<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:branch_view' );
        $this->middleware( 'CheckPrivilege:branch_delete' )->only( 'delete' );
    }

    public function index( Branch $branchEdit )
    {
        $title = "Branches";

        $branches = Branch::orderBy( 'name' )->get();

        return view( 'branch.index', compact(
            'title',
            'branches',
            'branchEdit'
        ) );
    }

    public function add( Request $request, Branch $branchEdit )
    {
        $this->validate( $request, [
            'name' => 'required|string'
        ] );

        $name = $request->name;

        // if branch edit is given. Update record
        if($branchEdit->id !== null){

            if(!\Auth::user()->userHasPrivilege('branch_edit')){
                abort(401, "You are not authorized to view that page.");
            }

            $branchEdit->name = $name;
            $branchEdit->save();
            return redirect()->route('dashboard.branch')->with('msg', "Branch updated");
        } else { // create new

            if(!\Auth::user()->userHasPrivilege('branch_add')){
                abort(401, "You are not authorized to view that page.");
            }

            Branch::create( ['name' => $name] );
            return back()->with( 'msg', "Branch has been created." );
        }
    }

    public function delete( Branch $branch )
    {
        $branch->delete();
        return back()->with( 'msg', "Branch has been deleted successfully." );
    }
}
