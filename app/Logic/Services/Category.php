<?php

namespace App\Logic\Services;

use App\ServicesCategory;
use App\Logic\Interfaces\ServicesCategoryInterface;
use Illuminate\Support\Str;

class Category implements ServicesCategoryInterface
{
    public function create(array $category): ServicesCategory
    {
        return ServicesCategory::create([
            'name' => $category['name'],
            'url' => Str::slug($category['name'])
        ]);
    }

    public function update(ServicesCategory $category, array $data): ServicesCategory
    {
        $category->name = $data['name'];
        $category->url = Str::slug($data['name']);
        $category->save();
        return $category;
    }

    public function delete(ServicesCategory $category): void
    {
        $category->delete();
    }
}
