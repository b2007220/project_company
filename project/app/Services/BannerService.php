<?php

namespace App\Services;

use App\Models\Banner;

class BannerService
{
    public function getAllBanners()
    {
        return Banner::orderBy('created_at', 'desc')->paginate(5);
    }
    public function getRandomBanner()
    {
        return Banner::where('status', true)->inRandomOrder()->limit(3)->get();
    }
    public function active($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->status = !$banner->status;
        $banner->save();
        return $banner;
    }
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return $banner;
    }
    public function createBanner($data)
    {
        $banner = new Banner();
        $banner->link = $data['link'];
        if (isset($data['image'])) {
            $image = $data['image'];
            $destinationPath = 'banner/';
            if ($banner->image && file_exists($destinationPath . $banner->image)) {
                unlink($destinationPath . $banner->image);
            }
            $profileImage = date('YmdHis') . "_" . uniqid() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $banner->image = $profileImage;
        }
        $banner->save();
        return $banner;
    }
    public function updateBanner($id, $data)
    {
        $banner = Banner::findOrFail($id);
        $banner->link = $data['link'];
        if (isset($data['image'])) {
            $image = $data['image'];
            $destinationPath = 'banner/';
            if ($banner->image && file_exists($destinationPath . $banner->image)) {
                unlink($destinationPath . $banner->image);
            }
            $profileImage = date('YmdHis') . "_" . uniqid() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $banner->image = $profileImage;
        }
        $banner->save();
        return $banner;
    }
}
