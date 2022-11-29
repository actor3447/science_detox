<?php
/**
 * Created by PhpStorm.
 * User: PDH
 * Date: 2022-09-15
 * Time: 오전 12:29
 */

class M_mypage extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    function selectLikeContentsCount($idx){
        $this->db->where('user_idx', $idx);
        return $this->db->get('contents_like')->num_rows();
    }

    function selectLikeContentsList($user_idx){
        if ($this->data['page'] == 1 || $this->data['page'] < 0) {
            $this->offset = 0;
        } else {
            $this->offset = $this->data['size'] * ($this->data['page'] - 1);
        }
        $this->limit  = $this->data['size'];
        $this->db->select('t.*');
        $this->db->join('contents t', 't.idx = c.contents_idx', 'left');
        $this->db->where('c.user_idx', $user_idx);
        return $this->db->get('contents_like c', $this->limit , $this->offset)->result_array();
    }

    function selectBookmarkCount($idx){
        $this->db->where('user_idx', $idx);
        return $this->db->get('contents_bookmark')->num_rows();
    }

    function selectBookmarkList($user_idx){
        if ($this->data['page'] == 1 || $this->data['page'] < 0) {
            $this->offset = 0;
        } else {
            $this->offset = $this->data['size'] * ($this->data['page'] - 1);
        }
        $this->limit  = $this->data['size'];
        $this->db->select('t.*');
        $this->db->join('contents t', 't.idx = c.contents_idx', 'left');
        $this->db->where('c.user_idx', $user_idx);
        return $this->db->get('contents_bookmark c', $this->limit , $this->offset)->result_array();
    }

    function selectMentoQnaCount($idx){
        $this->db->where('user_idx', $idx);
        return $this->db->get('mento_question')->num_rows();
    }

    function selectMentoQnaList($user_idx){
        if ($this->data['page'] == 1 || $this->data['page'] < 0) {
            $this->offset = 0;
        } else {
            $this->offset = $this->data['size'] * ($this->data['page'] - 1);
        }
        $this->limit  = $this->data['size'];
        $this->db->select('m.*, d.title as title');
        $this->db->join('debate_category d', 'd.idx = m.category_idx', 'left');
        $this->db->where('m.user_idx', $user_idx);
        return $this->db->get('mento_question m', $this->limit , $this->offset)->result_array();
    }

    function selectUserOne($idx){
        $this->db->where('idx', $idx);
        return $this->db->get('user')->row_array();
    }

    function updateUser($user_idx, $data){
        $this->db->where('idx', $user_idx);
        return $this->db->update('user', $data);
    }

    function selectDebateRoomCount($user_idx){
        $this->db->where('user_idx', $user_idx);
        $this->db->group_by("debate_room_idx");
        return $this->db->get('debate_room_connect')->num_rows();
    }

    function selectDebateRoomList($user_idx){
        if ($this->data['page'] == 1 || $this->data['page'] < 0) {
            $this->offset = 0;
        } else {
            $this->offset = $this->data['size'] * ($this->data['page'] - 1);
        }
        $this->limit  = $this->data['size'];
        $this->db->select('r.idx, r.title, c.title as category, r.img_path, r.reg_date, r.open_yn');
        $this->db->join('debate_message m', 'r.idx = m.debate_room_idx and m.user_idx='. $user_idx);
        $this->db->join('debate_category c', 'c.idx = r.debate_category_idx');
        $this->db->group_by('m.debate_room_idx');
        $this->db->order_by('r.idx asc');
        return $this->db->get('debate_room r', $this->limit , $this->offset)->result_array();
    }
}