<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentFeeTransaction extends Model
{
    protected $table = 'student_fee_transactions';
    protected $guarded = [];

    /*
     * Relationships
     */
    public function student()
    {
        return $this->belongsTo( Student::class, 'student_id', 'id' );
    }

    public function records()
    {
        return $this->hasMany( StudentFeeTransactionRecord::class, 'student_fee_transaction_id', 'id' );
    }
}
