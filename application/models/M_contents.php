<?php
/**
 * Created by PhpStorm.
 * User: PDH
 * Date: 2022-09-18
 * Time: 오전 12:49
 */

class M_contents extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    function selectContentsCount(){
        return $this->db->get('contents')->num_rows();
    }

    function selectContentsList(){
        if ($this->data['page'] == 1 || $this->data['page'] < 0) {
            $this->offset = 0;
        } else {
            $this->offset = $this->data['size'] * ($this->data['page'] - 1);
        }

        $this->limit  = $this->data['size'];

        if($this->data['search_text'] != ''){
            $this->db->like('title', $this->data['search_text']);
        }

        if($this->data['search_field'] != ''){
            if($this->data['search_field'] == 'content'){
                $this->db->where('type', 'content');
            }

            if($this->data['search_field'] == 'youtube') {
                $this->db->where('type', 'youtube');
            }

            if($this->data['search_field'] == 'last_order') {
                $this->db->order_by('reg_date', 'desc');
            }
        }

        return $this->db->get('contents', $this->limit , $this->offset)->result_array();
    }

    function selectContentsCurationHashTagList(){
        return $this->db->get('contents_curation')->result_array();
    }

    function selectContentsHashTagList($hash_tag_arr){
        if ($this->data['page'] == 1 || $this->data['page'] < 0) {
            $this->offset = 0;
        } else {
            $this->offset = $this->data['size'] * ($this->data['page'] - 1);
        }

        $this->limit  = $this->data['size'];
        $this->db->select('c.*');
        $this->db->where_in('h.hash_tag', $hash_tag_arr);
        $this->db->join('contents c', 'c.idx = h.contents_idx', 'right');
        $this->db->group_by('h.contents_idx');
        return $this->db->get('contents_hash_tag h', $this->limit , $this->offset)->result_array();
    }


}