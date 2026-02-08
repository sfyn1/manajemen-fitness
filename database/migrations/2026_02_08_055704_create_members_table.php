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
    Schema::create('members', function (Blueprint $table) {
        $table->id();
        
        // Relasi ke tabel users
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
        // Data Pribadi Tambahan
        $table->string('phone_number', 15);
        $table->text('address')->nullable();
        $table->enum('gender', ['L', 'P']);
        
        // Data Keanggotaan (Penting untuk Proposal Anda)
        $table->date('join_date'); // Tanggal bergabung
        $table->date('expiry_date')->nullable(); // Tanggal habis masa aktif
        $table->string('status')->default('active'); // active, expired, inactive
        
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
