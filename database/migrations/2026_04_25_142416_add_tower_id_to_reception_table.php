<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reception', function (Blueprint $table) {
            $table->unsignedBigInteger('tower_id')->nullable()->after('role');
            $table->foreign('tower_id')->references('tower_id')->on('tower');
        });
    }

    public function down(): void
    {
        Schema::table('reception', function (Blueprint $table) {
            $table->dropForeign(['tower_id']);
            $table->dropColumn('tower_id');
        });
    }
};