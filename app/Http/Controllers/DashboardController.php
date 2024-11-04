<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    function userIndex(){
        return Inertia::render('user/Dashboard');
    }
}
