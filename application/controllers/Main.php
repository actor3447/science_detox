<?php
/**
 * Created by PhpStorm.
 * User: PDH
 * Date: 2022-07-28
 * Time: 오후 2:41
 */

class Main extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('m_api');
        $this->load->model('M_api2', 'api2');
        $this->load->model('m_main');
        $this->load->model('m_debate');
        $this->data['device']    = $this->common->checkMobileLayout();

    }

    function index(){
        $this->yield                = false;
        $is_login                   = $this->common->loginUserCheck();
        $this->data['user_idx']     = $this->session->userdata('user_idx');
        $this->data['link_idx']     = $this->input->get('link_idx') ?? "";
        $is_mobile                  = $this->common->checkMobile();
        $this->data['check_link']   = '';
        $data                       = array();

        if ($is_mobile == 'N'){ //PC

            $list_cnt = '5';
            $like_cnt = '2';

        }else{
            $list_cnt = '1';
            $like_cnt = '1';
        }

        if ($this->data['user_idx'] != '') {
            $data = $this->m_main->selectContentsLike($this->data['user_idx']);
        }

        $hash_tag = '';
        foreach ($data as $row){
            $hash_data = $this->m_main->selectContentsHashTag($row['contents_idx']);
            foreach ($hash_data as $hash){
                $hash_tag .= $hash['hash_tag'] . "|" ;
            }
        }
        $hash_tag = rtrim($hash_tag, "|");
        $this->data['contents'] = $this->m_main->selectContents($hash_tag, $like_cnt);

        if (count($this->data['contents']) < $list_cnt){
            $cnt = $list_cnt - count($this->data['contents']);
            $string_idx = '';
            foreach ($this->data['contents'] as $row){
                $string_idx .= $row['idx'] . "," ;
            }
            $string_idx = rtrim($string_idx, ",");

            $add_contents =  $this->m_main->selectContentsRandom($cnt, $string_idx);

            foreach ($add_contents as $row){

                $arr = array("title" => $row['title'], "idx" => $row['idx'], "type" => $row['type'], "img_info" => $row['img_info'], "contents_info" => $row['contents_info'], "youtube_link" => $row['youtube_link'], "view_count" => $row['view_count']);
                array_push($this->data['contents'], $arr);
            }
        }
        shuffle($this->data['contents']);

        if ($this->data['link_idx'] != ''){

            $contents                       = $this->m_main->selectContentsOne($this->data['link_idx']);
            if (!empty($contents)){

                $check_link = '';


                foreach ($this->data['contents'] as $key =>  $row){

                    if ($row['idx'] == $this->data['link_idx']){
                        $check_link = $key;
                    }

                }

                if ($check_link == ''){

                    $arr = array("title" => $contents['title'], "idx" => $contents['idx'], "type" => $contents['type'], "img_info" => $contents['img_info'], "contents_info" => $contents['contents_info'], "youtube_link" => $contents['youtube_link'], "view_count" => $contents['view_count']);
                    array_push($this->data['contents'], $arr);
                    array_shift($this->data['contents']);
                    $this->data['check_link'] = $list_cnt -1 ;  //마지막으로 설정
                    $this->data['link_idx']   = $this->data['contents'][$this->data['check_link']]['idx'];
                }else{

                    $this->data['check_link'] = $check_link;

                }
            }
        }else{
            $this->data['link_idx'] = $this->data['contents'][0]['idx'];
        }


        //모바일일때
        if ($is_mobile == 'Y') {

            //관련 컨텐츠 갯수
            $contents_cnt = 3;

            if( $this->data['link_idx'] != '' ){
                $this->data['contents_idx'] = $this->data['link_idx'];
            }else{
                $this->data['contents_idx']     = $this->data['contents'][0]['idx'];
            }

            $like_yn                        = $this->api2->selectLikeContentsYn($this->data['user_idx'], $this->data['contents_idx']);
            if( $like_yn > 0 ){
                $this->data['like_yn']      = 'on';
            }else{
                $this->data['like_yn']      = '';
            }

            $bookmark_yn                    = $this->api2->selectBookmarkYn($this->data['user_idx'], $this->data['contents_idx']);
            if( $bookmark_yn > 0 ){
                $this->data['bookmark_yn']  = 'on';
            }else{
                $this->data['bookmark_yn']  = '';
            }
            $this->data['like_count']       = $this->api2->selectLikeContentsCount($this->data['contents_idx']);

            //관련컨텐츠
            $data       = $this->m_main->selectContentsHasgTag($this->data['contents_idx']);
            $hashtag    = '';
            foreach ($data as $row){
                $hashtag .= $row['hash_tag'] . "|" ;
            }
            $hashtag = rtrim($hashtag, "|");

            $this->data['related_contents'] = $this->m_main->selectContents($hashtag , $contents_cnt);
            if (count($this->data['related_contents']) < $contents_cnt){
                $cnt = $contents_cnt - count($this->data['related_contents']);

                $string_idx = $this->data['contents_idx'] . ",";

                foreach ($this->data['related_contents'] as $row){
                    $string_idx .= $row['idx'] . "," ;
                }
                $string_idx = rtrim($string_idx, ",");
                $add_contents =  $this->m_debate->selectContentsRandom($cnt, $string_idx);

                foreach ($add_contents as $row){
                    $arr = array("title" => $row['title'], "idx" => $row['idx'], 'img_info' => $row['img_info']);
                    array_push($this->data['related_contents'], $arr);
                }
            }
            shuffle($this->data['related_contents']);
            $this->data['contents_use_idx'] = $this->input->get('contents_use_idx') ?? "";

        }



        $this->load->view( $this->data['device'].'main', $this->data);
    }


    function chat(){
        $this->load->view('chat');
    }

    function mypage(){
        $this->load->view('mypage');
    }


    function debateView(){

        $check_login            = $this->common->checkUserLogin();

        if ($check_login){
            $this->data['user_idx']  = $this->session->userdata('user_idx');

            //테스트용
            $this->data['user_idx']  = $this->input->get('user_idx');
            $this->data['room_idx']  = $this->input->get('room_idx');

            $room_info              = $this->m_api->selectDebateRoomOne($this->data['room_idx']);
            $room_connect_info      = $this->m_api->selectDebateRoomConnect($this->data['room_idx']);
            if (!empty($room_info)){
                echo count($room_connect_info);
                $this->load->view('debate_view', $this->data);
            }
        }else{
            $this->common->goLogin();
        }

    }

    function getContentsList(){
        $this->yield                = false;
        $idx            = $this->input->post('idx') ?? "";
        $contents       = $this->api2->selectContentsOne($idx);
        $result_status  = array();
        $footer_html    = '';
        if(!empty($contents)){
            $result_status['header_text']   = $contents['title'];
            $img_info                       = json_decode($contents['img_info'], JSON_UNESCAPED_UNICODE);
            if($contents['type'] == 'youtube'){
//                $result_status['body_text'] = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$contents['youtube_link'].'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
//                $result_status['body_text'] .= '<br>';
                $result_status['body_text']     = $contents['contents_info'];
                $result_status['img_src']       = $contents['youtube_link'];
            }else{
                $result_status['body_text']     = $contents['contents_info'];
                $result_status['img_src']       = $img_info['img_path'];
            }
            $result_status['footer_html']   = $footer_html;
            $result_status['contents_idx']  = $contents['idx'];
            $result_status['view_count']    = $contents['view_count'];
            $result_status['status']        = 'success';
        }
        $get_hash_tag                   = $this->api2->selectHashTag($contents['idx']);
        $hash_tag                       = array();
        foreach ($get_hash_tag as $key => $value){
            $hash_tag[$key]             = $value['hash_tag'];
        }
        if(empty($hash_tag)){
            $hash_tag[0]                = '';
        }
        $related_contents               = $this->api2->selectRelatedContents($contents['idx'], $hash_tag);
        if( count($related_contents) < 3 ){
            $random_idx                 = array();
            if( !empty($related_contents) ){
                foreach ($related_contents as $idx_rows){
                    array_push($random_idx, $idx_rows['idx']);
                }
            }
            if(empty($random_idx)){
                $random_idx[0]          = '';
            }
            $cnt                        = 3 - count($related_contents);
            $random_contents            = $this->api2->selectRelatedContentsRandom($cnt, $random_idx);
            foreach( $random_contents as $append_contents ){
                array_push($related_contents, $append_contents);
            }

        }
        shuffle($related_contents);
        foreach ($related_contents as $rows){
            $related_contents_img           = json_decode($rows['img_info'], JSON_UNESCAPED_UNICODE);
            $footer_html                    .= '<li style="background-image:url('.$related_contents_img['img_path'].')">';
            $footer_html                    .= '    <a href="?link_idx=' . $rows['idx'] .'" class="btn-relation">';
            $footer_html                    .= '        <span class="relation-photo">';
            $footer_html                    .= '        </span>';
            $footer_html                    .= '        <span class="relation-title">'.$rows['title'].'</span>';
            $footer_html                    .= '    </a>';
            $footer_html                    .= '</li>';
        }

        $like_yn                        = $this->api2->selectLikeContentsYn($this->session->userdata('user_idx'), $idx);
        if( $like_yn > 0 ){
            $like_yn                        = 'on';
        }else{
            $like_yn                        = '';
        }
        $bookmark_yn                    = $this->api2->selectBookmarkYn($this->session->userdata('user_idx'), $idx);
        if( $bookmark_yn > 0 ){
            $bookmark_yn                    = 'on';
        }else{
            $bookmark_yn                    = '';
        }
        $like_count                         = $this->api2->selectLikeCount($idx);

        $result_status['related_contents']  = $footer_html;
        $result_status['like_yn']           = $like_yn;
        $result_status['like_count']        = $like_count;
        $result_status['bookmark_yn']       = $bookmark_yn;
        echo json_encode($result_status, JSON_UNESCAPED_UNICODE);
    }

    function contentsLikeReigstProcess(){
        $this->yield    = false;
        $login_yn       = $this->common->loginUserCheck();
        if( $login_yn == 0 ){
            $result_data['status']  = 'login_error';
        }
        $this->form_validation->set_rules('contents_idx', 'contents_idx', 'required');
        $this->form_validation->set_rules('user_idx', 'user_idx', 'required');
        $result_data    = array();
        if ($this->form_validation->run() == FALSE){
            $result_data["status"] = "validation_error";
        }else{
            $contents_idx   = $this->input->post('contents_idx') ?? "";
            $user_idx       = $this->input->post('user_idx') ?? "";
            $now_date       = date('Y-m-d H:i:s');
            $data           = array(
                            'contents_idx'  => $contents_idx,
                            'user_idx'      => $user_idx,
                            'reg_date'      => $now_date
                            );
            $insert_cnt     = $this->api2->selectLikeContentsCnt($contents_idx, $user_idx);
            if( $insert_cnt > 0 ){
                $delete_result     = $this->api2->deleteLikeContents($contents_idx, $user_idx);
                if( $delete_result ){
                    $result_data['status']  = 'delete_success';
                }
            }else{
                $result         = $this->api2->insertLikeContents($data);
                if( $result ){
                    $result_data['status']  = 'success';
                }else{
                    $result_data['status']  = 'insert_error';
                }
            }
        }
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function contentsMobileLikeReigstProcess(){
        $this->yield    = false;
        $login_yn       = $this->common->loginUserCheck();
        if( $login_yn == 0 ){
            $result_data['status']  = 'login_error';
        }
        $this->form_validation->set_rules('contents_idx', 'contents_idx', 'required');
        $this->form_validation->set_rules('user_idx', 'user_idx', 'required');
        $result_data    = array();
        if ($this->form_validation->run() == FALSE){
            $result_data["status"] = "validation_error";
        }else{
            $contents_idx       = $this->input->post('contents_idx') ?? "";
            $contents_use_idx   = $this->input->post('contents_use_idx') ?? "";
            $user_idx           = $this->input->post('user_idx') ?? "";
            $now_date           = date('Y-m-d H:i:s');
            $data               = array(
                'contents_idx'  => $contents_idx,
                'user_idx'      => $user_idx,
                'reg_date'      => $now_date
            );
            $insert_cnt         = $this->api2->selectLikeContentsCnt($contents_idx, $user_idx);
            if( $insert_cnt > 0 ){
                $this->api2->insertLikeContents($data);
            }
            $hash_tag_arr           = array();
            $contents_idx_arr       = array();
            $string_idx             = '';
            $related_contents       = $this->m_main->selectContentsHashtag($contents_idx);
            //해시태그
            if( !empty( $related_contents) ){
                foreach ($related_contents as $hash_rows){
                    array_push($hash_tag_arr, $hash_rows['hash_tag']);
                }
            }
            //컨텐츠 인덱스
            array_push($contents_idx_arr, $contents_idx);
            if( !empty($contents_use_idx) ){
                $contents_use_idx_arr   = explode(',', $contents_use_idx);
                foreach ($contents_use_idx_arr as $key => $value){
                    if(!empty($value)){
                        array_push($contents_idx_arr, $value);
                    }
                }
                //컨텐츠 인덱스 스트링
                foreach ($contents_idx_arr as $contents_key => $contents_value){
                    if( $contents_key == 0 ){
                        $string_idx = $contents_value;
                    }else{
                        $string_idx .= ','.$contents_value;
                    }
                }
            }else{
                $string_idx = $contents_idx;
            }
            $like_contents                  = $this->m_main->selectLikeContents($hash_tag_arr, $contents_idx_arr);
            if( empty($like_contents) ){
                $like_contents              = $this->m_main->selectLikeContentsRandom($contents_idx_arr);
                $result_data['status']          = 'success';
                $result_data['contents_idx']    = $like_contents['idx'];
                $result_data['string_idx']      = '';
                $result_data['status2']         = '1';
            }else{
                $result_data['status']          = 'success';
                $result_data['contents_idx']    = $like_contents['contents_idx'];
                $result_data['string_idx']      = $string_idx;
                $result_data['status2']         = '2';
            }

        }
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function bookmarkReigstProcess(){
        $this->yield    = false;
        $login_yn       = $this->common->loginUserCheck();
        if( $login_yn == 0 ){
            $result_data['status']  = 'delete_success';
        }
        $this->form_validation->set_rules('contents_idx', 'contents_idx', 'required');
        $this->form_validation->set_rules('user_idx', 'user_idx', 'required');
        $result_data    = array();
        if ($this->form_validation->run() == FALSE){
            $result_data["status"] = "validation_error";
        }else{
            $contents_idx   = $this->input->post('contents_idx') ?? "";
            $user_idx       = $this->input->post('user_idx') ?? "";
            $now_date       = date('Y-m-d H:i:s');
            $data           = array(
                'contents_idx'  => $contents_idx,
                'user_idx'      => $user_idx,
                'reg_date'      => $now_date
            );
            $insert_cnt     = $this->api2->selectBookmarkCnt($contents_idx, $user_idx);
            if( $insert_cnt > 0 ){
                $delete_result     = $this->api2->deleteBookmark($contents_idx, $user_idx);
                if( $delete_result ){
                    $result_data['status']  = 'delete_success';
                }
            }else{
                $result         = $this->api2->insertBookmark($data);
                if( $result ){
                    $result_data['status']  = 'success';
                }else{
                    $result_data['status']  = 'insert_error';
                }
            }
        }
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function addContentsViewCnt(){
        $this->yield        = false;
        $contents_idx       = $this->input->post('contents_idx') ?? "";
        $result_data        = array();
        if( !empty($contents_idx) ){
            $get_contents   = $this->api2->selectContentsOne($contents_idx);
            $view_cnt       = $get_contents['view_count'] + 1;
            $update_data    = array('view_count' => $view_cnt);
            $result         = $this->api2->updateContents($contents_idx, $update_data);
            if( $result ){
                $result_data['status']  = 'success';
            }else{
                $result_data['status']  = 'update_error';
            }
        }else{
            $result_data['status']  = 'content_idx_error';
        }
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function getContentsTitle(){
        $this->yield        = false;
        $link_idx           = $this->input->post('link_idx') ?? "";
        $contents           = $this->api2->selectContentsOne($link_idx);
        $result_data        = array();
        $html               = '';
        if(!empty($contents)){
            $html           .= '<div class="swiper-slide">';
            $html           .= '    <button type="button" class="btn-swiper" onclick="getContentsList('.$contents['idx'].')">';
            $html           .= '        <div class="img-group">';
            if( $contents['type'] == 'youtube' ){
                $html           .= '            <iframe class="youtube_video" width="500" height="100%" src="https://www.youtube.com/embed/'.$contents['youtube_link'].'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            }else{
                $img_info = json_decode($contents['img_info']);
                $html           .= '            <img src="'.$img_info->img_path.'" alt="">';
            }
            $html           .= '        </div>';
            $html           .= '    <div class="txt-group">';
            $html           .= '        <div class="title">'.$contents['title'].'</div>';
            $html           .= '    </div>';
            $html           .= '    </button>';
            $html           .= '</div>';
        }
        $result_data['header_html'] = $html;
        $result_data['status']      = 'success';
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }


    function share(){
        $this->data['idx']   = $this->input->get('idx') ?? "";
        $this->data['contents']           = $this->api2->selectContentsOne($this->data['idx']);
        $this->yield        = false;
        if (!empty($this->data['contents'])){

            $this->load->view( 'share', $this->data);
        }

    }
}