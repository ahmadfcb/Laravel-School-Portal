<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FatherRecord extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    /*
     * Relationships
     */
    public function students()
    {
        return $this->hasMany( Student::class, 'father_record_id', 'id' );
    }
}
