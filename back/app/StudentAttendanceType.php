<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAttendanceType extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $dates = ['attendance_date', 'created_at', 'updated_at'];

    /*
     * Relationships
     */
    public function studentAttendances()
    {
        return $this->hasMany( StudentAttendance::class, 'student_attendance_type_id', 'id' );
    }
}
