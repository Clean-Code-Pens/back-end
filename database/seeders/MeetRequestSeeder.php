<?php

namespace Database\Seeders;

use App\Models\MeetRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MeetRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MeetRequest::create([
            'user_id' => 2,
            'meet_id' => 1,
            'status' => false,
        ]);

        MeetRequest::create([
            'user_id' => 3,
            'meet_id' => 1,
            'status' => true,
        ]);
    }
}
