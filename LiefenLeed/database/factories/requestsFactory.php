<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\requests;
use App\Models\User;

class RequestsFactory extends Factory
{
    protected $model = requests::class;

    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $luckyuser = User::inRandomOrder()->first();
        return [
            'type' => $this->faker->randomElement([
                'Ziek',
                'Ziekte 3 maanden',
                'Ziekte 3 weken',
                'Ziekte ziekenhuisopname',
                'Huwelijk/Geregistreerd Partnerschap',
                'Pensionering',
                'FPU',
                'Ontslag',
                '50e Verjaardag',
                '65e Verjaardag',
                '12,5 Jaar Huwelijk',
                '12,5 Jaar Ambtenaar',
                '25 Jaar Huwelijk',
                '25 Jaar Ambtenaar',
                'Overlijden Ambtenaar of Huisgenoot',
                '40 Jaar Ambtenaar',
                '40 Jarig Huwelijk',
            ]),
            'Medewerker' => $user->medewerker,
            'name' => $luckyuser->Roepnaam . ' ' . $luckyuser->Achternaam,
            'approved' => $this->faker->boolean,
            'created_by' => $user->Roepnaam . ' ' . $user->Achternaam,
            'comments' => $this->faker->sentence,

        ];
    }
}
