<?php

// app/database/migrations/xxxx_xx_xx_xxxxxx_create_peminjamans_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // // Membuat tabel barangs
        // Schema::create('barangs', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('nama');
        //     $table->text('deskripsi')->nullable();
        //     $table->integer('stok')->default(0); // Menyimpan stok barang
        //     $table->timestamps();
        // });

        // Membuat tabel peminjamans
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('barang_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->enum('status', ['menunggu', 'diterima', 'ditolak', 'dikembalikan'])->default('menunggu');
            $table->integer('jumlah');
            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('peminjamans');
        Schema::dropIfExists('barangs');
    }
};
