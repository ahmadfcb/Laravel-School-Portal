<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchClassSection extends Model
{
    protected $table = "branch_class_section";
    protected $guarded = [];
    public $timestamps = false;

    /*
     * Relationships
     */
    public function branch()
    {
        return $this->belongsTo( Branch::class, 'branch_id', 'id' );
    }

    public function schoolClass()
    {
        return $this->belongsTo( SchoolClass::class, 'class_id', 'id' );
    }

    public function section()
    {
        return $this->belongsTo( Section::class, 'section_id', 'id' );
    }

    public function branchClassSectionSubjects()
    {
        return $this->hasMany( BranchClassSectionSubject::class, 'branch_class_section_id', 'id' );
    }

    public function subjects()
    {
        return $this->belongsToMany( Subjects::class, 'branch_class_section_subjects', 'branch_class_section_id', 'subject_id' )->withPivot( 'id' );
    }
}
