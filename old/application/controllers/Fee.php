<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Fee extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->account_library->login_in_check_process();

    }

    public function receive_fee_form()
    {
        $title = "Receive Fee";
        $this->load->view( 'fee/receive_fee_form_view', compact( 'title' ) );
    }

    public function receive_fee_form_process()
    {
        $this->form_validation->set_rules( 'pin', "PIN", "trim|required" );

        if ( $this->form_validation->run() == false ) {
            $this->receive_fee_form();
        } else {
            $pin = $this->input->post_get( 'pin' );

            $student_details = $this->general_model->get_data( '*', 'student_registration', array('student_registration_id' => $pin), 1 );

            if ( $student_details === false ) {
                $this->general_library->redirect( 'fee/receive_fee_form', 0, "That PIN is not attached to any student!" );
            } else {
                $url = "fee/receive-fee/{$student_details['student_registration_id']}?redirect_url=" . urlencode( current_url() );
                $this->general_library->redirect($url);
            }
        }
    }

    public function receive_fee_process( $student_id = false )
    {
        $redirect_url = $this->general_library->redirect_url( 'admin-dashboard/students' );

        if ( $student_id === false ) {
            $this->general_library->redirect( $redirect_url, 0, 'You were redirected to wrong link.' );
        } else {

            $student_details = $this->general_model->get_data( "*", 'student_registration', array(
                'student_registration_id' => $student_id
            ), 1 );

            if ( $student_details === FALSE ) {
                $this->general_library->redirect( $redirect_url, 0, "That user doesn't exists!" );
            } else {

                $this->form_validation->set_rules( 'adm_fee', 'Admission Fee', 'trim|integer|intval' );
                $this->form_validation->set_rules( 'reg_fee', 'Registration Fee', 'trim|integer|intval' );
                $this->form_validation->set_rules( 'tuition_fee', 'Tuition Fee', 'trim|integer|intval' );
                $this->form_validation->set_rules( 'comp_fee', 'Computer Fee', 'trim|integer|intval' );
                $this->form_validation->set_rules( 'exam_fee', 'Exam Fee', 'trim|integer|intval' );
                $this->form_validation->set_rules( 'arears', 'Arears', 'trim|integer|intval' );
                $this->form_validation->set_rules( 'fine', 'Fine', 'trim|integer|intval' );
                $this->form_validation->set_rules( 'other1', 'Other 1', 'trim|integer|intval' );
                $this->form_validation->set_rules( 'other2', 'Other 2', 'trim|integer|intval' );
                $this->form_validation->set_rules( 'other3', 'Other 3', 'trim|integer|intval' );
                $this->form_validation->set_rules( 'remission', 'Remission', 'trim|integer|intval' );
                $this->form_validation->set_rules( 'fee_for_number_of_months', 'Fee for number of months', 'trim|integer|intval' );

                if ( $this->form_validation->run() == false ) {
                    $this->receive_fee();
                } else {

                    $adm_fee = $this->input->post( 'adm_fee' );
                    $reg_fee = $this->input->post( 'reg_fee' );
                    $tuition_fee = $this->input->post( 'tuition_fee' );
                    $comp_fee = $this->input->post( 'comp_fee' );
                    $exam_fee = $this->input->post( 'exam_fee' );
                    $arears = $this->input->post( 'arears' );
                    $fine = $this->input->post( 'fine' );
                    $other1 = $this->input->post( 'other1' );
                    $other2 = $this->input->post( 'other2' );
                    $other3 = $this->input->post( 'other3' );
                    $remission = $this->input->post( 'remission' );
                    $fee_for_number_of_months = $this->input->post( 'fee_for_number_of_months' );
                    $advance_fee = $this->input->post( 'advance_fee' );

                    $adm_fee = ( $adm_fee === null ? 0 : $adm_fee );
                    $reg_fee = ( $reg_fee === null ? 0 : $reg_fee );
                    $tuition_fee = ( $tuition_fee === null ? 0 : $tuition_fee );
                    $comp_fee = ( $comp_fee === null ? 0 : $comp_fee );
                    $exam_fee = ( $exam_fee === null ? 0 : $exam_fee );
                    $arears = ( $arears === null ? 0 : $arears );
                    $fine = ( $fine === null ? 0 : $fine );
                    $other1 = ( $other1 === null ? 0 : $other1 );
                    $other2 = ( $other2 === null ? 0 : $other2 );
                    $other3 = ( $other3 === null ? 0 : $other3 );
                    $remission = ( $remission === null ? 0 : $remission );
                    $fee_for_number_of_months = ( $fee_for_number_of_months === null ? 0 : $fee_for_number_of_months );

                    // if advance fee has been selected
                    // change the tuition fee accordingly
                    if ( $advance_fee == '1' ) {
                        $tuition_fee = intval( $student_details['monthly_fee'] ) * $fee_for_number_of_months;
                    }

                    $sub_total = $adm_fee + $reg_fee + $tuition_fee + $comp_fee + $exam_fee + $arears + $fine + $other1 + $other2 + $other3;

                    $payable_upto_10 = $sub_total;
                    $payable_after_10 = intval( $this->general_model->db_variables( 'fine_after_10' ) ) + $payable_upto_10;

                    // if current date is greater than 10
                    if ( intval( date( 'd', now() ) ) > 10 ) {
                        $total = $payable_after_10;
                    } else {
                        $total = $payable_upto_10;
                    }

                    $total_with_remission = $total - $remission;

                    // if advance fee is NOT selected
                    if ( $advance_fee === null ) {

                        // get latest pending fee
                        $latest_pending_fee = $this->fee_model->get_latest_monthly_fee_details( $student_id, 2 );

                        if ( $latest_pending_fee !== false ) {
                            if ( $tuition_fee >= $latest_pending_fee['monthly_fee_detail_amount'] ) {
                                $this->db->update( 'monthly_fee_details', array(
                                    'monthly_fee_detail_paid_status' => 1
                                ), array(
                                    'monthly_fee_detail_id' => $latest_pending_fee['monthly_fee_detail_id']
                                ) );
                            }
                        }

                        // get any fee record for current month
                        $current_month_fee_record = $this->fee_model->get_latest_monthly_fee_details( $student_id, null, date( 'Y-m', now() ) . '-01' );
                        // if there is no record in current month for fee
                        if ( $current_month_fee_record === false ) {

                            // if monthly fee in student details is not 0 and paid tuition fee is greater or equal to the student monthly fee
                            if ( $tuition_fee >= $student_details['monthly_fee'] ) {
                                // insert record
                                $this->db->insert( 'monthly_fee_details', array(
                                    'monthly_fee_detail_date' => date( 'Y-m', now() ) . '-01',
                                    'monthly_fee_detail_amount' => $student_details['monthly_fee'],
                                    'monthly_fee_detail_paid_status' => 1,
                                    'student_registration_id' => $student_id
                                ) );

                                // updating fee processing date to the current month
                                $this->db->update( 'student_registration', array(
                                    'fee_month' => date( 'Y-m', now() ) . '-01'
                                ), array('student_registration_id' => $student_id) );
                            }
                        }

                    } else { // if advance fee is selected

                        $datetime = new DateTime( date( 'Y-m', now() ) . '-01' );

                        for ( $i = 0; $i < $fee_for_number_of_months; $i++ ) {

                            // for first
                            // current month will already be existing in DB
                            if ( $i == 0 ) {
                                // get current month fee record
                                $current_month_fee_record = $this->fee_model->get_latest_monthly_fee_details( $student_id, null, date( 'Y-m', now() ) . '-01' );
                                if ( $current_month_fee_record !== false ) {
                                    // if fee is pending
                                    if ( $current_month_fee_record['monthly_fee_detail_paid_status'] == 2 ) {
                                        // changing its status to paid
                                        $this->db->update( 'monthly_fee_details', array(
                                            'monthly_fee_detail_paid_status' => 1
                                        ), array(
                                            'monthly_fee_detail_id' => $current_month_fee_record['monthly_fee_detail_id']
                                        ) );

                                    } else if ( $current_month_fee_record['monthly_fee_detail_paid_status'] == 1 ) { // if fee for current month is already paid
                                        // add fee detail for next month
                                        $datetime->add( new DateInterval( "P1M" ) );

                                        // add entry to monthly fee details
                                        $this->db->insert( 'monthly_fee_details', array(
                                            'monthly_fee_detail_date' => $datetime->format( 'Y-m-d' ),
                                            'monthly_fee_detail_amount' => $student_details['monthly_fee'],
                                            'monthly_fee_detail_paid_status' => 1,
                                            'student_registration_id' => $student_details['student_registration_id']
                                        ) );
                                    }
                                }

                                // add one month
                                $datetime->add( new DateInterval( "P1M" ) );

                            } else { // all months after the first one

                                // add new record for the monthly fee
                                $this->db->insert( 'monthly_fee_details', array(
                                    'monthly_fee_detail_date' => $datetime->format( 'Y-m-d' ),
                                    'monthly_fee_detail_amount' => $student_details['monthly_fee'],
                                    'monthly_fee_detail_paid_status' => 1,
                                    'student_registration_id' => $student_details['student_registration_id']
                                ) );


                                // add one month
                                $datetime->add( new DateInterval( "P1M" ) );

                            }

                        }

                        // update fee month processing in student reg table
                        $this->db->update( 'student_registration', array(
                            'fee_month' => $datetime->format( 'Y-m-d' )
                        ), array(
                            'student_registration_id' => $student_details['student_registration_id']
                        ) );

                    }

                    // subtracting paid arears from the str reg table
                    $new_arears = intval( $student_details['arears'] ) - $arears;
                    $new_exam_arears = intval( $student_details['exam_fee_arears'] ) - $exam_fee;

                    $new_arears = ( $new_arears < 0 ? 0 : $new_arears );
                    $new_exam_arears = ( $new_exam_arears < 0 ? 0 : $new_exam_arears );

                    // updating student reg table
                    $this->db->update( 'student_registration', array(
                        'arears' => $new_arears,
                        'exam_fee_arears' => $new_exam_arears
                    ), array(
                        'student_registration_id' => $student_id
                    ) );

                    // adding fee paid details in the db table
                    $this->db->insert( 'fee_payments', array(
                        'fp_admission_fee' => $adm_fee,
                        'fp_registration_fee' => $reg_fee,
                        'fp_tuition_fee' => $tuition_fee,
                        'fp_exam_fee' => $exam_fee,
                        'fp_computer_fee' => $comp_fee,
                        'fp_fine' => $fine,
                        'fp_other1' => $other1,
                        'fp_other2' => $other2,
                        'fp_other3' => $other3,
                        'fp_payable_within_due_date' => $payable_upto_10,
                        'fp_payable_after_due_date' => $payable_after_10,
                        'fp_remission' => $remission,
                        'fp_total_fee' => $total,
                        'fp_paid_fee' => $total_with_remission,
                        'fp_payment_datetime' => date( 'Y-m-d H:i:s', now() ),
                        'student_registration_id' => $student_id
                    ) );

                    $fee_payment_insert_id = $this->db->insert_id();

                    $this->general_library->redirect( 'fee/view-fee-payment?payment_id=' . $fee_payment_insert_id . '&redirect=' . urlencode( $redirect_url ) );

                }

            }

        }

    }

    public function receive_fee( $student_id = false )
    {

        $redirect_url = $this->general_library->redirect_url( 'admin-dashboard/students' );

        if ( $student_id === false ) {
            $this->general_library->redirect( $redirect_url, 0, "Redirected to wrong link" );
        } else {

            $student_details = $this->general_model->get_data( "*", 'student_registration', array(
                'student_registration_id' => $student_id
            ), 1 );

            if ( $student_details === FALSE ) {
                $this->general_library->redirect( $redirect_url, 0, "That user doesn't exists!" );
            } else {

                $current_month_fee_details = $this->general_model->get_data( '*', 'monthly_fee_details', array(
                    'monthly_fee_detail_date' => date( 'Y-m', now() ) . '-01',
                    'student_registration_id' => $student_id
                ), 1 );

                $fee_history = $this->general_model->get_data( '*', 'monthly_fee_details', array(
                    'student_registration_id' => $student_id,
                ), 6, 'monthly_fee_detail_id', 'DESC' );

                $overall_payment_history = $this->general_model->get_data( '*', 'fee_payments', array(
                    'student_registration_id' => $student_id
                ), 6, 'fp_id', 'DESC' );

                $this->load->view( 'fee/receive_fee_view', array(
                    'title' => 'Receive fee',
                    'student_details' => $student_details,
                    'current_month_fee_details' => $current_month_fee_details,
                    'fee_history' => $fee_history,
                    'overall_payment_history' => $overall_payment_history,
                    'redirect_url' => $redirect_url
                ) );

            }

        }

    }

    public function today_collection()
    {

        $today_collection = $this->general_model->get_data_query( "SELECT * FROM `fee_payments` WHERE `fp_payment_datetime` LIKE '" . $this->db->escape_like_str( date( 'Y-m-d', now() ) ) . "%' ORDER BY`fp_id` ASC" );

        $today_collection_total = $this->general_model->get_data_query( "SELECT SUM(`fp_paid_fee`) AS sm FROM `fee_payments` WHERE `fp_payment_datetime` LIKE '" . $this->db->escape_like_str( date( 'Y-m-d', now() ) ) . "%'", false, 1 );
        $today_collection_total = intval( $today_collection_total['sm'] );

        $this->load->view( 'fee/today_collection_view', array(
            'title' => "Today's collection",
            'today_collection' => $today_collection,
            'today_collection_total' => $today_collection_total
        ) );
    }

    public function defaulters()
    {
        $redirect_url = $this->general_library->redirect_url( 'fee/defaulters' );

        $this->form_validation->set_data( $_GET );
        $this->form_validation->set_rules( 'school_branch', 'School Branch', 'trim' );
        $this->form_validation->set_rules( 'current_class', 'Class', 'trim' );
        $this->form_validation->set_rules( 'section', 'Section', 'trim' );
        $this->form_validation->run();

        $school_branch = $this->input->get( 'school_branch' );
        $current_class = $this->input->get( 'current_class' );
        $section = $this->input->get( 'section' );

        $defaulters = $this->fee_model->get_defaulters_details( $school_branch, $current_class, $section );

        $this->load->view( 'fee/defaulters_view', array(
            'title' => "Students who haven't submitted their fee for current month yet",
            'defaulters' => $defaulters,
            'redirect_url' => $redirect_url
        ) );

    }

    public function view_fee_payment()
    {

        $payment_id = $this->input->get( 'payment_id' );

        $redirect_url = $this->general_library->redirect_url( 'admin-dashboard/students' );

        if ( $payment_id === null ) {
            $this->general_library->redirect( $redirect_url, 0, "You were redirected to some wrong URL." );
        } else {

            $fee_payment_details = $this->general_model->get_data_query( "SELECT student_registration.*, fee_payments.* FROM student_registration INNER JOIN fee_payments ON fee_payments.student_registration_id = student_registration.student_registration_id WHERE fee_payments.fp_id = ? ORDER BY fee_payments.fp_id DESC", array($payment_id), 1 );

            $this->load->view( 'fee/view_fee_payment_view', array(
                'title' => 'Fee payment details',
                'redirect_url' => $redirect_url,
                'fee_payment_details' => $fee_payment_details
            ) );

        }

    }

    public function overall_statistics()
    {

        $this->form_validation->set_data( $_GET );
        $this->form_validation->set_rules( 'school_branch', 'Branch', 'trim' );
        $this->form_validation->set_rules( 'current_class', 'Class', 'trim' );
        $this->form_validation->set_rules( 'section', 'Section', 'trim' );
        $this->form_validation->set_rules( 'search', 'Search', 'trim' );
        $this->form_validation->set_rules( 'date_from', 'Date from', 'trim' );
        $this->form_validation->set_rules( 'date_to', 'Date to', 'trim' );
        $this->form_validation->run();

        $branch = $this->input->get( 'school_branch' );
        $class = $this->input->get( 'current_class' );
        $section = $this->input->get( 'section' );
        $search = $this->input->get( 'search' );
        $date_from = $this->input->get( 'date_from' );
        $date_to = $this->input->get( 'date_to' );

        $payment_records = $this->fee_model->get_payment_records( $branch, $class, $section, $search, $date_from, $date_to );
        $payment_records_grand_total = 0;

        // if payment records are available
        // getting grand total
        if ( $payment_records !== false ) {
            foreach ( $payment_records as $prcd ) {
                $payment_records_grand_total += intval( $prcd['fp_paid_fee'] );
            }
        }

        $fee_expected = $this->fee_model->fee_details( $branch, $class, $section, $search, $date_from, $date_to );
        $fee_paid = $this->fee_model->fee_details( $branch, $class, $section, $search, $date_from, $date_to, 1 );
        $fee_not_paid = $this->fee_model->fee_details( $branch, $class, $section, $search, $date_from, $date_to, 0 );
        $fee_pending = $this->fee_model->fee_details( $branch, $class, $section, $search, $date_from, $date_to, 2 );
        $exam_fee_arears = $this->fee_model->get_exam_fee_arears();
        $total_arears = $this->fee_model->get_arears();

        $this->load->view( 'fee/overall_statistics_view', array(
            'title' => "Overall Statistics",
            'date_from' => $date_from,
            'date_to' => $date_to,
            'payment_records' => $payment_records,
            'payment_records_grand_total' => $payment_records_grand_total,
            'fee_expected' => $fee_expected,
            'fee_paid' => $fee_paid,
            'fee_not_paid' => $fee_not_paid,
            'fee_pending' => $fee_pending,
            'exam_fee_arears' => $exam_fee_arears,
            'total_arears' => $total_arears
        ) );
    }

}