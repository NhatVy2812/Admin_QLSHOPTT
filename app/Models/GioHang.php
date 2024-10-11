<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GioHang extends Model
{
    use HasFactory;

    // Tên bảng
    protected $table = 'giohang';

    // Khóa chính của bảng
    protected $primaryKey = 'MaGH';

    // Không sử dụng auto-incrementing cho khóa chính vì khóa chính là kiểu char
    public $incrementing = false;

    // Định nghĩa kiểu dữ liệu của khóa chính là kiểu string
    protected $keyType = 'string';

    // Tắt timestamps (vì bảng không có trường created_at và updated_at)
    public $timestamps = false;

    // Các cột có thể được fill từ request hoặc array
    protected $fillable = [
        'MaGH',
        'MaKH',
        'NgayTao',
        'TongGiaTri',
    ];

    // Quan hệ với bảng KhachHang (nếu cần)
    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'MaKH', 'MaKH');
    }
}