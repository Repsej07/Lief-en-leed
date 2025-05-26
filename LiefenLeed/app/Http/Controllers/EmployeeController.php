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

        $results = DB::table('users')
            ->where('Roepnaam', 'like', "%{$query}%")
            ->orWhere('Voorvoegsel', 'like', "%{$query}%")
            ->orWhere('Achternaam', 'like', "%{$query}%")
            ->select('Roepnaam as voornaam', 'Voorvoegsel as tussenvoegsel', 'Achternaam as achternaam', 'Medewerker')
            ->limit(10)
            ->get();

        return response()->json($results);
    }

}
