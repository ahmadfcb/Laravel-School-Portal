<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchClassSectionSubject extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    /*
     * Relationships
     */
    public function branchClassSection()
    {
        return $this->belongsTo( BranchClassSection::class, 'branch_class_section_id', 'id' );
    }

    public function subject()
    {
        return $this->belongsTo( Subjects::class, 'subject_id', 'id' );
    }
}
