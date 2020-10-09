<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sibling extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    /*
     * Relationships
     */
    public function students()
    {
        return $this->belongsToMany( Student::class )->using( SiblingStudent::class );
    }
}
