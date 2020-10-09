<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClassSection extends Pivot
{
    protected $table = "class_section";
    public $timestamps = false;

    public function getCreatedAtColumn()
    {
        if(isset($this->pivotParent)){
            return $this->pivotParent->getCreatedAtColumn();
        }
        return static::CREATED_AT;
    }

    public function getUpdatedAtColumn()
    {
        if(isset($this->pivotParent)){
            return $this->pivotParent->getUpdatedAtColumn();
        }
        return static::UPDATED_AT;
    }

    /*
     * Relationships
     */
    public function schoolClass()
    {
        return $this->belongsTo( SchoolClass::class, 'class_id', 'id' );
    }

    public function section()
    {
        return $this->belongsTo( Section::class, 'section_id', 'id' );
    }

    public function subjects()
    {
        return $this->belongsToMany( Subjects::class, 'class_section_subject', 'class_section_id', 'subject_id' )
            ->using( ClassSectionSubject::class );
    }

    public function classSectionSubjects()
    {
        return $this->hasMany( ClassSectionSubject::class, 'class_section_id', 'id' );
    }

}
