<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Atribut yang boleh diisi secara mass-assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Admin, User, dll
    ];

    /**
     * Atribut yang disembunyikan saat data dikirim ke frontend/API.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes', // opsional kalau pakai 2FA
        'two_factor_secret',          // opsional kalau pakai 2FA
    ];

    /**
     * Atribut yang dikonversi otomatis ke tipe data lain.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Laravel 10+ udah support otomatis hash password
    ];

    /**
     * Role check (opsional tambahan).
     * 
     * Kamu bisa tambah helper function kayak ini kalau mau:
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function peminjamans() {
        return $this->hasMany(Peminjaman::class);
    }
    
}
