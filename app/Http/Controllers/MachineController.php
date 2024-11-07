<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MachineController extends Controller
{
    // function userIndex(){
    //     $kandang = Kandang::with('pen')->get()->toArray();
    //     return Inertia::render('user/kandangList',['kandang'=>$kandang]);
    // }
    
    // function createKandang(){
    //     return Inertia::render('user/FormCreateKandang');
    // }
    
    // function storeKandang(Request $request){
    //     // dd($request);
    //     $kandang = $request->validate([ 
    //                     'nama_kandang' => 'required|string|max:255', 
    //                     'jenis_kandang' => 'required|string',
    //                 ]);
    //     $kandang['nama_kandang'] = strtoupper($kandang['nama_kandang']);
    //     Kandang::create($kandang);

    //     return redirect()->route('user.kandangList')->with('success', 'Berhasil membuat jenis ayam baru!!');
    // }
}
