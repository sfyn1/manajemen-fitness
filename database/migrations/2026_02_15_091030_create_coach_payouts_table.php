<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coach_payouts', function (Blueprint $table) {
            $table->id();
            $table->string('payout_number')->unique(); // No Slip: SLIP-001
            $table->foreignId('coach_id')->constrained('coaches')->onDelete('cascade');
            $table->string('month'); // "02"
            $table->string('year'); // "2026"
            $table->integer('total_sessions'); // Jumlah sesi yang dibayar
            $table->decimal('total_amount', 12, 2); // Total uang (Rupiah)
            $table->dateTime('paid_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coach_payouts');
    }
};