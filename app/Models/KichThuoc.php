<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KichThuoc extends Model
{
    use HasFactory;
    protected $table = 'kichthuoc';

    protected $fillable = [
        'MaSize',
        'TenSize'
    ];
    protected $primaryKey = 'MaSize';

    // Không sử dụng tự động tăng cho khóa chính
    public $incrementing = false;

    // Đặt kiểu dữ liệu của khóa chính
    protected $keyType = 'string';
    public function chiTietSanPhams()
    {
        return $this->hasMany(ChiTietSanPham::class, 'MaSize', 'MaSize');
    }
}
