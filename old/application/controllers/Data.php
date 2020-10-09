<?php
/**
 * Will be used for data access APIs
 *
 * @author Muhammad Waseem
 */
class Data extends CI_Controller {
    
    public function student_info(){
        
        $this->form_validation->set_rules('reg_no', 'Registration number', 'trim|required');
        
        $has_error = false;
        $msg = "";
        $data = null;
        
        if($this->form_validation->run() == false){
            $has_error = true;
            $msg = $this->form_validation->error_string();
        } else {
            $reg_no = $this->input->post('reg_no');
            
            // get student info
            $student_info = $this->general_model->get_data("*", 'student_registration', array('registration_number' => $reg_no), 1);
            
            if($student_info === false){
                $has_error = true;
                $msg = "No student found!";
            } else {
                
                $has_error = false;
                $msg = "";
                
                $data = $student_info;
                
            }
            
        }
        
        $data_array = array(
            'has_error' => $has_error,
            'msg' => $msg,
            'data' => $data
        );

        $this->output->set_content_type( 'json' );
        $this->output->set_output( json_encode( $data_array ) );
        
    }
    
}
