<?php

class M_innosociallab extends CI_Model{
    public function __construct(){
        parent::__construct();

    }

    function selectInternshipList(){
        $this->db->where('season', $this->data['season']);
        $this->db->where("status", 'Y');
        $this->db->order_by('idx desc');
        return $this->db->get('internship')->result_array();
    }

    function selectInternshipOne($idx){
        $this->db->where("idx", $idx);
        return $this->db->get('internship')->row_array();
    }

    function insertInternship($data){
        return $this->db->insert('internship', $data);
    }

    function updateInternship($data , $idx){
        $this->db->where("idx", $idx);
        return $this->db->update('internship', $data);
    }

}