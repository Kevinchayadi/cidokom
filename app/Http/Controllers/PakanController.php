<?php

namespace App\Http\Controllers;

use App\Models\Pakan;
use App\Models\PakanTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PakanController extends Controller
{
    function userIndex()
    {
        $pakan = Pakan::get();
        return Inertia::render('user/pakanList', compact('pakan'));
    }

    function createPakan()
    {
        return Inertia::render('user/FormCreatePakan');
    }

    function storePakan(Request $request)
    {
        $pakan = $request->validate([
            'nama_pakan' => ['required'],
            'qty' => ['required', 'integer'], // Memisahkan aturan dengan koma
            'harga' => ['required', 'integer'], // Memisahkan aturan dengan koma
        ]);
        // dd($pakan);
        try {
            DB::beginTransaction();
            $harga = $pakan['harga'];
            $pakan['harga'] = $pakan['harga'] / $pakan['qty'];

            $pakan = Pakan::create($pakan);
            // dd($pakan);
            PakanTransaction::create([
                'id_pakan' => $pakan->id,
                'qty' => $pakan->qty,
                'harga_pembelian' => $harga,
            ]);
            DB::commit();
            return redirect()->route('admin.pakan')->with('success', 'Berhasil membuat pakan baru!!');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return back()->withErrors('gagal input!');
        }
        return redirect()->route('admin.pakan')->with('success', 'Berhasil membuat pakan baru!!');
    }
    function addPakan(Request $request, $id)
    {
        // dd([$id,$request]);
        $input = $request->validate([
            // 'nama_pakan' => ['require'],
            'qty' => ['required', 'numeric'], // Memisahkan aturan dengan koma
            'harga' => ['required', 'numeric'], // Memisahkan aturan dengan koma
        ]);
        $pakan = Pakan::find($id);
        $qty = $pakan->qty + $input['qty'];
        $harga = ($pakan->qty * $pakan->harga + $input['harga']) / $qty;
        try {
            DB::beginTransaction();
            PakanTransaction::create([
                'id_pakan' => $id,
                'qty' => $qty,
                'harga_pembelian' => $harga,
            ]);
            $test = $pakan->update([
                'qty' => $qty,
                'harga' => $harga,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return back()->withErrors('gagal input!');
        }

        // dd([$test]);
        // $pakan->save();

        return redirect()->route('admin.pakan')->with('success', 'Berhasil membuat pakan baru!!');
    }

    function adminIndex()
    {
        $pakan = Pakan::get();
        return Inertia::render('admin/pakan', ['pakan' => $pakan]);
    }
}
