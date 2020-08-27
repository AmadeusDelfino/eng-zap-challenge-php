<?php


namespace App\Http\Controllers;


use App\Services\PropertiesService;
use Illuminate\Http\Request;

class PropertiesController extends Controller
{
    /**
     * @var PropertiesService
     */
    protected $service = PropertiesService::class;

    public function getVivaReal(Request $request)
    {
        return response()->json($this->service->getVivaRealProperties(
            round($request->get('page', 0)),
            round($request->get('pageSize', 10))
        ));
    }

    public function getZap(Request $request)
    {
        return response()->json($this->service->getZapProperties(
            round($request->get('page', 0)),
            round($request->get('pageSize', 10))
        ));
    }
}
