<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietDanhMuc extends Model
{
    use HasFactory;
    protected $table = 'chitietdanhmuc';
    protected $primaryKey = 'MaCTDM';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'MaCTDM',
        'TenCTDM',
        'MaDanhMuc'
    ];

    // Quan hệ với bảng DanhMuc
    public function danhMuc()
    {
        return $this->belongsTo(DanhMuc::class, 'MaDanhMuc', 'MaDanhMuc');
    }

    // Quan hệ với bảng SanPham
    public function sanPham()
    {
        return $this->hasMany(SanPham::class, 'MaCTDM', 'MaCTDM');
    }
}
