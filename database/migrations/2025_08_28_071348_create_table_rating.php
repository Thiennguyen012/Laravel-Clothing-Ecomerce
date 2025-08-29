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
        Schema::create('rating', function (Blueprint $table) {
            $table->id();

            // Foreign keys với đúng type và table name
            $table->unsignedBigInteger('variant_id');
            $table->foreign('variant_id')->references('id')->on('variants')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('session_id')->nullable();

            // Rating với validation
            $table->tinyInteger('star')->unsigned()->default(5); // 1-5 stars
            $table->text('comment')->nullable(); // Optional comment
            $table->string('reviewer_name', 100); // Tên người review

            // Indexes for performance
            $table->index(['variant_id', 'user_id']);
            $table->index('star');

            // Unique constraint - 1 user chỉ review 1 variant 1 lần
            $table->unique(['variant_id', 'user_id'], 'unique_user_variant_rating');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rating');
    }
};
