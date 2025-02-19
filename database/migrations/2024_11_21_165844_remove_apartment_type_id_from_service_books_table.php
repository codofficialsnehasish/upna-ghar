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
            $table->dropForeign(['apartment_type_id']);
            $table->dropColumn('apartment_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_books', function (Blueprint $table) {
            $table->foreignId('apartment_type_id')->constrained()->onDelete('cascade')->nullable();
        });
    }
};
