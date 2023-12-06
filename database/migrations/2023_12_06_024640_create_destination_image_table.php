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
        Schema::create('destination_image', function (Blueprint $table) {
            $table->id('id_destination_images');
            $table->unsignedBigInteger('id_destinasi')->nullable();
            $table->string('icon');
            $table->smallInteger('soft_delete')->default(0);
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
        Schema::dropIfExists('destination_image');
    }
};
