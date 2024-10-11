<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    use HasFactory;
    protected $table = 'donhang';
    protected $primaryKey = 'MaDH';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'MaDH',
        'MaKH',
        'DiaChiGiaoHang',
        'NgayDatHang',
        'TongGiaTri',
        'TrangThai',
        'PhuongThucThanhToan'
    ];

    public function chiTietDonHang()
    {
        return $this->hasMany(ChiTietDonHang::class, 'MaDH', 'MaDH');
    }

    // Define the relationship with the KhachHang model
    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'MaKH', 'MaKH');
    }
    public $timestamps = false;
}
