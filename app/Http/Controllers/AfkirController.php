<?php

namespace App\Http\Controllers;

use App\Models\Afkir;
use App\Models\Pen;
use App\Services\countService;
use App\Services\moveService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AfkirController extends Controller
{

    protected $countService;
    protected $moveService;
    public function __construct(countService $countService, moveService $moveService)
    {
        $this->countService = $countService;
        $this->moveService = $moveService;
    }
    function afkir(){
        $afkir = Pen::whereHas('kandang', function($query) {
            $query->where('jenis_kandang', 'afkir');
        })->with('kandang')->get();
        // dd($afkir);
        return  Inertia::render('user/afkir', ['afkir'=>$afkir]);
    }
    function dailyAfkirForm($id){
        $pen = Pen::where('id', $id)->first();
        $pen = Pen::get();
        // dd($pen);
        // if($pen->code_pen === 'AFKIR-BRD' || $pen->code_pen === 'KARANTINA-BRD' ){
        //     $pen= Pen::whereHas('kandang', function($query) {
        //         $query->where('jenis_kandang', 'breeding');
        //     })->get();
        //return  Inertia::render('user/FormDailyAfkirBRD', ['id'=>$id, 'pen'=>$pen]);
        // }
        // if($pen->code_pen === 'AFKIR-CMR' || $pen->code_pen === 'KARANTINA-CMR'){
        //     $pen= Pen::whereHas('kandang', function($query) {
        //         $query->where('jenis_kandang', 'commercial');
        //     })->get();
        // return  Inertia::render('user/FormDailyAfkirCMR', ['id'=>$id, 'pen'=>$pen]);
            
        // }
        return  Inertia::render('user/FormDailyAfkirBRD', ['id'=>$id, 'pen'=>$pen]);
    }
    function storeAfkirForm(Request $request, $id){
        $data = Afkir::where('id_pen', $id)
    ->whereNotNull('male_cost')
    ->orWhereNotNull('female_cost') // Use orWhereNotNull for female_cost
    ->first();
        $input = $request->validate([
            'feed_male' => 'required|numeric|min:0',
            'feed_female' => 'required|numeric|min:0',
            'id_destination'=> 'nullable',
            'male_out' => 'nullable|numeric|min:0',
            'female_out' => 'nullable|numeric|min:0',
        ]);
        if($input['id_destination'] != 0){
            $datas = $this->moveService->moveTable($input['id_destination'], $id, $data->male_cost + $data->female_cost, $data->male,$data->female, $input['male_out'], $input['female_out']);
            $new_cost = $datas['new_cost']/($input['male_out']+$input['female_out']);

            $input['male_cost'] =  $data->male_cost - ($new_cost * $input['male_out']);
            $input['female_cost'] =  $data->female_cost - ($new_cost * $input['female_out']);
            
            $input['male'] = $datas['last_male'];
            $input['female'] = $datas['last_female'];
        }
        // Mendapatkan pen berdasarkan ID yang diberikan
        $input['id_pen'] = $id;
    
        
        Afkir::create($input);
        return back()->with('success', 'daily report added!');
    }


    
    function adminIndex(){
        $afkir = Afkir::where('id_pen', ['AFKIR-BRD','AFKIR-CMR'])->get();
        return Inertia::render('admin/afkir', ['afkir'=>$afkir]);
    }

    function adminKarantinaIndex(){
        $afkir = Afkir::where('id_pen', ['KARANTINA-BRD','KARANTINA-CMR'])->get();
        return Inertia::render('admin/karantina', ['afkir'=>$afkir]);
    }
}
