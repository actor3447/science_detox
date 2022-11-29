<?php
/**
 * Created by PhpStorm.
 * User: PDH
 * Date: 2022-09-04
 * Time: 오전 2:57
 */

class M_Qchat extends CI_Model{
    public function __construct(){
        parent::__construct();
    }

    function selectChatbotTotalCount(){
        $this->db->join('member m', 'c.reg_user_idx = m.idx');
        return $this->db->get('chatbot c')->num_rows();
    }

    function selectChatbotList(){
        $this->db->select('c.*, m.name');
        $this->db->order_by('c.idx', 'desc');
        $this->db->join('member m', 'c.reg_user_idx = m.idx');
        return $this->db->get('chatbot c')->result_array();
    }

    function selectChatbotOne($idx){
        $this->db->where('idx', $idx);
        return $this->db->get('chatbot')->row_array();
    }

    function insertChatbot($data){
        return $this->db->insert('chatbot', $data);
    }

    function updateChatbot($idx, $data){
        $this->db->where('idx', $idx);
        return $this->db->update('chatbot', $data);
    }

    function selectQuestionTotalCount(){
        return $this->db->get('question')->num_rows();
    }

    function selectQuestionList(){
        $this->db->order_by('idx', 'desc');
        return $this->db->get('question')->result_array();
    }

    function selectQuestionOne($idx){
        $this->db->where('idx', $idx);
        return $this->db->get('question')->row_array();
    }

    function insertQuestion($data){
        return $this->db->insert('question', $data);
    }

    function updateQuestion($idx, $data){
        $this->db->where('idx', $idx);
        return $this->db->update('question', $data);
    }

    function deleteChatbot($idx, $table){
        $this->db->where('idx', $idx);
        return $this->db->delete($table);
    }

    function selectMentoTotalCount(){
        if( $this->data['search_name'] != '' ){
            $this->db->where('name', $this->data['search_name']);
        }
        $this->db->where('mento_yn', 'Y');
        return $this->db->get('member')->num_rows();
    }

    function selectMentoList(){
        if ($this->data['page'] == 1 || $this->data['page'] < 0) {
            $this->offset = 0;
        } else {
            $this->offset = $this->data['size'] * ($this->data['page'] - 1);
        }
        if( $this->data['search_name'] != '' ){
            $this->db->where('name', $this->data['search_name']);
        }
        $this->limit  = $this->data['size'];
        $this->db->where('mento_yn', 'Y');
        return $this->db->get('member', $this->limit , $this->offset)->result_array();
    }

    function selectQnaCnt($idx){
        $this->db->where('mento_idx', $idx);
        $this->db->where('request_yn', 'N');
        return $this->db->get('mento_question')->num_rows();
    }

    function selectMentoQnaTotalCount($idx, $title){
        if ($this->data['page'] == 1 || $this->data['page'] < 0) {
            $this->offset = 0;
        } else {
            $this->offset = $this->data['size'] * ($this->data['page'] - 1);
        }
        if( $title != '' ){
            $this->db->like('title', $title);
        }
        $this->db->where('mento_idx', $idx);
        return $this->db->get('mento_question')->num_rows();
    }

    function selectMentoQnaList($idx, $title){
        if ($this->data['page'] == 1 || $this->data['page'] < 0) {
            $this->offset = 0;
        } else {
            $this->offset = $this->data['size'] * ($this->data['page'] - 1);
        }
        $this->db->select('m.*, u.name as user_name');
        $this->db->join('user u', 'm.user_idx = u.idx', 'left');
        if( $title != '' ){
            $this->db->like('m.title', $title);
        }
        $this->limit  = $this->data['size'];
        $this->db->where('m.mento_idx', $idx);
        $this->db->order_by('m.idx', 'desc');
        return $this->db->get('mento_question m', $this->limit , $this->offset)->result_array();
    }

    function selectQnaContent(){
        $this->db->where('idx', $this->data['idx']);
        return $this->db->get('mento_question')->row_array();
    }

    function updateMentoQna($idx, $data){
        $this->db->where('idx', $idx);
        return $this->db->update('mento_question', $data);
    }

    function deleteMentoQna($idx, $table){
        $this->db->where('idx', $idx);
        return $this->db->delete($table);
    }

}