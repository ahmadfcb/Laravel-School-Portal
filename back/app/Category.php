<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $casts = [
        'fee_discount' => 'integer'
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
    public function students()
    {
        return $this->hasMany( Student::class, 'category_id', 'id' );
    }
}
