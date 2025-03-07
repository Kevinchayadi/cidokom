<?php

namespace App\Http\Controllers;

use App\Models\CustHandle;
use App\Models\Customer;
use App\Models\Resident;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    function storeCustomer(Request $request)
    {
        $input = $request->validate([
            'nama_pelanggan' => 'required|string',
            'alamat_pelanggan' => 'required|string',
            'no_telepon_pelanggan' => 'required|numeric',
            'id_sales' => 'required|integer',
            'id_residence' => 'required|integer',
        ]);
        
        try {
            Customer::create($input);
            return redirect()->route('admin.Customer');
        } catch (\Throwable $th) {
            return back()->withErrors('Failed to create Customer');
        }
    }
    function editCustomer(Request $request, $id)
    {
        $input = $request->validate([
            'nama_pelanggan' => 'required|string',
            'alamat_pelanggan' => 'required|string',
            'no_telepon_pelanggan' => 'required|numeric',
            'id_sales' => 'required|integer',
            'id_residence' => 'required|integer',
        ]);
        
        try {
            Customer::with('id',$id)->update($input);
            return redirect()->route('admin.Customer');
        } catch (\Throwable $th) {
            return back()->withErrors('Failed to update Customer');
        }
    }

    function CustomerIndex()
    {
        $customer = Customer::with('sales','Residence')->get();
        $sales = CustHandle::get();
        $residence = Resident::get();
        // dd($customer->toArray());
        return Inertia::render('admin/sales/Customer', compact('customer','sales','residence'));
        
    }
}
