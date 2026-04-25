<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paketin', function (Blueprint $table) {
            $table->id('paketin_id');

            $table->string('user_nik', 16);
            $table->foreign('user_nik')->references('user_nik')->on('reception');

            $table->timestamp('input_date')->useCurrent();

            $table->unsignedBigInteger('tower_id');
            $table->foreign('tower_id')->references('tower_id')->on('tower');

            $table->unsignedBigInteger('penghuni_id');
            $table->foreign('penghuni_id')->references('penghuni_id')->on('penghuni');

            $table->string('unit', 10);

            $table->string('bentuk_paket');
            $table->integer('jumlah_paket');
            $table->string('lokasi_simpan');

            $table->unsignedBigInteger('expedisi_id');
            $table->foreign('expedisi_id')->references('expedisi_id')->on('expedisi');

            $table->string('foto_paket')->nullable();
            $table->string('hasil_ocr')->nullable();
            $table->string('status_verifikasi')->default('Belum Diambil');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paketin');
    }
};