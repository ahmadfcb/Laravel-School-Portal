<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SiblingStudent extends Pivot
{
    public $timestamps = false;
    protected $table = 'sibling_student';
}
