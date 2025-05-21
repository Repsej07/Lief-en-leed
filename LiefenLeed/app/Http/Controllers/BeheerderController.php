<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\VerzuimControl;

class BeheerderController extends Controller
{
    /**
     * Display a listing of the users (admin only).
     */
    public function index()
    {
        $users = User::all();
         $medicalChecks = VerzuimControl::with('user')->get();
        return view('beheerder.index', compact('users' ,'medicalChecks'));
    }

    /**
     * Show the form for creating a new user (admin only).
     */
    public function create()
    {
        $users = User::all();
        
        return view('beheerder.create', compact('users'));
    }

    /**
     * Store a newly created user (admin only).
     */
public function store(Request $request)
{
    $request->validate([
        'medewerker' => 'required|exists:users,id',
        'startdatum' => 'required|date',
        'opmerkingen' => 'nullable|string',
    ]);

    $user = User::findOrFail($request->medewerker);
    $user->is_sick = true;
    $user->sick_start_date = $request->startdatum;
    $user->save();

    return redirect()->route('beheerder.index')->with('success', 'Ziekmelding opgeslagen.');
}

    /**
     * Display the specified user (admin only).
     */
    public function show(User $user)
    {
        return view('beheerder.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user (admin only).
     */
    public function edit(User $user)
    {
        return view('beheerder.edit', compact('user'));
    }

    /**
     * Update the specified user in storage (admin only).
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user->update($request->only('name', 'email'));

        return redirect()->route('beheerder.index');
    }

    /**
     * Remove the specified user from storage (admin only).
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('beheerder.index');
    }
    
public function markNotSick(Request $request)
{
    $request->validate([
        'medewerker' => 'required|exists:users,id',
    ]);

    $user = User::findOrFail($request->medewerker);
    $user->is_sick = false;
    $user->save();

    return redirect()->route('beheerder.index')->with('success', 'Medewerker gemarkeerd als hersteld.');
}
}
