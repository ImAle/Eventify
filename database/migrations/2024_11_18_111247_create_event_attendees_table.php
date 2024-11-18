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
        Schema::create('event_attendees', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['CONFIRMED', 'CANCELLED']);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('event_id');
            $table->tinyInteger('deleted')->default(0);
            $table->dateTime('registered_at');
            // Relación con la tabla users
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            // Relación con la tabla events
            $table->foreign('event_id')->references('id')->on('events')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_attendees');
    }
};
