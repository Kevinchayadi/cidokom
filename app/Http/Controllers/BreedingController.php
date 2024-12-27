<?php

namespace App\Http\Controllers;

use App\Models\Afkir;
use App\Models\Ayam;
use App\Models\Breeding;
use App\Models\Breeding_detail;
use App\Models\Pakan;
use App\Models\Pen;
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
        $breeding = Breeding::with('BreedingDetails')->get();
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
            $item->age = floor($item->age + -1*(Carbon::now()->diffInDays(Carbon::parse($item->created_at))));
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
        // dd($request);

        $input = $request->validate([
            'id_pen' => 'required',
            'code_ayam_jantan' => 'required|string',
            'code_ayam_betina' => 'required|string',
            'jumlah_jantan' => 'required|integer',
            'jumlah_betina' => 'required|integer',
            'age' => 'required|integer',
            'inputBy' => 'required',
        ]);

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
            ->where('status', 'active')
            ->whereHas('kandang', function ($query) {
                $query->whereNotIn('jenis_kandang', ['breeding', 'commerce']);
            })
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
        try {
            DB::beginTransaction();
            if ($request->move_to != 0) {
                $unitCostAsFloat = (float) $Breeding->cost_unit;
                $datas = $this->moveService->moveTable($input['move_to'], $Breeding->id_pen, $unitCostAsFloat, $input['last_male'], $input['last_female'], $input['total_male_move'], $input['total_female_move']);
                $new_cost = $datas['new_cost'];

                $input['last_male'] = $datas['last_male'];
                $input['last_female'] = $datas['last_female'];
            }

            $currentfeed = $pakan->qty - $input['feed'];
            $current_cost = $this->countService->costegg($pakan, $input['feed'], $input['total_egg'] + $input['sale']);
            $input['cost_unit'] = $current_cost * $input['total_egg'] ;
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
            try {
                DB::beginTransaction();
                if ($request->move_to != 0) {
                    $unitCostAsFloat = (float) $Breeding->cost_unit;
                    $datas = $this->moveService->moveTable($input['move_to'], $Breeding->id_pen, $unitCostAsFloat, $input['last_male'], $input['last_female'], $input['total_male_move'], $input['total_female_move']);
                    $new_cost = $datas['new_cost'];

                    $input['last_male'] = $datas['last_male'];
                    $input['last_female'] = $datas['last_female'];
                }

                $currentfeed = $pakan->qty - $input['feed'];
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

    public function Download($invoiceId)
    {
        $invoice = Breeding::with('items')->findOrFail($invoiceId);

        $pdf = Pdf::loadView('invoice', ['invoice' => $invoice])->setPaper('A4', 'landscape');

        return $pdf->stream('invoice-' . $invoice->number . '.pdf');
    }
}
