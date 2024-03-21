<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="CustomerFarm",
 *      required={"customer_id","plant_id","acreage","lat","long"},
 *      @OA\Property(
 *          property="acreage",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="note",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="lat",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="long",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      )
 * )
 */class CustomerFarm extends Model
{
    public $table = 'customer_farm';

    public $fillable = [
        'customer_id',
        'plant_id',
        'acreage',
        'note',
        'lat',
        'long'
    ];

    protected $casts = [
        'acreage' => 'string',
        'note' => 'string',
        'lat' => 'string',
        'long' => 'string'
    ];

    public static array $rules = [
        'customer_id' => 'required',
        'plant_id' => 'required',
        'acreage' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'note' => 'nullable|string|max:255',
        'lat' => 'required|string|max:255',
        'long' => 'required|string|max:255'
    ];

    public function plant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Plant::class, 'plant_id');
    }

    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Customer::class, 'customer_id');
    }
}
