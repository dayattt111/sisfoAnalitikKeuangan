<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
      public function up(): void
      {
      Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financial_report_id')
                  ->nullable()
                  ->constrained('financial_reports')
                  ->nullOnDelete();
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->string('jenis');
            $table->decimal('jumlah', 15, 2);
            $table->text('keterangan')->nullable();
            $table->date('tanggal');
            $table->timestamps();
      });
      }


    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
