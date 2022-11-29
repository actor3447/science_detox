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
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5ZWH85L"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
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
                <a href="/" class="btn-logo" title="동아 사이언스 디톡스 홈으로 이동"></a>
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
    <div class="container debate-body-group" role="main" id="container">
    {yield}
    </div>
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
                    <a href="/debate">
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
            $(document).ready(function(){
                // 0:사이언스디톡S, 1:토론, 2:채팅
                var num = 0;
                var menu = '<?=$this->uri->segment(1, 0);?>';
                if (menu == 'contents'){
                    num = 0;
                }else if(menu == 'debate'){
                    num = 1;
                }else if(menu == 'chat'){
                    num = 2;
                }
                Science.setGnb(num);
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

<!-- POPUP : 멘토를 소개 -->
<div class="popup-group" id="popupMento" role="dialog" aria-labelledby="title-dialog">
    <div class="dim"></div>
    <div class="popup-content" tabindex="-1">
        <div class="popup-cover">
            <div class="popup-heading">
                <h3 class="popup-title" >멘토를 소개합니다.</h3>
            </div>
            <div class="popup-body">
                <div class="popup-inner">
                    <div class="mento-info-group">
                        <input type="hidden" id="mento_idx" value="">
                        <div class="mento-info-heading">
                            <img src="/assets/images/thumb_mento_pop.png" id="mento_img" alt="가나다 멘토">
                        </div>
                        <div class="mento-info-body">
                            <h4 class="title" id="mento_name"></h4>
                            <p class="sub-title" id="mento_title"></p>
                        </div>
                    </div>
                    <div class="mento-detail ui-scroll" id="mento_comment"></div>
                    <div class="btn-group flex-center">
                        <button type="button" class="btn-debate" onclick="Science.popup.open(this,'#popupQue');"><span>1:1질문하기</span></button>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-close"><span class="blind">팝업닫기</span></button>
    </div>
</div>
<!-- // POPUP : 멘토를 소개 -->
<!-- POPUP : 멘토 1:1 질문하기 -->
<div class="popup-group" id="popupQue" role="dialog" aria-labelledby="title-dialog">
    <div class="dim"></div>
    <div class="popup-content" tabindex="-1">
        <div class="popup-cover">
            <div class="popup-heading">
                <h3 class="popup-title" >멘토 1:1 질문하기</h3>
            </div>
            <div class="popup-body">
                <div class="popup-inner que-popup-group">
                    <!--
                    <select name="" class="ui-sct col-7" id="QueInfo0">
                        <?foreach ($category as $rows):?>
                            <option value="<?=$rows['idx']?>"><?=$rows['title']?></option>
                        <?endforeach;?>
                    </select>
                    -->
                    <input type="text" class="ui-input medium" id="QueInfo1" placeholder="제목을 입력하세요">
                    <textarea name="" cols="30" rows="6" class="ui-txa medium" id="QueInfo2" placeholder="내용을 입력하세요."></textarea>
                    <div class="btn-group flex-center">
                        <button type="button" class="btn-debate" id="askRegist"><span>보내기</span></button>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-close"><span class="blind">팝업닫기</span></button>
    </div>
</div>
<!-- // POPUP : 멘토 1:1 질문하기 -->
</body>
</html>
<script>
    $(function(){
        $('#askRegist').click(function(){
            var param           = {};
            var mento_idx       = $('#mento_idx').val();
            // var category_idx    = $('#QueInfo0').val();
            var title           = $('#QueInfo1').val();
            var content         = $('#QueInfo2').val();

            param.mento_idx     = mento_idx;
            // param.category_idx  = category_idx;
            param.title         = title;
            param.content       = content;

            $.ajax({
                url : "/chat/mentoQnaRegistProcess",
                method : "POST",
                dataType : "JSON",
                data : param,
                success: function(result){
                    if(result.status == "success") {
                        alert('저장 되었습니다.');
                        window.location.href = "/chat";
                    }else if(result.status == "login_error"){
                        alert('로그인 후 이용 바랍니다.');
                        window.location.href = "https://auth.dongascience.com/?referer_url=http%3A%2F%2Fwww.scitalks.co.kr%2Fmain2";
                    }
                },
            });
        })
    })

    function getTest(){
        var send_text       = $('#qa_text').val();
        var send_html        = '';
        var request_html     = '';

        send_html            += '<div class="ui-que-dd">';
        send_html            += '    <div class="que-body">';
        send_html            += '        '+send_text+'';
        send_html            += '    </div>';
        send_html            += '</div>';

        $('.ui-que-dl').append(send_html);

        $.ajax({
            type: "GET",
            url: "http://211.43.210.112:8080/join",
            data: { 'send_text' : send_text },
            success: function(response){
                request_html    += '<div class="ui-que-dt">';
                request_html    += '    <div class="que-heading">';
                request_html    += '        <img src="/public/images/ico_qbot.png" alt="Q.bot">';
                request_html    += '    </div>';
                request_html    += '    <div class="que-body">';
                request_html    += '        '+response.msg+'';
                request_html    += '    </div>';
                request_html    += '</div>';
                $('.ui-que-dl').append(request_html);
                $('#qa_text').val('');
            }
        });
    }
</script>