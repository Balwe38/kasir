<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('code', 150)->unique();
            $table->string('nama_produk', 50);
            $table->decimal('harga', 10, 2);
            $table->integer('stok');
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);

            $table->softDeletes();

            $table->foreignUuid('created_by')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};