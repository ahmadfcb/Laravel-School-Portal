<?php

class Admin_user_model extends CI_Model
{
    public function get( $id = null )
    {
        $this->db->select( '*' )
            ->from( 'admin_users' )
            ->order_by( 'admin_name', 'asc' );

        if ( $id !== null ) {
            $this->db->where( 'admin_users_id', $id );
        }

        $q = $this->db->get();

        if ( $q->num_rows() > 0 ) {
            if ( $id !== null ) {
                return $q->row_array();
            } else {
                return $q->result_array();
            }
        } else {
            return false;
        }
    }
}