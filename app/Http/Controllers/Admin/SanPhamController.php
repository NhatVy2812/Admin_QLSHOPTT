<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use App\Models\ChiTietSanPham;
use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\HinhAnhSanPham;
use App\Models\DanhMuc;
use App\Models\chitietdanhmuc;
use App\Models\MauSac;
use App\Models\KichThuoc;
use App\Models\ChiTietDonHang;
use App\Http\Controllers\Controller;
class SanPhamController extends Controller
{
    private function generateUniqueMaSP()
    {
        do {
            // Tạo số ngẫu nhiên sau tiền tố SP
            $number = rand(1000, 9999); // Bạn có thể thay đổi phạm vi số nếu cần
            $maSP = 'SP' . $number;
        } while (SanPham::where('MaSP', $maSP)->exists());

        return $maSP;
    }

    public function index(){
        $products = SanPham::paginate(10);
        return view('Admin.SanPham.index', ['products' => $products]);
        
    }
    public function create(){
        $danhMucs = chitietdanhmuc::all();
        return view('Admin.SanPham.create', compact('danhMucs'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            'TenSP' => 'required|string|max:255',
            'MaCTDM' => 'required|string|max:255',
            'MoTa' => 'required|string',
            'TrangThai' => 'required|boolean',
            'img.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'TenSP.required' => 'Tên sản phẩm không được để trống.',
            'MaCTDM.required' => 'Mã danh mục không được để trống.',
            'MoTa.required' => 'Mô tả không được để trống.',
            'TrangThai.required' => 'Trạng thái không được để trống.',
        ]);
        // Generate a unique MaSP
        $data['MaSP'] = $this->generateUniqueMaSP();
        $moTa = strip_tags($request->input('MoTa'));
        // Create a new product
        $newProduct = SanPham::create([
            'MaSP' => $data['MaSP'],
            'TenSP' => $data['TenSP'],
            'MaCTDM' => $data['MaCTDM'],
            'TrangThai' => $data['TrangThai'],
            'MoTa' =>$moTa,
        ]);

        return redirect()->route('product.variants.create', ['product' => $data['MaSP']]);
    }

    public function destroy($MaSP)
    {
        // Tìm sản phẩm theo MaSP
        $product = SanPham::where('MaSP', $MaSP)->firstOrFail();
        $chiTietSanPhamIds = ChiTietSanPham::where('MaSP', $MaSP)->pluck('MaCTSP');

        // Kiểm tra xem có chi tiết sản phẩm nào trong ChiTietDonHang không
        $hasOrderDetails = ChiTietDonHang::whereIn('MaCTSP', $chiTietSanPhamIds)->exists();
    
        if ($hasOrderDetails) {
            // Nếu có chi tiết đơn hàng liên quan, không cho phép xóa
            return redirect()->route('product.index')->with('error', 'Không thể xóa sản phẩm này vì có chi tiết đơn hàng liên quan.');
        }
        ChiTietSanPham::where('MaSP', $MaSP)->delete();
        $product->delete();
        return redirect()->route('product.index');
    }

    public function edit($MaSP)
    {
        $product = SanPham::where('MaSP', $MaSP)->firstOrFail();
        $danhMucs = chitietdanhmuc::all();
     //   $images = HinhAnhSanPham::where('MaSP', $MaSP)->get();

        return view('Admin.SanPham.edit', compact('product', 'danhMucs'));
    }

    public function update(Request $request, $MaSP)
    {
        // Xác thực dữ liệu yêu cầu
        $data = $request->validate([
            'TenSP' => 'required|string|max:255',
            'MaCTDM' => 'required|string|max:255',
            'MoTa' => 'nullable|string',
            'TrangThai' => 'required|boolean',
        ]);
    
        // Tìm sản phẩm theo MaSP
        $product = SanPham::where('MaSP', $MaSP)->firstOrFail();
    
        // Cập nhật thông tin sản phẩm
        $moTa = strip_tags($request->input('MoTa'));
        $product->update([
            'TenSP' => $data['TenSP'],
            'MaCTDM' => $data['MaCTDM'],
            'TrangThai' =>$data['TrangThai'],
            'MoTa' => $moTa,
        ]);
    
       
        return redirect()->route('product.index')->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }
    
}
    



