<?php
/**
 * Created by PhpStorm.
 * User: PDH
 * Date: 2022-09-05
 * Time: 오후 5:45
 */

class M_chatserver extends CI_Model{
    public function __construct(){
        parent::__construct();
    }


    function selectDebateRoomConnectOne($user_idx, $room_idx){

        $this->db->where('user_idx', $user_idx);
        $this->db->where('debate_room_idx', $room_idx);
        return $this->db->get('debate_room_connect')->row_array();

    }

    function insertDebateRoomConnect($data){
        return $this->db->insert('debate_room_connect', $data);
    }

    function updateDebateRoomConnect($data, $user_idx, $room_idx){
        $this->db->where('user_idx', $user_idx);
        $this->db->where('debate_room_idx', $room_idx);
        return $this->db->update('debate_room_connect', $data);
    }

    function selectDebateRoomConnectCheckTime($time){

        $this->db->where('reg_date <', $time);
        return $this->db->get('debate_room_connect')->result_array();
    }


    function deleteDebateRoomConnect($idx){

        $this->db->where('idx', $idx);
        return $this->db->delete('debate_room_connect');
    }

}