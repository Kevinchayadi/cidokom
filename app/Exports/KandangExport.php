<?php

namespace App\Exports;

use App\Models\Kandang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KandangExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Mengambil data Pakan
        return Kandang::all(); // Anda bisa menyesuaikan query di sini
    }

    public function headings(): array
    {
        return [
            'Cage Name',
            'Cage Location',
            'Cage Type',
        ];
    }

    public function map($kandang): array
    {
        return [
            $kandang->nama_kandang,
            $kandang->lokasi_kandang,
            $kandang->jenis_kandang,
        ];
    }
    public function styles(Worksheet $sheet)
    {
        // Mengatur lebar kolom
        foreach (range('A', 'C') as $column) {
            $sheet->getColumnDimension($column)->setWidth(20);
        }

        // Gaya untuk header
        $sheet->getStyle('A1:C1')->applyFromArray([
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

        $sheet->getStyle('A1:C' . $sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getStyle('G2:C' . $sheet->getHighestRow())->getNumberFormat()->setFormatCode('yyyy-mm-dd');

        return [];
    }
    
}
