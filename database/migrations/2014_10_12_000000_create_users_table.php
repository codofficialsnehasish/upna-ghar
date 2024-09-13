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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('role');
            $table->tinyInteger('status')->default(1);
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->unique();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('token')->nullable();
            $table->string('refer_code')->nullable();
            $table->string('user_image')->nullable();
            $table->string('work_expereince')->nullable();
            $table->string('type_of_service')->nullable();
            $table->string('street_address')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
