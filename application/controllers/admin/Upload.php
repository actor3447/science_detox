<?php

class Upload extends CI_Controller{

    function __construct(){

        parent::__construct();
        $this->yield    = FALSE;
        $this->data['upload_path']  = $this->config->item('upload_path');
    }

    function fileUpload(){
        $folder                     = "upload";
        $img_name                   = "file-0";
        $yy                         = date('Y');
        $mm                         = date('m');
        $dd                         = date('d');
        $img_path                   = '/public/' . $folder .'/' . $yy.'/'.$mm.'/'.$dd.'/';
        $config['upload_path']      = APPPATH . '../public/' . $folder . '/' . $yy.'/'.$mm.'/'.$dd.'/';
        $config['allowed_types']    = '*';
        $config['max_size']         = '30720';
        $config['encrypt_name']     = true;
        $config['remove_spaces']    = true;

        if(!is_dir($config['upload_path'])){
            mkdir($config['upload_path'] , 0777, true);
        }

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        $this->upload->do_upload($img_name);
        if ($this->upload->display_errors() != '') {
            //에러메세지 있을 때
            $result          = array("status" => "error");

        } else {
            $data 			 = $this->upload->data();
            $result 		 = array("status" => "success", "img_path" => $img_path . $data['file_name'], "img_name" => $data['orig_name']);
        }
        echo json_encode($result);
    }

    function chatbotFileUpload(){
        $folder                     = "upload";
        $img_name                   = "file-0";
        $today                      = date('Ymd');
        $img_path                   = '/public/' . $folder .'/' . $today . '/chatbot_data/';
        $config['upload_path']      = APPPATH . '../public/' . $folder . '/' . $today . '/chatbot_data/';
        $config['allowed_types']    = 'csv';
        $config['max_size']         = '30720';
        $config['remove_spaces']    = true;

        if(!is_dir($config['upload_path'])){
            mkdir($config['upload_path'] , 0777, true);
        }

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        $this->upload->do_upload($img_name);
        if ($this->upload->display_errors() != '') {
            //에러메세지 있을 때
            $result          = array("status" => "error");

        } else {
            $data 			 = $this->upload->data();
            $result 		 = array("status" => "success", "file_path" => $img_path . $data['file_name'], "file_name" => $data['orig_name']);
        }
        echo json_encode($result);
    }

    function imageUpload(){
        $folder                     = "upload";
        $img_name                   = "file-0";
        $today                      = date('Ymd');
        $img_path                   = '/public/' . $folder .'/' . $today . '/';
        $config['upload_path']      = APPPATH . '../public/' . $folder . '/' . $today . '/';
        $config['allowed_types']    = 'gif|jpg|jpeg|png';
        $config['max_size']         = '30720';
        $config['encrypt_name']     = true;
        $config['remove_spaces']    = true;

        if(!is_dir($config['upload_path'])){
            mkdir($config['upload_path'] , 0777, true);
        }

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        $this->upload->do_upload($img_name);
        if ($this->upload->display_errors() != '') {
            //에러메세지 있을 때
            $result          = array("status" => "error");

        } else {
            $data 			 = $this->upload->data();
            $result 		 = array("status" => "success", "img_path" => $img_path . $data['file_name'], "img_name" => $data['orig_name']);
        }
        echo json_encode($result);
    }

    // 에디터 파일 업로드
    function procImageUpload(){
        $folder                     = "upload";
        $today                      = date('Ymd');
        $img_path                   = '/public/' . $folder .'/' . $today . '/';
        $config['upload_path']      = APPPATH . '../public/' . $folder . '/' . $today . '/';
        $config['allowed_types']    = 'gif|jpg|jpeg|png';
        $config['max_size']         = '30720';
        $config['encrypt_name']     = TRUE;

        $this->load->library('upload', $config);

        if(!is_dir($config['upload_path'])){
            mkdir($config['upload_path'] , 0777,true);
        }

        if ( !$this->upload->do_upload('file')){
            $result          = array("status" => "error" , "message" => $this->upload->display_errors());
        } else{
            $data       = $this->upload->data();
            $result 		 = array("status" => "success" , "file_src" => $img_path.$data['file_name'] , "file_name" => $data['orig_name'], "file_size" => $data['file_size']);
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}