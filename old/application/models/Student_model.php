<?php

class Student_model extends CI_Model
{
    public $table_name = "student_registration";

    public function get( $id = null )
    {
        $this->db->from( $this->table_name );

        if ( $id !== null ) {
            $this->db->where( 'student_registration_id', $id );
        }

        $q = $this->db->get();

        if ( $id === null ) {
            return $q->result_array();
        } else {
            return $q->row_array();
        }
    }

    public function get_absent_students( $branch = null, $class = null, $section = null, $report_from = null, $report_to = null, $q = null )
    {
        $this->db->select( '`student_registration`.*, `student_attendance`.*, count(*) as absent_count' )
            ->from( 'student_registration' )
            ->join( 'student_attendance', 'student_attendance.student_id = student_registration.student_registration_id', 'inner' );

        $this->db->group_start();

        if ( !empty( $branch ) ) {
            $this->db->where( 'student_registration.school_branch', $branch );
        }

        if ( !empty( $class ) ) {
            $this->db->where( 'student_registration.current_class', $class );
        }

        if ( !empty( $section ) ) {
            $this->db->where( 'student_registration.section', $section );
        }

        if ( !empty( $report_from ) ) {
            $this->db->where( 'student_attendance.attendance_date >=', date( 'Y-m-d', strtotime( $report_from ) ) );
        }

        if ( !empty( $report_to ) ) {
            $this->db->where( 'student_attendance.attendance_date <=', date( 'Y-m-d', strtotime( $report_to ) ) );
        }

        if ( !empty( $q ) ) {

            if ( is_numeric( $q ) ) {
                $this->db->where( '`student_registration`.`registration_number`', $q );
            } else {
                $this->db->group_start();
                $this->db->like( '`student_registration`.`first_name`', $q, 'both' );
                $this->db->or_where( '`student_registration`.`cnic`', $q );
                $this->db->or_like( 'student_registration.father_cnic', $q, 'both' );
                $this->db->group_end();
            }
        }

        $this->db->group_end();

        $this->db->where( '`student_registration`.`student_status`', 'active' );

        $this->db->where( 'student_attendance.attendance', 'absent' );

        $this->db->group_by( 'student_registration.student_registration_id' );

        $query = $this->db->get();

        if ( $query->num_rows() > 0 ) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function new_students( $branch = null, $class = null, $section = null, $date_from = null, $date_to = null, $withdrawn = null )
    {
        $this->db
            ->select( '*' )
            ->from( $this->table_name );

        if ( !empty( $branch ) ) {
            $this->db->where( 'school_branch', $branch );
        }

        if ( !empty( $class ) ) {
            $this->db->where( 'current_class', $class );
        }

        if ( !empty( $section ) ) {
            $this->db->where( 'section', $section );
        }

        if ( !empty( $date_from ) ) {
            $this->db->where( 'admission_date >=', date( 'Y-m-d', strtotime( $date_from ) ) );
        }

        if ( !empty( $date_to ) ) {
            $this->db->where( 'admission_date <=', date( 'Y-m-d', strtotime( $date_to ) ) );
        }

        if ( $withdrawn !== null ) {
            $this->db->where( 'student_status', 'inactive' );
        }

        $q = $this->db->get();

        return $q->result_array();
    }
}