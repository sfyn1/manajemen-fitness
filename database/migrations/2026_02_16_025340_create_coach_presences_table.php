<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Absensi KHUSUS Group Coach (saat mengajar kelas kelompok)
        Schema::create('coach_presences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coach_id')->constrained('coaches')->onDelete('cascade');
            $table->foreignId('schedule_id')->nullable()->constrained('schedules')->onDelete('set null');

            $table->date('date'); // Tanggal coach mengajar
            $table->string('evidence_photo')->nullable(); // Foto bukti mengajar
            $table->decimal('coach_fee', 12, 2); // Nominal bayaran sesi ini (disimpan saat itu)

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coach_presences');
    }
};