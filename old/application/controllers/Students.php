<?php

class Students extends CI_Controller
{
    public function new_students()
    {
        $title = "New students";

        $this->form_validation->set_data( $_GET );
        $this->form_validation->set_rules( 'branch', 'Branch', 'trim' );
        $this->form_validation->set_rules( 'class', 'Class', 'trim' );
        $this->form_validation->set_rules( 'section', 'Section', 'trim' );
        $this->form_validation->set_rules( 'date_from', 'Date from', 'trim' );
        $this->form_validation->set_rules( 'date_to', 'Date to', 'trim' );
        $this->form_validation->set_rules( 'withdrawn', 'Withdrawn', 'trim' );
        $this->form_validation->run();

        $branch = $this->input->get( 'branch' );
        $class = $this->input->get( 'class' );
        $section = $this->input->get( 'section' );

        $withdrawn = $this->input->get( 'withdrawn' );
        $withdrawn = ( !empty( $withdrawn ) ? $withdrawn : null );

        $date_from = $this->input->get( 'date_from' );
        $date_from = ( $date_from !== null ? date( 'Y-m-d', strtotime( $date_from ) ) : date( 'Y-m-d', now() ) );

        $date_to = $this->input->get( 'date_to' );
        $date_to = ( $date_to !== null ? date( 'Y-m-d', strtotime( $date_to ) ) : date( 'Y-m-d', now() ) );

        $total = new stdClass();
        $total->male = 0;
        $total->female = 0;
        $students = $this->student_model->new_students( $branch, $class, $section, $date_from, $date_to, $withdrawn );
        foreach ( $students as $student ) {
            if ( $student['gender'] == 'male' ) {
                $total->male++;
            } else if ( $student['gender'] == 'female' ) {
                $total->female++;
            }
        }

        $data = compact(
            'title',
            'students',
            'total'
        );
        $this->load->view( 'students/new_students_view', $data );
    }
}