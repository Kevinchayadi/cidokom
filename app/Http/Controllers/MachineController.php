<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MachineController extends Controller
{
    function userIndex()
    {
        // dd('test');
        $machine = Machine::get();
        return Inertia::render('user/machineList', compact('machine'));
    }

    function createMachine()
    {
        return Inertia::render('user/FormCreateMachine');
    }

    function storeMachine(Request $request)
    {
        // dd($request);
        $machine = $request->validate([
            'machine_name' => 'required',
            'kapasitas' => 'required|integer',
        ]);
        Machine::create($machine);
        return redirect()->route('user.machine')->with('success', 'Berhasil membuat pakan baru!!');
    }
}
