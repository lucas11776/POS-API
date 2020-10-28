<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Controllers\Controller;
use App\Logic\Product;

class ProductController extends Controller
{
    /**
     * @var Product
     */
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function create(CreateProductRequest $request)
    {
        $product = $this->product->add($request->validated());

        return response()->json($product);
    }
}
