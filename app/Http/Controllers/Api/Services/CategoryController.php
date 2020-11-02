<?php

namespace App\Http\Controllers\Api\Services;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\CreateCategoryRequest;
use App\Http\Requests\Service\UpdateCategoryRequest;
use App\Logic\Services;
use App\ServicesCategory;
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

    public function update(ServicesCategory $category, UpdateCategoryRequest $request)
    {
        $category = $this->services->updateCategory($category, $request->validated());

        return response()->json($category);
    }

    public function delete(ServicesCategory $category)
    {
        $this->services->deleteCategory($category);

        return response()->json(['message' => 'Service category has been deleted successfully.']);
    }
}
