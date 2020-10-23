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
