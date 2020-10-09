<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClassSectionSubject extends Pivot
{
    protected $table = "class_section_subject";

    /*
     * Relationships
     */
    public function classSection()
    {
        return $this->belongsTo( ClassSection::class, 'class_section_id', 'id' );
    }

    public function subject()
    {
        return $this->belongsTo( Subjects::class, 'subject_id', 'id' );
    }
}
