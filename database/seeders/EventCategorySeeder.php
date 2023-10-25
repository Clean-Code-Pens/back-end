<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EventCategory::create([
            'name' => 'Konser',
            'status' => 1
        ]);

        EventCategory::create([
            'name' => 'Liburan',
            'status' => 1
        ]);

        EventCategory::create([
            'name' => 'Webinar',
            'status' => 1
        ]);

        EventCategory::create([
            'name' => 'Pendidikan',
            'status' => 1
        ]);

        EventCategory::create([
            'name' => 'Sosial',
            'status' => 1
        ]);
    }
}
