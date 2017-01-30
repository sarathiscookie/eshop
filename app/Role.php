<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    /**
     *function for roles
     */
    public function hasRole($userID)
    {
        return DB::table('roles')->select('role')->where('user_id', $userID)->first();
    }
}
