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
        Schema::create('service_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->foreignId('apartment_type_id')->constrained()->onDelete('cascade')->nullable();
            $table->foreignId('time_slot_id')->constrained()->onDelete('cascade');
            $table->date('visit_date')->nullable();
            $table->string('survey_charge')->nullable();
            $table->string('survey_charge_payment_mode')->nullable();
            $table->string('survey_charge_payment_status')->nullable();
            $table->unsignedBigInteger('allotted_worker_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_books');
    }
};
