<?php


namespace App\Traits;


use App\Enums\BoundingBoxValues;

trait IsInBoundingBox
{
    protected function isInBoundingBox($address)
    {
        $location = $address->geoLocation->location;

        return ($location->lon >= BoundingBoxValues::BOUNDING_BOX_MIN_LON && $location->lon <= BoundingBoxValues::BOUNDING_BOX_MAX_LON)
            && ($location->lat >= BoundingBoxValues::BOUNDING_BOX_MIN_LAT && $location->lat <= BoundingBoxValues::BOUNDING_BOX_MAX_LAT);
    }
}
