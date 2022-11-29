<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common {
    function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('m_common');

    }

    //관리자 로그인 체크
    function checkLogin(){
        if($this->CI->session->userdata('is_admin') == ""){
            redirect('/admin/login');
        }
    }


    //회원 로그인 체크
    function checkUserLogin(){
        $data = false;
        if($this->CI->session->userdata('is_login') == "Y"){
            $data = true;
        }
        return $data;
    }

    //로그인체크 후 처리
    function goLogin($url = '/'){
        echo "<script>alert('로그인 후 이용 바랍니다.');location.href='". $url. "'</script>";
    }


    //알럿창
    function alertMessage($message, $link = ''){

        echo "<script>alert('" . $message ."')</script>";
        if ($link != ''){
            echo "<script>location.href='" . $link ."'</script>";
        }

    }


    //관리자 날짜 셀렉트박스
    function setDateField($set_date = '', $start_year = '1980'){

        if ($set_date != ''){
            $set_date = explode( '-', $set_date);
        }
        $html = '
            {year}
            <p>&nbsp; - &nbsp;</p>
            {month}
            <p>&nbsp; - &nbsp;</p>
            {day}
        ';

        $year_html = '<select class="custom-select col-sm-1">';
        for($y = date('Y');  $y >= $start_year; $y--){
            if (isset($set_date[0]) &&  $set_date[0] == $y){
                $year_html .= '<option value="' . $y .'" selected >'. $y . '</option>';
            }else{
                $year_html .= '<option value="' . $y .'" >'. $y . '</option>';
            }
        }
        $year_html .= '<select>';

        $month_html = '<select class="custom-select col-sm-1">';
        for($m = 1;  $m <= 12 ; $m++){
            if(strlen($m) == 1) $m = "0".$m;
            if (isset($set_date[1]) &&  $set_date[1] == $m){
                $month_html .= '<option value="' . $m .'" selected >'. $m . '</option>';
            }else{
                $month_html .= '<option value="' . $m .'" >'. $m . '</option>';
            }
        }
        $month_html .= '<select>';

        $day_html = '<select class="custom-select col-sm-1">';
        for($d = 1;  $d <= 31 ; $d++){
            if(strlen($d) == 1) $d = "0".$d;
            if (isset($set_date[2]) &&  $set_date[2] == $d){
                $day_html .= '<option value="' . $d .'" selected >'. $d . '</option>';
            }else{
                $day_html .= '<option value="' . $d .'" >'. $d . '</option>';
            }
        }
        $day_html .= '<select>';

        $html = str_replace('{year}' , $year_html , $html);
        $html = str_replace('{month}' , $month_html , $html);
        $html = str_replace('{day}' , $day_html , $html);
        return $html;
    }



    //서브 타이틀 호출
    function subClass(){

        //...produce_bg/*센터소개 bg*/ .sub/*qna bg*/
        //.tool_bg/*공간장비지원 bg*/
        //.tenant_company_bg /*입주기업 bg*/
        //.online_bg /*프로그램 bg*/
        //.mento_bg}/*멘토 bg*/
        //.mypage/*mypage bg*/
        //.business_bg /*창업지원사업*/
        //.join_bg /*회원가입*/
        //.online_bg /*온라인강의*/


        $segment = $this->CI->router->fetch_class();
        $sub_class = array(
          "introduce"   => "produce_bg",
          "qna"         => "qna_bg",
          "mento"       => "mento_bg",
          "mypage"      => "mypage_bg",
          "join"        => "join_bg",
          "tenant"      => "tenant_company_bg",
          "mentoring"   => "mento_bg",
          "business"    => "business_bg",
            "online"    => "online_bg"
        );
        $class_name = "";
        if (array_key_exists($segment , $sub_class)){
            $class_name = $sub_class[$segment];
        }
        return $class_name ;
    }

    //날짜 형식 변환(2021년 01월 01일)
    function changeDate($date ,$type = 'text'){
        $date   = date("Y-m-d", strtotime($date));
        $result = explode('-',$date);
        if ($type == 'text'){
            return date($result[0] . "년 ". $result[1] ."월 ". $result[2] ."일");
        }elseif ($type == '.'){
            return date($result[0] . ".". $result[1] .".". $result[2]);
        }

    }

    //기업 상태
    function getComapnyStatus($status){
        $text = '';
        if ($status == 1){
            $text = '신청';
        }elseif ($status == 2){
            $text = '미승인';
        }elseif ($status == 3){
            $text = '승인';
        }
        return $text;
    }

    //기업추천 상태
    function getComapnyRecommendStatus($status){
        $text = '';
        if ($status == 1){
            $text = '추천';
        }
        return $text;
    }


    //제품추천 상태
    function getProductRecommendStatus($status){
        $text = '';
        if ($status == 1){
            $text = '추천';
        }
        return $text;
    }



    //제품 상태
    function getProductStatus($status){
        $text = '';
        if ($status == 1){
            $text = '임시저장';
        }elseif ($status == 2){
            $text = '승인요청';
        }elseif ($status == 3){
            $text = '승인';
        }
        return $text;
    }

    //기업 요청수
    function getRequestCount(){
        $this->CI->load->model('admin/M_company');
        $cnt = $this->CI->M_company->selectRequestCount();
        return $cnt;
    }

    //관리자 History
    function setHistory($member_idx , $type , $action){
        $this->CI->load->model('admin/M_main');
        $data = array('member_idx' => $member_idx,'type' => $type,'action' => $action , 'reg_date' => date("Y-m-d H:i:s") , 'reg_ip' => $this->CI->input->ip_address());
        $this->CI->M_main->insertHistory($data);
    }


    //email 패턴 체크
    public function checkEmail($email){
        $result  = true;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        }
        return $result;
    }

    //글자수 줄이기
    public function cutStr($title, $count){
        if (strlen($title) > $count){
            $i = 0;
            $re = "";
            do {
                $ch = substr($title, $i, 1);
                if (ord($ch) > 127) {
                    $ch2 = substr($title, $i+1, 1);
                    $re .= $ch . $ch2;
                    $i+=2;
                } else {
                    $re .= $ch;
                    $i++;
                }
            } while($i<$count);
            return $re . "...";
        } else
            return $title;
    }

    //모바일 여부 체크
    public function checkMobile(){
        $mobile_agent = array("iphone","ipod","ipad","android","blackberry","opera Mini", "windows ce", "nokia", "sony" );
        $check_mobile = false;
        for($i=0; $i<sizeof($mobile_agent); $i++){
            if(preg_match("/$mobile_agent[$i]/", strtolower($_SERVER['HTTP_USER_AGENT']))){
                $check_mobile = true;
                break;
            }
        }
        $is_mobile = "N";
        if($check_mobile) {
            $is_mobile = "Y";
        }

        return $is_mobile;
    }


    //모바일 레이아웃
    function checkMobileLayout(){
        $is_mobile = $this->CI->agent->is_mobile();
        if ($is_mobile){
            $device = "m_";
        }else{
            $device = "";
        }
        return $device;
    }




    //아이피 주소 확인
    function getRealIpAddr(){
        if(!empty($_SERVER['HTTP_CLIENT_IP']) && getenv('HTTP_CLIENT_IP')){
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']) && getenv('HTTP_X_FORWARDED_FOR')){
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        elseif(!empty($_SERVER['REMOTE_HOST']) && getenv('REMOTE_HOST')){
            return $_SERVER['REMOTE_HOST'];
        }
        elseif(!empty($_SERVER['REMOTE_ADDR']) && getenv('REMOTE_ADDR')){
            return $_SERVER['REMOTE_ADDR'];
        }
        return false;
    }

    /*
	 * 비트연산
	 */
    public function bit_get($arr) {
        if(!is_array($arr)) {
            return 0;
        }
        $tmp = 0;
        foreach($arr as $k=>$v) {
            $tmp = $tmp | (0+$v);
        }

        return $tmp;
    }


    public function bit_str($bit,$arr,$sep="") {
        if(!is_array($arr)) return NULL;

        $cnt = count($arr);
        $b = 1; $str = ""; $cnt_match =0;
        for($n=0;$n<$cnt;$n++) {
            if($b & $bit) {
                if($cnt_match>0)
                    $str .= $sep;
                $str .= $arr[$b];
                $cnt_match ++;
            }
            $b <<= 1;
        }
        return $str;
    }


    //이메일 보내기
    function sendMail($EMAIL, $NAME, $mailto, $SUBJECT, $CONTENT){
        //$EMAIL : 답장받을 메일주소
        //$NAME : 보낸이
        //$mailto : 보낼 메일주소
        //$SUBJECT : 메일 제목
        //$CONTENT : 메일 내용
        $admin_email = $EMAIL;
        $admin_name = $NAME;

        $header = "Return-Path: ".$admin_email."\n";
        $header .= "From: =?UTF-8?B?".base64_encode($admin_name)."?= <".$admin_email.">\n";
        $header .= "MIME-Version: 1.0\n";
        $header .= "X-Priority: 3\n";
        $header .= "X-MSMail-Priority: Normal\n";
        $header .= "X-Mailer: FormMailer\n";
        $header .= "Content-Transfer-Encoding: base64\n";
        $header .= "Content-Type: text/html;\n \tcharset=utf-8\n";

        $subject = "=?UTF-8?B?".base64_encode($SUBJECT)."?=\n";
        $contents = $CONTENT;

        $message = base64_encode($contents);
        flush();
        mail($mailto, $subject, $message, $header);
    }

    // 시간 체크
    function getTime(){
        $hh     = date("H");
        $mm     = date("i");
        $ss     = date("s");
        $get_time   = $hh."시 ".$mm."분 ".$ss."초";
        return $get_time;
    }

    //난수비밀번호
    function generateRandomString($length = 10) {
        $characters = '23456789abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ$@$!%*#?&';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    function insertVisitor(){
        $actual_link = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $site        = $_SERVER['REQUEST_URI'];

        if(!isset($_SESSION[$this->CI->input->ip_address()]))
        {
            $_SESSION[$this->CI->input->ip_address()] = "1";
            $this->CI->load->model('M_common');
            $data = array(
                'time' => date("Y-m-d H:i:s"),
                'site' => $actual_link,
                'user_ip' =>   $this->CI->input->ip_address()
            );
            $this->CI->M_common->insertVisitor($data);
        }

    }

    function selectVisitor(){
        $today = date('Y-m-d');
        $this->CI->load->model('M_common');
        return $this->CI->M_common->selectVisitor($today);

    }


    function getProductCode1(){

        $this->CI->load->model('M_common');
        $result = $this->CI->M_common->selectProductCode1();
        return $result;
    }

    function getProductCode2($code = ''){

        $this->CI->load->model('M_common');
        $result = $this->CI->M_common->selectProductCode2($code);
        return $result;
    }

    function getProductCode3($code = ''){

        $this->CI->load->model('M_common');
        $result = $this->CI->M_common->selectProductCode3($code);
        return $result;
    }

    // 관리자 파일 폼 생성
    function createFileForm($file_info, $file_id){
        $form_html          = '';
        for( $i = 1; $i < count($file_info); $i++ ){
            $num            = $i + 1;
            $file_id_num    = $file_id . "_" . $num;
            $form_html      .= '<div class="form-group row '.$file_id.'_form '.$file_id_num.'_form">';
            $form_html      .= '    <label class="col-sm-2 col-form-label"></label>';
            $form_html      .= '    <div class="col-sm-5">';
            $form_html      .= '        <div class="input-group-prepend">';
            $form_html      .= '            <input type="file" class="form-control" id="'.$file_id_num.'" name="attached_file" />';
            $form_html      .= '            <input type="hidden" class="form-control" id="'.$file_id_num.'_path" name="attached_file_path" value="'.$file_info[$i]['file_path'].'" />';
            $form_html      .= '            <input type="hidden" class="form-control" id="'.$file_id_num.'_name" name="attached_file_name" value="'.$file_info[$i]['file_name'].'" />';
            $form_html      .= '            <input type="text" class="form-control" id="'.$file_id_num.'_desc" value="'.$file_info[$i]['file_name'].'" placeholder="파일을 선택해 주세요." disabled />';
            $form_html      .= '            <div class="input-group-append" style="width:200px;">';
            $form_html      .= '                <button type="button" class="btn btn-block btn-info" onclick="fileAdd('."'".$file_id_num."'".');" >파일첨부</button>';
            $form_html      .= '            </div>';
            $form_html      .= '        </div>';
            $form_html      .= '    </div>';
            $form_html      .= '    <div style="float:left;">';
            $form_html      .= '        <button type="button" class="btn btn-danger" onclick="fileDelete('."'".$file_id_num."'".');" style="width:90px;" >파일삭제</button>';
            $form_html      .= '        <button type="button" class="btn btn-danger" onclick="deleteFileForm('."'".$file_id_num."'".');" style="width:50px; margin-left:30px;" >-</button>';
            $form_html      .= '    </div>';
            $form_html      .= '</div>';
        }


        return $form_html;
    }

    // 커스텀 수정 파일 폼 생성
    function createCustomFileForm($file_info, $file_id){
        $form_html          = '';
        for( $i = 1; $i < count($file_info); $i++ ){
            $num            = $i + 1;
            $file_id_num    = $file_id . "_" . $num;
            $form_html      .= '<div class="file_wrap '.$file_id.'_form '.$file_id_num.'_form">';
            $form_html      .= '    <div class="filebox bs3-primary">';
            $form_html      .= '            <input class="upload-name" value="'.$file_info[$i]['file_name'].'" disabled="disabled">';
            $form_html      .= '            <label for="'.$file_id_num.'"> 찾아보기</label>';
            $form_html      .= '            <input type="file" class="upload-hidden"  id="'.$file_id_num.'" name="attached_file" onclick="fileChange('."'".$file_id_num."'".')";  />';
            $form_html      .= '            <input type="hidden" class="form-control" id="'.$file_id_num.'_path" name="attached_file_path"  value="'.$file_info[$i]['file_path'].'" />';
            $form_html      .= '            <input type="hidden" class="form-control" id="'.$file_id_num.'_name" name="attached_file_name"  value="'.$file_info[$i]['file_name'].'" />';
            $form_html      .= '        </div>';
            $form_html      .= '    <div class="btn_wrap">';
            $form_html      .= '        <a href="javascript:deleteFileForm('."'".$file_id_num."'".');"><img src="/public/images/tenant_company/btn_minus.png" alt=""></a>';
            $form_html      .= '    </div>';
            $form_html      .= '</div>';
        }


        return $form_html;
    }



    // 관리자 구성강좌 폼 생성
    function createOrderForm($lecture_info){
        $form_html          = '';
        for( $i = 1; $i < count($lecture_info); $i++ ){
            $num            = $i + 1;
            $form_html      .= '<div class="order_form order_form_'.$num.'">';
            $form_html      .= '    <div class="form-group row">';
            $form_html      .= '        <label for="btn_thumb_img" class="col-sm-2 col-form-label">썸네일 이미지</label>';
            $form_html      .= '        <div class="col-sm-10">';
            $form_html      .= '            <div class="img_div_wrap">';
            $form_html      .= '                <span class="img_span_wrap">';
            $form_html      .= '                    <input type="file" id="thumb_img_'.$num.'_file" name="thumb_img_file" class="img_file"/>';
            $form_html      .= '                    <input type="hidden" id="thumb_img_'.$num.'_path" name="thumb_img_path" value="'.$lecture_info[$i]['img_path'].'"/>';
            $form_html      .= '                    <input type="hidden" id="thumb_img_'.$num.'_name" name="thumb_img_name" value="'.$lecture_info[$i]['img_name'].'"/>';
            $form_html      .= '                    <a href="javascript:imageAdd('."'thumb_img_".$num."'".')"><img src="/public/admin/images/add_photo.jpg" alt="" class="margin"></a>';
            $form_html      .= '                </span>';
            $form_html      .= '                <ul class="ul_img" id="thumb_img_'.$num.'">';
            if( $lecture_info[$i]['img_path'] != "" ){
                $form_html  .= '                    <li><div class="btn_delete"><a href="javascript:imageDelete('."'thumb_img_".$num."'".');"><img src="/public/admin/images/btn_delete_b.png"/></a></div><img src="'.$lecture_info[$i]['img_path'].'" class="margin"/></li>';
            }
            $form_html      .= '                </ul>';
            $form_html      .= '            </div>';
            $form_html      .= '        </div>';
            $form_html      .= '    </div>';
            $form_html      .= '    <div class="form-group row video_file_form">';
            $form_html      .= '        <label class="col-sm-2 col-form-label">동영상파일</label>';
            $form_html      .= '        <div class="col-sm-5">';
            $form_html      .= '            <div class="input-group-prepend">';
            $form_html      .= '                <input type="file" class="form-control" id="video_file_'.$num.'" name="video_file" />';
            $form_html      .= '                <input type="hidden" class="form-control" id="video_file_'.$num.'_path" name="video_file_path" value="'.$lecture_info[$i]['video_path'].'" />';
            $form_html      .= '                <input type="hidden" class="form-control" id="video_file_'.$num.'_name" name="video_file_name" value="'.$lecture_info[$i]['video_name'].'" />';
            $form_html      .= '                <input type="hidden" class="form-control" id="video_file_'.$num.'_play_time" name="video_file_play_time" value="'.$lecture_info[$i]['play_time'].'" />';
            $form_html      .= '                <input type="text" class="form-control" id="video_file_'.$num.'_desc" value="'.$lecture_info[$i]['video_name'].'" placeholder="동영상을 선택해 주세요." disabled />';
            $form_html      .= '                <div class="input-group-append" style="width:200px;">';
            $form_html      .= '                    <button type="button" class="btn btn-block btn-info" onclick="videoAdd('."'video_file_".$num."'".');" >동영상첨부</button>';
            $form_html      .= '                </div>';
            $form_html      .= '            </div>';
            $form_html      .= '        </div>';
            $form_html      .= '        <div style="float:left;">';
            $form_html      .= '            <button type="button" class="btn btn-danger" onclick="videoDelete('."'video_file_".$num."'".');" style="width:110px;" >동영상삭제</button>';
            $form_html      .= '        </div>';
            $form_html      .= '    </div>';
            $form_html      .= '    <div class="form-group row">';
            $form_html      .= '        <label for="lecture_title_'.$num.'" class="col-sm-2 col-form-label">강좌제목</label>';
            $form_html      .= '        <div class="col-sm-10">';
            $form_html      .= '            <input type="text" class="form-control" id="lecture_title_'.$num.'" name="lecture_title" placeholder="제목" value="'.$lecture_info[$i]['title'].'" />';
            $form_html      .= '        </div>';
            $form_html      .= '    </div>';
            $form_html      .= '    <div class="form-group row">';
            $form_html      .= '        <label for="lecture_content_'.$num.'" class="col-sm-2 col-form-label">강좌내용</label>';
            $form_html      .= '        <div class="col-sm-10">';
            $form_html      .= '            <textarea id="lecture_content_'.$num.'" name="lecture_content" class="text_area">'.$lecture_info[$i]['content'].'</textarea>';
            $form_html      .= '        </div>';
            $form_html      .= '    </div>';
            $form_html      .= '</div>';
        }


        return $form_html;
    }


    // 카테고리 리스트
    function getCategory($entry){
        $this->CI->load->model('m_common');
        $result     = $this->CI->m_common->selectCategoryList($entry);
        return $result;
    }

    // 코드 리스트
    function getCodeList($entry){
        $this->CI->load->model('m_common');
        $result     = $this->CI->m_common->selectCodeList($entry);
        return $result;
    }

    function getBitString($entry, $value){
        $code_list  = self::getCodeList($entry);
        $result     = "";
        foreach( $code_list as $rows ){
            if( $rows['int_val1'] & $value ){
                $result .= "* " . $rows['str_val1'] . "  ";
            }
        }
        return $result;
    }

    function loginUserCheck(){
        $user_session   = $this->CI->session->userdata();
        if(!empty($user_session['userId'])){
                return true;
        }else{
            return false;
        }
    }


}
