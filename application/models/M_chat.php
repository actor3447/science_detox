<?php
/**
 * Created by PhpStorm.
 * User: PDH
 * Date: 2022-09-05
 * Time: 오후 5:45
 */

class M_chat extends CI_Model{
    public function __construct(){
        parent::__construct();
    }

    function selectQuestionList(){
        $this->db->order_by('sort', 'asc');
        return $this->db->get('question')->result_array();
    }

    function selectMentoCount(){
        $this->db->where('mento_yn', 'Y');
        return $this->db->get('member')->num_rows();
    }

    function selectMentoList(){
        if ($this->data['page'] == 1 || $this->data['page'] < 0) {
            $this->offset = 0;
        } else {
            $this->offset = $this->data['size'] * ($this->data['page'] - 1);
        }
        $this->limit  = $this->data['size'];
        $this->db->select('m.*, c.name as category_name');
        $this->db->join('category c', 'c.idx = m.category_idx');
        $this->db->where('m.mento_yn', 'Y');
        return $this->db->get('member m', $this->limit , $this->offset)->result_array();
    }

    function selectMobileMentoList(){
        $this->db->select('m.*, d.name as title');
        $this->db->join('category d', 'd.idx = m.category_idx');
        $this->db->where('m.mento_yn', 'Y');
        return $this->db->get('member m')->result_array();
    }

    function selectMentoOne($mento_idx){
        $this->db->select('m.*, d.name as title');
        $this->db->join('category d', 'd.idx = m.category_idx');
        $this->db->where('m.idx', $mento_idx);
        $this->db->where('m.mento_yn', 'Y');
        return $this->db->get('member m')->row_array();
    }

}