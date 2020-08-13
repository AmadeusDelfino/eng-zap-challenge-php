<?php


namespace App\Services;


use App\Services\PropertiesServiceHandlers\VivaRealHandler;
use App\Services\PropertiesServiceHandlers\ZapHandler;

class PropertiesService
{
    public function getProperties()
    {
        return json_decode(
            file_get_contents(storage_path('app/source-2.json'))
        );
    }

    public function getZapProperties(int $page, int $pageSize = 10)
    {
        return (new ZapHandler())($this->getProperties(), $page, $pageSize);
    }

    public function getVivaRealProperties(int $page, int $pageSize = 10)
    {
        return (new VivaRealHandler())($this->getProperties(), $page, $pageSize);
    }
}
