<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'omeodev8@gmail.com'],
            [
                'name' => 'Admin',
                'password' => 'secretadmin1234',
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            ClientSeeder::class,
            LoanSeeder::class,
        ]);
    }
}
