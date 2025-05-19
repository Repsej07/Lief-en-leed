<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class BeheerderController extends Controller
{
    /**
     * Display a listing of the users (admin only).
     */
    public function index()
    {
        $users = User::all();
        return view('beheerder.index', compact('users'));
    }

    /**
     * Show the form for creating a new user (admin only).
     */
    public function create()
    {
        return view('beheerder.create');
    }

    /**
     * Store a newly created user (admin only).
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
        ]);

        User::create([
            'id' => $request['id'],
            'name' => $request['name'],
            'email' => $request['email'],
        ]);

        return redirect()->route('beheerder.index');
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
}
