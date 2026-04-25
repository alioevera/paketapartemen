<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expedisi', function (Blueprint $table) {
            $table->id('expedisi_id');
            $table->string('expedisi_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expedisi');
    }
};