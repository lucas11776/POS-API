<?php

namespace App\Logic\Services;

use App\Service as ServiceModel;
use App\Logic\Interfaces\ServicesInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class Services implements ServicesInterface
{
    public function all(): Collection
    {
        return ServiceModel::query()
            ->orderBy('name','ASC')
            ->get();
    }

    public function get(string $search = '', int $limit = 24): LengthAwarePaginator
    {
        return ServiceModel::query()
            ->where('name', 'LIKE', "%$search%")
            ->paginate($limit);
    }
}
