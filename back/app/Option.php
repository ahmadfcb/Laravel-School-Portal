<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $primaryKey = 'name';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $table = 'options';
    protected $guarded = [];

    /*
     * Methods
     */

    /**
     * @param $name string|array
     * @return array|mixed|string
     */
    public static function getOptionValue( $name )
    {
        if ( is_array( $name ) ) {
            $options = static::whereIn( 'name', $name )->get();
            $newOptions = [];
            foreach ( $options as $option ) {
                $newOptions[$option->name] = $option->value;
            }
            return $newOptions;
        } else {
            return static::select( 'value' )->find( $name )->value;
        }
    }
}
