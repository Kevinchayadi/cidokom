<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MachineController extends Controller
{
    function userIndex(){
        $machine = Machine::get();
        return Inertia::render('user/MachineList', compact('machine'));
    }
    
    function createMachine(){
        return Inertia::render('user/FormCreateMachine');
    }
    
    function storemachinen(Request $request){
        dd($request);
        $machine = $request->validate([
            'machine_name' => ['require'],

        ]);
        Machine::create($machine);;
        return redirect()->route('user.machine')->with('success', 'Berhasil membuat pakan baru!!');

    }
}
