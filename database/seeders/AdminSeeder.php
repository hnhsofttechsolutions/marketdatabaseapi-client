<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new User;
        $admin->role_id = 1;
        $admin->first_name = 'Admin';
        $admin->last_name = 'Admin';
        $admin->email = "admin@gmail.com";
        $admin->password = Hash::make('12345678');
        $admin->is_active=1;
        $admin->save();
    }
}
