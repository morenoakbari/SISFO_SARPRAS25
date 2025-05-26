<?php
// app/Models/Barang.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['barang_id', 'nama', 'stok', 'kategori_id', 'foto'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }


    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
    
}
