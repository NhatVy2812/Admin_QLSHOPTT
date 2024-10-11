<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'voucher';
    protected $primaryKey = 'MaVoucher';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'MaVoucher',
        'TenVoucher',
        'PhanTramGiamGia',
        'Active',
        'NgayBD',
        'NgayKT',
        'MaKH'
    ];

    public $timestamps = false;

    // Define the relationship with KhachHang (Customer)
    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'MaKH', 'MaKH');
    }
}
