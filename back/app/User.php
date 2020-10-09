<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*
     * Methods
     */

    /**
     * Check if provided user has provided privilege
     *
     * @param User $user
     * @param array|string $privilege
     * @return bool bool
     */
    public static function hasPrivilege( $user, $privilege, $verify_all = true )
    {
        // if not instance of User
        if ( ( $user instanceof User ) == false ) {
            $user = ( new static() )::find( $user );
        }

        $rtn = $user->privileges();

        if ( is_array( $privilege ) ) {
            if ( $verify_all === false ) {
                $rtn->whereIn( 'name', $privilege );
            } else {
                for ( $i = 0; $i < count( $privilege ); $i++ ) {
                    $rtn->where( 'name', $privilege[$i] );
                }
            }
        } else {
            $rtn->where( 'name', $privilege );
        }

        return $rtn->exists();
    }

    /**
     * Takes privilege or array or privileges and checks whether some or all the privileges are available
     * @param array|string $privilege
     * @param bool $verify_all
     * @return bool bool
     */
    public function userHasPrivilege( $privilege, $verify_all = true )
    {
        return static::hasPrivilege( $this, $privilege, $verify_all );
    }

    /**
     * Takes privilege name or array of privilege names and returns their results
     * @param $privilegeName array|string
     * @return array|bool
     */
    public function privilegeResults( $privilegeName )
    {
        if ( is_array( $privilegeName ) ) {
            $userPrivileges = $this->privileges()->whereIn( 'name', $privilegeName )->get();
            $newPrivilegesArray = [];
            foreach ( $privilegeName as $prv ) {
                $newPrivilegesArray[$prv] = $userPrivileges->where( 'name', $prv )->isNotEmpty();
            }
            return $newPrivilegesArray;
        } else {
            return $this->userHasPrivilege( $privilegeName );
        }
    }

    /*
     * Relationships
     */
    public function privileges()
    {
        return $this->belongsToMany( Privilege::class )->using( PrivilegeUser::class );
    }
}
