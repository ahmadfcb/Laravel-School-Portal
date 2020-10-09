<?php

namespace App\Http\Controllers;

use App\Option;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );

        $this->middleware( 'CheckPrivilege:account_user' )->only( ['index', 'create', 'delete', 'update'] );
    }

    public function index( User $editUser )
    {
        $title = "Users";

        $user = \Auth::user();

        $users = User::where( 'id', '!=', $user->id )->orderBy( 'name' )->get();

        return view( 'user.index', compact(
            'title',
            'editUser',
            'user',
            'users'
        ) );
    }

    public function userValidator( array $data )
    {
        $rules = [
            "name" => "required|string|max:191",
            "email" => ['required', 'string', 'email', 'max:191'],
            "image" => "nullable|mimes:jpeg,png",
            'gender' => 'required|string|in:male,female'
        ];

        if ( \request()->isMethod( 'PUT' ) ) {
            $rules['email'][] = Rule::unique( 'users', 'id' );
            $rules['password'] = "nullable|string|min:6";
            $rules['user_id'] = "required|numeric|exists:users,id";
        } else {
            $rules['email'][] = Rule::unique( 'users', 'id' )->ignore( auth()->user()->id );
            $rules['password'] = "required|string|min:6";
        }

        return \Validator::make( $data, $rules, [], [
            'name' => 'Name',
            'email' => 'Email',
            'image' => 'Image',
            'gender' => 'Gender',
            'password' => 'Password'
        ] );
    }

    public function create( Request $request )
    {
        $this->userValidator( $request->all() )->validate();

        $name = $request->name;
        $email = $request->email;
        $gender = strtolower( $request->gender );
        $password = $request->password;

        if ( $request->hasFile( 'image' ) && $request->file( 'image' )->isValid() ) {
            $image = $request->file( 'image' )->store( 'user_images' );
        } else {
            if ( $gender == 'male' ) {
                $image = Option::find( 'default_user_image_male' )->value;
            } else {
                $image = Option::find( 'default_user_image_female' )->value;
            }
        }

        do {
            $api_token = str_random( 60 );
        } while ( User::where( 'api_token', $api_token )->exists() );

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->image = $image;
        $user->gender = $gender;
        $user->password = bcrypt( $password );
        $user->api_token = $api_token;
        $user->save();

        return back()->with( 'msg', "User has been created." );
    }

    public function update( Request $request )
    {
        $this->userValidator( $request->all() )->validate();

        $user_id = $request->user_id;
        $name = $request->name;
        $email = $request->email;
        $gender = $request->gender;
        $password = $request->password;

        if ( $request->hasFile( 'image' ) && $request->file( 'image' )->isValid() ) {
            $image = $request->file( 'image' )->store( 'user_images' );
        }

        $user = User::findOrFail( $user_id );
        $user->name = $name;
        $user->email = $email;
        $user->gender = $gender;

        if ( isset( $image ) ) {
            $user->image = $image;
        }

        if ( !empty( $password ) ) {
            $user->password = bcrypt( $password );
        }

        $user->save();

        return redirect()->route('dashboard.users')->with( 'msg', "User has been updated." );
    }

    public function delete( User $user )
    {
        $user->delete();

        return back()->with( 'msg', "User has been deleted" );
    }

    public function changeAccountDetails()
    {
        $title = "Change Account Details";
        $user = \Auth::user();

        return view( 'user.changeAccountDetails', compact(
            'title',
            'user'
        ) );
    }

    public function updateBasicInfo( Request $request )
    {
        $this->validate( $request, [
            'name' => 'required|string|max:191',
            'gender' => 'required|string|in:male,female',
            'image' => 'nullable|mimes:jpeg,png'
        ], [], [
            'name' => 'Name',
            'gender' => 'Gender',
            'image' => 'image'
        ] );

        $name = $request->name;
        $gender = $request->gender;
        $image = $request->image;

        if ( !empty( $image ) ) {
            $image = $request->file( 'image' )->store( 'user_images' );
        } else {
            $image = Option::find( 'default_user_image_' . $gender )->value;
        }

        $user = \Auth::user();
        $user->name = $name;
        $user->gender = $gender;
        $user->image = $image;
        $user->save();

        return back()->with( 'msg', "Information updated!" );
    }

    public function updatePassword( Request $request )
    {
        $this->validate( $request, [
            'old_password' => 'required|string',
            'new_password' => 'required|string|confirmed',
            'new_password_confirmation' => 'required'
        ], [], [
            'old_password' => 'Old Password',
            'new_password' => 'New Password',
            'new_password_confirmation' => 'New Password Confirmation'
        ] );

        $old_password = $request->old_password;
        $new_password = $request->new_password;

        $user = \Auth::user();

        // if old password is NOT correct
        if ( !\Hash::check( $old_password, $user->password ) ) {
            return back()->with( 'err', "Old password didn't match your account's password. Please try again." );
        } else { // correct old password
            $user->password = \Hash::make( $new_password );
            $user->save();

            return back()->with( 'msg', "Password changed successfully!" );
        }
    }
}
