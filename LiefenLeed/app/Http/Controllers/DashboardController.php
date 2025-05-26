<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $userId = DB::table('users')->where('name', $request->input('name'))->value('id');
        $type = $request->input('type');
        $approved = false; // Set default

        if (in_array($type, ['50e Verjaardag', '65e Verjaardag'])) {
            $dateOfBirth = DB::table('users')->where('id', $userId)->value('date_of_birth');
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
            $employmentDate = DB::table('users')->where('id', $userId)->value('date_of_employment');
            $employmentDateObj = new \DateTime($employmentDate);

            // Handle different year milestones
            if ($type === '12,5 Jaar Ambtenaar') {
                // Add 12 years and 6 months
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
            $endOfEmployment = DB::table('users')->where('id', $userId)->value('end_of_employment');

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
            'name' => $request->input('name'),
            'approved' => $approved,
        ]);

        return view('eindeAanvraag');
    }
}
