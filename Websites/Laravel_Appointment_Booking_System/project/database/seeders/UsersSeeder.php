<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'role' => 'client',
            'password' => bcrypt('secret'),
        ]);

        DB::table('users')->insert([
            'name' => 'martyna',
            'email' => 'm@wp.pl',
            'role' => 'admin',
            'password' => bcrypt('secret12'),
        ]);

        DB::table('users')->insert([
            'name' => 'ala',
            'email' => 'ma@wp.pl',
            'role' => 'client',
            'password' => bcrypt('secret12'),
        ]);

        DB::table('users')->insert([
            'name' => 'jakub',
            'email' => 'j@wp.pl',
            'role' => 'provider',
            'password' => bcrypt('secret12'),
        ]);

        DB::table('users')->insert([
            'name' => 'kasia',
            'email' => 'k@wp.pl',
            'role' => 'client',
            'password' => bcrypt('secret12'),
        ]);

        DB::table('users')->insert([
            'name' => 'ola',
            'email' => 'o@wp.pl',
            'role' => 'provider',
            'password' => bcrypt('secret12'),
        ]);

        DB::table('users')->insert([
            'name' => 'filip',
            'email' => 'f@wp.pl',
            'role' => 'client',
            'password' => bcrypt('secret12'),
        ]);

        DB::table('users')->insert([
            'name' => 'bartek',
            'email' => 'b@wp.pl',
            'role' => 'client',
            'password' => bcrypt('secret12'),
        ]);

        // Dodatkowi usługodawcy
        DB::table('users')->insert([
            'name' => 'Anna',
            'email' => 'anna@wp.pl',
            'role' => 'provider',
            'password' => bcrypt('secret12'),
            'is_validated' => true,
        ]);

        DB::table('users')->insert([
            'name' => 'Karol',
            'email' => 'karol@wp.pl',
            'role' => 'provider',
            'password' => bcrypt('secret12'),
            'is_validated' => true,
        ]);

        DB::table('users')->insert([
            'name' => 'Ewa',
            'email' => 'ewa@wp.pl',
            'role' => 'provider',
            'password' => bcrypt('secret12'),
            'is_validated' => true,
        ]);

        DB::table('users')->insert([
            'name' => 'Tomasz',
            'email' => 'tomasz@wp.pl',
            'role' => 'provider',
            'password' => bcrypt('secret12'),
            'is_validated' => true,
        ]);

        DB::table('users')->insert([
            'name' => 'Marta',
            'email' => 'marta@wp.pl',
            'role' => 'provider',
            'password' => bcrypt('secret12'),
            'is_validated' => true,
        ]);

        DB::table('users')->insert([
            'name' => 'Piotr',
            'email' => 'piotr@wp.pl',
            'role' => 'provider',
            'password' => bcrypt('secret12'),
            'is_validated' => true,
        ]);

        DB::table('users')->insert([
            'name' => 'Natalia',
            'email' => 'natalia@wp.pl',
            'role' => 'provider',
            'password' => bcrypt('secret12'),
            'is_validated' => true,
        ]);

        DB::table('users')->insert([
            'name' => 'Michał',
            'email' => 'michal@wp.pl',
            'role' => 'provider',
            'password' => bcrypt('secret12'),
            'is_validated' => true,
        ]);

        DB::table('users')->insert([
            'name' => 'Zofia',
            'email' => 'zofia@wp.pl',
            'role' => 'provider',
            'password' => bcrypt('secret12'),
            'is_validated' => true,
        ]);

        DB::table('users')->insert([
            'name' => 'Adam',
            'email' => 'adam@wp.pl',
            'role' => 'provider',
            'password' => bcrypt('secret12'),
            'is_validated' => true,
        ]);
    }
}
