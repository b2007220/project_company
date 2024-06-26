<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BannerService;
use App\Forms\BannerForm;
use App\Exceptions\FormValidationException;

class BannerController extends Controller
{
    protected $bannerService, $bannerForm;

    public function __construct(BannerService $bannerService, BannerForm $bannerForm)
    {
        $this->bannerService = $bannerService;
        $this->bannerForm = $bannerForm;
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
        } catch (FormValidationException  $e) {

            return redirect()->back()->withErrors($e->getErrors())->withInput();
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
        } catch (FormValidationException  $e) {

            return redirect()->back()->withErrors($e->getErrors())->withInput();
        }
    }
    public function store(Request $request)
    {
        try {
            $this->bannerForm->validate($request->all());
            $banner = $this->bannerService->createBanner($request->all());
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thêm banner thành công',
                    'banner' => $banner,
                ]);
            }
            return redirect()->back()->with('success', 'Thêm banner thành công');
        } catch (FormValidationException  $e) {

            return redirect()->back()->withErrors($e->getErrors())->withInput();
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $this->bannerForm->validate($request->all());
            $banner = $this->bannerService->updateBanner($id, $request->all());
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cập nhật banner thành công',
                    'banner' => $banner,
                ]);
            }
            return redirect()->back()->with('success', 'Cập nhật banner thành công');
        } catch (FormValidationException  $e) {

            return redirect()->back()->withErrors($e->getErrors())->withInput();
        }
    }
}
