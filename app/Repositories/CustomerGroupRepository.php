<?php

namespace App\Repositories;

use App\Models\CustomerGroup;
use App\Repositories\BaseRepository;

class CustomerGroupRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'note'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return CustomerGroup::class;
    }
}
