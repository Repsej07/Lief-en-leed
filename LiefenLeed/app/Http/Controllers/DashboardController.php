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

        if (in_array($type, ['12,5 Jaar Huwelijk', '25 Jaar Huwelijk', '40 Jarig Huwelijk'])) {
            $marriageDate = DB::table('users')->where('id', $userId)->value('date_of_marriage');

            if ($marriageDate) {
                $marriageDateObj = new \DateTime($marriageDate);

                // Determine milestone date
                if ($type === '12,5 Jaar Huwelijk') {
                    $milestoneDate = (clone $marriageDateObj)->add(new \DateInterval('P12Y6M')); // 12 years, 6 months
                } elseif ($type === '25 Jaar Huwelijk') {
                    $milestoneDate = (clone $marriageDateObj)->add(new \DateInterval('P25Y'));
                } else { // 40 Jarig Huwelijk
                    $milestoneDate = (clone $marriageDateObj)->add(new \DateInterval('P40Y'));
                }

                $currentDate = new \DateTime();
                $oneMonthBefore = (clone $milestoneDate)->modify('-1 month');
                $oneMonthAfter = (clone $milestoneDate)->modify('+1 month');

                if ($currentDate >= $oneMonthBefore && $currentDate <= $oneMonthAfter) {
                    $approved = true;
                }
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
        if ($type === 'Huwelijk/Geregistreerd Partnerschap') {
            $marriageDate = DB::table('users')->where('id', $userId)->value('date_of_marriage');

            if ($marriageDate) {
            $marriageDate = new \DateTime($marriageDate);
            $currentDate = new \DateTime();
            $oneMonthBefore = (clone $marriageDate)->modify('-1 month');
            $oneMonthAfter = (clone $marriageDate)->modify('+1 month');

            if ($currentDate >= $oneMonthBefore && $currentDate <= $oneMonthAfter) {
                $approved = true;
            }
            }
        }
        if ($type === 'Ontslag/FPU/Pensionering') {
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
        if ($type === 'Ziekte 3 maanden') {
            $sickdate = DB::table('sick_users')->where('user_id', $userId)->value('sick_date');
            if ($sickdate) {
                $sickdate = new \DateTime($sickdate);
                $currentDate = new \DateTime();
                $threeMonthsLater = (clone $sickdate)->modify('+3 months');
                $twoDaysBefore = (clone $threeMonthsLater)->modify('-2 days');
                $twoDaysAfter = (clone $threeMonthsLater)->modify('+2 days');
                
                if ($currentDate >= $twoDaysBefore && $currentDate <= $twoDaysAfter) {
                    $approved = true;
                }
            }
        }
        if ($type === 'Ziekte 3 weken') {
            $sickdate = DB::table('sick_users')->where('user_id', $userId)->value('date_of_sick_leave');
            if ($sickdate) {
            $sickdate = new \DateTime($sickdate);
            $currentDate = new \DateTime();
            $threeWeeksLater = (clone $sickdate)->modify('+3 weeks');
            $twoDaysBefore = (clone $threeWeeksLater)->modify('-2 days');
            $twoDaysAfter = (clone $threeWeeksLater)->modify('+2 days');

            if ($currentDate >= $twoDaysBefore && $currentDate <= $twoDaysAfter) {
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
