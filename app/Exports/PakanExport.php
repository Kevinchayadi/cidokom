<?php

namespace App\Exports;

use App\Models\Pakan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PakanExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Mengambil data Pakan
        return Pakan::all(); // Anda bisa menyesuaikan query di sini
    }

    public function headings(): array
    {
        return [
            'Name',
            'Type Feed',
            'Quantity',
            'Price Feed',
        ];
    }

    public function map($pakan): array
    {
        return [
            $pakan->name,
            $pakan->type,
            $pakan->quantity,
            $pakan->price,
        ];
    }
    public function styles(Worksheet $sheet)
    {
        // Mengatur lebar kolom
        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setWidth(20);
        }

        // Gaya untuk header
        $sheet->getStyle('A1:H1')->applyFromArray([
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

        $sheet->getStyle('A1:H' . $sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getStyle('G2:H' . $sheet->getHighestRow())->getNumberFormat()->setFormatCode('yyyy-mm-dd');

        return [];
    }
}

