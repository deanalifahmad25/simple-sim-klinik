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
            $table->string('patient_weight')->nullable();
            $table->string('patient_blood_pressure')->nullable();
            $table->text('patient_complaint')->nullable();
            $table->text('diagnostic_result')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
