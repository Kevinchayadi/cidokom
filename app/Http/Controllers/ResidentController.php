<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResidentController extends Controller
{
    function storeResident(Request $request)
    {
        $input = $request->validate([
            'nama_Resident' => 'required',
            'tipe' => 'required|string'
        ]);
        // dd($request);
        
        try {
            Resident::create($input);
            return redirect()->route('admin.Residence')->with('success', 'berhasil membuat Residence baru!');;
        } catch (\Throwable $th) {
            return back()->withErrors('Failed to create Resident');
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
            return back()->withErrors('Failed to update Resident');
        }
    }

    function ResidentIndex()
    {
        $resident = Resident::with('Customers')->get();
        // dd($resident);
        return Inertia::render('admin/sales/Residence', compact('resident'));
        
    }
}
