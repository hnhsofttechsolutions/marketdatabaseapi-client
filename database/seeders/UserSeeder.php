<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new User;
        $admin->role_id = 2;
        $admin->first_name = 'Seller';
        $admin->last_name = 'Seller';
        $admin->email = "seller@gmail.com";
        $admin->password = Hash::make('12345678');
        $admin->is_active=1;
        $admin->is_broker=0;
        $admin->save();

        $admin = new User;
        $admin->role_id = 2;
        $admin->first_name = 'Seller broker';
        $admin->last_name = 'Seller broker';
        $admin->email = "seller_broker@gmail.com";
        $admin->password = Hash::make('12345678');
        $admin->is_active=1;
        $admin->is_broker=1;
        $admin->save();
    }
}
