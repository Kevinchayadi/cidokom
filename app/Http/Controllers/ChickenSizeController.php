<?php

namespace App\Http\Controllers;

use App\Models\ChickenSize;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChickenSizeController extends Controller
{
    function storeChicken(Request $request)
    {
        
        $input = $request->validate([
            'size' => 'required|string',
            'harga' => 'required|numeric'
        ]);
        
        try {
            ChickenSize::create($input);
            return redirect()->route('admin.ChickenSize')->with('success','Successfully created new chicken size!');
        } catch (\Throwable $th) {
            return back()->withErrors('Failed to create Chicken');
        }
    }
    function editChicken(Request $request, $id)
    {
        // dd($id);
        $input = $request->validate([
            'size' => 'required|string',
            'harga' => 'required|numeric'
        ]);
        
        try {
            ChickenSize::where('id',$id)->update($input);
            return redirect()->route('admin.ChickenSize')->with('success','Successfully Update chicken size!');
        } catch (\Throwable $th) {
            return back()->withErrors('Failed to update Chicken');
        }
    }

    function ChickenIndex()
    {
        $Chicken = ChickenSize::get();
        // dd($Chicken);
        return Inertia::render('admin/sales/ChickenSize', compact('Chicken'));
        
    }
}
