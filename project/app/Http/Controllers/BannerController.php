<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $banners = Banner::latest()->paginate(5);
        if ($request->ajax()) {
            return view("admin.content.banner-data", ["banners" => $banners])->render();
        }
        return view("admin.layout.banner", ["banners" => $banners]);
    }
    public function active(Request $request, $id)
    {
        try {
            $banner = Banner::findOrFail($id);
            $banner->status = !$banner->status;
            $banner->save();
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'banner' => $banner
                ]);
            }
            return redirect()->back()->with('success', 'Chỉnh sửa trạng thái banner thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi chỉnh sửa trạng thái banner');
        }
    }
    public function destroy(Request $request, $id)
    {
        try {
            $banner = Banner::findOrFail($id);

            if ($banner->delete()) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'banner' => $banner
                    ]);
                }
                return redirect()->back()->with('success', 'Xóa banner thành công');
            } else {
                if ($request->ajax()) {
                    return response()->json(['success' => false]);
                }
                return redirect()->back()->with('error', 'Xóa banner thất bại');
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false]);
            }
            return redirect()->back()->with('error', 'Xóa banner thất bại');
        }
    }
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'link' => 'nullable|string',
            ]);
            $banner = Banner::create($data);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thêm banner thành công',
                    'banner' => $banner,
                ]);
            }
            return redirect()->back()->with('success', 'Thêm banner thành công');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false]);
            }
            return redirect()->back()->with('error', 'Thêm banner thất bại');
        }
    }
    public function storeImage(Request $request, $id)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $banner = Banner::findOrFail($id);
        if ($request->file('image')) {
            $image = $request->file('image');
            $destinationPath = 'banner/';
            if ($banner->image && file_exists($destinationPath . $banner->image)) {
                unlink($destinationPath . $banner->image);
            }
            $profileImage = date('YmdHis') . "_" . uniqid() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $banner->image = $profileImage;
            $banner->save();
        } else {
            error_log('No files found in the request');
        }
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thông tin thành công',
                'image' => $banner->image,
            ]);
        }
        return redirect()->back()->with('success', 'Cập nhật thông tin thành công');
    }
}
