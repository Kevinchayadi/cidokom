<?php

namespace App\Http\Controllers;

use App\Models\ChickenSize;
use App\Models\CustHandle;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\saleTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

use function PHPUnit\Framework\isNull;

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
        $isSale = saleTransaction::where('tanggal_penjualan', $sale['tanggal_Penjualan'])->where('id_pembeli', $sale['id_pembeli'])->first();
        if ($isSale) {
            return back()->withErrors('Customer is already at This date!!');
        }
        $ayam = ChickenSize::find($sale['id_ayam']);
        $checkSales = CustHandle::whereHas('customers', function ($query) use ($sale) {
            $query->where('id', $sale['id_pembeli']);
        })->first();

        $sale['harga'] = $ayam->harga;
        $sale['diskon'] = $checkSales->diskon;

        $sale['total_harga'] = ($sale['harga'] - $sale['diskon']) * $sale['jumlah_ayam'];

        try {
            // dd($sale);
            DB::beginTransaction();
            // $sale = saleTransaction::create($sale);

            saleTransaction::create($sale);
            DB::commit();
            return redirect()->route('admin.sales')->with('success', 'Successfully Create New Sales!!');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->withErrors('Failed Create this Data!');
        }
    }
    function editSales(Request $request, $id)
    {
        $input = $request->validate([
            'jumlah_ayam' => 'required|integer|min:1',
            'id_ayam' => 'required|integer|min:1',
            'diskon' => 'required|numeric',
            'description' => 'nullable|string|max:255',
        ]);

        $sale = saleTransaction::find($id);
        $ayam = ChickenSize::find($sale['id_ayam']);
        $input['harga'] = $ayam->harga;

        // dd($input['jumlah_ayam']);
        $input['total_harga'] = ($input['harga'] - $input['diskon']) * $input['jumlah_ayam'];
        try {
            DB::beginTransaction();
            saleTransaction::where('id', $id)->update($input);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->withErrors('Failed to Update This data!');
        }

        return redirect()->route('admin.sales')->with('success', 'Update Sales Successfully!');
    }

    function salesIndex(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        $query = saleTransaction::with(['Customers.sales', 'ChickenSize']);
        $startDate=null;
        $endDate=null;

        if (!empty($start) && !empty($end)) {
            $startDate = Carbon::parse($start)->startOfDay();
            $endDate = Carbon::parse($end)->endOfDay();
            $query->whereBetween('tanggal_Penjualan', [$startDate, $endDate]);
        }

        $saleTransaction = $query->orderByDesc('tanggal_Penjualan')->get();

        $sale = Sale::get();
        $totalQtyTransactions = SaleTransaction::sum('jumlah_ayam');
        $totalQtySales = Sale::sum('qty');
        $stockLeft = $totalQtySales - $totalQtyTransactions;
        $customer = Customer::orderBy('nama_pelanggan')->get();
        $chickenSize = ChickenSize::get();

        $start = $startDate!=null?Carbon::parse($startDate)->format('Y-m-d'):null;
        $end = $endDate!=null?Carbon::parse($endDate)->format('Y-m-d'):null;

        return Inertia::render('admin/sales/sales', ['sale' => $sale, 'saleTransaction' => $saleTransaction, 'stockLeft' => $stockLeft, 'customer' => $customer, 'chickenSize' => $chickenSize, 'start'=>$start, 'end' =>$end]);
    }
}
