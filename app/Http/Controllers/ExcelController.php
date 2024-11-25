<?php

namespace App\Http\Controllers;

use App\Models\Breeding;
use App\Models\Commercial;
use App\Models\Commercial_detail;
use App\Models\Pakan;
use App\Services\countService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ExcelController extends Controller
{
    protected $countService;
    public function __construct(countService $countService)
    {
        $this->countService = $countService;
    }

    public function breedingupload(){
        return Inertia::render('upload/breeding');
    }
    public function commercialupload(){
        return Inertia::render('upload/commercial');
    }
    public function breedingstore(){
        return Inertia::render();
    }
    public function commercialstore(Request $request){
        // Validasi file Excel
        
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);
        // dd($request->file);
        // Ambil data dari Excel
        $data = \Maatwebsite\Excel\Facades\Excel::toArray([], $request->file('file'));
    
        // Ambil sheet pertama (Anda dapat menyesuaikan jika ada beberapa sheet)
        $rows = $data[0];
    
        // Abaikan baris header, mulai dari baris kedua
        $rows = array_slice($rows, 1);
       
    
        // Iterasi setiap baris dan jalankan logika `dailyStore`
        foreach ($rows as $row) {
            $input = [
                'id_commercial' => $row[0], // Sesuaikan kolom Excel
                'depreciation_die' => $row[1],
                'depreciation_afkir' => $row[2],
                'depreciation_panen' => $row[3],
                'feed' => $row[4],
                'feed_name' => $row[5],
                'inputBy' => $row[6],
            ];
    
            // Validasi data per baris
            $validated = Validator::make($input, [
                'id_commercial' => 'required|exists:commercials,id_commercial',
                'depreciation_die' => 'nullable|integer|min:0',
                'depreciation_afkir' => 'nullable|integer|min:0',
                'depreciation_panen' => 'nullable|integer|min:0',
                'feed' => 'required|integer',
                'feed_name' => 'required',
                'inputBy' => 'required',
            ])->validate();
    
            // Proses logika yang ada di `dailyStore`
            $commercial = Commercial::where('id_commercial', $validated['id_commercial'])->firstOrFail();
    
            $validated['begining_population'] = $commercial->entry_population;
            $validated['date'] = $commercial->date;
    
            $previousDetail = Commercial_detail::where('id_commercial', $validated['id_commercial'])
                ->latest('id')
                ->first();
            // dd($previousDetail);
    
            if (!$previousDetail ) {
                $validated['last_population'] = $commercial->entry_population - $validated['depreciation_die'] - $validated['depreciation_afkir'] - $validated['depreciation_panen'];
                // dd('terbaca');
            } else {
                $validated['last_population'] = $previousDetail->last_population - $validated['depreciation_die'] - $validated['depreciation_afkir'] - $validated['depreciation_panen'];
            }
            if( $validated['last_population']<0){
                return response()->json(['error' => 'Population chicken cant be minus quantity!'], 400);
            }
    
    
            $feed = Pakan::where('id', $validated['feed_name'])->firstOrFail();
            $commercial->unit_cost = (float) $commercial->unit_cost;
            $costchicken = $this->countService->costChicken($commercial->unit_cost, $previousDetail->last_population ?? $validated['begining_population']);
            $costTotal = $commercial->total_cost + $validated['feed'] * $feed->harga;
            $costUnit = $commercial->unit_cost - ($costchicken * ($validated['depreciation_die'] + $validated['depreciation_afkir'] + $validated['depreciation_panen'])) + ($validated['feed'] * $feed->harga);
    
            // Simpan detail komersial
            Commercial_detail::create($validated);
    
            // Update data komersial
            Commercial::where('id_commercial', $validated['id_commercial'])->update([
                'last_population' => $validated['last_population'],
                'total_cost' => $costTotal,
                'unit_cost' => $costUnit,
            ]);
        }
    
        return redirect()->route('commercial.upload')->with('success', 'Berhasil mengimpor data commercial.');
    }
}