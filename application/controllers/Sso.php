<?php
/**
 * Created by PhpStorm.
 * User: PDH
 * Date: 2022-07-28
 * Time: 오후 2:41
 */

class Sso extends CI_Controller{
    public function __construct(){
        parent::__construct();
        error_reporting(-1);
        ini_set('display_errors', 1);
        $this->load->model('M_common', 'm_common');
        $this->yield    = false;
    }

    public function index(){
        $sso_value      = $this->input->get('ssoValue');
        $sso_arr        = unserialize(base64_decode($sso_value));
	    session_regenerate_id(true);
        $this->session->set_userdata($sso_arr);
        $user_data   = $this->session->userdata();
        if(!empty($user_data['userId'])) {
            $user_cnt = $this->m_common->selectUserCnt($user_data['userId']);
            $now_date = date('Y-m-d H:i:s');
            if ($user_cnt <= 0) {
                $data = array(
                    'id' => $user_data['userId'],
                    'category_idx'  => 0,
                    'name' => $user_data['memName'],
                    'email' => $user_data['memEmail'],
                    'phone' => $user_data['cellphone'],
                    'reg_date' => $now_date,
                    'last_login_date' => $now_date
                );
                $this->m_common->insertUser($data);
            } else {
                $data = array(
                    'id' => $user_data['userId'],
                    'name' => $user_data['memName'],
                    'email' => $user_data['memEmail'],
                    'phone' => $user_data['cellphone'],
                    'last_login_date' => $now_date
                );
                $this->m_common->updateUser($user_data['userId'], $data);
            }
            $user_info = $this->m_common->selectUserOne($user_data['userId']);
            if (!empty($user_info)) {
                $session_info = array(
                    'user_idx' => $user_info['idx'],
                    'user_name' => $user_info['name'],
                    'user_email' => $user_info['email'],
                    'user_phone' => $user_info['phone'],
                    'user_school' => $user_info['school'],
                    'user_address' => $user_info['address'],
                    'last_login' => $user_info['last_login_date'],
                    'is_login' => 'Y',
                );
                $this->session->set_userdata($session_info);
            }
        }
        header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
        $retUrl = $this->input->get('retUrl');
        if($retUrl) {
            header("Location: ".$retUrl);
        } else {
            header("Location: /");
        }
    }

    public function logout(){
        header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
	    $this->session->sess_destroy();
        $retUrl = $this->input->get('retUrl');
        if($retUrl) {
            header("Location: ".$retUrl);
        } else {
            header("Location: /");
        }
    }
}
