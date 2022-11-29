<!-- MAIN -->
<div class="container" role="main" id="container">
    <div class="contents">
        <div class="con-group">
            <div class="con-heading">
                <h2 class="h2 loc-center">
                    <img src="/public/images/bg_mypage.png" alt="마이페이지, 내가 고른 콘텐츠를 모아 보세요">
                </h2>
            </div>
            <div class="con-body pd0 mgt0 bg-white">
                <div class="my-section bg-lightgray2">
                    <div class="loc-center ">
                        <div class="header-group">
                            <h4 class="h5-small darkgray font-bold">내 정보</h4>
                        </div>
                        <div class="my-group">
                            <div class="my-heading">
                                <input type="file" id="1_file" style="display: none" onchange="userImageUpload('1')"/>
                                <button type="button" class="my-photo" id="user_img_upload">
                                    <img src="<?=$user_img ? $user_img : '/public/images/thumb_user.png'?>" id="user_img">
                                </button>
                                <div class="my-info">
                                    <div class="my-nickname"><?=$user_nickname?></div>
                                    <div class="my-name">
                                        <input type="hidden" id="user_idx" value="<?=$user_idx?>">
                                        <span class="name"><?=$user_name?></span>
<!--                                        <span class="point">1,200P</span>-->
                                    </div>
                                </div>
                                <div class="myinfo-gbody">
                                    <button type="button" class="btn-round-line" onclick="updateUserInfo();"><span>개인정보 수정</span></button>
                                </div>
                            </div>
                            <div class="my-body">
                                <div class="my-dt" style="margin-top: 17px;">닉네임</div>
                                <div class="my-dd">
                                    <span><input type="text" id="nickname" value="<?=$user_nickname?>" style="text-align: center;"></span>
                                </div>
                                <div class="my-dt">Phone</div>
                                <div class="my-dd">
                                    <span><?=$user_phone?></span>
                                </div>
                                <div class="my-dt">학교</div>
                                <div class="my-dd">
                                    <span><input type="text" id="school" value="<?=$user_school?>" style="text-align: center;"></span>
                                </div>
                                <div class="my-dt">주소</div>
                                <div class="my-dd">
                                    <span><input type="text" id="address" value="<?=$user_address?>" style="text-align: center;"></span>
                                </div>
                                <div class="my-dt">관심분야</div>
                                <div class="my-dd my-select">
                                    <span>
                                        <select class="field" name="field" id='user_category'>
                                            <option value="">선택</option>
                                            <?foreach ($category as $rows_c):?>
                                                <option value="<?=$rows_c['idx']?>" <?=($rows_c['idx'] == $user_category) ? 'selected' : ''?>><?=$rows_c['title']?></option>
                                            <?endforeach;?>
                                        </select>
                                    </span>
                                </div>
                                <div class="my-dt">이메일</div>
                                <div class="my-dd">
                                    <span><?=$user_email?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--비활성화-->
                <!--
                <div class="my-section favor-section">
                    <div class="loc-center ">
                        <div class="header-group">
                            <h4 class="h5-small darkgray font-bold ico-hart">내가 좋아하는 콘텐츠</h4>
                        </div>

                        <ul class="myfavor-lists" id="like_contents">
                            <?foreach ($like_contents as $rows_l):?>
                            <li>
                                <a href="/main?link_idx=<?=$rows_l['idx']?>">
                                    <div class="myfavor-group">
                                        <?$contents_img = json_decode($rows_l['img_info'])?>
                                        <div class="myfavor-heading" style="background: url(<?=$contents_img->img_path?>) no-repeat; background-position: center center; background-size: cover;">
                                        </div>
                                        <div class="myfavor-body">
                                            <div class="myfavor-title"><?=$rows_l['title']?></div>
                                            <div class="myfavor-explain multiline">
                                                <?=strip_tags($rows_l['contents_info'])?>
                                            </div>
                                        </div>
                                        <?$date     = explode(' ', $rows_l['reg_date'])?>
                                        <div class="myfavor-footer"><?=$date[0]?></div>
                                    </div>
                                </a>
                            </li>
                            <?endforeach;?>
                        </ul>
                        <?if(!empty($like_contents)):?>
                        <div class="btn-group" id="like_contents_btn">
                            <button type="button" class="btn-more" onclick="moreLikeContents('2')"><span>더보기</span></button>
                        </div>
                        <?endif;?>
                    </div>
                </div>-->

                <div class="my-section bg-lightblue">
                    <div class="loc-center ">
                        <div class="header-group">
                            <h4 class="h5-small darkgray font-bold ico-bookmark">책갈피</h4>
                        </div>
                        <div class="my_notice1 my_notice" style="<?=(count($bookmark_contents) > 0) ? ' display: none;' : ''?>">아직 책갈피가 없네요! 콘텐츠를 보러 갈까요?</div>
                        <ul class="mybookmark-lists" id="bookmark_contents">
                            <?foreach ($bookmark_contents as $rows_b):?>
                                <li>
                                    <a href="/main?link_idx=<?=$rows_b['idx']?>">
                                        <div class="mybookmark-group">
                                            <?$contents_img = json_decode($rows_b['img_info'])?>
                                            <div class="mybookmark-heading" style="background: url(<?=$contents_img->img_path?>) no-repeat; background-position: center center; background-size: cover;">
                                            </div>
                                            <div class="mybookmark-body">
                                                <div class="mybookmark-title"><?=$rows_b['title']?></div>
                                                <div class="mybookmark-explain multiline" style="display: none;">
                                                    <?=strip_tags($rows_b['contents_info'])?>
                                                </div>
                                            </div>
                                            <?$date     = explode(' ', $rows_b['reg_date'])?>
                                            <div class="mybookmark-footer"><?=$date[0]?></div>
                                        </div>
                                    </a>
                                </li>
                            <?endforeach;?>
                        </ul>
                        <?if(!empty($bookmark_contents)):?>
                            <?if(!empty($bookmark_contents_next_btn)):?>
                                <div class="btn-group" id="bookmark_contents_btn">
                                    <button type="button" class="btn-more" onclick="moreBookmark('2')"><span>더보기</span></button>
                                </div>
                            <?endif;?>
                        <?endif;?>
                    </div>
                </div>

                <div class="my-section">
                    <div class="loc-center ">
                        <div class="header-group">
                            <h4 class="h5-small darkgray font-bold ico-mic">참여했던 토론</h4>
                        </div>
                        <div class="my_notice2 my_notice" style="<?=(count($debate_room) > 0) ? 'display: none;' : ''?>">아직 참여한 토론이 없네요. V토론에서 참여해 보세요!</div>
                        <ul class="mydebate-lists" id="debate_room">
                            <?foreach($debate_room as $d_rows):?>
                            <li>
                                <a href="/debate/chat?room_idx=<?=$d_rows['idx']?>">
                                <div class="mydebate-group">
                                    <div class="mydebate-heading" style="background: url(<?=$d_rows['img_path']?>) no-repeat; background-position: center center; background-size: cover;">
                                       
                                    </div>
                                    <div class="mydebate-body">
                                        <div class="mydebate-title"><?=$d_rows['category']?></div>
                                        <div class="mydebate-detail"><?=$d_rows['title']?></div>
                                    </div>
                                    <?$date     = explode(' ', $d_rows['reg_date'])?>
                                    <div class="mydebate-footer"><?=$date[0]?></div>
                                </div>
                                </a>
                            </li>
                            <?endforeach;?>
                        </ul>
                        <?if(!empty($debate_room)):?>
                            <?if(!empty($debate_room_next_btn)):?>
                                <div class="btn-group" id="debate_room_btn">
                                    <button type="button" class="btn-more" onclick="moreDebateRoom('2')"><span>더보기</span></button>
                                </div>
                            <?endif;?>
                        <?endif;?>
                    </div>
                </div>

                <div class="my-section bg-lightblue">
                    <div class="loc-center ">
                        <div class="header-group">
                            <h4 class="h5-small darkgray font-bold ">Q 내가 한 질문</h4>
                        </div>
                        <div class="my_notice3 my_notice" style="<?=(count($mento_question) > 0) ? 'display: none;' : ''?>">아직 아무 질문도 하지 않았네요. Q챗에서 질문을 올려 보세요!</div>
                        <ul class="myqna-lists" id="mento_question">
                            <?foreach ($mento_question as $rows_m):?>
                                <li>
                                    <div class="myqna-group">
                                        <div class="myqna-heading">
                                            <div class="myqna-qustion">
                                                <span class="flag">Q.&nbsp;</span>
                                                <span class="txt"><?=$rows_m['content']?></span>
                                            </div>
                                            <div class="myqna-answer">
                                                <span class="flag">A.&nbsp;</span>
                                                <span class="txt"><?=$rows_m['request_content']?></span>
                                            </div>
                                        </div>
                                        <div class="myqna-body">
                                            <?if($rows_m['request_yn'] == 'Y'):?>
                                                <div class="myqna-result">
                                                    <div class="btn-answer"><span>답변완료</span></div>
                                                </div>
                                            <?else:?>
                                                <div class="myqna-result">
                                                    <div class="btn-answer no"><span>답변 미완료</span></div>
                                                </div>
                                            <?endif;?>
                                            <?$date     = explode(' ', $rows_m['reg_date'])?>
                                            <div class="myqna-date"><?=$date[0]?></div>
                                        </div>
                                    </div>
                                </li>
                            <?endforeach;?>
                        </ul>
                        <?if(!empty($mento_question)):?>
                            <?if(!empty($mento_question_next_btn)):?>
                                <div class="btn-group" id="mento_question_btn">
                                    <button type="button" class="btn-more" onclick="moreMentoQuestion('2')"><span>더보기</span></button>
                                </div>
                            <?endif;?>
                        <?endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- // MAIN -->
<script>
    $(function(){
        $('#user_img_upload').click(function(){
            $('#1_file').trigger('click');
        });

        /*
        $('#nickname').focusout(function(){
            var param       = {};
            var user_idx    = $('#user_idx').val();
            var nickname    = $('#nickname').val();
            var type        = 'nickname';

            param.user_idx  = user_idx;
            param.nickname  = nickname;
            param.type      = type;
            $.ajax({
                url     : "/myPage/userInfoUpdate",
                method  : "POST",
                dataType: "JSON",
                data    : param,
                success: function(result){
                    if(result.status == "success") {

                    }else{

                    }
                },

            });
        })

        $('#school').focusout(function(){
            var param       = {};
            var user_idx    = $('#user_idx').val();
            var school      = $('#school').val();
            var type        = 'school';

            param.user_idx  = user_idx;
            param.school    = school;
            param.type      = type;
            $.ajax({
                url     : "/myPage/userInfoUpdate",
                method  : "POST",
                dataType: "JSON",
                data    : param,
                success: function(result){
                    if(result.status == "success") {

                    }else{

                    }
                },

            });
        })

        $('#address').focusout(function(){
            var param       = {};
            var user_idx    = $('#user_idx').val();
            var address     = $('#address').val();
            var type        = 'address';

            param.user_idx  = user_idx;
            param.address   = address;
            param.type      = type;
            $.ajax({
                url     : "/myPage/userInfoUpdate",
                method  : "POST",
                dataType: "JSON",
                data    : param,
                success: function(result){
                    if(result.status == "success") {

                    }else{

                    }
                },

            });
        })

        $('#user_category').change(function(){
            var param           = {};
            var user_idx        = $('#user_idx').val();
            var category_idx    = $('#user_category').val();
            var type            = 'category';

            param.user_idx      = user_idx;
            param.category_idx  = category_idx;
            param.type          = type;
            $.ajax({
                url     : "/myPage/userInfoUpdate",
                method  : "POST",
                dataType: "JSON",
                data    : param,
                success: function(result){
                    if(result.status == "success") {

                    }else{

                    }
                },

            });
        })
        */
    });


    function moreLikeContents(page){
        var user_idx    = $('#user_idx').val();
        $.ajax({
            url : "/myPage/moreLikeContents",
            method : "POST",
            dataType : "JSON",
            data : {'page' : page, 'user_idx' : user_idx},
            success: function(result){
                if(result.status == "success") {
                    $('#like_contents').append(result.html);
                    $('#like_contents_btn').html('');
                    $('#like_contents_btn').append(result.btn_html);
                }else {
                    alert('오류가 발생 되었습니다.');
                }
            },

        });
    }

    function moreMentoQuestion(page){
        var user_idx    = $('#user_idx').val();
        $.ajax({
            url : "/myPage/moreMentoQuestion",
            method : "POST",
            dataType : "JSON",
            data : {'page' : page, 'user_idx' : user_idx},
            success: function(result){
                if(result.status == "success") {
                    $('#mento_question').append(result.html);
                    $('#mento_question_btn').html('');
                    $('#mento_question_btn').append(result.btn_html);
                    myQnaAnswer();
                }else {
                    alert('오류가 발생 되었습니다.');
                }
            },
        });
    }

    function moreBookmark(page){
        var user_idx = $('#user_idx').val();
        $.ajax({
            url: "/myPage/moreBookmark",
            method: "POST",
            dataType: "JSON",
            data: {'page': page, 'user_idx': user_idx},
            success: function (result) {
                if (result.status == "success") {
                    $('#bookmark_contents').append(result.html);
                    $('#bookmark_contents_btn').html('');
                    $('#bookmark_contents_btn').append(result.btn_html);
                } else {
                    alert('오류가 발생 되었습니다.');
                }
            },

        });
    }

    function moreDebateRoom(page){
        var user_idx = $('#user_idx').val();
        $.ajax({
            url: "/myPage/moreDebateRoom",
            method: "POST",
            dataType: "JSON",
            data: {'page': page, 'user_idx': user_idx},
            success: function (result) {
                if (result.status == "success") {
                    $('#debate_room').append(result.html);
                    $('#debate_room_btn').html('');
                    $('#debate_room_btn').append(result.btn_html);
                } else {
                    alert('오류가 발생 되었습니다.');
                }
            },
        });
    }

    // 이미지 업로드
    function userImageUpload( img_id ){
        var data        = new FormData();
        var user_idx    = $('#user_idx').val();
        $.each($('#' + img_id + '_file')[0].files, function (i, file) {
            data.append('file-' + i, file);
            data.append('user_idx', user_idx);
        });

        $.ajax({
            url         : "/upload/userImageUpload",
            type        : "POST",
            processData : false,
            contentType : false,
            data        : data,
            dataType    : "JSON",
            success     : function (result) {
                console.log(result);
                if( result.status == "success" ){
                    $('#user_img').empty();
                    $('#user_img').attr('src', result.image_src);
                    return;
                }else{
                    alert('오류가 발생 되었습니다.');
                    return;
                }

            },
        });
    }

    function updateUserInfo(){
        var param           = {};
        var user_idx        = $('#user_idx').val();
        var nickname        = $('#nickname').val();
        var school          = $('#school').val();
        var address         = $('#address').val();
        var category_idx    = $('#user_category').val();

        param.user_idx      = user_idx;
        param.nickname      = nickname;
        param.school        = school;
        param.address       = address;
        param.category_idx  = category_idx;

        $.ajax({
            url     : "/myPage/userInfoUpdate",
            method  : "POST",
            dataType: "JSON",
            data    : param,
            success: function(result){
                if(result.status == "success") {
                    alert('개인정보 수정이 완료되었습니다.');
                    location.reload();
                }else{
                    alert('데이터 에러 관리자에게 문의해 주세요.');
                }
            },

        });
    }

    function myQnaAnswer(){
        $('.myqna-answer').each(function(){
            var content             = $(this).children('.txt');
            var content_txt         = $.trim(content.text());
            var content_txt_short   = content_txt.substring(0, 120) + "...";
            var content_btn_more    = $('<a href="javascript:toggle_content();">더 보기</a>');

            $(this).append(content_btn_more);

            if(content_txt.length >= 120){
                content.text(content_txt_short);
            }else{
                content_btn_more.hide();
            }

            content_btn_more.click(toggleContent);

            function toggleContent(){
                if($(this).hasClass('short')){
                    // 접기 상태
                    $(this).text('더보기');
                    content.text(content_txt_short);
                    $(this).removeClass('short');
                }else{
                    // 더보기 상태
                    $(this).text('접기');
                    content.text(content_txt);
                    $(this).addClass('short');
                }
            }
        });
    }

    /*자주하는 질문-더보기*/
$(document).ready(function(){
    $('.myqna-answer').each(function(){
        var content             = $(this).children('.txt');
        var content_txt         = $.trim(content.text());
        var content_txt_short   = content_txt.substring(0, 120) + "...";
        var content_btn_more    = $('<a href="javascript:toggle_content();">더 보기</a>');

        $(this).append(content_btn_more);

        if(content_txt.length >= 120){
            content.text(content_txt_short);
        }else{
            content_btn_more.hide();
        }

        content_btn_more.click(toggleContent);

        function toggleContent(){
            if($(this).hasClass('short')){
                // 접기 상태
                $(this).text('더보기');
                content.text(content_txt_short);
                $(this).removeClass('short');
            }else{
                // 더보기 상태
                $(this).text('접기');
                content.text(content_txt);
                $(this).addClass('short');
            }
        }
    });
});
</script>