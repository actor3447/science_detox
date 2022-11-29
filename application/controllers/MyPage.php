<?php
/**
 * Created by PhpStorm.
 * User: PDH
 * Date: 2022-09-14
 * Time: 오후 4:09
 */

class MyPage extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $login_yn       = $this->common->loginUserCheck();
        if( $login_yn == 0 ){
            echo '<script>alert("로그인 후 이용 바랍니다.")</script>';
            echo '<script>location.href="https://auth.dongascience.com/?referer_url='.urlencode(CURRENT_URI).'"</script>';
//            redirect('https://auth.dongascience.com/?referer_url='.urlencode(CURRENT_URI).'');
        }
        $this->load->model('M_mypage', 'mypage');
        $this->load->model('M_api', 'api');
        $this->data['page']                 = $this->input->get_post('page') ? $this->input->get_post('page') : 1;
        $this->data['size']                 = $this->input->get_post('size') ? $this->input->get_post('size') : 4;
        $this->data['cur_page']             = $this->data['page'];
    }

    function index(){
        $is_login                   = $this->common->loginUserCheck();
        $this->data['user_idx']     = '';
        $this->data['user_name']    = '';
        $this->data['user_email']   = '';
        $this->data['user_phone']   = '';
        $this->data['user_school']  = '';
        $this->data['user_address'] = '';
        $this->data['user_category']= '';
        $this->data['category']     = $this->api->selectDebateCategory();
        if($is_login){
            $user_data  = $this->mypage->selectUserOne($this->session->userdata('user_idx'));
            $this->data['user_idx']                 = $user_data['idx'];
            $this->data['user_nickname']            = $user_data['nickname'];
            $this->data['user_img']                 = $user_data['img_path'];
            $this->data['user_name']                = $user_data['name'];
            $this->data['user_email']               = $user_data['email'];
            $this->data['user_phone']               = $user_data['phone'];
            $this->data['user_address']             = $user_data['address'];
            $this->data['user_school']              = $user_data['school'];
            $this->data['user_category']            = $user_data['category_idx'];
            $this->data['like_contents']            = $this->mypage->selectLikeContentsList($user_data['idx']);
            $this->data['bookmark_contents']        = $this->mypage->selectBookmarkList($user_data['idx']);
            $this->data['mento_question']           = $this->mypage->selectMentoQnaList($user_data['idx']);
            $this->data['debate_room']              = $this->mypage->selectDebateRoomList($user_data['idx']);
            $this->data['page']                     = 2;
            $this->data['bookmark_contents_next_btn']   = $this->mypage->selectBookmarkList($user_data['idx']);
            $this->data['mento_question_next_btn']      = $this->mypage->selectMentoQnaList($user_data['idx']);
            $this->data['debate_room_next_btn']         = $this->mypage->selectDebateRoomList($user_data['idx']);
        }

        $this->load->view($this->common->checkMobileLayout().'mypage', $this->data);
    }

    function moreLikeContents(){
        $this->yield                        = false;
        $user_idx                           = $this->input->post('user_idx') ?? "";
        $this->data['tot_row']              = $this->mypage->selectLikeContentsCount($user_idx);
        $this->data['page']                 = $this->input->post('page') ?? "1";
        $this->data['tot_page'] 	        = ceil($this->data['tot_row']  /  $this->data['size'] );
        $this->data['cur_num']              = $this->data['tot_row'] - $this->data['size'] * ($this->data['cur_page'] - 1);
        $result                             = $this->mypage->selectLikeContentsList($user_idx);
        $html                               = '';
        $button_html                        = '';
        $result_data                        = array();

        foreach ($result as $rows){
            $html       .= '<li>';
            $html       .= '<a href="/main?link_idx='.$rows['idx'].'">';
            $html       .= '    <div class="myfavor-group">';
            $contents_img = json_decode($rows['img_info']);
            $html       .= '         <div class="myfavor-heading" style="background: url('.$contents_img->img_path.') no-repeat; background-position: center center; background-size: cover;">';
            $html       .= '         </div>';
            $html       .= '         <div class="myfavor-body">';
            $html       .= '            <div class="myfavor-title">'.$rows['title'].'</div>';
            $html       .= '            <div class="myfavor-explain multiline">';
            $html       .= '                 '.strip_tags($rows['contents_info']).'';
            $html       .= '            </div>';
            $html       .= '         </div>';
            $date       = explode(' ', $rows['reg_date']);
            $html       .= '         <div class="myfavor-footer">'.$date[0].'</div>';
            $html       .= '    </div>';
            $html       .= '</a>';
            $html       .= '</li>';
        }

        if(!empty($result)){
            $count          = $this->data['page'] + 1;
            $button_html    .= '<button type="button" class="btn-more" onclick="moreLikeContents(\''.$count.'\')"><span>더보기</span></button>';
        }else{
            $button_html    .= '';
        }

        $result_data['status']      = 'success';
        $result_data['html']        = $html;
        $result_data['btn_html']    = $button_html;
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function moreMentoQuestion(){
        $this->yield                        = false;
        $user_idx                           = $this->input->post('user_idx') ?? "";
        $this->data['tot_row']              = $this->mypage->selectMentoQnaCount($user_idx);
        $this->data['page']                 = $this->input->post('page') ?? "1";
        $this->data['tot_page'] 	        = ceil($this->data['tot_row']  /  $this->data['size'] );
        $this->data['cur_num']              = $this->data['tot_row'] - $this->data['size'] * ($this->data['cur_page'] - 1);
        $result                             = $this->mypage->selectMentoQnaList($user_idx);
        $html                               = '';
        $button_html                        = '';
        $result_data                        = array();

        foreach ($result as $rows){
            $html       .= '<li>';
            $html       .= '    <div class="myqna-group">';
            $html       .= '        <div class="myqna-heading">';
            $html       .= '            <div class="myqna-qustion">';
            $html       .= '                <span class="flag">Q.&nbsp;</span>';
            $html       .= '                <span class="txt">'.$rows['content'].'</span>';
            $html       .= '            </div>';
            $html       .= '            <div class="myqna-answer">';
            $html       .= '                <span class="flag">A.&nbsp;</span>';
            $html       .= '                <span class="txt">'.$rows['request_content'].'</span>';
            $html       .= '            </div>';
            $html       .= '        </div>';
            $html       .= '        <div class="myqna-body">';
            if( $rows['request_yn'] == 'Y' ){
                $html       .= '        <div class="myqna-result">';
                $html       .= '            <div class="btn-answer"><span>답변완료</span></div>';
                $html       .= '        </div>';
            }else{
                $html       .= '        <div class="myqna-result">';
                $html       .= '            <div class="btn-answer no"><span>답변 미완료</span></div>';
                $html       .= '        </div>';
            }
            $date     = explode(' ', $rows['reg_date']);
            $html       .= '            <div class="myqna-date">'.$date[0].'</div>';
            $html       .= '        </div>';
            $html       .= '    </div>';
            $html       .= '</li>';
        }
        $count              = $this->data['page'] + 1;
        $this->data['page'] = $count;
        $btn_result         = $this->mypage->selectMentoQnaList($user_idx);
        if(!empty($btn_result)){
            $button_html    .= '<button type="button" class="btn-more" onclick="moreMentoQuestion(\''.$count.'\')"><span>더보기</span></button>';
        }else{
            $button_html    .= '';
        }

        $result_data['status']      = 'success';
        $result_data['html']        = $html;
        $result_data['btn_html']    = $button_html;
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function moreBookmark(){
        $this->yield                        = false;
        $user_idx                           = $this->input->post('user_idx') ?? "";
        $this->data['tot_row']              = $this->mypage->selectBookmarkCount($user_idx);
        $this->data['page']                 = $this->input->post('page') ?? "1";
        $this->data['tot_page'] 	        = ceil($this->data['tot_row']  /  $this->data['size'] );
        $this->data['cur_num']              = $this->data['tot_row'] - $this->data['size'] * ($this->data['cur_page'] - 1);
        $result                             = $this->mypage->selectBookmarkList($user_idx);
        $html                               = '';
        $button_html                        = '';
        $result_data                        = array();

        foreach ($result as $rows){
            $html       .= '<li>';
            $html       .= '<a href="/main?link_idx='.$rows['idx'].'">';
            $html       .= '    <div class="mybookmark-group">';
            $contents_img = json_decode($rows['img_info']);
            $html       .= '         <div class="mybookmark-heading" style="background: url('.$contents_img->img_path.') no-repeat; background-position: center center; background-size: cover;">';
            $html       .= '         </div>';
            $html       .= '         <div class="mybookmark-body">';
            $html       .= '            <div class="mybookmark-title">'.$rows['title'].'</div>';
            $html       .= '            <div class="mybookmark-explain multiline" style="display: none">';
            $html       .= '                 '.strip_tags($rows['contents_info']).'';
            $html       .= '            </div>';
            $html       .= '         </div>';
            $date       = explode(' ', $rows['reg_date']);
            $html       .= '         <div class="mybookmark-footer">'.$date[0].'</div>';
            $html       .= '    </div>';
            $html       .= '</a>';
            $html       .= '</li>';
        }
        $count              = $this->data['page'] + 1;
        $this->data['page'] = $count;
        $btn_result         = $this->mypage->selectBookmarkList($user_idx);
        if(!empty($btn_result)){
            $button_html    .= '<button type="button" class="btn-more" onclick="moreBookmark(\''.$count.'\')"><span>더보기</span></button>';
        }else{
            $button_html    .= '';
        }

        $result_data['status']      = 'success';
        $result_data['html']        = $html;
        $result_data['btn_html']    = $button_html;
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function moreDebateRoom(){
        $this->yield                        = false;
        $user_idx                           = $this->input->post('user_idx') ?? "";
        $this->data['tot_row']              = $this->mypage->selectDebateRoomCount($user_idx);
        $this->data['page']                 = $this->input->post('page') ?? "1";
        $this->data['tot_page'] 	        = ceil($this->data['tot_row']  /  $this->data['size'] );
        $this->data['cur_num']              = $this->data['tot_row'] - $this->data['size'] * ($this->data['cur_page'] - 1);
        $result                             = $this->mypage->selectDebateRoomList($user_idx);
        $html                               = '';
        $button_html                        = '';
        $result_data                        = array();

        foreach ($result as $rows){
            $html       .= '<li>';
            $html       .= '    <a href="/debate/chat?room_idx='.$rows['idx'].'">';
            $html       .= '        <div class="mydebate-group">';
            $html       .= '            <div class="mydebate-heading" style="background: url('.$rows['img_path'].') no-repeat; background-position: center center; background-size: cover;"></div>';
            $html       .= '            <div class="mydebate-body">';
            $html       .= '                <div class="mydebate-title">'.$rows['category'].'</div>';
            $html       .= '                <div class="mydebate-detail">'.$rows['title'].'</div>';
            $html       .= '                ';
            $html       .= '            </div>';
            $date       = explode(' ', $rows['reg_date']);
            $html       .= '            <div class="mydebate-footer">'.$date[0].'</div>';
            $html       .= '        </div>';
            $html       .= '    </a>';
            $html       .= '</li>';
        }
        $count              = $this->data['page'] + 1;
        $this->data['page'] = $count;
        $btn_result         = $this->mypage->selectDebateRoomList($user_idx);
        if(!empty($btn_result)){
            $button_html    .= '<button type="button" class="btn-more" onclick="moreDebateRoom(\''.$count.'\')"><span>더보기</span></button>';
        }else{
            $button_html    .= '';
        }

        $result_data['status']      = 'success';
        $result_data['html']        = $html;
        $result_data['btn_html']    = $button_html;
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }


    /*
    function userInfoUpdate(){
        $type           = $this->input->post('type') ?? "";
        $result_data    = array();
        switch ($type){
            case 'nickname':
                $this->yield    = false;
                $this->form_validation->set_rules('user_idx', 'user_idx', 'required');
                $this->form_validation->set_rules('nickname', 'nickname', 'required');
                $user_idx       = $this->input->post('user_idx') ?? "";
                $nickname       = $this->input->post('nickname') ?? "";
                if ($this->form_validation->run() == FALSE){
                    $result_data["status"] = "validation_fail";
                }else{
                    $data       = array(
                        'nickname' => $nickname
                        );
                    $result     = $this->mypage->updateUser($user_idx, $data);
                    if( $result ){
                        $result_data["status"] = "success";
                    }else{
                        $result_data["status"] = "update_error";
                    }
                }
                break;

            case 'school':
                $this->yield    = false;
                $this->form_validation->set_rules('user_idx', 'user_idx', 'required');
                $this->form_validation->set_rules('school', 'school', 'required');
                $user_idx       = $this->input->post('user_idx') ?? "";
                $school         = $this->input->post('school') ?? "";
                if ($this->form_validation->run() == FALSE){
                    $result_data["status"] = "validation_fail";
                }else{
                    $data       = array(
                        'school' => $school
                    );
                    $result     = $this->mypage->updateUser($user_idx, $data);
                    if( $result ){
                        $result_data["status"] = "success";
                    }else{
                        $result_data["status"] = "update_error";
                    }
                }
                break;

            case 'address':
                $this->yield    = false;
                $this->form_validation->set_rules('user_idx', 'user_idx', 'required');
                $this->form_validation->set_rules('address', 'address', 'required');
                $user_idx       = $this->input->post('user_idx') ?? "";
                $address       = $this->input->post('address') ?? "";
                if ($this->form_validation->run() == FALSE){
                    $result_data["status"] = "validation_fail";
                }else{
                    $data       = array(
                        'address' => $address
                    );
                    $result     = $this->mypage->updateUser($user_idx, $data);
                    if( $result ){
                        $result_data["status"] = "success";
                    }else{
                        $result_data["status"] = "update_error";
                    }
                }
                break;

            case 'category':
                $this->yield    = false;
                $this->form_validation->set_rules('user_idx', 'user_idx', 'required');
                $this->form_validation->set_rules('category_idx', 'category_idx', 'required');
                $user_idx       = $this->input->post('user_idx') ?? "";
                $category_idx   = $this->input->post('category_idx') ?? "";
                if ($this->form_validation->run() == FALSE){
                    $result_data["status"] = "validation_fail";
                }else{
                    $data       = array(
                        'category_idx' => $category_idx
                    );
                    $result     = $this->mypage->updateUser($user_idx, $data);
                    if( $result ){
                        $result_data["status"] = "success";
                    }else{
                        $result_data["status"] = "update_error";
                    }
                }
                break;
        }
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }
    */

    function userInfoUpdate(){
        $result_data    = array();
        $this->yield    = false;
        $this->form_validation->set_rules('user_idx', 'user_idx', 'required');
        if ($this->form_validation->run() == FALSE){
            $result_data["status"] = "validation_fail";
        }else{
            $user_idx       = $this->input->post('user_idx') ?? "";
            $nickname       = $this->input->post('nickname') ?? "";
            $school         = $this->input->post('school') ?? "";
            $address        = $this->input->post('address') ?? "";
            $category_idx   = $this->input->post('category_idx') ?? "";
            $data       = array(
                'nickname' => $nickname,
                'school' => $school,
                'address' => $address,
                'category_idx' => $category_idx
            );
            $result     = $this->mypage->updateUser($user_idx, $data);
            if( $result ){
                $result_data["status"] = "success";
            }else{
                $result_data["status"] = "update_error";
            }
        }
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function moreMobileLikeContents(){
        $this->yield                        = false;
        $user_idx                           = $this->input->post('user_idx') ?? "";
        $this->data['tot_row']              = $this->mypage->selectLikeContentsCount($user_idx);
        $this->data['page']                 = $this->input->post('page') ?? "1";
        $this->data['tot_page'] 	        = ceil($this->data['tot_row']  /  $this->data['size'] );
        $this->data['cur_num']              = $this->data['tot_row'] - $this->data['size'] * ($this->data['cur_page'] - 1);
        $result                             = $this->mypage->selectLikeContentsList($user_idx);
        $html                               = '';
        $button_html                        = '';
        $result_data                        = array();

        foreach ($result as $rows){
            $html       .= '<li>';
            $html       .= '    <div class="btn-favorcon">';
            $contents_img = json_decode($rows['img_info']);
            $html       .= '         <img src="'.$contents_img->img_path.'" alt="'.$rows['title'].'">';
            $html       .= '         <div class="favor-info">';
            $html       .= '            <span class="title">'.$rows['title'].'</span>';
            $html       .= '            <span class="explain">'.strip_tags($rows['contents_info']).'</span>';
            $html       .= '         </div>';
            $html       .= '    </div>';
            $html       .= '</li>';
        }

        if(!empty($result)){
            $count          = $this->data['page'] + 1;
            $button_html    .= '<button type="button" class="btn-more bg-white" onclick="moreMobileLikeContents(\''.$count.'\')"><span>더보기</span></button>';
        }else{
            $button_html    .= '';
        }

        $result_data['status']      = 'success';
        $result_data['html']        = $html;
        $result_data['btn_html']    = $button_html;
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function moreMobileMentoQuestion(){
        $this->yield                        = false;
        $user_idx                           = $this->input->post('user_idx') ?? "";
        $this->data['tot_row']              = $this->mypage->selectMentoQnaCount($user_idx);
        $this->data['page']                 = $this->input->post('page') ?? "1";
        $this->data['tot_page'] 	        = ceil($this->data['tot_row']  /  $this->data['size'] );
        $this->data['cur_num']              = $this->data['tot_row'] - $this->data['size'] * ($this->data['cur_page'] - 1);
        $result                             = $this->mypage->selectMentoQnaList($user_idx);
        $html                               = '';
        $button_html                        = '';
        $result_data                        = array();

        foreach ($result as $rows){
            if( $rows['request_yn'] == 'Y'){
                $class_text     = 'complete';
                $answer_text    = '답변완료';
            }else{
                $class_text     = '';
                $answer_text    = '답변미완료';
            }
            $html       .= '<li class="'.$class_text.'">';
            $html       .= '    <div class="myqna-group">';
            $html       .= '        <div class="myque-heading">';
            $html       .= '            <div class="question">'.$rows['content'].'</div>';
            $html       .= '            <div class="answer txt">'.$rows['request_content'].'</div>';
            $html       .= '        </div>';
            $html       .= '    </div>';
            $html       .= '    <div class="myqna-result">';
            $html       .= '        <div class="btn-round-fill" style="text-align:center;"><span style="margin-top:6px;">'.$answer_text.'</span></div>';
            $date       = explode(' ', $rows['reg_date']);
            $html       .= '        <span class="date">'.$date[0].'</span>';
            $html       .= '    </div>';
            $html       .= '</li>';
        }

        $count              = $this->data['page'] + 1;
        $this->data['page'] = $count;
        $btn_result         = $this->mypage->selectMentoQnaList($user_idx);
        if(!empty($btn_result)){
            $button_html    .= '<button type="button" class="btn-more bg-white" onclick="moreMobileMentoQuestion(\''.$count.'\')"><span>더보기</span></button>';
        }else{
            $button_html    .= '';
        }

        $result_data['status']      = 'success';
        $result_data['html']        = $html;
        $result_data['btn_html']    = $button_html;
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function moreMobileBookmark(){
        $this->yield                        = false;
        $user_idx                           = $this->input->post('user_idx') ?? "";
        $this->data['tot_row']              = $this->mypage->selectBookmarkCount($user_idx);
        $this->data['page']                 = $this->input->post('page') ?? "1";
        $this->data['tot_page'] 	        = ceil($this->data['tot_row']  /  $this->data['size'] );
        $this->data['cur_num']              = $this->data['tot_row'] - $this->data['size'] * ($this->data['cur_page'] - 1);
        $result                             = $this->mypage->selectBookmarkList($user_idx);
        $html                               = '';
        $button_html                        = '';
        $result_data                        = array();

        foreach ($result as $rows){
            $contents_img = json_decode($rows['img_info']);
            $html       .= '<li>';
            $html       .= '    <div class="btn-favorcon">';
            $html       .= '        <img src="'.$contents_img->img_path.'" alt="'.$rows['title'].'">';
            $html       .= '        <div class="favor-info">';
            $html       .= '            <span class="title">'.$rows['title'].'</span>';
            $html       .= '            <span class="explain" style="display: none;">'.strip_tags($rows['contents_info']).'</span>';
            $html       .= '        </div>';
            $html       .= '    </div>';
            $html       .= '</li>';
        }

        $count              = $this->data['page'] + 1;
        $this->data['page'] = $count;
        $btn_result         = $this->mypage->selectBookmarkList($user_idx);
        if(!empty($btn_result)){
            $button_html    .= '<button type="button" class="btn-more" onclick="moreMobileBookmark(\''.$count.'\')"><span>더보기</span></button>';
        }else{
            $button_html    .= '';
        }

        $result_data['status']      = 'success';
        $result_data['html']        = $html;
        $result_data['btn_html']    = $button_html;
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }

    function moreMobileDebateRoom(){
        $this->yield                        = false;
        $user_idx                           = $this->input->post('user_idx') ?? "";
        $this->data['tot_row']              = $this->mypage->selectDebateRoomCount($user_idx);
        $this->data['page']                 = $this->input->post('page') ?? "1";
        $this->data['tot_page'] 	        = ceil($this->data['tot_row']  /  $this->data['size'] );
        $this->data['cur_num']              = $this->data['tot_row'] - $this->data['size'] * ($this->data['cur_page'] - 1);
        $result                             = $this->mypage->selectDebateRoomList($user_idx);
        $html                               = '';
        $button_html                        = '';
        $result_data                        = array();

        foreach ($result as $rows){
            if($rows['open_yn'] == 'Y'){
                $html   .= '<li class="ing">';
                $html   .= '    <div class="debate-group">';
                $html   .= '        <div class="debate-heading">';
                $html   .= '            <img src="'.$rows['img_path'].'" alt="">';
                $html   .= '            <div class="debate-flag">토론진행중</div>';
                $html   .= '        </div>';
                $html   .= '        <div class="debate-body">';
                $html   .= '            <div class="dbbody-middle">';
                $html   .= '                '.$rows['title'].'';
                $html   .= '            </div>';
                $html   .= '        </div>';
                $html   .= '    </div>';
                $html   .= '    <div class="debate-footer flex-center">';
                $html   .= '        <a href="/debate/chat?room_idx='.$rows['idx'].'" class="btn-primary"><span>토론 참여 하기</span></a>';
                $html   .= '    </div>';
                $html   .= '</li>';
            }else{
                $html   .= '<li class="end">';
                $html   .= '    <div class="debate-group">';
                $html   .= '        <div class="debate-heading">';
                $html   .= '            <img src="'.$rows['img_path'].'" alt="">';
                $html   .= '            <div class="debate-flag">토론종료</div>';
                $html   .= '        </div>';
                $html   .= '        <div class="debate-body">';
                $html   .= '            <div class="dbbody-middle">';
                $html   .= '                '.$rows['title'].'';
                $html   .= '            </div>';
                $html   .= '        </div>';
                $html   .= '    </div>';
                $html   .= '    <div class="debate-footer flex-center">';
                $html   .= '        <a href="/debate/chat?room_idx='.$rows['idx'].'" class="btn-secondary"><span>토론 참여 하기</span></a>';
                $html   .= '    </div>';
                $html   .= '</li>';
            }
        }

        $count              = $this->data['page'] + 1;
        $this->data['page'] = $count;
        $btn_result         = $this->mypage->selectDebateRoomList($user_idx);

        if(!empty($btn_result)){
            $button_html    .= '<button type="button" class="btn-more" onclick="moreMobileDebateRoom(\''.$count.'\')"><span>더보기</span></button>';
        }else{
            $button_html    .= '';
        }

        $result_data['status']      = 'success';
        $result_data['html']        = $html;
        $result_data['btn_html']    = $button_html;
        echo json_encode($result_data, JSON_UNESCAPED_UNICODE);
    }
}