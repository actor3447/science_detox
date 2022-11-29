<?php


class M_debate extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    function insertDebateRoom($data){

        $this->db->insert('debate_room', $data);
        $idx = $this->db->insert_id();
        return  $idx;
    }

    function insertDebateRoomHashTag($data){
        return  $this->db->insert('debate_room_hash_tag', $data);
    }



    function insertDebateMessage($data){
        return  $this->db->insert('debate_message', $data);
    }

    function insertDebateRoomConnect($data){
        return  $this->db->insert('debate_room_connect', $data);
    }

    function deleteDebateRoomConnect($user_idx, $room_idx){
        $this->db->where('user_idx', $user_idx);
        $this->db->where('debate_room_idx', $room_idx);
        return  $this->db->delete('debate_room_connect');
    }

    function selectDebateRoomConnectExcepMe($room_idx, $user_idx){
        $this->db->where('debate_room_idx', $room_idx);
        $this->db->where_not_in('user_idx', $user_idx);
        return $this->db->get('debate_room_connect')->result_array();
    }

    function selectDebateRoomConnectCount($room_idx){
        $this->db->where('debate_room_idx', $room_idx);
        $this->db->from('debate_room_connect');
        return $this->db->count_all_results();
    }

    function selectDebateRoomLike($room_idx, $user_idx){
        $this->db->where('debate_room_idx', $room_idx);
        $this->db->where('user_idx', $user_idx);
        $this->db->from('debate_room_like');
        return $this->db->count_all_results();
    }

    function selectDebateRoomBookmark($room_idx, $user_idx){
        $this->db->where('debate_room_idx', $room_idx);
        $this->db->where('user_idx', $user_idx);
        $this->db->from('debate_room_bookmark');
        return $this->db->count_all_results();
    }



    function deleteDebateRoomLike($room_idx, $user_idx){
        $this->db->where('user_idx', $user_idx);
        $this->db->where('debate_room_idx', $room_idx);
        return  $this->db->delete('debate_room_like');
    }

    function deleteDebateRoomBookmark($room_idx, $user_idx){
        $this->db->where('user_idx', $user_idx);
        $this->db->where('debate_room_idx', $room_idx);
        return  $this->db->delete('debate_room_bookmark');
    }


    function insertDebateRoomLike($data){
        return  $this->db->insert('debate_room_like', $data);
    }

    function insertDebateRoomBookmark($data){
        return  $this->db->insert('debate_room_bookmark', $data);
    }

    function selectDebateRoomConnect($room_idx){
        $this->db->select('u.name, r.user_idx');
        $this->db->join('user u', 'r.user_idx = u.idx' ,'left');
        $this->db->where('r.debate_room_idx', $room_idx);
        $this->db->order_by('r.idx asc');
        return $this->db->get('debate_room_connect r')->result_array();
    }

    function selectDebateMessageList($room_idx){
        $this->db->select('u.name, m.user_idx, m.type, m.message, m.duration, DATE_FORMAT(m.reg_date, "%Y-%m-%d %H:%i:%s") as reg_date');
        $this->db->join('user u', 'm.user_idx = u.idx' ,'left');
        $this->db->where('m.debate_room_idx', $room_idx);
        $this->db->order_by('m.idx asc');
        return $this->db->get('debate_message m')->result_array();

    }

    function updateDebateRoom($data , $room_idx){
        $this->db->where('idx', $room_idx);
        return $this->db->update('debate_room', $data);
    }


    function selectMyDebate($user_idx){

        $this->db->select('r.idx , r.title, c.title as category');
        $this->db->join('debate_message m', 'r.idx = m.debate_room_idx and m.user_idx='. $user_idx);
        $this->db->join('debate_category c', 'c.idx = r.debate_category_idx');
        $this->db->group_by('m.debate_room_idx');
        $this->db->order_by('r.idx asc');
        return $this->db->get('debate_room r')->result_array();

    }

    function selectUserName($user_idx){
        $this->db->select('name');
        $this->db->where('idx', $user_idx);
        return $this->db->get('user')->row_array();
    }

    function selectDebateMessage($room_idx){

        $this->db->where('debate_room_idx', $room_idx);
        $this->db->order_by('idx asc');
        return $this->db->get('debate_message')->result_array();
    }


    function selectDebateHasgTag($room_idx){
        $this->db->where('debate_room_idx', $room_idx);
        return $this->db->get('debate_room_hash_tag')->result_array();
    }

    function selectContents($hash_tag){
        $this->db->select('DISTINCT(c.idx) as idx , c.title, c.img_info');
        $this->db->join('contents c', 'c.idx = h.contents_idx');
        $this->db->where('LOWER(h.hash_tag) REGEXP ', "'" . $hash_tag . "'", false);
        $this->db->order_by(' rand() limit 3');
        return $this->db->get('contents_hash_tag h')->result_array();
    }


    function selectContentsRandom($cnt, $idx){

        $this->db->select('c.title, c.idx, c.img_info');
        if ($idx != ''){
            $this->db->where_not_in('c.idx', $idx, false);
        }
        $this->db->order_by(' rand() limit '. $cnt);
        return $this->db->get('contents c')->result_array();
    }
}