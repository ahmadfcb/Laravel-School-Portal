<?php

class Account_library
{

    public $ci;

    public function __construct()
    {
        $this->ci = &get_instance();

    }

    /**
     * Gets admin roles and search if any of those exists
     * @param array $role_arr
     * @return int 0 for not logged in. 1 for success. 2 for logged in but not authorized
     */
    public function logged_in_role( $role_arr )
    {

        if ( $this->logged_in() ) {

            $allowed = false;

            // if role is in string
            if ( is_string( $role_arr ) ) {
                if ( $this->ci->session->userdata( 'user_type' ) == $role_arr ) {
                    $allowed = true;
                }
            } else if ( is_array( $role_arr ) ) { // if role contains multiple roles as array

                for ( $i = 0; $i < count( $role_arr ); $i++ ) {
                    if ( $this->ci->session->userdata( 'user_type' ) == $role_arr[$i] ) {
                        $allowed = true;
                    }

                    if ( $allowed === true ) {
                        break;
                    }
                }

            }

            if ( $allowed === true ) {
                return 1;
            } else {
                return 2;
            }

        } else {
            return 0;
        }

    }

    /**
     * Check if user is logged in
     * @return boolean TRUE if logged in FALSE otherwise
     */
    public function logged_in()
    {
        if ( $this->ci->session->userdata( 'logged_in' ) === true ) {
            return true;
        } else {
            return false;
        }
    }

    public function login_in_check_process()
    {
        if ( $this->logged_in() === true ) {

            $seg1 = $this->ci->uri->segment(1);
            $seg2 = $this->ci->uri->segment(2);

            $uri_string = ($seg1 !== null ? $seg1 : "") . ($seg2 !== null ? "/" . $seg2 : "");

            if ( $this->ci->admin_user_type_privilege_model->get( $this->ci->session->userdata( 'user_type' ), $uri_string ) === false ) {
                show_error( "You are not authorized to access this page", 405, "Not Authorized" );
            }

        } else {
            $this->ci->general_library->redirect( 'admin-account/sign-in', 0, "You need to login before accessing requested page!" );
        }
    }

    /**
     * Check if user is logged in and is admin
     * @return int 0 for not logged in. 2 for not admin 1 for success
     */
    public function logged_in_admin()
    {
        if ( $this->logged_in() ) {

            if ( $this->ci->session->userdata( 'user_type' ) == 'admin' ) {
                return 1;
            } else {
                return 2;
            }

        } else {

            return 0;

        }
    }

    /**
     * Check if user is logged in and is super admin
     * @return int 0 for not logged in. 2 for not super admin 1 for success
     */
    public function logged_in_super_admin()
    {
        if ( $this->logged_in() ) {

            if ( $this->ci->session->userdata( 'user_type' ) == 'super_admin' ) {
                return 1;
            } else {
                return 2;
            }

        } else {

            return 0;

        }
    }

    public function log_in( $user_id, $admin_user_type )
    {
        $this->ci->session->set_userdata( "logged_in", true );
        $this->ci->session->set_userdata( 'user_id', $user_id );
        $this->ci->session->set_userdata( 'user_type', $admin_user_type );
    }

    public function redirect_already_logged_in()
    {
        if ( $this->logged_in() ) {
            $this->ci->session->set_flashdata( 'msg', 'You are already logged in!' );
            redirect( site_url( "admin-dashboard" ) );
        }
    }

}
