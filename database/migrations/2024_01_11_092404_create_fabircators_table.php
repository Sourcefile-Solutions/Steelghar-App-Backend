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
        Schema::create('fabircators', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('fab_id')->nullable();
            $table->string('approval_status');
            $table->string('company_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('gst');
            $table->string('pan');
            $table->string('aadhaar');
            $table->string('business_agreement');
            $table->string('photo');
            $table->integer('attempt')->nullable();
            $table->timestamp('applied_at')->nullable();
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fabircators');
    }
};
