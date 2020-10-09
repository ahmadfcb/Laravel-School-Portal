<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\SchoolClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentFeeApiController extends Controller
{
    public function getFee( Request $request )
    {
        $this->validate( $request, [
            'current_class_id' => 'nullable|required_without:category_id|exists:classes,id',
            'category_id' => 'nullable|required_without:current_class_id|exists:categories,id'
        ] );

        $current_class_id = $request->current_class_id;
        $category_id = $request->category_id;

        $fee = 0;

        if ( !empty( $current_class_id ) ) {
            $current_class = SchoolClass::find( $current_class_id );
            $fee += $current_class->fee;
        }

        if ( !empty( $category_id ) ) {
            $category = Category::find( $category_id );
            $fee -= $category->fee_discount;
        }

        return compact( 'fee' );
    }
}
