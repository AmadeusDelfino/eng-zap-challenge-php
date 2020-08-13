<?php


namespace App\Services\PropertiesServiceHandlers;


use App\Enums\TypeOfInteractionWithTheProperty;
use App\Traits\IsInBoundingBox;
use App\Traits\PropertyLocationIsValid;
use App\Traits\PropertyResponseMake;

class ZapHandler
{
    use PropertyLocationIsValid, PropertyResponseMake, IsInBoundingBox;

    CONST MAX_SQUARE_PRICE = 3500;
    CONST RENTAL_MIN_VALUE = 3500;
    CONST SALE_MIN_VALUE = 600000;

    public function __invoke(array $properties, int $page, int $pageSize): array
    {
        $properties = array_filter($properties, [$this, 'eligibleForZap']);

        return $this->makePropertiesResponse($properties, $page, $pageSize);
    }

    protected function eligibleForZap($property)
    {
        return $this->eligibleByPrices($property)
            && $this->locationIsValid($property)
            && $this->eligibleByAreaPrice($property);
    }

    protected function eligibleByAreaPrice($property)
    {
        // This algorithm is only necessary if the property is for sale. If the property is for sale, return true
        if ($property->pricingInfos->businessType === TypeOfInteractionWithTheProperty::BUSINESS_TYPE_RENTAL) {
            return true;
        }

        // Avoid division by zero
        if ($property->usableAreas == 0) {
            return false;
        }

        $squareMeterValue = $property->pricingInfos->price / $property->usableAreas;

        return $squareMeterValue > self::MAX_SQUARE_PRICE;
    }

    protected function eligibleByPrices($property): bool
    {
        $pricingInfos = $property->pricingInfos;
        $salePrice = $this->isInBoundingBox($property->address)
            ? self::SALE_MIN_VALUE - $this->getPercentOfValue(self::SALE_MIN_VALUE, 10)
            : self::SALE_MIN_VALUE;
        $rentalPrice = $this->isInBoundingBox($property->address)
            ? self::RENTAL_MIN_VALUE - $this->getPercentOfValue(self::RENTAL_MIN_VALUE, 10)
            : self::RENTAL_MIN_VALUE;

        return (
            ($pricingInfos->businessType === TypeOfInteractionWithTheProperty::BUSINESS_TYPE_SALE && $pricingInfos->price >= $salePrice)
            ||
            ($pricingInfos->businessType === TypeOfInteractionWithTheProperty::BUSINESS_TYPE_RENTAL && $pricingInfos->rentalTotalPrice >= $rentalPrice)
        );
    }

    protected function getPercentOfValue($value, $percent)
    {
        return $value > 0 ? round($value * ($percent / 100), 2) : 0;
    }
}
