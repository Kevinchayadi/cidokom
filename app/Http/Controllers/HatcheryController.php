<?php

namespace App\Http\Controllers;

use App\Models\Hatchery;
use App\Models\Hatchery_detail;
use App\Models\Pen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class HatcheryController extends Controller
{
    public function userIndex()
    {
        $hatchery = Hatchery::with('hatcheryDetails')->where('status', 'active')->get()->toArray();
        // dd($hatchery);
        return Inertia::render('user/Hatchery', compact('hatchery'));
    }

    public function createHatchery()
    {
        $pen = Pen::with('kandang')
            ->whereHas('kandang', function ($query) {
                $query->where('jenis_kandang', 'breeding');
            })
            ->get();
        return Inertia::render('user/FormCreateHatchery', compact('pen'));
    }
    public function storeHatchery(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'id_pen' => 'required|integer',
            'machine_name' => 'required|string',
            'total_setting' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $input = $request->validate([
            'id_pen' => 'required|integer',
            'machine_name' => 'required|string',
        ]);
        // Menambahkan tanggal setting
        $input['setting_date'] = Carbon::now();

        // Validasi input kedua
        $input2 = $request->validate([
            'total_setting' => 'required|integer',
        ]);

        // Mulai transaksi
        DB::beginTransaction();

        try {
            // Membuat entitas Hatchery
            $hatchery = Hatchery::create($input);
            // dd($hatchery->id_hatchery);
            // Mengaitkan id_hatchery dengan Hatchery_detail
            $input2['id_hatchery'] = $hatchery->id_hatchery;
            // dd($input2);
            Hatchery_detail::create($input2);

            // Commit transaksi jika semua berhasil
            DB::commit();

            return redirect()->route('user.hatchery')->with('success', 'Berhasil membuat kandang Hatchery baru');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollback();

            dd($e->getMessage());
            return back()->withErrors('error', 'Gagal membuat kandang Hatchery baru: ' . $e->getMessage());
        }
    }

    public function threeInputHatchery($id)
    {
        $hatcheryDetail = Hatchery_detail::where('id_hatchery', $id)->firstOrFail();
        return Inertia::render('user/FormThreeHatchery', ['hatcheryDetail' => $hatcheryDetail]);
    }

    public function threeInputedHatchery(Request $request)
    {
        // dd($request);
        $input = $request->validate([
            'id_hatchery' => 'required',
            'infertile' => 'required',
            'explode' => 'required',
            'hatcher' => 'required',
        ]);

        $hatcheryDetail = Hatchery_detail::with('hatchery')
            ->where('id_hatchery', $input['id_hatchery'])
            ->firstOrFail();
        $hatcheryDetail->update([
            'infertile' => $input['infertile'],
            'explode' => $input['explode'],
            'hatcher' => $input['hatcher'],
        ]);

        return redirect()->route('user.hatchery')->with('success', 'berhasil membuat kandang Breeding baru');
    }
    public function eightynInputHatchery($id)
    {
        $hatcheryDetail = Hatchery_detail::where('id_hatchery', $id)->firstOrFail();
        return Inertia::render('user/FormEightynHatchery', ['hatcheryDetail' => $hatcheryDetail]);
    }

    public function eightynInputedHatchery(Request $request)
    {
        // dd($request);
        $input = $request->validate([
            'id_hatchery' => 'required',
            'infertile' => 'required',
            'explode' => 'required',
            'hatcher' => 'required',
        ]);

        $hatcheryDetail = Hatchery_detail::with('hatchery')
            ->where('id_hatchery', $input['id_hatchery'])
            ->firstOrFail();
        $hatcheryDetail->update([
            'infertile' => $input['infertile'],
            'explode' => $input['explode'],
            'hatcher' => $input['hatcher'],
        ]);
        $hatchery = Hatchery::where('id_hatchery', $input['id_hatchery'])->firstOrFail();
        $hatchery->update([
            'candling_date' => Carbon::now(),
        ]);

        return redirect()->route('user.hatchery')->with('success', 'berhasil membuat kandang Breeding baru');
    }
    public function finalInputHatchery($id)
    {
        $hatcheryDetail = Hatchery_detail::where('id_hatchery', $id)->firstOrFail();
        return Inertia::render('user/FormTwentyoneHatchery', ['hatcheryDetail' => $hatcheryDetail]);
    }

    public function finalInputedHatchery(Request $request)
    {
        // dd($request);
        $input = $request->validate([
            'id_hatchery' => 'required',
            'dead_in_egg' => 'required',
            'hatchability' => 'required',
            'doc_afkir' => 'required',
            'saleable' => 'required',
        ]);

        $hatcheryDetail = Hatchery_detail::where('id_hatchery', $input['id_hatchery'])->firstOrFail();
        // dd($hatcheryDetail);
        $hatchery = Hatchery::where('id_hatchery', $input['id_hatchery'])->firstOrFail();

        $hatchery->update([
            'pull_chicken_date' => Carbon::now(),
        ]);
        $hatcheryDetail->update([
            'dead_in_egg' => $input['dead_in_egg'],
            'hatchability' => $input['hatchability'],
            'doc_afkir' => $input['doc_afkir'],
            'saleable' => $input['saleable'],
        ]);

        return redirect()->route('user.hatchery')->with('success', 'berhasil membuat kandang Breeding baru');
    }
}
