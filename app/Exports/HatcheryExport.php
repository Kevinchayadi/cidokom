<?php

namespace App\Exports;

use App\Models\Hatchery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HatcheryExport implements FromCollection, WithHeadings, WithMapping, WithStyles
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
        
        return $hatchery = Hatchery::with('hatcheryDetails', 'machine', 'pen')->get(); 
    }

    public function headings(): array
    {
        return [
            'Hatchery Name',
            'Code Pen From',
            'Machine Name',
            'Total Setting',
            'infertile',
            'explode',
            'Dead in Egg',
            'hatchability',
            'doc Afkir',
            'SaleAble / Chick-In'

        ];
    }

    public function map($hatchery): array
    {
        return [
            $hatchery->id_hatchery ?? 0,                           
            $hatchery->pen->code_pen ?? '',                        
            $hatchery->machine->nama_machine ?? '',                
            $hatchery->hatcheryDetails[0]->total_setting ?? 0,     
            $hatchery->hatcheryDetails[0]->infertile ?? 0,         
            $hatchery->hatcheryDetails[0]->explode ?? 0,            
            $hatchery->hatcheryDetails[0]->dead_in_egg ?? 0,        
            $hatchery->hatcheryDetails[0]->hatchability ?? 0,       
            $hatchery->hatcheryDetails[0]->doc_afkir ?? 0,          
            $hatchery->hatcheryDetails[0]->saleable ?? 0,          
        ];
    }
    public function styles(Worksheet $sheet)
    {
        
        foreach (range('A', 'J') as $column) {
            $sheet->getColumnDimension($column)->setWidth(20);
        }

        
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF808080'], 
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A1:J' . $sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);
        

        return [];
    }
}
