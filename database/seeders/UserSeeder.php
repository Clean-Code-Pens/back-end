<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'role_id' => 1 ,
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'google_id' => 'abcadad'
        ]);

        User::create([
            'name' => 'user',
            'role_id' => 2,
            'email' => 'userdummy@gmail.com',
            'password' => bcrypt('password'),
            'google_id' => 'abcadad'
        ]);
    }
}
