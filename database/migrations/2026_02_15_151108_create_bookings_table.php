<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');     // Siapa membernya
            $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade'); // Jadwal rutin mana
            
            $table->date('date'); // Tanggal latihan yang dipilih (Misal: 2026-02-20)
            $table->string('booking_code')->unique(); // Kode unik tiket
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};