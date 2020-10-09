<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $guarded = [];

    /*
     * Relationship
     */
    public function student()
    {
        return $this->belongsTo( Student::class, 'student_id', 'id' );
    }
}
