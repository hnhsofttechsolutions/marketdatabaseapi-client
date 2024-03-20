<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class BuyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new User;
        $admin->role_id = 3;
        $admin->first_name = 'Buyer';
        $admin->last_name = 'Buyer';
        $admin->email = "buyer@gmail.com";
        $admin->password = Hash::make('12345678');
        $admin->is_active=1;
        $admin->is_broker=0;
        $admin->save();

        $admin = new User;
        $admin->role_id = 3;
        $admin->first_name = 'Buyer Broker';
        $admin->last_name = 'Buyer Broker';
        $admin->email = "buyer_broker@gmail.com";
        $admin->password = Hash::make('12345678');
        $admin->is_active=1;
        $admin->is_broker=1;
        $admin->save();
    }
}
