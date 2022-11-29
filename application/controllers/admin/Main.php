<?php
/**
 * Created by PhpStorm.
 * User: hoshy1207
 * Date: 2019-08-16
 * Time: 오후 1:03
 */

class Main extends CI_Controller{

    public function __construct(){
        parent::__construct();

        $this->common->checkLogin();
        $this->data['idx']              = $this->input->get_post('idx') ? $this->input->get_post('idx') : "";
        $this->data['search_name']      = $this->input->get_post('search_name') ? $this->input->get_post('search_name') : "";
        $this->data['search_cert']      = $this->input->get_post('search_cert') ? $this->input->get_post('search_cert') : "";
        $this->data['type']             = $this->input->get_post('type') ? $this->input->get_post('type') : "";
    }

    function index(){
        $this->load->view('admin/welcome', $this->data);
    }

    function regist(){

        $this->load->view('admin/media/regist', $this->data);
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
}