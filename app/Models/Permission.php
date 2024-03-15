<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    use HasFactory;

    protected $table = 'permissions';
    protected $fillable
        = [
            "key",
            "name",
            "created_at",
            "updated_at",
            "permission_group_id",
            "default_router",
            "package",
            "created_at",
            "updated_at",
        ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }

    public function groups()
    {
        return $this->belongsTo(PermissionGroup::class, 'permission_group_id', 'id');
    }

}
