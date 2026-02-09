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
    Schema::create('presences', function (Blueprint $table) {
        $table->id();
        // Menyimpan siapa yang datang
        $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
        // Waktu datang
        $table->dateTime('check_in_time');
        // Status kedatangan (Hadir, Ditolak karena Expired, dll) - Opsional buat log error
        $table->string('status')->default('success'); 
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
