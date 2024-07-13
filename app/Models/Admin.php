<?php
// app/Models/User.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'surname',
        'phone',
        "phone_code",
        'email',
        'password',
    ];

    /**
     * Guard for the model
     *
     * @var string
     */
    protected $guard = 'admin-api';

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'admin_roles', 'admin_id', 'role_id');
    }

    // JWTSubject interface methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    public function getJWTCustomClaims()
    {
        $user = $this;
        $roles = [];
        foreach ($this->roles as $role) {
            array_push($roles, $role->name);
        }

        unset($user["password"]);
        unset($user["email_verified_at"]);
        unset($user["remember_token"]);
        unset($user["updated_at"]);
        unset($user["roles"]);
        $user["roles"] = $roles;

        return [
            'user' => $user
        ];
    }
}
