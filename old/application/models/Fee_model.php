<?php

class Fee_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

        $this->keep_updating_fee();
        $this->keep_updating_exam_fee();
    }

    public function keep_updating_fee()
    {

        $std_details = $this->general_model->get_data_query( "SELECT * FROM student_registration WHERE fee_month < ? AND student_status = 'active'", array(
            date( 'Y-m', now() ) . '-01'
        ) );

        if ( $std_details !== false ) {

            foreach ( $std_details as $std ) {

                $monthly_fee_details = $this->general_model->get_data( "*", "monthly_fee_details", array(
                    'student_registration_id' => $std['student_registration_id'],
                    'monthly_fee_detail_paid_status' => 2
                ), 1, 'monthly_fee_detail_id', 'DESC' );

                // if there is no pending fee detail available
                if ( $monthly_fee_details === false ) {

                    $this->db->insert( 'monthly_fee_details', array(
                        'monthly_fee_detail_date' => date( 'Y-m' ) . '-01',
                        'monthly_fee_detail_amount' => $std['monthly_fee'],
                        'monthly_fee_detail_paid_status' => 2,
                        'student_registration_id' => $std['student_registration_id']
                    ) );


                    // updating fee month to current month
                    $this->db->update( 'student_registration', array(
                        'fee_month' => date( 'Y-m' ) . '-01'
                    ), array(
                        'student_registration_id' => $std['student_registration_id']
                    ) );

                } else { // there is pending fee available

                    // add pending fee in the arears
                    // adding fee month to current month
                    $this->db->update( 'student_registration', array(
                        'arears' => intval( $std['arears'] ) + intval( $monthly_fee_details['monthly_fee_detail_amount'] ),
                        'fee_month' => date( 'Y-m' ) . '-01'
                    ), array(
                        'student_registration_id' => $std['student_registration_id']
                    ) );

                    // update pending fee to not paid
                    $this->db->update( 'monthly_fee_details', array(
                        'monthly_fee_detail_paid_status' => 0
                    ), array(
                        'monthly_fee_detail_id' => $monthly_fee_details['monthly_fee_detail_id']
                    ) );

                    // add new pending fee for current month
                    $this->db->insert( 'monthly_fee_details', array(
                        'monthly_fee_detail_date' => date( 'Y-m' ) . '-01',
                        'monthly_fee_detail_amount' => $std['monthly_fee'],
                        'monthly_fee_detail_paid_status' => 2,
                        'student_registration_id' => $std['student_registration_id']
                    ) );

                }

            }

        }

    }

    public function keep_updating_exam_fee()
    {
        $session_start_date = date( 'Y-m-d', strtotime( $this->general_model->db_variables( 'session_start_date' ) . date( '-Y', now() ) ) );

        // get all the records having date lower than current one
        $std_details = $this->general_model->get_data( '*', 'student_registration', array(
            'exam_fee_arear_update_date <' => $session_start_date,
            'student_status' => 'active'
        ) );

        // exam fee
        $exam_fee = $this->general_model->db_variables( 'exam_fee' );
        $exam_fee_update_date = $session_start_date;

        if ( $std_details !== false ) {
            foreach ( $std_details as $std ) {

                // update std reg with current date and exam fee
                $this->db->update( 'student_registration', array(
                    'exam_fee_arears' => intval( $std['exam_fee_arears'] ) + intval( $exam_fee ),
                    'exam_fee_arear_update_date' => $exam_fee_update_date
                ), array('student_registration_id' => $std['student_registration_id']) );

            }
        }
    }

    /**
     * Gets the latest monthly fee row from the DB
     * @param int $student_id
     * @param int|null $paid_status 0 for not paid. 1 for paid. 2 for pending
     * @return boolean
     */
    public function get_latest_monthly_fee_details( $student_id, $paid_status, $fee_month = null )
    {

        $this->db->select( '*' );
        $this->db->from( 'monthly_fee_details' );
        $this->db->where( 'student_registration_id', $student_id );

        if ( $paid_status !== null ) {
            $this->db->where( 'monthly_fee_detail_paid_status', $paid_status );
        }

        if ( $fee_month !== null ) {
            $this->db->where( 'monthly_fee_detail_date', $fee_month );
        }

        $this->db->order_by( 'monthly_fee_detail_id', 'DESC' );
        $this->db->limit( 1 );

        $query = $this->db->get();

        if ( $query->num_rows() > 0 ) {
            return $query->row_array();
        } else {
            return false;
        }

    }

    /**
     * Gets records of defaulters who haven't submitted their fee for the current month
     * @param string|null $branch
     * @param string|null $class
     * @param string|null $section
     * @return array|bool
     */
    public function get_defaulters_details( $branch = null, $class = null, $section = null )
    {
        $this->db->select( 'student_registration.*, monthly_fee_details.*' );
        $this->db->from( 'student_registration' );
        $this->db->join( 'monthly_fee_details', "monthly_fee_details.student_registration_id = student_registration.student_registration_id", 'inner' );
        $this->db->where( 'monthly_fee_details.monthly_fee_detail_paid_status !=', 1 );
        $this->db->like( 'monthly_fee_details.monthly_fee_detail_date', date( 'Y-m' ), 'after' );

        if ( !empty( $branch ) ) {
            $this->db->where( 'student_registration.school_branch', $branch );
        }
        if ( !empty( $class ) ) {
            $this->db->where( 'student_registration.current_class', $class );
        }
        if ( !empty( $section ) ) {
            $this->db->where( 'student_registration.section', $section );
        }

        $query = $this->db->get();

        if ( $query->num_rows() > 0 ) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function get_payment_records( $branch, $class, $section, $search, $date_from, $date_to )
    {
        $this->db->select( "student_registration.*, fee_payments.*" );
        $this->db->from( 'student_registration' );
        $this->db->join( 'fee_payments', 'fee_payments.student_registration_id = student_registration.student_registration_id', 'INNER' );

        if ( !empty( $branch ) ) {
            $this->db->where( 'student_registration.school_branch', $branch );
        }
        if ( !empty( $class ) ) {
            $this->db->where( 'student_registration.current_class', $class );
        }
        if ( !empty( $section ) ) {
            $this->db->where( 'student_registration.section', $section );
        }
        if ( !empty( $search ) ) {
            $search_esc = $this->db->escape_like_str( $search );
            $this->db->where( "( `student_registration.first_name` LIKE '%" . $search_esc . "%' OR `student_registration.last_name` LIKE '%" . $search_esc . "%' OR `student_registration.cnic` LIKE '%" . $search_esc . "%' OR `student_registration.father_cnic` LIKE '%" . $search_esc . "%' OR `student_registration.registration_number` LIKE '%" . $search_esc . "%' )" );
        }

        if ( !empty( $date_from ) && !empty( $date_to ) ) {
            $this->db->where( "fee_payments.fp_payment_datetime BETWEEN " . $this->db->escape( $date_from ) . " AND " . $this->db->escape( $date_to ) );
        } else { // get records from current month
            $this->db->like( 'fee_payments.fp_payment_datetime', date( 'Y-m' ), 'after' );
        }

        $query = $this->db->get();

        if ( $query->num_rows() > 0 ) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function fee_details( $branch, $class, $section, $search, $date_from, $date_to, $fee_details_type = null )
    {

        $this->db->select( 'COALESCE( SUM( `monthly_fee_details`.`monthly_fee_detail_amount` ), 0 ) as sm' );
        $this->db->from( 'student_registration' );
        $this->db->join( 'monthly_fee_details', 'monthly_fee_details.student_registration_id = student_registration.student_registration_id', 'inner' );

        if ( !empty( $branch ) ) {
            $this->db->where( 'student_registration.school_branch', $branch );
        }
        if ( !empty( $class ) ) {
            $this->db->where( 'student_registration.current_class', $class );
        }
        if ( !empty( $section ) ) {
            $this->db->where( 'student_registration.section', $section );
        }
        if ( !empty( $search ) ) {
            $search_esc = $this->db->escape_like_str( $search );
            $this->db->where( "( `student_registration.first_name` LIKE '%" . $search_esc . "%' OR `student_registration.last_name` LIKE '%" . $search_esc . "%' OR `student_registration.cnic` LIKE '%" . $search_esc . "%' OR `student_registration.father_cnic` LIKE '%" . $search_esc . "%' OR `student_registration.registration_number` LIKE '%" . $search_esc . "%' )" );
        }
        if ( !empty( $date_from ) && !empty( $date_to ) ) {
            $this->db->where( "monthly_fee_details.monthly_fee_detail_date BETWEEN " . $this->db->escape( $date_from ) . " AND " . $this->db->escape( $date_to ) );
        } else { // get records from current month
            $this->db->like( 'monthly_fee_details.monthly_fee_detail_date', date( 'Y-m' ), 'after' );
        }

        if ( $fee_details_type !== null ) {
            $this->db->where( 'monthly_fee_details.monthly_fee_detail_paid_status', $fee_details_type );
        }

        $query = $this->db->get();

        if ( $query->num_rows() > 0 ) {
            $result = $query->row_array();
            return $result['sm'];
        } else {
            return false;
        }

    }

    public function calculate_current_month_pending_fee()
    {
        $this->db->select( "COALESCE( SUM( `monthly_fee_detail_amount` ), 0 ) AS sm" );
        $this->db->from( 'monthly_fee_details' );
        $this->db->like( 'monthly_fee_detail_date', date( 'Y-m', now() ), 'after' );

        $query = $this->db->get();

        $pending_fee = $query->row_array();
        $pending_fee = intval( $pending_fee['sm'] );

        return $pending_fee;
    }

    public function get_exam_fee_arears()
    {
        $this->db->select( "COALESCE( SUM( `exam_fee_arears` ), 0 ) AS sm" );
        $this->db->from( 'student_registration' );

        $query = $this->db->get();

        $sum = $query->row_array();
        $sum = intval( $sum['sm'] );

        return $sum;
    }

    public function get_arears()
    {
        $this->db->select( "COALESCE( SUM( `arears` ), 0 ) AS sm" );
        $this->db->from( 'student_registration' );

        $query = $this->db->get();

        $arears = $query->row_array();
        $arears = intval( $arears['sm'] );

        $total = $arears + $this->calculate_current_month_pending_fee();

        return $total;

    }

}