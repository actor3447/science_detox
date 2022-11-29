<?php
/**
 * Created by PhpStorm.
 * User: PDH
 * Date: 2022-07-29
 * Time: 오후 3:35
 */

class Media extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->common->checkLogin();
        $this->load->model('admin/M_media', 'media');
        $this->session->set_userdata(array('user_idx' => '1'));
    }

    function index(){
        $this->data['total_cnt']    = $this->media->selectContentsTotalCount();
        $this->data['result']       = $this->media->selectContentsList();

        $this->load->view('admin/media/index', $this->data);
    }

    function regist(){
        $this->data['idx']                  = $this->input->get_post('idx') ? $this->input->get_post('idx') : "";
        $this->data['title']                = '';
        $this->data['type']                 = '';
        $this->data['youtube_link']         = '';
        $this->data['category']             = $this->media->selectCategory();
        $this->data['hash_tag']             = '';
        $this->data['contents']             = '';
        $this->data['img_info']             = '';
        $this->data['edit_contents']        = '';

        if( !empty($this->data['idx']) ){
            $result                         = $this->media->selectContentsOne($this->data['idx']);
            $hash_tag                       = $this->media->selectHashTag($this->data['idx']);
            foreach($hash_tag as $tag){
                $this->data['hash_tag']     .= $tag['hash_tag'];
            }
            $this->data['title']            = $result['title'];
            $this->data['youtube_link']     = $result['youtube_link'];
            $this->data['type']             = $result['type'];
            $this->data['img_info']         = json_decode($result['img_info'], JSON_UNESCAPED_UNICODE);
            $this->data['edit_contents']    = $result['contents_info'];
        }

        $this->load->view('admin/media/regist', $this->data);
    }

    function contentsRegistProcess(){
        $this->yield    = false;
        $this->form_validation->set_rules('idx', 'idx', 'required');
        $this->form_validation->set_rules('type', 'type', 'required');
        $this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('hash_tag', 'hash_tag', 'required');
        $this->form_validation->set_rules('contents', 'contents', 'required');
        $this->form_validation->set_rules('img_path', 'img_path', 'required');
        $this->form_validation->set_rules('img_name', 'img_name', 'required');

        if ($this->form_validation->run() == FALSE){
            $result_data["status"] = "fail";
        }

        $idx            = $this->input->post('idx') ?? "";
        $hash_tag       = $this->input->post('hash_tag') ?? "";
        $title          = $this->input->post('title') ?? "";
        $type           = $this->input->post('type') ?? "";
        $contents_info  = $this->input->post('contents_info') ?? "";
        $youtube_link   = $this->input->post('youtube_link') ?? "";
        $img_path       = $this->input->post('img_path') ?? "";
        $img_name       = $this->input->post('img_name') ?? "";
        $img_info       = array('img_path' => $img_path, 'img_name' => $img_name);
        $now_date       = date('Y-m-d H:i:s');
        $user_ip        = $this->input->ip_address();

        $hash_tag_arr   = explode('#', preg_replace("/\s+/", "", $hash_tag));




        if( empty($idx) ){
            $data       = array(
                'title'         => $title,
                'type'          => $type,
                'contents_info' => $contents_info,
                'youtube_link'  => $youtube_link,
                'img_info'      => json_encode($img_info, JSON_UNESCAPED_UNICODE),
                'reg_date'      => $now_date,
                'reg_user_idx'  => $this->session->userdata('user_idx'),
                'reg_user_ip'   => $user_ip
            );
            $result     = $this->media->insertContents($data);
            foreach ($hash_tag_arr as $rows){
                if(!empty($rows)){
                    $hash_data  = array(
                                'contents_idx'  => $result,
                                'hash_tag'      => '#'.$rows
                                );
                    $this->media->insertHashTag($hash_data);
                }
            }
            if( !empty($result) ){
                $result_data['status']  = 'success';
            }else{
                $result_data['status']  = 'error';
            }
        }else{
            $data       = array(
                'title'         => $title,
                'type'          => $type,
                'contents_info' => $contents_info,
                'youtube_link'  => $youtube_link,
                'img_info'      => json_encode($img_info, JSON_UNESCAPED_UNICODE),
                'mod_date'      => $now_date,
                'mod_user_idx'  => $this->session->userdata('user_idx'),
                'mod_user_ip'   => $user_ip
            );
            $result     = $this->media->updateContents($idx, $data);
            $this->media->deleteHashTag($idx);
            foreach ($hash_tag_arr as $rows){
                if(!empty($rows)){
                    $hash_data  = array(
                        'contents_idx'  => $idx,
                        'hash_tag'      => '#'.$rows
                    );
                    $this->media->insertHashTag($hash_data);
                }
            }
            if( $result ){
                $result_data['status']  = 'success';
            }else{
                $result_data['status']  = 'error';
            }
        }
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function categoryRegistProcess(){
        $this->yield        = false;
        $category_arr       = $this->input->post('category') ?? array();
        $now_date           = date('Y-m-d H:i:s');
        $process_yn         = false;
        foreach ($category_arr as $rows){
            if( !empty($rows) ){
                $data       = array(
                    'name'      => $rows,
                    'reg_date'  => $now_date
                );
                $this->media->insertCategory($data);
                $process_yn  = true;
            }
        }

        if( $process_yn == true ){
            $result_data['status']  = 'success';
        }else{
            $result_data['status']  = 'error';
        }
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function deleteContentsProcess(){
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
        $result                 = $this->media->deleteContents($idx, $table);
        if($result){
            $this->media->deleteContentsLike($idx);
            $this->media->deleteContentsBookmark($idx);
            $this->media->deleteContentsHashTag($idx);
            $result_data["status"] = "success";
        }else{
            $result_data["status"] = "fail";
        }
        echo json_encode($result_data);
    }

    function eventXls(){

        $this->yield                    = FALSE;

        ini_set('memory_limit', '-1');
        header("Content-type: application/vnd.ms-excel");
        header("Content-type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename = inipass_event_list.xls");
        header("Content-Description: PHP4 Generated Data");

        $this->data['total_cnt']        = $this->M_main->selectAllEventCount();
        $this->data["result"]           = $this->M_main->selectAllEvent();

        $this->load->view('admin/event_xls', $this->data);
    }

    function curation(){
        $this->data['total_cnt']    = $this->media->selectContentsCurationTotalCount();
        $this->data['result']       = $this->media->selectContentsCurationList();

        $this->load->view('admin/media/curation', $this->data);
    }

    function curationRegist(){
        $this->data['idx']                  = $this->input->get_post('idx') ? $this->input->get_post('idx') : "";
        $this->data['title']                = '';
        $this->data['hash_tag']             = '';

        if( !empty($this->data['idx']) ){
            $result                         = $this->media->selectContentsCurationOne($this->data['idx']);
            $this->data['title']            = $result['title'];
            $this->data['hash_tag']         = $result['hash_tag'];
        }

        $this->load->view('admin/media/curation_regist', $this->data);
    }

    function curationRegistProcess(){
        $this->yield    = false;
        $this->form_validation->set_rules('idx', 'idx', 'required');
        $this->form_validation->set_rules('type', 'type', 'required');
        $this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('hash_tag', 'hash_tag', 'required');

        if ($this->form_validation->run() == FALSE){
            $result_data["status"] = "fail";
        }

        $idx            = $this->input->post('idx') ?? "";
        $hash_tag       = $this->input->post('hash_tag') ?? "";
        $title          = $this->input->post('title') ?? "";
        $now_date       = date('Y-m-d H:i:s');
        $user_ip        = $this->input->ip_address();

        $hash_tag_arr   = explode('#', preg_replace("/\s+/", "", $hash_tag));




        if( empty($idx) ){
            $data       = array(
                'title'         => $title,
                'hash_tag'      => preg_replace("/\s+/", "", $hash_tag),
                'reg_date'      => $now_date,
                'reg_user_idx'  => $this->session->userdata('user_idx'),
            );
            $result     = $this->media->insertContentsCuration($data);
            if( !empty($result) ){
                $result_data['status']  = 'success';
            }else{
                $result_data['status']  = 'error';
            }
        }else{
            $data       = array(
                'title'         => $title,
                'hash_tag'      => preg_replace("/\s+/", "", $hash_tag),
                'mod_date'      => $now_date,
                'mod_user_idx'  => $this->session->userdata('user_idx'),
            );
            $result     = $this->media->updateContentsCuration($idx, $data);
            if( $result ){
                $result_data['status']  = 'success';
            }else{
                $result_data['status']  = 'error';
            }
        }
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

}