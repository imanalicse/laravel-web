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
        Schema::create('stripe_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->index();
            $table->integer('user_id')->index();
            $table->string('payment_type');
            $table->string('payment_reference_code')->index();
            $table->string('stripe_charge_id')->index();
            $table->string('stripe_transaction_id')->index();
            $table->string('transaction_mode');
            $table->text('payment_response');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stripe_payments');
    }
};
