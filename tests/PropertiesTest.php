<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PropertiesTest extends TestCase
{
    public function testZapEndpoint()
    {
        $this->get('/properties/zap')
            ->seeJsonStructure($this->getResponsePattern());
    }

    public function testVivaRealEndpoint()
    {
        $this->get('/properties/viva-real')
            ->seeJsonStructure($this->getResponsePattern());
    }

    protected function getResponsePattern(): array
    {
        return [
            'pageNumber',
            'pageSize',
            'totalCount',
            'totalPages',
            'listings' => [
                '*' => [
                    'usableAreas',
                    'listingType',
                    'createdAt',
                    'listingStatus',
                    'id',
                    'updatedAt',
                    'owner',
                    'images' => ['*' => []],
                    'address' => [
                        'city',
                        'neighborhood',
                        'geoLocation' => [
                            'precision',
                            'location' => [
                                'lon',
                                'lat',
                            ],
                        ],
                    ],
                    'bathrooms',
                    'bedrooms',
                    'pricingInfos' => [
                        'businessType'
                    ],
                ]
            ],
        ];
    }
}
