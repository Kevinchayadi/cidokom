<?php

namespace App\Http\Controllers;

use App\Models\Afkir;
use App\Models\Ayam;
use App\Models\Breeding;
use App\Models\Breeding_detail;
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
        // dd($breeding->toArray());

        foreach ($breeding as $item) {
            // Hitung umur berdasarkan created_at dan update nilai age
            $item->age = floor(
                $item->age +
                    Carbon::parse($item->created_at)
                        ->startOfDay()
                        ->diffInDays(Carbon::now()->startOfDay()),
            );
            $item->isInputed = false;
            $item->isTrue = false;
            $item->isReject = false;

            if($item->age >= 525){
                $item->isReject = true;
            }
            

            foreach ($item->BreedingDetails as $detail) {
                $createdDate = Carbon::parse($detail->created_at)
                    // ->startOfDay()
                    ->toDateString();
                $today = Carbon::now('Asia/Jakarta')->toDateString();
                // dd($createdDate == $today);
                if ($createdDate === $today) {
                    // Jika ada detail pada hari ini, set isInputed menjadi true
                    $item->isInputed = true;
                    break; // keluar dari loop karena sudah ditemukan detail hari ini
                }
            }
            // dd($createdDate);
            // Periksa apakah item sudah memenuhi kriteria vaksin
            foreach ($vaksin as $data) {
                if ($item->age >= $data->hari) {
                    // Jika vaksin dengan 'hari' yang tepat ditemukan, cek apakah vaksin sudah ada
                    $item->isTrue = in_array($data->id, $item->vaksin->pluck('id')->toArray());
                    // dd($item->isTrue);
                    // Jika vaksin sudah ada, set isTrue ke false dan keluar dari loop
                    if ($item->isTrue === false) {
                        break;
                    }
                }
            }
        }
        // dd($breeding[2]->age);

        // dd($breeding[0]-> );

        return Inertia::render('user/Breeding', compact('breeding'));
    }
    public function adminIndex()
    {
        $breeding = Breeding::with([
            'BreedingDetails' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'pen',
        ])->get();
        foreach ($breeding as $item) {
            $item->age =
                $item->age +
                Carbon::parse($item->created_at)
                    ->startOfDay()
                    ->diffInDays(Carbon::now()->startOfDay());
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
        // $input['cost_total_induk'] = $input['cost'];
        $input['cost_induk'] = $input['cost_Total_induk'] / ($input['jumlah_jantan'] + $input['jumlah_betina']);

        // dd($input);
        Breeding::create($input);

        Pen::where('id', $input['id_pen'])->update([
            'status' => 'inactive',
        ]);

        return redirect()->route('user.breeding')->with('success', 'berhasil membuat kandang Breeding baru');
    }

    public function inputBreeding($id)
    {
        $pakan = Pakan::get()->toArray();
        $pen = Pen::with('kandang')
            ->where('status', 'inactive')
            ->whereHas('kandang', function ($query) {
                $query->whereNotIn('jenis_kandang', ['breeding', 'commerce']);
            })
            ->where('code_pen', 'like', '%BRD')
            ->get();
        
        return Inertia::render('user/FormDailyBreeding', ['id_breeding' => $id, 'pakan' => $pakan, 'pen' => $pen]);
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
        ]);
        if ($input['move_to'] == 0) {
            $input['total_female_move'] = 0;
            $input['total_male_move'] = 0;
        }
        $Breeding = Breeding::find($input['id_breeding']);
        $pakan = Pakan::where('nama_pakan', $input['feed_name'])->first();

        if (!$Breeding) {
            return response()->json(['error' => 'Data Breeding tidak ditemukan'], 404);
        }
        $input['begining_population'] = $Breeding->begining_population;

        $previousDetail = Breeding_detail::where('id_breeding', $input['id_breeding'])
            ->latest('created_at')
            ->first();
        if (!$previousDetail) {
            $input['last_male'] = $Breeding->jumlah_jantan - $input['male_die'] - $input['male_reject'];
            $input['last_female'] = $Breeding->jumlah_betina - $input['female_die'] - $input['female_reject'];
        } else {
            $calculate_male = $previousDetail->last_male - $input['male_die'] - $input['male_reject'];
            $calculate_female = $previousDetail->last_female - $input['female_die'] - $input['female_reject'];
            $input['last_male'] = $calculate_male;
            $input['last_female'] = $calculate_female;
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
            if ($request->move_to != 0) {
                $unitCostAsFloat = (float) $Breeding->cost_Total_induk;
                $datas = $this->moveService->moveTable($input['move_to'], $Breeding->id_pen, $unitCostAsFloat, $input['last_male'], $input['last_female'], $input['total_male_move'], $input['total_female_move']);

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

            //if table move has breeding pending
            //------------------------------------------------------------------------------------------------------------------------------------
            $totalMale = Table_move::where('destination_pen', $Breeding->id_pen)
                ->where('status', 'active')
                ->sum('totalMale');
            $totalFemale = Table_move::where('destination_pen', $Breeding->id_pen)
                ->where('status', 'active')
                ->sum('totalFemale');
            $totalPopulation = $totalMale ?? (0 + $totalFemale ?? 0);
            $costMale = Table_move::where('destination_pen', $Breeding->id_pen)
                ->where('status', 'active')
                ->sum('maleCost');
            $costFemale = Table_move::where('destination_pen', $Breeding->id_pen)
                ->where('status', 'active')
                ->sum('femaleCost');
            $input['last_male'] += $totalMale ?? 0;
            $input['last_female'] += $totalFemale ?? 0;

            $total_cost = $Breeding->cost_Total_induk - $new_cost + $costMale + $costFemale - $Breeding->cost_induk * ($input['female_reject'] + $input['male_reject']);
            $cost_induk = $total_cost / ($input['last_male'] + $input['last_female']);
            $Breeding->update([
                'cost_Total_induk' => $total_cost,
                'cost_induk' => $cost_induk,
            ]);
            // dd($request);
            // dd($totalPopulation);

            if ($totalPopulation != 0) {
                Table_move::where('destination_pen', $Breeding->id_pen)
                    ->where('status', 'active')
                    ->update('status', 'inactive');
                $input['last_population'] = $totalPopulation;
            }

            //feed
            //--------------------------------------------------------------------------------------------------------------------------------
            // $currentfeed = $pakan->qty - $input['feed'];
            $current_cost = $this->countService->costegg($pakan, $input['feed'], $input['total_egg'] + $input['sale']);
            $input['cost_unit'] = $current_cost * $input['total_egg'];
            $input['cost_total'] = $current_cost * ($input['total_egg'] + $input['sale']);
            $pakan->update([
                'qty' => $currentfeed,
            ]);
            Breeding_detail::create($input);
            if ($input['last_male'] == 0 && $input['last_female'] == 0) {
                $Breeding->update([
                    'status' => 'inactive',
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
        $pen = Pen::with('kandang')
            ->where('status', 'inactive')
            ->whereHas('kandang', function ($query) {
                $query->whereNotIn('jenis_kandang', ['breeding', 'commerce']);
            })
            ->where('code_pen', 'like', '%BRD')
            ->get();

        return Inertia::render('user/FormMoveBreeding', ['id' => $id, 'pen' => $pen]);
    }

    public function moveTable(Request $request, $id)
    {
        // dd('test');
        $input = $request->validate([
            'move_to' => 'integer',
            'total_female_move' => 'integer',
            'total_male_move' => 'integer',
        ]);
        // dd($input);
    
        if ($input['move_to'] == 0) {
            return back()->withErrors('Select move pen');
        }
    
        // Mendapatkan Breeding berdasarkan ID
        $Breeding = Breeding::with(['breedingDetails' => function ($query) {
            $query->whereDate('created_at', Carbon::today());
        }])->findOrFail($id); // pastikan ID valid
    
        // Mendapatkan data breedingDetails pertama
        $breedingDetail = $Breeding->breedingDetails->first(); // atau bisa menggunakan firstOrFail()
    
        if (!$breedingDetail) {
            return back()->withErrors('Breeding details not found!');
        }
    
        // Lakukan perhitungan dan pemindahan
        // Mulai transaksi DB
        
        try {
            DB::beginTransaction();
            $unitCostAsFloat = (float) $Breeding->cost_Total_induk;
            $datas = $this->moveService->moveTable(
                $input['move_to'],
                $Breeding->id_pen,
                $unitCostAsFloat,
                $breedingDetail->last_male,
                $breedingDetail->last_female,
                $input['total_male_move'],
                $input['total_female_move']
            );
        
            $new_cost = $datas['new_cost'];
            $input['last_male'] = $datas['last_male'];
            $input['last_female'] = $datas['last_female'];
        
            // Validasi agar jumlah ayam tidak menjadi negatif
            if ($input['last_male'] < 0) {
                return back()->withErrors('Male chicken cant be negative quantity!');
            }
            if ($input['last_female'] < 0) {
                return back()->withErrors('Female chicken cant be negative quantity!');
            }
        
            // Menghitung total cost dan cost induk
            $total_cost = $Breeding->cost_Total_induk - $new_cost;
            $cost_induk = $total_cost / ($input['last_male'] + $input['last_female']);
        
            // Update Breeding data
            $Breeding->update([
                'cost_Total_induk' => $total_cost,
                'cost_induk' => $cost_induk,
            ]);
    
            // Update BreedingDetails
            $breedingDetail->update([
                'last_male' => $input['last_male'],
                'last_female' => $input['last_female'],
                'move_to' => $input['move_to'],
                'total_male_move' => $input['total_male_move'],
                'total_female_move' => $input['total_female_move'],
            ]);
    
            // Commit transaksi jika berhasil
            DB::commit();
    
            return redirect()->route('user.breeding')->with('success', 'Successfully moved to new pen!');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollback();
            return back()->withErrors('Failed to move to new pen, try again.');
        }
    }
    public function AfkirALL($id)
    {
        // Mendapatkan Breeding berdasarkan ID
        $Breeding = Breeding::with(['breedingDetails' => function ($query) {
            $query->latest('created_at')->first();  
        }])->findOrFail($id); 
        $pen = Pen::where('code_pen', 'AFKIR-BRD')->first();
        // Mendapatkan data breedingDetails pertama
        $breedingDetail = $Breeding->breedingDetails->first(); // atau bisa menggunakan firstOrFail()
        
        // Lakukan perhitungan dan pemindahan
        $unitCostAsFloat = (float) $Breeding->cost_Total_induk;
        $datas = $this->moveService->moveTable(
            $pen->id,
            $Breeding->id_pen,
            $unitCostAsFloat,
            $breedingDetail->last_male,
            $breedingDetail->last_female,
            $breedingDetail->last_male,
            $breedingDetail->last_female,
        );
        $male = $breedingDetail->last_male;
        $female = $breedingDetail->last_female;
        // dd($id);
        $new_cost = $datas['new_cost'];
        $input['last_male'] = $datas['last_male'];
        $input['last_female'] = $datas['last_female'];
    
        // Mulai transaksi DB
        DB::beginTransaction();
    
        try {
            // Update Breeding data
            $Breeding->update([
                'status'=> 'inactive'
            ]);
            
            if ($breedingDetail->created_at->isToday()) {
                // Lakukan update jika tanggalnya hari ini
                // dd($input['last_female']);
                $breedingDetail->update([
                    'last_male' => $input['last_male'],
                    'last_female' => $input['last_female'],
                    'total_male_move' => $male,
                    'total_female_move' => $female,
                ]);
            } else {
                // Lakukan pembuatan breeding detail baru jika tanggalnya bukan hari ini
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
            
            // dd('test');
            
            // Commit transaksi jika berhasil
            DB::commit();
            
            return redirect()->route('user.breeding')->with('success', 'Successfully moved to new pen!');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollback();
            dd('es');
            return back()->withErrors('Failed to move to new pen, try again.');
        }
    }
    

    public function dailyStoreBulk(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $data = \Maatwebsite\Excel\Facades\Excel::toArray([], $request->file('file'));

        $rows = $data[0];

        $rows = array_slice($rows, 1);

        foreach ($rows as $row) {
            $data = [
                'id_breeding' => $row[0],
                'female_die' => $row[1],
                'female_reject' => $row[2],
                'male_die' => $row[3],
                'male_reject' => $row[4],
                'egg_morning' => $row[5],
                'egg_afternoon' => $row[6],
                'broken' => $row[7],
                'abnormal' => $row[8],
                'sale' => $row[9],
                'total_egg' => $row[10],
                'move_to' => $row[11],
                'total_female_move' => $row[12],
                'total_male_move' => $row[13],
                'feed' => $row[14],
                'feed_name' => $row[15],
                'inputBy' => $row[16],
            ];

            $input = Validator::make($data, [
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
            ])->validate();

            $Breeding = Breeding::find($input['id_breeding']);
            $pakan = Pakan::where('nama_pakan', $input['feed_name'])->firstOrFail();

            if (!$Breeding) {
                return response()->json(['error' => 'Data Breeding tidak ditemukan'], 404);
            }
            $input['begining_population'] = $Breeding->begining_population;

            $previousDetail = Breeding_detail::where('id_breeding', $input['id_breeding'])
                ->latest('created_at')
                ->first();
            if (!$previousDetail) {
                $input['last_male'] = $Breeding->jumlah_jantan - $input['male_die'] - $input['male_reject'];
                $input['last_female'] = $Breeding->jumlah_betina - $input['female_die'] - $input['female_reject'];
            } else {
                $calculate_male = $previousDetail->last_male - $input['male_die'] - $input['male_reject'];
                $calculate_female = $previousDetail->last_female - $input['female_die'] - $input['female_reject'];
                $input['last_male'] = $calculate_male;
                $input['last_female'] = $calculate_female;
            }
            if ($input['last_male'] < 0) {
                return response()->json(['error' => 'Female chicken cant be minus quantity!'], 400);
            }
            if ($input['last_female'] < 0) {
                return response()->json(['error' => 'Female chicken cant be minus quantity!'], 400);
            }
            $currentfeed = $pakan->qty - $input['feed'];
            if ($currentfeed < 0) {
                return back()->withErrors('pakan is not enough!! please check pakan stock or call jakarta admin to check the stock!');
            }
            try {
                DB::beginTransaction();
                if ($request->move_to != 0) {
                    $unitCostAsFloat = (float) $Breeding->cost_unit;
                    $datas = $this->moveService->moveTable($input['move_to'], $Breeding->id_pen, $unitCostAsFloat, $input['last_male'], $input['last_female'], $input['total_male_move'], $input['total_female_move']);
                    $new_cost = $datas['new_cost'];

                    $input['last_male'] = $datas['last_male'];
                    $input['last_female'] = $datas['last_female'];
                }

                $current_cost = $this->countService->costegg($pakan, $input['feed'], $input['total_egg'] + $input['sale']);
                $input['cost_unit'] = $current_cost * $input['total_egg'];
                $input['cost_total'] = $current_cost * ($input['total_egg'] + $input['sale']);
                $pakan->update([
                    'qty' => $currentfeed,
                ]);
                Breeding_detail::create($input);
                if ($input['last_male'] == 0 && $input['last_female'] == 0) {
                    $Breeding->update([
                        'status' => 'inactive',
                    ]);
                }
                DB::commit();
                return redirect()->route('user.breeding')->with('success', 'berhasil membuat kandang Breeding baru');
            } catch (\Throwable $th) {
                DB::rollback();
                return back()->with('error', 'failed input!');
            }
        }
    }

    public function adminDashboar()
    {
        $breeding = Breeding::get();
        return Inertia::render('admin/Dashboard', compact('breeding'));
    }
    public function getBreedingDetail($id)
    {
        $breeding = Breeding_detail::with('breeding')->where('id_breeding', $id)->get()->toArray();
        return [$id, 1];
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
        // dd( $breeding->age);
        foreach ($vaksin as $data) {
            if ($breeding->age >= $data->hari) {
                // Jika vaksin dengan 'hari' yang tepat dbreedingukan, cek apakah vaksin sudah ada
                $breeding->isTrue = in_array($data->id, $breeding->vaksin->pluck('id')->toArray());
                // dd($breeding->isTrue);
                // Jika vaksin sudah ada, set isTrue ke false dan keluar dari loop
                if ($breeding->isTrue === false) {
                    $vaksinList[] = $data;
                }
            }
        }

        // dd($vaksinList);
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
        // dd($vaksintype);
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
            //throw $th;
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
}
