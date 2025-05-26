<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Assuming you have an Employee model

class EmployeeController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->query('query');

        $results = User::where('name', 'like', "%$search%")
            ->limit(10)
            ->get();

        return response()->json($results);
    }
}
