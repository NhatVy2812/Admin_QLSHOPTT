<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MauSac extends Model
{
    use HasFactory;
    protected $table = 'mausac';

    protected $fillable = [
        'MaMau',
        'TenMau'
    ];
    protected $primaryKey = 'MaMau';

    // Không sử dụng tự động tăng cho khóa chính
    public $incrementing = false;

    // Đặt kiểu dữ liệu của khóa chính
    protected $keyType = 'string';

    public function chiTietSanPhams()
    {
        return $this->hasMany(ChiTietSanPham::class, 'MaMau', 'MaMau');
    }
}
