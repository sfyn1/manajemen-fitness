<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coach_presences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coach_id')->constrained('coaches')->onDelete('cascade');
            $table->foreignId('schedule_id')->nullable()->constrained('schedules')->onDelete('set null');
            
            $table->date('date'); // Tanggal coach mengajar
            $table->decimal('coach_fee', 12, 2); // Nominal gaji sesi ini (disimpan permanen)
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coach_presences');
    }
};