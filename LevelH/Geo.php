<?php

namespace Hackathon\LevelH;

class Geo
{
    public function __construct()

    {

    }

    public function getClosestCityFromId($id){
        $myCities = new CitiesData();
        $cities = $myCities->getCities();
        $srcCity = $myCities->getCityInfoById($id);
        $closestDistance = PHP_INT_MAX;
        $closestCity = $srcCity;
        $deg2RadLat1 = deg2rad($srcCity['lat']);
        $deg2RadLon1 = deg2rad($srcCity['long']);
        $cosDeg2RadLat1 = cos($deg2RadLat1);

        foreach ($cities as $dstCity) {
            if ($dstCity['id'] === $srcCity['id']
                || $dstCity['long'] > $srcCity['long'] + 1
                || $dstCity['long'] < $srcCity['long'] - 1){
                continue;
            }

            $distance = $this->computeDistance(
                $deg2RadLat1,
                $deg2RadLon1,
                $dstCity['lat'],
                $dstCity['long'],
                $cosDeg2RadLat1
            );

            if ($closestDistance > $distance) {
                $closestDistance = $distance;
                $closestCity = $dstCity;
            }
        }

        return $closestCity;

    }

    // function insertSort(&$a) {
    //     $n = count($a);
    //     for ($i = 0; $i < ($n - 1); $i++) {
    //         $key = $i + 1;
    //         $tmp = $a[$key];
    //         for ($j = ($i + 1); $j > 0; $j--) {
    //             if ($tmp['long'] < $a[$j - 1]['long']) {
    //                 $a[$j] = $a[$j - 1];
    //                 $key = $j - 1;
    //             }
    //         }
    //         $a[$key] = $tmp;
    //     }
    // }

    /**
     * Give the distance in meter between two points (in kilometer)
     *
     * @param $lat1
     * @param $lng1
     * @param $lat2
     * @param $lng2
     * @return int
     */

    private function computeDistance($deg2RadLat1, $deg2RadLon1, $lat2, $lng2, $cosDeg2RadLat1){

        $earth_radius = 6378137; // Earth Radius is 6378.137 km
        $rlo2 = deg2rad($lng2);
        $rla2 = deg2rad($lat2);
        $dlo = ($rlo2 - $deg2RadLon1) / 2;
        $dla = ($rla2 - $deg2RadLat1) / 2;
        $a =
            (sin($dla) * sin($dla)) +
            $cosDeg2RadLat1 * cos($rla2) *
            (sin($dlo) * sin($dlo));
        $d = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return ($earth_radius * $d) / pow(10, 3);
    }
};