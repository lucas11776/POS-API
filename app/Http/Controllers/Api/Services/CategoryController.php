<?php

namespace App\Http\Controllers\Api\Services;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\CreateCategoryRequest;
use App\Http\Requests\Service\UpdateCategoryRequest;
use App\Logic\Services\Category;
use App\ServicesCategory;

class CategoryController extends Controller
{
    /**
     * @var Category
     */
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function create(CreateCategoryRequest $request)
    {
        $category = $this->category->create($request->validated());

        return response()->json($category);
    }

    public function update(ServicesCategory $category, UpdateCategoryRequest $request)
    {
        $category = $this->category->update($category, $request->validated());

        return response()->json($category);
    }

    public function delete(ServicesCategory $category)
    {
        $this->category->delete($category);

        return response()->json(['message' => 'Service category has been deleted successfully.']);
    }
}
