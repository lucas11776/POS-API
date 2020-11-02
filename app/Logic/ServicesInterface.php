<?php


namespace App\Logic;


use App\ServicesCategory;

interface ServicesInterface
{
    /**
     * Create new service category in database.
     *
     * @param array $category
     * @return ServicesCategory
     */
    public function createCategory(array $category): ServicesCategory;

    /**
     * Update service category in database.
     *
     * @param ServicesCategory $category
     * @param array $data
     * @return ServicesCategory
     */
    public function updateCategory(ServicesCategory $category, array $data): ServicesCategory;

    /**
     * Delete service category in database.
     *
     * @param ServicesCategory $category
     */
    public function deleteCategory(ServicesCategory $category): void;
}
