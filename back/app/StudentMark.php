<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentMark extends Model
{
    //
    protected $table='student_marks';

    public function students()
    {
        return $this->hasMany( Student::class, 'section_id', 'id' );
    }  

    public function test()
    {
        return $this->hasMany( 'App\Student_Tests');
    }
}

