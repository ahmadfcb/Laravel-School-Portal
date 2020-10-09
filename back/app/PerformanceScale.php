<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PerformanceScale extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $table = 'performance_scales';
    protected $casts = [
        'scale_weight' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope( 'orderByScaleWeight', function ( Builder $builder ) {
            $builder->orderBy( 'scale_weight', 'asc' );
        } );
    }

    /*
     * Relationships
     */
    public function studentPerformances()
    {
        return $this->hasMany( StudentPerformance::class, 'performance_scale_id', 'id' );
    }
}
