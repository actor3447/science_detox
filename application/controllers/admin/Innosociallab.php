<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Innosociallab extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('admin/m_innosociallab');
        $this->data['idx']                      = $this->input->get_post('idx') ? $this->input->get_post('idx') : "";
        $this->common->checkLogin();
        $this->data['manager_idx']              = $this->session->userdata('manager_idx');
        $this->data['category_entry']           = "SPT";
        $this->data['agency_entry']             = "MDP";
        $this->data['recruit_status']           = array("Y" => "모집예정", "I" => "모집중", "E" => "마감" ,"" => "외부기관");
        $this->data['season']                   = $this->input->get('season') ?? 1;
    }

    public function index()
    {
        $this->data['result']                   = $this->m_innosociallab->selectInternshipList();
        $this->data['total_cnt']                = count($this->data['result']);
        $this->load->view('/admin/innosociallab/index', $this->data);
    }

    public function regist()
    {
        $this->data['idx']                              = $this->input->get_post('idx') ? $this->input->get_post('idx') : "";
        $this->data['company_name']                     = "";#업체명
        $this->data['sido']                             = "";#시도
        $this->data['gugun']                            = "";#구군
        $this->data['homepage']                         = "";#홈페이지
        $this->data['intro']                            = "";#회사소개
        $this->data['email']                            = "";#이메일
        $this->data['tel']                              = "";#전화번호
        $this->data['employ_period']                    = "";#근무기간
        $this->data['job_desc']                         = "";#업무내용
        $this->data['qualifications']                   = "";#자격요건
        $this->data['preferential']                     = "";#우대사항
        $this->data['location']                         = "";#근무위치
        $this->data['welfare']                          = "";#복리후생
        $this->data['reg_date']                         = "";
        $this->data['status']                           = "Y";
        $this->data['job']                              = "";#직무
        $this->data['job_category']                     = "";#업종
        $this->data['category']                         = "";#카테고리 (장애인, 경력보유여성...)
        $this->data['mission']                          = "";#기업 소설 미션
        $this->data['apply']                            = "";#지원서 접수 방법
        $this->data['step']                             = "";#지원 절차
//        $this->data['attached_file_path']               = "";
//        $this->data['attached_file_name']               = "";
        if($this->data['idx'] != ""){
            $result                                 = $this->m_innosociallab->selectInternshipOne($this->data['idx']);
            $this->data['season']                   = $result['season'];
            $this->data['company_name']             = $result['company_name'];
            $this->data['sido']                     = $result['sido'];
            $this->data['gugun']                    = $result['gugun'];
            $this->data['intro']                    = $result['intro'];
            $this->data['homepage']                 = $result['homepage'];
            $this->data['email']                    = $result['email'];
            $this->data['tel']                      = $result['tel'];
            $this->data['employ_period']            = $result['employ_period'];
            $this->data['job_desc']                 = $result['job_desc'];
            $this->data['qualifications']           = $result['qualifications'];
            $this->data['preferential']             = $result['preferential'];
            $this->data['location']                 = $result['location'];
            $this->data['welfare']                  = $result['welfare'];
            $this->data['reg_date']                 = $result['reg_date'];
            $this->data['status']                   = $result['status'];
            $this->data['job']                      = $result['job'];
            $this->data['job_category']             = $result['job_category'];
            $this->data['category']                 = $result['category'];
            $this->data['mission']                  = $result['mission'];
            $this->data['apply']                    = $result['apply'];
            $this->data['step']                     = $result['step'];
//            $this->data['attached_file_path']       = $result['attached_file_path'];
//            $this->data['attached_file_name']       = $result['attached_file_name'];
        }

        $this->load->view('admin/innosociallab/regist', $this->data);

    }

    function registProcess(){

        $this->yield = false;
        $result_data = array();
        $data        = array();

        $data["idx"]                    = $this->input->post('idx') ?? "";
        $data["category"]               = $this->input->post('category') ?? "";
        $data["company_name"]           = $this->input->post('company_name') ?? "";
        $data["sido"]                   = $this->input->post('sido') ?? "";
        $data["gugun"]                  = $this->input->post('gugun') ?? "";
        $data["homepage"]               = $this->input->post('homepage') ?? "";
        $data["intro"]                  = $this->input->post('intro') ?? "";
        $data["email"]                  = $this->input->post('email') ?? "";
        $data["tel"]                    = $this->input->post('tel') ?? "";
        $data["employ_period"]          = $this->input->post('employ_period') ?? "";
        $data["job_desc"]               = $this->input->post('job_desc') ?? "";
        $data["qualifications"]         = $this->input->post('qualifications') ?? "";
        $data["preferential"]           = $this->input->post('preferential') ?? "";
        $data["location"]               = $this->input->post('location') ?? "";
        $data["welfare"]                = $this->input->post('welfare') ?? "";
        $data["job"]                    = $this->input->post('job') ?? "";
        $data["job_category"]           = $this->input->post('job_category') ?? "";
        $data['season']                 = $this->input->post('season') ?? 1;
        $data['mission']                = $this->input->post('mission') ?? 1;
        $data['apply']                  = $this->input->post('apply') ?? 1;
        $data['step']                   = $this->input->post('step') ?? 1;
//        $data["attached_file_path"]     = $this->input->post('attached_file_path') ?? "";
//        $data["attached_file_name"]     = $this->input->post('attached_file_name') ?? "";

        if ($data['idx'] != "") {
            $result = $this->m_innosociallab->updateInternship($data, $data["idx"] );

        } else {
            $data['reg_date'] = date('Y-m-d h:i:s');;
            $result = $this->m_innosociallab->insertInternship($data);

        }
        if ($result) {
            $result_data["status"] = "success";
        } else {
            $result_data["status"] = "fail";
        }

        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function deleteProcess(){

        $this->yield            = false;
        $result_data            = array();
        $data                   = array();
        $idx                    = $this->input->post('idx') ?? "";
        $data["status"]         = "N";
        $result                 = $this->m_innosociallab->updateInternship($data, $idx);

        if($result){
            $result_data["status"] = "success";
        }else{
            $result_data["status"] = "fail";
        }
        echo json_encode($result_data);

    }

}
