<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialReportsTable extends Migration
{
    public function up()
    {
        Schema::create('financial_reports', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('staff_id')      // ID staff yang membuat laporan
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->foreignId('validated_by')  // ID admin yang memvalidasi laporan
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->enum('status', ['pending', 'approved', 'rejected'])
                  ->default('pending');       // Status validasi laporan
            $table->timestamp('validated_at')  // Waktu validasi
                  ->nullable();
            $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('financial_reports');
    }
}
