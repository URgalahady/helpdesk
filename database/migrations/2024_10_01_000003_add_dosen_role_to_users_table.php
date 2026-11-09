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
        // Modify the 'role' column to include 'dosen' option
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['mahasiswa', 'admin', 'dosen'])
                ->default('mahasiswa')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum without 'dosen'
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['mahasiswa', 'admin'])
                ->default('mahasiswa')
                ->change();
        });
    }
};