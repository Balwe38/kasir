<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('id_transaction')
                ->constrained('transactions')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignUuid('id_product')
                ->constrained('produks')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->integer('qty');
            $table->integer('price');
            $table->integer('discount_price')->default(0);
            $table->integer('discount_percent')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};