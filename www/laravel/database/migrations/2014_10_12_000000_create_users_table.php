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
            $table->string('account', 16)->unique();
            $table->string('password')->nullable();
            $table->string('nickname', 64)->nullable();
            $table->string('phone', 16)->nullable();
            $table->unsignedTinyInteger('gender')->nullable()->comment('性别 1男，2女');
            $table->string('avatar', 200)->default('static/image/web/avatar.jpg')->comment('头像');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
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
