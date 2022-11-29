<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0,user-scalable=no">
    <title>싸이언스디톡s</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard/dist/web/static/pretendard.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/css/swiper.css">
    <link rel="stylesheet" href="/public/css/ui_layout.css">
    <link rel="stylesheet" href="/public/css/ui_pc_common.css">
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.18.1/build/cssreset-context/cssreset-context-min.css">
    <!-- <link rel="stylesheet" href="/public/css/ui_pc_common.css"> -->
    <script src="/public/js/libs/jquery-3.6.0.min.js"></script>
    <script src="/public/js/libs/swiper.min.js"></script>
    <script src="/public/js/libs/gsap.min.js"></script>
    <script src="/public/js/libs/EasePack.min.js"></script>
    <script src="/public/js/libs/useragent.js"></script>
    <script src="/public/js/ui_common.js"></script>
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
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5ZWH85L"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="skip-group">
    <a href="#container" class="btn-skip">본문바로가기</a>
</div>
<!-- // WRAPPER -->
<div class="wrapper main">
    <!-- HEADING -->
    <header class="header" id="header">
        <div class="header-inner">
            <h1><a href="/" class="btn-logo on" title="싸이언스디톡스 홈으로 이동">싸이언스디톡스</a></h1>
            <nav class="nav-group">
                <ul class="nav-ul">
                    <li>
                        <a href="/contents?search_field=curation" class="btn-menu"></a>
                    </li>
                    <li>
                        <a href="/debate/index" class="btn-menu ico-debate"></a>
                    </li>
                    <li>
                        <a href="/chat" class="btn-menu ico-chat"></a>
                    </li>
                </ul>
            </nav>
            <div class="util-group">
                <?if($this->session->userdata('user_name') != ''):?>
                    <a href="https://auth.dongascience.com/logout.php?referer_url=<?=urlencode(LOGOUT_URI); ?>" class="btn_logout">
                        <span class="txt_logout">로그아웃</span>
                    </a>
                    <a href="/myPage" class="btn-user">
                        <span class="user-name"><?=$this->session->userdata('user_name')?></span>
                        <span class="ico-user"></span>
                    </a>
                   
                <?else:?>
                    <a href="https://auth.dongascience.com/?referer_url=<?=urlencode(CURRENT_URI)?>" class="btn-user">
                        <span class="user-name">로그인</span>
                        <span class="ico-user"></span>
                    </a>
                <?endif;?>
            </div>
        </div>
    </header>
    <!-- HEADING -->
    <script>
        var url_array = [];
    </script>
    <!-- MAIN -->
    <div class="container" role="main" id="container">
        <input type="hidden" id="check_view" value="0">
        <input type="hidden" id="link_idx" value="<?=$link_idx?>">
        <input type="hidden" id="link_yn" value="N">
        <h2 class="none">본문내용</h2>
        <div class="contents">
            <div class="con-group">
                <div class="con-heading">
                    <div class="swiper main-swiper">
                        <div class="swiper-wrapper">
                        <?foreach ($contents as $rows):?>
                        <?$img_info = json_decode($rows['img_info'])?>
                            <div class="swiper-slide" >
                                <div class="btn-swiper" onclick="getContentsList(<?=$rows['idx']?>);" data-idx="<?=$rows['idx']?>">
                                    <div class="img-group">
                                        <?if( $rows['type'] == 'youtube' ):?>
                                            <iframe class="yt_iframe none" width="500" height="500" src="" title="YouTube video player"  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                            <div class="yt-play"  data-url="<?=$rows['youtube_link']?>" ><button class="ytp-large-play-button ytp-button ytp-large-play-button-red-bg ytp-shorts-mode" aria-label="재생"><svg height="100%" version="1.1" viewBox="0 0 68 48" width="100%"><path class="ytp-large-play-button-bg" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#f00"></path><path d="M 45,24 27,14 27,34" fill="#fff"></path></svg></button></div>
                                            <img src="<?=$img_info->img_path?>" alt="<?=$rows['title']?>" class="contents_img main_img">
                                        <?else:?>
                                            <img src="<?=$img_info->img_path?>" alt="<?=$rows['title']?>" class="main_img">
                                        <?endif;?>
                                    </div>
                                    <div class="txt-group">
                                        <div class="title"><?=$rows['title']?></div>
                                    </div>
                                </div>
                            </div>
                        <?endforeach;?>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>

                    </div>

                    <script>


                        var check_link    = '<?=$check_link?>';
                        var link_idx      = '<?=$link_idx?>';

                        window.onload = function() {

                            mainSwiper = new Swiper(".main-swiper", {
                                slidesPerView: 'auto',
                                spaceBetween:100,
                               // direction: 'horizontal',
                                centeredSlides: true,
                                simulateTouch:false,
                                loop:true,

                                on: {
                                    slideChangeTransitionEnd : function() {

                                        $('#check_view').val('0');
                                        var idx = $('.swiper-slide-active').find('.btn-swiper').attr('data-idx');

                                        // if( link_yn === 'N' ){
                                        //     if( link_idx !== '' ){
                                        //         $.ajax({
                                        //             type    : "POST",
                                        //             url     : "/main/getContentsTitle",
                                        //             dataType: "JSON",
                                        //             data    : { 'link_idx' : link_idx },
                                        //             success: function(result){
                                        //                 if(result.status == 'success'){
                                        //                     $('.swiper-slide-active').html('');
                                        //                     $('.swiper-slide-active').append(result.header_html);
                                        //
                                        //                     $('#link_yn').val('Y');
                                        //                 }
                                        //             }
                                        //         });
                                        //     }
                                        // };
                                        getContentsList(idx);

                                    },
                                    slideChange: function () {
                                        $('.swiper-slide').find('iframe').addClass('none');
                                        $('.swiper-slide').find('.contents_img').removeClass('none');
                                        $('.swiper-slide-active').find('iframe').attr('src', '');
                                        $('.swiper-slide-active').find('.yt-play').removeClass('none');
                                        $('.swiper-slide-active').find('.txt-group').removeClass('none');
                                    }
                                },
                                navigation: {
                                    nextEl: ".swiper-button-next",
                                    prevEl: ".swiper-button-prev",
                                }
                            });


                            $(document).on("click", ".yt-play", function () {
                                var url = $(this).attr('data-url');
                                $('.swiper-slide-active').find('iframe').attr('src', 'https://www.youtube.com/embed/' + url+ '?autoplay=1&rel=0&showinfo=0&controls=1');
                                $('.swiper-slide-active').find('iframe').removeClass('none');
                                $('.swiper-slide-active').find('.txt-group').addClass('none');
                                $(this).addClass('none')
                            });


                            if (check_link != ''){
                                mainSwiper.slideTo(check_link,  0, false);
                                getContentsList(link_idx);
                            }

                        }
                        $(window).resize(function($){
                            mainSwiper.update();
                        });


                    </script>

                    <div class="scmotion-group">
                        <div class="img-group">
                            <a href="#con-body" class="scroll">
                                <img class="mouse_motion" src="/public/images/mouse.gif" alt="스크롤하세요"><br>
                                <img src="/public/images/ico_scroll_txt.png" alt="스크롤하세요">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="con-body loc-center" id="con-body">
                    <div class="science-heading">
                        <div class="img-group text-center">
                            <img src="/public/images/img_neon.png" alt="싸이언스디톡S">
                        </div>

                        <div class="science-title-group">
                            <ul class="science-btn-group">
                                <li>
                                    <button type="button" class="btn-dodebate" title="토론하기" onclick="registDebate()">
                                        <span>토론하기</span>
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="btn-doquetion" title="팝업열기" onclick="location.href='/chat' ">
                                        <span>1:1질문</span>
                                    </button>
                                </li>
                            </ul>
                            <div class="header-group">
                                <h3 class="h3 contents_title" id="contents_title"></h3>
                            </div>
                        </div>
                    </div>
                    <div class="science-body">
                        <input type="hidden" id="contents_idx" value="">
                        <input type="hidden" id="user_idx" value="<?=$user_idx?>">
                        <div class="science-detail yui3-cssreset" id="contents_info">

                        </div>
                        <ul class="science-info">
                            <li>
                                <div class="info-views">
                                    <span class="ico-views"><span class="blind">뷰 카운트</span></span>
                                    <span class="num" id="view_count">12</span>
                                </div>
                            </li>
                            <li>
                                <div class="info-like">
                                    <!-- .btn-like 클릭시 .on추가 -->
                                    <button type="button" class="btn-like" title="좋아요" onclick="likeContents()"></button>
                                    <span class="num">1000</span>
                                </div>
                            </li>
                            <li>
                                <!-- .btn-bookmark 클릭시 .on추가 -->
                                <button type="button" class="btn-bookmark" title="책갈피 추가" onclick="bookMarkContents()"></button>
                            </li>
                            <li>
                                <button type="button" class="btn-sns" title="소셜네트워크"  onclick="Science.popup.open(this,'#popupShare')"></button>
                            </li>
                        </ul>
                    </div>
                    <div class="science-footer">
                        <div class="header-group text-center">
                            <h5 class="h5 white">관련 콘텐츠</h5>
                        </div>
                        <ul class="relation-group" id="related_contents">

                        </ul>
                    </div>
                    <div class="quick-group">
                        <button type="button" class="btn-quick do-refresh" onclick="window.location.reload()" title="리플래시"></button>
                        <a href="javascript:;" class="btn-quick do-top" title="탑으로 이동" onclick="scrollUp()"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- // MAIN -->

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-inner loc-center">
            <div class="footer-heading">
                <div class="img-group">
                    <img src="/public/images/logo_gray.png" alt="싸이언스디톡S">
                </div>
            </div>
            <div class="footer-body">
                <div class="footer-body-h">
                    <div class="footer-menu-group">
                        <ul class="footer-menu">
                            <li>
                                <a href="" class="btn-footer-link">개인정보취급방침</a>
                            </li>
                            <li>
                                <a href="" class="btn-footer-link">저작권&middot;콘텐츠 이용안내</a>
                            </li>
                        </ul>
                        <div class="footer-support">
                            <span class="title">제작지원 :&nbsp;</span>
                            <span class="img-group">
									<img src="/public/images/logo_support.png" alt="한국언론진흥재단">
								</span>
                        </div>
                    </div>
                    <div class="company-info">
                        <span>(주)동아사이언스 사이언스디톡S</span>
                        <span>제호 : 동아사이언스 사이언스디톡S</span>
                        <span>발행인 : 장경애</span>
                        <span>편집인 : 고선아</span>
                    </div>
                    <div class="ceo-info">
                        <span>대표 : 장경애</span>
                        <span>개인정보관리책임자 : 최수정(privacy@dongascience.com)</span>
                        <span>청소년보호책임자 : 신한식</span>
                    </div>
                    <div class="contact-info">
                        <span>서울시 용산구 청파로 109, 7층 (04370)</span>
                        <span>문의 : 02-6749-2000</span>
                        <span>팩스 : 02-3148-0789</span>
                        <span>사업자등록번호 : 101-81-62201 (사업자정보확인)</span>
                    </div>
                    <div class="copyright-info">
                        Copyright © Dongascience. All right reserved.
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- // FOOTER -->
</div>
<!-- // WRAPPER -->


<!-- POPUP : 토론하기 -->
<div class="popup-group" id="popupDebate" role="dialog" >
    <div class="dim"></div>
    <div class="popup-content" tabindex="-1">
        <div class="popup-cover">
            <div class="popup-heading">
                <h5 class="popup-title" >토론방을 만들어 보세요</h5>
            </div>
            <div class="popup-body">
                <div class="popup-inner">
                    <div class="dl-group">
                        <div class="ui-dl">
                            <div class="ui-dt">
                                <label for="debateInfo0">인원수</label>
                            </div>
                            <div class="ui-dd">
                                <select id="debateInfo0" class="ui-sct text-center col-6">
                                    <option value="">선택</option>
                                    <?for($i=2; $i <= 20;$i++):?>
                                        <option value="<?=$i?>"><?=$i?></option>
                                    <?endfor;?>
                                    <option value="0">무제한</option>
                                </select>
                            </div>
                        </div>
                        <div class="ui-dl">
                            <div class="ui-dt">
                                <label for="debateInfo1">카테고리</label>
                            </div>
                            <div class="ui-dd">
                                <select  id="debateInfo1" class="ui-sct">
                                    <option value="">카테고리를 선택하세요</option>
                                </select>
                            </div>
                        </div>
                        <div class="ui-dl">
                            <div class="ui-dt">
                                <label for="debateInfo2">방 제목</label>
                            </div>
                            <div class="ui-dd">
                                <input type="text" class="ui-ipt" id="debateInfo2" placeholder="제목을 입력해 주세요.">
                            </div>
                        </div>
                        <div class="ui-dl">
                            <div class="ui-dt">
                                <label for="debateInfo4">해쉬태그</label>
                            </div>
                            <div class="ui-dd">
                                <input type="text" class="ui-ipt" id="debateInfo4" placeholder="#초콜릿 #바나나">
                            </div>
                        </div>
                        <div class="ui-dl align-item-start">
                            <div class="ui-dt ">
                                <label for="upload-file">이미지 설정</label>
                            </div>
                            <div class="ui-dd flex align-item-end">
                                <div class="file-group">
                                    <label class="upload-photo"></label>
                                    <input type="file" id="upload-file">
                                    <input type="hidden" id="img_path" name="img_path" >
                                </div>
                                <!-- 아래 버튼 .none 클래스 삭제시 나타남 -->

                                <button type="button" id="img_del_btn" class="btn btn-senary small mgl10 none">
                                    <span>삭제</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-group flex-center mgt30">
                    <button type="button" class="btn btn-quinary" id="btn-regist-room"><span>만들기</span></button>
                    <button type="button" class="btn btn-senary"  onclick="Science.popup.close(this,'#popupDebate')"><span>취소</span></button>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-close"><span class="blind">팝업닫기</span></button>
    </div>
</div>
<!-- POPUP : 토론하기 -->

<!-- POPUP : 1:1질문 -->
<div class="popup-group" id="popupQuestion" role="dialog" >
    <div class="dim"></div>
    <div class="popup-content" tabindex="-1">
        <div class="popup-cover">
            <div class="popup-heading">
                <h5 class="popup-title" id="title-dialog1">멘토에게 질문 하기</h5>
            </div>
            <div class="popup-body">
                <div class="popup-inner">
                    <div class="dl-group">
                        <div class="ui-dl">
                            <div class="ui-dt">
                                <label for="QueInfo0">카테고리</label>
                            </div>
                            <div class="ui-dd">
                                <select id="QueInfo0" class="ui-sct text-center col-6">
                                    <option value="">선택</option>
                                    <option value="">1</option>
                                    <option value="">3</option>
                                    <option value="">4</option>
                                    <option value="">5</option>
                                </select>
                            </div>
                        </div>
                        <div class="ui-dl">
                            <div class="ui-dt">
                                <label for="QueInfo1">질문제목</label>
                            </div>
                            <div class="ui-dd">
                                <input type="text" class="ui-ipt" id="QueInfo1" placeholder="제목을 입력해 주세요.">
                            </div>
                        </div>
                        <div class="ui-dl">
                            <div class="ui-dt">
                                <label for="QueInfo2">질문내용</label>
                            </div>
                            <div class="ui-dd">
                                <textarea name="cont" id="QueInfo2" class="ui-txa" cols="30" rows="4" placeholder="내용을 입력해 주세요."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-group flex-center mgt30">
                    <button type="button" class="btn btn-quinary"><span>보내기</span></button>
                        <button type="button" class="btn btn-senary"><span>취소</span></button>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-close"><span class="blind">팝업닫기</span></button>
    </div>
</div>
<!-- POPUP : 1:1질문 -->

<!-- popup : sns공유하기 -->
<div class="popup-group" id="popupShare" role="dialog">
    <div class="dim"></div>
    <div class="popup-content" tabindex="-1">
        <div class="popup-cover">
            <div class="popup-heading">
                <h5 class="popup-title" >공유하기</h5>
            </div>
            <div class="popup-body">
                <div class="popup-inner">
                    <div class="share_btn_wrap">
                        <button class="btn_ka btn_share" onclick="shareKakao()"></button>
                        <button class="btn_fb btn_share" onclick="shareFacebook()"></button>
                        <button class="btn_tw btn_share" onclick="shareTwitter()"></button>
                    </div>
                </div>
                <div class="btn-group flex-center mgt30">
                    <button type="button" class="btn btn-senary" onclick="Science.popup.close(this,'#popupShare')"><span>취소</span></button>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-close"><span class="blind">팝업닫기</span></button>
    </div>
</div>
<!-- popup : sns공유하기 -->
<!--카카오 api 호출-->
<script src="https://developers.kakao.com/sdk/js/kakao.js"></script>
</body>
</html>
<script>
    $(window).scroll(function () {
        var height          = $(document).scrollTop();
        var check_view      = $('#check_view').val();
        var contents_idx    = $('#contents_idx').val();
        if( check_view == 0 ){
            if( height > 700){
                $('#check_view').val('1');
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

    });
    $(function(){
        var contents_idx    = $('#contents_idx').val();
        gtag('event', 'contents_view_count', {
            'event_category': '페이지 조회 수',
            'event_label': 'link_idx',
            'value': contents_idx
        });
        $('.swiper-button-next').click(function(){
            $('.swiper-slide-duplicate-active .btn-swiper').trigger('click');
            $('#check_view').val('0');
        });

        $('.swiper-button-prev').click(function(){
            $('.swiper-slide-duplicate-active .btn-swiper').trigger('click');
            $('#check_view').val('0');
        });


        //토론 카테고리
        $.ajax({
            url         : "/index.php/api/getDebateCategory",
            type        : "POST",
            dataType    : "JSON",
            success     : function (result) {
                var html = "";
                $.each(result, function(key, value){
                    html += '<option value="' + value.idx +'">' + value.title+'</option>';
                });
                $('#debateInfo1').append(html);
            }
        });


        //토론방 만들기
        $(document).on("click", "#btn-regist-room", function () {

            var param = {};
            param.member_cnt  = $("#debateInfo0").val();
            param.category    = $("#debateInfo1").val();
            param.title       = $("#debateInfo2").val();
            param.img_path    = $("#img_path").val();
            param.hash_tag    = $("#debateInfo4").val();

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
    });
    function registDebate(){
        var user_idx        = $('#user_idx').val();
        if(user_idx == ''){
            alert('로그인 후 이용가능합니다.');
            return;
        }else{
            Science.popup.open(this,'#popupDebate');
        }
    }
    function getContentsList(idx){
        $.ajax({
            type    : "POST",
            url     : "/main/getContentsList",
            dataType: "JSON",
            data    : { 'idx' : idx },
            success: function(result){
                if(result.status == 'success'){
                    $('#contents_info').html('');
                    $('#related_contents').html('');
                    $('#view_count').text('');
                    // $('.swiper-slide-active .img-group').append(result.img_src);
                    $('#contents_title').text(result.header_text);
                    // $('#contents_img').attr('src', result.img_src);
                    $('#contents_info').append(result.body_text);
                    $('#related_contents').append(result.related_contents);
                    $('#contents_idx').val(result.contents_idx);
                    $('#view_count').text(result.view_count);
                    $('#contents_info ol li').css('list-style', 'auto');
                    $('#contents_info ul li').css('list-style', 'initial');
                    $('#kakao_link_idx').val(idx);
                    $('.info-like .num').text(result.like_count);

                    if(result.like_yn == 'on'){
                        $('.btn-like').addClass('on');
                    }else{
                        $('.btn-like').removeClass('on');
                    }
                    if(result.bookmark_yn == 'on'){
                        $('.btn-bookmark').addClass('on');
                    }else{
                        $('.btn-bookmark').removeClass('on');
                    }
                }
            }
        });
    }
    function likeContents(){
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
            url     : "/main/contentsLikeReigstProcess",
            dataType: "JSON",
            data    : { 'contents_idx' : contents_idx, 'user_idx' : user_idx},
            success: function(result){
                if(result.status == 'success'){
                    $('.btn-like').addClass('on');
                }else if(result.status == 'delete_success'){
                    $('.btn-like').removeClass('on');
                }else{
                    alert('데이터 에러 관리자에게 문의해 주세요.');
                }
            }
        });
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
                    $('.btn-bookmark').addClass('on');
                }else if(result.status == 'delete_success'){
                    $('.btn-bookmark').removeClass('on');
                }else{
                    alert('데이터 에러 관리자에게 문의해 주세요.');
                }
            }
        });
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

    // SDK를 초기화 합니다. 사용할 앱의 JavaScript 키를 설정해 주세요.
    Kakao.init('7058a26e8ac2bc7d18dc66415b8cdd46');
    // SDK 초기화 여부를 판단합니다.
    console.log(Kakao.isInitialized());
    <?$host = ((stripos($_SERVER['SERVER_PROTOCOL'], 'https') == true) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']?>
    function shareKakao() {
        Kakao.Link.sendDefault({
            objectType: 'feed',
            content: {
                title: '싸이언스디톡스',
                description: $('#contents_title').text(),
                imageUrl:
                '<?php echo $host?>'+$('.main_img').attr('src'),
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
</script>