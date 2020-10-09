<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAttachment extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    /*
     * Relationships
     */
    public function student()
    {
        return $this->belongsTo( Student::class, 'student_id', 'id' );
    }
}
