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
        Schema::create('investor_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('buyer_id')->unsigned();
            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('country_origin')->nullable();
            $table->string('pursue')->nullable();
            $table->string('legal_form')->nullable();
            $table->string('url')->nullable();
            $table->string('city')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('managing_director')->nullable();
            $table->string('formal')->nullable();
            $table->string('salutation')->nullable();
            $table->string('title')->nullable();
            $table->string('ranking');
            $table->string('Link_purchase_profile')->nullable();
            $table->string('purchase_contact_person')->nullable();
            $table->string('email_purchase_request')->nullable();
            $table->string('residential_real_estate')->nullable();
            $table->string('office_properties')->nullable();
            $table->string('retail_shopping_center')->nullable();
            $table->string('logistics_infrastructure')->nullable();
            $table->string('light_industrial')->nullable();
            $table->string('hotels_tourism')->nullable();
            $table->string('care_health_social_affair')->nullable();
            $table->string('regional_focus');
            $table->string('germany')->nullable();
            $table->string('switzerland')->nullable();
            $table->string('austria')->nullable();
            $table->string('benelux')->nullable();
            $table->string('eastern_europe')->nullable();
            $table->string('northern_europe')->nullable();
            $table->string('spain')->nullable();
            $table->string('italy')->nullable();
            $table->string('portugal')->nullable();
            $table->string('uk')->nullable();
            $table->string('ireland')->nullable();
            $table->enum('investor_type',['Investment manager','Real estate company'])->default('Investment manager');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investor_details');
    }
};
