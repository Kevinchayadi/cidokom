<?php

namespace App\Http\Controllers;

use App\Models\Afkir;
use App\Models\Breeding;
use App\Models\Breeding_detail;
use App\Models\Commercial;
use App\Models\Commercial_detail;
use App\Models\Customer;
use App\Models\Hatchery;
use App\Models\Pakan;
use App\Models\Sale;
use App\Models\saleTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    function userIndex()
    {
        return Inertia::render('user/Dashboard');
    }

    function adminIndex()
    {
        $breeding = Breeding::with('breedingDetails', 'pen')
            ->where('status', 'active')
            ->with([
                'breedingDetails' => function ($query) {
                    $query->where('created_at', '>=', Carbon::now()->subDays(30))->latest('created_at');
                },
            ])
            ->get();

        $totalBreeding = 0;
        $totalDeath = 0;

        foreach ($breeding as $item) {
            $item->live = 0;
            $item->Death = 0;

            $lastMale = $item->breedingDetails[0]->last_male ?? $item->jumlah_jantan;
            $lastFemale = $item->breedingDetails[0]->last_female ?? $item->jumlah_betina;
            $totalBreeding += $lastMale + $lastFemale;
            $item->live = $lastMale + $lastFemale;

            foreach ($item->breedingDetails as $data) {
                $maleDead = $data->male_die ?? 0;
                $femaleDead = $data->female_die ?? 0;
                $totalDeath += $maleDead + $femaleDead;
                $item->Death += $maleDead + $femaleDead;
            }
        }

        $afkir = Afkir::with('pen')
            ->whereHas('pen', function ($query) {
                $query->where('code_pen', 'AFKIR-BRD');
            })
            ->latest('created_at')
            ->first();

        if ($afkir) {
            $totalAfkir = $afkir->male + $afkir->female;
            $totalDeath += $afkir->male_die + $afkir->female_die;
        } else {
            $totalAfkir = 0;
        }
        $hatchery = Hatchery::with('hatcheryDetails')->whereNotNull('pull_chicken_date')->latest('created_at')->take(4)->get();

        return Inertia::render('admin/Dashboard', compact('totalAfkir', 'totalBreeding', 'totalDeath', 'afkir', 'breeding', 'hatchery'));
    }
    function Summary(Request $request)
    {
        $dateInput = $request->input('date');

        $breedings = Breeding::where('status', 'active')->get();
        $breedingDetails = [];
        $test = true;
        $TotalEgg = Breeding_detail::where('status', 'active')->sum('total_egg');
        $pakan = Pakan::get();
        $latestBreedingDetail = Breeding_detail::latest('created_at')->first();
        if (is_null($dateInput)) {
            $date = Carbon::parse($latestBreedingDetail->created_at)->format('Y-m-d');
        } else {
            $date = Carbon::parse($dateInput)->startOfDay();
        }
        foreach ($breedings as $item) {
            $breedingDetail = Breeding_detail::where('id_breeding', $item->id_breeding)->whereDate('created_at', $date)->latest('created_at')->first();
            if($breedingDetail !=null){

                $total_feed = Breeding_detail::where('id_breeding', $item->id_breeding)->sum('feed');
                $total_male_sale = Breeding_detail::where('id_breeding', $item->id_breeding)->sum('male_reject');
                $total_female_sale = Breeding_detail::where('id_breeding', $item->id_breeding)->sum('female_reject');
                $last_breed = Breeding_detail::where('id_breeding', $item->id_breeding)->latest('created_at')->first();
                $breedingDetail->FCR = number_format(
                    $total_feed / ($total_male_sale + $total_female_sale + ($last_breed->last_male ?? 0) + ($last_breed->last_female ?? 0)),
                    2, // Jumlah digit di belakang koma
                    '.', // Pemisah desimal
                    ''  // Pemisah ribuan (opsional, bisa diabaikan)
                );

            }

            $breedingDetails[] = $breedingDetail;

            if (empty($breedingDetail)) {
                $test = false;
            }
        }

        $breedingDetail = Breeding_detail::where('status', 'active')->get();

        $commercials = Commercial::where('status', 'active')->get();
        $commercialDetails = [];

        foreach ($commercials as $com) {
            $commercialDetail = Commercial_detail::where('id_commercial', $com->id_commercial)->whereDate('created_at', $date)->latest('created_at')->first();
            if($commercialDetail != null){
                $total_feed = Commercial_detail::where('id_commercial', $com->id_commercial)->sum('feed');
                $total_sale = Commercial_detail::where('id_commercial', $com->id_commercial)->sum('depreciation_panen');
                $last_commercial = Commercial_detail::where('id_commercial', $com->id_commercial)->latest('created_at')->first();
                $commercialDetail->FCR = number_format( $total_feed/($total_sale + $last_commercial->last_population??0),
                2, // Jumlah digit di belakang koma
                '.', // Pemisah desimal
                ''  // Pemisah ribuan (opsional, bisa diabaikan)
            );

            }
            $commercialDetails[] = $commercialDetail;
        }
        // dd([$breedingDetails, $commercialDetails]);

        return Inertia::render('admin/summary', [
            'breeding' => $breedingDetails,
            'commercial' => $commercialDetails,
            'total_egg' => $TotalEgg,
            'pakan' => $pakan,
        ]);
    }

    function salesSummary(Request $request)
    {
        // Ambil parameter jumlah dari request, jika tidak ada, set default 30
        $jumlah = $request->input('jumlah', 30);

        // Ambil transaksi dengan status 'pending' dalam periode yang ditentukan
        $saleTransactions = SaleTransaction::where('status', 'pending')
            ->where('created_at', '>=', Carbon::now()->subDays($jumlah))
            ->get();

        $dailySales = [];

        foreach ($saleTransactions as $transaction) {
            $date = Carbon::parse($transaction->created_at)->format('Y-m-d');

            if (isset($dailySales[$date])) {
                $dailySales[$date] += $transaction->jumlah_ayam;
            } else {
                $dailySales[$date] = $transaction->jumlah_ayam;
            }
        }

        $dailySales = array_map(
            function ($totalQty, $date) {
                return [
                    'date' => $date,
                    'total_qty' => $totalQty,
                ];
            },
            $dailySales,
            array_keys($dailySales),
        );

        // Customer tanpa transaksi terbaru dalam jumlah hari yang ditentukan
        $customersWithoutRecentSales = Customer::with('sales')
            ->whereDoesntHave('salesTransaction', function ($query) use ($jumlah) {
                $query->where('created_at', '>=', Carbon::now()->subDays($jumlah));
            })
            ->orderBy('nama_pelanggan')
            ->get();

        // Customer dengan transaksi terbaru dalam jumlah hari yang ditentukan
        $customersWithRecentSales = Customer::whereHas('salesTransaction', function ($query) use ($jumlah) {
            $query->where('created_at', '>=', Carbon::now()->subDays($jumlah));
        })
            ->with([
                'salesTransaction' => function ($query) use ($jumlah) {
                    $query->where('created_at', '>=', Carbon::now()->subDays($jumlah));
                },
            ])
            ->get()
            ->map(function ($customer) {
                $customer->total_ayam = $customer->salesTransaction->sum('jumlah_ayam');
                $customer->total_harga = $customer->salesTransaction->sum('total_harga');
                return $customer;
            })
            ->sortBy('nama_pelanggan');
        // dd([$dailySales,$customersWithoutRecentSales,$customersWithRecentSales]);
        // Kirim data ke frontend menggunakan Inertia
        return Inertia::render('admin/sales/Summary', [
            'dailySales' => $dailySales,
            'recentCust' => $customersWithRecentSales,
            'passiveCust' => $customersWithoutRecentSales,
        ]);
    }
}
