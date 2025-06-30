<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'username' => 'doctor2',
            'email' => 'doctor2@gmail.com',
            'password_hash' => 'doctor2', // Mutator hashes
            'access_level' => 'doctor',
        ]);
        User::create([
            'username' => 'doctor3',
            'email' => 'doctor3@gmail.com',
            'password_hash' => 'doctor3', // Mutator hashes
            'access_level' => 'doctor',
        ]);
    }
}