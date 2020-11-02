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
        // TODO: Implement updateCategory() method.
    }

    public function deleteCategory(ServicesCategory $category): void
    {
        // TODO: Implement deleteCategory() method.
    }
}
