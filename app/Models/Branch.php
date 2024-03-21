<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="Branch",
 *      required={"name","first_setup"},
 *      @OA\Property(
 *          property="name",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
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
 *          property="phone",
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
 *      ),
 *      @OA\Property(
 *          property="lat",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="long",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      )
 * )
 */class Branch extends Model
{
    public $table = 'branches';

    public $fillable = [
        'name',
        'address',
        'phone',
        'active',
        'image',
        'first_setup',
        'lat',
        'long'
    ];

    protected $casts = [
        'name' => 'string',
        'address' => 'string',
        'phone' => 'string',
        'image' => 'string',
        'lat' => 'string',
        'long' => 'string'
    ];

    public static array $rules = [
        'name' => 'required|string|max:191',
        'address' => 'nullable|string|max:191',
        'phone' => 'nullable|string|max:191',
        'active' => 'nullable',
        'image' => 'nullable|string|max:191',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'first_setup' => 'required',
        'lat' => 'nullable|string|max:255',
        'long' => 'nullable|string|max:255'
    ];

    
}
