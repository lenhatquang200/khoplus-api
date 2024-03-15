<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="Manufacturing",
 *      required={"code","name","phone"},
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
 *          property="phone",
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
 *          property="address",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="email",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="company",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="tax",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="account_number",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="bank_name",
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
 */class Manufacturing extends Model
{
    public $table = 'manufacturings';

    public $fillable = [
        'manufacturing_group_id',
        'code',
        'name',
        'phone',
        'note',
        'address',
        'province_id',
        'district_id',
        'ward_id',
        'email',
        'company',
        'tax',
        'active',
        'account_number',
        'bank_name'
    ];

    protected $casts = [
        'code' => 'string',
        'name' => 'string',
        'phone' => 'string',
        'note' => 'string',
        'address' => 'string',
        'email' => 'string',
        'company' => 'string',
        'tax' => 'string',
        'account_number' => 'string',
        'bank_name' => 'string'
    ];

    public static array $rules = [
        'manufacturing_group_id' => 'nullable',
        'code' => 'required|string|max:191',
        'name' => 'required|string|max:191',
        'phone' => 'required|string|max:191',
        'note' => 'nullable|string|max:191',
        'address' => 'nullable|string|max:191',
        'province_id' => 'nullable',
        'district_id' => 'nullable',
        'ward_id' => 'nullable',
        'email' => 'nullable|string|max:191',
        'company' => 'nullable|string|max:191',
        'tax' => 'nullable|string|max:191',
        'active' => 'nullable',
        'account_number' => 'nullable|string|max:191',
        'bank_name' => 'nullable|string|max:191',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function manufacturingGroup(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\ManufacturingGroup::class, 'manufacturing_group_id');
    }
}
