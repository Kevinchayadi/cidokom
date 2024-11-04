<?php

namespace App\Http\Controllers;

use App\Models\Ayam;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AyamController extends Controller
{
    function userIndex(){
        $ayam = Ayam::get();
        // dd($ayam);
        return Inertia::render('user/ayamList', ['ayam'=>$ayam, 'successMessage' => session('success!!')]);
    }
    
    function createAyam(){
        $ayam = Ayam::get();
        return Inertia::render('user/FormCreateAyam',['ayam'=>$ayam]);
    }
    
    function storeAyam(Request $request){
        // dd($request);
        $ayam = $request->validate([
                    'code_ayam' => 'required|string|max:255',  
                    'strain_male' => 'required|string|max:255', 
                    'strain_female' => 'required|string|max:255', 

                ], [
                    'code_ayam.required' => 'Nama Ayam wajib diisi.',
                    'strain_male.required' => 'Induk Jantan wajib diisi.',
                    'strain_female.required' => 'Induk Betina wajib diisi.',
                ]);
                $ayam['code_ayam'] = strtoupper($ayam['code_ayam']);

        
        Ayam::create($ayam);

        return redirect()->route('user.ayamList')->with('success', 'Berhasil membuat jenis ayam baru!!');
    }

    function adminIndex(){
        $ayam = Ayam::get();
        return Inertia::render('admin.ayam', ['ayam'=>$ayam]);
    }
}
