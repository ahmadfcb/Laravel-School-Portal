<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student_Tests extends Model
{
    //
    protected $table='class_test_table';

    
    public function ClassTest()
    {
    	return $this->hasMany('App\StudentSubject');
    }
    public function schoolClass()
    {
        return $this->belongsTo( SchoolClass::class, 'class_id', 'id' );
    }
}
