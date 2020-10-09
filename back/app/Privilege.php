<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    /*
     * Relationships
     */
    public function users()
    {
        return $this->belongsToMany( User::class )->using( PrivilegeUser::class );
    }
}
