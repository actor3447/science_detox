<?php
class M_common extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function selectUserOne($user_id){
        $this->db->where('id', $user_id);
        return $this->db->get('user')->row_array();
    }

    function insertUser($data){
        $this->db->insert('user', $data);
    }

    function updateUser($user_id, $data){
        $this->db->where('id', $user_id);
        $this->db->update('user', $data);
    }

    function selectUserCnt($user_id){
        $this->db->where('id', $user_id);
        return $this->db->get('user')->num_rows();
    }
}