<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolMedium extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $table = 'school_mediums';

    public function students()
    {
        return $this->hasMany( Student::class, 'school_medium_id', 'id' );
    }
}
