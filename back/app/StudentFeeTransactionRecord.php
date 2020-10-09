<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentFeeTransactionRecord extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $casts = [
        'credit' => 'integer',
        'debit' => 'integer',
        'remission' => 'integer',
        'balance' => 'integer'
    ];

    /*
     * Relationships
     */
    public function studentFeeTransaction()
    {
        return $this->belongsTo( StudentFeeTransaction::class, 'student_fee_transaction_id', 'id' );
    }

    public function studentFeeType()
    {
        return $this->belongsTo( StudentFeeType::class, 'student_fee_type_id', 'id' );
    }
}
