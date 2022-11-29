<?php


class Debate extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->common->checkLogin();
        $this->load->model('admin/M_debate', 'm_debate');

    }

    function index(){

        $this->data['total_cnt']    = $this->m_debate->selectDebateCount();
        $this->data['result']       = $this->m_debate->selectDebateList();

        $this->load->view('admin/debate/index', $this->data);
    }

    function chat(){
        $this->data['idx']          = $this->input->get_post('idx');
        $this->data['total_cnt']    = $this->m_debate->selectDebateMessageCount($this->data['idx']);
        $this->data['result']       = $this->m_debate->selectDebateMessageList($this->data['idx']);
        $this->load->view('admin/debate/chat', $this->data);
    }

    function deleteDebate(){
        $this->yield                = false;
        $this->form_validation->set_rules('idx', 'idx', 'required');
        if ($this->form_validation->run() == FALSE){
            $result_data["status"]  = "fail";
        }
        $debate_idx         = $this->input->post('idx') ?? "";
        if( !empty($debate_idx) ){
            $this->m_debate->deleteAdminDebateRoom($debate_idx);
            $this->m_debate->deleteAdminDebateRoomBookmark($debate_idx);
            $this->m_debate->deleteAdminDebateRoomConnect($debate_idx);
            $this->m_debate->deleteAdminDebateRoomHashTag($debate_idx);
            $this->m_debate->deleteAdminDebateRoomLike($debate_idx);
            $result_data["status"]  = "success";
        }else{
            $result_data["status"]  = "fail";
        }
    echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

}