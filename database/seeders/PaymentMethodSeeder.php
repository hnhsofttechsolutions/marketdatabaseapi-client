<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;
use Illuminate\Support\Str;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $paymentMethod =new PaymentMethod;
            $paymentMethod->name='Stripe';
            $paymentMethod->slug=strtolower(Str::slug('Stripe'));
            $paymentMethod->public_key='pk_test_51KKeaxERpgKKkr1sNMV4NZCdzz2aU9ktQIfyCUBjMqjkOY7pYro9x7ET400HZYzOSlvqCKuWxb1huLwBoEWXFnau00sFQweIJC';
            $paymentMethod->secret_key='sk_test_51KKeaxERpgKKkr1sVoI50GPtxdfPKaaAVobmDF6eYfCkMLOCwNWaLql9U1v7IL985DAZRJfbKcco2rqrJhAKc6Xt00Iq1Rn3WW';
            $paymentMethod->is_active=1;
            $paymentMethod->save();
    }
}
