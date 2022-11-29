<?php
/**
 * Created by PhpStorm.
 * User: hoshy1207
 * Date: 2018-08-20
 * Time: 오전 10:58
 */

class Upload extends CI_COntroller{

    function __construct(){

        parent::__construct();
        $this->yield    = FALSE;

    }



    function uploadImage(){

        $folder                     = "upload";
        $image_name                 = 'file-0';
        $yy                         = date('Y');
        $mm                         = date('m');
        $dd                         = date('d');
        $image_path                 = $yy.'/'.$mm.'/'.$dd.'/';
        $config['upload_path']      = APPPATH.'../public/'.$folder.'/'.$yy.'/'.$mm.'/'.$dd.'/';
        $config['allowed_types']    = 'gif|jpg|jpeg|png';
        $config['encrypt_name']     = TRUE;
        if(!is_dir($config['upload_path'])){
            mkdir($config['upload_path'] , 0777,true);
        }


        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->do_upload($image_name);
        $data 			 = $this->upload->data();


        if ($this->upload->display_errors() != '') {
            $result          = array("status" => "error" , "msg" => $this->upload->display_errors());
        }else{
            $result 		 = array("status" => "success" , "image_src" =>  '/public/'. $folder . '/' .$image_path.$data['file_name'] , "image_name" => $data['orig_name'], "image_height" => $data['image_height'], "image_width" => $data['image_width']);
        }
        echo json_encode($result);
    }


    function debate(){
        $this->load->model('M_debate', 'm_debate');
        $folder                     = "debate";
        $check_login                = $this->common->checkUserLogin();
        if ($check_login){
            $file_name                  = 'audio_data';
            $room_idx                   = $this->input->post('room_idx');
            $duration                   = $this->input->post('duration');
            $file_path                  = '/public/'.$folder.'/'.$room_idx.'/';
            $config['upload_path']      = APPPATH.'../public/'.$folder.'/'.$room_idx.'/';
            $config['allowed_types']    = 'wav';
            $config['encrypt_name']     = false;
            $config['file_name']        = $this->session->userdata('user_idx'). '_' . $_FILES['audio_data']['name'];
            $config['max_size']         = '10240';

            if(!is_dir($config['upload_path'])){
                mkdir($config['upload_path'] , 0777,true);
            }

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            $this->upload->do_upload($file_name);
            $data = $this->upload->data();
            if ($this->upload->display_errors() != '') {
                $result          = array("status" => "error" , "msg" => $this->upload->display_errors());
            }else{
                $insert_data = array(
                    "type"              => 'voice',
                    "debate_room_idx"   => $room_idx,
                    "user_idx"          => $this->session->userdata('user_idx'),
                    "message"           => $file_path . $data['file_name'],
                    "duration"          => $duration,
                    "reg_date"          => date('Y-m-d h:i:s')
                );
                $this->m_debate->insertDebateMessage($insert_data);
                $result  = array("status" => "success" , "file_src" =>  $file_path . $data['file_name'] , "file_name" => $data['orig_name']);
            }

        }else{
            $result  = array("status" => "logout");
        }

        echo json_encode($result);
    }

    function userImageUpload(){
        $this->load->model('m_api2', 'api2');
        $folder                     = "upload";
        $image_name                 = 'file-0';
        $user_idx                   = $this->input->post('user_idx') ?? "";
        $today                      = date('Ymd');
        $img_path                   = '/public/' . $folder .'/' . $today . '/';
        $config['upload_path']      = APPPATH . '../public/' . $folder . '/' . $today . '/';
        $config['allowed_types']    = 'gif|jpg|jpeg|png';
        $config['encrypt_name']     = TRUE;
        if(!is_dir($config['upload_path'])){
            mkdir($config['upload_path'] , 0777,true);
        }

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->do_upload($image_name);
        $data 			    = $this->upload->data();
        $img_data           = array('img_path'  => $img_path.$data['file_name']);
        $insert_result      = $this->api2->updateUserImage($user_idx, $img_data);

        if( $insert_result ){
            if ($this->upload->display_errors() != '') {
                $result          = array("status" => "error" , "msg" => $this->upload->display_errors());
            }else{
                $result 		 = array("status" => "success" , "image_src" =>  $img_path.$data['file_name'] , "image_name" => $data['orig_name'], "image_height" => $data['image_height'], "image_width" => $data['image_width']);
            }
        }else{
            $result['status']   = 'update_error';
        }
        echo json_encode($result);
    }
}