<?php

class M_login extends CI_Model{
    public function __construct(){
        parent::__construct();

    }

    function selectAdmin($data){
        $this->db->where('BINARY(id)', $data['id']);
        $this->db->where('BINARY(passwd)', $data['pwd']);
        return $this->db->get('member')->row_array();
    }
}