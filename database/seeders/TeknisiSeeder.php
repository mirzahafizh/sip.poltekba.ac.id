<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeknisiSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'teknisi@poltekba.ac.id'],
            [
                'name' => 'Teknisi UPA',
                'password' => Hash::make('teknisi123'),
                'role' => 'teknisi',
                'unit_id' => null,
                'whatsapp' => null,
                'email_verified_at' => now(),
            ]
        );
    }
}
