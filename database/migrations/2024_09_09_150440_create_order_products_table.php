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
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->uuid()->default(DB::raw('UUID()'))->unique();
            $table->foreignIdFor(\App\Models\Order::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('product_id')->default(false);
            $table->string('product_name')->nullable(false);
            $table->string('slug')->nullable(false);
            $table->string('product_image')->nullable();
            $table->decimal('product_price', 20, 5)->default(0);
            $table->integer('product_quantity')->default(false);
            $table->timestamps();
            $table->engine('InnoDB');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};
