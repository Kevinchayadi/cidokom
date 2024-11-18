<?php

namespace App\Http\Controllers;

use App\Models\Ayam;
use App\Models\Commercial;
use App\Models\Commercial_detail;
use App\Models\Kandang;
use App\Models\Pakan;
use App\Models\Pen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\CountService;

use function Termwind\render;

class CommercialController extends Controller
{
    protected $countService;
    public function __construct(CountService $countService)
    {
        $this->countService = $countService;
    }
    public function userIndex()
    {
        $commercial = Commercial::with('commercialDetails')->get();
        return Inertia::render('user/commercial', compact('commercial'));
    }
    
    public function adminIndex()
    {
        $commercial = Commercial::with('commercialDetails','pen')->get();
        return Inertia::render('admin/commercial', compact('commercial'));
    }

    public function createCommercial()
    {
        $pen = Pen::with('kandang')
            ->whereHas('kandang', function ($query) {
                $query->where('jenis_kandang', 'commerce');
            })
            ->get()->toArray();
        return Inertia::render('user/FormCreateCommercial', ['pen' => $pen]);
    }
    public function storeCommercial(Request $request)
    {   
        // dd($request);
        $input = $request->validate([
            'id_pen' => 'required|integer|exists:pens,id',
            'entryDate' => 'required|date',
            'entry_population' => 'required|integer|min:1',
            'age' => 'required|integer|min:0',
            'inputBy'=> 'required',
        ]);
        $input['last_population'] = $input['entry_population'];

        $input['last_update'] = Carbon::now();

        Commercial::create($input);

        return redirect()->route('user.commercial')->with('success', 'berhasil membuat kandang commercial baru');
    }

    public function dailyForm($id)
    {
        $feed = Pakan::get()->toArray();
        $pen = Pen::with('kandang')->get();
        return Inertia::render('user/FormDailyCommercial', ['id_commercial' => $id, 'feed' => $feed, 'pen'=> $pen]);
    }

    public function dailyStore(Request $request)
    {
        
        $input = $request->validate([
            'id_commercial' => 'required|exists:commercials,id_commercial',
            'depreciation_die' => 'nullable|integer|min:0',
            'depreciation_afkir' => 'nullable|integer|min:0',
            'depreciation_panen' => 'nullable|integer|min:0',
            'feed' => 'required|integer',
            'feed_name' => 'required',
            'inputBy'=> 'required',
        ]);
        // dd($request);
        

        $commercial = Commercial::where('id_commercial', $input['id_commercial'])->firstOrFail();
        if (!$commercial) {
            return response()->json(['error' => 'Data Commercial tidak ditemukan'], 404);
        }
        $input['begining_population'] = $commercial->entry_population;
        $input['date'] = $commercial->date;

        $previousDetail = Commercial_detail::where('id_commercial', $input['id_commercial'])
            ->latest('created_at')
            ->first();
        if (!$previousDetail) {
            $input['last_population'] = $input['begining_population']- $input['depreciation_afkir'] - $input['depreciation_panen'];
            $input['last_population'];

        } else {
            $input['last_population'] = $previousDetail->last_population - $input['depreciation_die'] - $input['depreciation_afkir'] - $input['depreciation_panen'];
            $input['last_population'] ;
        }
        $feed = Pakan::where('id', $input['feed_name'])->firstorfail();
        $costchicken = $this->countService->costChicken($commercial->unit_cost, $previousDetail->last_population);
        $costTotal = $commercial->total_cost +  $input['feed'] * $feed->harga;
        $costUnit = $commercial->unit_cost - ($costchicken *($input['depreciation_die'] + $input['depreciation_afkir'] + $input['depreciation_panen'])) + ($input['feed'] * $feed->harga);

        Commercial_detail::create($input);

        Commercial::where('id_commercial', $input['id_commercial'])->update([
            'last_population' => $input['last_population'],
            'total_cost' => $costTotal,
            'unit_Cost' => $costUnit,
        ]);

        return redirect()->route('user.commercial')->with('success', 'berhasil membuat kandang commercial baru');
    }
}
