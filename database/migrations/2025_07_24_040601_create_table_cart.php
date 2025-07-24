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
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // null nếu là khách vãng lai
            $table->string('session_id')->nullable(); // session ID cho khách vãng lai
            $table->unsignedBigInteger('variant_id'); // liên kết với variants
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2); // giá tại thời điểm thêm vào
            $table->timestamps();

            // Quan hệ khóa ngoại
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('variant_id')->references('id')->on('variants')->onDelete('cascade');

            // Index để tăng performance
            $table->index(['user_id', 'session_id']);
            $table->index('variant_id');

            // Unique constraint để tránh duplicate trong cart
            $table->unique(['user_id', 'variant_id', 'session_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};
