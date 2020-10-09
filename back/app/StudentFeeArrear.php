<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentFeeArrear extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $table = 'student_fee_arrears';
    protected $casts = [
        'arrear' => 'integer'
    ];

    /*
     * Relationships
     */
    public function student()
    {
        return $this->belongsTo( Student::class, 'student_id', 'id' );
    }

    public function studentFeeType()
    {
        return $this->belongsTo( StudentFeeType::class, 'student_fee_type_id', 'id' );
    }
}
