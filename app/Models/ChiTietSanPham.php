<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietSanPham extends Model
{
    use HasFactory;
    protected $table = 'chitietsanpham';
    public $timestamps = false;
    // Đặt các thuộc tính có thể được gán đại diện cho các cột của bảng
    protected $fillable = [
        'MaCTSP',
        'MaSP',
        'MaSize',
        'MaMau',
        'SKU',
        'SoLuongTonKho',
        'HinhAnh'
    ];

    // Chỉ định khóa chính của bảng
    protected $primaryKey = 'MaCTSP';

    // Không sử dụng tự động tăng cho khóa chính
    public $incrementing = false;

    // Đặt kiểu dữ liệu của khóa chính
    protected $keyType = 'string';

    // Xác định các mối quan hệ đến các model khác

    /**
     * Mối quan hệ đến model `SanPham`
     */
    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'MaSP', 'MaSP');
    }

    /**
     * Mối quan hệ đến model `MauSac`
     */
    public function mauSac()
    {
        return $this->belongsTo(MauSac::class, 'MaMau', 'MaMau');
    }

    /**
     * Mối quan hệ đến model `KichThuoc`
     */
    public function kichThuoc()
    {
        return $this->belongsTo(KichThuoc::class, 'MaSize', 'MaSize');
    }
    public function chiTietDonHangs()
    {
        return $this->hasMany(ChiTietDonHang::class, 'MaCTSP', 'MaCTSP');
    }
}
