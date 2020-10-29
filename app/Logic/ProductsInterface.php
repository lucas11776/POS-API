<?php


namespace App\Logic;


use App\ProductsCategory;

interface ProductsInterface
{
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