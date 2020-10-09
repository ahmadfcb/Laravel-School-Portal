<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $table = "classes";
    protected $guarded = [];
    public $timestamps = false;
    protected $casts = [
        'fee' => 'integer'
    ];

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
    public function sections()
    {
        return $this->belongsToMany( Section::class, 'class_section', 'class_id', 'section_id' )
            ->using( ClassSection::class )
            ->withPivot( 'id' );
    }

    public function classOfAdmissionStudents()
    {
        return $this->hasMany( Student::class, 'class_of_admission_id', 'id' );
    }

    public function currentClassStudents()
    {
        return $this->hasMany( Student::class, 'current_class_id', 'id' );
    }

    public function classSections()
    {
        return $this->hasMany( ClassSection::class, 'class_id', 'id' );
    }

    public function branchClassSection()
    {
        return $this->hasMany( BranchClassSection::class, 'class_id', 'id' );
    }
}
