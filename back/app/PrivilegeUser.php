<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PrivilegeUser extends Pivot
{
    public $timestamps = false;
    protected $table = 'privilege_user';
}
