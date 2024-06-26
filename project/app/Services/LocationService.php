<?php

namespace App\Services;

use App\Models\Location;

class LocationService
{
    public function getAllLocations()
    {
        return Location::orderBy('created_at', 'desc')->paginate(5);
    }
    public function getAllLocationForSelect()
    {
        return Location::where('is_store',0)->orderBy('created_at', 'desc')->get();
    }
    public function distanceCalculate($id)
    {
        $destination = Location::findOrFail($id);
        $longitudeDestination = $destination->lng;
        $latitudeDestination = $destination->lat;

        $earthRadius = 6371;

        $shop = Location::where('is_store', 1)->first();
        $longitudeShop = $shop->lng;
        $latitudeShop = $shop->lat;

        $toRadians = function ($degree) {
            return $degree * (pi() / 180);
        };

        $latFromRad = $toRadians($latitudeShop);
        $lonFromRad = $toRadians($longitudeShop);
        $latToRad = $toRadians($latitudeDestination);
        $lonToRad = $toRadians($longitudeDestination);

        $latDelta = $latToRad - $latFromRad;
        $lonDelta = $lonToRad - $lonFromRad;

        $a = sin($latDelta / 2) ** 2 + cos($latFromRad) * cos($latToRad) * sin($lonDelta / 2) ** 2;
        $c = 2 * asin(sqrt($a));

        return $c * $earthRadius;
    }

    public function getShipFee($id)
    {
        $distance = $this->distanceCalculate($id);

        $feeFactor = 10;
        $shipFee = $distance * $feeFactor;
        return (int) $shipFee;
    }
}
