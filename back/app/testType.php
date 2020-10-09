<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class testType extends Model
{
    //
    protected $table='testType';

     public function students()
    {
        return $this->hasMany( Student::class, 'test_id', 'id' );
    }  

    public function test()
    {
        return $this->hasMany( 'App\Student_Tests');
    }
}
