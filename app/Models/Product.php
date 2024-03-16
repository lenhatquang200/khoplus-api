<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="Product",
 *      required={"code","name","type_id","group_id","unit_id","price","active"},
 *      @OA\Property(
 *          property="code",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="name",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="description",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="image",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="vat_percent",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="active",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="boolean",
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
 *      )
 * )
 */class Product extends Model
{
    public $table = 'products';

    public $fillable = [
        'code',
        'name',
        'type_id',
        'group_id',
        'unit_id',
        'larger_unit',
        'description',
        'image',
        'vat_percent',
        'price',
        'base_price',
        'inventory',
        'active',
        'is_inventory',
        'is_return',
        'is_sell',
        'sort'
    ];

    protected $casts = [
        'code' => 'string',
        'name' => 'string',
        'description' => 'string',
        'image' => 'string',
        'vat_percent' => 'decimal:3',
        'active' => 'boolean'
    ];

    public static array $rules = [
        'code' => 'required|string|max:191',
        'name' => 'required|string|max:191',
        'type_id' => 'required',
        'group_id' => 'required',
        'unit_id' => 'required',
        'larger_unit' => 'nullable',
        'description' => 'nullable|string|max:191',
        'image' => 'nullable|string|max:191',
        'vat_percent' => 'nullable|numeric',
        'price' => 'nullable',
        'base_price' => 'nullable',
        'inventory' => 'nullable',
        'active' => 'nullable',
        'is_inventory' => 'nullable',
        'is_return' => 'nullable',
        'is_sell' => 'nullable',
        'sort' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
    protected $appends
      = [
        'formatted_created_at'
      ];

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d/m/Y H:i:s');
    }
    public function unit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\ProductUnit::class, 'unit_id');
    }

    public function type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\ProductType::class, 'type_id');
    }

    public function group(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\ProductGroup::class, 'group_id');
    }

    public function largerUnit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\ProductUnit::class, 'larger_unit');
    }
}
