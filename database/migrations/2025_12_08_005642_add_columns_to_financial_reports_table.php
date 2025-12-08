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
        Schema::table('financial_reports', function (Blueprint $table) {
            // Rename staff_id to user_id for consistency
            $table->renameColumn('staff_id', 'user_id');
            
            // Add missing columns
            $table->string('judul')->after('id');
            $table->text('deskripsi')->nullable()->after('judul');
            $table->date('periode_mulai')->nullable()->after('deskripsi');
            $table->date('periode_akhir')->nullable()->after('periode_mulai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financial_reports', function (Blueprint $table) {
            $table->renameColumn('user_id', 'staff_id');
            $table->dropColumn(['judul', 'deskripsi', 'periode_mulai', 'periode_akhir']);
        });
    }
};
