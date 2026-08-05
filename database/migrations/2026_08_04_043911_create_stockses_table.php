<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("stocksses", function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('quantity');
            $table->enum('type_transaction', ['in', 'out']);
            $table->decimal('base_price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stockses');
    }
};
