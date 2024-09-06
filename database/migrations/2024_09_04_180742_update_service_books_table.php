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
            $table->tinyInteger('is_verified')->default(0)->after('verification_otp');
            $table->timestamp('verification_time')->nullable()->after('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_books', function (Blueprint $table) {
            $table->dropColumn(['verification_otp','verification_time']);
        });
    }
};
