<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nim')->nullable()->after('role');
            $table->string('nidn_nip')->nullable()->after('nim');
            $table->string('jurusan')->nullable()->after('nidn_nip');
            $table->string('program_studi')->nullable()->after('jurusan');
            $table->string('semester')->nullable()->after('program_studi');
            $table->string('status_pengajar')->nullable()->after('semester');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nim',
                'nidn_nip',
                'jurusan',
                'program_studi',
                'semester',
                'status_pengajar',
            ]);
        });
    }
};
