<?php

namespace App\Services;

use App\Models\Pakan;

class countService
{
    public function dailyBreeding(Pakan $pakan , int $food, int $egg):float{
        if($egg === 0)return 0.0;
        $cost = $pakan->harga * $food;
        $eggCost = $cost/$egg;
        return $eggCost;
    }
    public function costegg(Pakan $pakan , int $food, int $egg):float{
        if($egg === 0)return 0.0;
        $cost = $pakan->harga * $food;
        $eggCost = $cost/$egg;
        return $eggCost;
    }
    public function costChicken(float $current, int $total){
        $cost = $current / $total;
        // dd($cost);
        return $cost;
    }
}
