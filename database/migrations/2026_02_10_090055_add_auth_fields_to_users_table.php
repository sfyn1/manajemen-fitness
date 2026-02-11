<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. Kolom Role (Admin, Owner, Coach, Member)
            // Default kita set 'member' agar aman
            $table->enum('role', ['admin', 'owner', 'coach', 'member'])->default('member')->after('email');

            // 2. Nomor HP (Untuk Admin/Coach/Owner, karena Member sudah punya di tabel members,
            // tapi sebaiknya User juga punya untuk keperluan Login/OTP)
            $table->string('phone_number')->nullable()->after('role');

            // 3. Kolom OTP (Untuk Reset Password via Email)
            $table->string('otp_code')->nullable()->after('password');
            $table->timestamp('otp_expires_at')->nullable()->after('otp_code');

            // 4. Status Wajib Ganti Password (Khusus Member Baru)
            $table->boolean('must_change_password')->default(false)->after('remember_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'phone_number',
                'otp_code',
                'otp_expires_at',
                'must_change_password'
            ]);
        });
    }
};