<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            //$table->string('stripe_plan');
            $table->integer('price');
            $table->string('description');
            $table->string('duration');
            $table->string('period');
            $table->integer('offered_property')->default(0);
            $table->enum('is_type',['buyer_broker','seller_broker'])->default('buyer_broker');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
