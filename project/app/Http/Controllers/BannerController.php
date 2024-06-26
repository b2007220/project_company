<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Services\BannerService;

class BannerController extends Controller
{
    protected $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function index(Request $request)
    {
        $banners = $this->bannerService->getAllBanners();
        if ($request->ajax()) {
            return view("admin.content.banner-data", ["banners" => $banners])->render();
        }
        return view("admin.layout.banner", ["banners" => $banners]);
    }
  
    public function active(Request $request, $id)
    {
        try {
            $banner = $this->bannerService->active($id);
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
            $this->bannerService->destroy($id);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Xóa banner thành công',
                ]);
            }
            return redirect()->back()->with('success', 'Xóa banner thành công');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Xóa banner thất bại');
        }
    }
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'link' => 'nullable|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $banner = $this->bannerService->createBanner($data);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thêm banner thành công',
                    'banner' => $banner,
                ]);
            }
            return redirect()->back()->with('success', 'Thêm banner thành công');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Thêm banner thất bại');
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'link' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $banner = $this->bannerService->updateBanner($id, $data);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cập nhật banner thành công',
                    'banner' => $banner,
                ]);
            }
            return redirect()->back()->with('success', 'Cập nhật banner thành công');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Cập nhật banner thất bại');
        }
    }
}
