<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VerzuimControl;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class VerzuimControlController extends Controller
{
    public function index()
    {
        $users = User::all();
        $medicalChecks = VerzuimControl::with('user')->where('status', 'gepland')->get();
        
        return view('beheerder.index', compact('users', 'medicalChecks'));
    }
    
public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'type' => 'required|in:huisbezoek,telefonisch',
    ]);
    
    // Set default planned_date as tomorrow (or adjust to your preference)
    $validated['planned_date'] = now()->addDay();
    
    $exists = VerzuimControl::where('user_id', $validated['user_id'])
                ->where('status', 'gepland')
                ->exists();

    if ($exists) {
        return response()->json([
            'success' => false,
            'message' => 'Deze medewerker heeft al een geplande controle.'
        ], 409);
    }
    
    VerzuimControl::create($validated);
    
    return response()->json(['success' => true]);
}


    
public function approve($id)
{
    $check = VerzuimControl::findOrFail($id);
    $check->status = 'goedgekeurd';
    $check->save();

    return redirect()->back()->with('success', 'Controle goedgekeurd.');
}

public function disapprove($id)
{
    $check = VerzuimControl::findOrFail($id);
    $check->status = 'afgekeurd';
    $check->save();

    return redirect()->back()->with('success', 'Controle afgekeurd.');
}
    
    public function getMedicalChecks()
    {
       $medicalChecks = VerzuimControl::with('user')->where('status', 'gepland')->get() ?? collect([]);

        return response()->json($medicalChecks);
    }
}
