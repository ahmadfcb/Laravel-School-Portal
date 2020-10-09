<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentSubject extends Model
{
    //
    protected $table='class_subject_marks';

    public function students()
    {
        return $this->hasMany( Student::class, 'section_id', 'id' );
    }  

    public function test()
    {
        return $this->hasMany( 'App\Student_Tests');

    }

    public function marks()
    {
        return $this->hasMany( 'App\StudentMark');
    }
}
