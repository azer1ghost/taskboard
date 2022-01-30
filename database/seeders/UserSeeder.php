<?php

namespace Database\Seeders;

use App\Models\Board;
use Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        \App\Models\User::factory()
            ->has(
                Board::factory(4)->hasTasks(2)
            )
            ->create([
                'email' => 'user@gmail.com',
                'password' => Hash::make('password')
            ]);
    }
}
