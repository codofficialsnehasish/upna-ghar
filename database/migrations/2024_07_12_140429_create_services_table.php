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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('sub_parent_id')->nullable();
            $table->string('slug')->unique();
            $table->decimal('price',10,2)->default(0.00);
            $table->unsignedBigInteger('price_type_id')->nullable();
            $table->text('description')->nullable();
            $table->string('main_image')->nullable();
            $table->string('rating')->nullable();
            $table->tinyInteger('visibility')->default(0);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('sub_parent_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('price_type_id')->references('id')->on('payment_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
