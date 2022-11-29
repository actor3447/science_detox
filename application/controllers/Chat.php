<?php

class Chat extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $login_yn       = $this->common->loginUserCheck();
        if( $login_yn == 0 ){
            echo '<script>alert("로그인 후 이용 바랍니다.")</script>';
            echo '<script>location.href="https://auth.dongascience.com/?referer_url='.urlencode(CURRENT_URI).'"</script>';
//            redirect('https://auth.dongascience.com/?referer_url='.urlencode(CURRENT_URI).'');
        }
        $this->load->model('M_api', 'api');
        $this->load->model('M_api2', 'api2');
        $this->load->model('M_chat', 'chat');
        $this->data['page']                 = $this->input->get_post('page') ? $this->input->get_post('page') : 1;
        $this->data['size']                 = $this->input->get_post('size') ? $this->input->get_post('size') : 5;
        $this->data['cur_page']             = $this->data['page'];
    }

    function index(){
        $this->data['qa_list']              = $this->chat->selectQuestionList();
        $this->data['category']             = $this->api->selectDebateCategory();
        $is_mobile                          = $this->common->checkMobile();
        if( $is_mobile == 'N' ){
            $this->data['tot_row']              = $this->chat->selectMentoCount();
            $this->data['tot_page'] 	        = ceil($this->data['tot_row']  /  $this->data['size'] );
            $this->data['cur_num']              = $this->data['tot_row'] - $this->data['size'] * ($this->data['cur_page'] - 1);
            $this->data['mento_list']           = $this->chat->selectMentoList();
            $this->data['page']                 = 2;
            $this->data['mento_next_list']      = $this->chat->selectMentoList();
        }
        if( $is_mobile == 'Y' ){
            $this->data['mento_list']           = $this->chat->selectMobileMentoList();
        }
        $this->load->view($this->common->checkMobileLayout().'chat', $this->data);
    }

    function mentoMoreView(){
        $this->yield                        = false;
        $this->data['tot_row']              = $this->chat->selectMentoCount();
        $this->data['page']                 = $this->input->post('page') ?? "1";
        $this->data['tot_page'] 	        = ceil($this->data['tot_row']  /  $this->data['size'] );
        $this->data['cur_num']              = $this->data['tot_row'] - $this->data['size'] * ($this->data['cur_page'] - 1);
        $result                             = $this->chat->selectMentoList();
        $html                               = '';
        $button_html                        = '';
        $result_data                        = array();

        foreach ($result as $rows){
            $html       .= '<li>';
            $html       .= '    <div class="mento-group">';
            $html       .= '        <button type="button" class="btn-mento" title="팝업열기">';
            $html       .= '            <div class="mento-heading">';
            $mento_img = json_decode($rows['img_info']);
            $html       .= '            <img src="'.$mento_img->img_path.'" alt="홍 길동 멘토 사진">';
            $html       .= '            </div>';
            $html       .= '            <div class="mento-body">';
            $html       .= '                <div class="mento-body-title">'.$rows['name'].' 멘토</div>';
            $html       .= '                    <ul class="mento-detail-lists">';
            $html       .= '                        <li>'.$rows['education'].'</li>';
            $html       .= '                        <li>'.$rows['category_name'].'</li>';
            $html       .= '                    </ul>';
            $html       .= '                </div>';
            $html       .= '        </button>';
            $html       .= '        <div class="mento-footer">';
            $html       .= '            <button type="button" title="팝업열기" class="btn-question" onclick="mentoAsk(\''.$rows['idx'].'\')">';
            $html       .= '                <span>1:1 질문하기</span>';
            $html       .= '            </button>';
            $html       .= '        </div>';
            $html       .= '    </div>';
            $html       .= '</li>';
        }

        $count              = $this->data['page'] + 1;
        $this->data['page'] = $count;
        $btn_result         = $this->chat->selectMentoList();

        if(!empty($btn_result)){
            $button_html    .= '<button type="button" class="btn-more-gray" onclick="mentoMoreView(\''.$count.'\')">';
            $button_html    .= '    <span>더보기</span>';
            $button_html    .= '</button>';
        }else{
            $button_html    .= '';
        }

        $result_data['status']      = 'success';
        $result_data['html']        = $html;
        $result_data['btn_html']    = $button_html;
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function mentoMobileView(){
        $this->yield        = false;
        $mento_idx          = $this->input->post('mento_idx') ?? "";
        $result_data        = array();
        $result             = $this->chat->selectMentoOne($mento_idx);
        if( !empty($result) ){
            $result_data['mento_idx']       = $result['idx'];
            $result_data['mento_name']      = $result['name'].' 멘토';
            $result_data['mento_img']       = json_decode($result['img_info']);
            $result_data['mento_category']   = $result['title'];
            $result_data['mento_comment']   = $result['comment'];
            $result_data['status']          = 'success';
        }else{
            $result_data['status']          = 'idx_error';
        }
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function mentoQnaRegistProcess(){
        $this->yield    = false;
        $this->form_validation->set_rules('mento_idx', 'mento_idx', 'required');
//        $this->form_validation->set_rules('category_idx', 'category_idx', 'required');
        $this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('content', 'content', 'required');
        $result_data    = array();
        if ($this->form_validation->run() == FALSE){
            $result_data["status"] = "fail";
        }

        $user_idx       = $this->api2->selectUserIdx($this->session->userdata('user_idx'));
        $mento_idx      = $this->input->post('mento_idx') ?? "";
//        $category_idx   = $this->input->post('category_idx') ?? "";
        $title          = $this->input->post('title') ?? "";
        $content        = $this->input->post('content') ?? "";
        $now_date       = date('Y-m-d H:i:s');

        if(!empty($user_idx['idx'])){
            $data       = array(
                        'user_idx'          => $user_idx['idx'],
                        'mento_idx'         => $mento_idx,
                        'category_idx'      => '0',
                        'title'             => $title,
                        'content'           => $content,
                        'request_content'   => '',
                        'reg_date'          => $now_date,
                        'request_yn'        => 'N'
                        );
            $result     = $this->api2->insertMentoQna($data);
            if(!empty($result)){
                $result_data['status']  = 'success';
            }else{
                $result_data['status']  = 'error';
            }
        }else{
            $result_data['status']  = 'login_error';
        }
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function mentoInfo(){
        $this->yield    = false;
        $this->form_validation->set_rules('mento_idx', 'mento_idx', 'required');
        $result_data    = array();
        if ($this->form_validation->run() == FALSE){
            $result_data["status"] = "fail";
        }
        $mento_idx      = $this->input->post('mento_idx') ?? "";
        if( !empty($mento_idx) ){
            $result     = $this->chat->selectMentoOne($mento_idx);
            if( !empty($result) ){
                $result_data['mento_idx']       = $result['idx'];
                $result_data['mento_name']      = $result['name'].' 멘토';
                $result_data['mento_img']       = json_decode($result['img_info']);
                $result_data['mento_category']  = $result['title'];
                $result_data['mento_education'] = $result['education'];
                $result_data['mento_comment']   = $result['comment'];
                $result_data['status']          = 'success';
            }else{
                $result_data['status']          = 'result_fail';
            }
        }else{
            $result_data['status']          = 'idx_fail';
        }
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }
}

?>