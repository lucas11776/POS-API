<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
use App\Logic\Products\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * @var Products
     */
    protected $products;

    public function __construct(Products $products)
    {
        $this->products = $products;
    }

    public function index(Request $request)
    {
        $search = is_string($request->get('search')) ? $request->get('search') : '';
        $limit = is_numeric($request->get('limit')) ? $request->get('limit') : 24;
        $products = $this->products->get($search, $limit);

        return response()->json($products);
    }

    public function all()
    {
        $products = $this->products->all();

        return response()->json($products);
    }
}
