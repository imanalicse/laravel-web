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
            $table->foreignIdFor(\App\Models\Order::class, 'order_id')->nullable(true)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('user_id')->index();
            $table->string('payment_type')->nullable(false);
            $table->string('payment_reference_code')->index();
            $table->string('stripe_charge_id')->nullable(true)->index();
            $table->string('stripe_transaction_id')->nullable(true)->index();
            $table->string('transaction_mode')->nullable(true);
            $table->text('payment_response')->nullable(true);
            $table->timestamps();
            $table->engine('InnoDB');
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
