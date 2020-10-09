<?php

class Student_attendance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->account_library->login_in_check_process();
    }

    public function index()
    {
        $branch = $this->input->get( 'school_branch' );
        $class = $this->input->get( 'current_class' );
        $section = $this->input->get( 'section' );

        //$redirect_url = $this->general_library->redirect_url( "admin-dashboard/absent-students" );
        $redirect_url = $this->general_library->redirect_url( "student-attendance" );

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

        $this->load->view( 'student_attendance/index_view', array(
            'title' => 'Manage absent students',
            'redirect_url' => $redirect_url,
            'student_details' => $student_details,
            'sms_templates' => $this->general_model->get_data( '*', 'sms_templates' )
        ) );
    }

    public function process()
    {

        $student = $this->input->post( 'student' );
        $send_sms = $this->input->post( 'send_sms' );
        $message = $this->input->post( 'message' );
        $attendance_date = $this->input->post( 'attendance_date' );

        for ( $i = 0; $i < count( $student ); $i++ ) {
            $this->form_validation->set_rules( "student[{$i}][student_id]", "Student ID", "required|trim" );
            $this->form_validation->set_rules( "student[{$i}][attendance]", "Student Attendance", "required|trim|in_list[present,absent,late]" );
        }
        $this->form_validation->set_rules( 'send_sms', 'Send SMS option', 'required|trim|in_list[yes,no]' );
        $this->form_validation->set_rules( 'message', 'Parent\'s Message', 'trim' );
        $this->form_validation->set_rules( 'attendance_date', "Attendance Date", 'required|trim|strtotime' );

        if ( $this->form_validation->run() == false ) {
            $this->index();
        } else {

            $created_on = date( 'Y-m-d', now() );
            $attendance_date = ( !empty( $attendance_date ) ? date( 'Y-m-d', strtotime( $attendance_date ) ) : date( 'Y-m-d', now() ) );
            $student_ids = array();

            foreach ( $student as $std ) {
                $student_attendance = $this->general_model->get_data( '*', 'student_attendance', array(
                    'student_id' => $std['student_id'],
                    'attendance_date' => $attendance_date
                ), 1 );

                if ( $student_attendance === false ) {
                    $this->db->insert( 'student_attendance', array(
                        'student_id' => $std['student_id'],
                        'attendance' => $std['attendance'],
                        'attendance_date' => $attendance_date,
                        'created_on' => $created_on
                    ) );

                    $student_ids = $std['student_id'];
                } else {
                    $this->db->update( 'student_attendance', array(
                        'attendance' => $std['attendance']
                    ), array(
                        'student_id' => $std['student_id'],
                    ) );
                }
            }

            $redirect_message = "Attendance has been marked for this class.";

            $phone_numbers = $this->general_model->get_phone_numbers( $student_ids );

            if ( $send_sms == 'yes' ) {
                $send_sent = $this->general_library->send_sms( $phone_numbers, $message );

                if ( $send_sent === true ) {
                    $redirect_message += " SMS has been sent.";
                } else {
                    $redirect_message += " SMS couldn't be sent to all the parents.";
                }
            }

            $redirect_url = $this->general_library->redirect_url( 'student-attendance' );

            $this->general_library->redirect( $redirect_url, 1, $redirect_message );

        }
    }

    public function report()
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

        if ( !empty( $report_from ) && !empty( $report_to ) ) {
            $dates_provided = true;
        } else {
            $dates_provided = false;
        }

        $report_from = $this->input->get( 'report_from' );
        $report_from = ( !empty( $report_from ) ? date( 'Y-m-d', strtotime( $report_from ) ) : date( 'Y-m-d', now() ) );

        $report_to = $this->input->get( 'report_to' );
        $report_to = ( !empty( $report_to ) ? date( 'Y-m-d', strtotime( $report_to ) ) : date( 'Y-m-d', now() ) );

        $q = $this->input->get( 'q' );

        $student_details = null;

        // if any of the parameters is not empty
        if ( !empty( $branch ) || !empty( $class ) || !empty( $section ) || !empty( $report_from ) || !empty( $report_to ) || !empty( $q ) ) {

            $student_details = $this->student_model->get_absent_students( $branch, $class, $section, $report_from, $report_to, $q );

        }

        $data = array(
            'title' => 'Report for absent students',
            'student_details' => $student_details,
            'dates_provided' => $dates_provided
        );

        if ( $dates_provided === true ) {
            $data['report_from'] = date( "Y-m-d H:i:s", strtotime( $report_from ) );
            $rprto = new DateTime( $report_to );
            $rprto->add( new DateInterval( 'P1D' ) );
            $rprto->sub( new DateInterval( 'PT1S' ) );
            $data['report_to'] = $rprto->format( 'Y-m-d' );
        }

        $this->load->view( 'student_attendance/report_view', $data );
    }
}