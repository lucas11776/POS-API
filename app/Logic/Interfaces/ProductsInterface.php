<?php

namespace App\Logic\Interfaces;

use App\ProductsCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductsInterface
{
    /**
     * Get all products from database.
     *
     * @return Collection
     */
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
}
