<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\requests;

class RequestController extends Controller
{
    public function index()
    {
        $requests = requests::all();
        return view('request.index', compact('requests'));
    }

    public function goedkeuren($id)
    {
        $request = requests::findOrFail($id);
        $request->approved = true;
        $request->save();

        return redirect()->route('request.index')->with('success', 'Aanvraag goedgekeurd.');
    }
    public function afkeuren($id)
    {
        $request = requests::findOrFail($id);
        $request->delete();

        return redirect()->route('request.index')->with('error', 'Aanvraag verwijderd.');
    }

}
