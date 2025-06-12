<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_success()
    {
        $this->withoutMiddleware();

        $testJson = [
            'rows' => [
                [
                    'Medewerker' => '100000',
                    'Roepnaam' => 'Test',
                    'Voorvoegsel' => null,
                    'Achternaam' => 'User',
                    'E-mail_werk' => 'testuser@example.com',
                    'Geboortedatum' => '1990-01-01T00:00:00Z',
                    'AOW-datum' => '2055-01-01T00:00:00Z',
                    'In_dienst_ivm_dienstjaren' => '2020-01-01T00:00:00Z'
                ]
            ]
        ];

        $file = UploadedFile::fake()->createWithContent('test_import.json', json_encode($testJson));

        $response = $this->followingRedirects()->post('/import-data', [
            'import_file' => $file,
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', [
            'medewerker' => '100000',
            'email' => 'testuser@example.com',
        ]);
    }

}
