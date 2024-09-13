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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid()->default(DB::raw('UUID()'))->unique();
            $table->decimal('order_total', 20, 5)->default(0);
            $table->decimal('service_amount', 20, 5)->default(0);
            $table->decimal('shipping_amount', 20, 5)->default(0);
            $table->decimal('tax_amount', 20, 5)->default(0);
            $table->decimal('coupon_amount', 20, 5)->default(0);
            $table->string('tax_title')->nullable();
            $table->string('shipping_method')->nullable();
            $table->string('coupon_code')->nullable();
            $table->dateTime('order_date_time')->nullable(false);
            $table->string('payment_method');
            $table->string('payment_reference_code');
            $table->string('currency');
            $table->string('order_pdf')->nullable();
            $table->string('order_status')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_email_sent')->default(0);
            $table->timestamps();
            $table->engine('InnoDB');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
