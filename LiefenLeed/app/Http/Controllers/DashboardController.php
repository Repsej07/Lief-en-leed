<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
    $requester = Auth::user()->Roepnaam . ' ' . Auth::user()->Achternaam; // Get the full name (Roepnaam and Achternaam) of the currently authenticated user
    $medewerkerNummer = $request->input('medewerker'); // employee number from request

    // Get user id and roepnaam by medewerker number in one query
    $user = DB::table('users')
        ->select('id', 'Roepnaam', 'Voorvoegsel', 'Achternaam','Geboortedatum', 'In_dienst_ivm_dienstjaren', 'AOW-datum')
        ->where('Medewerker', $medewerkerNummer)
        ->first();

    if (!$user) {
        // Handle not found, e.g. redirect back with error
        return redirect()->back()->withErrors(['medewerker' => 'Medewerker niet gevonden']);
    }

    $userId = $user->id;
    $type = $request->input('type');
    $approved = false;
    $fullName = trim($user->Roepnaam . ' ' . ($user->Voorvoegsel ? $user->Voorvoegsel . ' ' : '') . $user->Achternaam);



    if (in_array($type, ['50e Verjaardag', '65e Verjaardag'])) {
        $dateOfBirth = $user->Geboortedatum;
        $milestoneAge = $type == '50e Verjaardag' ? 50 : 65;
        $milestoneBirthday = date('Y-m-d', strtotime($dateOfBirth . " +$milestoneAge years"));
        $currentDate = date('Y-m-d');
        $oneMonthBefore = date('Y-m-d', strtotime($milestoneBirthday . ' -1 month'));
        $oneMonthAfter = date('Y-m-d', strtotime($milestoneBirthday . ' +1 month'));

        if ($currentDate >= $oneMonthBefore && $currentDate <= $oneMonthAfter) {
            $approved = true;
        }
    }

    if (in_array($type, ['12,5 Jaar Ambtenaar', '25 Jaar Ambtenaar', '40 Jaar Ambtenaar'])) {
        $employmentDate = $user->In_dienst_ivm_dienstjaren;
        $employmentDateObj = new \DateTime($employmentDate);

        if ($type === '12,5 Jaar Ambtenaar') {
            $milestoneDate = (clone $employmentDateObj)->add(new \DateInterval('P12Y6M'));
        } elseif ($type === '25 Jaar Ambtenaar') {
            $milestoneDate = (clone $employmentDateObj)->add(new \DateInterval('P25Y'));
        } else {
            $milestoneDate = (clone $employmentDateObj)->add(new \DateInterval('P40Y'));
        }

        $currentDate = new \DateTime();
        $oneMonthBefore = (clone $milestoneDate)->modify('-1 month');
        $oneMonthAfter = (clone $milestoneDate)->modify('+1 month');

        if ($currentDate >= $oneMonthBefore && $currentDate <= $oneMonthAfter) {
            $approved = true;
        }
    }

    if ($type === 'Pensionering') {
        $endOfEmployment = $user->{'AOW-datum'};

        if ($endOfEmployment) {
            $endOfEmployment = new \DateTime($endOfEmployment);
            $currentDate = new \DateTime();
            $oneMonthBefore = (clone $endOfEmployment)->modify('-1 month');
            $oneMonthAfter = (clone $endOfEmployment)->modify('+1 month');

            if ($currentDate >= $oneMonthBefore && $currentDate <= $oneMonthAfter) {
                $approved = true;
            }
        }
    }



 requests::create([
        'type' => $type,
        'Medewerker' => $medewerkerNummer,
        'name' => $fullName,
        'approved' => $approved,
        'created_by'=>$requester,
        'comments' => $request->input('opmerkingen', ''), // Optional comments from the request
    ]);

    return view('eindeAanvraag');
}

}
