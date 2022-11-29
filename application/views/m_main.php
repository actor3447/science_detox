<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0,user-scalable=no,viewport-fit=cover">
    <title>싸이언스디톡s</title>
    <link rel="stylesheet" as="style"crossorigin href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard/dist/web/static/pretendard.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/css/swiper.css">
    <link rel="stylesheet" href="/public/mobile/css/ui_layout.css">
    <link rel="stylesheet" href="/public/mobile/css/ui_m_common.css">
    <script type="text/javascript" src="/public/mobile/js/libs/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="/public/mobile/js/libs/swiper.min.js"></script>
    <script type="text/javascript" src="/public/mobile/js/libs/gsap.min.js"></script>
    <script type="text/javascript" src="/public/mobile/js/libs/EasePack.min.js"></script>
    <script type="text/javascript" src="/public/mobile/js/libs/useragent.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script type="text/javascript" src="/public/mobile/js/ui_common.js"></script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-PXFN2ZM226"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-PXFN2ZM226');
    </script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-5ZWH85L');</script>
    <!-- End Google Tag Manager -->
</head>
<script>
    $(function(){
        var cookie  = $.cookie('tutorial');
        if( cookie != 'Y' ){
            $('.tutorial-group').addClass('active');
        }



        //토론방 만들기
        $(document).on("click", "#btn-regist-room", function () {
            var param = {};
            param.member_cnt  = $("#dbt1").val();
            param.category    = $("#dbt2").val();
            param.title       = $("#dbt3").val();
            param.img_path    = $("#img_path").val();
            param.hash_tag    = $("#dbt4").val();

            if (param.member_cnt == ""){
                alert("인원수를 선택해 주세요.");
                return;
            }

            if (param.category == ""){
                alert("카테고리를 선택해 주세요.");
                return;
            }

            if (param.title == ""){
                alert("방제목을 입력해 주세요.");
                return;
            }


            $.ajax({
                url         : "/debate/registDebateRoom",
                type        : "POST",
                data        : param,
                dataType    : "JSON",
                success     : function (result) {
                    if( result.status == "success" ){
                        location.href = '/debate/chat?room_idx=' + result['room_idx'];
                    }else if(result.status == "logout" ){
                        alert('로그인 후 이용바랍니다.');
                        return;
                    }
                }
            });
        });

        //이미지 추가
        $(document).on("click", ".upload-photo", function () {
            $("#upload-file").click();
        });

        //이미지 삭제
        $(document).on("click", "#img_del_btn", function () {
            if (confirm("삭제 하시겠습니까?")){
                $("#img_path").val('');
                $(".upload-photo").css("background-image", "url(/public/images/bg_plus.png)");
            }
        });

        //토론 이미지 업로드
        $("#upload-file").change(function() {
            var src = $(this).attr("src");
            var target_img = $(this).find('img');
            var data = new FormData();
            $.each($('#upload-file')[0].files, function (i, file) {
                data.append('file-' + i, file);
            });

            $.ajax({
                url         : "/upload/uploadImage",
                type        : "POST",
                processData : false,
                contentType : false,
                data        : data,
                dataType    : "JSON",
                success     : function (result) {
                    if( result.status == "success" ){
                        $("#img_path").val(result.image_src);
                        $(".upload-photo").css("background-image", "url(" + result.image_src +")");
                        $("#img_del_btn").removeClass('none');
                    }else{
                        alert('이미지 파일이 아닙니다.');

                    }
                }
            });
        });

    })

    function showHowTo(){
        $('.tutorial-group').addClass('active');
    }
</script>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5ZWH85L"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="skip-menu">
    <a href="#container">본문바로가기</a>
</div>
<!-- // WRAPPER -->
<div class="wrapper main">
    <!-- HEADING -->
    <header class="header">
        <div class="header-inner">
            <h1 class="h1">
                <a href="/" class="btn-logo" title="동아 싸이언스 디톡스 홈으로 이동"></a>
            </h1>
            <div class="btn_wrap">
                <?if($this->session->userdata('user_name') == ''):?>
                    <a class="btn_login" href="https://auth.dongascience.com/?referer_url=<?=urlencode(CURRENT_URI)?>"><span>로그인</span></a>
                <?else:?>
                    <a class="btn_logout" href="https://auth.dongascience.com/logout.php?referer_url=<?=urlencode(LOGOUT_URI); ?>"><span>로그아웃</span></a>
                <?endif;?>
            </div>
        </div>
    </header>
    <!-- HEADING -->
    <!-- MAIN -->
    <div class="container" role="main" id="container">
        <?foreach ($contents as $rows):?>
        <div class="contents">
            <div class="body-group">
                <div class="main-heading">

                    <input type="hidden" id="user_idx" value="<?=$user_idx?>">
                    <input type="hidden" id="contents_idx" value="<?=$rows['idx']?>">
                    <input type="hidden" id="contents_use_idx" value="<?=$contents_use_idx?>">
                    <input type="hidden" id="status" value="0">
                    <input type="hidden" id="youtube_id" value="<?=$rows['youtube_link']?>">
                    <!-- 스와이퍼 영역 -->
                    <div class="swiper-detail">
                        <?$contents_img = json_decode($rows['img_info'], JSON_UNESCAPED_UNICODE)?>
                        <div class="img-group">
                            <?if($rows['type'] == 'youtube'):?>
                                <div class="mask_yt">
                                    <div class="yt-play"  ><button class="ytp-large-play-button ytp-button ytp-large-play-button-red-bg ytp-shorts-mode" aria-label="재생"><svg height="100%" version="1.1" viewBox="0 0 68 48" width="100%"><path class="ytp-large-play-button-bg" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#f00"></path><path d="M 45,24 27,14 27,34" fill="#fff"></path></svg></button></div>
                                </div>
                                <img class="main_img" src="<?=$contents_img['img_path']?>">
                                
                                <!--                                <iframe width="560" height="100%" src="https://www.youtube.com/embed/--><?//=$youtube_link?><!--" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->
                                <div id="player"></div>
                            <?else:?>
                               
                                <img src="<?=$contents_img['img_path']?>" alt="<?=$rows['title']?>" id="main_img">
                            <?endif;?>
                        </div>
                        <div class="swipe_effect swipe_like"></div>
                        <div class="swipe_effect swipe_pass"></div>
                        <script>
                            // 2. This code loads the IFrame Player API code asynchronously.
                            var tag = document.createElement('script');
                            tag.src = "https://www.youtube.com/iframe_api";
                            var firstScriptTag = document.getElementsByTagName('script')[0];
                            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                            // 3. This function creates an <iframe> (and YouTube player)
                            //    after the API code downloads.
                            // player;
                            youtube_id  = $('#youtube_id').val();
                            function onYouTubeIframeAPIReady() {
                                player = new YT.Player('player', {
                                    height: '100%',
                                    width: '640',
                                    videoId: youtube_id,
                                    playerVars: {
                                        mute:0,
                                        rel:0,
                                        controls:1,
                                    },
                                    events: {
                                        'onStateChange': onPlayerStateChange
                                    }
                                });
                            }

                            // 5. The API calls this function when the player's state changes.
                            //    The function indicates that when playing a video (state=1),
                            //    the player should play for six seconds and then stop.
                            var done = false;
                            function onPlayerStateChange(event) {
                                var status =    player.getPlayerState();
                                if( status === 1 ){
                                    $('.detail-body').css('display', 'none');
                                    /* $('.other-group').css('display', 'none');
                                    $('.info-group').css('display', 'none'); */
                                }
                                if( status === -1 || status === 0 || status === 2){
                                    $('.detail-body').removeAttr('style');
                                    /* $('.other-group').removeAttr('style');
                                    $('.info-group').removeAttr('style'); */
                                }
                            }
                            function stopVideo() {
                                player.stopVideo();
                            }
                               //btn-zoom
                            $(document).ready(function(){
                                $(document).on("click", "#btn-zoom", function(){
                                    var offset      = $("#section-detail").offset();
                                    var scroll_top  = $(".container").scrollTop() - 70;
                                    console.log(scroll_top);
                                    $(".container").animate({scrollTop:offset.top + scroll_top},800);
                                });
                                // 유튜브 마스크 클릭
                                $('.mask_yt').on("click", function(){
                                    if($('.mask_yt').hasClass('on')){
                                        $('.yt-play').removeClass('hide');
                                        $('.main_img').removeClass('hide');
                                        $('#player').css('opacity','0');
                                        player.pauseVideo();
                                    }else{
                                        $('#player').css('opacity','1');
                                        $('.yt-play').addClass('hide');
                                        $('.main_img').addClass('hide');
                                        player.playVideo();
                                    }
                                        $('.mask_yt').toggleClass('on');
                                });

                            });

                        </script>
                        <div class="detail-heading">
                            <button type="button" class="btn-howto" title="이용방법" onclick="showHowTo()"></button>
                            <!-- 책갈피 등록시 .on클래스 추가 -->
                            <button type="button" class="btn-hart" onclick="mobileLikeContents()"></button>
                            <button type="button" class="btn-bookmark <?=$bookmark_yn?>" title="책갈피" onclick="bookMarkContents();"></button>
                            <button type="button" class="btn-sns" title="SNS" onclick="Science.popup.open(this,'#popupShare')"></button>
                        </div>

                        <div class="detail-body">
                            <div class="btn-group">
                                <button type="button" class="btn-swiper-debate" onclick="registDebate()">V토론</button>
                                <button type="button" class="btn-swiper-chat" id="mento_chat">1:1채팅</button>
                            </div>
                            <div class="info-group">
                                <h3 class="h3" id="contents_title"><?=$rows['title']?></h3>
                            </div>
                            <div class="other-group">
                                <div class="did-see"><?=$rows['view_count']?></div>
                                <button type="button" class="btn-like <?=$like_yn?>"><?=$like_count?></button>
                            </div>
                            <ul class="sns-group">
                                <!--
                                <li>
                                    <button type="button" class="btn-smile"></button>
                                </li>-->
                                <!--<li>
                                    <button type="button" class="btn-hart" onclick="likeContents()"></button>
                                </li>-->
                                <!--<li>
                                    <button type="button" class="btn-zoom" id="btn-zoom"></button>
                                </li>-->
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="section-detail" id="section-detail">
                        <?=$rows['contents_info']?>
                    <div class="header-group text-center">
                        <h5 class="h5">관련 콘텐츠</h5>
                    </div>
                    <ul class="relation-lists">
                        <?foreach ($related_contents as $rows):?>
                        <?$contents_img = json_decode($rows['img_info'], JSON_UNESCAPED_UNICODE)?>
                        <li style="background-image: url('<?=$contents_img['img_path']?>')">
                            <a href="<?=$this->config->item('base_url').'/main/index?link_idx='.$rows['idx']?>" class="btn-relation">
                                <span class="title ellipsis"><?=$rows['title']?></span>
                            </a>
                        </li>
                        <?endforeach;?>
                    </ul>
                </div>

                <div class="top-btn-group">
                    <button type="button" class="btn-top" title="상단으로 이동"></button>
                </div>
            </div>
        </div>
        <?endforeach;?>
    </div>
    <!-- // MAIN -->

    <!-- FOOTER -->
    <footer class="footer">
        <nav class="nav">
            <ul class="nav-ul">
                <li>
                    <a href="/contents?search_field=curation">
                        <button type="button" class="btn-menu ico-search"><span>검색</span></button>
                    </a>
                </li>
                <li>
                    <a href="/debate/index">
                        <button type="button" class="btn-menu ico-debate"><span>V토론</span></button>
                    </a>
                </li>
                <li>
                    <a href="/main">
                        <button type="button" class="btn-menu ico-main on" title="메인"></button>
                    </a>
                </li>
                <li>
                    <a href="/chat">
                        <button type="button" class="btn-menu ico-chat"><span>Q챗</span></button>
                    </a>
                </li>
                <li>
                    <a href="/myPage">
                        <button type="button" class="btn-menu ico-my"><span>MY</span></button>
                    </a>
                </li>
            </ul>
        </nav>
        <script>
            $(document).ready(function () {
                Science.setGnb(2);

                $.ajax({
                    url         : "/index.php/api/getDebateCategory",
                    type        : "POST",
                    dataType    : "JSON",
                    success     : function (result) {
                        var html = "";
                        $.each(result, function(key, value){
                            html += '<option value="' + value.idx +'">' + value.title+'</option>';
                        });
                        $('#dbt2').append(html);
                    }
                });


            });
        </script>
    </footer>
    <!-- // FOOTER -->
</div>
<!-- // WRAPPER -->



<!-- POPUP: 토론방 만들기 -->
<div class="popup-group" id="popupDebate" role="dialog" aria-labelledby="title-dialog">
    <div class="dim"></div>
    <div class="popup-content" tabindex="-1">
        <div class="popup-cover">
            <div class="popup-heading">
                <h3 class="popup-title" >토론방을 만들어 보세요</h3>
            </div>
            <div class="popup-body">
                <div class="popup-inner">
                    <div class="ui-dl">
                        <div class="ui-dt">
                            <label for="dbt1">인원수</label>
                        </div>
                        <div class="ui-dd">
                            <select name="" id="dbt1" class="ui-sct col-6">
                                <option value="">선택</option>
                                <?for($i=2; $i <= 20;$i++):?>
                                    <option value="<?=$i?>"><?=$i?></option>
                                <?endfor;?>
                                <option value="0">무제한</option>
                            </select>
                        </div>
                        <div class="ui-dt mgt16">
                            <label for="dbt2">카테고리</label>
                        </div>
                        <div class="ui-dd mgt16">
                            <select name="" id="dbt2" class="ui-sct col-10">
                                <option value="">카테고리를 선택하세요</option>
                            </select>
                        </div>
                        <div class="ui-dt mgt16">
                            <label for="dbt3">방제목</label>
                        </div>
                        <div class="ui-dd mgt16">
                            <input type="text" id="dbt3" class="ui-input col-10" placeholder="제목을 입력해 주세요.">
                        </div>

                        <div class="ui-dt mgt16">
                            <label for="dbt4">해쉬태그</label>
                        </div>
                        <div class="ui-dd mgt16">
                            <input type="text" id="dbt4" class="ui-input col-10" placeholder="#초콜릿 #바나나">
                        </div>


                        <div class="ui-dt mgt16">
                            <label for="dbt4">이미지 설정</label>
                        </div>
                        <div class="ui-dd flex align-item-end mgt16">
                            <div class="file-group">
                                <!-- label에 이미지 넣기 -->
                                <label for="dbt5" class="upload-photo"></label>

                                <input type="file" id="upload-file">
                                <input type="hidden" id="img_path" name="img_path" >

                            </div>
                            <!-- 아래 버튼 .none 클래스 삭제시 나타남 -->
                            <button type="button" id="img_del_btn" class="btn btn-line small mgl10 none"><span>삭제</span></button>
                        </div>
                    </div>

                    <div class="btn-group flex-center">
                        <button type="button" class="btn-debate" id="btn-regist-room"><span>토론방 만들기</span></button>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-close"><span class="blind">팝업닫기</span></button>
    </div>
</div>


<!-- popup: 공유하기-->
<div class="popup-group" id="popupShare" role="dialog" aria-labelledby="title-dialog">
    <div class="dim"></div>
    <div class="popup-content" tabindex="-1">
        <div class="popup-cover">
            <div class="popup-heading">
                <h3 class="popup-title" >공유하기</h3>
            </div>
            <div class="popup-body">
                <div class="popup-inner">
                    <div class="share_btn_wrap">
                        <button class="btn_ka btn_share" onclick="shareKakao()"></button>
                        <button class="btn_fb btn_share" onclick="shareFacebook()"></button>
                        <button class="btn_tw btn_share" onclick="shareTwitter()"></button>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-close"><span class="blind">팝업닫기</span></button>
    </div>
</div>

<!-- POPUP : Tutorial -->
<!-- 안보이게 하려면 active 클래스 삭제 -->
<div class="tutorial-group" id="popupTutorial" role="dialog" >
    <div class="dim"></div>
    <div class="tutorial-content" tabindex="-1">
        <div class="tutorial-cover">
            <div class="tuto0">
                <img src="/public/mobile/images/tutorial_img0.png" alt="위로 스와이프 자세히 보기">
            </div>
            <div class="tuto1">
                <img src="/public/mobile/images/tutorial_img1.png" alt="오른쪽으로 스와이프 좋아요">
            </div>
            <div class="tuto2">
                <img src="/public/mobile/images/tutorial_img2.png" alt="왼쪽으로 스와이프 넘길게요">
            </div>
            <div class="tuto-lists">
                <ul class="sns-group">
                    <li>
                        <div class="btn-smile"></div>
                    </li>
                    <li>
                        <div class="btn-hart"></div>
                    </li>
                    <li>
                        <div class="btn-zoom"></div>
                    </li>
                </ul>
                <div class="tuto3">
                    <img src="/public/mobile/images/tutorial_img3.png" alt="터치로도 표현 할 수 있어요">
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-tutorial-close"><span class="blind">팝업닫기</span></button>
    </div>
</div>
<!-- // POPUP : Tutorial -->
</body>
</html>
<!--카카오 api 호출-->
<script src="https://developers.kakao.com/sdk/js/kakao.js"></script>
<script>
    var contents_idx    = $('#contents_idx').val();
    $(document).ready(function(){
        gtag('event', 'contents_view_count', {
            'event_category': '페이지 조회 수',
            'event_label': 'link_idx',
            'value': contents_idx
        });
        $(document).on('click', '.btn-tutorial-close',function(){
            $('.tutorial-group').removeClass('active');
            $.cookie('tutorial', 'Y', {expires: 1});
        });
        addViewCnt();
        $('.section-detail ol li').css('list-style', 'auto');
        $('.section-detail ul li').css('list-style', 'initial');
        $('#mento_chat').click(function(){
           location.href    = '/chat' 
        });
    });

    function likeContents(){
        var contents_idx        = $('#contents_idx').val();
        var contents_use_idx    = $('#contents_use_idx').val();
        var user_idx            = $('#user_idx').val();

        if( contents_idx == '' ){
            alert('컨텐츠를 선택해 주세요.');
            return;
        }

        if(user_idx == ''){
            alert('로그인 후 이용가능합니다.');
            return;
        }

        $.ajax({
            type    : "POST",
            url     : "/main/contentsMobileLikeReigstProcess",
            dataType: "JSON",
            data    : { 'contents_idx' : contents_idx, 'contents_use_idx' : contents_use_idx, 'user_idx' : user_idx},
            success: function(result){
                if(result.status == 'success'){
                    location.href='/main?link_idx='+result.contents_idx+'&contents_use_idx='+result.string_idx;
                }else if(result.status == 'delete_success'){
                    // alert('좋아요가 취소 되었습니다.');
                }else{
                    alert('데이터 에러 관리자에게 문의해 주세요.');
                }
            }
        });
    }

    function mobileLikeContents(){
        var contents_idx        = $('#contents_idx').val();
        var contents_use_idx    = $('#contents_use_idx').val();
        var user_idx            = $('#user_idx').val();

        if( contents_idx == '' ){
            alert('컨텐츠를 선택해 주세요.');
            return;
        }

        if(user_idx == ''){
            alert('로그인 후 이용가능합니다.');
            return;
        }

        $.ajax({
            type    : "POST",
            url     : "/main/contentsMobileLikeReigstProcess",
            dataType: "JSON",
            data    : { 'contents_idx' : contents_idx, 'contents_use_idx' : contents_use_idx, 'user_idx' : user_idx},
            success: function(result){
                if(result.status == 'success'){
                    $('.swipe_like').show();
                    setTimeout(function(){
                        $('.swipe_like').hide();
                    }, 500)
                }else if(result.status == 'delete_success'){
                    // alert('좋아요가 취소 되었습니다.');
                }else{
                    alert('데이터 에러 관리자에게 문의해 주세요.');
                }
            }
        });
    }

    function registDebate(){
        var user_idx        = $('#user_idx').val();
        if(user_idx == ''){
            alert('로그인 후 이용가능합니다.');
            return;
        }else{
            Science.popup.open(this,'#popupDebate');
        }
    }

    function bookMarkContents(){
        var contents_idx    = $('#contents_idx').val();
        var user_idx        = $('#user_idx').val();

        if( contents_idx == '' ){
            alert('컨텐츠를 선택해 주세요.');
            return;
        }

        if(user_idx == ''){
            alert('로그인 후 이용가능합니다.');
            return;
        }

        $.ajax({
            type    : "POST",
            url     : "/main/bookmarkReigstProcess",
            dataType: "JSON",
            data    : { 'contents_idx' : contents_idx, 'user_idx' : user_idx},
            success: function(result){
                if(result.status == 'success'){
                    alert('북마크에 추가되었습니다.');
                    $('.btn-bookmark ').addClass('on');
                }else if(result.status == 'delete_success'){
                    alert('북마크가 취소 되었습니다.');
                    $('.btn-bookmark ').removeClass('on');
                }else{
                    alert('데이터 에러 관리자에게 문의해 주세요.');
                }
            }
        });
    }


    function addViewCnt(){
        var contents_idx    = $('#contents_idx').val();
        if( contents_idx != '' ){
            $.ajax({
                type    : "POST",
                url     : "/main/addContentsViewCnt",
                dataType: "JSON",
                data    : { 'contents_idx' : contents_idx},
                success: function(result){
                    if(result.status == 'success'){

                    }
                }
            });
        }
    }

    function swiperAction(chkStr){
        var user_idx    = $('#user_idx').val();
        if(chkStr=='pass'){
            location.href=window.location.protocol + "//" + window.location.host + "/?idx=";
        }
        if(chkStr=='like'){
            if( user_idx != '' ){
                likeContents();
            }else{
                location.href=window.location.protocol + "//" + window.location.host + "/?idx=";
            }
        }
    }

    // SDK를 초기화 합니다. 사용할 앱의 JavaScript 키를 설정해 주세요.
    Kakao.init('7058a26e8ac2bc7d18dc66415b8cdd46');
    // SDK 초기화 여부를 판단합니다.
    console.log(Kakao.isInitialized());
    <?$host = (($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') ? "https" : "http") . "://$_SERVER[HTTP_HOST]"?>
    function shareKakao() {
        Kakao.Link.sendDefault({
            objectType: 'feed',
            content: {
                title: '싸이언스디톡스',
                description: $('#contents_title').text(),
                imageUrl:
                '<?php echo $host?>'+$('#main_img').attr('src'),
                link: {
                    mobileWebUrl: '<?php echo $host?>',
                    webUrl: '<?php echo $host?>',
                },
            },
            buttons: [
                {
                    title: '웹으로 보기',
                    link: {
                        mobileWebUrl: '<?php echo $host?>?link_idx='+$('#contents_idx').val(),
                        webUrl: '<?php echo $host?>?link_idx='+$('#contents_idx').val(),
                    },
                },
            ],
        })
    }

    function shareFacebook() {
        var idx = $('#contents_idx').val();
        var url = '<?=$this->config->item('base_url') . '/main/share?idx='?>' + idx;
        var facebook_url = "https://www.facebook.com/sharer/sharer.php?u=" + url + "&display=popup&ref=plugin&src=share_button";
        var fawin = window.open(facebook_url, 'fawin', 'width=600,height=500,scrollbars=no,resizable=no');
        if (fawin) fawin.focus();
    }

    function shareTwitter() {
        var title = '싸이언스디톡스';
        var idx = $('#contents_idx').val();
        var url = '<?=$this->config->item('base_url') . '/main/share?idx='?>' + idx;
        var twitter_url = "https://twitter.com/intent/tweet?text=" + title +
            "&url=" + url + "&original_referer=&ref=twit";
        var twwin = window.open(twitter_url, 'twwin', 'menubar=yes,toolbar=yes,status=yes,resizable=yes,location=yes,scrollbars=yes');
        if (twwin) twwin.focus();
    }
</script>