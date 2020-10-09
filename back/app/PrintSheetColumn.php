<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PrintSheetColumn extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope( 'orderByName', function ( Builder $builder ) {
            $builder->orderBy( 'name', 'asc' );
        } );
    }
}
