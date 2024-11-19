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
            $table->dropColumn(['survey_charge']);

            $table->decimal('discount_rate',5,2)->default(0.00)->after('price_type_id');
            $table->decimal('discount_price',10,2)->default(0.00)->after('discount_rate');
            $table->decimal('gst_rate',5,2)->default(0.00)->after('discount_price');
            $table->decimal('gst_amount',10,2)->default(0.00)->after('gst_rate');
            $table->decimal('total_price',10,2)->default(0.00)->after('gst_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->decimal('survey_charge',10,2)->default(0.00)->after('price_type_id');
            $table->dropColumn(['discount_rate','discount_price','gst_rate','gst_amount','total_price']);
        });
    }
};
