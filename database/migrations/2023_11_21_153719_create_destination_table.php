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
        Schema::create('destination', function (Blueprint $table) {
            $table->id('id_destinasi');
            $table->unsignedBigInteger('id_itinerary')->nullable(); // Foreign key to itinerary table
            $table->binary('images');
            $table->string('title');
            $table->float('rating');
            $table->boolean('trending');
            $table->string('location');
            $table->longText('description')->nullable();
            $table->longText('facilities')->nullable();
            $table->timestamps();

            // $table->foreign('id_itinerary')->references('id_itinerary')->on('itinerary')
            // ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destination');
    }
};
