<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentPerformance extends Model
{
    protected $guarded = [];
    protected $table = 'student_performances';
    protected $dates = ['performance_date', 'created_at', 'updated_at'];

    /*
     * Relationships
     */
    public function student()
    {
        return $this->belongsTo( Student::class, 'student_id', 'id' );
    }

    public function performanceScale()
    {
        return $this->belongsTo( PerformanceScale::class, 'performance_scale_id', 'id' );
    }

    public function performanceType()
    {
        return $this->belongsTo( PerformanceType::class, 'performance_type_id', 'id' );
    }
}
