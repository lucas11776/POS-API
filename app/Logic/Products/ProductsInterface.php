<?php

namespace App\Logic\Products;

use App\ProductsCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductsInterface
{
    public function all(): Collection;

    /**
     * Get products in database.
     *
     * @param string $search
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function get(string $search = '', int $limit = 24): LengthAwarePaginator;

    /**
     * Get product categories.
     *
     * @return Collection
     */
    public function categories(): Collection;

    /**
     * Added product category.
     *
     * @param string $name
     * @return ProductsCategory
     */
    public function createCategory(string $name): ProductsCategory;

    /**
     * Update product category.
     *
     * @param ProductsCategory $category
     * @param string $name
     * @return ProductsCategory
     */
    public function updateCategory(ProductsCategory $category, string $name): ProductsCategory;

    /**
     * Delete product category.
     *
     * @param ProductsCategory $category
     */
    public function deleteCategory(ProductsCategory $category): void;
}
