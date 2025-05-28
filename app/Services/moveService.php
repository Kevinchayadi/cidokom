<?php

namespace App\Services;

use App\Models\Afkir;
use App\Models\Breeding;
use App\Models\Breeding_detail;
use App\Models\Pen;
use App\Models\Commercial;
use App\Models\Commercial_detail;
use App\Models\Table_move;
use Carbon\Carbon;
use PhpParser\Node\Stmt\Break_;

class moveService
{
    public function createAfkir(int $move_pen, int $male, int $female, float $male_cost, float $female_cost, int $female_come, int $male_come)
    {
        Afkir::create([
            'id_pen' => $move_pen,
            'male' => $male,
            'female' => $female,
            'male_cost' => $male_cost,
            'female_cost' => $female_cost,
            'female_come' => $female_come,
            'male_come' => $male_come,
        ]);
    }

    public function moveToBreeding(Breeding $breeding, Breeding_detail $detail, int $current_pen, int $total_female, int $total_male, $new_cost, Carbon $date)
    {
        $detail->update([
            'receive_from' => $current_pen,
            'total_female_receive' => $total_female,
            'total_male_receive' => $total_male,
        ]);
        $breeding
            ->breedingDetails()
            ->where('created_at', '>=', $date)
            ->get()
            ->each(function ($detail) use ($total_male, $total_female) {
                $detail->increment('last_male', $total_male);
                $detail->increment('last_female', $total_female);
            });
        $latestDetail = $breeding->breedingDetails()->orderBy('created_at', 'desc')->first();
        $total_cost = $breeding->cost_Total_induk + $new_cost;
        $cost_induk = $total_cost / ($latestDetail->last_male + $latestDetail->last_female);
        $breeding->update([
            'cost_Total_induk' => $total_cost,
            'cost_induk' => $cost_induk,
        ]);
    }

    public function moveToCommercial(Commercial $commercial, Commercial_detail $detail, int $current_pen, int $total_receive, $total_cost, $date)
    {
        $detail->update([
            'recieve_from' => $current_pen,
            'total_recieve' => $total_receive,
        ]);
        $commercial
            ->commercialDetails()
            ->where('created_at', '>=', $date)
            ->get()
            ->each(function ($detail) use ($total_receive) {
                $detail->increment('last_population', $total_receive);
            });
        $commercial->increment('last_population', $total_receive);
        $commercial->increment('total_cost', $total_cost);
        $commercial->increment('unit_cost', $total_cost);
    }

    public function createMoveTable(int $current_pen, int $move_pen, int $male, int $female, float $cost_male, float $cost_female, string $status)
    {
        Table_move::create([
            'current_pen' => $current_pen,
            'destination_pen' => $move_pen,
            'totalMale' => $male,
            'totalFemale' => $female,
            'maleCost' => $cost_male,
            'femaleCost' => $cost_female,
            'status' => $status,
        ]);
    }

    public function BreedingDestination(int $move_pen, int $current_pen, float $cost, int $new_cost, int $male, int $female, Carbon $date, string $user)
    {
        $breeding = Breeding::with(['breedingDetails'])
            ->where('id_pen', $move_pen)
            ->where('status', 'active')
            ->first();
        $curr = Breeding::where('status', 'active')->where('id_pen', $current_pen)->first();

        if (isset($breeding)) {
            $detailID = $breeding->breedingDetails()->whereDate('created_at', $date)->first();
            if (isset($detailID)) {
                $detail = Breeding_detail::findOrFail($detailID->id); // pastikan $detail adalah model
            }
            if (isset($detail)) {
                $total_female = $detail->total_female_receive + $female;
                $total_male = $detail->total_male_receive + $male;

                $this->moveToBreeding($breeding, $detail, $current_pen, $total_female, $total_male, $new_cost, $date);

                $this->createMoveTable($current_pen, $move_pen, $male, $female, $cost * $male, $cost * $female, 'inactive');
            } else {
                $this->createMoveTable($current_pen, $move_pen, $male, $female, $cost * $male, $cost * $female, 'active');
            }
        } else {
            Breeding::create([
                'id_pen' => $move_pen,
                'code_ayam_jantan' => $curr->code_ayam_jantan,
                'code_ayam_betina' => $curr->code_ayam_jantan,
                'jumlah_jantan' => $male,
                'jumlah_betina' => $female,
                'age' => $curr->age,
                'cost_Total_induk' => $new_cost,
                'created_at' => $curr->created_at,
                'inputBy' => $user,
            ]);
            Pen::where('id', $move_pen)->update([
                'status' => 'inactive',
            ]);
            $this->createMoveTable($current_pen, $move_pen, $male, $female, $cost * $male, $cost * $female, 'inactive');
        }
    }

    public function CommercialgDestination(int $move_pen, int $current_pen, float $cost, int $new_cost, int $male, int $female, Carbon $date, string $user)
    {
        $commercial = commercial::with(['commercialDetails'])
            ->where('id_pen', $move_pen)
            ->where('status', 'active')
            ->first();
        $curr = commercial::where('status', 'active')->where('id_pen', $current_pen)->first();
        $totalPopulation = $male + $female;

        if (isset($commercial)) {
            $detailId = $commercial->commercialDetails()->whereDate('created_at', $date)->first();
            if (isset($detailId)) {
                $detail = Commercial_detail::findOrFail($detailId->id); // pastikan $detail adalah model
            }

            if (isset($detail)) {
                $total_receive = $detail->total_recieve + $female + $male;
                $this->moveToCommercial($commercial, $detail, $current_pen, $total_receive, $new_cost, $date);

                $this->createMoveTable($current_pen, $move_pen, $male, $female, $cost * $male, $cost * $female, 'inactive');
            } else {
                $this->createMoveTable($current_pen, $move_pen, $male, $female, $cost * $male, $cost * $female, 'active');
            }
        } else {
            $dateinput = carbon::parse($date)->format('Y-m-d');
            $created = $date;
            $age = 0;

            if ($curr) {
                $dateinput = $curr->entryDate;
                $created = $curr->created_at;
                $age = $curr->age;
            }

            Commercial::create([
                'id_pen' => $move_pen,
                'entryDate' => $dateinput,
                'entry_population' => $totalPopulation,
                'last_population' => $totalPopulation,
                'total_cost' => $new_cost,
                'unit_Cost' => $new_cost,
                'age' => $age,
                'created-at' => $created,
                'inputBy' => $user,
            ]);
            Pen::where('id', $move_pen)->update([
                'status' => 'inactive',
            ]);
            $this->createMoveTable($current_pen, $move_pen, $male, $female, $cost * $male, $cost * $female, 'inactive');
        }

        // $commercial = commercial::with(['commercialDetails'])
        //     ->where('id_pen', $move_pen)
        //     ->first();

        // if (isset($commercial)) {
        //     $last_population_commercial = $commercial->commercialDetails[0]->last_population + $male + $female;
        //     $total_female = $commercial->commercialDetails[0]->total_female_receive + $female;
        //     $total_male = $commercial->commercialDetails[0]->total_male_receive + $male;
        //     $total_cost_commercial = (float) ($commercial->cost_total + $new_cost);
        //     $unit_cost_commercial = (float) ($commercial->unit_cost + $new_cost);

        //     $this->moveToCommercial($commercial, $last_population_commercial, $current_pen, $total_female, $total_male, $total_cost_commercial, $unit_cost_commercial);

        //     $this->createMoveTable($current_pen, $move_pen, $male, $female, $cost * $male, $cost * $female, 'inactive');
        // } else {
        //     $this->createMoveTable($current_pen, $move_pen, $male, $female, $cost * $male, $cost * $female, 'active');
        // }
    }

    public function moveTable(int $move_pen, int $current_pen, float $current_cost, int $last_male, int $last_female, int $male, int $female, ?Carbon $date = null, ?string $user = 'user')
    {
        $date = $date ?? Carbon::now();
        if ($move_pen != 0) {
            $data = Pen::with('kandang')->where('id', $move_pen)->firstorfail();
            if ($last_male + $last_female != 0) {
                $cost = $current_cost / ($last_male + $last_female);
            } else {
                $cost = 0;
            }

            $new_cost = $cost * ($male + $female);

            if ($data->kandang->jenis_kandang == 'afkir') {
                $afkir = Afkir::where('id_pen', $move_pen)->latest('created_at')->first();

                if ($afkir) {
                    $this->createAfkir($move_pen, $afkir->male + $male, $afkir->female + $female, $afkir->male_cost + $cost * $male, $afkir->female_cost + $cost * $female, $female, $male);
                } else {
                    $this->createAfkir($move_pen, $male, $female, $cost * $male, $cost * $female, $male, $female);
                }
                $this->createMoveTable($current_pen, $move_pen, $male, $female, $cost * $male, $cost * $female, 'inactive');
            }
            if ($data->kandang->jenis_kandang == 'breeding') {
                $this->BreedingDestination($move_pen, $current_pen, $cost, $new_cost, $male, $female, $date, $user);
            }

            if ($data->kandang->jenis_kandang == 'commerce') {
                $this->CommercialgDestination($move_pen, $current_pen, $cost, $new_cost, $male, $female, $date, $user);
            }
            if ($last_female == 0) {
                $last_male = $last_male - $male - $female;
            } else {
                $last_male -= $male;
                $last_female -= $female;
            }
            $input['total_move'] = $male + $female;
            $data = [
                'new_cost' => $new_cost,
                'last_male' => $last_male,
                'last_female' => $last_female,
            ];
            return $data;
        }
    }

    public function receiveData() {}
}
