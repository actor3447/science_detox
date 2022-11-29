<?php
/**
 * Created by PhpStorm.
 * User: PDH
 * Date: 2022-09-04
 * Time: 오전 2:51
 */

class Qchat extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->common->checkLogin();
        $this->load->model('admin/M_Qchat', 'q_chat');
        $this->data['page']                 = $this->input->get_post('page') ? $this->input->get_post('page') : 1;
        $this->data['size']                 = $this->input->get_post('size') ? $this->input->get_post('size') : 20;
        $this->data['cur_page']             = $this->data['page'];
    }

    function index(){
        $this->data['total_cnt']    = $this->q_chat->selectChatbotTotalCount();
        $this->data['result']       = $this->q_chat->selectChatbotList();
        $this->load->view('admin/q_chat/index', $this->data);
    }

    function regist(){
        $this->data['idx']                  = $this->input->get_post('idx') ? $this->input->get_post('idx') : "";
        $this->data['title']                = '';
        $this->data['description']          = '';
        $this->data['img_info']             = '';
        $this->data['edit_contents']        = '';

        if( !empty($this->data['idx']) ){
            $result                         = $this->q_chat->selectChatbotOne($this->data['idx']);
            $this->data['title']            = $result['title'];
            $this->data['file_info']        = json_decode($result['file_info'], JSON_UNESCAPED_UNICODE);
            $this->data['description']      = $result['description'];
        }

        $this->load->view('admin/q_chat/regist', $this->data);
    }

    function question(){
        $this->data['total_cnt']    = $this->q_chat->selectQuestionTotalCount();
        $this->data['result']       = $this->q_chat->selectQuestionList();
        $this->load->view('admin/q_chat/question', $this->data);
    }

    function question_regist(){
        $this->data['idx']                  = $this->input->get_post('idx') ? $this->input->get_post('idx') : "";
        $this->data['title']                = '';
        $this->data['sort']                 = '';
        $this->data['description']          = '';
        if( !empty($this->data['idx']) ){
            $result                         = $this->q_chat->selectQuestionOne($this->data['idx']);
            $this->data['title']            = $result['title'];
            $this->data['sort']             = $result['sort'];
            $this->data['description']      = $result['description'];
        }
        $this->load->view('admin/q_chat/question_regist', $this->data);
    }

    function chatbotRegistProcess(){
        $this->yield    = false;
        $this->form_validation->set_rules('idx', 'idx', 'required');
        $this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('description', 'description', 'required');
        $this->form_validation->set_rules('file_path', 'file_path', 'required');
        $this->form_validation->set_rules('file_name', 'file_name', 'required');

        if ($this->form_validation->run() == FALSE){
            $result_data["status"] = "fail";
        }

        $idx            = $this->input->post('idx') ?? "";
        $title          = $this->input->post('title') ?? "";
        $description    = $this->input->post('description') ?? "";
        $file_path      = $this->input->post('file_path') ?? "";
        $file_name      = $this->input->post('file_name') ?? "";
        $file_info      = array('file_path' => $file_path, 'file_name' => $file_name);
        $now_date       = date('Ymd_His');
        $user_ip        = $this->input->ip_address();

        //접속시작
        $connect        = ssh2_connect($ftp_server,22);
        ssh2_auth_password($connect,$ftp_username,$ftp_password);
        // 파일전송 업로드
        ssh2_scp_send($connect, $_SERVER["DOCUMENT_ROOT"].$file_path,"/home/bandibiz/chatbot_data/".$file_name,0644);
        //접속종료
        ssh2_exec($connect,'echo "EXITING" && exit;');
        unset($connect);

        if( empty($idx) ){
            $data       = array(
                'title'             => $title,
                'description'       => $description,
                'file_info'         => json_encode($file_info, JSON_UNESCAPED_UNICODE),
                'reg_date'          => $now_date,
                'reg_user_idx'      => $this->session->userdata('user_idx'),
                'reg_user_ip'       => $user_ip
            );
            $result     = $this->q_chat->insertChatbot($data);
            if( !empty($result) ){
                $result_data['status']  = 'success';
            }else{
                $result_data['status']  = 'error';
            }
        }else{
            $data       = array(
                'title'             => $title,
                'description'       => $description,
                'file_info'         => json_encode($file_info, JSON_UNESCAPED_UNICODE),
                'mod_date'          => $now_date,
                'mod_user_idx'      => $this->session->userdata('user_idx'),
                'mod_user_ip'       => $user_ip
            );
            $result     = $this->q_chat->updateChatbot($idx, $data);
            if( $result ){
                $result_data['status']  = 'success';
            }else{
                $result_data['status']  = 'error';
            }
        }
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function questionRegistProcess(){
        $this->yield    = false;
        $this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('sort', 'sort', 'required');
        $this->form_validation->set_rules('description', 'description', 'required');

        if ($this->form_validation->run() == FALSE){
            $result_data["status"] = "fail";
        }

        $idx            = $this->input->post('idx') ?? "";
        $title          = $this->input->post('title') ?? "";
        $sort           = $this->input->post('sort') ?? "";
        $description    = $this->input->post('description') ?? "";
        $now_date       = date('Y-m-d H:i:s');

        if( empty($idx) ){
            $data       = array(
                'title'             => $title,
                'description'       => $description,
                'sort'              => $sort,
                'reg_date'          => $now_date,
            );
            $result     = $this->q_chat->insertQuestion($data);
            if( !empty($result) ){
                $result_data['status']  = 'success';
            }else{
                $result_data['status']  = 'error';
            }
        }else{
            $data       = array(
                'title'             => $title,
                'description'       => $description,
                'sort'              => $sort,
                'mod_date'          => $now_date,
            );
            $result     = $this->q_chat->updateQuestion($idx, $data);
            if( $result ){
                $result_data['status']  = 'success';
            }else{
                $result_data['status']  = 'error';
            }
        }
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function deleteChatbotProcess(){
        $this->yield            = false;
        $this->form_validation->set_rules('idx', 'idx', 'required');
        $this->form_validation->set_rules('table', 'table', 'required');

        if ($this->form_validation->run() == FALSE){
            $result_data["status"] = "fail";
        }
        $result_data            = array();
        $data                   = array();
        $idx                    = $this->input->post('idx') ?? "";
        $table                  = $this->input->post('table') ?? "";
        $result                 = $this->q_chat->deleteChatbot($idx, $table);
        if($result){
            $result_data["status"] = "success";
        }else{
            $result_data["status"] = "fail";
        }
        echo json_encode($result_data);
    }

    function mento(){
        $this->data['search_name']          = $this->input->get('search_name') ?? "";
        $this->data['base_url']             = current_url() . "?search_name=" . $this->data['search_name'];
        $this->data['tot_row']              = $this->q_chat->selectMentoTotalCount();
        $this->data['tot_page'] 	        = ceil($this->data['tot_row']  /  $this->data['size'] );
        $this->data['cur_num']              = $this->data['tot_row'] - $this->data['size'] * ($this->data['cur_page'] - 1);
        $this->data['result']               = $this->q_chat->selectMentoList();
        foreach ($this->data['result'] as $key => $value){
            $this->data['result'][$key]['cnt']  = $this->q_chat->selectQnaCnt($value['idx']);
        }
        $this->paging->init($this->data);
        $this->data['paging']               = $this->paging->createPage();
        $this->load->view('admin/q_chat/mento_list', $this->data);
    }

    function mentoQna(){
        $this->data['idx']                  = $this->input->get('idx') ?? "";
        $title                              = $this->input->get('search_title') ?? "";
        $this->data['base_url']             = current_url() . "?idx=" . $this->data['idx'] . '&search_title=' . $title;
        $this->data['tot_row']              = $this->q_chat->selectMentoQnaTotalCount($this->data['idx'], $title);
        $this->data['tot_page'] 	        = ceil($this->data['tot_row']  /  $this->data['size'] );
        $this->data['cur_num']              = $this->data['tot_row'] - $this->data['size'] * ($this->data['cur_page'] - 1);
        $this->data['result']               = $this->q_chat->selectMentoQnaList($this->data['idx'], $title);
        $this->paging->init($this->data);
        $this->data['paging']               = $this->paging->createPage();
        $this->load->view('admin/q_chat/qna_list', $this->data);
    }

    function mentoQnaRegist(){
        $this->data['idx']                  = $this->input->get('idx') ?? "";
        $result                             = $this->q_chat->selectQnaContent();
        if(!empty($result)){
            $this->data['mento_idx']         = $result['mento_idx'];
            $this->data['title']            = $result['title'];
            $this->data['content']          = $result['content'];
            $this->data['request_content']  = $result['request_content'];
        }
        $this->load->view('admin/q_chat/qna_regist', $this->data);
    }

    function mentoQnaRegistProcess(){
        $this->yield    = false;
        $this->form_validation->set_rules('idx', 'idx', 'required');
        $this->form_validation->set_rules('request_content', 'request_content', 'required');
        $result_data    = array();
        if ($this->form_validation->run() == FALSE){
            $result_data["status"] = "fail";
        }

        $idx                = $this->input->post('idx') ?? "";
        $request_content    = $this->input->post('request_content') ?? "";
        $now_date       = date('Y-m-d H:i:s');

        if(!empty($idx)){
            $data       = array(
                'request_content'   => $request_content,
                'request_date'      => $now_date,
                'request_yn'        => 'Y'
            );
            $result     = $this->q_chat->updateMentoQna($idx, $data);
            if(!empty($result)){
                $result_data['status']  = 'success';
            }else{
                $result_data['status']  = 'error';
            }
        }else{
            $result_data['status']  = 'idx_error';
        }
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function deleteMentoQnaProcess(){
        $this->yield            = false;
        $this->form_validation->set_rules('idx', 'idx', 'required');
        $this->form_validation->set_rules('table', 'table', 'required');

        if ($this->form_validation->run() == FALSE){
            $result_data["status"] = "fail";
        }
        $result_data            = array();
        $data                   = array();
        $idx                    = $this->input->post('idx') ?? "";
        $table                  = $this->input->post('table') ?? "";
        $result                 = $this->q_chat->deleteMentoQna($idx, $table);
        if($result){
            $result_data["status"] = "success";
        }else{
            $result_data["status"] = "fail";
        }
        echo json_encode($result_data);
    }

}