<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\BaseRepository;

class CustomerRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'customer_group',
        'name',
        'phone',
        'birthday',
        'address',
        'province_id',
        'district_id',
        'ward_id',
        'note',
        'image',
        'gender'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Customer::class;
    }
}
