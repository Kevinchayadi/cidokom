<?php

namespace App\Exports;

use App\Models\Ayam;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ChickenExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Mengambil data Pakan
        return Ayam::all(); // Anda bisa menyesuaikan query di sini
    }

    public function headings(): array
    {
        return [
            'Code Ayam',
            'Strain Male',
            'Strain Female',
            
        ];
    }

    public function map($ayam): array
    {
        return [
            $ayam->code_ayam,
            $ayam->strain_male,
            $ayam->strain_female,
           
        ];
    }
    public function styles(Worksheet $sheet)
    {
        // Mengatur lebar kolom
        foreach (range('A', 'D') as $column) {
            $sheet->getColumnDimension($column)->setWidth(20);
        }

        // Gaya untuk header
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF808080'], // Warna abu-abu
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A1:D' . $sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);
        // $sheet->getStyle('G2:H' . $sheet->getHighestRow())->getNumberFormat()->setFormatCode('yyyy-mm-dd');

        return [];
    }
}
