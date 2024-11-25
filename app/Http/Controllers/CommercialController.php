<?php

namespace App\Http\Controllers;

use App\Models\Afkir;
use App\Models\Ayam;
use App\Models\Breeding;
use App\Models\Breeding_detail;
use App\Models\Commercial;
use App\Models\Commercial_detail;
use App\Models\Kandang;
use App\Models\Pakan;
use App\Models\Pen;
use App\Models\Table_move;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\CountService;
use Illuminate\Support\Facades\Validator;

use function Termwind\render;

class CommercialController extends Controller
{
    protected $countService;
    public function __construct(CountService $countService)
    {
        $this->countService = $countService;
    }
    public function userIndex()
    {
        $commercial = Commercial::with('commercialDetails')->get();
        return Inertia::render('user/commercial', compact('commercial'));
    }

    public function adminIndex()
    {
        $commercial = Commercial::with('commercialDetails', 'pen')->get();
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
        // dd($request);
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
            ->where('status', 'active')
            ->whereHas('kandang', function ($query) {
                $query->whereNotIn('jenis_kandang', ['breeding', 'commerce']);
            })
            ->get();
        return Inertia::render('user/FormDailyCommercial', ['id_commercial' => $id, 'feed' => $feed, 'pen' => $pen]);
    }

    public function dailyStore(Request $request)
    {
        $input = $request->validate([
            'id_commercial' => 'required|exists:commercials,id_commercial',
            'depreciation_die' => 'nullable|integer|min:0',
            'depreciation_afkir' => 'nullable|integer|min:0',
            'depreciation_panen' => 'nullable|integer|min:0',
            'feed' => 'required|integer',
            'feed_name' => 'required',
            'inputBy' => 'required',
        ]);
        // dd($request);

        $commercial = Commercial::where('id_commercial', $input['id_commercial'])->firstOrFail();
        if (!$commercial) {
            return response()->json(['error' => 'Data Commercial tidak ditemukan'], 404);
        }
        $input['begining_population'] = $commercial->entry_population;
        $input['date'] = $commercial->date;

        $previousDetail = Commercial_detail::where('id_commercial', $input['id_commercial'])
            ->latest('created_at')
            ->first();
        if (!$previousDetail) {
            $input['last_population'] = $input['begining_population'] - $input['depreciation_die'] - $input['depreciation_afkir'] - $input['depreciation_panen'];
            $input['last_population'];
        } else {
            $input['last_population'] = $previousDetail->last_population - $input['depreciation_die'] - $input['depreciation_afkir'] - $input['depreciation_panen'];
            $input['last_population'];
        }
        if ($input['last_population'] < 0) {
            return response()->json(['error' => 'Population chicken cant be minus quantity!'], 400);
        }
        $costchicken = $this->countService->costChicken($commercial->unit_cost ?? 0, $input['last_population']);
        $new_cost = 0;
        try {
            //code...
            if ($request->move_to != 0) {
                // $input['last_population'] =  $input['last_population'] - $input['total_male_move'] - $input['total_female_move'];
                $data = Pen::with('kandang')
                    ->where('id', $request->move_to)
                    ->firstorfail();
                $cost = $commercial->unit_cost / $input['last_population'];
                $new_cost = $cost * ($request->total_male_move + $request->total_female_move);
                if ($data->kandang->jenis_kandang == 'afkir') {
                    // dd('test');
                    $afkir = Afkir::where('id_pen', $request->move_to)->firstOrFail();
                    if ($afkir) {
                        $male = $afkir->male + $request->total_male_move;
                        $female = $afkir->female + $request->total_female_move;
                        // $cost = $commercial->unit_cost / $input['last_population'] ;
                        $male_cost = $afkir->male_cost + $cost * $request->total_male_move;
                        $female_cost = $afkir->female_cost + $cost * $request->total_female_move;
                        Afkir::create([
                            'id_pen' => $request->move_to,
                            'male' => $male,
                            'female' => $female,
                            'male_cost' => $male_cost,
                            'female_cost' => $female_cost,
                            'female_come' => $request->total_female_move,
                            'male_come' => $request->total_male_move,
                        ]);
                    } else {
                        Afkir::create([
                            'id_pen' => $request->move_to,
                            'male' => $request->total_male_move,
                            'female' => $request->total_female_move,
                            'male_cost' => $cost * $request->total_male_move,
                            'female_cost' => $cost * $request->total_female_move,
                            'female_come' => $request->total_female_move,
                            'male_come' => $request->total_male_move,
                        ]);
                    }
                    Table_move::create([
                        'current_pen' => $commercial->id_pen,
                        'destination_pen' => $request->move_to,
                        'totalMale' => $request->total_male_move,
                        'totalFemale' => $request->total_female_move,
                        'maleCost' => $cost * $request->total_male_move,
                        'femaleCost' => $cost * $request->total_female_move,
                        'status' => 'inactive',
                    ]);
                }
                if ($data->kandang->jenis_kandang == 'breeding') {
                    $breeding = Breeding::with([
                        'breedingDetail' => function ($query) {
                            $query->whereDate('created_at', Carbon::today());
                        },
                    ])
                        ->where('id_pen', $request->move_to)
                        ->first();

                    if ($breeding) {
                        $last_male = $breeding->last_male + $request->total_male_move;
                        $last_female = $breeding->last_female + $request->total_female_move;
                        $total_female = $breeding->total_female_receive + $request->total_female_move;
                        $total_male = $breeding->total_male_receive + $request->total_male_move;
                        $breeding->breeding_detail->update([
                            'last_male' => $last_male,
                            'last_female' => $last_female,
                            'receive_from' => $commercial->id_pen,
                            'total_female_receive' => $total_female,
                            'total_male_receive' => $total_male,
                        ]);
                        Table_move::create([
                            'current_pen' => $commercial->id_pen,
                            'destination_pen' => $request->move_to,
                            'totalMale' => $request->total_male_move,
                            'totalFemale' => $request->total_female_move,
                            'maleCost' => $cost * $request->total_male_move,
                            'femaleCost' => $cost * $request->total_female_move,
                            'status' => 'inactive',
                        ]);
                    } else {
                        Table_move::create([
                            'current_pen' => $commercial->id_pen,
                            'destination_pen' => $request->move_to,
                            'totalMale' => $request->total_male_move,
                            'totalFemale' => $request->total_female_move,
                            'maleCost' => $cost * $request->total_male_move,
                            'femaleCost' => $cost * $request->total_female_move,
                        ]);
                    }
                }
                $input['last_population'] = $input['last_population'] - $input['total_male_move'] - $input['total_female_move'];
                $input['total_move'] = $request->total_male_move + $request->total_female_move;
            }
            $totalMale = Table_move::where('destination_pen', $commercial->id_pen)->sum('totalMale');
            $totalFemale = Table_move::where('destination_pen', $commercial->id_pen)->sum('totalFemale');
            $totalPopulation = $totalMale + $totalFemale;
            $costMale = Table_move::where('destination_pen', $commercial->id_pen)->sum('maleCost');
            $costFemale = Table_move::where('destination_pen', $commercial->id_pen)->sum('femaleCost');
            $costPopulation = $costMale + $costFemale;
            
            if($totalPopulation){
                $input['last_population'] = $totalPopulation;
            }
            // dd($request);
            $feed = Pakan::where('id', $input['feed_name'])->firstorfail();
            // dd( $input['last_population']);
            $currentfeed = $feed->qty - $input['feed'];
            $costTotal = $commercial->total_cost + ($input['feed'] * $feed->harga)  - $new_cost;
            $costUnit = $commercial->unit_cost - $costchicken * ($input['depreciation_die'] + $input['depreciation_afkir'] + $input['depreciation_panen']) + $input['feed'] * $feed->harga - $new_cost + $costPopulation;
            // dd($request);
            Commercial_detail::create($input);
            $feed->update([
                'qty' => $currentfeed,
            ]);

            Commercial::where('id_commercial', $input['id_commercial'])->update([
                'last_population' => $input['last_population'],
                'total_cost' => $costTotal,
                'unit_Cost' => $costUnit,
            ]);

            return redirect()->route('user.commercial')->with('success', 'berhasil membuat kandang commercial baru');
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => 'input commercial failed!'], 400);
        }
    }

    public function dailyStoreBulk(Request $request)
    {
        // Validasi file Excel
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        // Ambil data dari Excel
        $data = \Maatwebsite\Excel\Facades\Excel::toArray([], $request->file('file'));

        // Ambil sheet pertama (Anda dapat menyesuaikan jika ada beberapa sheet)
        $rows = $data[0];

        // Abaikan baris header, mulai dari baris kedua
        $rows = array_slice($rows, 1);

        // Iterasi setiap baris dan jalankan logika `dailyStore`
        foreach ($rows as $row) {
            $input = [
                'id_commercial' => $row[0], // Sesuaikan kolom Excel
                'depreciation_die' => $row[1],
                'depreciation_afkir' => $row[2],
                'depreciation_panen' => $row[3],
                'feed' => $row[4],
                'feed_name' => $row[5],
                'inputBy' => $row[6],
            ];

            // Validasi data per baris
            $validated = Validator::make($input, [
                'id_commercial' => 'required|exists:commercials,id_commercial',
                'depreciation_die' => 'nullable|integer|min:0',
                'depreciation_afkir' => 'nullable|integer|min:0',
                'depreciation_panen' => 'nullable|integer|min:0',
                'feed' => 'required|integer',
                'feed_name' => 'required',
                'inputBy' => 'required',
            ])->validate();

            // Proses logika yang ada di `dailyStore`
            $commercial = Commercial::where('id_commercial', $validated['id_commercial'])->firstOrFail();

            $validated['begining_population'] = $commercial->entry_population;
            $validated['date'] = $commercial->date;

            $previousDetail = Commercial_detail::where('id_commercial', $validated['id_commercial'])
                ->latest('created_at')
                ->first();

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

            // Simpan detail komersial
            Commercial_detail::create($validated);

            // Update data komersial
            Commercial::where('id_commercial', $validated['id_commercial'])->update([
                'last_population' => $validated['last_population'],
                'total_cost' => $costTotal,
                'unit_cost' => $costUnit,
            ]);
        }

        return redirect()->route('user.commercial')->with('success', 'Berhasil mengimpor data commercial.');
    }
}
