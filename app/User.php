<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'role', 'email', 'password', 'address', 'alias',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * User name first letter be capital
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    /**
     * User lastname first letter be capital
     */
    public function setLastNameAttribute($value)
    {
        $this->attributes['lastname'] = ucfirst($value);
    }

    /**
     * set alias letter be small
     */
    public function setAliasAttribute($value)
    {
        $this->attributes['alias'] = strtolower($value);
    }

    /**
     * Relation set to roles table
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
}
