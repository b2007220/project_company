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
}
