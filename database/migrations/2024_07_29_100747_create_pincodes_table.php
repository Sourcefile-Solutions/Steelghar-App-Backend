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
        Schema::create('pincodes', function (Blueprint $table) {
            $table->id();
            $table->integer('pincode');
            $table->string('office_name')->nullable();
            $table->string('office_type')->nullable();
            $table->string('division_name')->nullable();
            $table->string('region_name')->nullable();
            $table->string('circle_name')->nullable();
            $table->string('telephone')->nullable();
            $table->string('related_headoffice')->nullable();
            $table->string('related_suboffice')->nullable();
            $table->string('state')->nullable();
            $table->string('district')->nullable();
            $table->string('taluk')->nullable();
            $table->string('delivery_charge')->nullable();
            $table->string('delivery_status')->nullable();
            $table->string('duration')->nullable();
            $table->boolean('site_mode')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pincodes');
    }
};
