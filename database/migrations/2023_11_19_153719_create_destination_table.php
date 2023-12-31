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
            $table->binary('images');
            $table->string('title');
            $table->integer('rating');
            $table->boolean('trending');
            $table->string('location');
            $table->longText('description')->nullable();
            // $table->smallInteger('soft_delete')->default(0);
            $table->timestamps();
    
            // Foreign key to itinerary table
            // $table->unsignedBigInteger('id_itinerary')->nullable(); // Foreign key to itinerary table
            // $table->foreign('id_itinerary')->references('id_itinerary')->on('itinerary');
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
