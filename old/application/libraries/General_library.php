<?php

class General_library
{

    public $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
    }

    public function show_error_or_msg()
    {
        $error = $this->ci->session->flashdata( 'error' );
        $msg = $this->ci->session->flashdata( 'msg' );
        if ( $error ) {
            echo "<div class='alert alert-danger'>{$error}</div>";
        }

        if ( $msg ) {
            echo "<div class='alert alert-success'>{$msg}</div>";
        }
    }

    /**
     * Validates and format phone numbers
     * @param array $mobile_numbers
     * @return string
     */
    public function validate_mobile_numbers( $mobile_numbers )
    {
        $numbers = array();

        for ( $i = 0; $i < count( $mobile_numbers ); $i++ ) {
            $nmb = substr( $mobile_numbers[$i], -10 );
            $nmb = "92" . $nmb;

            if ( strlen( $nmb ) == 12 ) {
                $numbers[] = $nmb;
            }
        }

        return $numbers;
    }

    /**
     * Gets all the phone numbers of the parents
     * @return array Returns array of Father's numbers.
     * @throws Exception if no number is found.
     */
    public function get_all_phone_numbers()
    {

        $mobile_nos = $this->ci->general_model->get_data_query( "SELECT `father_mobile` FROM `student_registration` WHERE `father_mobile` != ''" );

        if ( $mobile_nos === false ) {
            throw new Exception( "No phone number found!" );
        } else {

            $ph_arr = array();
            foreach ( $mobile_nos as $no ) {
                $ph_arr[] = $no['father_mobile'];
            }

            return $ph_arr;

        }

    }

    public function send_sms( $mobile_numbers, $message )
    {
        $url = "http://cbs.zong.com.pk/ReachCWSv2/CorporateSMS.svc?wsdl";

        $client = new SoapClient( $url, array('trace' => 1, 'exception' => 0) );

        // validate all the mobile numbers
        $mobile_numbers = $this->validate_mobile_numbers( $mobile_numbers );

        // generating dynamic list array to store arrays of numbers and variables
        $dynamicList = array();

        // looping through all the numbers and adding them to the dynamic list array
        // These numbers will be sent messages.
        foreach ( $mobile_numbers as $nmb ) {
            $dynamicList[] = array(
                'Number' => $nmb,
                'Var1' => '',
                'Var2' => '',
                'Var3' => '',
                'Var4' => '',
                'Var5' => ''
            );
        }

        $dynamicSMS = $client->DynamicSMS( array(
            'obj_DynamicSMS' => array(
                'loginId' => '923168882257',
                'loginPassword' => 'prime1329',
                'Mask' => 'PrimeSchool',
                'Message' => $message,
                'lstNL' => array(
                    'DynamicList' => $dynamicList
                ),
                'CampaignDate' => date( 'm/d/Y h:i:s a', ( now() + ( 10 * 60 ) ) ), // schedule for sending 5 mins later from now
                'ShortCodePrefered' => 'n'
            )
        ) );

        if ( strpos( $dynamicSMS->DynamicSMSResult, "Message Submitted Successfully" ) === false ) {
            return false;
        } else {
            return true;
        }
    }

    public function send_sms_old( $mobile_numbers, $message )
    {
        $username = "923137544811";
        $password = "2763";
        $sender = "PrimeFoundation";
        $url = "http://sendpk.com/api/sms.php?username=" . $username . "&password=" . $password . "&mobile=" . $mobile_numbers . "&sender=" . urlencode( $sender ) . "&format=json&message=" . urlencode( $message );

        $ch = curl_init();
        $timeout = 30;
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
        $responce = curl_exec( $ch );
        curl_close( $ch );

        $json = json_decode( $responce, true );

        if ( $json['success'] == true ) {
            $return_value = true;

            foreach ( $json['results'] as $rslt ) {
                if ( $rslt['status'] != "OK" ) {
                    $return_value = false;
                }
            }

            return $return_value;
        } else {
            return false;
        }
    }

    /**
     * Redirect user with message set in session
     * @param string $url to which the browser should be redirected.
     * @param int $message_type 0 for error, 1 for msg.
     * @param string $message Message that should be shown
     */
    public function redirect( $url, $message_type = 0, $message = "" )
    {

        if ( !empty( $message ) ) {
            $message_type = ( $message_type === 0 ? 'error' : 'msg' );

            $this->ci->session->set_flashdata( $message_type, $message );
        }

        redirect( $url );
    }

    public function redirect_url( $fallback )
    {

        $redirect = $this->ci->input->get( 'redirect' );

        $redirect_url = ( !empty( $redirect ) ? urldecode( $redirect ) : site_url( $fallback ) );

        return $redirect_url;

    }

    public function current_url( $with_query_params = true )
    {

        $current_url = current_url();

        if ( $with_query_params === true ) {

            $query_str = $_SERVER['QUERY_STRING'];

            if ( !empty( $query_str ) ) {
                $current_url .= "?" . $query_str;
            }

        }

        return $current_url;

    }

}
