<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HinhAnhSanPham extends Model
{
    use HasFactory;
    protected $table = 'hinhanhsanpham';
    protected $primaryKey = ['MaHinh', 'MaSP']; // Đảm bảo rằng đây là khóa chính đúng
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['MaHinh', 'MaSP', 'HinhAnh'];
    public $timestamps = false;
    public function sanpham()
    {
        return $this->belongsTo(SanPham::class, 'MaSP', 'MaSP');
    }
}
