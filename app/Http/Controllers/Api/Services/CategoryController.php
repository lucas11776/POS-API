<?php

namespace App\Http\Controllers\Api\Services;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\CreateCategoryRequest;
use App\Logic\Services;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @var Services
     */
    protected $services;

    public function __construct(Services $services)
    {
        $this->services = $services;
    }

    public function create(CreateCategoryRequest $request)
    {
        $category = $this->services->createCategory($request->validated());

        return response()->json($category);
    }
}
