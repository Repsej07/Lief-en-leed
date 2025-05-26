<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Assuming you have an Employee model
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{

public function search(Request $request)
{
    $query = $request->input('query');

    if (!$query) {
        return response()->json([]);
    }

    $employees = DB::table('users')
        ->select('Medewerker as medewerker', 'Roepnaam as voornaam', 'Voorvoegsel as tussenvoegsel', 'Achternaam as achternaam')
        ->where(function($q) use ($query) {
            $q->where('Roepnaam', 'like', "%{$query}%")
              ->orWhere('Achternaam', 'like', "%{$query}%")
              ->orWhere(DB::raw("CONCAT(Roepnaam, ' ', Voorvoegsel, ' ', Achternaam)"), 'like', "%{$query}%");
        })
        ->limit(10)
        ->get();

    return response()->json($employees);
}


}
