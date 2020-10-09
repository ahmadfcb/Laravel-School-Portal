<?php

namespace App\Http\Controllers;

use App\PerformanceType;
use Illuminate\Http\Request;

class PerformanceTypeController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:performance_type_view' );
        $this->middleware( 'CheckPrivilege:performance_type_add' )->only( 'store' );
        $this->middleware( 'CheckPrivilege:performance_type_update' )->only( 'update' );
        $this->middleware( 'CheckPrivilege:performance_type_delete' )->only( 'remove' );
    }

    public function performanceTypeValidator( array $data )
    {
        $rules = [
            'name' => 'required|string|max:191'
        ];

        if ( \request()->isMethod( 'put' ) ) {
            $rules['id'] = "required|numeric|exists:performance_types,id";
        }

        return \Validator::make( $data, $rules );
    }

    public function index( PerformanceType $editItem )
    {
        $title = "Performance Types";
        $performanceTypes = PerformanceType::get();

        return view( 'performance_type.index', compact(
            'title',
            'performanceTypes',
            'editItem'
        ) );
    }

    public function store( Request $request )
    {
        $this->performanceTypeValidator( $request->all() )->validate();

        PerformanceType::create( [
            'name' => $request->name
        ] );

        return back()->with( 'msg', "Performance type has been created!" );
    }

    public function update( Request $request )
    {
        $this->performanceTypeValidator( $request->all() )->validate();

        $performance_type = PerformanceType::findOrFail( $request->id );
        $performance_type->name = $request->name;
        $performance_type->save();

        return redirect()->route( 'dashboard.performance_type' )->with( 'msg', "Name of performance type updated to '{$performance_type->name}'." );
    }

    public function remove( PerformanceType $performanceType )
    {
        $performanceType->delete();

        return back()->with( 'msg', "Performance Type '{$performanceType->name}' has been deleted" );
    }
}
