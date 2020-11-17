<?php

namespace App\Logic\Products;

use App\Product;

interface ProductInterface
{
    /**
     * Added new product in database.
     *
     * @param array $product
     * @return Product
     */
    public function add(array $product): Product;

    /**
     * Update product in database.
     *
     * @param Product $product
     * @param array $form
     * @return Product
     */
    public function update(Product $product, array $form): Product;

    /**
     * Delete product in database.
     *
     * @param Product $product
     */
    public function delete(Product $product): void;
}
