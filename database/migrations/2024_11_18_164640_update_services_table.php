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
        Schema::table('services', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeign(['parent_id']);
            $table->dropForeign(['sub_parent_id']);
            $table->dropForeign(['service_type']);
            
            // Drop columns
            $table->dropColumn(['parent_id', 'sub_parent_id', 'service_type']);

            $table->string('service_types')->nullable()->after('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Recreate dropped columns
            $table->unsignedBigInteger('parent_id')->nullable()->after('slug');
            $table->unsignedBigInteger('sub_parent_id')->nullable()->after('parent_id');
            $table->unsignedBigInteger('service_type')->nullable()->after('sub_parent_id');

            // Recreate foreign keys
            $table->foreign('parent_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('sub_parent_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('service_type')->references('id')->on('service_types')->onDelete('cascade');

            // Drop the new column
            $table->dropColumn('service_types');
        });
    }
};