<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\KhachHang;
use App\Models\DonHang;
use App\Models\GioHang;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::all();
        return view('Admin.Voucher.index', compact('vouchers'));
    }

    public function create()
    {
        return view('vouchers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'MaVoucher' => 'required|unique:vouchers,MaVoucher|max:100',
            'TenVoucher' => 'required|max:200',
            'PhanTramGiamGia' => 'required|integer',
            'Active' => 'required|integer',
            'NgayBD' => 'nullable|date',
            'NgayKT' => 'nullable|date',
        ]);

        Voucher::create($request->all());
        return redirect()->route('vouchers.index')->with('success', 'Voucher created successfully.');
    }

    public function show(Voucher $voucher)
    {
        return view('vouchers.show', compact('voucher'));
    }

    public function edit(Voucher $voucher)
    {
        return view('vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $request->validate([
            'TenVoucher' => 'required|max:200',
            'PhanTramGiamGia' => 'required|integer',
            'Active' => 'required|integer',
            'NgayBD' => 'nullable|date',
            'NgayKT' => 'nullable|date',
        ]);

        $voucher->update($request->all());
        return redirect()->route('vouchers.index')->with('success', 'Voucher updated successfully.');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect()->route('vouchers.index')->with('success', 'Voucher deleted successfully.');
    }
}
