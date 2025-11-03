<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLogsTable extends Migration
{
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')  // ID user yang melakukan aktivitas
                  ->nullable()
                  ->constrained('users') // relasi ke tabel users
                  ->nullOnDelete();      // jika user dihapus, set NULL
            $table->text('activity');    // Deskripsi/detail aktivitas
            $table->timestamps();        // created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
}
