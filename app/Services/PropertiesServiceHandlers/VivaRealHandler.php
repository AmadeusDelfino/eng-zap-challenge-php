<?php


namespace App\Services\PropertiesServiceHandlers;


use App\Enums\TypeOfInteractionWithTheProperty;
use App\Traits\IsInBoundingBox;
use App\Traits\PropertyLocationIsValid;
use App\Traits\PropertyResponseMake;

class VivaRealHandler
{
    use
        PropertyLocationIsValid,
        PropertyResponseMake,
        IsInBoundingBox;

    const RENTAL_MAX_VALUE = 4000;
    const SALE_MAX_VALUE = 700000;


    public function __invoke(array $properties, int $page, int $pageSize): array
    {
        $properties = array_filter($properties, [$this, 'eligibleForVivaReal']);

        return $this->makePropertiesResponse($properties, $page, $pageSize);
    }

    protected function eligibleForVivaReal($property)
    {
        return $this->eligibleByPrices($property)
            && ($this->locationIsValid($property))
            && $this->eligibleForTheCondominiumFee($property);
    }

    protected function eligibleByPrices($property)
    {
        $pricingInfos = $property->pricingInfos;
        // When the property is inside the bounding box, it is necessary to increase the maximum rent by 50%
        $rentalTotalPrice = $this->isInBoundingBox($property->address)
            ? self::RENTAL_MAX_VALUE + $this->getPercentOfValue(self::RENTAL_MAX_VALUE, 50)
            : self::RENTAL_MAX_VALUE;

        return (
            ($pricingInfos->businessType === TypeOfInteractionWithTheProperty::BUSINESS_TYPE_SALE && $pricingInfos->price <= self::SALE_MAX_VALUE)
            ||
            ($pricingInfos->businessType === TypeOfInteractionWithTheProperty::BUSINESS_TYPE_RENTAL && $pricingInfos->rentalTotalPrice <= $rentalTotalPrice)
        );
    }

    protected function eligibleForTheCondominiumFee($property)
    {
        $pricingInfos = $property->pricingInfos;
        // This algorithm is only necessary if the property is for rent. If the property is for sale, return true
        if ($pricingInfos->businessType === TypeOfInteractionWithTheProperty::BUSINESS_TYPE_SALE) {
            return true;
        }
        // If the value of the condominium is invalid, the business rule imposes that we must treat the validation as false
        if (!isset($pricingInfos->monthlyCondoFee) || !is_numeric($pricingInfos->monthlyCondoFee)) {
            return false;
        }

        $thirtyPercentOfTheRent = $this->getPercentOfValue($pricingInfos->rentalTotalPrice, 30);

        return $pricingInfos->monthlyCondoFee < $thirtyPercentOfTheRent;
    }

    protected function getPercentOfValue($value, $percent)
    {
        return $value > 0 ? round($value * ($percent / 100), 2) : 0;
    }
}
