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
        Schema::create('registration_t', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patient_m')->onDelete('cascade');
            $table->string('registration_number')->unique();
            $table->string('patient_weight');
            $table->string('patient_blood_pressure');
            $table->text('patient_complaint');
            $table->text('diagnostic_result');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_t');
    }
};
