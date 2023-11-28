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
        Schema::create('itinerary', function (Blueprint $table) {
            $table->id('id_itinerary');
            $table->unsignedBigInteger('id_destinasi')->nullable();
            $table->string('itinerary_day');
            $table->string('itinerary_location_description');
            $table->longText('itinerary_description');
            $table->timestamps();
        
            // Foreign key to destination table
            $table->foreign('id_destinasi')->references('id_destinasi')->on('destination');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itinerary');
    }
};
