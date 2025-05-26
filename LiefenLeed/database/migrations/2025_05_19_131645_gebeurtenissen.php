<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gebeurtenissen', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->timestamps();
            $table->boolean('automatic')->default(false);
        });
        DB::table('gebeurtenissen')->insert([
            ['type' => 'Ziek'],
            ['type' => 'Ziekte 3 maanden'],
            ['type' => 'Ziekte 3 weken'],
            ['type' => 'Ziekte ziekenhuisopname'],
            ['type' => 'Huwelijk/Geregistreerd Partnerschap'],
            ['type' => 'Pensionering'],
            ['type' => 'FPU'],
            ['type' => 'Ontslag'],
            ['type' => '50e Verjaardag'],
            ['type' => '65e Verjaardag'],
            ['type' => '12,5 Jaar Huwelijk'],
            ['type' => '12,5 Jaar Ambtenaar'],
            ['type' => '25 Jaar Huwelijk'],
            ['type' => '25 Jaar Ambtenaar'],
            ['type' => 'Overlijden Ambtenaar of Huisgenoot'],
            ['type' => '40 Jaar Ambtenaar'],
            ['type' => '40 Jarig Huwelijk'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
