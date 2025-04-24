<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function PHPUnit\Framework\isNull;

class ResidentController extends Controller
{
    function storeResident(Request $request)
    {
        $input = $request->validate([
            'nama_Resident' => 'required',
            'tipe' => 'required|string'
        ]);
        $check = Resident::where('nama_Resident' , $input['nama_Resident'])->where('tipe', $input['tipe'])->first();
        if($check){
            return back()->withErrors('Data Already Exist!');
        }
        
        try {
            Resident::create($input);
            return redirect()->route('admin.Residence')->with('success', 'berhasil membuat Residence baru!');;
        } catch (\Throwable $th) {
            return back()->withErrors('Failed to create Residence');
        }
    }
    function editResident(Request $request, $id)
    {
        $input = $request->validate([
            'tipe_Resident' => 'required',
            'tipe' => 'required|string'
        ]);
        
        try {
            Resident::where('id',$id)->update($input);
            return redirect()->route('admin.resident')->with('success', 'berhasil membuat Residence baru!');
        } catch (\Throwable $th) {
            return back()->withErrors('Failed to update Residence');
        }
    }

    function ResidentIndex()
    {
        $resident = Resident::with('Customers')->get();
        // dd($resident);
        return Inertia::render('admin/sales/Residence', compact('resident'));
        
    }
}
