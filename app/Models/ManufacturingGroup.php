<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="ManufacturingGroup",
 *      required={"name","active"},
 *      @OA\Property(
 *          property="name",
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
 */class ManufacturingGroup extends Model
{
    public $table = 'manufacturing_group';

    public $fillable = [
        'name',
        'note',
        'active'
    ];

    protected $casts = [
        'name' => 'string',
        'note' => 'string'
    ];

    public static array $rules = [
        'name' => 'required|string|max:191',
        'note' => 'nullable|string|max:191',
        'active' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function manufacturings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Manufacturing::class, 'manufacturing_group_id');
    }
}
