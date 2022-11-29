<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0,user-scalable=no,viewport-fit=cover">
<!--    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">-->
    <title>싸이언스디톡s</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard/dist/web/static/pretendard.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/css/swiper.css">
    <link rel="stylesheet" href="/public/css/ui_layout.css">
    <link rel="stylesheet" href="/public/css/ui_pc_common.css">
    <link rel="stylesheet" href="/public/css/common.css">
    <!-- <link rel="stylesheet" href="/public/css/ui_pc_common.css"> -->
    <script src="/public/js/libs/jquery-3.6.0.min.js"></script>
    <script src="/public/js/libs/swiper.min.js"></script>
    <script src="/public/js/libs/gsap.min.js"></script>
    <script src="/public/js/libs/EasePack.min.js"></script>
    <script src="/public/js/libs/useragent.js"></script>
    <script src="/public/js/libs/jquery.bpop.js"></script>
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
<div class="wrapper chat">
    <!-- HEADING -->
    <header class="header" id="header">
        <div class="header-inner">
            <h1>
                <a href="/main" class="btn-logo on" title="싸이언스디톡스 홈으로 이동">싸이언스디톡스</a>
            </h1>
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

    <!-- MAIN -->
    <div class="container" role="main" id="container">
        {yield}
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
                                <select id="debateInfo1" class="ui-sct">
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
                    <button type="button" class="btn btn-quinary"  id="btn-regist-room"><span>만들기</span></button>
                    <button type="button" class="btn btn-senary" onclick="Science.popup.close(this,'#popupDebate')"><span>취소</span></button>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-close"><span class="blind">팝업닫기</span></button>
    </div>
</div>
<!--// POPUP : 토론하기 -->
<!-- POPUP : 1:1질문 -->
<div class="popup-group" id="popupQuestion" role="dialog" >
    <div class="dim"></div>
    <div class="popup-content" tabindex="-1">
        <div class="popup-cover">
            <div class="popup-heading">
                <h5 class="popup-title" >멘토에게 질문 하기</h5>
            </div>
            <div class="popup-body">
                <div class="popup-inner">
                    <div class="dl-group">
                        <input type="hidden" id="mento_idx" value="">
                        <!--
                        <div class="ui-dl">
                            <div class="ui-dt">
                                <label for="QueInfo0">카테고리</label>
                            </div>
                            <div class="ui-dd">
                                <select id="QueInfo0" class="ui-sct text-center col-6">
                                    <?foreach ($category as $rows2):?>
                                        <option value="<?=$rows2['idx']?>"><?=$rows2['title']?></option>
                                    <?endforeach;?>
                                </select>
                            </div>
                        </div>
                        -->
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
                                <textarea class="ui-txa" id="QueInfo2" cols="30" rows="4" placeholder="내용을 입력해 주세요."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-group flex-center mgt30">
                    <button type="button" class="btn btn-quinary" id="askRegist"><span>보내기</span></button>
                    <button type="button" class="btn btn-senary" id="askCancle"><span>취소</span></button>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-close"><span class="blind">팝업닫기</span></button>
    </div>
</div>
<!--// POPUP : 1:1질문 -->
<!-- POPUP : 맨토 -->
<div class="popup-group heading-none" id="popupMento" role="dialog" aria-labelledby="title-dialog">
    <div class="dim"></div>
    <div class="popup-content bg-lightgray" tabindex="-1">
        <div class="popup-cover">
            <div class="popup-heading">
                <h5 class="popup-title" >멘토 상세 팝업</h5>
            </div>
            <div class="popup-body">
                <div class="popup-inner">
                    <div class="mento-group">
                        <div class="btn-mento" title="팝업열기">
                            <div class="mento-heading">
                                <img id="mento_info_img" src="" alt="홍 길동 멘토 사진">
                            </div>
                            <div class="mento-body">
                                <div class="mento-body-title" id="mento_info_name"></div>
                                <ul class="mento-detail-lists">
                                    <li id="mento_info_education"></li>
                                    <li id="mento_info_category"></li>
                                </ul>
                            </div>
                        </div>
                        <div class="mento-footer">
                            <button type="button" title="팝업열기" class="btn-question" id="mento_info_question" onclick="">
                                <span>1:1 질문하기</span>
                            </button>
                        </div>
                    </div>
                    <div class="meto-intro" id="mento_info_comment">
                        멘토 소개
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-close" id="mento_info_close"><span class="blind">팝업닫기</span></button>
    </div>
</div>
<!-- POPUP : 맨토 -->
<script>
    $(function(){
        $('#askCancle').click(function(){
            $('#popupQuestion').removeClass('active');
            $('#mento_idx').val('');
        })

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
                    }
                },
            });
        })
    })
</script>
</body>
</html>