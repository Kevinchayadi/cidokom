<?php

namespace App\Http\Controllers;

use App\Models\vaksin;
use App\Models\vaksinTransaction;
use App\Models\vaksinType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class VaksinController extends Controller
{
    function userIndex()
    {
        $vaksinType = vaksinType::get();
        return Inertia::render('user/vaksinList', compact('vaksinType'));
    }

    function createvaksin()
    {
        return Inertia::render('user/FormCreatevaksinType');
    }

    function storevaksin(Request $request)
    {
        // dd($request);
        $vaksinType = $request->validate([
            'nama_vaksin' => 'required|required|unique:vaksin_types,nama_vaksin',
            'qty' => 'required|integer', // Memisahkan aturan dengan koma
            'harga' => 'required|integer', // Memisahkan aturan dengan koma
        ]);
        // dd($vaksinType);
        try {
            DB::beginTransaction();
            $harga = $vaksinType['harga'];
            $vaksinType['harga'] = $vaksinType['harga'] / $vaksinType['qty'];

            $vaksinType = vaksinType::create($vaksinType);
            // dd($vaksinType);
            vaksinTransaction::create([
                'id_vaksin' => $vaksinType->id,
                'qty' => $vaksinType->qty,
                'harga' => $harga,
            ]);
            DB::commit();
            return redirect()->route('admin.vaksin')->with('success', 'Berhasil membuat vaksinType baru!!');
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
            return back()->withErrors('gagal input!');
        }
        return redirect()->route('admin.vaksinType')->with('success', 'Berhasil membuat vaksinType baru!!');
    }
    function addvaksin(Request $request, $id)
    {
        // dd([$id,$request]);
        $input = $request->validate([
            // 'nama_vaksinType' => ['require'],
            'qty' => ['required', 'numeric'], // Memisahkan aturan dengan koma
            'harga' => ['required', 'numeric'], // Memisahkan aturan dengan koma
        ]);
        $vaksinType = vaksinType::find($id);
        // dd($vaksinType);
        $qty = $vaksinType->qty + $input['qty'];
        $harga = ($vaksinType->qty * $vaksinType->harga + $input['harga']) / $qty;
        try {
            DB::beginTransaction();
            vaksinTransaction::create([
                'id_vaksin' => $id,
                'qty' => $qty,
                'harga' => $harga,
            ]);
            $test = $vaksinType->update([
                'qty' => $qty,
                'harga' => $harga,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
            return back()->withErrors('gagal input!');
        }

        // dd([$test]);
        // $vaksinType->save();

        return redirect()->route('admin.vaksin')->with('success', 'Berhasil membuat vaksinType baru!!');
    }

    function adminIndex()
    {
        $vaksinType = vaksinType::get();
        // dd($vaksinType);
        return Inertia::render('admin/vaksin', ['vaksin' => $vaksinType]);
    }
    function adminIndex2()
    {
        $vaksin = vaksin::get();
        // dd($vaksinType);
        return Inertia::render('admin/vaksinSchedule', ['vaksin' => $vaksin]);
    }
}
