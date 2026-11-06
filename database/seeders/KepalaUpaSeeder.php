<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KepalaUpaSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'royani.hm@poltekba.ac.id'],
            [
                'name' => 'Royani HM',
                'password' => Hash::make('upa123'),
                'role' => 'upa',
                'unit_id' => null,
                'whatsapp' => null,
                'email_verified_at' => now(),
            ]
        );
    }
}
