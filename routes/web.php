<?php

use App\Models\SanPham;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\Admin\ChiTietSanPhamController;
use App\Http\Controllers\Admin\DanhMucController;
use App\Http\Controllers\Admin\KhuyenMaiController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DonHangController;
use App\Http\Controllers\Admin\DonNhapHangController;
use App\Http\Controllers\Admin\ChiTietDonNhapHangController;
use App\Http\Controllers\Admin\KhachHangController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\NhanVienController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin', function () {
    return view('Admin.welcome');
});
Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->group(function ()  {
    //San pham
    Route::get('/product', [SanPhamController::class, 'index'])->name('product.index');
    Route::get('/product/create', [SanPhamController::class, 'create'])->name('product.create');
    Route::post('/product', [SanPhamController::class, 'store'])->name('product.store');
    Route::get('/product/{MaSP}/edit', [SanPhamController::class, 'edit'])->name('product.edit');
    Route::put('/product/{MaSP}', [SanPhamController::class, 'update'])->name('product.update');
    Route::delete('/product/{MaSP}', [SanPhamController::class, 'destroy'])->name('product.destroy');


    //ChiTietSanPham
    Route::get('/product/{product}/details/create', [ChiTietSanPhamController::class, 'create'])->name('product.variants.create');
    Route::post('/product/{product}/detail', [ChiTietSanPhamController::class, 'store'])->name('product.variants.store');
    Route::get('/product/{MaSP}/details', [ChiTietSanPhamController::class, 'show'])->name('product.details');
    Route::get('chitietsanpham/{MaCTSP}/edit', [ChiTietSanPhamController::class, 'edit'])->name('chitietsanpham.edit');
    Route::put('chitietsanpham/{MaCTSP}', [ChiTietSanPhamController::class, 'update'])->name('chitietsanpham.update');
    Route::delete('chitietsanpham/{MaCTSP}', [ChiTietSanPhamController::class, 'destroy'])->name('chitietsanpham.destroy');

    //DanhMuc
    Route::resource('danhmuc', DanhMucController::class);
    Route::get('danhmuc/{id}/chitiet', [DanhMucController::class, 'getChiTiet']);
    Route::post('danhmuc/chitiet/save', 'DanhMucController@saveChitiet')->name('danhmuc.chitiet.save');
    Route::delete('danhmuc/chitiet/{id}/delete', [DanhMucController::class, 'deleteChiTiet']);

    //KhuyenMai
    Route::resource('khuyenmai', KhuyenMaiController::class);
    // Route::resource('sanphamkhuyenmai', SanPhamKhuyenMaiController::class);

    //SanPhamKhuyenMai
    Route::get('khuyenmai/{maKM}/sanpham/create', [KhuyenMaiController::class, 'create_SPKM'])->name('sanphamkhuyenmai.create');
    Route::post('khuyenmai/{maKM}/sanpham', [KhuyenMaiController::class, 'store_SPKM'])->name('sanphamkhuyenmai.store');
    Route::delete('khuyenmai/{maKM}/chitiet/{MaCTSP}', [KhuyenMaiController::class, 'destroy_SPKM'])->name('sanphamkhuyenmai.destroy');
   
    //DonHang
    Route::resource('donhang', DonHangController::class);
    Route::get('/thongke', [DonHangController::class, 'showDashboard'])->name('donhang.dashboard');
    Route::get('donhang/{id}/pdf', [DonHangController::class, 'print'])->name('donhang.print');
    Route::post('/donhang/updateStatus', [DonHangController::class, 'updateStatus'])->name('donhang.updateStatus');

    //DonNhapHang
    Route::resource('donnhaphang', DonNhapHangController::class);
    // Route::get('donnhaphang/{maNH}/chitiet/create', [ChiTietDonNhapHangController::class, 'create'])->name('chitietdonnhaphang.create');
    Route::post('donnhaphang/{maNH}/chitiet', [ChiTietDonNhapHangController::class, 'store'])->name('chitietdonnhaphang.store');
    // Route::get('donnhaphang/{maNH}/chitiet/{MaCTSP}/edit', [ChiTietDonNhapHangController::class, 'edit'])->name('chitietdonnhaphang.edit');
    Route::post('donnhaphang/{maNH}/chitietsp', [ChiTietDonNhapHangController::class, 'update'])->name('chitietdonnhaphang.update');
    Route::delete('donnhaphang/{maNH}/chitiet/{MaCTSP}', [ChiTietDonNhapHangController::class, 'destroy'])->name('chitietdonnhaphang.destroy');
   
    //ChiTietSanPhamNhap
    Route::get('chitietsanphamnhap/{maSP}', [ChiTietDonNhapHangController::class, 'getMaCTSPOptions']);
    Route::post('/chitietsanphamnhap/{donnhaphang}', [ChiTietDonNhapHangController::class, 'store_CTSP'])->name('chitietsanphamnhap.store_CTSP');


    Route::get('/filter-by-date', [DonHangController::class, 'filterByDate']);
    //Khach Hang
    Route::get('/khachhang', [KhachHangController::class, 'index'])->name('khachhang.index');
    Route::delete('/khachhang/{id}', [KhachHangController::class, 'destroy'])->name('khachhang.destroy');
   
  
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/voucher', [VoucherController::class, 'index'])->name('voucher.index');
    Route::get('/orders-current-month', [DashboardController::class, 'getOrdersForCurrentMonth']);
    Route::resource('nhanvien', NhanVienController::class);
});
