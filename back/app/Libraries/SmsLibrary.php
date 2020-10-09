<?php

namespace App\Libraries;


class SmsLibrary
{
    /**
     * Validates and format phone numbers
     * @param string|array $mobile_numbers
     * @return array
     */
    public static function validate_mobile_numbers( $mobile_numbers )
    {
        if ( !is_array( $mobile_numbers ) ) {
            $mobile_numbers = [$mobile_numbers];
        }

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
     * @param string|array $mobile_numbers
     * @param string $message
     * @return array ['status', 'msg']
     */
    public static function send_sms( $mobile_numbers, $message )
    {
        $url = "http://cbs.zong.com.pk/ReachCWSv2/CorporateSMS.svc?wsdl";

        $client = new \SoapClient( $url, array('trace' => 1, 'exception' => 0) );

        // validate all the mobile numbers
        $mobile_numbers = self::validate_mobile_numbers( $mobile_numbers );

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
                'loginPassword' => '123',
                'Mask' => 'PrimeSchool',
                'Message' => $message,
                'lstNL' => array(
                    'DynamicList' => $dynamicList
                ),
                'CampaignDate' => now()->addMinutes( 5 )->format( 'm/d/Y h:i:s a' ), // schedule for sending 5 mins later from now
                'ShortCodePrefered' => 'n'
            )
        ) );

        if ( strpos( $dynamicSMS->DynamicSMSResult, "Message Submitted Successfully" ) === false ) {
            return [
                'status' => false,
                'msg' => $dynamicSMS->DynamicSMSResult
            ];
        } else {
            return [
                'status' => true,
                'msg' => $dynamicSMS->DynamicSMSResult
            ];
        }
    }
}