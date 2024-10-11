<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    use HasFactory;

    protected $table = 'khachhang';
    protected $primaryKey = 'MaKH';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'MaKH',
        'HoTen',
        'Email',
        'SDT',
        'LoaiKH',
        'Username',
        'Password',
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];

    public function donHang()
    {
        return $this->hasMany(DonHang::class, 'MaKH', 'MaKH');
    }
    
}
