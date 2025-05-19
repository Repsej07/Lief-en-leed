<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\gebeurtenissen;

class DashboardController extends Controller
{
    public function index()
    {
        // Haal alle gebeurtenissen op uit de database
        $gebeurtenissen = gebeurtenissen::all();
        return view('dashboard', ['gebeurtenissen' => $gebeurtenissen]);
    }
}
