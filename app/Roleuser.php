<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roleuser extends Model
{
    protected $guarded = ['id'];

    protected $table   = 'role_user';

    public $timestamps = false;
}
