<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Home extends CI_Controller {

    public function index() {
        $news = $this->general_model->get_data("*", "news", null, 5, 'news_id', 'DESC');
        
        $this->load->view( 'home/index_view', array(
            'news' => $news
        ) );
    }

    public function contact() {

        $this->form_validation->set_rules( 'name', 'Name', 'trim|required' );
        $this->form_validation->set_rules( 'email', 'Email', 'trim|required|valid_email' );
        $this->form_validation->set_rules( 'subject', 'Subject', 'trim|required' );
        $this->form_validation->set_rules( 'message', 'Message', 'trim|required' );

        if ( $this->form_validation->run() == false ) {

            $data = array( 'emailTitle' => "Email not sent!", 'emailMsg' => "Some information is missing or wrong, that's why we could not send your email. Kindly fill all the information correctly and try again." );
        } else {

            $name = $this->input->post( 'name' );
            $email = $this->input->post( 'email' );
            $subject = $this->input->post( 'subject' );
            $message = $this->input->post( 'message' );

            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.zoho.com',
                'smtp_port' => 465,
                'smtp_user' => 'info@pfseline.com',
                'smtp_pass' => '3K3a89IvN',
                'mailtype' => 'text',
                'charset' => 'utf-8'
            );
            $this->load->library( 'email', $config );

            $this->email->from( "info@pfseline.com", $name );
            $this->email->to( 'info@pfseline.com' );
            $this->email->reply_to( $email, $name );
            $this->email->subject( $subject );
            $this->email->message( $message );
            $this->email->set_newline( "\r\n" );


            if ( $this->email->send() ) {

                $data = array( 'emailTitle' => "Email sent!", 'emailMsg' => "Email has been sent successfully! We'll get back to you as soon as possible" );
            } else {

                $data = array( 'emailTitle' => "Email not sent!", 'emailMsg' => "Something went wrong. Please try again later." );
            }


            $this->load->view( 'home/contact_view', $data );
        }
    }

    public function news( $page_number = 0 ) {
        $config = array(
            'base_url' => site_url( 'home/news' ),
            'total_rows' => $this->db->count_all( 'news' ),
            'per_page' => 3
        );

        $this->pagination->initialize( $config );
        
        $page_number = intval($page_number);
        // if page number is less than 0 or greater than max records
        if($page_number < 0 || $page_number > $config['total_rows']){
            $this->session->set_flashdata('error', 'You were trying to access link that is not available.');
            redirect('home/news');
        }

        $news = $this->general_model->get_data_query( "SELECT * FROM `news` ORDER BY `added_time` DESC LIMIT ?, ?", array($page_number, $config['per_page']) );

        $this->load->view( 'home/news_view', array( 'title' => 'News', 'news' => $news, 'page_entity' => 'news' ) );
    }
    
    public function events( $page_number = 0 ) {
        $config = array(
            'base_url' => site_url( 'home/events' ),
            'total_rows' => $this->db->count_all( 'events' ),
            'per_page' => 3
        );

        $this->pagination->initialize( $config );
        
        $page_number = intval($page_number);
        // if page number is less than 0 or greater than max records
        if($page_number < 0 || $page_number > $config['total_rows']){
            $this->session->set_flashdata('error', 'You were trying to access link that is not available.');
            redirect('home/events');
        }

        $news = $this->general_model->get_data_query( "SELECT `id` AS news_id, `event_name` AS title, `event_description` AS description, `event_media` AS image, `added_time` FROM `events` ORDER BY `added_time` DESC LIMIT ?, ?", array($page_number, $config['per_page']) );

        $this->load->view( 'home/news_view', array( 'title' => 'News', 'news' => $news, 'page_entity' => 'events' ) );
    }

    public function blank_page()
    {
        $data = array(
            'body_options' => 'onafterprint="self.close()"'
        );
        $this->load->view('templates/blank_page_header', $data);
        $this->load->view('templates/blank_page_footer', $data);
    }

}
