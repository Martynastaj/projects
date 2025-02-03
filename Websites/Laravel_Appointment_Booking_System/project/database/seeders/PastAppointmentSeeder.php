<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Service;
use App\Models\Rezerwacja;

class PastAppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Pobierz użytkownika "john.doe@gmail.com"
        $client = User::where('email', 'john.doe@gmail.com')->first();

        if (!$client) {
            $this->command->error('Użytkownik john.doe@gmail.com nie został znaleziony. Uruchom UserSeeder przed tym Seederem.');
            return;
        }

        // Pobierz przykładową usługę (lub utwórz, jeśli nie istnieje)
        $service = Service::firstOrCreate(
            ['name' => 'Manicure hybrydowy (60 minut)', 'providerID' => User::where('role', 'provider')->first()->id],
            [
                'duration' => 60,
                'price' => 100.00,
            ]
        );

        // Twórz 2 wizyty dla klienta z ustalonymi datami
        $appointments = [
            [
                'date' => '2025-01-05', // Data pierwszej wizyty
                'time' => '10:00:00',
                'service_id' => $service->id,
                'client_id' => $client->id,
                'provider_id' => $service->providerID,
            ],
            [
                'date' => '2025-01-25', // Data drugiej wizyty
                'time' => '14:30:00',
                'service_id' => $service->id,
                'client_id' => $client->id,
                'provider_id' => $service->providerID,
            ],
        ];

        foreach ($appointments as $appointment) {
            Rezerwacja::create($appointment);
        }

        $this->command->info('Dodano minione wizyty dla użytkownika john.doe@gmail.com na daty 5.01.2025 i 25.01.2025.');
    }
}
