<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Carbon\Carbon;
// Assuming you have a User model for employees

class ImportController extends Controller
{
    //

    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimetypes:application/json,text/plain'
        ]);


        $json = file_get_contents($request->file('import_file')->getRealPath());
        $data = json_decode($json, true);

        if (!isset($data['rows']) || !is_array($data['rows'])) {
            return back()->withErrors(['import_file' => 'Ongeldig JSON-formaat.']);
        }

        foreach ($data['rows'] as $row) {
            // Save each employee record (example)
            User::create([
                'medewerker' => $row['Medewerker'],
                'Roepnaam' => $row['Roepnaam'],
                'Tussenvoegsel' => $row['Voorvoegsel'],
                'Achternaam' => $row['Achternaam'],
                'email' => $row['E-mail_werk'],
                'Geboortedatum' => Carbon::parse($row['Geboortedatum'])->format('Y-m-d'),
                'aow_datum' => Carbon::parse($row['AOW-datum'])->format('Y-m-d'),
                'in_dienst_ivm_dienstjaren' => Carbon::parse($row['In_dienst_ivm_dienstjaren'])->format('Y-m-d'),
                'password' => bcrypt('default_password'), // Set a default password or handle it differently
            ]);
        }

        return back()->with('success', 'Data succesvol geïmporteerd.');
    }
}
