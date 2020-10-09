<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
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
    public function schoolClasses()
    {
        return $this->belongsToMany( SchoolClass::class, 'class_section', 'section_id', 'class_id' )
            ->using( ClassSection::class )
            ->withPivot( 'id' );
    }

    public function students()
    {
        return $this->hasMany( Student::class, 'section_id', 'id' );
    }

    public function classSections()
    {
        return $this->hasMany( ClassSection::class, 'section_id', 'id' );
    }

    public function branchClassSection()
    {
        return $this->hasMany( BranchClassSection::class, 'section_id', 'id' );
    }
}
