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
        Schema::table('members', function (Blueprint $table) {
            // Kita tambah kolom 'photo' di sini sekalian
            $table->string('photo')->nullable()->after('gender'); // FOTO WAJAH
            
            $table->string('ktp_image')->nullable()->after('photo');
            $table->string('student_card_image')->nullable()->after('ktp_image');
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Jangan lupa drop juga kalau rollback
            $table->dropColumn(['photo', 'ktp_image', 'student_card_image']);
        });
    }
};
