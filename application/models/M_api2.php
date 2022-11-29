<?php
/**
 * Created by PhpStorm.
 * User: PDH
 * Date: 2022-09-05
 * Time: 오후 5:54
 */

class M_api2 extends CI_Model {
    public function __construct(){
        parent::__construct();
    }

    function selectContentsList(){
        $this->db->order_by('idx', 'desc');
        return $this->db->get('contents')->result_array();
    }

    function selectContentsOne($idx){
        $this->db->where('idx', $idx);
        return $this->db->get('contents')->row_array();
    }

    function selectMainContentsOne(){
        if($this->data['idx'] != ''){
            $this->db->where('idx', $this->data['idx']);
        }
        $this->db->order_by('idx', 'desc');
        return $this->db->get('contents')->row_array();
    }

    function selectMentoList(){
        return $this->db->get('member')->result_array();
    }

    function selectUserCnt($phone){
        $this->db->where('phone', $phone);
        return $this->db->get('user')->num_rows();
    }

    function insertUser($data){
        $this->db->insert('user', $data);
    }

    function updateUser($phone, $data){
        $this->db->where('phone', $phone);
        $this->db->update('user', $data);
    }

    function selectUserIdx($user_idx){
        $this->db->select('idx');
        $this->db->where('idx', $user_idx);
        return $this->db->get('user')->row_array();
    }

    function insertMentoQna($data){
        return $this->db->insert('mento_question', $data);
    }

    function insertLikeContents($data){
        return $this->db->insert('contents_like', $data);
    }

    function selectLikeContentsCnt($contents_idx, $user_idx){
        $this->db->where('contents_idx', $contents_idx);
        $this->db->where('user_idx', $user_idx);
        return $this->db->get('contents_like')->num_rows();
    }

    function insertBookmark($data){
        return $this->db->insert('contents_bookmark', $data);
    }

    function selectBookmarkCnt($contents_idx, $user_idx){
        $this->db->where('contents_idx', $contents_idx);
        $this->db->where('user_idx', $user_idx);
        return $this->db->get('contents_bookmark')->num_rows();
    }

    function updateUserImage($user_idx, $img_data){
        $this->db->where('idx', $user_idx);
        return $this->db->update('user', $img_data);
    }

    function updateContents($contents_idx, $update_data){
        $this->db->where('idx', $contents_idx);
        return $this->db->update('contents', $update_data);
    }

    function selectLikeContentsYn($user_idx, $contents_idx){
        $this->db->where('contents_idx', $contents_idx);
        $this->db->where('user_idx', $user_idx);
        return $this->db->get('contents_like')->num_rows();
    }

    function selectBookmarkYn($user_idx, $contents_idx){
        $this->db->where('contents_idx', $contents_idx);
        $this->db->where('user_idx', $user_idx);
        return $this->db->get('contents_bookmark')->num_rows();
    }

    function selectLikeContentsCount($contents_idx){
        $this->db->where('contents_idx', $contents_idx);
        return $this->db->get('contents_like')->num_rows();
    }

    function selectHashTag($contents_idx){
        $this->db->select('hash_tag');
        $this->db->where('contents_idx', $contents_idx);
        return $this->db->get('contents_hash_tag')->result_array();
    }

    function selectRelatedContents($contents_idx, $hash_tag){
        $this->db->select('c.*');
        $this->db->join('contents c', 'c.idx = h.contents_idx');
        $this->db->where('c.idx !=', $contents_idx);
        $this->db->where_in('hash_tag', $hash_tag);
        $this->db->order_by('rand()');
        $this->db->limit('3');
        return $this->db->get('contents_hash_tag h')->result_array();
    }

    function selectRelatedContentsRandom($cnt, $idx){
        $this->db->select('c.title, c.idx, c.img_info');
        $this->db->where_not_in('c.idx', $idx);
        $this->db->order_by(' rand() limit '. $cnt);
        return $this->db->get('contents c')->result_array();

    }

    function selectMainContentsCount(){
        return $this->db->get('contents')->num_rows();
    }

    function deleteLikeContents($contents_idx, $user_idx){
        $this->db->where('contents_idx', $contents_idx);
        $this->db->where('user_idx', $user_idx);
        return $this->db->delete('contents_like');
    }

    function deleteBookmark($contents_idx, $user_idx){
        $this->db->where('contents_idx', $contents_idx);
        $this->db->where('user_idx', $user_idx);
        return $this->db->delete('contents_bookmark');
    }

    function selectCategory(){
        return $this->db->get('category')->result_array();
    }

    function selectLikeCount($idx){
        $this->db->where('contents_idx', $idx);
        return $this->db->get('contents_like')->num_rows();
    }
}