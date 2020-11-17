<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateCategoryRequest;
use App\Http\Requests\Product\UpdateCategoryRequest;
use App\Logic\Products\Products;
use App\ProductsCategory;

class CategoryController extends Controller
{
    /**
     * @var Products
     */
    protected $products;

    public function __construct(Products $products)
    {
        $this->products = $products;
    }

    public function index()
    {
        $categories = $this->products->categories();

        return response()->json($categories);
    }

    public function create(CreateCategoryRequest $request)
    {
        $category = $this->products->createCategory($request->get('name'));

        return response()->json($category);
    }

    public function update(ProductsCategory $category, UpdateCategoryRequest $request)
    {
        $category = $this->products->updateCategory($category, $request->get('name'));

        return response()->json($category);
    }

    public function delete(ProductsCategory $category)
    {
        $this->products->deleteCategory($category);

        return response()->json(['message' => 'Product category has been delete.']);
    }
}
