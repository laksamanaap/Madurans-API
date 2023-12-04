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
        Schema::create('facilities', function (Blueprint $table) {
            $table->id('id_facility');
            $table->unsignedBigInteger('id_destinasi');
            $table->json('facility_name')->nullable(); 

            // Foreign key to destination table
            $table->foreign('id_destinasi')->references('id_destinasi')->on('destination');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
