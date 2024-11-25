<?php

namespace App\Imports;

use App\Models\Commercial_detail;
use App\Models\CommercialDetail;
use App\Models\Pen;
use App\Models\Kandang;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class CommercialDetailImport implements ToModel
{
    public function model(array $row)
    {
    
        return new Commercial_detail([
            'id_pen' => $row[1], // ID Pen dari Excel
            'entryDate' => Carbon::parse($row[2]), // Tanggal Masuk
            'entry_population' => $row[3], // Populasi Masuk
            'last_population' => $row[3], // Populasi Awal = Masuk
            'age' => $row[4], // Umur
            'total_cost' => $row[5], // Biaya Total
            'unit_cost' => $row[6], // Biaya per Unit
            'inputBy' => $row[7], // User yang input
            'status' => $row[8], // Status
        ]);
    }
}
