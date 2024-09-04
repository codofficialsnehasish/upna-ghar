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
        Schema::create('service_form_templates_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_template_id')->nullable();
            $table->string('label_name')->nullable();
            $table->string('input_type')->nullable();
            $table->text('input_type_options')->nullable();
            $table->tinyInteger('input_is_required')->default(0);
            $table->tinyInteger('input_is_readonly')->default(0);
            $table->timestamps();

            $table->foreign('form_template_id')->references('id')->on('service_form_templates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_form_templates_fields');
    }
};
