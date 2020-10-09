<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
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
    public function students()
    {
        return $this->hasMany( Student::class, 'branch_id', 'id' );
    }

    public function branchClassSection()
    {
        return $this->hasMany( BranchClassSection::class, 'branch_id', 'id' );
    }
}
