<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profile::create([
            'user_id' => 1,
            'addres' => 'alamat',
            'profile_picture' => '/profilePicture/usericon.png',
            'job' => 'admin',
            'noHp' => '091234',
            'gender' => 'male'
        ]);

        Profile::create([
            'user_id' => 2,
            'addres' => 'Surabaya',
            'profile_picture' => '/profilePicture/usericon.png',
            'job' => 'student',
            'noHp' => '0812345',
            'gender' => 'male'
        ]);

        Profile::create([
            'user_id' => 3,
            'addres' => 'Surabaya',
            'profile_picture' => '/profilePicture/usericon.png',
            'job' => 'student',
            'noHp' => '0812345',
            'gender' => 'female'
        ]);

        Profile::create([
            'user_id' => 4,
            'addres' => 'Surabaya',
            'profile_picture' => '/profilePicture/usericon.png',
            'job' => 'student',
            'noHp' => '0812345',
            'gender' => 'female'
        ]);
    }
}
