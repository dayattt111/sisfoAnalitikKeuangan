<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('financial_report_id') // ID laporan keuangan
                  ->constrained('financial_reports')
                  ->cascadeOnDelete();
            $table->enum('type', ['debit', 'credit']) // Jenis: debit atau credit
                  ->comment('Jenis transaksi');
            $table->string('description')   // Deskripsi transaksi
                  ->comment('Deskripsi transaksi');
            $table->decimal('amount', 15, 2) // Nominal transaksi
                  ->comment('Jumlah nominal');
            $table->date('transaction_date') // Tanggal transaksi
                  ->comment('Tanggal transaksi');
            $table->timestamps();           // created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
