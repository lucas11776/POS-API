<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateCategoryRequest;
use App\Logic\Products;
use Illuminate\Http\Request;

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

    public function create(CreateCategoryRequest $request)
    {
        $category = $this->products->createCategory($request->get('name'));

        return response()->json($category);
    }

    public function update()
    {
        dd('Updating product category');
    }
}
