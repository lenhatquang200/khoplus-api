<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="CustomerFarm",
 *      required={"customer_id","plant_id","acreage"},
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
 *      )
 * )
 */class CustomerFarm extends Model
{
    public $table = 'customer_farm';

    public $fillable = [
        'customer_id',
        'plant_id',
        'acreage',
        'note'
    ];
    protected $appends
      = [
        'formatted_created_at'
      ];

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d/m/Y H:i:s');
    }
    protected $casts = [
        'acreage' => 'string',
        'note' => 'string'
    ];

    public static array $rules = [
        'customer_id' => 'required',
        'plant_id' => 'required',
        'acreage' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'note' => 'nullable|string|max:255'
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
