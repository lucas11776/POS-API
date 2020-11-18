<?php

namespace App\Http\Controllers\Api\Services;

use App\Http\Controllers\Controller;
use App\Logic\Services\Services;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    /**
     * @var Services
     */
    protected $services;

    public function __construct(Services $services)
    {
        $this->services = $services;
    }

    public function index(Request $request)
    {
        $search = is_string($request->get('search')) ? $request->get('search') : '';
        $limit = is_numeric($request->get('limit')) ? $request->get('limit') : 24;
        $services = $this->services->get($search, $limit);

        return response()->json($services);
    }

    public function all()
    {
        $services = $this->services->all();

        return response()->json($services);
    }
}
