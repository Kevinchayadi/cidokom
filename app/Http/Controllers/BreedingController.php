<?php

namespace App\Http\Controllers;

use App\Models\Afkir;
use App\Models\Ayam;
use App\Models\Breeding;
use App\Models\Breeding_detail;
use App\Models\Daily_feed;
use App\Models\Pakan;
use App\Models\Pen;
use App\Models\Sale;
use App\Models\Table_move;
use App\Models\vaksin;
use App\Models\vaksinType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\CountService;
use App\Services\moveService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BreedingController extends Controller
{
    protected $countService;
    protected $moveService;
    public function __construct(CountService $countService, moveService $moveService)
    {
        $this->countService = $countService;
        $this->moveService = $moveService;
    }
    public function userIndex()
    {
        $breeding = Breeding::with('BreedingDetails', 'vaksin')->where('status', 'active')->latest()->get();
        $vaksin = vaksin::where('type', 'BRD')->get();

        foreach ($breeding as $item) {
            $item->age = floor(
                $item->age +
                    Carbon::parse($item->created_at)
                        ->startOfDay()
                        ->diffInDays(Carbon::now()->startOfDay()),
            );
            $item->isInputed = false;
            $item->isTrue = false;
            $item->isReject = false;

            if ($item->age >= 525) {
                $item->isReject = true;
            }

            foreach ($item->BreedingDetails as $detail) {
                $createdDate = Carbon::parse($detail->created_at)
                ->toDateString();

                $today = Carbon::now('Asia/Jakarta')->toDateString();

                if ($createdDate === $today) {
                    $item->isInputed = true;
                    break;
                }
            }

            foreach ($vaksin as $data) {
                if ($item->age >= $data->hari) {
                    $item->isTrue = in_array($data->id, $item->vaksin->pluck('id')->toArray());

                    if ($item->isTrue === false) {
                        break;
                    }
                }
            }
        }

        return Inertia::render('user/Breeding', compact('breeding'));
    }
    public function adminIndex()
    {
        $breeding = Breeding::with([
            'breedingDetails' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'pen',
        ])
            ->orderBy('status')
            ->get();
        foreach ($breeding as $item) {
            $item->age =
                ($item->age ?? 0) +
                Carbon::parse($item->created_at)
                    ->startOfDay()
                    ->diffInDays(Carbon::now()->startOfDay());
            $FCR = 0;
            foreach ($item->breedingDetails as $detail) {
                if ($detail->last_male + $detail->lastfemale != 0) {
                    $FCR += $detail->feed / ($detail->last_male + $detail->lastfemale);
                }
            }
            $item->fcr = $FCR;

            if ($item->entryDate == null) {
                $item->entryDate = Carbon::parse($item->created_at)->format('Y-m-d');
            }
        }

        return Inertia::render('admin/breeding', compact('breeding'));
    }

    public function createBreeding()
    {
        $pen = Pen::with('kandang')
            ->where('status', 'active')
            ->whereHas('kandang', function ($query) {
                $query->where('jenis_kandang', 'breeding');
            })
            ->get();
        $ayam = Ayam::get();
        return Inertia::render('user/FormCreateBreeding', ['pen' => $pen, 'ayam' => $ayam]);
    }

    public function storeBreeding(Request $request)
    {
        $input = $request->validate([
            'id_pen' => 'required',
            'code_ayam_jantan' => 'required|string',
            'code_ayam_betina' => 'required|string',
            'jumlah_jantan' => 'required|integer',
            'jumlah_betina' => 'required|integer',
            'age' => 'required|integer',
            'cost_Total_induk' => 'required',
            'inputBy' => 'required',
        ]);

        $input['cost_induk'] = $input['cost_Total_induk'] / ($input['jumlah_jantan'] + $input['jumlah_betina']);

        Breeding::create($input);

        Pen::where('id', $input['id_pen'])->update([
            'status' => 'inactive',
        ]);

        return redirect()->route('user.breeding')->with('success', 'berhasil membuat kandang Breeding baru');
    }

    public function inputBreeding($id)
    {
        $pakan = Pakan::get()->toArray();

        $breeding = Breeding::with([
            'BreedingDetails' => function ($query) {
                $query->latest('created_at');
            },
            'pen',
        ])->find($id);
        $pen = Pen::with('kandang')
            ->whereHas('kandang', function ($query) {
                $query->where('jenis_kandang', 'breeding')->orWhere(function ($subQuery) {
                    $subQuery->where('jenis_kandang', 'afkir')->where('code_pen', 'like', '%BRD');
                });
            })
            ->whereNot('id', $breeding->id_pen)
            ->get();
        $latest = $breeding->breedingDetails->sortByDesc('created_at')->values()->first();
        $chicken = [
            'male' => $latest->last_male ?? $breeding->jumlah_jantan,
            'female' => $latest->last_female ?? $breeding->jumlah_betina,
        ];

        $name = $breeding->pen->code_pen;

        return Inertia::render('user/FormDailyBreeding', ['id_breeding' => $id, 'pakan' => $pakan, 'pen' => $pen, 'name' => $name, 'chicken' => $chicken]);
    }

    public function inputedBreeding(Request $request)
    {
        $input = $request->validate([
            'id_breeding' => 'required',
            'female_die' => 'required|integer|min:0',
            'female_reject' => 'required|integer|min:0',
            'male_die' => 'required|integer|min:0',
            'male_reject' => 'required|integer|min:0',
            'egg_morning' => 'required|integer|min:0',
            'egg_afternoon' => 'required|integer|min:0',
            'broken' => 'required|integer|min:0',
            'abnormal' => 'required|integer|min:0',
            'sale' => 'required|integer',
            'total_egg' => 'required',
            'move_to' => 'integer',
            'total_female_move' => 'integer',
            'total_male_move' => 'integer',
            'feed' => 'required|numeric|min:0',
            'feed_name' => 'required|string',
            'inputBy' => 'required',
            'date' => 'date|nullable',
        ]);

        $Breeding = Breeding::find($input['id_breeding']);
        $pakan = Pakan::where('nama_pakan', $input['feed_name'])->first();
        $previousDetail = Breeding_detail::where('id_breeding', $input['id_breeding'])->latest('created_at')->first();

        if ($input['move_to'] == 0) {
            $input['total_female_move'] = 0;
            $input['total_male_move'] = 0;
        }

        if (!$Breeding) {
            return response()->json(['error' => 'Data Breeding tidak ditemukan'], 404);
        }
        $input['begining_population'] = $Breeding->begining_population;

        if (!$previousDetail) {
            $input['last_male'] = $Breeding->jumlah_jantan - $input['male_die'] - $input['male_reject'];
            $input['last_female'] = $Breeding->jumlah_betina - $input['female_die'] - $input['female_reject'];
        } else {
            if (Carbon::parse($previousDetail->created_at)->greaterThanOrEqualTo(Carbon::parse($input['date']))) {
                return back()->withErrors('data terakhir update adalah ' . $previousDetail->created_at->format('d-m-y'));
            }

            $calculate_male = $previousDetail->last_male - $input['male_die'] - $input['male_reject'];
            $calculate_female = $previousDetail->last_female - $input['female_die'] - $input['female_reject'];
            $input['last_male'] = $calculate_male;
            $input['last_female'] = $calculate_female;
        }
        $datemove = null;
        if (isset($input['date'])) {
            $input['created_at'] = Carbon::parse($input['date'])->addHours(7);
            $datemove = Carbon::parse($input['date']);
        }
        if ($input['last_male'] < 0) {
            return back()->withErrors('Female chicken cant be minus quantity!');
        }
        if ($input['last_female'] < 0) {
            return back()->withErrors('Female chicken cant be minus quantity!');
        }
        $currentfeed = $pakan->qty - $input['feed'];
        if ($currentfeed < 0) {
            return back()->withErrors('pakan is not enough!! please check pakan stock or call jakarta admin to check the stock!');
        }
        try {
            DB::beginTransaction();
            $new_cost = 0;
            if ($request->move_to != 0 && $request->total_female_move + $request->total_male_move != 0) {
                $unitCostAsFloat = (float) $Breeding->cost_Total_induk;
                $datas = $this->moveService->moveTable($input['move_to'], $Breeding->id_pen, $unitCostAsFloat, $input['last_male'], $input['last_female'], $input['total_male_move'], $input['total_female_move'], $datemove, $input['inputBy']);

                $new_cost = $datas['new_cost'];
                $input['last_male'] = $datas['last_male'];
                $input['last_female'] = $datas['last_female'];
            }

            if ($input['male_reject'] + $input['female_reject'] != 0) {
                $qtysale = $input['male_reject'] + $input['female_reject'];
                Sale::create([
                    'id_pen' => $Breeding->id_pen,
                    'qty' => $qtysale,
                ]);
            }

            $totalMale = Table_move::where('destination_pen', $Breeding->id_pen)->where('status', 'active')->sum('totalMale');
            $totalFemale = Table_move::where('destination_pen', $Breeding->id_pen)->where('status', 'active')->sum('totalFemale');
            $totalPopulation = ($totalMale ?? 0) + ($totalFemale ?? 0);
            $costMale = Table_move::where('destination_pen', $Breeding->id_pen)->where('status', 'active')->sum('maleCost');
            $costFemale = Table_move::where('destination_pen', $Breeding->id_pen)->where('status', 'active')->sum('femaleCost');

            $total_cost = $Breeding->cost_Total_induk - $new_cost + $costMale + $costFemale - $Breeding->cost_induk * ($input['female_reject'] + $input['male_reject']);
            $cost_induk = 0;
            if ($input['last_male'] + $input['last_female'] > 0) {
                $cost_induk = $total_cost / ($input['last_male'] + $input['last_female']);
            }

            $Breeding->update([
                'cost_Total_induk' => $total_cost,
                'cost_induk' => $cost_induk,
            ]);

            if ($totalPopulation != 0) {
                $lastTable = Table_move::where('destination_pen', $Breeding->id_pen)->where('status', 'active')->first();
                $input['receive_from'] = $lastTable->current_pen;
                Table_move::where('destination_pen', $Breeding->id_pen)
                    ->where('status', 'active')
                    ->update(['status' => 'inactive']);
                $input['last_female'] += $totalFemale;
                $input['last_male'] += $totalMale;
                $input['total_female_receive'] = $totalFemale;
                $input['total_male_receive'] = $totalMale;
            }

            $current_cost = $this->countService->costegg($pakan, $input['feed'], $input['total_egg'] + $input['sale']);
            if ($input['total_egg'] == 0 || $input['total_egg'] + $input['sale'] == 0) {
                $input['cost_unit'] = $pakan->harga * $input['feed'];
                $input['cost_total'] = $pakan->harga * $input['feed'];
            } else {
                $input['cost_unit'] = $current_cost * $input['total_egg'];
                $input['cost_total'] = $current_cost * ($input['total_egg'] + $input['sale']);
            }
            $pakan->update([
                'qty' => $currentfeed,
            ]);
            Daily_feed::create([
                'id_pen' => $Breeding->id_pen,
                'id_pakan' => $pakan->id,
                'qty' => $input['feed'],
                'stock_feed' => $currentfeed,
            ]);
            Breeding_detail::create($input);
            if ($input['last_male'] == 0 && $input['last_female'] == 0) {
                $Breeding->update([
                    'status' => 'inactive',
                ]);
                Pen::find($Breeding->id_pen)->update([
                    'status' => 'active',
                ]);
            }
            DB::commit();
            return redirect()->route('user.breeding')->with('success', 'berhasil membuat kandang Breeding baru');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors('failed input!');
        }
    }

    public function moveForm($id)
    {
        $pen = $pen = Pen::with('kandang')
            ->where('status', 'inactive')
            ->whereHas('kandang', function ($query) {
                $query->where('jenis_kandang', 'breeding')->orWhere(function ($subQuery) {
                    $subQuery->where('jenis_kandang', 'afkir')->where('code_pen', 'like', '%BRD');
                });
            })
            ->get();
        $breeding = Breeding::with([
            'BreedingDetails' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'pen',
        ])->find($id);
        $chicken = [
            'male' => $breeding->breedingDetails[0]->last_male,
            'female' => $breeding->breedingDetails[0]->last_female,
        ];
        $name = $breeding->pen->code_pen;

        return Inertia::render('user/FormMoveBreeding', ['id' => $id, 'pen' => $pen, 'name' => $name, 'chicken' => $chicken]);
    }

    public function moveTable(Request $request, $id)
    {
        $input = $request->validate([
            'move_to' => 'integer',
            'total_female_move' => 'integer',
            'total_male_move' => 'integer',
        ]);

        if ($input['move_to'] == 0) {
            return back()->withErrors('Select move pen');
        }

        $Breeding = Breeding::with([
            'breedingDetails' => function ($query) {
                $query->whereDate('created_at', Carbon::today());
            },
        ])->findOrFail($id);

        $breedingDetail = $Breeding->breedingDetails->first();

        if (!$breedingDetail) {
            return back()->withErrors('Breeding details not found!');
        }

        try {
            DB::beginTransaction();
            $unitCostAsFloat = (float) $Breeding->cost_Total_induk;
            $datas = $this->moveService->moveTable($input['move_to'], $Breeding->id_pen, $unitCostAsFloat, $breedingDetail->last_male, $breedingDetail->last_female, $input['total_male_move'], $input['total_female_move']);

            $new_cost = $datas['new_cost'];
            $input['last_male'] = $datas['last_male'];
            $input['last_female'] = $datas['last_female'];

            if ($input['last_male'] < 0) {
                return back()->withErrors('Male chicken cant be negative quantity!');
            }
            if ($input['last_female'] < 0) {
                return back()->withErrors('Female chicken cant be negative quantity!');
            }

            $total_cost = $Breeding->cost_Total_induk - $new_cost;
            $cost_induk = $total_cost / ($input['last_male'] + $input['last_female']);

            $Breeding->update([
                'cost_Total_induk' => $total_cost,
                'cost_induk' => $cost_induk,
            ]);

            $breedingDetail->update([
                'last_male' => $input['last_male'],
                'last_female' => $input['last_female'],
                'move_to' => $input['move_to'],
                'total_male_move' => $input['total_male_move'],
                'total_female_move' => $input['total_female_move'],
            ]);

            DB::commit();

            return redirect()->route('user.breeding')->with('success', 'Successfully moved to new pen!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors('Failed to move to new pen, try again.');
        }
    }
    public function AfkirALL($id)
    {
        $Breeding = Breeding::with([
            'breedingDetails' => function ($query) {
                $query->latest('created_at')->first();
            },
        ])->findOrFail($id);
        $pen = Pen::where('code_pen', 'AFKIR-BRD')->first();

        $breedingDetail = $Breeding->breedingDetails->first();

        $unitCostAsFloat = (float) $Breeding->cost_Total_induk;
        $datas = $this->moveService->moveTable($pen->id, $Breeding->id_pen, $unitCostAsFloat, $breedingDetail->last_male, $breedingDetail->last_female, $breedingDetail->last_male, $breedingDetail->last_female);
        $male = $breedingDetail->last_male;
        $female = $breedingDetail->last_female;

        $new_cost = $datas['new_cost'];
        $input['last_male'] = $datas['last_male'];
        $input['last_female'] = $datas['last_female'];

        DB::beginTransaction();

        try {
            $Breeding->update([
                'status' => 'inactive',
            ]);
            Pen::find($Breeding->id_pen)->update([
                'status' => 'active',
            ]);

            if ($breedingDetail->created_at->isToday()) {
                $breedingDetail->update([
                    'last_male' => $input['last_male'],
                    'last_female' => $input['last_female'],
                    'total_male_move' => $male,
                    'total_female_move' => $female,
                ]);
            } else {
                Breeding_detail::create([
                    'id_breeding' => $id,
                    'last_male' => 0,
                    'last_female' => 0,
                    'female_die' => 0,
                    'female_reject' => 0,
                    'male_die' => 0,
                    'male_reject' => 0,
                    'egg_morning' => 0,
                    'egg_afternoon' => 0,
                    'broken' => 0,
                    'abnormal' => 0,
                    'sale' => 0,
                    'total_egg' => 0,
                    'move_to' => $pen->id,
                    'total_male_move' => $male,
                    'total_female_move' => $female,
                    'receive_from' => 0,
                    'total_male_receive' => 0,
                    'total_female_receive' => 0,
                    'cost_unit' => 0,
                    'cost_total' => 0,
                    'feed' => 0,
                    'feed_name' => '0',
                    'status' => 0,
                    'inputBy' => 'system',
                ]);
            }

            DB::commit();

            return redirect()->route('user.breeding')->with('success', 'Successfully moved to new pen!');
        } catch (\Exception $e) {
            DB::rollback();
            dd('es');
            return back()->withErrors('Failed to move to new pen, try again.');
        }
    }

    public function addVaccine($id)
    {
        $breeding = Breeding::with('BreedingDetails', 'vaksin')->where('id_breeding', $id)->first();
        $vaksin = vaksin::where('type', 'BRD')->get();
        $vaksinList = [];

        $breeding->age = floor(
            $breeding->age +
                Carbon::parse($breeding->created_at)
                    ->startOfDay()
                    ->diffInDays(Carbon::now()->startOfDay()),
        );

        foreach ($vaksin as $data) {
            if ($breeding->age >= $data->hari) {
                $breeding->isTrue = in_array($data->id, $breeding->vaksin->pluck('id')->toArray());

                if ($breeding->isTrue === false) {
                    $vaksinList[] = $data;
                }
            }
        }

        return Inertia::render('user/FormAddBreedingVaksin', ['id' => $id, 'vaksin' => $vaksinList, 'pen' => 'breeding']);
    }
    public function storevaccine($id, Request $request)
    {
        $input = $request->validate([
            'id_vaksin' => 'required|integer',
            'qty' => 'required|numeric',
        ]);
        $breeding = Breeding::with('BreedingDetails', 'vaksin')->where('id_breeding', $id)->first();
        $vaksin = vaksin::find($input['id_vaksin']);
        $vaksintype = vaksinType::where('nama_vaksin', $vaksin->nama)->first();

        if (!$vaksintype) {
            return back()->withErrors('Vaksin not found!, please call Jakarta Admin to add the vaksin!!');
        }
        $qty = $vaksintype->qty - $input['qty'];

        if ($qty < 0) {
            return back()->withErrors('Vaksin QTY is not enough, please tell Jakarta Admin!!');
        }
        try {
            $vaksintype->update([
                'qty' => $qty,
            ]);
            $breeding->vaksin()->attach($request->id_vaksin);
        } catch (\Throwable $th) {
            return back()->withErrors('failed input!');
        }

        return redirect()->route('user.breeding')->with('success', 'berhasil membuat kandang Breeding baru');
    }

    public function Download($invoiceId)
    {
        $invoice = Breeding::with('items')->findOrFail($invoiceId);

        $pdf = Pdf::loadView('invoice', ['invoice' => $invoice])->setPaper('A4', 'landscape');

        return $pdf->stream('invoice-' . $invoice->number . '.pdf');
    }

    public function adjustment(Request $request){
        $input = $request->validate([
            'id' => 'required',
            'female_die' => 'required|integer',
            'female_reject' => 'required|integer',
            'male_die' => 'required|integer',
            'male_reject' => 'required|integer',
            'egg_morning' => 'required|integer|min:0',
            'egg_afternoon' => 'required|integer|min:0',
            'broken' => 'required|integer|min:0',
            'abnormal' => 'required|integer|min:0',
            'sale' => 'required|integer',
            'total_egg' => 'required',
            'feed' => 'required|numeric|min:0',
            'feed_name' => 'required|string',
        ]);
        DB::transaction(function () use ($input) {

            $prev = Breeding_detail::lockForUpdate()->find($input['id']);
            $feed = Pakan::where('nama_pakan', $input['feed_name'])->first();
            
    
            $lastMale = $prev->last_male + $prev->male_die + $prev->male_reject;
            $lastFemale = $prev->last_female + $prev->female_die + $prev->female_reject;
            $current_cost = $this->countService->costegg($feed, $input['feed'], $input['total_egg'] + $input['sale']);
            $input['last_male'] = $lastMale - $input['male_die'] - $input['male_reject'];
            $input['last_female'] = $lastFemale - $input['female_die'] - $input['female_reject'];
            if ($input['last_male'] < 0) {
                return back()->withErrors('Female chicken cant be minus quantity!');
            }
            if ($input['last_female'] < 0) {
                return back()->withErrors('Female chicken cant be minus quantity!');
            }
    
            $prevFeed = Pakan::where('nama_pakan', $prev->feed_name)->first();
            $prevFeed->increment('qty', $prev->feed);
            $Breeding = Breeding::find($prev->id_breeding);
            Daily_feed::create([
                'id_pen' => $Breeding->id_pen,
                'id_pakan' => $prevFeed->id,
                'qty' => $input['feed'],
                'stock_feed' => $prevFeed->qty,
            ]);
    
    
            if(($input['total_egg'] + $input['sale']) == 0){
                $input['cost_unit'] = $current_cost;
                $input['cost_total'] = $current_cost;
            }else{
                $input['cost_unit'] = $current_cost*$input['total_egg'];
                $input['cost_total'] = $current_cost*$input['total_egg'] + $current_cost*$input['sale_egg'];
            }
    
            $prev->update($input);
            $currfeed = Pakan::where('nama_pakan', $input['feed_name'])->first();
            if($currfeed->qty < $input['feed']){
                return back()->withErrors('Feed Stock cant be minus quantity!');
            }
            $currfeed->decrement('qty', $input['feed']);
            
            Daily_feed::create([
                'id_pen' => $Breeding->id_pen,
                'id_pakan' => $currfeed->id,
                'qty' => $input['feed'],
                'stock_feed' => $currfeed->qty,
            ]);
        });
    }


}
