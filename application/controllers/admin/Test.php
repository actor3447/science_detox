<?php
/**
 * Created by PhpStorm.
 * User: PDH
 * Date: 2022-08-31
 * Time: 오전 11:17
 */

class Test extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    #통합 로그인 URL
    #https://auth.dongascience.com/?referer_url={return URL (url_encode)}
    #https://mauth.dongascience.com/?referer_url={return URL (url_encode)}
    #샘플 parameter
    #key : ssoValue
    #value : YToxNjp7czo1OiJtZW1JZCI7czo4OiJ3b250b3A3NiI7czo2OiJ1c2VySWQiO3M6ODoid29udG9wNzYiO3M6NzoibWVtTmFtZSI7czo5OiLshqHsm5DsnqwiO3M6ODoibWVtRW1haWwiO3M6MjE6IndvbnRvcDcwNkBoYW5tYWlsLm5ldCI7czo5OiJjZWxscGhvbmUiO3M6MTM6IjAxMC0yNjY2LTMyMjIiO3M6NToibWVtQ2QiO3M6NzoiMDE4XzAwMiI7czo5OiJtZW1DZE5hbWUiO3M6MTI6IuydvOuwmO2ajOybkCI7czo5OiJsb2dpblRpbWUiO2k6MTY2MTczOTkwNztzOjk6InNlc3Npb25JZCI7czo2NDoiMzY1YzZjNjkzZjgzODNmMzc5YzVkNDRmZmY2OWM3NmM2NmQzOTFjNmEwM2QzMzhjMjMzMWEyZTUzOTM4Y2FhNiI7czoxMToicGVyaW9kU3RhdGUiO2I6MTtzOjEyOiJvcmRlclBlcmlvZEQiO3M6MTY6IjIwMTkwMTAxMjAyNTEyMzEiO3M6MTI6Im9yZGVyUGVyaW9kTSI7czoxNjoiMjAxOTAxMDEyMDI1MTIzMSI7czoxMjoib3JkZXJQZXJpb2RDIjtzOjE2OiIwMDAwMDAwMDAwMDAwMDAwIjtzOjEyOiJvcmRlclBlcmlvZE4iO3M6MTY6IjIwMjEwMTAxMjAzMDEyMzEiO3M6MTI6Im9yZGVyTWVtVHlwZSI7czoxOiJQIjtzOjc6Im1lbVR5cGUiO3M6MToiUiI7fQ==
    #callback : ex) www.scitalks.co.kr/sso
    public function index()
    {
        // ssoValue decode
        $sso_value = $this->input->get('ssoValue');
        $sso_arr = unserialize(base64_decode($sso_value));

        $user_id        = $sso_arr['userId'];
        $session_id     = $sso_arr['sessionId'];
        $period_state   = $sso_arr['periodState'];
        $order_period_d = $sso_arr['orderPeriodD'];
        $order_period_m = $sso_arr['orderPeriodM'];
        $order_period_c = $sso_arr['orderPeriodC'];
        $order_period_n = $sso_arr['orderPeriodN'];
        $order_mem_type = $sso_arr['orderMemType'];
        $mem_type       = $sso_arr['memType'];


        $retUrl = $this->input->get('retUrl');
        if($retUrl) {
            header("Location: ".$retUrl);
        } else {
            header("Location: /");
        }
    }

    #통합 로그아웃 URL
    #https://auth.dongascience.com//logout.php?referer_url={return URL (url_encode)}
    #https://mauth.dongascience.com/logout.php?referer_url={return URL (url_encode)}
    #callback : ex) www.scitalks.co.kr/sso/logout
    public function logout()
    {
        header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');

        $this->session->unset_userdata("ID");
        $this->session->unset_userdata("NAME");
        $this->session->unset_userdata("EMAIL");
        $this->session->unset_userdata("TEL");
        $this->session->unset_userdata("CELLPHONE");
        $this->session->unset_userdata("MEMBER_NAME");
        $this->session->unset_userdata("STAFF");
        $this->session->unset_userdata("periodState");
        $this->session->unset_userdata("orderPeriodD");
        $this->session->unset_userdata("orderPeriodM");
        $this->session->unset_userdata("orderPeriodC");
        $this->session->unset_userdata("memType");
        $this->session->unset_userdata("orderMemType");

        $retUrl = $this->input->get('retUrl');
        if($retUrl) {
            header("Location: ".$retUrl);
        } else {
            header("Location: /");
        }
    }
}