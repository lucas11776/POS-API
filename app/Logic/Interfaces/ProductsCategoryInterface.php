<?php

namespace App\Logic\Interfaces;

use App\ProductsCategory;

interface ProductsCategoryInterface
{
    /**
     * Added product category.
     *
     * @param array $category
     * @return ProductsCategory
     */
    public function create(array $category): ProductsCategory;

    /**
     * Update product category.
     *
     * @param ProductsCategory $category
     * @param string $name
     * @return ProductsCategory
     */
    public function update(ProductsCategory $category, string $name): ProductsCategory;

    /**
     * Delete product category.
     *
     * @param ProductsCategory $category
     */
    public function delete(ProductsCategory $category): void;
}
