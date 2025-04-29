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
use App\Models\Pen;
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

        $breedingPens = Pen::with('kandang')
            ->whereHas('kandang', function ($query) {
                $query->where('jenis_kandang', 'breeding');
            })
            ->get();
        $breeds = [];

        $totalBreeding = 0;
        $totalDeath = 0;
        foreach($breedingPens as $pens){
            $data=[
                'id_pen'=> $pens->id,
                'code_pen' => $pens->code_pen,
                'male' =>0,
                'female' =>0,
                'dead' => 0,
            ];
            $breeds[] = $data;
        }


        foreach ($breeding as $item) {
            $lastMale = $item->breedingDetails[0]->last_male ?? $item->jumlah_jantan;
            $lastFemale = $item->breedingDetails[0]->last_female ?? $item->jumlah_betina;
            $temp = 0;
            $totalBreeding += $lastMale + $lastFemale;
            foreach ($item->breedingDetails as $data) {
                $maleDead = $data->male_die ?? 0;
                $femaleDead = $data->female_die ?? 0;
                $totalDeath += $maleDead + $femaleDead;
                $temp += $maleDead + $femaleDead;
            }
            foreach ($breeds as &$breed) {
                if ($item->id_pen == $breed['id_pen']) {
                    $breed['male'] = $lastMale;
                    $breed['female'] = $lastFemale;
                    $breed['dead'] = $temp;
                }
            }
            // $totalBreeding += $lastMale + $lastFemale;
            // $item->live = $lastMale + $lastFemale;

            // foreach ($item->breedingDetails as $data) {
            //     $maleDead = $data->male_die ?? 0;
            //     $femaleDead = $data->female_die ?? 0;
            //     $totalDeath += $maleDead + $femaleDead;
            //     $item->Death += $maleDead + $femaleDead;
            // }
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

        return Inertia::render('admin/Dashboard', compact('totalAfkir', 'totalBreeding', 'totalDeath', 'afkir', 'breeds', 'hatchery'));
    }
    function Summary(Request $request)
    {
        $firstInputed = $request->input('first');

        $endInputed = $request->input('end');
        
        $latestBreedingDetail = Breeding_detail::latest('created_at')->first();
        if (is_null($firstInputed)) {
            $startDate = Carbon::parse($latestBreedingDetail->created_at)->format('Y-m-d H:i:s');
        } else {
            $startDate = Carbon::parse($firstInputed)->startOfDay()->format('Y-m-d H:i:s');
        }
        if (is_null($endInputed)) {
            $endDate = Carbon::parse($latestBreedingDetail->created_at)->setTime(23, 59)->format('Y-m-d H:i:s');
        } else {
            $endDate = Carbon::parse($endInputed)->startOfDay()->setTime(23, 59)->format('Y-m-d H:i:s');
        }
        // dd($startDate, $endDate);

        $breedingDetails=[];
        $breedingPens = Pen::with('kandang')
        ->whereHas('kandang', function ($query) {
            $query->where('jenis_kandang', 'breeding');
        })
        ->get();
        
        foreach ($breedingPens as $breed) {
            // dd($breed->id);
            $breedingDetail = Breeding_detail::whereHas('breeding', function ($query) use ($breed) {
                $query->where('id_pen', $breed->id);
            })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
            $lastDetail = Breeding_detail::whereHas('breeding', function ($query) use ($breed) {
                $query->where('id_pen', $breed->id);
            })
            ->whereDate('created_at', $startDate)
            ->latest('created_at')
            ->first();
            if($breedingDetail->isEmpty()){
                $detailBreed = [
                    'code_pen'=>$breed->code_pen,
                    'male_come' => 0,
                    'female_come' => 0,
                    'male_die' => 0,
                    'female_die' => 0,
                    'male_out' => 0,
                    'female_out' => 0,
                    'last_male' => 0,
                    'last_female' => 0,
                    'egg' =>0,
                    'broken' =>0,
                    'abnormal'=>0,
                    'HE'=>0,
                    'cost'=>0,
                    'last_male'=>0,
                    'last_female'=>0,
                ];
            }else{
                $detailBreed = [
                    'code_pen'=>$breed->code_pen,
                    'male_come' => $breedingDetail->sum('total_male_receive'),
                    'female_come' => $breedingDetail->sum('total_male_receive'),
                    'male_die' => $breedingDetail->sum('male_die'),
                    'female_die' => $breedingDetail->sum('female_die'),
                    'male_out' => $breedingDetail->sum('total_male_out'),
                    'female_out' => $breedingDetail->sum('total_male_out'),
                    'last_male' => $breedingDetail->sum('last_male'),
                    'last_female' => $breedingDetail->sum('last_female'),
                    'egg' => $breedingDetail->sum('egg_morning') + $breedingDetail->sum('egg_afternoon'),
                    'broken' => $breedingDetail->sum('broken'),
                    'abnormal' => $breedingDetail->sum('abnormal'),
                    'HE' => $breedingDetail->sum('total_egg'),
                    'cost' => $breedingDetail->sum('cost_total'),
                    'last_male' => $lastDetail->last_male ?? 0,
                    'last_female' => $lastDetail->last_female ?? 0,
                ];
            }

            $breedingDetails[] = $detailBreed;

            if (empty($breedingDetail)) {
                $test = false;
            }
        }

    
        $commercialDetails = [];

        $commercePens = Pen::with('kandang')
        ->whereHas('kandang', function ($query) {
            $query->where('jenis_kandang', 'commerce');
        })
        ->get();
        
        foreach ($commercePens as $commercial) {
            $commercialDetail = commercial_detail::whereHas('commercial', function ($query) use ($commercial) {
                $query->where('id_pen', $commercial->id);
            })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
            $lastDetail2 = Commercial_detail::whereHas('commercial', function ($query) use ($commercial) {
                $query->where('id_pen', $commercial->id);
            })
            ->whereDate('created_at', $startDate)
            ->latest('created_at')
            ->first();
            
            if($commercialDetail->isEmpty()){
                $detailcommercial = [
                    'code_pen'=>$commercial->code_pen,
                    'die' => 0,
                    'sale' => 0,
                    'come' => 0,
                    'out' => 0,
                    'feed' => 0,
                    'last_stock'=> 0,
                ];
            }else{
                $detailcommercial = [
                    'code_pen'=>$commercial->code_pen,
                    'die' => $commercialDetail->sum('depreciation_die'),
                    'sale' => $commercialDetail->sum('depreciation_panen'),
                    'come' => $commercialDetail->sum('total_move'),
                    'out' => $commercialDetail->sum('total_move'),
                    'feed' => $commercialDetail->sum('feed'),
                    'last_stock'=> $lastDetail2->last_population??0,
                ];
            }

            $commercialDetails[] = $detailcommercial;
        }
        // dd([$breedingDetails, $commercialDetails]);
        $endDate = Carbon::parse($endDate)->startOfDay()->setTime(23, 50)->format('Y-m-d');
        $startDate = Carbon::parse($startDate)->startOfDay()->setTime(23, 50)->format('Y-m-d');

        return Inertia::render('admin/summary', [
            'breeding' => $breedingDetails,
            'commercial' => $commercialDetails,
            'startDate'=>$startDate,
            'endDate'=>$endDate,
        ]);
    }

    function salesSummary(Request $request)
    {
        // Ambil parameter jumlah dari request, jika tidak ada, set default 30
        $jumlah = $request->input('jumlah', 7);

        // Ambil transaksi dengan status 'pending' dalam periode yang ditentukan
        $saleTransactions = SaleTransaction::where('status', 'pending')
            ->where('tanggal_Penjualan', '>=', Carbon::now()->subDays(7))
            ->get();

        $dailySales = [];

        foreach ($saleTransactions as $transaction) {
            $date = Carbon::parse($transaction->tanggal_Penjualan)->format('Y-m-d');

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
        usort($dailySales, function ($a, $b) {
            return strtotime($a['date']) <=> strtotime($b['date']);
        });

        // Customer tanpa transaksi terbaru dalam jumlah hari yang ditentukan
        $customersWithoutRecentSales = Customer::with('sales')
            ->whereDoesntHave('salesTransaction', function ($query) use ($jumlah) {
                $query->where('created_at', '>=', Carbon::now()->subDays($jumlah));
            })
            ->orderBy('nama_pelanggan')
            ->get()->toArray();

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
            ->sortBy('nama_pelanggan')->toArray();
        // dd([$dailySales,$customersWithoutRecentSales,$customersWithRecentSales->toArray()]);
        // Kirim data ke frontend menggunakan Inertia
        return Inertia::render('admin/sales/Summary', [
            'dailySales' => $dailySales,
            'recentCust' => array_values($customersWithRecentSales),
            'passiveCust' => array_values($customersWithoutRecentSales),
        ]);
    }
}
