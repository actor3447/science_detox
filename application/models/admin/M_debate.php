<?php


class M_debate extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function selectDebateCount(){

        return $this->db->get('debate_room d')->num_rows();
    }

    function selectDebateList(){
        $this->db->select('d.*, u.name as user_name, c.title as category_title');
        $this->db->join('user u', 'u.idx = d.owner_idx' ,'left');
        $this->db->join('debate_category c', 'c.idx = d.debate_category_idx' ,'left');
//        $this->db->where('debate_room_idx');
        return $this->db->get('debate_room d')->result_array();
    }



    function selectDebateMessageCount($idx){

        $this->db->where('debate_room_idx', $idx);
        return $this->db->get('debate_message')->num_rows();

    }

    function selectDebateMessageList($idx){
        $this->db->where('d.debate_room_idx', $idx);
        $this->db->join('user u', 'u.idx = d.user_idx' ,'left');
        return $this->db->get('debate_message d')->result_array();
    }

    function deleteAdminDebateRoom($debate_idx){
        $this->db->where('idx', $debate_idx);
        $this->db->delete('debate_room');
    }

    function deleteAdminDebateRoomBookmark($debate_idx){
        $this->db->where('debate_room_idx', $debate_idx);
        $this->db->delete('debate_room_bookmark');
    }

    function deleteAdminDebateRoomConnect($debate_idx){
        $this->db->where('debate_room_idx', $debate_idx);
        $this->db->delete('debate_room_connect');
    }

    function deleteAdminDebateRoomHashTag($debate_idx){
        $this->db->where('debate_room_idx', $debate_idx);
        $this->db->delete('debate_room_hash_tag');
    }

    function deleteAdminDebateRoomLike($debate_idx){
        $this->db->where('debate_room_idx', $debate_idx);
        $this->db->delete('debate_room_like');
    }
}