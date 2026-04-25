<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paketout', function (Blueprint $table) {
            $table->id('paketout_id');

            $table->unsignedBigInteger('paketin_id');
            $table->foreign('paketin_id')->references('paketin_id')->on('paketin');

            $table->string('user_nik', 16);
            $table->foreign('user_nik')->references('user_nik')->on('reception');

            $table->timestamp('out_date')->useCurrent();
            $table->string('pengambil');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paketout');
    }
};