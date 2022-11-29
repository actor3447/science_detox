<?php


class M_api extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function selectDebateCategory(){

        return $this->db->get('debate_category')->result_array();
    }

    function selectContentsOne($idx){
        $this->db->where('idx', $idx);
        return $this->db->get('contents')->row_array();
    }



    function selectDebateRoomOne($room_idx){
        $this->db->select('r.*, c.title as category_title, count(l.idx) as like_cnt, count(b.idx) as bookmark_cnt');
        $this->db->where('r.idx', $room_idx);
        $this->db->join('debate_category c', 'c.idx = r.debate_category_idx' ,'left');
        $this->db->join('debate_room_like l', 'l.debate_room_idx = r.idx' ,'left');
        $this->db->join('debate_room_bookmark b', 'b.debate_room_idx = r.idx' ,'left');
        return $this->db->get('debate_room r')->row_array();
    }

    function selectDebateRoomConnect($room_idx){
        $this->db->where('debate_room_idx', $room_idx);
        return $this->db->get('debate_room_connect')->result_array();
    }



    function insertDebateRoomConnect($data){
        return $this->db->insert('debate_room_connect', $data);
    }

    function selectDebateRoomConnectByUser($room_idx, $user_idx){
        $this->db->where('debate_room_idx', $room_idx);
        $this->db->where('user_idx', $user_idx);
        return $this->db->get('debate_room_connect')->row_array();
    }

    function deleteDebateRoomConnect($room_idx, $user_idx){
        $this->db->where('debate_room_idx', $room_idx);
        $this->db->where('user_idx', $user_idx);
        return $this->db->delete('debate_room_connect');
    }

    function selectDebateRoomCount($category){

        $this->db->select('idx');
        $this->db->where('debate_category_idx', $category);
        $this->db->from('debate_room');
        return $this->db->count_all_results();
    }

    function selectDebateRoomList($category= ''){
        $this->db->select('r.* , ( SELECT count(idx) FROM debate_room_like WHERE debate_room_idx=r.idx) as like_cnt , ( SELECT count(idx) FROM debate_room_bookmark WHERE debate_room_idx=r.idx) as bookmark_cnt');

        if ($this->data['page'] == 1 || $this->data['page'] < 0) {
            $this->offset = 0;
        } else {
            $this->offset = $this->data['size'] * ($this->data['page'] - 1);
        }

        $this->limit  = $this->data['size'];

        $this->db->where('r.debate_category_idx', $category);
        $this->db->order_by('r.idx desc');
        return $this->db->get('debate_room r', $this->limit , $this->offset)->result_array();
    }


    function selectDebateRoomHashtag($dabate_idx){
        $this->db->where('debate_room_idx', $dabate_idx);
        return $this->db->get('debate_room_hash_tag')->result_array();
    }




}