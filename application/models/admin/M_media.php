<?php
/**
 * Created by PhpStorm.
 * User: PDH
 * Date: 2022-07-29
 * Time: 오후 3:58
 */

class M_media extends CI_Model{
    public function __construct(){
        parent::__construct();
    }

    function insertCategory($data){
        return $this->db->insert('category', $data);
    }

    function updateCategory($idx, $data){
        $this->db->where('idx', $idx);
        return $this->db->update('category', $data);
    }

    function selectCategory(){
        return $this->db->get('category')->result_array();
    }

    function insertContents($data){
        $this->db->insert('contents', $data);
        return $this->db->insert_id();
    }

    function updateContents($idx, $data){
        $this->db->where('idx', $idx);
        return $this->db->update('contents', $data);
    }
    function selectContentsTotalCount(){
        return $this->db->get('contents')->num_rows();
    }

    function selectContentsOne($idx){
        $this->db->where('idx', $idx);
        return $this->db->get('contents')->row_array();
    }

    function selectContentsList(){
        $this->db->order_by('idx', 'desc');
        return $this->db->get('contents')->result_array();
    }

    function deleteContents($idx, $table){
        $this->db->where('idx', $idx);
        return $this->db->delete($table);
    }

    function insertHashTag($data){
        $this->db->insert('contents_hash_tag', $data);
    }

    function deleteHashTag($idx){
        $this->db->where('contents_idx', $idx);
        $this->db->delete('contents_hash_tag');
    }

    function selectHashTag($idx){
        $this->db->where('contents_idx', $idx);
        return $this->db->get('contents_hash_tag')->result_array();
    }

    function selectContentsCurationTotalCount(){
        return $this->db->get('contents_curation')->num_rows();
    }

    function selectContentsCurationList(){
        $this->db->order_by('idx', 'desc');
        return $this->db->get('contents_curation')->result_array();
    }

    function insertContentsCuration($data){
        return $this->db->insert('contents_curation', $data);
    }

    function updateContentsCuration($idx, $data){
        $this->db->where('idx', $idx);
        return $this->db->update('contents_curation', $data);
    }

    function selectContentsCurationOne($idx){
        $this->db->where('idx', $idx);
        $this->db->order_by('idx', 'desc');
        return $this->db->get('contents_curation')->row_array();
    }

    function deleteContentsLike($contents_idx){
        $this->db->where('contents_idx', $contents_idx);
        $this->db->delete('contents_like');
    }

    function deleteContentsBookmark($contents_idx){
        $this->db->where('contents_idx', $contents_idx);
        $this->db->delete('contents_bookmark');
    }

    function deleteContentsHashTag($contents_idx){
        $this->db->where('contents_idx', $contents_idx);
        $this->db->delete('contents_hash_tag');
    }

}