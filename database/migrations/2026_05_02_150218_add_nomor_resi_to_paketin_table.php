<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('paketin', function (Blueprint $table) {
            $table->string('nomor_resi')->nullable()->after('unit');
        });
    }

    public function down(): void
    {
        Schema::table('paketin', function (Blueprint $table) {
            $table->dropColumn('nomor_resi');
        });
    }
};