<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;
class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Search Teasers', 
                'slug' => 'search-teasers', 
                //'stripe_plan' => 'price_1MmEVrERpgKKkr1s0wi9Vei0', 
                'price' => 100, 
                'description' => 'search teasers',
                'duration' => '1',
                'period' => 'months',
                'offered_property' => 0,
                'is_type'=>'buyer_broker',
            ],
            [
                'name' => 'Basic', 
                'slug' => 'basic', 
                //'stripe_plan' => 'price_1MmEVrERpgKKkr1s0wi9Vei0', 
                'price' => 100, 
                'description' => 'Basic',
                'duration' => '1',
                'period' => 'months',
                'offered_property' => 10,
                'is_type'=>'seller_broker',
            ],
            [
                'name' => 'Premium', 
                'slug' => 'premium', 
                //'stripe_plan' => 'price_1MmEXWERpgKKkr1s6CoGYMWK', 
                'price' => 200, 
                'description' => 'Premium',
                'duration' => '1',
                'period' => 'months',
                'offered_property' => 20,
                'is_type'=>'seller_broker',
            ]
        ];
  
        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
