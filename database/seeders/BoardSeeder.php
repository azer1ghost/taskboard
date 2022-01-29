<?php

namespace Database\Seeders;

use App\Models\Board;
use Illuminate\Database\Seeder;

class BoardSeeder extends Seeder
{
    public function run()
    {
        $stages =  ['Unspecified stage', 'Has not started', 'Processing', 'Completed'];

        foreach ($stages as $stage) {
            Board::create(['title' => $stage, 'user_id' => 1]);
        }
    }
}
