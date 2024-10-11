<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    use HasFactory;
    protected $table = 'sanpham';
    protected $primaryKey = 'MaSP';
    public $timestamps = false;

    protected $fillable = [
        'MaSP', 
        'TenSP', 
        'MaCTDM', 
        'MoTa',
        'TongSL',
        'GiaBan',
        'TrangThai'
    ];

    public function getKeyType()
    {
        return 'string';
    }
    public function chiTietDanhMuc()
    {
        return $this->belongsTo(chitietdanhmuc::class, 'MaCTDM', 'MaCTDM');
    }
    // public function hinhanhsanphams()
    // {
    //     return $this->hasMany(HinhAnhSanPham::class, 'MaSP', 'MaSP');
    // }

    public function chitietsanphams()
    {
        return $this->hasMany(ChiTietSanPham::class, 'MaSP', 'MaSP');
    }
    public function soLuongBan()
    {
        return $this->hasMany(ChiTietDonHang::class, 'MaCTSP', 'MaCTSP')
            ->selectRaw('SUM(SoLuong) as total')
            ->groupBy('MaCTSP');
    }
}
