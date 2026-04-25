<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('paketout', function (Blueprint $table) {
            $table->boolean('send_pengingat')->default(false)->after('pengambil');
            $table->timestamp('pengingat_dikirim_at')->nullable()->after('send_pengingat');
        });
    }

    public function down(): void
    {
        Schema::table('paketout', function (Blueprint $table) {
            $table->dropColumn(['send_pengingat', 'pengingat_dikirim_at']);
        });
    }
};