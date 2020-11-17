<?php

namespace App\Logic\Products;

use App\ProductsCategory;
use App\Product as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

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

    public function createCategory(string $name): ProductsCategory
    {
        return ProductsCategory::create([
            'name' => $name,
            'url' => Str::slug($name)
        ]);
    }

    public function updateCategory(ProductsCategory $category, string $name): ProductsCategory
    {
        $category->name = $name;
        $category->url = Str::slug($name);
        $category->save();
        return $category;
    }

    public function deleteCategory(ProductsCategory $category): void
    {
        // TODO: Delete all category id from products
        $category->delete();
    }
}
