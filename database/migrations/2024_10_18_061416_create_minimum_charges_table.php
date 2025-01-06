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
        Schema::create('minimum_charges', function (Blueprint $table) {
            $table->id();
            $table->string('from_kg');
            $table->string('to_kg');
            $table->string('from_km');
            $table->string('to_km');
            $table->string('minimum_charge');
            $table->string('additional_km')->nullable();
            $table->string('additional_charge')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minimum_charges');
    }
};
