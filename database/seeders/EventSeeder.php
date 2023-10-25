<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::create([
            'name' => 'Konser ABC',
            'user_id' => 2,
            'event_category_id' => 1,
            'description' => 'Konser Music ABCSDD',
            'date' => '2023-10-12',
            'image' => 'path/image.jpg',
            'place' => 'Graha Kencana',
            'address' => 'Jl. Surabaya',
            'status' => 1
        ]);

        Event::create([
            'name' => 'Trip To Lombok',
            'user_id' => 2,
            'event_category_id' => 1,
            'description' => 'Trip To Lombok',
            'date' => '2023-10-12',
            'image' => 'path/image.jpg',
            'place' => 'Lombok',
            'address' => 'Jl. Surabaya',
            'status' => 1
        ]);

        Event::create([
            'name' => 'Webinar Teknologi',
            'user_id' => 2,
            'event_category_id' => 2,
            'description' => 'Webinar Teknologi',
            'date' => '2023-10-12',
            'image' => 'path/image.jpg',
            'place' => 'Lombok',
            'address' => 'Jl. Surabaya',
            'status' => 1
        ]);

        Event::create([
            'name' => 'Seminar Statistic',
            'user_id' => 2,
            'event_category_id' => 3,
            'description' => 'Seminar Statistic',
            'date' => '2023-10-12',
            'image' => 'path/image.jpg',
            'place' => 'Lombok',
            'address' => 'Jl. Surabaya',
            'status' => 1
        ]);

        Event::create([
            'name' => 'Pelatihan Basic Financial Accounting - Online',
            'user_id' => 2,
            'event_category_id' => 4,
            'description' => 'Pelatihan Basic Financial Accounting - Online',
            'date' => '2023-10-12',
            'image' => 'path/image.jpg',
            'place' => 'Lombok',
            'address' => 'Jl. Surabaya',
            'status' => 1
        ]);

        Event::create([
            'name' => 'Pelatihan Brevet A & B Terpadu',
            'user_id' => 2,
            'event_category_id' => 5,
            'description' => 'Pelatihan Brevet A & B Terpadu',
            'date' => '2023-10-12',
            'image' => 'path/image.jpg',
            'place' => 'Lombok',
            'address' => 'Jl. Surabaya',
            'status' => 1
        ]);

        Event::create([
            'name' => 'Pelatihan Pajak Brevet C',
            'user_id' => 2,
            'event_category_id' => 5,
            'description' => 'Pelatihan Pajak Brevet C',
            'date' => '2023-10-12',
            'image' => 'path/image.jpg',
            'place' => 'Lombok',
            'address' => 'Jl. Surabaya',
            'status' => 1
        ]);
    }
}
