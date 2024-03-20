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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('seller_id')->unsigned();
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            // $table->string('name');
            // $table->string('slug');
            // $table->string('price');
            // $table->string('address');
            // $table->string('area');
            // $table->longText('description')->nullable();
            // $table->string('property_id');
            $table->enum('type',['Residential','Office','Retail','Hospitality','Industrial','Light Industrial','Retirement Homes','Student Appartements','Special Real Estate'])->default('Residential');
            // $table->string('status');
            // $table->integer('room');
            // $table->integer('bedroom');
            // $table->integer('bath');
            // $table->integer('garage');
            // $table->date('year_Built');
            $table->string('portfolio_single_property');
            $table->string('object_project');
            $table->string('state');
            $table->string('city');
            $table->string('rental_area');
            $table->integer('number_of_apartements')->nullable();
            $table->string('rental_income_pa');
            $table->string('purchase_price');
            $table->string('purchase_price_rental_income_pa');
            $table->string('purchase_price_m2');
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->boolean('is_active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
