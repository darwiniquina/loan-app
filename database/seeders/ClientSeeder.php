<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            [
                'full_name' => 'Juan Dela Cruz',
                'contact_no' => '+63 917 123 4567',
                'email' => 'juan.delacruz@example.com',
                'address' => '123 Rizal Street, Quezon City, Metro Manila',
            ],
            [
                'full_name' => 'Maria Santos',
                'contact_no' => '+63 918 234 5678',
                'email' => 'maria.santos@example.com',
                'address' => '456 Bonifacio Avenue, Makati City, Metro Manila',
            ],
            [
                'full_name' => 'Pedro Reyes',
                'contact_no' => '+63 919 345 6789',
                'email' => 'pedro.reyes@example.com',
                'address' => '789 Aguinaldo Street, Pasig City, Metro Manila',
            ],
            [
                'full_name' => 'Ana Garcia',
                'contact_no' => '+63 920 456 7890',
                'email' => 'ana.garcia@example.com',
                'address' => '321 Mabini Road, Taguig City, Metro Manila',
            ],
            [
                'full_name' => 'Roberto Cruz',
                'contact_no' => '+63 921 567 8901',
                'email' => null,
                'address' => '654 Luna Street, Mandaluyong City, Metro Manila',
            ],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}
