<?php

namespace App\Http\Controllers;

use App\Models\ChickenSize;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\saleTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SaleController extends Controller
{
    function storeSales(Request $request)
    {
        // dd($request);
        $sale = $request->validate([
            'tanggal_Penjualan' => 'required|date',
            'id_pembeli' => 'required|integer|max:100',
            'jumlah_ayam' => 'required|integer|min:1',
            'id_ayam' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
        ]);
        $ayam = ChickenSize::find($sale['id_ayam']);
        $sale['harga'] = $ayam->harga;
        $sale['total_harga'] = $sale['harga'] * $sale['jumlah_ayam'];

        // try {
            // dd($sale);
            DB::beginTransaction();
            // $sale = saleTransaction::create($sale);

            saleTransaction::create($sale);
            DB::commit();
            return redirect()->route('admin.sales')->with('success', 'Berhasil membuat sale baru!!');
        // } catch (\Throwable $th) {
        //     DB::rollBack();

        //     return back()->withErrors('gagal input!');
        // }
    }
    function editSales(Request $request, $id)
    {
        $input = $request->validate([
            'tanggal_Penjualan' => 'required|date',
            'id_pembeli' => 'required|integer|max:100',
            'jumlah_ayam' => 'required|integer|min:1',
            'id_ayam' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
        ]);
        $sale = saleTransaction::find($id);
        

        $input['total_harga'] = $sale['harga'] * $sale['jumlah_Ayam'];
        try {
            DB::beginTransaction();
            saleTransaction::where('id', $id)->update($input);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->withErrors('gagal input!');
        }

        return redirect()->route('admin.sales')->with('success', 'Berhasil mengupdate sale baru!!');
    }

    function salesIndex()
    {
        $saleTransaction = saleTransaction::with(['Customers.sales','ChickenSize'])->get();
        $sale = Sale::get();
        $totalQtyTransactions = SaleTransaction::sum('jumlah_ayam');
        $totalQtySales = Sale::sum('qty');
        $stockLeft = $totalQtySales - $totalQtyTransactions;
        $customer = Customer::get();
        $chickenSize = ChickenSize::get();
        // dd([$customer, $chickenSize]);
        // dd($saleTransaction->toArray());
        return Inertia::render('admin/sales/sales', ['sale' => $sale, 'saleTransaction' => $saleTransaction, 'stockLeft' => $stockLeft, 'customer'=> $customer,'chickenSize' => $chickenSize]);
    }
}
