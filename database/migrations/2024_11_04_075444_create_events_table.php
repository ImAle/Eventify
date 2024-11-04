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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organizer_id');
            $table->string('title', 150);
            $table->string('description')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('location', 255)->nullable();
            $table->decimal('latitude', 9, 6)->nullable();
            $table->decimal('longitude', 9, 6)->nullable();
            $table->integer('max_attendees')->nullable();
            $table->decimal('price', 10, 2)->default(0.00);
            $table->string('image_url', 255)->nullable();
            $table->tinyInteger('deleted')->default(0);
            $table->timestamps();
            
            // Relación con la tabla users (organizers)
            $table->foreign('organizer_id')->references('id')->on('users')->onUpdate('cascade');

            // Relación con la tabla categories
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
