<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Requests\Product\UpdateProductRequest;
use App\Product as Model;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Controllers\Controller;
use App\Logic\Products\Product;

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

    public function update(Model $product, UpdateProductRequest $request)
    {
        $product = $this->product->update($product, $request->validated());

        return response()->json($product);
    }

    public function delete(Model $product)
    {
        $this->product->delete($product);

        return response()->json(['message' => 'Product has been delete successfully']);
    }
}
