<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
// Assuming you have a User model for employees

class ImportController extends Controller
{
    //

    public function import(Request $request)
    {
        Log::debug('Import called');
        $request->validate([
            'import_file' => 'required|file|mimetypes:application/json,text/plain'
        ]);
        Log::debug('File validation passed');


        $json = file_get_contents($request->file('import_file')->getRealPath());
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return redirect()->back()->withErrors(['import_file' => 'Ongeldig JSON-formaat.']);
        }


        if (!isset($data['rows']) || !is_array($data['rows'])) {
            return back()->withErrors(['import_file' => 'Ongeldig JSON-formaat.']);
        }

        $imported = 0;
        $skipped = [];

        foreach ($data['rows'] as $row) {
            try {
                User::updateOrCreate(
                    ['medewerker' => $row['Medewerker']], // Search condition
                    [
                        'Roepnaam' => $row['Roepnaam'],
                        'Voorvoegsel' => $row['Voorvoegsel'],
                        'Achternaam' => $row['Achternaam'],
                        'email' => $row['E-mail_werk'],
                        'Geboortedatum' => Carbon::parse($row['Geboortedatum'])->format('Y-m-d'),
                        'AOW-datum' => Carbon::parse($row['AOW-datum'])->format('Y-m-d'),
                        'in_dienst_ivm_dienstjaren' => Carbon::parse($row['In_dienst_ivm_dienstjaren'])->format('Y-m-d'),
                        'password' => bcrypt('default_password'), // Set a default password
                    ]
                );
                $imported++;
            } catch (\Exception $e) {
                $errorMsg = $e->getMessage();

                // Shorten common errors for clarity
                if (str_contains($errorMsg, 'Duplicate entry')) {
                    $errorMsg = 'Duplicaat van medewerker-ID (unieke waarde bestaat al)';
                } elseif (str_contains($errorMsg, 'Integrity constraint violation')) {
                    $errorMsg = 'Integriteitsfout: unieke beperking schending';
                } else {
                    // You can truncate the message if too long
                    $errorMsg = substr($errorMsg, 0, 100) . (strlen($errorMsg) > 100 ? '...' : '');
                }

                $skipped[] = [
                    'medewerker' => $row['Medewerker'] ?? 'onbekend',
                    'email' => $row['E-mail_werk'] ?? 'onbekend',
                    'reden' => $errorMsg,
                ];
            }
        }

        return back()->with([
            'success' => "$imported gebruikers geïmporteerd.",
            'skipped' => $skipped
        ]);
    }
}
