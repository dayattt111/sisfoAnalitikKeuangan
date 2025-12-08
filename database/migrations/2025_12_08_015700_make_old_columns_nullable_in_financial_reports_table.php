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
            // Make old deprecated columns nullable since we're using bulan/tahun instead
            $table->string('judul')->nullable()->change();
            $table->text('deskripsi')->nullable()->change();
            $table->date('periode_mulai')->nullable()->change();
            $table->date('periode_akhir')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financial_reports', function (Blueprint $table) {
            // Revert to NOT NULL (optional - usually not needed)
            $table->string('judul')->nullable(false)->change();
            $table->text('deskripsi')->nullable(false)->change();
            $table->date('periode_mulai')->nullable(false)->change();
            $table->date('periode_akhir')->nullable(false)->change();
        });
    }
};
