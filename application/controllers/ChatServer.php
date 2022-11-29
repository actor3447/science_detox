<?php


class ChatServer extends CI_Controller
{
//    public function __construct()
//    {
//        parent::__construct();
//        $this->load->model('M_chatserver', 'm_chatserver');
//        $this->load->model('M_debate', 'm_debate');
//        $this->yield = false;
//
//        error_reporting( E_ALL );
//        ini_set( "display_errors", 1 );
//
//    }
//
//    function insertNupdate()
//    {
//
//        $user_idx  = $this->input->get_post('user_idx');
//        $room_idx  = $this->input->get_post('room_idx');
//
//        $result = $this->m_chatserver->selectDebateRoomConnectOne($user_idx, $room_idx);
//        if (empty($result)){
//            $data =  array('debate_room_idx' => $room_idx, 'user_idx' => $user_idx ,'reg_date' => date('Y-m-d h:i:s'));
//            $this->m_chatserver->insertDebateRoomConnect($data);
//        }else{
//            $data =  array('reg_date' => date('Y-m-d h:i:s'));
//            $this->m_chatserver->updateDebateRoomConnect($data, $user_idx, $room_idx);
//        }
//        $result             = $this->m_debate->selectDebateRoomConnect($room_idx);
////        $result['message']  = array();
////        $result['message']  = $this->m_debate->selectDebateMessageList($room_idx);
//        echo json_encode($result, JSON_UNESCAPED_UNICODE);
//
//    }
//
//    private function checkConnect(){
//
//        $timestamp = strtotime("-5 seconds");
//        $time = date("Y-m-d H:i:s", $timestamp)."<br/>";
//        $result = $this->m_chatserver->selectDebateRoomConnectCheckTime($time);
//        foreach ($result as $rows){
//            $this->m_chatserver->deleteDebateRoomConnect($rows['idx']);
//        }
//    }
//
//
//    function scheduler(){
//        while(true){
//            self::checkConnect();
//            sleep(10);
//        }
//    }
}
