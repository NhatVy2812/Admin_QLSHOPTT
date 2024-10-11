<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMuc extends Model
{
    use HasFactory;
       // Tên bảng trong cơ sở dữ liệu
    protected $table = 'danhmuc';

    // Khóa chính của bảng
    protected $primaryKey = 'MaDanhMuc';

    // Tắt tự động tăng khóa chính
    public $incrementing = false;

    // Loại dữ liệu của khóa chính
    protected $keyType = 'string';

    // Các trường có thể gán hàng loạt
    protected $fillable = ['MaDanhMuc', 'TenDanhMuc'];

    // Tắt timestamps nếu bảng không có trường created_at và updated_at
    public $timestamps = false;
    public function chiTietDanhMucs()
{
    return $this->hasMany(chitietdanhmuc::class, 'MaDanhMuc', 'MaDanhMuc');
}

}
