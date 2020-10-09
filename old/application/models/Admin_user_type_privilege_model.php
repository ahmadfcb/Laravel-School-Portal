<?php

class Admin_user_type_privilege_model extends CI_Model
{

    public function get( $user_type = null, $can_access = null )
    {

        $this->db->from( 'admin_user_types' )
            ->join( 'admin_user_type_privilege', 'admin_user_type_privilege.admin_user_type_id = admin_user_types.admin_user_type_id', 'inner' );

        if ( $user_type !== null ) {
            $this->db->where( 'admin_user_types.user_type_name', $user_type );
        }

        if ( $can_access !== null ) {
            $this->db->where( 'admin_user_type_privilege.can_access', $can_access );
        }

        $q = $this->db->get();

        if ( $q->num_rows() > 0 ) {

            if ( $can_access !== null ) {
                return $q->row_array();
            } else {
                return $q->result_array();
            }

        } else {
            return false;
        }

    }

    public function filter_privileges( $can_access, $all_accessible_array )
    {
        $rtn_value = false;

        foreach ( $all_accessible_array as $all_accessible_array_value ) {
            if ( is_string( $can_access ) ) {
                if ( $can_access == $all_accessible_array_value['can_access'] ) {
                    $rtn_value = true;
                }
            } else if ( is_array( $can_access ) ) {
                foreach ($can_access as $can_access_value){
                    if($can_access_value == $all_accessible_array_value['can_access']){
                        $rtn_value = true;
                        // breaking this internal loop
                        break;
                    }
                }
            }

            if($rtn_value === true){
                // breaking the outer loop
                break;
            }
        }

        return $rtn_value;

    }

}