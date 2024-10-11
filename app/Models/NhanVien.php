<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    use HasFactory;
    protected $table = 'nhanvien';
    protected $primaryKey = 'MaNV';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'MaNV',
        'HoTen',
        'Email',
        'SDT',
        'Username',
        'Password',
        'VaiTro',
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];


    
}
