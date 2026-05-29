<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration ini sekarang tidak melakukan apa-apa karena sudah digabung
// ke create_coaches_table (user_id) dan create_coach_presences_table (evidence_photo, status)
return new class extends Migration
{
    public function up(): void
    {
        // No-op: semua kolom sudah ada di migration create masing-masing
    }

    public function down(): void
    {
        // No-op
    }
};