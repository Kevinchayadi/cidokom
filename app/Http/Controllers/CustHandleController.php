<?php

namespace App\Http\Controllers;

use App\Models\CustHandle;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustHandleController extends Controller
{
    function storeSales(Request $request)
    {
        $input = $request->validate([
            'nama_sales' => 'required|String',
            'diskon' => 'required|numeric'
        ]);
        try {
            CustHandle::create($input);
        } catch (\Throwable $th) {
            return back()->withErrors('Failed to create Sales');
        } 
        return redirect()->route('admin.CustHandle')->with('success', 'Sales created successfully');
    }
    function editSales(Request $request, $id)
    {
        $input = $request->validate([
            'nama_sales' => 'required|String',
            'diskon' => 'required|numeric'
        ]);
        try {
            CustHandle::where('id',$id)->update($input);
        } catch (\Throwable $th) {
            return back()->withErrors('Failed to Update Sales');
        } 
        return redirect()->route('admin.CustHandle')->with('success', 'Sales Update successfully');
        
    }

    function salesIndex()
    {
        $sales = CustHandle::all();
        
        return Inertia::render('admin/sales/CustHandle', compact('sales'));
    }
}
