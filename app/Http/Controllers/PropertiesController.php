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
            $request->get('page', 1),
            $request->get('pageSize', 10)
        ));
    }

    public function getZap(Request $request)
    {
        return response()->json($this->service->getZapProperties(
            $request->get('page', 1),
            $request->get('pageSize', 10)
        ));
    }
}
