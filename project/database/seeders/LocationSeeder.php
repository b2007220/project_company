<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            ["name" => "store", "lat" => 10.799132682525615, "lng" => 106.66912966947433, "is_store" => 1],
            ["name" => "Bắc Giang", "lat" => 21.333, "lng" => 106.333, "is_store" => 0],
            ["name" => "Bắc Kạn", "lat" => 22.167, "lng" => 105.833, "is_store" => 0],
            ["name" => "Cao Bằng", "lat" => 22.667, "lng" => 106, "is_store" => 0],
            ["name" => "Hà Giang", "lat" => 22.75, "lng" => 105, "is_store" => 0],
            ["name" => "Lạng Sơn", "lat" => 21.75, "lng" => 106.5, "is_store" => 0],
            ["name" => "Phú Thọ", "lat" => 21.333, "lng" => 105.167, "is_store" => 0],
            ["name" => "Quảng Ninh", "lat" => 21.25, "lng" => 107.333, "is_store" => 0],
            ["name" => "Thái Nguyên", "lat" => 21.667, "lng" => 105.833, "is_store" => 0],
            ["name" => "Tuyên Quang", "lat" => 22.117, "lng" => 105.25, "is_store" => 0],
            ["name" => "Lào Cai", "lat" => 22.333, "lng" => 104, "is_store" => 0],
            ["name" => "Yên Bái", "lat" => 21.5, "lng" => 104.667, "is_store" => 0],
            ["name" => "Điện Biên", "lat" => 21.383, "lng" => 103.017, "is_store" => 0],
            ["name" => "Hòa Bình", "lat" => 20.333, "lng" => 105.25, "is_store" => 0],
            ["name" => "Lai Châu", "lat" => 22, "lng" => 103, "is_store" => 0],
            ["name" => "Sơn La", "lat" => 21.167, "lng" => 104, "is_store" => 0],
            ["name" => "Bắc Ninh", "lat" => 21.083, "lng" => 106.167, "is_store" => 0],
            ["name" => "Hà Nam", "lat" => 20.583, "lng" => 106, "is_store" => 0],
            ["name" => "Hải Dương", "lat" => 20.917, "lng" => 106.333, "is_store" => 0],
            ["name" => "Hưng Yên", "lat" => 20.833, "lng" => 106.083, "is_store" => 0],
            ["name" => "Nam Định", "lat" => 20.25, "lng" => 106.25, "is_store" => 0],
            ["name" => "Ninh Bình", "lat" => 20.25, "lng" => 105.833, "is_store" => 0],
            ["name" => "Thái Bình", "lat" => 20.5, "lng" => 106.333, "is_store" => 0],
            ["name" => "Vĩnh Phúc", "lat" => 21.3, "lng" => 105.6, "is_store" => 0],
            ["name" => "Hà Nội", "lat" => 21.02833, "lng" => 105.85417, "is_store" => 0],
            ["name" => "Hải Phòng", "lat" => 20.865139, "lng" => 106.683833, "is_store" => 0],
            ["name" => "Hà Tĩnh", "lat" => 18.333, "lng" => 105.9, "is_store" => 0],
            ["name" => "Nghệ An", "lat" => 19.333, "lng" => 104.833, "is_store" => 0],
            ["name" => "Quảng Bình", "lat" => 17.5, "lng" => 106.333, "is_store" => 0],
            ["name" => "Quảng Trị", "lat" => 16.75, "lng" => 107, "is_store" => 0],
            ["name" => "Thanh Hóa", "lat" => 20, "lng" => 105.5, "is_store" => 0],
            ["name" => "Thừa Thiên-Huế", "lat" => 16.333, "lng" => 107.583, "is_store" => 0],
            ["name" => "Đắk Lắk", "lat" => 12.667, "lng" => 108.05, "is_store" => 0],
            ["name" => "Đắk Nông", "lat" => 11.983, "lng" => 107.7, "is_store" => 0],
            ["name" => "Gia Lai", "lat" => 13.75, "lng" => 108.25, "is_store" => 0],
            ["name" => "Kon Tum", "lat" => 14.75, "lng" => 107.917, "is_store" => 0],
            ["name" => "Lâm Đồng", "lat" => 11.95, "lng" => 108.433, "is_store" => 0],
            ["name" => "Bình Định", "lat" => 14.167, "lng" => 109, "is_store" => 0],
            ["name" => "Bình Thuận", "lat" => 10.933, "lng" => 108.1, "is_store" => 0],
            ["name" => "Khánh Hòa", "lat" => 12.25, "lng" => 109.2, "is_store" => 0],
            ["name" => "Ninh Thuận", "lat" => 11.75, "lng" => 108.833, "is_store" => 0],
            ["name" => "Phú Yên", "lat" => 13.167, "lng" => 109.167, "is_store" => 0],
            ["name" => "Quảng Nam", "lat" => 15.58333, "lng" => 107.91667, "is_store" => 0],
            ["name" => "Quảng Ngãi", "lat" => 15, "lng" => 108.667, "is_store" => 0],
            ["name" => "Đà Nẵng", "lat" => 16.06944, "lng" => 108.20972, "is_store" => 0],
            ["name" => "Bà Rịa-Vũng Tàu", "lat" => 10.583, "lng" => 107.25, "is_store" => 0],
            ["name" => "Bình Dương", "lat" => 11.167, "lng" => 106.667, "is_store" => 0],
            ["name" => "Bình Phước", "lat" => 11.75, "lng" => 106.917, "is_store" => 0],
            ["name" => "Đồng Nai", "lat" => 11.117, "lng" => 107.183, "is_store" => 0],
            ["name" => "Tây Ninh", "lat" => 11.333, "lng" => 106.167, "is_store" => 0],
            ["name" => "Hồ Chí Minh", "lat" => 10.8, "lng" => 106.65, "is_store" => 0],
            ["name" => "An Giang", "lat" => 10.5, "lng" => 105.167, "is_store" => 0],
            ["name" => "Bạc Liêu", "lat" => 9.25, "lng" => 105.75, "is_store" => 0],
            ["name" => "Bến Tre", "lat" => 10.167, "lng" => 106.5, "is_store" => 0],
            ["name" => "Cà Mau", "lat" => 9.083, "lng" => 105.083, "is_store" => 0],
            ["name" => "Đồng Tháp", "lat" => 10.667, "lng" => 105.667, "is_store" => 0],
            ["name" => "Hậu Giang", "lat" => 9.783, "lng" => 105.467, "is_store" => 0],
            ["name" => "Kiên Giang", "lat" => 10, "lng" => 105.167, "is_store" => 0],
            ["name" => "Long An", "lat" => 10.667, "lng" => 106.167, "is_store" => 0],
            ["name" => "Sóc Trăng", "lat" => 9.667, "lng" => 105.833, "is_store" => 0],
            ["name" => "Tiền Giang", "lat" => 10.417, "lng" => 106.167, "is_store" => 0],
            ["name" => "Trà Vinh", "lat" => 9.833, "lng" => 106.25, "is_store" => 0],
            ["name" => "Vĩnh Long", "lat" => 10.167, "lng" => 106, "is_store" => 0],
            ["name" => "Cần Thơ", "lat" => 10.033, "lng" => 105.783, "is_store" => 0],
        ];
        DB::table('locations')->insert($locations);
    }
}
