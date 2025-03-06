<?php

namespace App\Exports;

use App\Models\Commercial;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CommercialExport implements FromCollection, WithHeadings, WithMapping, WithStyles
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
        
        return Commercial::with('commercialDetails', 'pen')->where('id_commercial',$this->id)->get(); 
        
    }

    public function headings(): array
    {
        return [
            'Commercial Name',
            'Pen Code',
            'Entry Population',
            'Last Population',
            'die Chicken',
            'sale Chicken',
            'total Move',
            'move To',
            'total Receive',
            'Receive From',
            'Feed',
            'Feed Name'


        ];
    }

    public function map($commercial): array
    {
        // dd($commercial->commercialDetails);
        $rows = [];
        if ($commercial->commercialDetails->isNotEmpty()) {
            foreach ($commercial->commercialDetails as $detail) {
                $rows[] = [
                    $commercial->id_commercial,
                    $commercial->pen->code_pen ?? '',  
                    $detail->begining_population ?? 0,  
                    $detail->last_population ?? 0,      
                    $detail->depreciation_die ?? 0,     
                    $detail->depreciation_panen ?? 0,   
                    $detail->total_move ?? 0,           
                    $detail->move_to ?? '',             
                    $detail->total_receive ?? 0,        
                    $detail->receive_from ?? '',        
                    $detail->feed ?? 0,                 
                    $detail->feed_name ?? '',           
                ];
            }
            
        } else {
            
            $rows[] = [
                $commercial->id_commercial,
                $commercial->pen->code_pen,
                null,  
                null,  
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
            ];
        }
        return $rows;
    }
    public function styles(Worksheet $sheet)
    {
        
        foreach (range('A', 'L') as $column) {
            $sheet->getColumnDimension($column)->setWidth(20);
        }

        
        $sheet->getStyle('A1:L1')->applyFromArray([
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

        $sheet->getStyle('A1:L' . $sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);
        // $sheet->getStyle('G2:H' . $sheet->getHighestRow())->getNumberFormat()->setFormatCode('yyyy-mm-dd');

        return [];
    }
}
