<?php

namespace App\Http\Controllers\Api\Services;

use App\Http\Requests\Service\UpdateServiceRequest;
use App\Service as Model;
use App\Http\Controllers\Controller;
use App\Http\Requests\Service\CreateServiceRequest;
use App\Logic\Service;

class ServiceController extends Controller
{
    /**
     * @var Service
     */
    protected $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function store(CreateServiceRequest $request)
    {
        $service = $this->service->add($request->validated());

        return response()->json($service);
    }

    public function update(Model $service, UpdateServiceRequest $request)
    {
        $service = $this->service->update($service, $request->validated());

        return response()->json($service);
    }
}
