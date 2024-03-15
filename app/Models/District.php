<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    const TABLE = 'districts';
    protected $table = self::TABLE;
    protected $fillable = [
        'districtid',
        'name',
        'type',
        'location',
        'provinceid',
    ];
}
