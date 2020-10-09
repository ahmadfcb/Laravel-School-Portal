<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Admin_account extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function sign_in(){
        $this->account_library->redirect_already_logged_in();
        
        $this->load->view('admin_account/sign_in_view');
    }

    public function sign_in_process() {
        $this->account_library->redirect_already_logged_in();

        $username = $this->input->post( 'username' );
        $username = strtolower( $username );
        $password = $this->input->post( 'password' );

        $has_error = false;
        $error_msg = "";
        $user_data = null;

        if ( $username === null || empty( $username ) || $password === null || empty( $password ) ) {
            $has_error = true;
            $error_msg = "Username or password is not provided.";
        } else {
            $user_data = $this->general_model->get_data( "*", 'admin_users', array( 'admin_username' => $username ), 1 );

            if ( $user_data === false ) {
                $has_error = true;
                $error_msg = "That user name is not registered with us.";
            } else {

                if ( password_verify( $password, $user_data[ 'admin_password' ] ) ) {

                    $has_error = false;
                    $error_msg = "";
                } else {

                    $has_error = true;
                    $error_msg = "Provided password is not correct. Please make sure you provided correct credentials.";
                }
            }
        }

        // if ajax request
        if ( $this->input->is_ajax_request() ) {
            
            $this->output->set_content_type( 'application/json' );
            $this->output->set_output( json_encode( array( 'has_error' => $has_error, 'error_msg' => $error_msg ) ) );
            
        } else {
            
            // if there is no error
            if($has_error === false){
                
                $this->account_library->log_in($user_data['admin_users_id'], $user_data['admin_user_type']);
                
                //redirect( site_url( $this->session->userdata('user_type') . "-dashboard" ) );
                redirect( site_url( "admin-dashboard" ) );
                
            } else { // there is error
                
                $this->session->set_flashdata("error", $error_msg);
                redirect( site_url('/admin-account/sign-in'));
                
            }
            
        }

    }
    
    public function sign_out(){
        
        $this->session->sess_destroy();
        redirect('admin-account/sign-in');
        
    }

}
