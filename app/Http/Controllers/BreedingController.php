<?php

namespace App\Http\Controllers;

use App\Models\Ayam;
use App\Models\Breeding;
use App\Models\Breeding_detail;
use App\Models\Pakan;
use App\Models\Pen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\CountService;

class BreedingController extends Controller
{
    protected $countService;
    public function __construct(CountService $countService)
    {
        $this->countService = $countService;
    }
    public function userIndex()
    {
        $breeding = Breeding::with('BreedingDetails')->get();
        return Inertia::render('user/Breeding', compact('breeding'));
    }
    public function adminIndex()
    {
        $breeding = Breeding::with('BreedingDetails')->get();
        return Inertia::render('admin/Breeding', compact('breeding'));
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
        // dd($request);
        $input = $request->validate([
            'id_pen' => 'required',
            'code_ayam_jantan' => 'required|string',
            'code_ayam_betina' => 'required|string',
            'jumlah_jantan' => 'required|integer',
            'jumlah_betina' => 'required|integer',
            'age' => 'required|integer',
            'inputBy'=> 'required',
        ]);
        // dd($request);
        Breeding::create($input);

        Pen::where('id', $input['id_pen'])->update([
            'status' => 'inactive'
        ]);

        return redirect()->route('user.breeding')->with('success', 'berhasil membuat kandang Breeding baru');
    }

    public function inputBreeding($id)
    {
        $pakan = Pakan::get()->toArray();
        // dd($pakan);
        return Inertia::render('user/FormDailyBreeding', ['id_breeding' => $id, 'pakan'=> $pakan]);
        
    }


    public function inputedBreeding(Request $request)
    {
        // dd($request);
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
            'feed' => 'required|numeric|min:0',
            'feed_name' => 'required|string',
            'inputBy'=> 'required',
        ]);
        // dd($request);

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

        $current_cost =  $this->countService->dailyBreeding($pakan, $input['feed'],$input['total_egg']+$input['sale']);
        $Breeding->update([
            'cost_total' => $Breeding->cost_total + ($current_cost * $input['total_egg'])
        ]);


        

        Breeding_detail::create($input);

        return redirect()->route('user.breeding')->with('success', 'berhasil membuat kandang Breeding baru');
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
}
