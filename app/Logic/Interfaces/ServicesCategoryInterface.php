<?php

namespace App\Logic\Interfaces;

use App\ServicesCategory;

interface ServicesCategoryInterface
{
    /**
     * Create new service category in database.
     *
     * @param array $category
     * @return ServicesCategory
     */
    public function create(array $category): ServicesCategory;

    /**
     * Update service category in database.
     *
     * @param ServicesCategory $category
     * @param array $data
     * @return ServicesCategory
     */
    public function update(ServicesCategory $category, array $data): ServicesCategory;

    /**
     * Delete service category in database.
     *
     * @param ServicesCategory $category
     */
    public function delete(ServicesCategory $category): void;
}
