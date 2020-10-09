<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $dates = ['dob', 'date_of_admission', 'fee_generation_date_time', 'fine_generation_date_time'];
    protected $casts = [
        'pin' => 'integer',
        'extra_discount' => 'integer',
        'assigned_class_fee' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope( 'notWithdrawn', function ( Builder $builder ) {
            $builder->where( 'withdrawn', 0 );
        } );
    }

    /*
     * Methods
     */
    public function scopeGetFiltered( $query, $branch_id = null, $class_id = null, $section_id = null, $filter = null )
    {
        if ( $branch_id !== null ) {
            $query->where( 'branch_id', $branch_id );
        }

        if ( $class_id !== null ) {
            $query->where( 'current_class_id', $class_id );
        }

        if ( $section_id !== null ) {
            $query->where( 'section_id', $section_id );
        }

        if ( $filter !== null ) {
            if ( is_numeric( $filter ) ) {
                $query->where( 'pin', $filter );
            } else {
                $query->where( function ( $q ) use ( $filter ) {
                    $q->orWhere( 'name', 'like', "%{$filter}%" );
                    $q->orWhere( 'cnic', 'like', "%{$filter}%" );
                } );
            }
        }

        return $query;
    }

    public function attendance( $date = null )
    {
        $date = ( $date !== null ? Carbon::parse( $date ) : Carbon::now() );

        return $this->attandences()->where( 'attendance_date', $date )->first();
    }

    /**
     * Gives available number for SMS. Loads: fatherRecord.
     * @return mixed|null|string
     */
    public function getAvailablePhoneNumber()
    {
        if ( !empty( $this->fatherRecord->sms_cell ) ) {
            $phone = $this->fatherRecord->sms_cell;
        } else if ( !empty( $this->fatherRecord->mobile ) ) {
            $phone = $this->fatherRecord->mobile;
        } else if ( !empty( $this->mother_phone ) ) {
            $phone = $this->mother_phone;
        } else {
            $phone = null;
        }

        return $phone;
    }

    /**
     * Gets fee for the student
     * @return int
     */
    public function getFee()
    {
        $fee = ( $this->assigned_class_fee ?? 0 ) - ( $this->category->fee_discount ?? 0 ) - ( $this->extra_discount ?? 0 );
        $fee = ( $fee < 0 ? 0 : $fee );
        return $fee;
    }

    /*
     * Relationships
     */
    public function attachments()
    {
        return $this->hasMany( StudentAttachment::class, 'student_id', 'id' );
    }

    public function siblings()
    {
        return $this->belongsToMany( Sibling::class )->using( SiblingStudent::class );
    }

    public function schoolMedium()
    {
        return $this->belongsTo( SchoolMedium::class, 'school_medium_id', 'id' );
    }

    public function branch()
    {
        return $this->belongsTo( Branch::class, 'branch_id', 'id' );
    }

    public function classOfAdmission()
    {
        return $this->belongsTo( SchoolClass::class, 'class_of_admission_id', 'id' );
    }

    public function currentClass()
    {
        return $this->belongsTo( SchoolClass::class, 'current_class_id', 'id' );
    }

    public function section()
    {
        return $this->belongsTo( Section::class, 'section_id', 'id' );
    }

    public function fatherRecord()
    {
        return $this->belongsTo( FatherRecord::class, 'father_record_id', 'id' );
    }

    public function attandences()
    {
        return $this->hasMany( StudentAttendance::class, 'student_id', 'id' );
    }

    public function performances()
    {
        return $this->hasMany( StudentPerformance::class, 'student_id', 'id' );
    }

    public function category()
    {
        return $this->belongsTo( Category::class, 'category_id', 'id' );
    }

    public function withdrawals()
    {
        return $this->hasMany( Withdrawal::class, 'student_id', 'id' );
    }

    public function readmissions()
    {
        return $this->hasMany( Readmission::class, 'student_id', 'id' );
    }

    public function feeTransactions()
    {
        return $this->hasMany( StudentFeeTransaction::class, 'student_id', 'id' );
    }

    public function feeArrears()
    {
        return $this->hasMany( StudentFeeArrear::class, 'student_id', 'id' );
    }

    public function test()
    {
        return $this->belongsTo( Student_Tests::class, 'class_id', 'id' );
    }

    public function marks()
    {
        return $this->belongsTo( StudentMark::class, 'student_id', 'id' );
    }

    public function student_subject()
    {
        return $this->belongsTo( StudentSubject::class, 'class_test_id', 'id' );
    }
}
