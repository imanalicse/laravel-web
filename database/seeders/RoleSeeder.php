<?php

namespace Database\Seeders;

use App\Enum\UserRole;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['id' => 1, 'name' => UserRole::SUPER_ADMIN],
            ['id' => 2, 'name' => UserRole::ADMIN],
            ['id' => 3, 'name' => UserRole::CUSTOMER],
        ]);
    }
}
