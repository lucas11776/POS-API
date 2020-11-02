<?php


namespace App\Logic;


use App\ServicesCategory;
use Illuminate\Support\Str;

class Services implements ServicesInterface
{
    public function createCategory(array $category): ServicesCategory
    {
        return ServicesCategory::create([
            'name' => $category['name'],
            'url' => Str::slug($category['name'])
        ]);
    }

    public function updateCategory(ServicesCategory $category, array $data): ServicesCategory
    {
        $category->name = $data['name'];
        $category->url = Str::slug($data['name']);
        $category->save();
        return $category;
    }

    public function deleteCategory(ServicesCategory $category): void
    {
        // TODO: Implement deleteCategory() method.
    }
}
