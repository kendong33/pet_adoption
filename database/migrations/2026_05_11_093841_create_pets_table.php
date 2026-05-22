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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name');                                              // Pet name
            $table->string('category');                                          // e.g. Dog, Cat, Bird
            $table->string('breed');                                             // e.g. Labrador
            $table->integer('age');                                              // Age in years
            $table->enum('gender', ['Male', 'Female']);                         // Gender
            $table->string('health_status')->nullable();                        // e.g. Healthy, Vaccinated
            $table->text('description')->nullable();                            // Full description
            $table->string('image')->nullable();                                // Stored path in storage/pets
            $table->enum('status', ['Available', 'Adopted', 'Archived'])
                  ->default('Available');                                        // Adoption status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
