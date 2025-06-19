<?php

// app/Models/Peminjaman.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans'; // pastikan nama tabel sesuai dengan yang ada di database

    protected $fillable = [
        'user_id',
        'barang_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'jumlah',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }
}
