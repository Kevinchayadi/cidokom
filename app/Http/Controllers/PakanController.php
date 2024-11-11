<?php

namespace App\Http\Controllers;

use App\Models\Pakan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PakanController extends Controller
{
    function userIndex(){
        $pakan = Pakan::get();
        return Inertia::render('user/pakanList', compact('pakan'));
    }
    
    function createPakan(){
        return Inertia::render('user/FormCreatePakan');
    }
    
    function storePakan(Request $request){
        dd($request);
        $pakan = $request->validate([
            'nama_pakan' => ['require'],
            'qty' => ['require']
        ]);
        Pakan::create($pakan);;
        return redirect()->route('user.pakan')->with('success', 'Berhasil membuat pakan baru!!');

    }
}
