<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownloadsTable extends Migration
{
    public function up()
    {
        Schema::create('downloads', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('manager_id')      // ID user (manager) pengunduh
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->foreignId('financial_report_id') // ID laporan yang diunduh
                  ->constrained('financial_reports')
                  ->cascadeOnDelete();
            $table->timestamp('downloaded_at')    // Waktu laporan diunduh
                  ->useCurrent();
            // Tidak menggunakan created_at/updated_at karena sudah ada downloaded_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('downloads');
    }
}
