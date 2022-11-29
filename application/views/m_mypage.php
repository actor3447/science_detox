<!-- MAIN -->
<div class="container" role="main" id="container">
    <div class="contents">
        <div class="body-group">
            <div class="body-heading">
                <div class="header-group">
                    <h3 class="other teritory">마이페이지<span>관심있는 콘텐츠를 모아보세요</span></h3>
                </div>
                <div class="myinfo-group">
                    <div class="myinfo-heading">
                        <input type="hidden" id="user_idx" value="<?=$user_idx?>">
                        <input type="file" id="1_file" style="display: none" onchange="userImageUpload('1')"/>
                        <div class="img-group" id="user_img_upload">
                            <img src="<?=$user_img ? $user_img : '/public/images/thumb_user.png'?>" id="user_img"/>
                        </div>
                        <div class="userinfo-group">
                            <div class="nickname"><?=$user_nickname?></div>
                            <div class="name-group">
                                <span class="name"><?=$user_name?></span>
                            </div>
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
            <div class="body-con">
                <!--
                <div class="section-group">
                    <div class="header-group pdt17">
                        <h4 class="h4">내가 좋아하는 콘텐츠</h4>
                    </div>
                    <ul class="favorcon-lists" id="like_contents">
                        <?foreach ($like_contents as $rows_l):?>
                        <li>
                            <div class="btn-favorcon">
                                <?$contents_img = json_decode($rows_l['img_info'])?>
                                <img src="<?=$contents_img->img_path?>" alt="콘텐츠 제목">
                                <div class="favor-info">
                                    <span class="title"><?=$rows_l['title']?></span>
                                    <span class="explain"><?=strip_tags($rows_l['contents_info'])?></span>
                                </div>
                            </div>
                        </li>
                        <?endforeach;?>
                    </ul>

                    <div class="btn-group" id="like_contents_btn">
                        <button type="button" class="btn-more bg-white" onclick="moreMobileLikeContents('2')"><span>더보기</span></button>
                    </div>
                </div>
                -->

                <div class="section-group">
                    <div class="header-group pdt17">
                        <h4 class="h4">책갈피</h4>
                    </div>
                    <div class="my_notice1 my_notice" style="<?=(count($bookmark_contents) > 0) ? ' display: none;' : ''?>">아직 책갈피가 없네요! 콘텐츠를 보러 갈까요?</div>
                    <ul class="favorcon-lists" id="bookmark_contents">
                        <?foreach ($bookmark_contents as $rows_b):?>
                            <li>
                                <a href="/main?link_idx=<?=$rows_b['idx']?>">
                                    <div class="btn-favorcon">
                                        <?$contents_img = json_decode($rows_b['img_info'])?>
                                        <img src="<?=$contents_img->img_path?>" alt="콘텐츠 제목">
                                        <div class="favor-info">
                                            <span class="title"><?=$rows_b['title']?></span>
                                            <span class="explain" style="display: none;"><?=strip_tags($rows_b['contents_info'])?></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?endforeach;?>
                    </ul>
                    <?if(!empty($bookmark_contents)):?>
                        <?if(!empty($bookmark_contents_next_btn)):?>
                        <div class="btn-group" id="bookmark_contents_btn">
                            <button type="button" class="btn-more bg-white" onclick="moreMobileBookmark('2')"><span>더보기</span></button>
                        </div>
                        <?endif;?>
                    <?endif;?>
                </div>

                <div class="section-group">
                    <div class="header-group pdt17">
                        <h4 class="h4">내가 참여 했던 토론</h4>
                    </div>
                    <div class="my_notice2 my_notice" style="<?=(count($debate_room) > 0) ? 'display: none;' : ''?>">아직 참여한 토론이 없네요. V토론에서 참여해 보세요!</div>
                    <ul class="debate-lists" id="debate_room">
                        <?foreach($debate_room as $d_rows):?>
                            <?if( $d_rows['open_yn'] == 'Y' ):?>
                                <li class="ing">
                                    <div class="debate-group">
                                        <div class="debate-heading">
                                            <img src="<?=$d_rows['img_path']?>" alt="">
                                            <div class="debate-flag">토론진행중</div>
                                        </div>
                                        <div class="debate-body">
                                            <div class="dbbody-middle">
                                                <?=$d_rows['title']?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="debate-footer flex-center">
                                        <a href="/debate/chat?room_idx=<?=$d_rows['idx']?>" class="btn-primary"><span>토론 참여 하기</span></a>
                                    </div>
                                </li>
                            <?else:?>
                                <li class="end">
                                    <div class="debate-group">
                                        <div class="debate-heading">
                                            <img src="<?=$d_rows['img_path']?>" alt="">
                                            <div class="debate-flag">토론종료</div>
                                        </div>
                                        <div class="debate-body">
                                            <div class="dbbody-middle">
                                                <?=$d_rows['title']?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="debate-footer flex-center">
                                        <a href="/debate/chat?room_idx=<?=$d_rows['idx']?>" class="btn-secondary"><span>토론 다시보기</span></a>
                                    </div>
                                </li>
                                <?endif;?>
                        <?endforeach;?>
                    </ul>
                    <?if(!empty($debate_room)):?>
                        <?if(!empty($debate_room_next_btn)):?>
                        <div class="btn-group" id="debate_room_btn">
                            <button type="button" class="btn-more bg-white" onclick="moreMobileDebateRoom('2')"><span>더보기</span></button>
                        </div>
                        <?endif;?>
                    <?endif;?>
                </div>

                <div class="section-group bg-lightblue">
                    <div class="header-group pdt17">
                        <h4 class="h4">내가 한 질문</h4>
                    </div>
                    <div class="my_notice3 my_notice" style="<?=(count($mento_question) > 0) ? 'display: none;' : ''?>">아직 아무 질문도 하지 않았네요. Q챗에서 질문을 올려 보세요!</div>
                    <ul class="myque-lists" id="mento_question">
                        <?foreach ($mento_question as $rows_m):?>
                            <li class="<?=($rows_m['request_yn'] == 'Y') ? 'complete' : ''?>">
                                <div class="myqna-group">
                                    <div class="myque-heading">
                                        <div class="question"><?=$rows_m['content']?></div>
                                        <div class="answer txt"><?=$rows_m['request_content']?></div>
                                    </div>
                                </div>
                                <div class="myqna-result">
                                    <?if($rows_m['request_yn'] == 'Y'):?>
                                        <div class="btn-round-fill" style="text-align:center;"><span style="margin-top:6px;">답변완료</span></div>
                                    <?else:?>
                                        <div class="btn-round-fill" style="text-align:center;"><span style="margin-top:6px;">답변미완료</span></div>
                                    <?endif;?>
                                    <?$date     = explode(' ', $rows_m['reg_date'])?>
                                    <span class="date"><?=$date[0]?></span>
                                </div>
                            </li>
                        <?endforeach;?>
                    </ul>
                    <?if(!empty($mento_question)):?>
                        <?if(!empty($mento_question_next_btn)):?>
                        <div class="btn-group" id="mento_question_btn">
                            <button type="button" class="btn-more bg-white" onclick="moreMobileMentoQuestion('2')"><span>더보기</span></button>
                        </div>
                        <?endif;?>
                    <?endif;?>
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

        /*자주하는 질문-더보기*/
        $('.myque-heading').each(function(){
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

    function moreMobileLikeContents(page){
        var user_idx    = $('#user_idx').val();
        $.ajax({
            url : "/mypage/moreMobileLikeContents",
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

    function moreMobileMentoQuestion(page){
        var user_idx    = $('#user_idx').val();
        $.ajax({
            url : "/myPage/moreMobileMentoQuestion",
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

    function moreMobileBookmark(page){
        var user_idx = $('#user_idx').val();
        $.ajax({
            url: "/myPage/moreMobileBookmark",
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

    function moreMobileDebateRoom(page){
        var user_idx = $('#user_idx').val();
        $.ajax({
            url: "/myPage/moreMobileDebateRoom",
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
        $('.myque-heading').each(function(){
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
</script>