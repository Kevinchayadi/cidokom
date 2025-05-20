<?php

namespace App\Http\Controllers;

use App\Models\ChickenSize;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\saleTransaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public static function transactionSales(Request $request)
    {
        // dd('test');
        $start = $request->input('start');
        $end = $request->input('end');
        $query = saleTransaction::with(['Customers.sales', 'Customers.Residence']);
        $startDate = null;
        $endDate = null;

        if (!empty($start) && !empty($end)) {
            $startDate = Carbon::parse($start)->startOfDay();
            $endDate = Carbon::parse($end)->endOfDay();
            $query->whereBetween('tanggal_Penjualan', [$startDate, $endDate]);
        }

        $saleTransactions = $query->orderByDesc('tanggal_Penjualan')->get();
        $grouped = $saleTransactions->groupBy(function ($item) {
            return optional($item->customers->residence)->nama_Resident ?? 'Tanpa Residence';
        });

        $start = $startDate != null ? Carbon::parse($startDate)->format('Y-m-d') : null;
        $end = $endDate != null ? Carbon::parse($endDate)->format('Y-m-d') : null;

        $pdf = Pdf::loadView('salesDownload', [
            'groupedTransactions' => $grouped,
            'start' => $start,
            'end' => $end,
        ]);

        return $pdf->stream('transaction_sales.pdf');
    }
    public static function chickensales(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        $startDate = !empty($start) ? Carbon::parse($start)->startOfDay() : null;
        $endDate = !empty($end) ? Carbon::parse($end)->endOfDay() : null;
        $chickenSizes = ChickenSize::withSum(
            [
                'saleTransactions as total_qty' => function ($query) use ($startDate, $endDate) {
                    if ($startDate && $endDate) {
                        $query->whereBetween('tanggal_Penjualan', [$startDate, $endDate]);
                    }
                },
            ],
            'jumlah_ayam',
        )
            ->has('saleTransactions') // hanya yang ada transaksi
            ->get();

        $start = $startDate != null ? Carbon::parse($startDate)->format('Y-m-d') : null;
        $end = $endDate != null ? Carbon::parse($endDate)->format('Y-m-d') : null;

        $pdf = Pdf::loadView('chickenSaleDownload', [
            'ChckenType' => $chickenSizes,
            'start' => $start,
            'end' => $end,
        ]);

        return $pdf->download('transaction_sales.pdf');
    }
}
