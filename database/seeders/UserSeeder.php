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

        $super_admin_user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super.admin@yopmail.com',
            'password' => '123456',
            'active' => 1
        ]);
        $super_admin_user->roles()->attach(1);

        $admin_user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@yopmail.com',
            'password' => '123456',
            'active' => 1
        ]);
        $admin_user->roles()->attach(2);

        $customer_user = User::factory()->create([
            'name' => 'Customer',
            'email' => 'customer@yopmail.com',
            'password' => '123456',
            'active' => 1
        ]);
        $customer_user->roles()->attach(3);
    }
}
