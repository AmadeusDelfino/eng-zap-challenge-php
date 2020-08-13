<?php


namespace App\Traits;


trait PropertyLocationIsValid
{
    protected function locationIsValid($property)
    {
        $geoLocation = $property->address->geoLocation->location;

        return $geoLocation->lon != 0 && $geoLocation->lat != 0;
    }
}
