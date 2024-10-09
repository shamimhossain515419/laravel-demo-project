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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('added_by'); // Column for the user who added the post
            $table->string('title'); // Title of the post
            $table->text('body'); // Main content of the post
            $table->text('description')->nullable(); // Description of the post (optional)
            $table->timestamps();

            // Foreign key to the categories table
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            // Foreign key to the users table for 'added_by'
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
