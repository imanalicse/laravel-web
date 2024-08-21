<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Iman Ali',
            'email' => 'admin@yopmail.com',
            'password' => '123456',
            'active' => 1
        ]);

        $user->roles()->attach(2);

        $user2 = User::factory()->create([
            'name' => 'Ishak Ahmed',
            'email' => 'customer@yopmail.com',
            'password' => '123456',
            'active' => 1
        ]);

        $user2->roles()->attach(3);
    }
}
