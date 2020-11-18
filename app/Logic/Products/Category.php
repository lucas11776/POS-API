<?php

namespace App\Logic\Products;

use App\ProductsCategory;
use App\Logic\Interfaces\ProductsCategoryInterface;
use Illuminate\Support\Str;

class Category implements ProductsCategoryInterface
{
    public function create(array $category): ProductsCategory
    {
        return ProductsCategory::create([
            'name' => $category['name'],
            'url' => Str::slug($category['name'])
        ]);
    }

    public function update(ProductsCategory $category, string $name): ProductsCategory
    {
        $category->name = $name;
        $category->url = Str::slug($name);
        $category->save();
        return $category;
    }

    public function delete(ProductsCategory $category): void
    {
        // TODO: Delete all category id from products
        $category->delete();
    }
}
