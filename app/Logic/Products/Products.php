<?php

namespace App\Logic\Products;

use App\ProductsCategory;
use App\Product as Model;
use App\Logic\Interfaces\ProductsInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class Products implements ProductsInterface
{
    public function all(): Collection
    {
        return Model::query()
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function get(string $search = '', int $limit = 24): LengthAwarePaginator
    {
        return Model::query()
            ->where('name', 'LIKE', "%$search%")
            ->orderBy('name', 'ASC')
            ->paginate($limit);
    }

    public function categories(): Collection
    {
        return ProductsCategory::query()
            ->orderBy('name', 'ASC')
            ->get();
    }
}
