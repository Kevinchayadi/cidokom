<?php

namespace App\Services;

use App\Models\Afkir;
use App\Models\Breeding;
use App\Models\Pen;
use App\Models\Commercial;
use App\Models\Table_move;
use Carbon\Carbon;

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
    public function moveToBreeding(Breeding $breeding, int $last_female, int $last_male, int $current_pen, int $total_female, int $total_male, $total_cost, $cost_induk)
    {
        $breeding->breedingDetails[0]->update([
            'last_male' => $last_male,
            'last_female' => $last_female,
            'receive_from' => $current_pen,
            'total_female_receive' => $total_female,
            'total_male_receive' => $total_male,
        ]);
        $breeding->update([
            'cost_Total_induk' => $total_cost,
            'cost_induk' => $cost_induk,
        ]);
    }
    public function moveToCommercial(Commercial $commercial, int $last_population, int $current_pen, int $total_female, int $total_male, $total_cost, $current_cost)
    {
        // dd('test3');
        $commercial->commercialDetails[0]->update([
            'last_population' => $last_population,
            'recieve_from' => $current_pen,
            'total_recieve' => $total_male,
            // 'total_male_receive' => $total_male,
        ]);
        $commercial->update([
            'last_population' => $last_population,
            'total_cost' => $total_cost,
            'unit_cost' => $current_cost,
        ]);
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
        // dd('test22');
    }
    public function moveTable(int $move_pen, int $current_pen, float $current_cost, int $last_male, int $last_female, int $male, int $female)
    {
        if ($move_pen != 0) {
            // $last_male =  $last_male - $input['total_male_move'] - $input['total_female_move'];
            $data = Pen::with('kandang')->where('id', $move_pen)->firstorfail();
            $cost = $current_cost / ($last_male + $last_female);

            $new_cost = $cost * ($male + $female);
            // dd($new_cost);

            if ($data->kandang->jenis_kandang == 'afkir') {
                // dd('test');
                $afkir = Afkir::where('id_pen', $move_pen)->latest('created_at')->first();
                // dd($afkir);
                if ($afkir) {
                    // dd('test');
                    $this->createAfkir($move_pen, $afkir->male + $male, $afkir->female + $female, $afkir->male_cost + $cost * $male, $afkir->female_cost + $cost * $female, $female, $male);
                } else {
                    // dd('test2');
                    $this->createAfkir($move_pen, $male, $female, $cost * $male, $cost * $female, $male, $female);
                }
                $this->createMoveTable($current_pen, $move_pen, $male, $female, $cost * $male, $cost * $female, 'inactive');
            }
            if ($data->kandang->jenis_kandang == 'breeding') {
                $breeding = Breeding::with([
                    'breedingDetails' => function ($query) {
                        $query->orderBy('created_at', 'desc'); // Urutkan berdasarkan 'created_at' terbaru
                        // Ambil hanya satu record terbaru
                    },
                ])
                    ->where('id_pen', $move_pen) // Filter berdasarkan 'id_pen'
                    ->whereHas('breedingDetails', function ($query) {
                        $query->whereDate('created_at', Carbon::today()); // Filter yang tanggalnya hari ini
                    })
                    ->first(); // Ambil record pertama yang ditemukan
                // dd( $breeding->breedingDetails);
                // dd($breeding->breedingDetails);
                if (isset($breeding)) {
                    $last_male_breeding = $breeding->breedingDetails[0]->last_male + $male;
                    $last_female_breeding = $breeding->breedingDetails[0]->last_female + $female;
                    $total_female = $breeding->breedingDetails[0]->total_female_receive + $female;
                    $total_male = $breeding->breedingDetails[0]->total_male_receive + $male;
                    $total_cost_breeding = (float) ($breeding->cost_Total_induk + $new_cost);
                    $costInduk = (float) ($total_cost_breeding / ($last_male_breeding + $last_female_breeding));

                    $this->moveToBreeding($breeding, $last_female_breeding, $last_male_breeding, $current_pen, $total_female, $total_male, $total_cost_breeding, $costInduk);

                    $this->createMoveTable($current_pen, $move_pen, $male, $female, $cost * $male, $cost * $female, 'inactive');
                } else {
                    $this->createMoveTable($current_pen, $move_pen, $male, $female, $cost * $male, $cost * $female, 'active');
                }
            }
            // dd($data->kandang->jenis_kandang == 'commerce');
            if ($data->kandang->jenis_kandang == 'commerce') {
                $commercial = commercial::with([
                    'commercialDetails' => function ($query) {
                        $query
                            ->whereDate('created_at', Carbon::today()) // Filter yang tanggalnya hari ini
                            ->orderBy('created_at', 'desc')
                            ->first();
                    },
                ])
                    ->where('id_pen', $move_pen)
                    ->whereHas('commercialDetails', function ($query) {
                        $query->whereDate('created_at', Carbon::today()); // Memastikan bahwa ada commercialDetails[0] hari ini
                    })
                    ->first(); // Ambil record pertama yang ditemukan

                // dd($commercial);
                if (isset($commercial)) {
                    // dd($commercial->commercialDetails[0]);
                    $last_population_commercial = $commercial->commercialDetails[0]->last_population + $male + $female;
                    $total_female = $commercial->commercialDetails[0]->total_female_receive + $female;
                    $total_male = $commercial->commercialDetails[0]->total_male_receive + $male;
                    $total_cost_commercial = (float) ($commercial->cost_total + $new_cost);
                    $unit_cost_commercial = (float) ($commercial->unit_cost + $new_cost);

                    $this->moveToCommercial($commercial, $last_population_commercial, $current_pen, $total_female, $total_male, $total_cost_commercial, $unit_cost_commercial);

                    $this->createMoveTable($current_pen, $move_pen, $male, $female, $cost * $male, $cost * $female, 'inactive');
                } else {
                    // dd( 'tempt');

                    $this->createMoveTable($current_pen, $move_pen, $male, $female, $cost * $male, $cost * $female, 'active');
                }
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

    // public function Breeding( int $move_pen, int $current_pen, float $current_cost, int $last_male, int $last_female, int $male, int $female){
    //     if ($move_pen != 0) {
    //         // $last_male =  $last_male - $input['total_male_move'] - $input['total_female_move'];
    //         $data = Pen::with('kandang')
    //         ->where('id', $move_pen)
    //         ->firstorfail();
    //         $cost = $current_cost / ($last_male+$last_female);
    //         $new_cost = $cost * ($male + $female);

    //         if ($data->kandang->jenis_kandang == 'afkir') {
    //             // dd('test');
    //             $afkir = Afkir::where('id_pen', $move_pen)->first();
    //             if ($afkir) {
    //                 // dd('test');
    //                $this->createAfkir($move_pen, $afkir->male + $male, $afkir->female + $female ,$afkir->male_cost + $cost * $male, $afkir->female_cost + $cost * $female, $male, $female);

    //             } else {
    //                 // dd('test2');
    //                 $this->createAfkir($move_pen, $male, $female , $cost * $male,  $cost * $female, $male, $female);
    //             }
    //             $this->createMoveTable($current_pen, $move_pen, $male, $female, $cost * $male,  $cost * $female, 'inactive');
    //         }
    //         if ($data->kandang->jenis_kandang == 'breeding') {

    //             $breeding = Breeding::with([
    //                 'breedingDetails' => function ($query) {
    //                     $query->whereDate('created_at', Carbon::today());
    //                 },
    //             ])
    //                 ->where('id_pen', $move_pen)
    //                 ->first();

    //             if ($breeding) {
    //                 $last_male_breeding = $breeding->breeding_detail->last_male + $male;
    //                 $last_female_breeding = $breeding->breeding_detail->last_female + $female;
    //                 $total_female = $breeding->total_female_receive + $female;
    //                 $total_male = $breeding->total_male_receive + $male;
    //                 $total_cost_breeding = (float)($breeding->cost_induk + $new_cost);

    //                 $this->moveToBreeding($breeding,$last_female_breeding, $last_male_breeding,$current_pen, $total_female, $total_male, $total_cost_breeding);

    //                 $this->createMoveTable($current_pen, $move_pen, $male, $female, $cost * $male,  $cost * $female, 'inactive');
    //             } else {
    //                 $this->createMoveTable($current_pen, $move_pen, $male, $female, $cost * $male,  $cost * $female, 'active');
    //             }
    //         }
    //         if ($data->kandang->jenis_kandang == 'commercial') {
    //             $commercial = commercial::with([
    //                 'commercialDetail' => function ($query) {
    //                     $query->whereDate('created_at', Carbon::today());
    //                 },
    //             ])
    //                 ->where('id_pen', $move_pen)
    //                 ->first();

    //             if ($commercial) {
    //                 $last_population_commercial = $commercial->commercialDetails[0]->last_male + $male + $female;
    //                 $total_female = $commercial->total_female_receive + $female;
    //                 $total_male = $commercial->total_male_receive + $male;
    //                 $total_cost_commercial = (float)($commercial->cost_total + $new_cost);
    //                 $unit_cost_commercial = (float)($commercial->unit_cost + $new_cost);

    //                 $this->moveToCommercial($commercial,$last_population_commercial,$current_pen, $total_female, $total_male, $total_cost_commercial, $unit_cost_commercial);

    //                 $this->createMoveTable($current_pen, $move_pen, $male, $female, $cost * $male,  $cost * $female, 'inactive');
    //             } else {
    //                 $this->createMoveTable($current_pen, $move_pen, $male, $female, $cost * $male,  $cost * $female, 'active');
    //             }
    //         }
    //         if($last_female == 0){
    //             $last_male = $last_male - $male - $female;
    //         }else{
    //             $last_male -= $male;
    //             $last_female -= $female;
    //         }
    //         $input['total_move'] = $male + $female;
    //         $data = [
    //             'new_cost' => $new_cost,
    //             'last_male' => $last_male,
    //             'last_female'=> $last_female

    //         ];
    //         return $data;
    //     }
    // }
    public function receiveData()
    {
    }
}
