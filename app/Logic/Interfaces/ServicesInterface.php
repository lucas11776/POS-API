<?php

namespace App\Logic\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ServicesInterface
{
    /**
     * Get all services from database.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Get services from database.
     *
     * @param string $search
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function get(string $search = '', int $limit = 24): LengthAwarePaginator;
}
