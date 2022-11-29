<?php
/**
 * Created by PhpStorm.
 * User: PDH
 * Date: 2022-09-07
 * Time: 오후 4:39
 */

class Member extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->common->checkLogin();
        $this->load->model('/admin/M_member', 'member');
        $this->load->model('M_api', 'api');
        $this->data['idx']              = $this->input->get_post('idx') ? $this->input->get_post('idx') : "";
        $this->data['search_name']      = $this->input->get_post('search_name') ? $this->input->get_post('search_name') : "";
        $this->data['search_cert']      = $this->input->get_post('search_cert') ? $this->input->get_post('search_cert') : "";
        $this->data['type']             = $this->input->get_post('type') ? $this->input->get_post('type') : "";
    }

    function index(){
        $this->data['total_cnt']        = $this->member->selectMemberCnt();
        $this->data['result']           = $this->member->selectMember();
        $this->load->view('admin/member/index', $this->data);
    }


    function user(){

        $this->data['total_cnt']        = $this->member->selectUserCnt();
        $this->data['result']           = $this->member->selectUserList();

        $this->load->view('admin/member/user', $this->data);
    }

    function regist(){
        $this->data['idx']                  = $this->input->get_post('idx') ? $this->input->get_post('idx') : "";
        $this->data['id']               = '';
        $this->data['passwd']           = '';
        $this->data['name']             = '';
        $this->data['education']        = '';
        $this->data['img_info']         = '';
        $this->data['mento_yn']         = '';
        $this->data['category_idx']     = '';
        $this->data['comment']          = '';
        $this->data['category']             = $this->member->selectCategory();
        if( !empty($this->data['idx']) ){
            $result                         = $this->member->selectMemberOne();
            $this->data['idx']              = $result['idx'];
            $this->data['id']               = $result['id'];
            $this->data['passwd']           = $result['passwd'];
            $this->data['name']             = $result['name'];
            $this->data['education']        = $result['education'];
            $this->data['img_info']         = json_decode($result['img_info'], JSON_UNESCAPED_UNICODE);
            $this->data['mento_yn']         = $result['mento_yn'];
            $this->data['category_idx']     = $result['category_idx'];
            $this->data['comment']          = $result['comment'];
        }

        $this->load->view('admin/member/regist', $this->data);
    }

    function memberRegistProcess(){
        $this->yield    = false;
        $this->form_validation->set_rules('idx', 'idx', 'required');
        $this->form_validation->set_rules('member_id', 'member_id', 'required');
        $this->form_validation->set_rules('passwd', 'passwd', 'required');
        $this->form_validation->set_rules('name', 'name', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $result_data['status']  = 'error';
        }

        $idx            = $this->input->post('idx') ?? "";
        $member_id      = $this->input->post('member_id') ?? "";
        $passwd         = $this->input->post('passwd') ?? "";
        $name           = $this->input->post('name') ?? "";
        $mento_yn       = $this->input->post('mento_yn') ?? "";
        $education      = $this->input->post('education') ?? "";
        $category_idx   = $this->input->post('category_idx') ?? "";
        $img_path       = $this->input->post('img_path') ?? "";
        $img_name       = $this->input->post('img_name') ?? "";
        $comment        = $this->input->post('comment') ?? "";
        $now_date       = date('Y-m-d h:i:s');
        $img_info       = array('img_path' => $img_path, 'img_name' => $img_name);
        $result_data    = array();

        if($mento_yn == 'N'){
            $education      = '';
            $category_idx   = 0;
            $img_path       = '';
            $img_name       = '';
            $comment        = '';
            $img_info       = array('img_path' => $img_path, 'img_name' => $img_name);
        }
        if( empty($idx) ){
            $data       = array(
                        'id'            => $member_id,
                        'passwd'        => $passwd,
                        'name'          => $name,
                        'mento_yn'      => $mento_yn,
                        'education'     => $education,
                        'category_idx'  => $category_idx,
                        'comment'       => $comment,
                        'reg_date'      => $now_date,
                        'img_info'      => json_encode($img_info, JSON_UNESCAPED_UNICODE)
                        );
            $result     = $this->member->insertMember($data);
            if($result){
                $result_data['status']  = 'success';
            }else{
                $result_data['status']  = 'error';
            }
        }else{
            $data       = array(
                        'id'            => $member_id,
                        'passwd'        => $passwd,
                        'name'          => $name,
                        'mento_yn'      => $mento_yn,
                        'education'     => $education,
                        'category_idx'  => $category_idx,
                        'comment'       => $comment,
                        'mod_date'      => $now_date,
                        'img_info'      => json_encode($img_info, JSON_UNESCAPED_UNICODE)
                        );
            $result     = $this->member->updateMember($idx, $data);
            if($result){
                $result_data['status']  = 'success';
            }else{
                $result_data['status']  = 'error';
            }
        }
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }
}