<?php

namespace App\Http\Controllers;

use App\Models\Pakan;
use App\Models\PakanTransaction;
use Carbon\Carbon;
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
        $isThisDay = Pakan::where('nama_pakan', $pakan['nama_pakan'])->first();
        if($isThisDay){
            return back()->withErrors('This Feed had been Created Before!');
        }
        
        try {
            DB::beginTransaction();
            $harga = $pakan['harga'];
            $pakan['harga'] = $pakan['harga'] / $pakan['qty'];

            $pakan = Pakan::create($pakan);
            // dd($pakan);
            PakanTransaction::create([
                'first_stock' => 0,
                'id_pakan' => $pakan->id,
                'qty' => $pakan->qty,
                'harga_pembelian' => $harga,
            ]);
            DB::commit();
            return redirect()->route('admin.pakan')->with('success', 'Created new Feed Succesfully!!');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return back()->withErrors('Failed create Feedt!');
        }
    
    }
    function addPakan(Request $request, $id)
    {
        // dd([$id,$request]);
        $input = $request->validate([
            // 'nama_pakan' => ['require'],
            'qty' => ['required', 'numeric'], // Memisahkan aturan dengan koma
            'harga' => ['required', 'numeric'], // Memisahkan aturan dengan koma
        ]);
        $isThisDay = PakanTransaction::where('id_pakan',$id)->latest('created_at')->first();
        if(Carbon::parse($isThisDay->created_at)->format('Y-m-d') == Carbon::now()->format('Y-m-d')){
            return back()->withErrors('Transaction For This Feed Already Added Today!');
        }
        $pakan = Pakan::find($id);

        $qty = $pakan->qty + $input['qty'];
        $harga = ($pakan->qty * $pakan->harga + $input['harga']) / $qty;
        try {
            DB::beginTransaction();

            PakanTransaction::create([
                'first_stock' => $pakan->qty,
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
            return back()->withErrors('Failed To add Stock!');
        }

        // dd([$test]);
        // $pakan->save();

        return redirect()->route('admin.pakan')->with('success', 'Add Feed Stock Successfully!!');
    }

    function adminIndex()
    {
        $pakan = Pakan::get();
        return Inertia::render('admin/pakan', ['pakan' => $pakan]);
    }
}
