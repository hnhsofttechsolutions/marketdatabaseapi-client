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
        Schema::create('investor_profiles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('buyer_id')->unsigned();
            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('portfolio_single_property');
            $table->string('object_project');
            $table->string('state');
            $table->string('city');
            $table->string('rental_area');
            $table->string('number_of_apartements')->nullable();
            $table->string('rental_income_pa');
            $table->string('purchase_price');
            $table->string('purchase_price_rental_income_pa');
            $table->string('purchase_price_m2');
            $table->enum('type',['Residential','Office','Retail','Hospitality','Industrial','Light Industrial','Retirement Homes','Student Appartements','Special Real Estate'])->default('Residential');
            $table->enum('status',['pending','accepted','cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investor_profiles');
    }
};
