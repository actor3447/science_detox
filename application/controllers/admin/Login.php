<?php

class Login extends CI_Controller{

    public function __construct(){
        parent::__construct();

        $this->yield        = FALSE;
        $this->load->model('admin/M_login');
    }

    function index(){
        $this->load->view('admin/login');
    }

    function loginProcess(){
        $admin_id                     = $this->input->post('admin_id');
        $admin_pwd                    = $this->input->post('admin_pwd');

        $data = array(
            "id"  => $admin_id,
            "pwd" => $admin_pwd,
        );
        $admin = $this->M_login->selectAdmin($data);
        $result  = array("status" => "fail");
        if (isset($admin)){
            $data = array(
                'is_admin'          => 'Y',
                'admin_id'          => $admin["id"],
                'admin_idx'         => $admin["idx"],
                'admin_name'        => $admin["name"],
            );
            $this->session->set_userdata($data);
            $result = array("status" => "success");

        }
        echo json_encode($result);
    }

    function logout(){
        $this->session->sess_destroy();
        redirect("/admin/login");
    }
}