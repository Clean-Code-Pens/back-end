<?php

namespace Database\Seeders;

use App\Models\Meet;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MeetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Meet::create([
            'user_id' => 3,
            'event_id' => 1,
            'name' => 'Saya membutuhkan Teman untuk konser ini',
            'description' => 'Konser Music ABCSDD',
            'people_need' => 3,
        ]);

        Meet::create([
            'user_id' => 4,
            'event_id' => 2,
            'name' => 'Saya membutuhkan Teman untuk konser ini',
            'description' => 'Konser Music ABCSDD',
            'people_need' => 3,
        ]);

        Meet::create([
            'user_id' => 4,
            'event_id' => 3,
            'name' => 'Saya membutuhkan Teman untuk konser ini',
            'description' => 'Konser Music ABCSDD',
            'people_need' => 3,
        ]);

        Meet::create([
            'user_id' => 3,
            'event_id' => 4,
            'name' => 'Saya membutuhkan Teman untuk konser ini',
            'description' => 'Konser Music ABCSDD',
            'people_need' => 3,
        ]);

        Meet::create([
            'user_id' => 2,
            'event_id' => 5,
            'name' => 'Saya membutuhkan Teman untuk konser ini',
            'description' => 'Konser Music ABCSDD',
            'people_need' => 3,
        ]);

        Meet::create([
            'user_id' => 4,
            'event_id' => 6,
            'name' => 'Saya membutuhkan Teman untuk konser ini',
            'description' => 'Konser Music ABCSDD',
            'people_need' => 3,
        ]);

        Meet::create([
            'user_id' => 3,
            'event_id' => 7,
            'name' => 'Saya membutuhkan Teman untuk konser ini',
            'description' => 'Konser Music ABCSDD',
            'people_need' => 3,
        ]);

        Meet::create([
            'user_id' => 2,
            'event_id' => 7,
            'name' => 'Saya membutuhkan Teman untuk konser ini',
            'description' => 'Konser Music ABCSDD',
            'people_need' => 3,
        ]);
    }
}
