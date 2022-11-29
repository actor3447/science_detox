<?php
/**
 * Created by PhpStorm.
 * User: PDH
 * Date: 2022-09-07
 * Time: 오후 4:38
 */

class M_member extends CI_Model{
    public function __construct(){
        parent::__construct();
    }

    function insertMember($data){
        return $this->db->insert('member', $data);
    }

    function updateMember($idx, $data){
        $this->db->where('idx', $idx);
        return $this->db->update('member', $data);
    }

    function selectMember(){
        $this->db->order_by('idx', 'desc');
        return $this->db->get('member')->result_array();
    }

    function selectMemberCnt(){
        return $this->db->get('member')->num_rows();
    }

    function selectMemberOne(){
        $this->db->where('idx', $this->data['idx']);
        return $this->db->get('member')->row_array();
    }


    function selectUserCnt(){
        return $this->db->get('user')->num_rows();
    }

    function selectUserList(){
        $this->db->order_by('idx', 'desc');
        return $this->db->get('user')->result_array();
    }

    function selectCategory(){
        return $this->db->get('category')->result_array();
    }

}