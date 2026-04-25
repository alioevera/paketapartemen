<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penghuni', function (Blueprint $table) {
            $table->id('penghuni_id');

            $table->unsignedBigInteger('tower_id');
            $table->foreign('tower_id')->references('tower_id')->on('tower');

            $table->string('unit', 10);
            $table->string('nama_penghuni', 100);
            $table->string('nomor_telepon', 20)->unique();
            $table->string('email', 100)->unique();

            $table->unique(['tower_id', 'unit']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penghuni');
    }
};