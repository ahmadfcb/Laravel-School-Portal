<?php

class General_model extends CI_Model
{

    public function get_data( $select, $from, $where = null, $limit = null, $order_by = null, $order_by_direction = null, $limit_offset = null )
    {

        $this->db->select( $select );
        $this->db->from( $from );

        if ( $where !== null ) {
            $this->db->where( $where );
        }

        if ( $limit !== null ) {

            if ( $limit_offset !== null ) {
                $this->db->limit( $limit, $limit_offset );
            } else {
                $this->db->limit( $limit );
            }

        }

        if ( $order_by !== null && $order_by_direction !== null ) {
            $this->db->order_by( $order_by, $order_by_direction );
        }

        $query = $this->db->get();

        $number_of_rows = $query->num_rows();

        // if no row returned
        if ( $number_of_rows == 0 ) {
            return FALSE;
        } else if ( $limit == 1 ) {
            return $query->row_array();
        } else if ( $number_of_rows > 0 ) {
            return $query->result_array();
        } else {
            return FALSE;
        }

    }

    public function get_data_query( $query_text, $bound_arr = false, $limit = false )
    {

        if ( $bound_arr === false ) {
            $query = $this->db->query( $query_text );
        } else {
            $query = $this->db->query( $query_text, $bound_arr );
        }

        $number_of_rows = $query->num_rows();

        // if no row returned
        if ( $number_of_rows == 0 ) {
            return FALSE;
        } else if ( $limit == 1 ) {
            return $query->row_array();
        } else if ( $number_of_rows > 0 ) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function db_variables( $name )
    {
        $query = $this->get_data( "value", 'variables', array('name' => $name), 1 );
        return $query['value'];
    }

    public function get_phone_numbers( $stdids )
    {
        if ( !empty( $stdids ) ) {

            $this->db->select( 'father_mobile' );
            $this->db->from( 'student_registration' );
            $this->db->where_in( 'student_registration_id', $stdids );

            $query = $this->db->get();

            if ( $query->num_rows() > 0 ) {

                $rows = $query->result_array();
                $phone_numbers = array();

                foreach ( $rows as $ph ) {
                    $phone_numbers[] = $ph['father_mobile'];
                }

                return $phone_numbers;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function get_father_numbers_with_registration( $registration_number )
    {

        $this->db->select( 'father_mobile' );
        $this->db->from( 'student_registration' );
        $this->db->where_in( 'registration_number', $registration_number );
        $this->db->where( 'father_mobile !=', '' );

        $query = $this->db->get();

        if ( $query->num_rows() > 0 ) {
            $phone_numbers = $query->result_array();
            $numbers = array();

            foreach ( $phone_numbers as $nmb ) {
                $numbers[] = $nmb['father_mobile'];
            }

            return $numbers;
        } else {
            return false;
        }

    }

    public function get_student_details_with_ids( array $student_reg_ids )
    {

        $this->db->where_in( 'student_registration_id', $student_reg_ids );
        $query = $this->db->get( 'student_registration' );

        if ( $query->num_rows() > 0 ) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_latest_registration_number()
    {

        $this->db->select( 'registration_number' );
        $this->db->order_by( 'student_registration_id', 'desc' );
        $this->db->limit( 1 );
        $query = $this->db->get( 'student_registration' );

        if ( $query->num_rows() == 1 ) {
            $result = $query->row_array();
            return $result['registration_number'];
        } else {
            return false;
        }

    }

    public function calculate_absents( $user_id, $time_from, $time_to )
    {

        return $this->db->from( 'student_attendance' )
            ->where( 'student_attendance.attendance_date >=', date( 'Y-m-d', strtotime( $time_from ) ) )
            ->where( 'student_attendance.attendance_date <=', date( 'Y-m-d', strtotime( $time_to ) ) )
            ->where( 'student_attendance.student_id', $user_id )
            ->count_all_results();

    }

    public function fee_paid_statistics( $branch, $class, $section, $from_date, $to_date )
    {

        // getting total payments during the selected duration
        $this->db->select( 'sum(fee_paid.amount) paid_fee' );
        $this->db->from( 'student_registration' );
        $this->db->join( 'fee_vouchers', 'fee_vouchers.student_registration_id = student_registration.student_registration_id', 'inner' );
        $this->db->join( 'fee_paid', 'fee_paid.voucher_id = fee_vouchers.voucher_id', 'inner' );

        if ( !empty( $branch ) ) {
            $this->db->where( 'school_branch', $branch );
        }
        if ( !empty( $class ) ) {
            $this->db->where( 'current_class', $class );
        }
        if ( !empty( $section ) ) {
            $this->db->where( 'section', $section );
        }
        if ( !empty( $from_date ) ) {
            $this->db->where( 'fee_paid_date >=', date( 'Y-m-d', $from_date ) );
        }
        if ( !empty( $to_date ) ) {
            $this->db->where( 'fee_paid_date <=', date( 'Y-m-d', $to_date ) );
        }

        $query = $this->db->get();

        $result = $query->row_array();

        // Getting remaining dues till now
        $this->db->select( 'sum(total_fee_due) AS total_remaining' );
        $query2 = $this->db->get( 'student_registration' );
        $remaining_dues = $query2->row_array();

        $result['total_remaining_dues'] = $remaining_dues['total_remaining'];


        return $result;
    }

    public function get_user_type_names()
    {
        $result = $this->get_data( "user_type_name", "admin_user_types" );

        if ( $result === false ) {
            return false;
        } else {
            $user_type_names = array();

            foreach ( $result as $rslt ) {
                $user_type_names[] = $rslt['user_type_name'];
            }

            return $user_type_names;
        }
    }

    public function search_students( $branch, $class, $section, $query, $active = true )
    {

        $this->db->select( "*" );
        $this->db->from( 'student_registration' );

        if ( !empty( $branch ) ) {
            $this->db->where( 'school_branch', $branch );
        }

        if ( !empty( $class ) ) {
            $this->db->where( 'current_class', $class );
        }

        if ( !empty( $section ) ) {
            $this->db->where( 'section', $section );
        }

        if ( !empty( $query ) ) {
            $query_esc = $this->db->escape_like_str( $query );
            $this->db->where( "(first_name LIKE '%" . $query_esc . "%' OR last_name LIKE '%" . $query_esc . "%' OR cnic LIKE '%" . $query_esc . "%' OR father_cnic LIKE '%" . $query_esc . "%' OR registration_number LIKE '%" . $query_esc . "%')" );
        }

        $db_query = $this->db->get();

        if ( $db_query->num_rows() > 0 ) {
            return $db_query->result_array();
        } else {
            return false;
        }

    }

    public function get_previous_student( $student_id )
    {
        $q = $this->db->select( '*' )
            ->from( 'student_registration' )
            ->where( "student_registration_id = (SELECT MIN(student_registration_id) FROM student_registration where student_registration_id < " . $this->db->escape( $student_id ) . ")" )
            ->get();

        if ( $q->num_rows() > 0 ) {
            return $q->row_array();
        } else {
            return false;
        }
    }

    public function get_next_student( $student_id )
    {
        $q = $this->db->select( '*' )
            ->from( 'student_registration' )
            ->where( "student_registration_id = (SELECT MIN(student_registration_id) FROM student_registration where student_registration_id > " . $this->db->escape( $student_id ) . ")" )
            ->get();

        if ( $q->num_rows() > 0 ) {
            return $q->row_array();
        } else {
            return false;
        }
    }

}
