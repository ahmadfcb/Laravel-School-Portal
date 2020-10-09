<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope( 'orderByName', function ( Builder $builder ) {
            $builder->orderBy( 'name', 'asc' );
        } );
    }

    /*
     * Relationships
     */
    public function classSection()
    {
        return $this->belongsToMany( ClassSection::class, 'class_section_subject', 'subject_id', 'class_section_id' )->using( ClassSectionSubject::class );
    }

    public function classSectionSubjects()
    {
        return $this->hasMany( ClassSectionSubject::class, 'subject_id', 'id' );
    }

    public function branchClassSectionSubject()
    {
        return $this->hasMany( BranchClassSectionSubject::class, 'subject_id', 'id' );
    }

    public function branchClassSections()
    {
        return $this->belongsToMany( BranchClassSection::class, 'branch_class_section_subjects', 'subject_id', 'branch_class_section_id' )->withPivot( 'id' );
    }
}
