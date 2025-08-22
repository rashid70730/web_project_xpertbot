<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('renewal_id')->nullable()->after('id'); 
            $table->string('payment_method')->nullable()->after('renewal_id');
            $table->boolean('is_trial')->default(false)->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn(['renewal_id', 'payment_method', 'is_trial']);
        });
    }
};