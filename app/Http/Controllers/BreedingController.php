<?php

namespace App\Http\Controllers;

use App\Models\Ayam;
use App\Models\Breeding;
use App\Models\Breeding_detail;
use App\Models\Pen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BreedingController extends Controller
{
    public function userIndex()
    {
        $breeding = Breeding::with('BreedingDetails')->get();
        return Inertia::render('user/Breeding', compact('breeding'));
    }

    public function createBreeding()
    {
        $pen = Pen::with('kandang')
            ->whereHas('kandang', function ($query) {
                $query->where('jenis_kandang', 'breeding');
            })
            ->get();
        $ayam = Ayam::get();
        return Inertia::render('user/FormCreateBreeding',['pen' => $pen, 'ayam' => $ayam]);
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
        ]);
        // dd($request);
        Breeding::create($input);

        return redirect()->route('user.breeding')->with('success', 'berhasil membuat kandang Breeding baru');
    }

    public function inputBreeding($id)
    {
        return Inertia::render('user/FormDailyBreeding',['id_breeding' => $id]);
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
            'feed' => 'required|numeric|min:0',
            'feed_name' => 'required|string',
        ]);
        // dd($request);

        $Breeding = Breeding::find($input['id_breeding']);
        if (!$Breeding) {
            return response()->json(['error' => 'Data Breeding tidak ditemukan'], 404);
        }
        $input['begining_population'] = $Breeding->begining_population;
        $input['date'] = $Breeding->date;

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

        Breeding_detail::create($input);

        return redirect()->route('user.breeding')->with('success', 'berhasil membuat kandang Breeding baru');
    }
}
