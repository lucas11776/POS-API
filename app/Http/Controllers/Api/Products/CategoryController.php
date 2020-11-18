<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateCategoryRequest;
use App\Http\Requests\Product\UpdateCategoryRequest;
use App\Logic\Products\Category;
use App\Logic\Products\Products;
use App\ProductsCategory;

class CategoryController extends Controller
{
    /**
     * @var Category
     */
    protected $category;

    /**
     * @var Products
     */
    protected $products;

    public function __construct(Category $category, Products $products)
    {
        $this->category = $category;
        $this->products = $products;
    }

    public function index()
    {
        $categories = $this->products->categories();

        return response()->json($categories);
    }

    public function create(CreateCategoryRequest $request)
    {
        $category = $this->category->create($request->validated());

        return response()->json($category);
    }

    public function update(ProductsCategory $category, UpdateCategoryRequest $request)
    {
        $category = $this->category->update($category, $request->get('name'));

        return response()->json($category);
    }

    public function delete(ProductsCategory $category)
    {
        $this->category->delete($category);

        return response()->json(['message' => 'Product category has been delete.']);
    }
}
