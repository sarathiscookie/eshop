<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userrole extends Model
{
    protected $guarded = ['id'];

    protected $table   = 'user_roles';

}
