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
            $table->string('name');//name of the plan ex:Basic,Premium
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->string('billing_cycle'); // e.g., 'monthly', 'yearly'
            $table->string('features')->nullable();// json or related table listining what the plan includes
            $table->integer('trial_period_days')->default(0);// Number of free trial period,if available
            $table->boolean('is_active')->default(true);//boolean to indicate if the plan is active
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
