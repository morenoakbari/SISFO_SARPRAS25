<?php

// app/Models/Kategori.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    /**
     * Relasi ke Barang (Kategori memiliki banyak Barang)
     */
    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }
}


