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
            $table->string('payout_number')->unique(); // No Slip: PAY-XXXXX

            $table->foreignId('coach_id')->constrained('coaches')->onDelete('cascade');

            // Tipe payroll dibedakan: gaji bulanan (PT) vs per sesi (group coach)
            $table->enum('payout_type', ['monthly_salary', 'session_fee'])->default('session_fee');

            $table->string('month'); // "05"
            $table->string('year');  // "2026"

            // Khusus Group Coach: jumlah sesi yang dihitung
            $table->integer('total_sessions')->default(0);

            // Khusus PT: komponen gaji
            $table->decimal('base_salary', 12, 2)->default(0); // Gaji pokok
            $table->decimal('bonus', 12, 2)->default(0); // Bonus (opsional)

            // Total akhir yang dibayarkan (berlaku untuk keduanya)
            $table->decimal('total_amount', 12, 2);

            $table->string('notes')->nullable(); // Catatan slip gaji
            $table->dateTime('paid_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coach_payouts');
    }
};