<?php


namespace App\Logic;


use App\ProductsCategory;
use Illuminate\Support\Str;

class Products implements ProductsInterface
{

    public function createCategory(string $name): ProductsCategory
    {
        return ProductsCategory::create([
            'name' => $name,
            'url' => Str::slug($name)
        ]);
    }

    public function updateCategory(ProductsCategory $category, string $name): ProductsCategory
    {
        // TODO: Implement updateCategory() method.
    }

    public function deleteCategory(ProductsCategory $category): void
    {
        // TODO: Implement deleteCategory() method.
    }
}
