<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChiTietDonNhapHang;
use App\Models\ChiTietSanPham;
use App\Models\DonNhapHang;
use App\Models\SanPham;
use App\Models\ChiTietSanPhamNhap;

class ChiTietDonNhapHangController extends Controller
{
    // public function index()
    // {
    //     $chitietdonnhaphangs = ChiTietDonNhapHang::all();
    //     return view('Admin.ChiTietDonNhapHang.index', compact('chitietdonnhaphangs'));
    // }

    // public function create($maNH)
    // {
    //     // Lấy thông tin đơn nhập hàng và danh sách sản phẩm
    //     $donNhapHang = DonNhapHang::findOrFail($maNH);
    //     $SanPhams = SanPham::all(); // Lấy tất cả sản phẩm hoặc tùy chỉnh theo nhu cầu

    //     // Trả về view với dữ liệu cần thiết
    //     return view('Admin.ChiTietDonNhapHang.create', compact('donNhapHang', 'SanPhams'));
    // }
    public function store(Request $request, $maNH)
    {
       
        $request->validate([
            'donnhaphang_id' => 'required|string',
            'products' => 'required|array',
            'products.*' => 'string',
        ]);
    
        $donnhaphangId = $request->input('donnhaphang_id');
        $products = $request->input('products');
        
        foreach ($products as $productId) {
            $existingRecord = ChiTietDonNhapHang::where('MaNH', $donnhaphangId)
                                                ->where('MaSP', $productId)
                                                ->first();
    
            if (!$existingRecord) {
                ChiTietDonNhapHang::create([
                    'MaNH' => $donnhaphangId,
                    'MaSP' => $productId,
                    'TongSoLuong' => 1, // Bạn có thể thay đổi giá trị này nếu cần
                    'GiaNhap' => 0, // Bạn có thể thay đổi giá trị này nếu cần
                    'ThanhTien' => 0 // Bạn có thể thay đổi giá trị này nếu cần
                ]);
            }
        }
    
        return redirect()->back()->with('success', 'Sản phẩm đã được lưu thành công.');
    }
    
    
   // Controller
    // public function edit($maNH, $maCTSP)
    // {
    //     $chiTiet = ChiTietDonNhapHang::where('MaNH', $maNH)
    //         ->where('MaSP', $maCTSP)
    //         ->firstOrFail();
       
    //     return view('Admin.ChiTietDonNhapHang.edit', compact('chiTiet'));
    // }

    public function update(Request $request, $maNH)
        {
            $validated = $request->validate([
                'MaSP' => 'required|string',
                'TongSoLuong' => 'required|integer',
                'GiaNhap' => 'required|numeric',
            ]);

            $chitiet = ChiTietDonNhapHang::where('MaNH', $maNH)
                                        ->where('MaSP', $request->MaSP)
                                        ->first();

            if ($chitiet) {
                $chitiet->TongSoLuong = $request->TongSoLuong;
                $chitiet->GiaNhap = $request->GiaNhap;
                $chitiet->ThanhTien = $request->TongSoLuong * $request->GiaNhap;
                $chitiet->save();

                return response()->json([
                    'success' => true,
                    'new_total_price' => format_currency($chitiet->ThanhTien)
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy sản phẩm'
                ]);
            }
        }

        public function destroy($maNH, $maCTSP)
        {
            $chiTiet = ChiTietDonNhapHang::where('MaNH', $maNH)
                ->where('MaSP', $maCTSP)
                ->firstOrFail();
            
            $chiTiet->delete();
            ChiTietSanPhamNhap::where('MaNH', $maNH)
            ->where('MaSP', $maCTSP)
            ->delete();
            return redirect()->route('donnhaphang.show', $maNH)->with('success', 'Chi tiết đơn nhập hàng đã được xóa!');
        }
     

        public function getMaCTSPOptions($maSP)
        {
            $chitietsanphams = ChiTietSanPham::where('MaSP', $maSP)->get();

            $options = $chitietsanphams->map(function ($item) {
                return [
                    'MaCTSP' => $item->MaCTSP,
                    'MaMau' => $item->MaMau,
                    'MaSize' => $item->MaSize,
                ];
            });

            return response()->json([
                'success' => true,
                'maCTSPOptions' => $options
            ]);
        }
        public function store_CTSP(Request $request, $donnhaphang)
        {
            
            $maSP = $request->input('maSP');
            $data = $request->except('maSP'); // Loại bỏ maSP từ dữ liệu để dễ xử lý

            foreach ($data['soLuongNhap'] as $maCTSP => $soLuongNhap) {
                if ($soLuongNhap > 0) { // Chỉ lưu nếu số lượng nhập lớn hơn 0
                    ChiTietSanPhamNhap::updateOrCreate(
                        [
                            'MaNH' => $donnhaphang, // Lấy trực tiếp từ route
                            'MaSP' => $maSP,
                            'MaCTSP' => $maCTSP,
                        ],
                        [
                            'SoLuongNhap' => $soLuongNhap,
                        ]
                    );
                }
            }

            return response()->json(['success' => true]);
        }


    }
