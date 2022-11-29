<?php
/**
 * Created by PhpStorm.
 * User: PDH
 * Date: 2022-09-15
 * Time: 오후 11:13
 */

class Contents extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('M_api2', 'api2');
        $this->load->model('M_contents', 'contents');
        $this->data['search_field']         = $this->input->get_post('search_field') ? $this->input->get_post('search_field') : '';
        $this->data['search_text']          = $this->input->get_post('search_text') ? $this->input->get_post('search_text') : '';
        $this->data['page']                 = $this->input->get_post('page') ? $this->input->get_post('page') : 1;
        $this->data['device']               = $this->common->checkMobileLayout();
        if( $this->data['device'] == 'm_' ){
            $this->data['size']                 = $this->input->get_post('size') ? $this->input->get_post('size') : 4;
        }else{
            $this->data['size']                 = $this->input->get_post('size') ? $this->input->get_post('size') : 8;
        }
        $this->data['cur_page']             = $this->data['page'];

    }

    function index(){
        $this->data['tot_row']              = $this->contents->selectContentsCount();
        $this->data['tot_page'] 	        = ceil($this->data['tot_row']  /  $this->data['size'] );
        $this->data['cur_num']              = $this->data['tot_row'] - $this->data['size'] * ($this->data['cur_page'] - 1);
        $curation_hash_tag_list             = $this->contents->selectContentsCurationHashTagList();
        $next_prev                          = 2;
        foreach ($curation_hash_tag_list as $key => $value){
            $hash_tag_arr                   = array();
            $hash_tag                       = explode('#', $value['hash_tag']);
            foreach ($hash_tag as $rows){
                if( !empty($rows) ){
                    array_push($hash_tag_arr, '#'.$rows);
                }
            }
            $this->data['page']                                 = 1;
            $contents_list                                      = $this->contents->selectContentsHashTagList($hash_tag_arr);
            $curation_hash_tag_list[$key]['contents']           = $contents_list;
            $this->data['page']                                 = $next_prev;
            $contents_list_next_prev                            = $this->contents->selectContentsHashTagList($hash_tag_arr);
            $curation_hash_tag_list[$key]['contents_next_prev'] = count($contents_list_next_prev);
            unset($hash_tag_arr);
        }
        $this->data['page']                     = 1;
        $this->data['contents_list']            = $this->contents->selectContentsList();
        $this->data['contents_curation_list']   = $curation_hash_tag_list;
        $this->data['page']                     = $next_prev;
        $this->data['contents_list_next_prev']  = count($this->contents->selectContentsList());

        $this->load->view($this->data['device'].'contents', $this->data);
    }

    function moreMobileContents(){
        $this->yield                        = false;
        $user_idx                           = $this->input->post('user_idx') ?? "";
        $this->data['tot_row']              = $this->contents->selectContentsCount();
        $this->data['page']                 = $this->input->post('page') ?? "1";
        $this->data['tot_page'] 	        = ceil($this->data['tot_row']  /  $this->data['size'] );
        $this->data['cur_num']              = $this->data['tot_row'] - $this->data['size'] * ($this->data['cur_page'] - 1);
        $result                             = $this->contents->selectContentsList();
        $html                               = '';
        $button_html                        = '';
        $result_data                        = array();

        foreach ($result as $rows){
            $contents_img = json_decode($rows['img_info']);
            $html       .= '<li style="background-image:url('.$contents_img->img_path.'); background-size:cover; background-repeat:no-repeat;">';
            $html       .= '    <a href="/main?link_idx='.$rows['idx'].'" class="btn-category">';
            $html       .= '            <span class="title">'.$rows['title'].'</span>';
            $html       .= '    </a>';
            $html       .= '</li>';
        }

        if(!empty($result)){
            $count          = $this->data['page'] + 1;
            $button_html    .= '<button type="button" class="btn-more bg-white" onclick="moreMobileContents(\''.$count.'\')"><span>더 보기</span></button>';
        }else{
            $button_html    .= '';
        }

        $result_data['status']      = 'success';
        $result_data['html']        = $html;
        $result_data['btn_html']    = $button_html;
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function moreContents(){
        $this->yield                        = false;
        $user_idx                           = $this->input->post('user_idx') ?? "";
        $this->data['tot_row']              = $this->contents->selectContentsCount();
        $this->data['page']                 = $this->input->post('page') ?? "1";
        $this->data['tot_page'] 	        = ceil($this->data['tot_row']  /  $this->data['size'] );
        $this->data['cur_num']              = $this->data['tot_row'] - $this->data['size'] * ($this->data['cur_page'] - 1);
        $result                             = $this->contents->selectContentsList();
        $html                               = '';
        $button_html                        = '';
        $result_data                        = array();

        foreach ($result as $rows){
            $html       .= '<li class="result_box">';
            $html       .= '    <a href="/main?link_idx='.$rows['idx'].'">';
            $contents_img = json_decode($rows['img_info'], JSON_UNESCAPED_UNICODE);
            $html       .= '         <div class="result_img"><img src="'.$contents_img['img_path'].'" alt="'.$rows['title'].'"></div>';
            $html       .= '         <div class="result_txt">';
            $html       .= '            <p class="cont_title">'.$rows['title'].'</p>';
            $date       = explode(' ', $rows['reg_date']);
            $html       .= '            <span class="cont_date">'.$date[0].'</span>';
            $html       .= '         </div>';
            $html       .= '    </a>';
            $html       .= '</li>';
        }
        $next_prev          = $this->data['page'] + 1;
        $this->data['page'] = $next_prev;
        $next_result        = $this->contents->selectContentsList();
        if(!empty($next_result)){
            $button_html    .= '<button type="button" class="btn-more bg-white" onclick="moreContents(\''.$next_prev.'\')"><span>더 보기</span></button>';
        }else{
            $button_html    .= '';
        }

        $result_data['status']      = 'success';
        $result_data['html']        = $html;
        $result_data['btn_html']    = $button_html;
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function moreCurationContents(){
        $this->yield                        = false;
        $this->data['tot_row']              = $this->contents->selectContentsCount();
        $this->data['page']                 = $this->input->post('page') ?? "1";
        $hash_tag_text                      = $this->input->post('hash_tag') ?? "";
        $contents_idx                       = $this->input->post('contents_idx') ?? "";
        $this->data['tot_page'] 	        = ceil($this->data['tot_row']  /  $this->data['size'] );
        $this->data['cur_num']              = $this->data['tot_row'] - $this->data['size'] * ($this->data['cur_page'] - 1);
        $result                             = '';
        $html                               = '';
        $button_html                        = '';
        $result_data                        = array();
        $hash_tag_arr                       = array();
        $hash_tag                           = explode('#', $hash_tag_text);
        if( !empty( $hash_tag ) ){
            foreach ($hash_tag as $rows){
                if( !empty($rows) ){
                    array_push($hash_tag_arr, '#'.$rows);
                }
            }
            $result                         = $this->contents->selectContentsHashTagList($hash_tag_arr);
        }

        foreach ($result as $rows){
            $html           .= '<li class="result_box">';
            $html           .= '    <a href="/main?link_idx='.$rows['idx'].'">';
            $contents_img = json_decode($rows['img_info'], JSON_UNESCAPED_UNICODE);
            $html           .= '         <div class="result_img"><img src="'.$contents_img['img_path'].'" alt="'.$rows['title'].'"></div>';
            $html           .= '         <div class="result_txt">';
            $html           .= '            <p class="cont_title">'.$rows['title'].'</p>';
            $date           = explode(' ', $rows['reg_date']);
            $html           .= '            <span class="cont_date">'.$date[0].'</span>';
            $html           .= '         </div>';
            $html           .= '    </a>';
            $html           .= '</li>';
        }
        $next_prev          = $this->data['page'] + 1;
        $this->data['page'] = $next_prev;
        $next_result        = $this->contents->selectContentsHashTagList($hash_tag_arr);
        if(!empty($next_result)){
            $button_html    .= '<button type="button" class="btn-more bg-white" onclick="moreCurationContents(\''.$next_prev.'\', \''.$contents_idx.'\', \''.$hash_tag_text.'\')"><span>더 보기</span></button>';
        }else{
            $button_html    .= '';
        }

        $result_data['status']      = 'success';
        $result_data['html']        = $html;
        $result_data['btn_html']    = $button_html;
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function moreMobileCurationContents(){
        $this->yield                        = false;
        $user_idx                           = $this->input->post('user_idx') ?? "";
        $this->data['tot_row']              = $this->contents->selectContentsCount();
        $this->data['page']                 = $this->input->post('page') ?? "1";
        $hash_tag_text                      = $this->input->post('hash_tag') ?? "";
        $contents_idx                       = $this->input->post('contents_idx') ?? "";
        $this->data['tot_page'] 	        = ceil($this->data['tot_row']  /  $this->data['size'] );
        $this->data['cur_num']              = $this->data['tot_row'] - $this->data['size'] * ($this->data['cur_page'] - 1);
        $html                               = '';
        $button_html                        = '';
        $result                             = '';
        $result_data                        = array();
        $hash_tag_arr                       = array();
        $hash_tag                           = explode('#', $hash_tag_text);
        if( !empty( $hash_tag ) ){
            foreach ($hash_tag as $rows){
                if( !empty($rows) ){
                    array_push($hash_tag_arr, '#'.$rows);
                }
            }
            $result                         = $this->contents->selectContentsHashTagList($hash_tag_arr);
        }

        foreach ($result as $rows){
            $contents_img = json_decode($rows['img_info']);
            $html       .= '<li style="background-image:url('.$contents_img->img_path.'); background-size:cover; background-repeat:no-repeat;">';
            $html       .= '    <a href="/main?link_idx='.$rows['idx'].'" class="btn-category">';
            $html       .= '            <span class="title">'.$rows['title'].'</span>';
            $html       .= '    </a>';
            $html       .= '</li>';
        }
        $next_prev          = $this->data['page'] + 1;
        $this->data['page'] = $next_prev;
        $next_result        = $this->contents->selectContentsHashTagList($hash_tag_arr);
        if(!empty($next_result)){
            $button_html    .= '<button type="button" class="btn-more bg-white" onclick="moreMobileCurationContents(\''.$next_prev.'\', \''.$contents_idx.'\', \''.$hash_tag_text.'\')"><span>더 보기</span></button>';
        }else{
            $button_html    .= '';
        }

        $result_data['status']      = 'success';
        $result_data['html']        = $html;
        $result_data['btn_html']    = $button_html;
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }
}