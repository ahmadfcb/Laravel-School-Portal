<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:category_view' );
        $this->middleware( 'CheckPrivilege:category_delete' )->only( 'delete' );
    }

    public function index( Category $categoryEdit )
    {
        $title = "Categories";

        $categories = Category::orderBy( 'name' )->get();

        return view( 'category.index', compact(
            'title',
            'categories',
            'categoryEdit'
        ) );
    }

    public function add( Request $request, Category $categoryEdit )
    {
        $this->validate( $request, [
            'name' => 'required|string',
            'fee_discount' => 'required|numeric|min:0'
        ] );

        $name = $request->name;
        $fee_discount = $request->fee_discount;

        // if category edit is given. Update record
        if ( $categoryEdit->id !== null ) {

            if ( !\Auth::user()->userHasPrivilege( 'category_edit' ) ) {
                abort( 401, "You are not authorized to view that page." );
            }

            $categoryEdit->name = $name;
            $categoryEdit->fee_discount = $fee_discount;
            $categoryEdit->save();
            return redirect()->route( 'dashboard.category' )->with( 'msg', "Category updated" );
        } else { // create new

            if ( !\Auth::user()->userHasPrivilege( 'category_add' ) ) {
                abort( 401, "You are not authorized to view that page." );
            }

            Category::create( ['name' => $name, 'fee_discount' => $fee_discount] );
            return back()->with( 'msg', "Category has been created." );
        }
    }

    public function delete( Category $category )
    {
        $category->delete();
        return back()->with( 'msg', "Category deleted successfully!" );
    }
}
