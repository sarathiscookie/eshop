<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = ['id'];
    
    public $timestamps = false;

    /**
     * Relation set to roles table
     */
    public function users()
    {
        return $this->belongsToMany('App\user');
    }
}
