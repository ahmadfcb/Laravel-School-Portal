<?php

namespace App\Http\Controllers;

use App\PerformanceScale;
use Illuminate\Http\Request;

class PerformanceScaleController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:performance_scale_view' );
        $this->middleware( 'CheckPrivilege:performance_scale_add' )->only( 'store' );
        $this->middleware( 'CheckPrivilege:performance_scale_edit' )->only( 'update' );
        $this->middleware( 'CheckPrivilege:performance_scale_delete' )->only( 'remove' );
    }

    public function performanceScaleValidator( array $data )
    {
        $rules = [
            'title' => 'required|string|max:191',
            'scale_weight' => 'required|numeric|min:1|unique:performance_scales,scale_weight'
        ];

        if ( \request()->isMethod( 'put' ) ) {
            $rules['id'] = "required|numeric|exists:performance_scales,id";
        }

        return \Validator::make( $data, $rules );
    }

    public function index( PerformanceScale $editItem )
    {
        $title = "Performance Scales";
        $performance_scales = PerformanceScale::get();

        return view( 'performance_scale.index', compact(
            'title',
            'performance_scales',
            'editItem'
        ) );
    }

    public function store( Request $request )
    {
        $this->performanceScaleValidator( $request->all() )->validate();

        PerformanceScale::create( [
            'title' => $request->title,
            'scale_weight' => $request->scale_weight
        ] );

        return back()->with( 'msg', "Performance scale has been created!" );
    }

    public function update( Request $request )
    {
        $this->performanceScaleValidator( $request->all() )->validate();

        $performance_scale = PerformanceScale::findOrFail( $request->id );
        $performance_scale->title = $request->title;
        $performance_scale->scale_weight = $request->scale_weight;
        $performance_scale->save();

        return redirect()->route( 'dashboard.performance_scale' )->with( 'msg', "Performance Scale updated successfully!" );
    }

    public function remove( PerformanceScale $performanceScale )
    {
        $performanceScale->delete();

        return back()->with( 'msg', "Performance Scale has been deleted!" );
    }
}
