<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usługi dla fryzjera (Jakub)
        DB::table('services')->insert([
            'providerID' => 4, // ID usługodawcy "Jakub"
            'name' => 'Strzyżenie męskie',
            'category' => 'Fryzjer',
            'duration' => 30,
            'price' => 50.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('services')->insert([
            'providerID' => 4, // ID usługodawcy "Jakub"
            'name' => 'Strzyżenie damskie',
            'category' => 'Fryzjer',
            'duration' => 60,
            'price' => 120.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Usługi dla nowego fryzjera (Karol)
        DB::table('services')->insert([
            'providerID' => 10, // ID usługodawcy "Karol"
            'name' => 'Modelowanie włosów',
            'category' => 'Fryzjer',
            'duration' => 40,
            'price' => 80.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('services')->insert([
            'providerID' => 10, // ID usługodawcy "Karol"
            'name' => 'Koloryzacja włosów',
            'category' => 'Fryzjer',
            'duration' => 90,
            'price' => 200.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Usługi dla kosmetyczki (Ola)
        DB::table('services')->insert([
            'providerID' => 6, // ID usługodawcy "Ola"
            'name' => 'Manicure',
            'category' => 'Paznokcie',
            'duration' => 45,
            'price' => 100.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('services')->insert([
            'providerID' => 6, // ID usługodawcy "Ola"
            'name' => 'Pedicure',
            'category' => 'Paznokcie',
            'duration' => 60,
            'price' => 150.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Usługi dla nowej kosmetyczki (Ewa )
        DB::table('services')->insert([
            'providerID' => 11, // ID usługodawcy "Ewa
            'name' => 'Manicure hybrydowy',
            'category' => 'Paznokcie',
            'duration' => 60,
            'price' => 100.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('services')->insert([
            'providerID' => 11, // ID usługodawcy "Ewa"
            'name' => 'Manicure klasyczny',
            'category' => 'Paznokcie',
            'duration' => 45,
            'price' => 80.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Usługi dla masażystów (Marta i Piotr)
        DB::table('services')->insert([
            'providerID' => 13, // ID usługodawcy "Marta"
            'name' => 'Masaż relaksacyjny',
            'category' => 'Masaż',
            'duration' => 60,
            'price' => 120.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('services')->insert([
            'providerID' => 13, // ID usługodawcy "Marta"
            'name' => 'Masaż leczniczy',
            'category' => 'Masaż',
            'duration' => 90,
            'price' => 180.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('services')->insert([
            'providerID' => 14, // ID usługodawcy "Piotr"
            'name' => 'Masaż sportowy',
            'category' => 'Masaż',
            'duration' => 75,
            'price' => 150.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('services')->insert([
            'providerID' => 14, // ID usługodawcy "Piotr"
            'name' => 'Masaż gorącymi kamieniami',
            'category' => 'Masaż',
            'duration' => 90,
            'price' => 200.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Usługi dla depilacji (Natalia i Michał)
        DB::table('services')->insert([
            'providerID' => 15, // ID usługodawcy "Natalia"
            'name' => 'Depilacja woskiem',
            'category' => 'Depilacja',
            'duration' => 45,
            'price' => 100.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('services')->insert([
            'providerID' => 15, // ID usługodawcy "Natalia"
            'name' => 'Depilacja laserowa',
            'category' => 'Depilacja',
            'duration' => 90,
            'price' => 300.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('services')->insert([
            'providerID' => 16, // ID usługodawcy "Michał"
            'name' => 'Depilacja nóg',
            'category' => 'Depilacja',
            'duration' => 60,
            'price' => 150.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('services')->insert([
            'providerID' => 16, // ID usługodawcy "Michał"
            'name' => 'Depilacja rąk',
            'category' => 'Depilacja',
            'duration' => 60,
            'price' => 120.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Usługi dla "Zofia"
        DB::table('services')->insert([
            'providerID' => 17, // ID usługodawcy "Zofia"
            'name' => 'Laminacja brwi',
            'category' => 'Brwi/Rzęsy',
            'duration' => 45,
            'price' => 120.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('services')->insert([
            'providerID' => 17, // ID usługodawcy "Zofia"
            'name' => 'Przedłużanie rzęs',
            'category' => 'Brwi/Rzęsy',
            'duration' => 90,
            'price' => 250.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Usługi dla "Adam"
        DB::table('services')->insert([
            'providerID' => 18, // ID usługodawcy "Adam"
            'name' => 'Henna pudrowa brwi',
            'category' => 'Brwi/Rzęsy',
            'duration' => 40,
            'price' => 80.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('services')->insert([
            'providerID' => 18, // ID usługodawcy "Adam"
            'name' => 'Lifting rzęs',
            'category' => 'Brwi/Rzęsy',
            'duration' => 60,
            'price' => 150.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
