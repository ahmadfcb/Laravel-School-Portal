<?php

namespace App\Http\Controllers;

use App\Privilege;
use App\User;
use Illuminate\Http\Request;

class PrivilegeController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:account_user_privilege' );
        $this->middleware( 'CheckPrivilege:account_user_privilege_add' )->only( 'assign' );
        $this->middleware( 'CheckPrivilege:account_user_privilege_remove' )->only( 'remove' );
    }

    public function privilege( User $user )
    {
        $title = "{$user->name} privileges";

        $user_privileges = $user->privileges()->orderBy( 'name' )->get();

        $privileges = Privilege::orderBy( 'name' )->get();

        return view( 'privilege.privilege', compact(
            'title',
            'user',
            'privileges',
            'user_privileges'
        ) );
    }

    public function attach( Request $request, User $user )
    {
        $this->validate( $request, [
            'user_privileges' => 'required',
            'user_privileges.*' => 'required|numeric|exists:privileges,id'
        ] );

        $user_privileges = $request->user_privileges;

        $user->privileges()->sync( $user_privileges );

        return back()->with('msg', "User privileges has been saved!");
    }
}
