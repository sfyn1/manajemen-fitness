<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coaches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('name');
            $table->string('phone_number')->nullable();
            $table->string('photo')->nullable();

            // TIPE COACH: Personal Trainer atau Group Class Coach
            $table->enum('coach_type', ['personal_trainer', 'group_coach'])->default('group_coach');

            // Khusus Personal Trainer: Gaji pokok bulanan (flat)
            $table->decimal('base_salary', 12, 2)->nullable(); // Gaji pokok bulanan PT

            // Khusus Group Coach: Bayaran per sesi mengajar
            $table->decimal('session_rate', 12, 2)->nullable(); // Bayaran per sesi group

            // Info kontrak PT (opsional)
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coaches');
    }
};
