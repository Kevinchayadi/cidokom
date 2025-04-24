<?php

namespace App\Http\Controllers;

use App\Models\Afkir;
use App\Models\Ayam;
use App\Models\Breeding;
use App\Models\Breeding_detail;
use App\Models\Commercial;
use App\Models\Commercial_detail;
use App\Models\Daily_feed;
use App\Models\Kandang;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function Termwind\render;

class CommercialController extends Controller
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
        $commercial = Commercial::with('commercialDetails', 'vaksin')->where('status', 'active')->get();
        $vaksin = vaksin::where('type', 'CMR')->get();
        // dd($commercial[2]->vaksin);

        foreach ($commercial as $item) {
            // Hitung umur berdasarkan created_at dan update nilai age
            $item->age = floor(
                $item->age +
                    Carbon::parse($item->created_at)
                        ->startOfDay()
                        ->diffInDays(Carbon::now()->startOfDay()),
            );
            $item->isInputed = false;
            $item->isTrue = false;
            $item->isTime = false;

            if ($item->age >= 70) {
                $item->isTime = true;
            }

            foreach ($item->commercialDetails as $detail) {
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

        return Inertia::render('user/commercial', compact('commercial'));
    }

    public function adminIndex()
    {
        $commercial = Commercial::with([
            'commercialDetails' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'pen',
        ])->orderBy('status')->get();
        foreach ($commercial as $item) {
            $item->age =
                ($item->age??0) +
                Carbon::parse($item->created_at)
                    ->startOfDay()
                    ->diffInDays(Carbon::now()->startOfDay());

                $FCR = 0;
                foreach($item->commercialDetails as $detail){
                    if(($detail->last_population)!=0){
                        $FCR += $detail->feed/$detail->last_population;
                    }
                }
                $item->fcr = $FCR;

            if($item->entryDate == null){
                $item->entryDate = Carbon::parse($item->created_at)->format('Y-m-d');
            }
            }
        return Inertia::render('admin/commercial', compact('commercial'));
    }

    public function createCommercial()
    {
        $pen = Pen::with('kandang')
            ->where('status', 'active')
            ->whereHas('kandang', function ($query) {
                $query->where('jenis_kandang', 'commerce');
            })
            ->get()
            ->toArray();
        return Inertia::render('user/FormCreateCommercial', ['pen' => $pen]);
    }
    public function storeCommercial(Request $request)
    {
        $input = $request->validate([
            'id_pen' => 'required|integer|exists:pens,id',
            'entryDate' => 'required|date',
            'entry_population' => 'required|integer|min:1',
            'age' => 'required|integer|min:0',
            'inputBy' => 'required',
        ]);
        $input['last_population'] = $input['entry_population'];

        $input['last_update'] = Carbon::now();

        Commercial::create($input);
        Pen::where('id', $input['id_pen'])->update([
            'status' => 'inactive',
        ]);

        return redirect()->route('user.commercial')->with('success', 'berhasil membuat kandang commercial baru');
    }

    public function dailyForm($id)
    {
        $feed = Pakan::get()->toArray();
        $pen = Pen::with('kandang')
        ->where('status', 'inactive')
        ->whereHas('kandang', function ($query) {
            $query->where('jenis_kandang', 'commerce')->orWhere(function ($subQuery) {
                $subQuery->where('jenis_kandang', 'afkir')->where('code_pen', 'like', '%CMR');
            });
        })
        ->get();
        $commercial = Commercial::with([
            'commercialDetails' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'pen',
            ])->find($id);
            $latest = $commercial->commercialDetails->sortByDesc('created_at')->values()->first();
            $chicken = [
                'total'=> $latest->last_population??$commercial->last_population,
            ];
        $name = $commercial->pen->code_pen;
        

        return Inertia::render('user/FormDailyCommercial', ['id_commercial' => $id, 'feed' => $feed, 'pen' => $pen, 'name' =>$name, 'chicken' => $chicken]);
    }

    public function dailyStore(Request $request)
    {
        $input = $request->validate([
            'id_commercial' => 'required|exists:commercials,id_commercial',
            'depreciation_die' => 'nullable|integer|min:0',
            'depreciation_afkir' => 'nullable|integer|min:0',
            'depreciation_panen' => 'nullable|integer|min:0',
            'move_to' => 'integer',
            'total_female_move' => 'integer',
            'total_male_move' => 'integer',
            'feed' => 'required|numeric',
            'feed_name' => 'required',
            'inputBy' => 'required',
            'date' => 'date',
        ]);
        
        $commercial = Commercial::where('id_commercial', $input['id_commercial'])->firstOrFail();
        $previousDetail = Commercial_detail::where('id_commercial', $input['id_commercial'])->latest('created_at')->first();
        
        
        
        if (!$commercial) {
            return back()->withErrors('Data Commercial tidak ditemukan');
        }
        $input['begining_population'] = $commercial->entry_population;
        
        
        
        if (!$previousDetail) {
            $input['last_population'] = $input['begining_population'] - $input['depreciation_die'] - $input['depreciation_afkir'] - $input['depreciation_panen'];
            $costchicken = $this->countService->costChicken($commercial->unit_Cost ?? 0, $input['begining_population']);
        } else {
            if(Carbon::parse($previousDetail->created_at)->greaterThanOrEqualTo(Carbon::parse($input['date']))) {
                return back()->withErrors('data terakhir update adalah ' . $previousDetail->created_at->format('d-m-y'));
            }
            if(isset($input['date'])){
                $input['created_at'] = Carbon::parse($input['date'])->addHours(7);
            }

            $input['last_population'] = $previousDetail->last_population - $input['depreciation_die'] - $input['depreciation_afkir'] - $input['depreciation_panen'];
            if ($previousDetail->last_population == 0) {
                Commercial::where('id_commercial', $input['id_commercial'])->update(['status'=>'inactive']);
                return redirect()->route('user.commercial')->with('success', 'cage is empty!');
            }
            $costchicken = $this->countService->costChicken($commercial->unit_Cost ?? 0, $previousDetail->last_population);
        }
        if ($input['last_population'] < 0) {
            
            return back()->withErrors('Population chicken cant be minus quantity!');
        }
        
        // dd($costchicken);;
        $new_cost = 0.0;
        //feed
        //----------------------------------------------------------------------------------------------------------------------------------------
        $feed = Pakan::where('nama_pakan', $input['feed_name'])->firstorfail();
        
        $currentfeed = $feed->qty - $input['feed'];
        
        if ($currentfeed < 0) {
            // dd('test');
            return back()->withErrors('pakan is not enough!! please check pakan stock or call jakarta admin to check the stock!');
        }
        try {
            DB::beginTransaction();
            //move transaction
            //---------------------------------------------------------------------------------------------------------------------------------------------
            if ($request->move_to != 0) {
                $unitCostAsFloat = (float) $commercial->unit_Cost;
                $datas = $this->moveService->moveTable($input['move_to'], $commercial->id_pen, $unitCostAsFloat, $input['last_population'], 0, $input['total_male_move'], $input['total_female_move']);
                $new_cost = $datas['new_cost'];
                // dd( $datas['last_male']);
                $input['last_population'] = $datas['last_male'] + $datas['last_female'];
            }
            $input['total_move'] = $input['total_male_move'] + $input['total_female_move'];

            if ($input['depreciation_panen'] != 0) {
                $qtysale = $input['depreciation_panen'];
                Sale::create([
                    'id_pen' => $commercial->id_pen,
                    'qty' => $qtysale,
                ]);
            }
            //if table move not null
            // dd('test');
            //-----------------------------------------------------------------------------------------------------------------------------------------
            $totalMale = Table_move::where('destination_pen', $commercial->id_pen)->where('status', 'active')->sum('totalMale');
            $totalFemale = Table_move::where('destination_pen', $commercial->id_pen)->where('status', 'active')->sum('totalFemale');
            $totalPopulation = $totalMale ?? (0 + $totalFemale ?? 0);
            $costMale = Table_move::where('destination_pen', $commercial->id_pen)->where('status', 'active')->sum('maleCost');
            $costFemale = Table_move::where('destination_pen', $commercial->id_pen)->where('status', 'active')->sum('femaleCost');
            $costPopulation = $costMale ?? (0 + $costFemale ?? 0);
            // dd($totalPopulation);

            if ($totalPopulation != 0) {
                $lastTable = Table_move::where('destination_pen', $commercial->id_pen)->where('status', 'active')->first();
                $input['recieve_from'] = $lastTable->current_pen;
                Table_move::where('destination_pen', $commercial->id_pen)
                    ->where('status', 'active')
                    ->update(['status' => 'inactive']);
                $input['last_population'] += $totalPopulation;
                $input['total_recieve'] = $totalPopulation;
            }

            $costTotal = $commercial->total_cost + $input['feed'] * $feed->harga - $new_cost + $costPopulation;
            $costUnit = $commercial->unit_Cost - $costchicken * $input['depreciation_panen'] + $input['feed'] * $feed->harga - $new_cost + $costPopulation;

            // dd($input);
            Commercial_detail::create($input);
            $feed->update([
                'qty' => $currentfeed,
            ]);
            Daily_feed::create([
                'id_pen' => $commercial->id_pen,
                'id_pakan' => $feed->id,
                'qty' => $input['feed'],
                'stock_feed' => $currentfeed
            ]);
            $status = 'active';
            if ($input['last_population'] == 0) {
                $status = 'inactive';
            }

            Commercial::where('id_commercial', $input['id_commercial'])->update([
                'last_population' => $input['last_population'],
                'total_cost' => $costTotal,
                'unit_Cost' => $costUnit,
                'status' => $status,
            ]);

            DB::commit();
            return redirect()->route('user.commercial')->with('success', 'berhasil membuat kandang commercial baru');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors('input commercial failed!');
        }
    }

    public function moveForm($id)
    {
       $pen = Pen::with('kandang')
        ->where('status', 'inactive')
        ->whereHas('kandang', function ($query) {
            $query->where('jenis_kandang', 'commerce')->orWhere(function ($subQuery) {
                $subQuery->where('jenis_kandang', 'afkir')->where('code_pen', 'like', '%CMR');
            });
        })
        ->get();
            $commercial = Commercial::with([
                'commercialDetails' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                },
                'pen',
            ])->find($id);
    
            $chicken = [
                'total'=> $commercial->commercialDetails[0]->last_population,
            ];
            $name = $commercial->pen->code_pen;

        return Inertia::render('user/FormMoveCommercial', ['id' => $id, 'pen' => $pen,'chicken'=> $chicken, 'name' => $name]);
    }
    public function moveTable(Request $request, $id)
    {
        // Validasi input
        $input = $request->validate([
            // 'id_commercial' => 'required|exists:commercials,id_commercial', // Pastikan ID valid
            'move_to' => 'integer|required',
            'total_female_move' => 'integer|required',
            'total_male_move' => 'integer|required',
        ]);

        if ($input['move_to'] == 0) {
            return back()->withErrors('Select move pen');
        }

        // Mendapatkan Commercial berdasarkan ID
        $commercial = Commercial::with([
            'commercialDetails' => function ($query) {
                $query->whereDate('created_at', Carbon::today());
            },
        ])->findOrFail($id); // pastikan ID valid

        // Mendapatkan data commercialDetails pertama
        $commercialDetail = $commercial->commercialDetails->first(); // jika lebih dari satu, bisa menggunakan get()

        if (!$commercialDetail) {
            return back()->withErrors('Commercial details not found for today!');
        }
        // dd($commercialDetail);

        // Lakukan perhitungan dan pemindahan
        $unitCostAsFloat = (float) $commercial->cost_Total_induk;
        $datas = $this->moveService->moveTable($input['move_to'], $commercial->id_pen, $unitCostAsFloat, $commercialDetail->last_population, 0, $input['total_male_move'], $input['total_female_move']);

        $new_cost = $datas['new_cost'];
        $input['last_population'] = $datas['last_male'] + $datas['last_female'];

        // Validasi agar jumlah ayam tidak menjadi negatif
        if ($input['last_population'] < 0) {
            return back()->withErrors('Male chicken cannot have negative quantity!');
        }

        // Menghitung total cost dan cost induk
        $total_cost = $commercial->total_cost - $new_cost;
        $unit_Cost = $commercial->unit_cost - $new_cost;

        // Mulai transaksi DB
        DB::beginTransaction();

        try {
            // Update commercial data
            $commercial->update([
                'total_cost' => $total_cost,
                'unit_Cost' => $unit_Cost,
                'last_population' => $input['last_population'],
            ]);

            // Update commercialDetails
            $commercialDetail->update([
                'last_population' => $input['last_population'],
            ]);

            // Commit transaksi jika berhasil
            DB::commit();

            return redirect()->route('user.commercial')->with('success', 'Successfully moved to new pen!');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollback();
            return back()->withErrors('Failed to move to new pen. Error: ' . $e->getMessage());
        }
    }

    public function SaleALL($id)
    {
        // Mendapatkan Breeding berdasarkan ID
        $commercial = Commercial::with([
            'commercialDetails' => function ($query) {
                $query->latest('created_at')->first();
            },
        ])->findOrFail($id);
        // Mendapatkan data commercialDetails pertama
        $commercialDetail = $commercial->commercialDetails->first(); // atau bisa menggunakan firstOrFail()
        // dd($commercialDetail);

        // Lakukan perhitungan dan pemindahan

        // Mulai transaksi DB
        $last = $commercial->last_population ?? $commercial->entry_population;
        // dd($commercial);

        try {
            DB::beginTransaction();
            // Update commercial data
            $commercial->update([
                'last_population' => 0,
                'status' => 'inactive',
            ]);

            if ($commercialDetail != null && $commercialDetail->created_at->isToday()) {
                // Lakukan update jika tanggalnya hari ini
                $commercialDetail->update([
                    'last_population' => 0,
                    'depreciation_panen' => $last,
                ]);
            } else {
                // dd('test');
                // Lakukan pembuatan commercial detail baru jika tanggalnya bukan hari ini
                Commercial_detail::create([
                    'id_commercial' => $id, // Asumsikan ini datang dari input yang divalidasi
                    'date' => Carbon::now(), // Menetapkan tanggal saat ini
                    'begining_population' => 0,
                    'last_population' => $last,
                    'depreciation_die' => 0,
                    'depreciation_afkir' => 0,
                    'depreciation_panen' => 0,
                    'move_to' => 0,
                    'total_move' => 0,
                    'recieve_from' => 0,
                    'total_recieve' => 0,
                    'feed' => 0,
                    'feed_name' => '0', // Asumsi kolom feed_name adalah string
                    'inputBy' => Auth::user()->name, // Mengisi dengan nama pengguna yang sedang login
                ]);
            }
            Sale::create([
                'id_pen' => $commercial->id_pen,
                'qty' => $last,
            ]);

            // Commit transaksi jika berhasil
            DB::commit();

            return redirect()->route('user.commercial')->with('success', 'Successfully moved to new pen!');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollback();
            dd('tst');
            return back()->withErrors('Failed to move to new pen, try again.');
        }
    }

    public function addVaccine($id)
    {
        $commercial = Commercial::with('commercialDetails', 'vaksin')->where('id_commercial', $id)->first();
        $vaksin = vaksin::where('type', 'CMR')->get();
        $vaksinList = [];

        $commercial->age = floor(
            $commercial->age +
                Carbon::parse($commercial->created_at)
                    ->startOfDay()
                    ->diffInDays(Carbon::now()->startOfDay()),
        );
        // dd( $commercial->age);
        foreach ($vaksin as $data) {
            if ($commercial->age >= $data->hari) {
                // Jika vaksin dengan 'hari' yang tepat dcommercialukan, cek apakah vaksin sudah ada
                $commercial->isTrue = in_array($data->id, $commercial->vaksin->pluck('id')->toArray());
                // dd($commercial->isTrue);
                // Jika vaksin sudah ada, set isTrue ke false dan keluar dari loop
                if ($commercial->isTrue === false) {
                    $vaksinList[] = $data;
                }
            }
        }

        // dd($vaksinList);
        return Inertia::render('user/FormAddCommercialVaksin', ['id' => $id, 'vaksin' => $vaksinList, 'pen' => 'commercial']);
    }
    public function storevaccine($id, Request $request)
    {
        $input = $request->validate([
            'id_vaksin' => 'required|integer',
            'qty' => 'required|numeric',
        ]);
        $commercial = Commercial::with('commercialDetails', 'vaksin')->where('id_commercial', $id)->first();
        $vaksin = vaksin::find($input['id_vaksin']);
        $vaksintype = vaksinType::where('nama_vaksin', $vaksin->nama)->first();

        if (!$vaksintype) {
            return back()->withErrors('Vaksin not found!, please call Jakarta Admin to add the vaksin!!');
        }

        $qty = $vaksintype->qty - $input['qty'];

        if ($qty < 0) {
            return back()->withErrors('Vaksin QTY is not enough, please tell Jakarta Admin!!');
        }
        // dd($vaksintype);
        // dd($vaksintype);
        try {
            $vaksintype->update([
                'qty' => $qty,
            ]);
            $commercial->vaksin()->attach($request->id_vaksin);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->withErrors('failed input!');
        }

        return redirect()->route('user.commercial')->with('success', 'berhasil membuat kandang Breeding baru');
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
            $input = [
                'id_commercial' => $row[0],
                'depreciation_die' => $row[1],
                'depreciation_afkir' => $row[2],
                'depreciation_panen' => $row[3],
                'feed' => $row[4],
                'feed_name' => $row[5],
                'inputBy' => $row[6],
            ];

            $validated = Validator::make($input, [
                'id_commercial' => 'required|exists:commercials,id_commercial',
                'depreciation_die' => 'nullable|integer|min:0',
                'depreciation_afkir' => 'nullable|integer|min:0',
                'depreciation_panen' => 'nullable|integer|min:0',
                'feed' => 'required|integer',
                'feed_name' => 'required',
                'inputBy' => 'required',
            ])->validate();

            $commercial = Commercial::where('id_commercial', $validated['id_commercial'])->firstOrFail();

            $validated['begining_population'] = $commercial->entry_population;
            $validated['date'] = $commercial->date;

            $previousDetail = Commercial_detail::where('id_commercial', $validated['id_commercial'])->latest('created_at')->first();

            if (!$previousDetail) {
                $validated['last_population'] = $validated['begining_population'] - $validated['depreciation_afkir'] - $validated['depreciation_panen'];
            } else {
                $validated['last_population'] = $previousDetail->last_population - $validated['depreciation_die'] - $validated['depreciation_afkir'] - $validated['depreciation_panen'];
            }
            if ($input['last_population'] < 0) {
                return response()->json(['error' => 'Population chicken cant be minus quantity!'], 400);
            }

            $feed = Pakan::where('id', $validated['feed_name'])->firstOrFail();
            $costchicken = $this->countService->costChicken($commercial->unit_cost, $previousDetail->last_population ?? $validated['begining_population']);
            $costTotal = $commercial->total_cost + $validated['feed'] * $feed->harga;

            $costUnit = $commercial->unit_cost - $costchicken * ($validated['depreciation_die'] + $validated['depreciation_afkir'] + $validated['depreciation_panen']) + $validated['feed'] * $feed->harga;

            Commercial_detail::create($validated);

            Commercial::where('id_commercial', $validated['id_commercial'])->update([
                'last_population' => $validated['last_population'],
                'total_cost' => $costTotal,
                'unit_cost' => $costUnit,
            ]);
        }

        return redirect()->route('user.commercial')->with('success', 'Berhasil mengimpor data commercial.');
    }

    public function Download($invoiceId)
    {
        $invoice = Commercial::with('items')->findOrFail($invoiceId);

        $pdf = Pdf::loadView('invoice', ['invoice' => $invoice])->setPaper('A4', 'landscape');

        return $pdf->stream('invoice-' . $invoice->number . '.pdf');
    }
}
