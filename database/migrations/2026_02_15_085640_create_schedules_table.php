<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coach_id')->constrained('coaches')->onDelete('cascade');
            $table->foreignId('class_type_id')->constrained('class_types')->onDelete('cascade');
            
            // KITA KEMBALI KE HARI (RECURRING)
            $table->string('day'); // Contoh: "Senin", "Selasa"
            $table->time('start_time'); // 10:00:00
            $table->time('end_time');   // 12:00:00
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};