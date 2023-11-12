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
            'name' => 'Super Junior World Tour – Super Show 8: Infinite Time',
            'user_id' => 2,
            'event_category_id' => 1,
            'description' => 'Konser Music ABCSDD',
            'date' => '2020-11-11',
            'image' => '/event/1suju.jpg',
            'place' => 'Indonesia Convention Exhibition (ICE) BSD, Tangerang Selatan, Banten',
            'address' => 'BSD, Tangerang Selatan, Banten',
            'status' => 1
        ]);

        Event::create([
            'name' => 'Konser Eric Nam ‘Before We Begin’ Asia Tour 2020',
            'user_id' => 2,
            'event_category_id' => 1,
            'description' => 'Konser Eric Nam ‘Before We Begin’ Asia Tour 2020',
            'date' => '2020-01-13',
            'image' => '/event/2erik.jpeg',
            'place' => 'Soehanna Hall – The Energy, ',
            'address' => 'Jakarta Selatan',
            'status' => 1
        ]);

        Event::create([
            'name' => 'Berdendang Bergoyang Festival',
            'user_id' => 2,
            'event_category_id' => 2,
            'description' => 'Festival musik lokal sedang banyak digelar belakangan ini. Nah, salah satu festival musik lokal yang recommended untuk didatangi adalah Berdendang Bergoyang Festival.',
            'date' => '2023-10-12',
            'image' => '/event/3goyang.jpg',
            'place' => 'Lombok',
            'address' => 'Jl. Surabaya',
            'status' => 1
        ]);

        Event::create([
            'name' => 'Java Jazz Festival 2020',
            'user_id' => 2,
            'event_category_id' => 3,
            'description' => 'Java Jazz Festival 2020',
            'date' => '2023-10-12',
            'image' => '/event/4java.png',
            'place' => 'Tennis Indoor & Plaza Barat GBK.',
            'address' => 'Jakarta Pusat',
            'status' => 1
        ]);

        Event::create([
            'name' => 'Java Jazz Festival 2020',
            'user_id' => 2,
            'event_category_id' => 4,
            'description' => 'Siap yang sudah menanti-nanti acara jazz tahunan ini? Kali ini Java Jazz Festival kembali menjadi wadah pelepas dahaga bagi penikmat musik di Tanah Air.',
            'date' => '2020-02-20',
            'image' => '/event/5head.jpg',
            'place' => 'Jakarta International Expo (JIExpo), ',
            'address' => 'Jakarta Pusat',
            'status' => 1
        ]);

        Event::create([
            'name' => 'Head in the Clouds Indonesia',
            'user_id' => 2,
            'event_category_id' => 5,
            'description' => 'ini dia salah satu konser yang paling dinanti penggemar musik di Indonesia. Rich Brian, Joji, Niki, dan Hight Brother yang tergabung dalam label 88 Rising akan menyapa fans di Indonesia lewat konser Head in the Clouds Indonesia.',
            'date' => '2023-10-12',
            'image' => '/event/louis.jpg',
            'place' => 'JIExpo Kemayoran.',
            'address' => 'Jakarta Pusat',
            'status' => 1
        ]);

        Event::create([
            'name' => 'Louis Tomlinson World Tour 2020',
            'user_id' => 2,
            'event_category_id' => 5,
            'description' => 'Kamu penggemar band One Direction? Kalau jawabanmu iya, jangan sampai kelewatan konser solo pertama Louis Tomlinson di Jakarta.',
            'date' => '2023-10-12',
            'image' => '/event/louis.jpg',
            'place' => 'Tennis Indoor Senayan, ',
            'address' => 'Jakarta Pusat',
            'status' => 1
        ]);
    }
}
