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
        Schema::create('orderproduct_t', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number');
            $table->foreign('registration_number')
                    ->references('registration_number')
                    ->on('registration_t')
                    ->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->integer('qty');
            $table->foreignId('product_id')->constrained('product_m')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderproduct_t');
    }
};
