<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    const TABLE = 'provinces';
    protected $table = self::TABLE;
    protected $fillable = [
        'provinceid',
        'name',
        'type',
    ];

}
