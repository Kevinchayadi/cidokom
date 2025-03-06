<?php

namespace App\Exports;

use App\Models\Breeding;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BreedingExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    private $id;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function collection()
    {
        // Mengambil data Pakan
        // dd('test');
        return Breeding::with('pen','breedingDetails')->where('id_breeding',$this->id)->get(); // Anda bisa menyesuaikan query di sini
    }

    public function headings(): array
    {
        return [
            'Cost Center',
            'Pen',
            'Entry Date',
            'Last Update',
            'Female Strain',
            'Male Stain',
            'Entry Male Population',
            'Entry Female Population',
            'Last Male Population',
            'Last Female Population',
            'age',
            'female Die',
            'female Reject',
            'male Die',
            'male Reject',
            'move To',
            'female Move',
            'male Move',
            'Receive To',
            'female Receive',
            'male Receive',
            'Morning Egg',
            'Afternoon Egg',
            'Broken',
            'Abnormal',
            'Sale',
            'Total Egg',
            'feed',
            'feed name',
            'input By'
        ];
    }

    public function map($breeding): array
    {
        // dd($breeding->pen-);
        $rows = [];
        if ($breeding->breedingDetails->isNotEmpty()) {
            // Jika ada detail
            foreach ($breeding->breedingDetails as $detail) {
                $rows[] = [
                    $breeding->id_breeding,
                    $breeding->pen->code_pen ?? '', // Jika ada relasi pen, kosongkan jika tidak ada
                    $breeding->created_at->format('Y-m-d') ?? '0', // Jika entry_date kosong, set '0'
                    $breeding->updated_at->format('Y-m-d') ?? '0', // Jika updated_at kosong, set '0'
                    $breeding->code_ayam_jantan ?? '0', // Jika code_ayam_jantan kosong, set '0'
                    $breeding->code_ayam_betina ?? '0', // Jika code_ayam_betina kosong, set '0'
                    $breeding->jumlah_jantan ?? 0, // Jika jumlah_jantan kosong, set 0
                    $breeding->jumlah_betina ?? 0, // Jika jumlah_betina kosong, set 0
                    $detail->last_male ?? 0, // Jika last_male kosong, set 0
                    $detail->last_female ?? 0, // Jika last_female kosong, set 0
                    $breeding->age ?? 0, // Jika age kosong, set 0
                    $detail->female_die ?? 0, // Jika female_die kosong, set 0
                    $detail->female_reject ?? 0, // Jika female_reject kosong, set 0
                    $detail->male_die ?? 0, // Jika male_die kosong, set 0
                    $detail->male_reject ?? 0, // Jika male_reject kosong, set 0
                    $detail->move_to ?? 0, // Jika move_to kosong, set 0
                    $detail->total_female_move ?? 0, // Jika total_female_move kosong, set 0
                    $detail->total_male_move ?? 0, // Jika total_male_move kosong, set 0
                    $detail->receive_from ?? 0, // Jika receive_from kosong, set 0
                    $detail->total_female_receive ?? 0, // Jika total_female_receive kosong, set 0
                    $detail->total_male_receive ?? 0, // Jika total_male_receive kosong, set 0
                    $detail->egg_morning ?? 0, // Jika egg_morning kosong, set 0
                    $detail->egg_afternoon ?? 0, // Jika egg_afternoon kosong, set 0
                    $detail->broken ?? 0, // Jika broken kosong, set 0
                    $detail->abnormal ?? 0, // Jika abnormal kosong, set 0
                    $detail->sale ?? 0, // Jika sale kosong, set 0
                    $detail->total_egg ?? 0, // Jika total_egg kosong, set 0
                    $detail->feed ?? 0, // Jika feed kosong, set 0
                    $detail->feed_name ?? '0', // Jika feed_name kosong, set '0'
                    $detail->input_by ?? '0', // Jika input_by kosong, set '0'
                ];
            }
        } else {
            // Jika tidak ada detail, tambahkan satu row kosong atau data default
            $rows[] = [
                $breeding->id_breeding,
                $breeding->pen->code_name ?? '', // Jika ada relasi pen
                $breeding->entry_date->format('Y-m-d'),
                $breeding->updated_at->format('Y-m-d'),
                $breeding->code_ayam_jantan,
                $breeding->code_ayam_betina,
                $breeding->jumlah_jantan,
                $breeding->jumlah_betina,
                null,  // last_male (kosong)
                null,  // last_female (kosong)
                $breeding->age,
                null,  // female_die (kosong)
                null,  // female_reject (kosong)
                null,  // male_die (kosong)
                null,  // male_reject (kosong)
                null,  // move_to (kosong)
                null,     // total_female_move
                null,     // total_male_move
                null,  // receive_from (kosong)
                null,     // total_female_receive
                null,     // total_male_receive
                null,     // egg_morning
                null,     // egg_afternoon
                null,     // broken
                null,     // abnormal
                null,     // sale
                null,     // total_egg
                null,     // feed
                null,  // feed_name (kosong)
                null,  // input_by (kosong)
            ];
        }
        // dd($rows);
        return $rows;
    }
    public function styles(Worksheet $sheet)
    {
        // Mengatur lebar kolom (A hingga kolom AB sesuai header)
        foreach (range('A', 'Z') as $column) {
            $sheet->getColumnDimension($column)->setWidth(20);
        }
        
        // Menambahkan kolom AA dan AB secara terpisah
        $additionalColumns = ['AA', 'AB','AC','AD'];
        foreach ($additionalColumns as $column) {
            $sheet->getColumnDimension($column)->setWidth(20);
        }

        // Gaya untuk header
        $sheet->getStyle('A1:AD1')->applyFromArray([
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

        // Gaya untuk seluruh data (center alignment)
        $sheet->getStyle('A2:AD' . $sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Format kolom tanggal (Entry Date dan Last Update)
        // $sheet->getStyle('AC2:AD' . $sheet->getHighestRow())->getNumberFormat()->setFormatCode('yyyy-mm-dd');

        return [];
    }
}
