<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="Customer",
 *      required={"customer_group","name","phone","address","gender"},
 *      @OA\Property(
 *          property="name",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="phone",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="birthday",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="address",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="note",
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
 */class Customer extends Model
{
    public $table = 'customers';

    public $fillable = [
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

    protected $casts = [
        'name' => 'string',
        'phone' => 'string',
        'birthday' => 'date',
        'address' => 'string',
        'note' => 'string',
        'image' => 'string'
    ];

    public static array $rules = [
        'customer_group' => 'required',
        'name' => 'required|string|max:191',
        'phone' => 'required|string|max:20',
        'birthday' => 'nullable',
        'address' => 'required|string|max:191',
        'province_id' => 'nullable',
        'district_id' => 'nullable',
        'ward_id' => 'nullable',
        'note' => 'nullable|string|max:191',
        'image' => 'nullable|string|max:191',
        'gender' => 'required',
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
    public function customerGroup(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\CustomerGroup::class, 'customer_group');
    }

    public function customerFarms(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\CustomerFarm::class, 'customer_id');
    }
}
