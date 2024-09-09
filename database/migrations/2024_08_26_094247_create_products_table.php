<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid()->default(DB::raw('UUID()'))->unique();
            $table->string('name')->nullable(false);
            $table->string('slug')->nullable(false)->unique();
            $table->decimal('price', 20, 5)->default(0);
            $table->text('description')->default('');
            $table->string('image')->default('');
            $table->engine('InnoDB');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
