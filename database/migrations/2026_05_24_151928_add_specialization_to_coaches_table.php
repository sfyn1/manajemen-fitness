<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('coaches', function (Blueprint $table) {
            // Specialisasi kelas untuk Group Coach (nullable karena PT tidak butuh ini)
            $table->foreignId('class_type_id')
                  ->nullable()
                  ->after('session_rate')
                  ->constrained('class_types')
                  ->nullOnDelete();
        });

        Schema::table('pt_sessions', function (Blueprint $table) {
            // Tambah kolom reschedule untuk fitur ubah jadwal H-1
            $table->date('rescheduled_from_date')->nullable()->after('cancel_reason');
            $table->time('rescheduled_from_time')->nullable()->after('rescheduled_from_date');
            $table->timestamp('rescheduled_at')->nullable()->after('rescheduled_from_time');
        });
    }

    public function down(): void
    {
        Schema::table('coaches', function (Blueprint $table) {
            $table->dropForeign(['class_type_id']);
            $table->dropColumn('class_type_id');
        });

        Schema::table('pt_sessions', function (Blueprint $table) {
            $table->dropColumn(['rescheduled_from_date', 'rescheduled_from_time', 'rescheduled_at']);
        });
    }
};
