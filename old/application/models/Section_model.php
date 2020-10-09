<?php

class Section_model extends CI_Model
{
    public $table_name = "section";
    public $id = "id";

    public function get( $id = null, $name = null )
    {
        $this->db->from( $this->table_name );

        if ( $id !== null ) {
            $this->db->where( $this->id, $id );
        }

        if ( $name !== null ) {
            $this->db->where( 'name', $name );
        }

        $this->db->order_by( 'name', 'asc' );
        $q = $this->db->get();

        if ( $id !== null || $name !== null ) {
            return $q->row_array();
        } else {
            return $q->result_array();
        }
    }
}