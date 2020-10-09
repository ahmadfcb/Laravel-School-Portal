<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Readmission extends Model
{
    protected $guarded = [];
    protected $table = 'readmissions';

    /*
     * Relationships
     */
    public function student()
    {
        return $this->belongsTo( Student::class, 'student_id', 'id' );
    }
}
