<?php
/**
 * Created by PhpStorm.
 * User: PDH
 * Date: 2022-09-05
 * Time: 오후 6:44
 */

class Api2 extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->yield    = false;
        $this->load->model('M_Api2', 'api2');
    }

    function getContentsList(){
        $idx            = $this->input->post('idx') ?? "";
        $contents       = $this->api2->selectContentsOne($idx);
        $result_status  = array();
        $footer_html    = '';
        if(!empty($contents)){
            $result_status['header_text']   = $contents['title'];
            $img_info                       = json_decode($contents['img_info'], JSON_UNESCAPED_UNICODE);
            $result_status['img_src']       = $img_info['img_path'];
            $result_status['body_text']     = $contents['contents_info'];
            $footer_html                    .= '<ul class="relation-group">';
            $footer_html                    .= '    <li>';
            $footer_html                    .= '        <a href="" class="btn-relation">';
            $footer_html                    .= '            <span class="relation-photo">';
            $footer_html                    .= '                <img src="/public/images/thum0_relation_photo0.png" alt="콘텐츠 제목1">';
            $footer_html                    .= '            </span>';
            $footer_html                    .= '        <span class="relation-title">콘텐츠 제목1</span>';
            $footer_html                    .= '        </a>';
            $footer_html                    .= '    </li>';
            $footer_html                    .= '</ul>';
            $result_status['footer_html']   = $footer_html;
            $result_status['status']        = 'success';
        }
        echo json_encode($result_status, JSON_UNESCAPED_UNICODE);
    }

    function test(){
        echo 1111;
        exit;
    }
}