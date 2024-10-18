<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'user_type' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@demo.com',
            'password' => bcrypt('password'),
        ]);
    }
}
