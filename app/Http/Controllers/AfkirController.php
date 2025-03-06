<?php

namespace App\Http\Controllers;

use App\Models\Afkir;
use App\Models\Pakan;
use App\Models\Pen;
use App\Services\countService;
use App\Services\moveService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AfkirController extends Controller
{
    protected $countService;
    protected $moveService;
    public function __construct(countService $countService, moveService $moveService)
    {
        $this->countService = $countService;
        $this->moveService = $moveService;
    }
    function afkir()
    {
        $afkir = Pen::whereHas('kandang', function ($query) {
            $query->where('jenis_kandang', 'afkir');
        })
            ->with('kandang')
            ->get();
        foreach ($afkir as $item) {
            $item->isTrue = true;
            $data = Afkir::where('id_pen', $item->id)
                ->whereDate('created_at', Carbon::today())
                ->get();
            if (!$data->isEmpty()) {
                // Periksa kondisi: male == 0, female == 0, atau tanggal sama dengan hari ini
                foreach ($data as $record) {
                    // dd($data);
                    if ($record->feed_female !== null || $record->feed_male !== null) {
                        $item->isTrue = false;
                        break; // Hentikan iterasi jika kondisi terpenuhi
                    }
                }

                // Ambil data terbaru (berdasarkan waktu)
                $latestData = $data->sortByDesc('created_at')->first();

                if ($latestData && $latestData->male == 0 && $latestData->female == 0) {
                    $item->isTrue = false; // Jika data terbaru memiliki male == 0 dan female == 0
                }
            } else {
                // Jika data tidak ditemukan, tandai sebagai tidak valid
                $item->isTrue = false;
            }
        }

        // dd(!Afkir::where('id_pen', 33)->whereDate('created_at', Carbon::today())->get()->isEmpty());
        return Inertia::render('user/afkir', ['afkir' => $afkir]);
    }
    function dailyAfkirForm($id)
    {
        $penCheck = Pen::where('id', $id)->first();
        // $pen = Pen::get();

        $pakan = Pakan::get()->toArray();
        // dd($pen);
        if ($penCheck->code_pen === 'AFKIR-BRD' || $penCheck->code_pen === 'KARANTINA-BRD') {
            $pen = Pen::whereHas('kandang', function ($query) {
                $query->where('jenis_kandang', 'breeding');
            })->get();
            // return  Inertia::render('user/FormDailyAfkirBRD', ['id'=>$id, 'pen'=>$pen]);
        }
        if ($penCheck->code_pen === 'AFKIR-CMR' || $penCheck->code_pen === 'KARANTINA-CMR') {
            $pen = Pen::whereHas('kandang', function ($query) {
                $query->where('jenis_kandang', 'commercial');
            })->get();
            // return  Inertia::render('user/FormDailyAfkirCMR', ['id'=>$id, 'pen'=>$pen]);
        }
        return Inertia::render('user/FormDailyAfkirBRD', ['id' => $id, 'pen' => $pen, 'pakan' => $pakan]);
    }
    function storeAfkirForm(Request $request, $id)
    {
        $data = Afkir::where('id_pen', $id)->latest('created_at')->first();

        $input = $request->validate([
            'feedName' => 'required',
            'feed_male' => 'required|numeric|min:0',
            'feed_female' => 'required|numeric|min:0',
            'male_die' => 'required|integer|min:0',
            'female_die' => 'required|integer|min:0',
            'male_sale' => 'required|integer|min:0',
            'female_sale' => 'required|integer|min:0',
            'id_destination' => 'nullable',
            'male_out' => 'nullable|numeric|min:0',
            'female_out' => 'nullable|numeric|min:0',
        ]);
        // dd($data);
        $pakan = Pakan::where('nama_pakan', $input['feedName'])->first();
        $currentfeed = $pakan->qty - $input['feed_male'] - $input['feed_female'];
        $input['male_cost'] = $data->male_cost + $pakan->harga * $input['feed_male'];
        $input['female_cost'] = $data->female_cost + $pakan->harga * $input['feed_female'];
        $input['male'] = $data->male - $input['male_die'] - $input['male_sale'];
        $input['female'] = $data->female - $input['female_die'] - $input['female_sale'];
        if ($input['male'] < 0) {
            return back()->withErrors('Male qty cant less than 0');
        }
        if ($input['female'] < 0) {
            return back()->withErrors('Female qty cant less than 0');
        }
        try {
        //     //code...
            $pakan->update([
                'qty' => $currentfeed,
            ]);
            // dd('test');
            if ($input['id_destination'] != 0 && $input['male_out'] + $input['female_out'] != 0) {
                // dd($input['male_cost']);
                $datas = $this->moveService->moveTable($input['id_destination'], $id, $input['male_cost'] + $input['female_cost'], $data->male, $data->female, $input['male_out'], $input['female_out']);

                $new_cost = $datas['new_cost'] / ($input['male_out'] + $input['female_out']);

                $input['male_cost'] = $input['male_cost'] - $new_cost * $input['male_out'];
                $input['female_cost'] = $input['female_cost'] - $new_cost * $input['female_out'];

                $input['male'] = $datas['last_male'];
                $input['female'] = $datas['last_female'];
            }
            $input['id_pen'] = $id;

            Afkir::create($input);
            return redirect()->route('user.afkir')->with('success', 'daily report added!');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->withErrors(['error' => 'gagal transaksi!']);
        }
        // Mendapatkan pen berdasarkan ID yang diberikan
    }

    function moveForm($id)
    {
        $penCheck = Pen::where('id', $id)->first();

        if ($penCheck->code_pen === 'AFKIR-BRD' || $penCheck->code_pen === 'KARANTINA-BRD') {
            $pen = Pen::whereHas('kandang', function ($query) {
                $query->where('jenis_kandang', 'breeding');
            })->get();
            // return  Inertia::render('user/FormDailyAfkirBRD', ['id'=>$id, 'pen'=>$pen]);
        }
        if ($penCheck->code_pen === 'AFKIR-CMR' || $penCheck->code_pen === 'KARANTINA-CMR') {
            $pen = Pen::whereHas('kandang', function ($query) {
                $query->where('jenis_kandang', 'commercial');
            })->get();
            // return  Inertia::render('user/FormDailyAfkirCMR', ['id'=>$id, 'pen'=>$pen]);
        }
        return Inertia::render('user/FormMoveAfkir', ['id' => $id, 'pen' => $pen]);
    }
    function moveTable(Request $request, $id)
    {
        $data = Afkir::where('id_pen', $id)->latest('created_at')->first();

        $input = $request->validate([
            'id_destination' => 'nullable',
            'male_out' => 'nullable|numeric|min:0',
            'female_out' => 'nullable|numeric|min:0',
        ]);
        
        try {
            //code...
            $datas = $this->moveService->moveTable($input['id_destination'], $id, $input['male_cost'] + $input['female_cost'], $data->male, $data->female, $input['male_out'], $input['female_out']);

            $new_cost = $datas['new_cost'] / ($input['male_out'] + $input['female_out']);

            $input['male_cost'] = $data->male - $new_cost * $input['male_out'];
            $input['female_cost'] = $data->female - $new_cost * $input['female_out'];

            $input['male'] = $datas['last_male'];
            $input['female'] = $datas['last_female'];
                
                
            $input['id_pen'] = $id;

            Afkir::create($input);
            return redirect()->route('user.afkir')->with('success', 'daily report added!');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->withErrors(['error' => 'gagal transaksi!']);
        }
        // Mendapatkan pen berdasarkan ID yang diberikan
    }

    function adminIndex()
    {
        $afkir = Afkir::with('pen')
            ->whereHas('pen', function ($query) {
                $query->where('code_pen', 'AFKIR-BRD');
            })
            ->get();
        // dd($afkir);
        return Inertia::render('admin/afkir', ['afkir' => $afkir]);
    }
    function adminIndex2()
    {
        $afkir = Afkir::with('pen')
            ->whereHas('pen', function ($query) {
                $query->where('code_pen', 'KARANTINA-BRD');
            })
            ->get();
        return Inertia::render('admin/karantinaBreeding', ['afkir' => $afkir]);
    }
    function adminIndex3()
    {
        $afkir = Afkir::with('pen')
            ->whereHas('pen', function ($query) {
                $query->where('code_pen', 'KARANTINA-CMR');
            })
            ->get();
        return Inertia::render('admin/karantinaCommercial', ['afkir' => $afkir]);
    }

    function adminKarantinaIndex()
    {
        $afkir = Afkir::where('id_pen', ['KARANTINA-BRD', 'KARANTINA-CMR'])->get();
        return Inertia::render('admin/karantina', ['afkir' => $afkir]);
    }
}
