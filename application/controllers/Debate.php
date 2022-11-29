<?php


class Debate extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_api');
        $this->load->model('m_debate');
        $this->data['device'] = $this->common->checkMobileLayout();

        $this->data['check_login'] = $this->common->checkUserLogin();
    }

    function index()
    {

        $this->data['category'] = $this->m_api->selectDebateCategory();
        $this->load->view('debate/'. $this->data['device'] .'index', $this->data);

    }


    function registDebateRoom(){

        $this->yield             = false;

        $result         = array('status' => 'error');

        $member_cnt     = $this->input->post('member_cnt');
        $category       = $this->input->post('category');
        $title          = $this->input->post('title');
        $img_path       = $this->input->post('img_path');
        $hash_tag       = $this->input->post('hash_tag');
        $hash_array     = array();

        if ($this->data['check_login']){

            $data = array(
                "owner_idx"             => $this->session->userdata('user_idx'),
                "debate_category_idx"   => $category,
                "member_cnt"            => $member_cnt,
                "title"                 => $title,
                "debate_category_idx"   => $category,
                "img_path"              => $img_path,
                "open_yn"               => 'Y',
                "reg_date"              => date('Y-m-d h:i:s')
            );

            #해쉬값 처리
            if (trim($hash_tag) != ""){
                $hash_array     = explode( '#', trim($hash_tag));
            }

            $debate_room_idx = $this->m_debate->insertDebateRoom($data);
            foreach ($hash_array as $key => $value){
                if ($value != ''){
                    $this->m_debate->insertDebateRoomHashTag(array('debate_room_idx' => $debate_room_idx , 'hash_tag' => trim($value)));
                }
            }
            $result = array('status' => 'success' , 'room_idx' => $debate_room_idx);
        }else{
            $result = array('status' => 'logout');
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }



    function chat(){

        //로그인 체크
        if ($this->data['check_login']){

            $this->data['debate_url']= $this->config->item('debate_url');
            $this->data['user_idx']  = $this->session->userdata('user_idx');
            $this->data['user_name'] = $this->session->userdata('user_name');
            $this->data['room_idx']  = $this->input->get('room_idx');

            $this->data['room_info']    = $this->m_api->selectDebateRoomOne($this->data['room_idx']);

            $this->data['room_like']    = $this->m_debate->selectDebateRoomLike($this->data['room_idx'], $this->data['user_idx']);
            $this->data['bookmark_cnt'] = $this->m_debate->selectDebateRoomBookmark($this->data['room_idx'], $this->data['user_idx']);

            $room_connect_info          = $this->m_debate->selectDebateRoomConnectExcepMe($this->data['room_idx'], $this->data['user_idx']);
            if (!empty($this->data['room_info'])){

                if ($this->data['room_info']['member_cnt'] > 0){

                    if ($this->data['room_info']['open_yn'] == 'Y'){
                        //방 인원수 체크
                        if (count($room_connect_info) > 0 && count($room_connect_info) >= $this->data['room_info']['member_cnt']){
                            $this->common->alertMessage('정원이 초과되어 입장할수 없습니다.', '/debate/index');
                        }
                    }
                }

            }

            //관련컨텐츠
            $data       = $this->m_debate->selectDebateHasgTag($this->data['room_idx']);
            $hashtag    = '';
            foreach ($data as $row){
                $hashtag .= $row['hash_tag'] . "|" ;
            }
            $hashtag = rtrim($hashtag, "|");

            $this->data['contents'] = $this->m_debate->selectContents($hashtag);
            if (count($this->data['contents']) < 3){
                $cnt = 3 - count($this->data['contents']);
                $string_idx = '';
                foreach ($this->data['contents'] as $row){
                    $string_idx .= $row['idx'] . "," ;
                }
                $string_idx = rtrim($string_idx, ",");

                $add_contents =  $this->m_debate->selectContentsRandom($cnt, $string_idx);


                foreach ($add_contents as $row){
                    $arr = array("title" => $row['title'], "idx" => $row['idx'], 'img_info' => $row['img_info']);
                    array_push($this->data['contents'], $arr);
                }
            }
            shuffle($this->data['contents']);

            $this->load->view('debate/'. $this->data['device'] .'chat', $this->data);

        }else{
            $this->common->goLogin('/debate/index');
        }
    }

//    function checkConnect(){
//        $this->yield          = false;
//        $users                = json_decode($this->input->post('users'));
//
//        foreach ($users as $user){
//            $this->m_debate->deleteDebateRoomConnect($user->username, $user->room);
//            $data = array('debate_room_idx' => $user->room, 'user_idx' => $user->username, 'reg_date' => date('Y-m-d h:i:s'));
//            $this->m_debate->insertDebateRoomConnect($data);
//        }
//    }


    function checkLike(){
        $this->yield          = false;

        if ($this->data['check_login']){
            $room_idx             = $this->input->post('room_idx');
            $status               = $this->input->post('status');
            $user_idx             = $this->session->userdata('user_idx');

            $like_cnt             = $this->m_debate->selectDebateRoomLike($room_idx , $user_idx);
            if ($status == 1){

                if ($like_cnt <= 0){
                    $data = array('debate_room_idx' => $room_idx, 'user_idx' => $user_idx, 'reg_date' => date('Y-m-d h:i:s'));
                    $this->m_debate->insertDebateRoomLike($data);
                }
            }else{
                $this->m_debate->deleteDebateRoomLike($room_idx, $user_idx);
            }

        }
    }

    function checkBookmark(){
        $this->yield          = false;

        if ($this->data['check_login']){
            $room_idx             = $this->input->post('room_idx');
            $status               = $this->input->post('status');
            $user_idx             = $this->session->userdata('user_idx');

            $like_cnt             = $this->m_debate->selectDebateRoomBookmark($room_idx , $user_idx);
            if ($status == 1){

                if ($like_cnt <= 0){
                    $data = array('debate_room_idx' => $room_idx, 'user_idx' => $user_idx, 'reg_date' => date('Y-m-d h:i:s'));
                    $this->m_debate->insertDebateRoomBookmark($data);
                }
            }else{
                $this->m_debate->deleteDebateRoomBookmark($room_idx, $user_idx);
            }

        }
    }

    function closeDebateRoom(){
        $this->yield             = false;
        //로그인 체크
        if ($this->data['check_login']){
            $user_idx                = $this->session->userdata('user_idx');
            $room_idx                = $this->input->post('room_idx');
            $this->data['room_info'] = $this->m_api->selectDebateRoomOne($room_idx);
            if (!empty($this->data['room_info']) && ($user_idx == $this->data['room_info']['owner_idx'])){
                $data = array('open_yn' => 'N');
                $this->m_debate->updateDebateRoom($data , $room_idx);
                $result = array('status' => 'success');
            }
        }else{
            $result = array('status' => 'logout');
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);

    }




//    function checkJoinRoom(){
//        $this->yield             = false;
//
//        $room_idx                = $this->input->post('room_idx');
//        $result                  = array();
//
//        //로그인 체크
//        if ($this->data['check_login']){
//            $status = $this->checkJoinConnect($room_idx, $this->session->userdata['user_idx']);
//            if ($status){
//                $result = array('status' => 'success' , 'user_idx' => $this->session->userdata['user_idx'], 'user_name' => $this->session->userdata['user_name'] );
//            }else{
//                $result = array('status' => 'over');  //정원초과
//            }
//        }else{
//            $result = array('status' => 'logout');
//        }
//        echo json_encode($result, JSON_UNESCAPED_UNICODE);
//    }




    function debateChatList(){
        $this->yield             = false;
        $room_idx = $this->input->get_post('room_idx');
        $result = $this->m_debate->selectDebateRoomConnect($room_idx);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

//    private function checkJoinConnect($room_idx, $user_idx){
//
//        $result = false;
//
//        $this->data['room_info']    = $this->m_api->selectDebateRoomOne($room_idx);
//        $connect_cnt                = $this->m_debate->selectDebateRoomConnectCount($room_idx);
//        if (!empty($this->data['room_info'])){
//            //방 인원수 체크
//            if ($connect_cnt < $this->data['room_info']['member_cnt']){
//                $result = true;
//            }
//        }
//        return $result;
//
//    }


    function debateMessageList(){

        $this->yield             = false;
        $room_idx = $this->input->get_post('room_idx');
        $result = $this->m_debate->selectDebateMessageList($room_idx);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);

    }

    function insertMessage(){
        $this->yield             = false;
        //로그인 체크
        if ($this->data['check_login']){
            $room_idx = $this->input->get_post('room_idx');
            $message = $this->input->get_post('message');

            $data = array(
                "user_idx"              => $this->session->userdata('user_idx'),
                "debate_room_idx"       => $room_idx,
                "message"               => htmlspecialchars($message),
                "type"                  => 'text',
                "reg_date"              => date('Y-m-d h:i:s')
            );
            $this->m_debate->insertDebateMessage($data);
            $result = array('message' => htmlspecialchars($message));
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }

    }



    function getUser(){
        $this->yield             = false;
        $user_idx = $this->input->get_post('user_idx');
        $result = $this->m_debate->selectUserName($user_idx);

        if (!empty($result)){
            $result = array('status'=>'success', 'user_name' => $result['name']);
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }


    function getUsers(){
        $this->yield             = false;

        $users = $this->input->get_post('users');
        $result_data = [];

        foreach ($users as $user){

            $data = $this->m_debate->selectUserName($user['username']);
            array_push($result_data, array('user_name' => $data['name'], 'user_idx' => $user['username']));
        }
        $result = array('status'=>'success', 'users' => $result_data);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);

    }

    function checkUser(){
        $this->yield             = false;
        $room_idx = $this->input->get_post('room_idx');
        $data     = $this->m_debate->selectDebateRoomConnect($room_idx);
        $result = array('status'=>'success', 'users' => $data);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }


    function getMessage(){
        $this->yield             = false;
        $room_idx = $this->input->get_post('room_idx');
        $result = $this->m_debate->selectDebateMessage($room_idx);

        if ($result){
            $result = array('status'=>'success', 'message' => $result);
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }
}
