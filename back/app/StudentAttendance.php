<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    protected $guarded = [];
    protected $dates = ['attendance_date', 'created_at', 'updated_at'];

    /*
     * Relationships
     */
    public function studentAttendanceType()
    {
        return $this->belongsTo( StudentAttendanceType::class, 'student_attendance_type_id', 'id' );
    }

    public function student()
    {
        return $this->belongsTo( Student::class, 'student_id', 'id' );
    }
}
