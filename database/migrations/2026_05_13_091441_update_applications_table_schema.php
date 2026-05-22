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
        Schema::table('applications', function (Blueprint $table) {
            $table->string('adopter_name')->after('pet_id');
            $table->string('contact_number')->after('adopter_name');
            $table->text('address')->after('contact_number');
            $table->text('home_background')->after('address');
            $table->renameColumn('status', 'application_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['adopter_name', 'contact_number', 'address', 'home_background']);
            $table->renameColumn('application_status', 'status');
        });
    }
};
