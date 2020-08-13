<?php


namespace App\Traits;


trait PropertyResponseMake
{
    protected function makePropertiesResponse(array $properties, int $page, int $pageSize)
    {
        $paginate = array_chunk($properties, $pageSize);

        return [
            'pageNumber' => $page,
            'pageSize' => $pageSize,
            'totalCount' => count($properties),
            'totalPages' => count($paginate),
            "listings" => $paginate[$page] ?? [],
        ];
    }
}
