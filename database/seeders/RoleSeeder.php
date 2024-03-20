<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRole=["admin",'seller','buyer'];
        foreach($userRole as $value){
            $role =new Role;
            $role->name=$value;
            $role->save();
        }
    }
}
