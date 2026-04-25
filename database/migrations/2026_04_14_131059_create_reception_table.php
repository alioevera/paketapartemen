<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reception', function (Blueprint $table) {
            $table->string('user_nik', 16)->primary();
            $table->string('user_name');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'receptionist'])->default('receptionist');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reception');
    }
};