<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Admin_dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->account_library->login_in_check_process();
    }

    public function index()
    {

        $this->load->view( "admin_dashboard/index_view", array('title' => "Admin Panel") );
    }

    public function student_registration_process()
    {
        $this->form_validation->set_rules( 'registration_new', 'Registraion Number', 'trim|is_unique[student_registration.registration_new]', array('is_unique' => "Provided registration number has already been assigned to a student") );
        $this->form_validation->set_rules( 'registration_number', 'PIN', 'required|trim|integer|is_unique[student_registration.registration_number]', array('is_unique' => "Provided PIN has already been asigned to a student") );
        $this->form_validation->set_rules( 'first_name', 'First name', 'required|trim|min_length[2]|max_length[255]' );
        $this->form_validation->set_rules( 'last_name', 'Last name', 'trim|min_length[2]|max_length[255]' );
        $this->form_validation->set_rules( 'gender', 'Gender', 'strtolower|min_length[4]|max_length[6]' );
        $this->form_validation->set_rules( 'dob', 'Date of birth', 'trim' );
        $this->form_validation->set_rules( 'dobw', 'Date of birth in words', 'trim|max_length[512]' );
        $this->form_validation->set_rules( 'CNIC', 'Student B.Form / CNIC', 'trim|min_length[13]|max_length[13]|numeric|is_unique[student_registration.cnic]', array('numeric' => 'You should provide numeric data for %s', 'is_unique' => 'This CNIC has already been registered with a student.') );
        $this->form_validation->set_rules( 'father_guardian_name', 'Father/Guardian name', 'trim|max_length[255]' );
        $this->form_validation->set_rules( 'father_guardian_CNIC', 'Father/Guardian CNIC', 'trim|min_length[13]|max_length[13]|numeric', array('numeric' => 'You should provide numeric data for %s') );
        $this->form_validation->set_rules( 'father_guardian_profession', 'Father/Guardian Profession', 'trim|max_length[255]' );
        $this->form_validation->set_rules( 'father_guardian_mobile', 'Father/Guardian mobile number', 'trim|max_length[20]' );
        $this->form_validation->set_rules( 'date_of_admission', 'Date of admission', 'trim' );
        $this->form_validation->set_rules( 'admission_class', 'Admission class', 'required|trim|max_length[10]' );
        $this->form_validation->set_rules( 'current_class', 'Current class', 'required|trim|max_length[10]' );
        $this->form_validation->set_rules( 'section', 'Section', 'trim|max_length[255]' );
        $this->form_validation->set_rules( 'school_branch', 'School branch', 'trim|max_length[255]' );
        $this->form_validation->set_rules( 'street_address', 'Street address', 'trim|max_length[512]' );
        $this->form_validation->set_rules( 'colony', 'Colony name', 'trim|max_length[50]' );
        $this->form_validation->set_rules( 'city', 'City name', 'trim|max_length[50]' );
        $this->form_validation->set_rules( 'monthly_fee', 'Monthly fee', 'required|trim|integer' );
        $this->form_validation->set_rules( 'arears', 'Arears', 'required|trim|integer' );
        $this->form_validation->set_rules( 'exam_fee', 'Exam fee', 'required|trim|integer' );
        $this->form_validation->set_rules( 'student_status', 'Student status', 'required|trim|max_length[10]' );
        $this->form_validation->set_rules( 'mother_name', 'mother_name', 'trim|htmlspecialchars|max_length[255]' );
        $this->form_validation->set_rules( 'mother_cnic', 'mother_cnic', 'trim|htmlspecialchars|max_length[255]' );
        $this->form_validation->set_rules( 'mother_profession', 'mother_profession', 'trim|htmlspecialchars|max_length[255]' );
        $this->form_validation->set_rules( 'mother_phone', 'mother_phone', 'trim|htmlspecialchars|max_length[255]' );
        $this->form_validation->set_rules( 'mother_qualification', 'mother_qualification', 'trim|htmlspecialchars|max_length[255]' );

        if ( $this->form_validation->run() == false ) {
            $this->student_registration();
        } else {

            $first_name = $this->input->post( 'first_name' );
            $last_name = $this->input->post( 'last_name' );
            $gender = $this->input->post( 'gender' );
            $dob = $this->input->post( 'dob' );
            $dobw = $this->input->post( 'dobw' );
            $cnic = $this->input->post( 'CNIC' );
            $father_name = $this->input->post( 'father_guardian_name' );
            $father_cnic = $this->input->post( 'father_guardian_CNIC' );
            $father_profession = $this->input->post( 'father_guardian_profession' );
            $father_mobile = $this->input->post( 'father_guardian_mobile' );

            $admission_date = $this->input->post( 'date_of_admission' );
            $admission_date = ( empty( $admission_date ) ? date( 'Y-m-d H:i:s', now() ) : $admission_date );

            $registration_new = $this->input->post( 'registration_new' );
            $registration_number = $this->input->post( 'registration_number' );
            $admission_class = $this->input->post( 'admission_class' );
            $current_class = $this->input->post( 'current_class' );
            $section = $this->input->post( 'section' );
            $school_branch = $this->input->post( 'school_branch' );
            $street_address = $this->input->post( 'street_address' );
            $colony = $this->input->post( 'colony' );
            $city = $this->input->post( 'city' );
            $monthly_fee = $this->input->post( 'monthly_fee' );
            $arears = $this->input->post( 'arears' );
            $student_status = $this->input->post( 'student_status' );

            $mother_name = $this->input->post( 'mother_name' );
            $mother_cnic = $this->input->post( 'mother_cnic' );
            $mother_profession = $this->input->post( 'mother_profession' );
            $mother_phone = $this->input->post( 'mother_phone' );
            $mother_qualification = $this->input->post( 'mother_qualification' );

            $current_fee_month = date( 'Y-m', now() ) . '-01';
            $exam_fee = $this->input->post( 'exam_fee' );


            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 2000;
            $config['encrypt_name'] = TRUE;


            $this->load->library( 'upload', $config );


            $image_path = "";
            $image_error = false;

            if ( $_FILES['std_pic']['name'] ) {
                if ( !$this->upload->do_upload( 'std_pic' ) ) {
                    $this->session->set_flashdata( 'error', $this->upload->display_errors() );
                    $image_error = TRUE;
                } else {

                    $image_path = $this->upload->data( 'file_name' );
                    $image_path = "/uploads/{$image_path}";
                }
            } else {
                $image_path = "/uploads/default-profile-pic.jpg";
            }


            if ( $image_error === true ) {
                $this->student_registration();
            } else {

                $this->db->insert( "student_registration", array(
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'profile_pic' => $image_path,
                    'gender' => $gender,
                    'dob' => $dob,
                    'dob_word' => $dobw,
                    'cnic' => $cnic,
                    'father_name' => $father_name,
                    'father_cnic' => $father_cnic,
                    'father_profession' => $father_profession,
                    'father_mobile' => $father_mobile,
                    'admission_date' => $admission_date,
                    'registration_new' => $registration_new,
                    'registration_number' => $registration_number,
                    'admission_class' => $admission_class,
                    'current_class' => $current_class,
                    'section' => $section,
                    'school_branch' => $school_branch,
                    'street_address' => $street_address,
                    'colony' => $colony,
                    'city' => $city,
                    'monthly_fee' => $monthly_fee,
                    'fee_month' => $current_fee_month,
                    'arears' => $arears,
                    'exam_fee_arears' => $exam_fee,
                    'exam_fee_arear_update_date' => date( 'Y-m-d', strtotime( $this->general_model->db_variables( 'session_start_date' ) . date( '-Y', now() ) ) ),
                    'student_status' => $student_status,
                    'mother_name' => $mother_name,
                    'mother_cnic' => $mother_cnic,
                    'mother_profession' => $mother_profession,
                    'mother_phone' => $mother_phone,
                    'mother_qualification' => $mother_qualification
                ) );

                $this->session->set_flashdata( 'msg', 'Student has been registered successfully.' );
                redirect( 'admin-dashboard/student-registration' );
            }
        }
    }

    public function student_registration()
    {
        $next_student = $this->general_model->get_next_student( 0 );
        $this->load->view( "admin_dashboard/student_registration_view", array(
            'title' => "Student Registration",
            'latest_registration_number' => $this->general_model->get_latest_registration_number(),
            'next_student' => $next_student
        ) );
    }

    public function student_delete()
    {

        $std_id = $this->input->get( 'stdid' );

        if ( $std_id === null ) {
            $this->session->set_flashdata( 'error', 'Student ID not provided.' );
            redirect( 'admin-dashboard/students' );
        } else {
            $this->db->delete( 'student_registration', array('student_registration_id' => $std_id) );
            if ( $this->db->affected_rows() == 1 ) {
                $this->session->set_flashdata( 'msg', 'Student details has been deleted successfully!' );
            } else {
                $this->session->set_flashdata( 'error', 'Couldn\'t delete requested user!' );
            }

            $redirect = $this->input->get( 'redirect' );

            $redirect_url = ( !empty( $redirect ) ? urldecode( $redirect ) : "admin-dashboard/students" );

            redirect( $redirect_url );
        }
    }

    public function view_student()
    {

        $std_id = $this->input->get( 'stdid' );

        if ( $std_id === null ) {
            $this->session->set_flashdata( 'error', 'Student ID not provided.' );
            redirect( 'admin-dashboard/students' );
        } else {

            $student_details = $this->general_model->get_data_query( "SELECT * FROM `student_registration` WHERE `student_registration_id` = ?", array($std_id), 1 );

            $redirect = $this->input->get( 'redirect' );
            $redirect_url = ( !empty( $redirect ) ? urldecode( $redirect ) : "admin-dashboard/students" );

            $this->load->view( "admin_dashboard/view_student_view", array(
                'title' => 'Student details',
                'student_details' => $student_details,
                'redirect_url' => $redirect_url
            ) );
        }
    }

    public function student_update_process()
    {

        $std_id = $this->input->get( 'stdid' );

        if ( empty( $std_id ) ) {
            $this->session->set_flashdata( 'error', 'Student ID not provided.' );
            redirect( 'admin-dashboard/students' );
        }

        $this->form_validation->set_rules( 'first_name', 'First name', 'required|trim|min_length[2]|max_length[255]' );
        $this->form_validation->set_rules( 'last_name', 'Last name', 'trim|min_length[2]|max_length[255]' );
        $this->form_validation->set_rules( 'gender', 'Gender', 'strtolower|min_length[4]|max_length[6]' );
        $this->form_validation->set_rules( 'dob', 'Date of birth', 'trim' );
        $this->form_validation->set_rules( 'dobw', 'Date of birth in words', 'trim|max_length[512]' );
        $this->form_validation->set_rules( 'CNIC', 'Student B.Form / CNIC', 'trim|min_length[13]|max_length[13]|numeric' );
        $this->form_validation->set_rules( 'father_guardian_name', 'Father/Guardian name', 'trim|max_length[255]' );
        $this->form_validation->set_rules( 'father_guardian_CNIC', 'Father/Guardian CNIC', 'trim|min_length[13]|max_length[13]|numeric', array('numeric' => 'You should provide numeric data for %s') );
        $this->form_validation->set_rules( 'father_guardian_profession', 'Father/Guardian Profession', 'trim|max_length[255]' );
        $this->form_validation->set_rules( 'father_guardian_mobile', 'Father/Guardian mobile number', 'trim|max_length[20]' );
        $this->form_validation->set_rules( 'date_of_admission', 'Date of admission', 'trim' );
        $this->form_validation->set_rules( 'registration_new', 'Student registration number', 'trim' );
        $this->form_validation->set_rules( 'registration_number', 'Student PIN', 'required|trim|integer' );
        $this->form_validation->set_rules( 'admission_class', 'Admission class', 'required|trim|max_length[10]' );
        $this->form_validation->set_rules( 'current_class', 'Current class', 'required|trim|max_length[10]' );
        $this->form_validation->set_rules( 'section', 'Section', 'trim|max_length[255]' );
        $this->form_validation->set_rules( 'school_branch', 'School branch', 'trim|max_length[255]' );
        $this->form_validation->set_rules( 'street_address', 'Street address', 'trim|max_length[512]' );
        $this->form_validation->set_rules( 'colony', 'Colony name', 'trim|max_length[50]' );
        $this->form_validation->set_rules( 'city', 'City name', 'trim|max_length[50]' );
        $this->form_validation->set_rules( 'monthly_fee', 'Monthly fee', 'required|trim|integer' );
        $this->form_validation->set_rules( 'arears', 'Arears', 'required|trim|integer' );
        $this->form_validation->set_rules( 'exam_fee', 'Exam fee', 'required|trim|integer' );
        $this->form_validation->set_rules( 'student_status', 'Student status', 'required|trim|max_length[10]' );
        $this->form_validation->set_rules( 'mother_name', 'mother_name', 'trim|htmlspecialchars|max_length[255]' );
        $this->form_validation->set_rules( 'mother_cnic', 'mother_cnic', 'trim|htmlspecialchars|max_length[255]' );
        $this->form_validation->set_rules( 'mother_profession', 'mother_profession', 'trim|htmlspecialchars|max_length[255]' );
        $this->form_validation->set_rules( 'mother_phone', 'mother_phone', 'trim|htmlspecialchars|max_length[255]' );
        $this->form_validation->set_rules( 'mother_qualification', 'mother_qualification', 'trim|htmlspecialchars|max_length[255]' );


        if ( $this->form_validation->run() == false ) {
            $this->student_update();
        } else {

            $first_name = $this->input->post( 'first_name' );
            $last_name = $this->input->post( 'last_name' );
            $gender = $this->input->post( 'gender' );
            $dob = $this->input->post( 'dob' );
            $dobw = $this->input->post( 'dobw' );
            $cnic = $this->input->post( 'CNIC' );
            $father_name = $this->input->post( 'father_guardian_name' );
            $father_cnic = $this->input->post( 'father_guardian_CNIC' );
            $father_profession = $this->input->post( 'father_guardian_profession' );
            $father_mobile = $this->input->post( 'father_guardian_mobile' );
            $admission_date = $this->input->post( 'date_of_admission' );
            $registration_new = $this->input->post( 'registration_new' );
            $registration_number = $this->input->post( 'registration_number' );
            $admission_class = $this->input->post( 'admission_class' );
            $current_class = $this->input->post( 'current_class' );
            $section = $this->input->post( 'section' );
            $school_branch = $this->input->post( 'school_branch' );
            $street_address = $this->input->post( 'street_address' );
            $colony = $this->input->post( 'colony' );
            $city = $this->input->post( 'city' );
            $monthly_fee = $this->input->post( 'monthly_fee' );
            $arears = $this->input->post( 'arears' );
            $exam_fee = $this->input->post( 'exam_fee' );
            $student_status = $this->input->post( 'student_status' );

            $mother_name = $this->input->post( 'mother_name' );
            $mother_cnic = $this->input->post( 'mother_cnic' );
            $mother_profession = $this->input->post( 'mother_profession' );
            $mother_phone = $this->input->post( 'mother_phone' );
            $mother_qualification = $this->input->post( 'mother_qualification' );

            $this->db->update( "student_registration", array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'gender' => $gender,
                'dob' => $dob,
                'dob_word' => $dobw,
                'cnic' => $cnic,
                'father_name' => $father_name,
                'father_cnic' => $father_cnic,
                'father_profession' => $father_profession,
                'father_mobile' => $father_mobile,
                'admission_date' => $admission_date,
                'registration_number' => $registration_number,
                'registration_new' => $registration_new,
                'admission_class' => $admission_class,
                'current_class' => $current_class,
                'section' => $section,
                'school_branch' => $school_branch,
                'street_address' => $street_address,
                'colony' => $colony,
                'city' => $city,
                'monthly_fee' => $monthly_fee,
                'arears' => $arears,
                'exam_fee_arears' => $exam_fee,
                'student_status' => $student_status,
                'mother_name' => $mother_name,
                'mother_cnic' => $mother_cnic,
                'mother_profession' => $mother_profession,
                'mother_phone' => $mother_phone,
                'mother_qualification' => $mother_qualification
            ), array(
                'student_registration_id' => $std_id
            ) );


            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 2000;
            $config['encrypt_name'] = TRUE;

            $this->load->library( 'upload', $config );


            if ( $_FILES['std_pic']['name'] ) {

                if ( $this->upload->do_upload( 'std_pic' ) ) {

                    $image_path = $this->upload->data( 'file_name' );
                    $image_path = "/uploads/{$image_path}";

                    $this->db->update( "student_registration", array('profile_pic' => $image_path), array('student_registration_id' => $std_id) );
                } else {

                    $this->session->set_flashdata( 'error', "Student Picture was not uploaded: " . $this->upload->display_errors() );
                }
            }


            $redirect = $this->input->get( 'redirect' );

            $redirect_url = ( !empty( $redirect ) ? urldecode( $redirect ) : 'admin-dashboard/student-update?stdid=' . $std_id );

            $this->session->set_flashdata( 'msg', 'Student information updated' );

            redirect( $redirect_url );
        }
    }

    public function student_update()
    {

        $std_id = $this->input->get( 'stdid' );
        $std_reg_no = $this->input->get( 'stdregno' );

        if ( empty( $std_id ) && empty( $std_reg_no ) ) {
            $this->session->set_flashdata( 'error', 'Student ID not provided.' );
            redirect( 'admin-dashboard/students' );
        } else {

            if ( !empty( $std_id ) ) {
                $student_details = $this->general_model->get_data( "*", "student_registration", array('student_registration_id' => $std_id), 1 );
                $std_reg_no = $student_details['registration_number'];
            } else {
                $student_details = $this->general_model->get_data( "*", "student_registration", array('registration_number' => $std_reg_no), 1 );
                $std_id = $student_details['student_registration_id'];
            }

            $redirect = $this->input->get( 'redirect' );

            $redirect_url = ( !empty( $redirect ) ? urldecode( $redirect ) : current_url() );

            $previous_student = $this->general_model->get_previous_student( $std_id );
            $next_student = $this->general_model->get_next_student( $std_id );

            $this->load->view( "admin_dashboard/student_update_view", array(
                'title' => "Student Updation",
                'student_details' => $student_details,
                'redirect_url' => $redirect_url,
                'previous_student' => $previous_student,
                'next_student' => $next_student,
                'std_reg_no' => $std_reg_no
            ) );
        }
    }

    public function payment_settings_update()
    {

        $this->form_validation->set_rules( 'fine_after_10', 'Fine after 10th of each month', 'trim|required|numeric' );

        if ( $this->form_validation->run() == false ) {
            $this->payment_settings();
        } else {

            $fine_after_10 = $this->input->post( 'fine_after_10' );

            $this->db->update( 'variables', array('value' => $fine_after_10), array('name' => 'fine_after_10') );

            $redirect_url = $this->general_library->redirect_url( 'admin-dashboard/payment_settings-update' );

            $this->general_library->redirect( $redirect_url, 1, "Values have been updated!" );
        }
    }

    public function payment_settings()
    {
        $current_url = $this->general_library->current_url();
        $this->load->view( "admin_dashboard/payment_settings_view", array(
            'title' => 'Change fine',
            'current_url' => $current_url
        ) );
    }

    public function add_news_process()
    {

        $this->form_validation->set_rules( 'news_title', 'Title', 'trim|required' );
        $this->form_validation->set_rules( 'description', 'Description', 'trim|required' );
        $this->form_validation->set_rules( 'post_type', 'Post type', 'trim|required|in_list[event,news]' );

        if ( $this->form_validation->run() == false ) {
            $this->add_news();
        } else {

            $title = $this->input->post( 'news_title' );
            $description = $this->input->post( 'description' );
            $post_type = $this->input->post( 'post_type' );

            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 2000;
            $config['encrypt_name'] = TRUE;

            $this->load->library( 'upload', $config );

            $image_path = '';

            if ( !empty( $_FILES['pic']['name'] ) ) {
                if ( !$this->upload->do_upload( 'pic' ) ) {
                    $this->session->set_flashdata( 'error', 'Couldn\'t upload image: ' . $this->upload->display_errors() );
                    redirect( 'admin_dashboard/add-news' );
                } else {

                    $image_path = "/uploads/" . $this->upload->data( 'file_name' );
                }
            }

            if ( $post_type == 'news' ) {

                $this->db->insert( 'news', array(
                    'title' => $title,
                    'description' => $description,
                    'image' => $image_path,
                    'added_time' => date( "Y-m-d H:i:s", time() )
                ) );

            } else {

                $this->db->insert( 'events', array(
                    'event_name' => $title,
                    'event_description' => $description,
                    'event_media' => $image_path,
                    'added_time' => date( "Y-m-d H:i:s", time() )
                ) );

            }

            $this->session->set_flashdata( 'msg', 'News has been added.' );
            redirect( "admin-dashboard/add-news" );
        }
    }

    public function add_news()
    {

        $this->load->view( "admin_dashboard/add_news_view", array('title' => 'Add News/Events') );
    }

    public function reg_card_get()
    {

        $this->form_validation->set_rules( 'reg_number[]', 'Registration number', 'trim|required' );

        if ( $this->form_validation->run() == false ) {
            $this->reg_card();
        } else {

            $reg_number = $this->input->post( 'reg_number' );
            $student_details = $this->general_model->get_data_query( "SELECT * FROM `student_registration` WHERE `registration_number` IN (" . implode( ',', $reg_number ) . ")" );

            if ( $student_details === false ) {
                $this->session->set_flashdata( 'error', 'This registration number is not assigned yet!' );
                redirect( 'admin_dashboard/reg_card' );
            } else {

                $this->load->view( 'admin_dashboard/reg_card_get_view', array('student_details' => $student_details) );
            }
        }
    }

    public function reg_card()
    {

        $this->load->view( 'admin_dashboard/reg_card_view', array('title' => 'Student registration card') );
    }

    public function leave_certificate_get()
    {

        $this->form_validation->set_rules( 'reg_number', 'Registration number', 'trim|required' );
        $this->form_validation->set_rules( 'from_date', 'Admission date', 'trim' );
        $this->form_validation->set_rules( 'to_date', 'Leaving date', 'trim' );
        $this->form_validation->set_rules( 'conduct', 'Conduct', 'trim' );

        if ( $this->form_validation->run() == false ) {
            $this->leave_certificate();
        } else {

            $reg_number = $this->input->post( 'reg_number' );
            $from_date = $this->input->post( 'from_date' );
            $leaving_date = $this->input->post( 'to_date' );
            $conduct = $this->input->post( 'conduct' );

            $student_details = $this->general_model->get_data( "*", "student_registration", array('registration_number' => $reg_number), 1 );

            if ( $student_details === false ) {
                $this->session->set_flashdata( 'error', 'This registration number is not assigned yet!' );
                redirect( 'admin_dashboard/leave_certificate' );
            } else {

                // if student status is not inactive
                if ( $student_details['student_status'] != 'inactive' ) {

                    // setting student inactive
                    $this->db->update( 'student_registration', array(
                        'student_status' => 'inactive'
                    ), array(
                        'registration_number' => $reg_number
                    ) );

                    // adding information to the withdrawn
                    $this->db->insert( 'withdrawn', array(
                        'withdrawn_time' => date( "Y-m-d H:i:s", now() ),
                        'leave_certificate_granted' => 1,
                        'student_registration_id' => $student_details['student_registration_id']
                    ) );
                }

                // showing the leave certificate
                $this->load->view( 'admin_dashboard/leave_certificate_get_view', array('student_details' => $student_details, 'leave_certificate' => array('admission_date' => $from_date, 'leaving_date' => $leaving_date, 'conduct' => $conduct)) );
            }
        }
    }

    public function leave_certificate()
    {

        $this->load->view( 'admin_dashboard/leave_certificate_view', array('title' => 'Leave/Chracter certificate') );
    }

    public function character_certificate_get()
    {

        $this->form_validation->set_rules( 'reg_number', 'Registration number', 'trim|required' );
        $this->form_validation->set_rules( 'from_date', 'Admission date', 'trim' );
        $this->form_validation->set_rules( 'to_date', 'Leaving date', 'trim' );
        $this->form_validation->set_rules( 'conduct', 'Conduct', 'trim' );

        if ( $this->form_validation->run() == false ) {
            $this->leave_certificate();
        } else {

            $reg_number = $this->input->post( 'reg_number' );
            $from_date = $this->input->post( 'from_date' );
            $leaving_date = $this->input->post( 'to_date' );
            $conduct = $this->input->post( 'conduct' );

            $student_details = $this->general_model->get_data( "*", "student_registration", array('registration_number' => $reg_number), 1 );

            if ( $student_details === false ) {
                $this->session->set_flashdata( 'error', 'This registration number is not assigned yet!' );
                redirect( 'admin_dashboard/leave_certificate' );
            } else {

                // showing the leave certificate
                $this->load->view( 'admin_dashboard/character_certificate_get_view', array('student_details' => $student_details, 'leave_certificate' => array('admission_date' => $from_date, 'leaving_date' => $leaving_date, 'conduct' => $conduct)) );
            }
        }
    }

    public function withdraw_process()
    {

        // form validation
        $this->form_validation->set_rules( 'reg_no', 'Registration Number', 'trim|required' );
        $this->form_validation->set_rules( 'comments', 'Comments', 'trim|required' );

        // check if form is validated
        if ( $this->form_validation->run() == false ) {
            $this->withdraw();
        } else {

            $reg_no = $this->input->post( 'reg_no' );
            $comments = $this->input->post( 'comments' );

            // get details of the student with reg number
            $student_details = $this->general_model->get_data( "*", 'student_registration', array(
                'registration_number' => $reg_no
            ), 1 );

            // check if user exists
            if ( $student_details === false ) {
                $this->general_library->redirect( 'admin-dashboard/withdraw', 0, "No student has that registration number." );
            } else {

                if ( $student_details['student_status'] !== 'inactive' ) {

                    // set user to inactive
                    $this->db->update( 'student_registration', array(
                        'student_status' => 'inactive'
                    ), array(
                        'student_registration_id' => $student_details['student_registration_id']
                    ) );

                    // add record to the withdrawl table
                    $this->db->insert( 'withdrawn', array(
                        'withdrawn_time' => date( "Y-m-d H:i:s", now() ),
                        'leave_certificate_granted' => 0,
                        'comments' => $comments,
                        'student_registration_id' => $student_details['student_registration_id']
                    ) );

                    $this->general_library->redirect( 'admin-dashboard/withdraw', 1, "Student with registration number " . $student_details['registration_number'] . " has been withdrawn." );
                } else {

                    $this->general_library->redirect( 'admin-dashboard/withdraw', 1, "Student with registration number " . $student_details['registration_number'] . " is already withdrawn." );
                }
            }
        }
    }

    public function withdraw()
    {

        $this->load->view( 'admin_dashboard/withdraw_view', array(
            'title' => 'Withdraw student'
        ) );
    }

    public function readmit_process()
    {

        $this->form_validation->set_rules( 'reg_no', 'Registration number', 'required|trim' );

        if ( $this->form_validation->run() == false ) {
            $this->withdraw();
        } else {

            $reg_no = $this->input->post( 'reg_no' );

            $student = $this->general_model->get_data( '*', 'student_registration', array(
                'registration_number' => $reg_no
            ), 1 );

            if ( $student === false ) {
                $this->general_library->redirect( 'admin-dashboard/withdraw', 0, "Student with " . $reg_no . " registration number doesn't exists in records." );
            } else {

                if ( $student['student_status'] == 'active' ) {
                    $this->general_library->redirect( 'admin-dashboard/withdraw', 0, "The student is not withdrawn in first place." );
                } else {
                    $this->db->update( 'student_registration', array(
                        'student_status' => 'active'
                    ), array(
                        'student_registration_id' => $student['student_registration_id']
                    ) );

                    $this->general_library->redirect( 'admin-dashboard/withdraw', 1, "Student has been re-admitted to the school." );
                }
            }
        }
    }

    public function add_teacher_process()
    {

        $this->form_validation->set_rules( 'name', 'Name', 'trim|required|max_length[255]' );
        $this->form_validation->set_rules( 'father_name', 'Father\'s name', 'trim|required|max_length[255]' );
        $this->form_validation->set_rules( 'gender', 'Gender', 'trim|required|max_length[6]' );
        $this->form_validation->set_rules( 'dob', 'Date of birth', 'trim|required' );
        $this->form_validation->set_rules( 'cnic', 'CNIC', 'trim|required|exact_length[13]|is_unique[teachers.cnic]', array('is_unique' => "This CNIC is already attached with a teacher's details.") );
        $this->form_validation->set_rules( 'street_address', 'Street address', 'trim|required|max_length[512]' );
        $this->form_validation->set_rules( 'colony', 'Colony', 'trim|required|max_length[100]' );
        $this->form_validation->set_rules( 'city', 'City', 'trim|required|max_length[100]' );

        // form validation failed
        if ( $this->form_validation->run() == false ) {
            $this->add_teacher();
        } else { // form validation passed
            $data = array(
                'name' => $this->input->post( 'name' ),
                'father_name' => $this->input->post( 'father_name' ),
                'pic' => 'uploads/default-profile-pic.jpg', // default
                'gender' => $this->input->post( 'gender' ),
                'dob' => $this->input->post( 'dob' ),
                'cnic' => $this->input->post( 'cnic' ),
                'street_address' => $this->input->post( 'street_address' ),
                'colony' => $this->input->post( 'colony' ),
                'city' => $this->input->post( 'city' )
            );

            $this->db->insert( 'teachers', $data );

            $inser_id = $this->db->insert_id();


            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 2000;
            $config['encrypt_name'] = TRUE;

            $this->load->library( 'upload', $config );

            if ( $_FILES['teacher_pic']['name'] ) {

                if ( $this->upload->do_upload( 'teacher_pic' ) ) {

                    $image_path = $this->upload->data( 'file_name' );
                    $image_path = "/uploads/{$image_path}";

                    $this->db->update( "teachers", array('pic' => $image_path), array('teacher_id' => $inser_id) );
                } else {

                    $this->session->set_flashdata( 'error', "Teacher's picture was not uploaded: " . $this->upload->display_errors() );
                }
            }


            $this->session->set_flashdata( 'msg', 'Teacher\'s record has been added successfully.' );

            redirect( 'admin-dashboard/add-teacher' );
        }
    }

    public function add_teacher()
    {

        $this->load->view( 'admin_dashboard/add_teacher_view', array('title' => 'Add new teacher details') );
    }

    public function teachers()
    {

        $teachers_details = $this->general_model->get_data( '*', 'teachers' );

        $this->load->view( 'admin_dashboard/teachers_view', array('title' => 'Teachers', 'teachers_details' => $teachers_details) );
    }

    public function teacher_details( $teacher_id = false )
    {

        if ( $teacher_id === false ) {
            $this->session->set_flashdata( 'error', "Teacher Identity is not provided!" );
            redirect( 'admin-dashboard/teachers' );
        } else {

            $teacher_details = $this->general_model->get_data( '*', 'teachers', array('teacher_id' => $teacher_id), 1 );

            $this->load->view( 'admin_dashboard/teacher_details_view', array('title' => 'Teacher details', 'teacher_details' => $teacher_details) );
        }
    }

    public function absent_students()
    {

        $branch = $this->input->get( 'school_branch' );
        $class = $this->input->get( 'current_class' );
        $section = $this->input->get( 'section' );

        $redirect_url = $this->general_library->redirect_url( "admin-dashboard/absent-students" );

        $student_details = null;

        // if all of the parameters are provided
        if ( !empty( $branch ) && !empty( $class ) && !empty( $section ) ) {
            $student_details = $this->general_model->get_data( "*", "student_registration", array(
                'school_branch' => $branch,
                'current_class' => $class,
                'section' => $section,
                'student_status' => 'active'
            ) );
        }

        $this->load->view( 'admin_dashboard/absent_students_view', array(
            'title' => 'Manage absent students',
            'redirect_url' => $redirect_url,
            'student_details' => $student_details,
            'sms_templates' => $this->general_model->get_data( '*', 'sms_templates' )
        ) );
    }

    public function absent_students_process()
    {
        $redirect_url = $this->general_library->redirect_url( 'admin-dashboard/absent-students' );

        $this->form_validation->set_rules( 'stdid[]', 'Student selection', "required" );
        $this->form_validation->set_rules( 'message', 'Message', 'trim' );
        $this->form_validation->set_rules( 'send_sms', 'Send SMS', 'required' );
        $this->form_validation->set_rules( 'absent_date', 'Absent date', 'trim' );

        if ( $this->form_validation->run() == false ) {
            $this->general_library->redirect( 'admin-dashboard/absent-students', 0, 'Maybe students not selected' );
        } else {

            $stdids = $this->input->post( 'stdid' );
            $message = $this->input->post( 'message' );
            $send_sms = $this->input->post( 'send_sms' );
            $absent_date = $this->input->post( 'absent_date' );
            $absent_time = ( !empty( $absent_date ) ? strtotime( $absent_date ) : now() );

            if ( $send_sms == 'yes' ) {

                // get phone numbers of the father
                $phone_numbers = $this->general_model->get_phone_numbers( $stdids );

                $send_sms = $this->general_library->send_sms( $phone_numbers, $message );

                if ( $send_sms === true ) {
                    $this->session->set_flashdata( 'msg', 'Your message has been sent to the mobile numbers and record for the absense of student has been saved.' );
                } else {
                    $this->session->set_flashdata( 'error', "Your message wasn't sent to the prents' mobile numbers. Kindly try again." );
                }
            } else {

                $this->session->set_flashdata( 'msg', 'Students have been marked as absent.' );
            }

            $student_details = $this->general_model->get_student_details_with_ids( $stdids );

            foreach ( $student_details as $stddet ) {
                // check if already absent
                $cnt = $this->general_model->calculate_absents( $stddet['student_registration_id'], date( 'Y-m-d', $absent_time ) . " 00:00:00", date( 'Y-m-d', $absent_time ) . " 23:59:59" );
                $cnt = intval( $cnt );

                if ( $cnt <= 0 ) {

                    $this->db->insert( 'absent_students', array(
                        'branch' => $stddet['school_branch'],
                        'class' => $stddet['current_class'],
                        'section' => $stddet['section'],
                        'student_registration_id' => $stddet['student_registration_id'],
                        'absent_time' => date( "Y-m-d H:i:s", $absent_time )
                    ) );
                }
            }

            $this->session->set_flashdata( 'msg', 'Selected students have been marked absent!' );
            redirect( $redirect_url );
        }
    }

    public function absent_students_report()
    {

        $this->form_validation->set_data( $_GET );
        $this->form_validation->set_rules( 'branch', 'Branch', 'trim|urldecode' );
        $this->form_validation->set_rules( 'class', 'Class', 'trim|urldecode' );
        $this->form_validation->set_rules( 'section', 'Section', 'trim|urldecode' );
        $this->form_validation->set_rules( 'report_from', 'Report from', 'trim|urldecode' );
        $this->form_validation->set_rules( 'report_to', 'Report to', 'trim|urldecode' );
        $this->form_validation->set_rules( 'q', 'Search', 'trim|urldecode' );

        $this->form_validation->run();

        $branch = $this->input->get( 'branch' );
        $class = $this->input->get( 'class' );
        $section = $this->input->get( 'section' );
        $report_from = $this->input->get( 'report_from' );
        $report_to = $this->input->get( 'report_to' );
        $q = $this->input->get( 'q' );

        $student_details = null;
        $dates_provided = false;

        // if any of the parameters is not empty
        if ( !empty( $branch ) || !empty( $class ) || !empty( $section ) || !empty( $report_from ) || !empty( $report_to ) || !empty( $q ) ) {

            $query = "SELECT `student_registration`.*, `absent_students`.`absent_students_id`, `absent_students`.`branch`, `absent_students`.`class`, `absent_students`.`section`, `absent_students`.`absent_time` FROM `student_registration` INNER JOIN `absent_students` ON `absent_students`.`student_registration_id` = `student_registration`.`student_registration_id`";

            $query .= ' WHERE';
            $add_and = false;

            if ( !empty( $branch ) ) {
                $query .= " student_registration.school_branch = " . $this->db->escape( $branch );
                $add_and = true;
            }

            if ( !empty( $class ) ) {
                $query .= ( $add_and === true ? " and" : "" ) . " student_registration.current_class = " . $this->db->escape( $class );
                $add_and = true;
            }

            if ( !empty( $section ) ) {
                $query .= ( $add_and === true ? " and" : "" ) . " student_registration.section = " . $this->db->escape( $section );
                $add_and = true;
            }

            if ( !empty( $report_from ) && !empty( $report_to ) ) {
                $report_to_date = new DateTime( $report_to );
                $report_to_date->add( new DateInterval( 'P1D' ) );
                $report_to_date->sub( new DateInterval( 'PT1S' ) );

                $query .= ( $add_and === true ? " and" : "" ) . " `absent_students`.`absent_time` >= " . $this->db->escape( date( "Y-m-d H:i:s", strtotime( $report_from ) ) ) . " AND `absent_students`.`absent_time` <= " . $this->db->escape( $report_to_date->format( 'Y-m-d H:i:s' ) );
                $add_and = true;

                $dates_provided = true;
            }

            if ( !empty( $q ) ) {
                $q = $this->db->escape_like_str( $q );
                $query .= ( $add_and === true ? " and" : "" ) . " student_registration.first_name = '%" . $q . "%' AND student_registration.last_name = '%" . $q . "%' AND student_registration.father_cnic = '%" . $q . "%' AND student_registration.registration_number = '%" . $q . "%'";
            }


            $query .= " ORDER BY `student_registration`.`registration_number` ASC, `absent_students`.`absent_time` DESC";

            $student_details = $this->general_model->get_data_query( $query );
        }

        $data = array(
            'title' => 'Report for absent students',
            'student_details' => $student_details,
            'dates_provided' => $dates_provided
        );

        if ( $dates_provided === true ) {
            $data['report_from'] = date( "Y-m-d H:i:s", strtotime( $report_from ) );
            $data['report_to'] = $report_to_date->format( 'Y-m-d H:i:s' );
        }

        $this->load->view( 'admin_dashboard/absent_students_report_view', $data );
    }

    public function promote_demote_students_process()
    {

        $this->form_validation->set_rules( 'std_id[]', 'Student', 'trim|required' );
        $this->form_validation->set_rules( 'branch', 'Branch', 'trim|required' );
        $this->form_validation->set_rules( 'class', 'Class', 'trim|required' );
        $this->form_validation->set_rules( 'section', 'Section', 'trim|required' );
        $this->form_validation->set_rules( 'redirect', 'URL', 'required' );

        if ( $this->form_validation->run() == false ) {
            $this->promote_demote_students();
        } else {

            $std_ids = $this->input->post( 'std_id' );
            $branch = $this->input->post( 'branch' );
            $class = $this->input->post( 'class' );
            $section = $this->input->post( 'section' );
            $redirect = $this->input->post( 'redirect' );

            foreach ( $std_ids as $id ) {
                $this->db->update( 'student_registration', array(
                    'current_class' => $class,
                    'section' => $section,
                    'school_branch' => $branch
                ), array(
                    'student_registration_id' => $id
                ) );
            }

            $this->general_library->redirect( $redirect, 1, "Records has been updated!" );
        }
    }

    public function promote_demote_students()
    {

        $this->form_validation->set_data( $_GET );

        $this->form_validation->set_rules( 'branch', 'Branch', 'trim|urldecode|required' );
        $this->form_validation->set_rules( 'class', 'Class', 'trim|urldecode|required' );
        $this->form_validation->set_rules( 'section', 'Section', 'trim|urldecode|required' );

        $student_details = null;
        if ( $this->form_validation->run() ) {
            $branch = $this->input->get( 'branch' );
            $class = $this->input->get( 'class' );
            $section = $this->input->get( 'section' );

            $student_details = $this->general_model->get_data( "*", "student_registration", array(
                'current_class' => $class,
                'section' => $section,
                'school_branch' => $branch
            ) );
        }

        $this->load->view( 'admin_dashboard/promote_demote_students_view', array(
            'title' => 'Promote/Demote students',
            'student_details' => $student_details
        ) );
    }

    public function attendance_sheet()
    {

        $this->form_validation->set_data( $_GET );

        $this->form_validation->set_rules( 'branch', 'Branch', 'trim|urldecode|required' );
        $this->form_validation->set_rules( 'class', 'Class', 'trim|urldecode|required' );
        $this->form_validation->set_rules( 'section', 'Section', 'trim|urldecode|required' );

        if ( $this->form_validation->run() == false ) {
            $this->general_library->redirect( 'admin-dashboard/students', 0, 'Missing details' );
        } else {

            $branch = $this->input->get( 'branch' );
            $class = $this->input->get( 'class' );
            $section = $this->input->get( 'section' );

            // get student details
            $student_details = $this->general_model->get_data( '*', 'student_registration', array(
                'school_branch' => $branch,
                'current_class' => $class,
                'section' => $section,
                'student_status' => 'active'
            ) );

            if ( $student_details === false ) {
                $this->general_library->redirect( 'admin-dashboard/students', 0, "There are no students in the " . $branch . " > " . $class . " > " . $section );
            } else {

                $this->load->view( 'admin_dashboard/attendance_sheet_view', array(
                    'title' => 'Attendance sheet',
                    'student_details' => $student_details,
                    'branch' => $branch,
                    'class' => $class,
                    'section' => $section
                ) );
            }
        }
    }

    public function sms_templates_process()
    {

        $this->form_validation->set_rules( 'template_text', 'Template text', 'trim|required|htmlspecialchars' );

        if ( $this->form_validation->run() == false ) {
            $this->sms_templates();
        } else {

            $this->db->insert( 'sms_templates', array(
                'sms_template_body' => $this->input->post( 'template_text' )
            ) );

            $this->general_library->redirect( 'admin-dashboard/sms-templates', 1, "SMS Template has been added." );
        }
    }

    public function sms_templates()
    {

        $sms_templates = $this->general_model->get_data( '*', 'sms_templates' );

        $this->load->view( 'admin_dashboard/sms_templates_view', array(
            'title' => 'SMS templates',
            'sms_templates' => $sms_templates
        ) );
    }

    public function sms_templates_delete( $template_id = false )
    {

        if ( $template_id === false ) {
            $this->general_library->redirect( 'admin-dashboard/sms_templates', 0, "You've been directed to wrong URL" );
        } else {

            $this->db->delete( 'sms_templates', array(
                'sms_template_id' => $template_id
            ) );

            $this->general_library->redirect( 'admin-dashboard/sms_templates', 1, "Requested template has been deleted successfully." );
        }
    }

    public function general_sms()
    {

        $this->form_validation->set_rules( 'reg_number[]', 'Registration Number', 'required|trim' );

        if ( $this->form_validation->run() == false ) {
            $this->students();
        } else {

            $reg_number = $this->input->post( 'reg_number' );
            $sms_templates = $this->general_model->get_data( "*", "sms_templates" );

            $this->load->view( 'admin_dashboard/general_sms_view', array(
                'title' => 'General SMS',
                'reg_number' => $reg_number,
                'sms_templates' => $sms_templates
            ) );
        }
    }

    public function students()
    {

        // form validation to the get array
        $this->form_validation->set_data( $_GET );
        $this->form_validation->set_rules( 'branch', 'Branch', 'urldecode|trim' );
        $this->form_validation->set_rules( 'class', 'Class', 'urldecode|trim' );
        $this->form_validation->set_rules( 'section', 'Section', 'urldecode|trim' );
        $this->form_validation->set_rules( 'q', 'Search query', 'urldecode|trim' );
        $this->form_validation->set_rules( 'withdrawn', 'Withdrawn', 'urldecode|trim' );
        $this->form_validation->run();

        $branch = $this->input->get( 'branch' );
        $class = $this->input->get( 'class' );
        $section = $this->input->get( 'section' );
        $student_search = $this->input->get( 'q' );
        $withdrawn = ( $this->input->get( 'withdrawn' ) == 'true' ? true : false );

        $show_roll_no = false;

        // if NONE of the branch class section are empty but student search is empty
        if ( !empty( $branch ) && !empty( $class ) && !empty( $section ) && empty( $student_search ) ) {
            $show_roll_no = true;
        }


        // if this search is only for withdrawn students
        if ( $withdrawn === true ) {
            $query = "SELECT `student_registration`.*, `withdrawn`.`withdrawn_id`, `withdrawn`.`withdrawn_time`, `withdrawn`.`leave_certificate_granted`, `withdrawn`.`comments` FROM `student_registration` LEFT JOIN `withdrawn` ON `withdrawn`.`student_registration_id` = `student_registration`.`student_registration_id`";
        } else {
            $query = "SELECT * FROM student_registration";
        }

        // check if any of the get fields are not empty
        if ( !empty( $branch ) || !empty( $class ) || !empty( $section ) || !empty( $student_search ) ) {
            $query .= " WHERE";

            if ( $withdrawn === true ) {
                $query .= " `student_registration`.`student_status` = 'inactive' AND";
            } else {
                $query .= " `student_registration`.`student_status` = 'active' AND";
            }
        } else {
            if ( $withdrawn === true ) {
                $query .= " WHERE `student_registration`.`student_status` = 'inactive'";
            } else {
                $query .= " WHERE `student_registration`.`student_status` = 'active'";
            }
        }

        $add_and = false;
        $current_search_string = "";

        // if branch is not empty
        if ( !empty( $branch ) ) {
            $current_search_string .= "Branch (<b>" . $branch . "</b>)";

            $query .= " `student_registration`.`school_branch` = " . $this->db->escape( $branch );
            $add_and = true;
        }

        // if class is not empty
        if ( !empty( $class ) ) {
            $current_search_string .= ( $add_and === true ? " > Class (<b>" . $class . "</b>)" : "" );

            $query .= ( $add_and === true ? " and" : "" ) . " `student_registration`.`current_class` = " . $this->db->escape( $class );
        }

        // if section is not empty
        if ( !empty( $section ) ) {
            $current_search_string .= ( $add_and === true ? " > Section(<b>" . $section . "</b>)" : "" );

            $query .= ( $add_and === true ? " and" : "" ) . " `student_registration`.`section` = " . $this->db->escape( $section );
        }

        // if student search is not empty
        if ( !empty( $student_search ) ) {
            $student_search_esc = $this->db->escape_like_str( $student_search );

            if ( is_numeric( $student_search ) ) {
                $query .= ( $add_and === true ? " and" : "" ) . " ( student_registration.registration_number = " . $this->db->escape( $student_search ) . " )";
            } else {
                $query .= ( $add_and === true ? " and" : "" ) . " ( `student_registration`.`first_name` LIKE '%" . $student_search_esc . "%' OR `student_registration`.`last_name` LIKE '%" . $student_search_esc . "%' OR student_registration.father_name LIKE '%" . $student_search_esc . "%' OR student_registration.father_cnic LIKE '%" . $student_search_esc . "%' OR student_registration.registration_number LIKE '%" . $student_search_esc . "%' )";
            }

            $current_search_string .= ( $add_and === true ? " > " . $student_search : "" );
        }

        $query .= " ORDER BY `student_registration`.`registration_number` ASC";

        $registered_students = $this->general_model->get_data_query( $query );
        $students_count = array(
            'total' => count( $registered_students ),
            'male' => 0,
            'female' => 0
        );
        foreach ( $registered_students as $registered_student ) {
            if ( $registered_student['gender'] == 'male' ) {
                $students_count['male'] += 1;
            } else {
                $students_count['female'] += 1;
            }
        }

        $redirect_url = current_url() . ( !empty( $_SERVER['QUERY_STRING'] ) ? "?" . $_SERVER['QUERY_STRING'] : "" );

        $is_admin = $this->account_library->logged_in_admin();

        $this->load->view( 'admin_dashboard/students_view', array(
            'title' => "All registered students",
            'students' => $registered_students,
            'student_search' => $student_search,
            'branch' => $branch,
            'class' => $class,
            'section' => $section,
            'current_search_string' => $current_search_string,
            'show_roll_no' => $show_roll_no,
            'withdrawn' => $withdrawn,
            'redirect_url' => $redirect_url,
            'students_count' => $students_count,
            'is_admin' => $is_admin
        ) );
    }

    public function general_sms_send()
    {

        $this->form_validation->set_rules( 'reg_number[]', 'Registration Number', 'required|trim' );
        $this->form_validation->set_rules( 'msg', 'Message', 'required|trim' );

        if ( $this->form_validation->run() == false ) {
            $this->students();
        } else {

            $reg_numbers = $this->input->post( 'reg_number' );
            $msg = $this->input->post( 'msg' );

            $numbers = $this->general_model->get_father_numbers_with_registration( $reg_numbers );
            $numbers = $this->general_library->validate_mobile_numbers( $numbers );

            $send_sms = $this->general_library->send_sms( $numbers, $msg );

            if ( $send_sms === true ) {
                $this->general_library->redirect( 'admin-dashboard/students', 1, "Your SMS has been sent to all the selected contacts." );
            } else {
                $this->general_library->redirect( 'admin-dashboard/students', 0, "Couldn't send your SMS. Please try again." );
            }
        }
    }

    public function best_students_process()
    {

        $this->form_validation->set_rules( 'name[]', 'Name', 'trim|required' );
        $this->form_validation->set_rules( 'registration_no[]', 'Registration Number', 'trim|required' );
        $this->form_validation->set_rules( 'roll_number[]', 'Roll Number', 'trim' );
        $this->form_validation->set_rules( 'father_name[]', "Father's name", 'trim' );
        $this->form_validation->set_rules( 'school_branch[]', 'School Branch', 'trim' );
        $this->form_validation->set_rules( 'current_class[]', 'Current Class', 'trim' );
        $this->form_validation->set_rules( 'section[]', 'Section', 'trim' );

        if ( $this->form_validation->run() == false ) {
            $this->best_students();
        } else {

            $this->db->truncate( 'best_students' );

            $name = $this->input->post( 'name[]' );
            $reg_no = $this->input->post( 'registration_no[]' );
            $roll_no = $this->input->post( 'roll_number[]' );
            $father_name = $this->input->post( 'father_name[]' );
            $school_branch = $this->input->post( 'school_branch[]' );
            $current_class = $this->input->post( 'current_class[]' );
            $section = $this->input->post( 'section[]' );

            for ( $i = 0; $i < 3; $i++ ) {

                $this->db->insert( 'best_students', array(
                    'student_name' => $name[$i],
                    'student_registration_no' => $reg_no[$i],
                    'roll_no' => $roll_no[$i],
                    'father_name' => $father_name[$i],
                    'branch' => $school_branch[$i],
                    'class' => $current_class[$i],
                    'section' => $section[$i]
                ) );

            }

            $this->general_library->redirect( 'admin-dashboard/best-students', 1, "Record has been updated" );

        }

    }

    public function best_students()
    {

        $best_students = $this->general_model->get_data( "*", "best_students", null, null, 'best_student_id', 'ASC' );

        $this->load->view( 'admin_dashboard/best_students_view', array(
            'title' => "Best Students of the month",
            'best_students' => $best_students
        ) );

    }

    public function create_accounts_process()
    {

        $user_type_names = $this->general_model->get_user_type_names();

        $this->form_validation->set_rules( 'acc_type', 'Account type', 'trim|required|in_list[' . implode( ',', $user_type_names ) . ']' );
        $this->form_validation->set_rules( 'username', 'Username', 'trim|required|strtolower|alpha_dash|is_unique[admin_users.admin_username]|max_length[50]' );
        $this->form_validation->set_rules( 'password', 'Password', 'required|max_length[60]' );
        $this->form_validation->set_rules( 'full_name', 'Full name', 'trim|max_length[50]' );

        if ( $this->form_validation->run() == false ) {
            $this->create_accounts();
        } else {

            $acc_type = $this->input->post( 'acc_type' );
            $username = $this->input->post( 'username' );
            $password = $this->input->post( 'password' );
            $full_name = $this->input->post( 'full_name' );

            $this->db->insert( 'admin_users', array(
                'admin_name' => $full_name,
                'admin_username' => $username,
                'admin_password' => password_hash( $password, PASSWORD_BCRYPT ),
                'admin_user_type' => $acc_type
            ) );

            $this->general_library->redirect( 'admin-dashboard/create-accounts', 1, "Account with username <b>" . $username . "</b> and provided password has been created successfully!" );
        }

    }

    public function create_accounts()
    {
        $accounts = $this->admin_user_model->get();

        $this->load->view( 'admin_dashboard/create_accounts_view', array(
            'title' => "Create Accounts",
            'user_type_names' => $this->general_model->get_user_type_names(),
            'accounts' => $accounts
        ) );

    }

    public function change_password_process()
    {
        $this->form_validation->set_rules( 'old_password', 'old_password', 'trim|required|min_length[3]' );
        $this->form_validation->set_rules( 'new_password', 'new_password', 'trim|required|min_length[3]|matches[new_password_confirmation]' );
        $this->form_validation->set_rules( 'new_password_confirmation', 'new_password_confirmation', 'trim|required|min_length[3]' );

        if ( $this->form_validation->run() == false ) {
            $this->change_password();
        } else {

            $old_password = $this->input->post( 'old_password' );
            $new_password = $this->input->post( 'new_password' );
            $new_password_confirmation = $this->input->post( 'new_password_confirmation' );

            $user_details = $this->admin_user_model->get( $this->session->userdata( 'user_id' ) );

            if ( $user_details === false ) {
                $this->general_library->redirect( 'admin-account/sign-out', 0, 'Please log in again' );
            } else {

                if ( password_verify( $old_password, $user_details['admin_password'] ) ) {

                    $new_password_hash = password_hash( $new_password, PASSWORD_BCRYPT );

                    $this->db->update( 'admin_users', array(
                        'admin_password' => $new_password_hash
                    ), array(
                        'admin_users_id' => $this->session->userdata( 'user_id' )
                    ) );

                    $this->general_library->redirect( 'admin-dashboard/change-password', 1, "Password has been updated!" );

                } else {
                    $this->general_library->redirect( 'admin-dashboard/change-password', 0, "Please make sure you provided accurate current password!" );
                }

            }

        }
    }

    public function change_password()
    {
        $data = array(
            'title' => 'Change password'
        );

        $this->load->view( 'admin_dashboard/change_password_view', $data );
    }

    public function add_datesheet()
    {

        $this->load->view( 'admin_dashboard/add_datesheet_view', array(
            'title' => 'Add datesheet'
        ) );

    }

    public function add_datesheet_process()
    {

        if ( $_FILES['file']['name'] ) {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = 2000;
            $config['encrypt_name'] = TRUE;

            $identified = 'datesheet';

            $this->load->library( 'upload', $config );

            if ( $this->upload->do_upload( 'file' ) ) {

                $file_data = $this->upload->data();
                $file_path = $file_data['full_path'];

                if ( $this->form_validation->is_unique( $identified, 'files.file_identifier' ) ) {

                    $this->db->insert( 'files', array(
                        'file_identifier' => $identified,
                        'file_path' => $file_path,
                        'add_on' => date( 'Y-m-d H:i:s', now() )
                    ) );

                } else {

                    $this->db->update( 'files', array(
                        'file_path' => $file_path,
                        'add_on' => date( 'Y-m-d H:i:s', now() )
                    ), array(
                        'file_identifier' => $identified
                    ) );

                }

                $this->general_library->redirect( 'admin-dashboard/add-datesheet', 1, "File has been updated" );

            } else {
                $this->general_library->redirect( 'admin-dashboard/add-datesheet', 0, $this->upload->display_errors() );
            }
        } else {
            $this->general_library->redirect( 'admin-daashboard/add-datesheet-process', 0, "Kindly select a file to upload" );
        }

    }

    public function time_table_process()
    {

        $this->form_validation->set_rules( 'teacher_id', 'Teacher ID', 'trim|required' );
        $this->form_validation->set_rules( 'branch', 'Branch', 'trim|required' );
        $this->form_validation->set_rules( 'class', 'Class', 'trim|required' );
        $this->form_validation->set_rules( 'section', 'Section', 'trim|required' );
        $this->form_validation->set_rules( 'class_start_time', 'Class start time', 'trim|required|strtotime' );
        $this->form_validation->set_rules( 'class_end_time', 'Class end time', 'trim|required|strtotime' );
        $this->form_validation->set_rules( 'subject', 'Subject', 'trim|required' );

        if ( $this->form_validation->run() == false ) {
            $this->time_table();
        } else {

            $teacher_id = $this->input->post( 'teacher_id' );
            $branch = $this->input->post( 'branch' );
            $class = $this->input->post( 'class' );
            $section = $this->input->post( 'section' );
            $class_start_time = $this->input->post( 'class_start_time' );
            $class_end_time = $this->input->post( 'class_end_time' );
            $subject = $this->input->post( 'subject' );

            $this->db->insert( 'time_table', array(
                'teacher_id' => $teacher_id,
                'class_start_time' => date( 'H:i:s', $class_start_time ),
                'class_end_time' => date( 'H:i:s', $class_end_time ),
                'branch' => $branch,
                'class' => $class,
                'section' => $section,
                'subject' => $subject
            ) );

            $this->general_library->redirect( 'admin-dashboard/time-table', 1, "Entry added in time table" );

        }

    }

    public function time_table()
    {

//        $this->form_validation->set_data($_GET);
//        $this->form_validation->set_rules('filter_by', 'Filter by', 'trim');
//        $this->form_validation->set_rules('teacher_id', 'Teacher ID', 'trim');
//        $this->form_validation->set_rules('school_branch', 'School branch', 'trim');
//        $this->form_validation->set_rules('current_class', 'Class', 'trim');
//        $this->form_validation->set_rules('section', 'Section', 'trim');
//        $this->form_validation->set_rules('time_start', 'Time from', 'trim');
//        $this->form_validation->set_rules('time_end', 'Time to', 'trim');

        $filter_by = $this->input->get( 'filter_by' );

        $teachers_details = $this->general_model->get_data( "*", "teachers", null, null, 'name', 'ASC' );

        $this->db->select( '`teachers`.`teacher_id`, `teachers`.`name`, `teachers`.`father_name`, `teachers`.`pic`, `teachers`.`gender`, `teachers`.`dob`, `teachers`.`cnic`, `teachers`.`street_address`, `teachers`.`colony`, `teachers`.`city`, `time_table`.`id`, `time_table`.`class_start_time`, `time_table`.`class_end_time`, `time_table`.`branch`, `time_table`.`class`, `time_table`.`section`, `time_table`.`subject`' );
        $this->db->from( 'teachers' );
        $this->db->join( 'time_table', "`teachers`.`teacher_id` = `time_table`.`teacher_id`", 'inner' );

        if ( $filter_by == 'teacher' ) {

            $teacher_id = $this->input->get( 'teacher_id' );
            $this->db->where( '`time_table`.`teacher_id`', $teacher_id );

        } else if ( $filter_by == 'branch_class_section' ) {

            $branch = $this->input->get( 'school_branch' );
            $class = $this->input->get( 'current_class' );
            $section = $this->input->get( 'section' );

            if ( !empty( $branch ) ) {
                $this->db->where( 'time_table.branch', $branch );
            }
            if ( !empty( $class ) ) {
                $this->db->where( 'time_table.class', $class );
            }
            if ( !empty( $section ) ) {
                $this->db->where( 'time_table.section', $section );
            }

        } else if ( $filter_by == 'time_range' ) {

            $time_start = $this->input->get( 'time_start' );
            $time_end = $this->input->get( 'time_end' );

            if ( !empty( $time_start ) ) {
                $this->db->where( 'time_table.class_start_time >=', date( 'H:i:s', strtotime( $time_start ) ) );
            }
            if ( !empty( $time_end ) ) {
                $this->db->where( 'time_table.class_start_time <=', date( 'H:i:s', strtotime( $time_end ) ) );
            }

        }

        $query = $this->db->get();
        if ( $query->num_rows() > 0 ) {
            $time_table = $query->result_array();
        } else {
            $time_table = false;
        }

        $this->load->view( 'admin_dashboard/time_table_view', array(
            'title' => 'Timetable',
            'teachers_details' => $teachers_details,
            'time_table' => $time_table
        ) );

    }

    public function time_table_delete( $time_table_id )
    {

        $this->db->delete( 'time_table', array(
            'id' => $time_table_id
        ) );

        $redirect_url = $this->general_library->redirect_url( 'admin-dashboard/time-table' );

        $this->general_library->redirect( $redirect_url, 1, "Time table entry has been deleted!" );

    }

    public function delete_account( $account_id )
    {

        $this->db->delete( 'admin_users', array(
            'admin_users_id' => $account_id
        ) );

        $this->general_library->redirect( 'admin-dashboard/create-accounts', 1, "Account has been deleted!" );

    }

}
