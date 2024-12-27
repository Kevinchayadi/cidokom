<?php

namespace App\Http\Controllers;

use App\Models\currentEgg;
use App\Models\Kandang;
use App\Models\Pen;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PenController extends Controller
{
    function userIndex(){
        $pen = Pen::with('kandang')->get()->toArray();
        return Inertia::render('user/pen', compact('pen'));
    }
    function kandangPen($id){
        $pen = Pen::with('kandang')->where('id_kandang',$id)->get();
        return Inertia::render('user/pen', compact('pen'));
    }
    
    function createPen(){
        $kandang = Kandang::with('pen')->get();
        return Inertia::render('user/FormCreatePen', compact('kandang'));
        
    }
    
    function storePen(Request $request){
        $pen = $request->validate([
            'id_kandang' => 'required',
            'code_pen' => 'required'
        ]);
        
        
        $pen['code_pen'] = strtoupper($pen['code_pen']);
        $penInput = Pen::create($pen);
        return redirect()->route('user.penList')->with('success', 'Berhasil membuat pen baru!!');
    }
    function adminIndex(){
        $pen = Pen::with('kandang')->get();
        // dd($pen[0]->kandang->nama_kandang);
        return Inertia::render('admin/pen', ['pen'=>$pen]);
    }
}
