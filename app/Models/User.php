<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $appends
      = [
        'user_permission',
        'permission_group',
        'formatted_created_at'
      ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }
    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'user_branches');
    }

    public function getUserPermissionAttribute()
    {
        $roles = [];
        foreach ($this->roles as $role) {
            $roles = array_merge($roles, $role->permissions->pluck('name', 'key')->toArray());
        }
        return $roles;
    }
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d/m/Y H:i:s');
    }

    public function getPermissionGroupAttribute()
    {
        $groups = [];
        foreach ($this->roles as $role) {
            $groups = [];
            foreach ($role->permissions as $permission) {
                $groups[$permission->groups->key] = $permission->groups->name;
            }
        }
        return $groups;
    }

    public function hasRole($role)
    {
        $role = Role::where('name',$role)->first();
        if($role)
        {
            if($this->roles()->where('role_id',$role->id)->first())
            {
                return true;
            }
            else
                return false;
        }
        return false;
        //
    }
}
