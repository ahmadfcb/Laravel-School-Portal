<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PerformanceType extends Model
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
    public function studentPerformances()
    {
        return $this->hasMany( StudentPerformance::class, 'performance_type_id', 'id' );
    }
}
