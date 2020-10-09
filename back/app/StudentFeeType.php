<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentFeeType extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $table = 'student_fee_types';
    protected $casts = [
        'fee' => 'integer',
        'editable' => 'boolean'
    ];

    /*
     * Relationships
     */
    public function studentFeeArrears()
    {
        return $this->hasMany( StudentFeeArrear::class, 'student_fee_type_id', 'id' );
    }

    public function studentFeeTransactionRecords()
    {
        return $this->hasMany( StudentFeeTransactionRecord::class, 'student_fee_type_id', 'id' );
    }
}
