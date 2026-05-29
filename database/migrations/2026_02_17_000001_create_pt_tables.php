<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // === TABEL 1: PAKET PT ===
        // Master data paket yang ditawarkan gym (5, 10, 20, 30 sesi)
        Schema::create('pt_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // "Paket Starter 5 Sesi", "Paket Lanjut 10 Sesi", dll.
            $table->integer('session_count'); // 5 / 10 / 20 / 30
            $table->decimal('price', 12, 2); // Harga yang dibayar member
            $table->integer('validity_days')->default(30); // Berlaku berapa hari setelah aktif
            $table->integer('duration_minutes')->default(60); // Durasi per sesi (60 atau 120 menit)
            $table->text('description')->nullable(); // Deskripsi paket (opsional)
            $table->boolean('is_active')->default(true); // Admin bisa nonaktifkan paket
            $table->timestamps();
        });

        // === TABEL 2: LANGGANAN PT MEMBER ===
        // Member beli paket PT → pilih PT tertentu → admin konfirmasi
        Schema::create('pt_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->foreignId('coach_id')->constrained('coaches')->onDelete('cascade'); // PT yang dipilih
            $table->foreignId('pt_package_id')->constrained('pt_packages')->onDelete('cascade');

            $table->integer('sessions_total'); // Salin dari package
            $table->integer('sessions_used')->default(0); // Sudah terpakai
            // sessions_left = sessions_total - sessions_used (dihitung di model)

            $table->date('start_date')->nullable(); // Di-set admin saat konfirmasi
            $table->date('end_date')->nullable(); // start_date + validity_days

            // Status alur: pending → active → completed / expired / cancelled
            $table->enum('status', ['pending', 'active', 'completed', 'expired', 'cancelled'])->default('pending');

            // Pembayaran dilakukan manual di admin saat sesi pertama selesai
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
            $table->dateTime('paid_at')->nullable();
            $table->string('payment_note')->nullable(); // Catatan pembayaran admin

            $table->timestamps();
        });

        // === TABEL 3: SESI PT INDIVIDUAL ===
        // Tiap sesi PT yang dijadwalkan oleh member (booking slot waktu)
        Schema::create('pt_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pt_subscription_id')->constrained('pt_subscriptions')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->foreignId('coach_id')->constrained('coaches')->onDelete('cascade');

            $table->date('session_date'); // Tanggal sesi (Senin–Sabtu)
            $table->time('start_time'); // Jam mulai dipilih member (07:00–21:00)
            $table->time('end_time');   // Dihitung otomatis (start + duration_minutes)

            $table->integer('session_number'); // Sesi ke-berapa dari paket (1, 2, 3, ...)

            // Status sesi
            $table->enum('status', ['scheduled', 'completed', 'cancelled', 'no_show'])->default('scheduled');

            // Catatan latihan (diisi PT setelah sesi selesai)
            $table->text('notes')->nullable();

            // Alasan cancel (jika dibatalkan member, harus H-1)
            $table->text('cancel_reason')->nullable();
            $table->dateTime('cancelled_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pt_sessions');
        Schema::dropIfExists('pt_subscriptions');
        Schema::dropIfExists('pt_packages');
    }
};
