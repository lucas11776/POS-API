<?php

namespace App\Logic\Interfaces;

use App\Service;

interface ServiceInterface
{
    /**
     * Store new service in categories.
     *
     * @param array $service
     * @return Service
     */
    public function add(array $service): Service;

    /**
     * Update service in database.
     *
     * @param Service $service
     * @param array $data
     * @return Service
     */
    public function update(Service $service, array $data): Service;

    /**
     * Delete service in database,.
     *
     * @param Service $service
     */
    public function delete(Service $service): void;
}
