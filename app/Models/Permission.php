<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'permissions',
    ];

    /**
     * Get the users associated with the role.
     */
    public function roles()
    {
        return $this->hasMany(Role::class);
    }
}
