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
        Schema::table('service_books', function (Blueprint $table) {
            $table->bigInteger('verification_otp')->after('allotted_worker_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_books', function (Blueprint $table) {
            $table->dropColumn('verification_otp');
        });
    }
};
