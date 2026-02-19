<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Agar Coach bisa Login, dia harus punya akun User
        Schema::table('coaches', function (Blueprint $table) {
            if (!Schema::hasColumn('coaches', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('set null');
            }
        });

        // 2. Tambah kolom Bukti Foto & Status di tabel Absensi
        Schema::table('coach_presences', function (Blueprint $table) {
            $table->string('evidence_photo')->nullable()->after('date'); // Foto Bukti
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('evidence_photo');
        });
    }

    public function down(): void
    {
        Schema::table('coaches', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
        Schema::table('coach_presences', function (Blueprint $table) {
            $table->dropColumn(['evidence_photo', 'status']);
        });
    }
};