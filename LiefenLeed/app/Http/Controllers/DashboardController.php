<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\gebeurtenissen;
use App\Models\requests;

class DashboardController extends Controller
{
    public function index()
    {
        // Haal alle gebeurtenissen op uit de database
        $gebeurtenissen = gebeurtenissen::all();
        return view('dashboard', ['gebeurtenissen' => $gebeurtenissen]);
    }
    public static function storeRequest(Request $request)
    {
        // dd($request->all());
        requests::create([
            'type' => $request->input('type'),
            'name' => $request->input('name'),
        ]);
        return view(view: 'eindeAanvraag');
    }
}
