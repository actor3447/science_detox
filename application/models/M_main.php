<?php


class M_main extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function selectContentsLike($user_idx){
        $this->db->where('user_idx', $user_idx);
        return $this->db->get('contents_like')->result_array();
    }


    function selectContentsHashTag($idx){
        $this->db->select('hash_tag');
        $this->db->where('contents_idx', $idx);
        return $this->db->get('contents_hash_tag')->result_array();
    }


    function selectContents($hash_tag, $list_cnt){
        $this->db->select('DISTINCT(c.idx) as idx, c.*');
        $this->db->join('contents c', 'c.idx = h.contents_idx');
        $this->db->where('LOWER(h.hash_tag) REGEXP ', "'" . $hash_tag . "'", false);
        $this->db->order_by(' rand() limit '. $list_cnt);
        return $this->db->get('contents_hash_tag h')->result_array();
    }


    function selectContentsRandom($cnt, $idx){
        $this->db->select('DISTINCT(c.idx) as idx , c.*');
        $this->db->where_not_in('c.idx', $idx, false);
        $this->db->order_by(' rand() limit '. $cnt);
        return $this->db->get('contents c')->result_array();
    }

    function selectContentsOne($idx){
        $this->db->where('idx', $idx);
        return $this->db->get('contents')->row_array();
    }

    function selectContentsHasgTag($idx){
        $this->db->where('contents_idx', $idx);
        return $this->db->get('contents_hash_tag')->result_array();

    }

    function selectLikeContents($hash_tag_arr, $contents_idx_arr){
        $this->db->select('contents_idx');
        $this->db->where_in('hash_tag', $hash_tag_arr);
        $this->db->where_not_in('contents_idx', $contents_idx_arr);
        $this->db->order_by('rand() limit 1');
        return $this->db->get('contents_hash_tag')->row_array();
    }

    function selectLikeContentsRandom($idx){
        $this->db->select('DISTINCT(c.idx) as idx , c.*');
        $this->db->where_not_in('c.idx', $idx, false);
        $this->db->order_by('rand() limit 1');
        return $this->db->get('contents c')->row_array();
    }
}