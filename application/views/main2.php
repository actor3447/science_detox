<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0,user-scalable=no,viewport-fit=cover">
    <title>싸이언스디톡스</title>
    <link rel="stylesheet" as="style"crossorigin href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard/dist/web/static/pretendard.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/css/swiper.css">
    <link rel="stylesheet" href="/public/css/ui_layout.css">
    <link rel="stylesheet" href="/public/css/ui_pc_common.css">
    <!-- <link rel="stylesheet" href="/public/css/ui_pc_common.css"> -->
    <script type="text/javascript" src="/public/js/libs/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="/public/js/libs/swiper.min.js"></script>
    <script type="text/javascript" src="/public/js/libs/gsap.min.js"></script>
    <script type="text/javascript" src="/public/js/libs/EasePack.min.js"></script>
    <script type="text/javascript" src="/public/js/libs/useragent.js"></script>
    <script type="text/javascript" src="/public/js/ui_common.js"></script>
    <!-- 개발시 아래 삭제 -->
    <script type="text/javascript" src="/public/js/header_footer_guide.js"></script>
</head>
<body>
<div class="skip-group">
    <a href="#container" class="btn-skip">본문바로가기</a>
</div>
<!-- // WRAPPER -->
<div class="wrapper main">
    <!-- HEADING -->
    <header class="header" id="header">
        <div class="header-inner">
            <h1>
                <a href="" class="btn-logo" title="싸이언스디톡스 홈으로 이동"></a>
            </h1>
            <nav class="nav-group">
                <ul class="nav-ul">
                    <li>
                        <a href="" class="btn-menu">싸이언스디톡S</a>
                    </li>
                    <li>
                        <a href="" class="btn-menu ico-debate">토론</a>
                    </li>
                    <li>
                        <a href="" class="btn-menu ico-chat">쳇</a>
                    </li>
                </ul>
            </nav>
            <div class="util-group">
                <a href="https://auth.dongascience.com/?referer_url=<?php echo urlencode(CURRENT_URI); ?>" class="btn-user">
                    <span class="user-name">login</span>
                    <spin class="ico-user"></spin>
                </a>
                <a href="https://auth.dongascience.com/logout.php?referer_url=<?php echo urlencode(CURRENT_URI); ?>" class="btn-user">
                    <span class="user-name">logout</span>
                    <spin class="ico-user"></spin>
                </a>
                <a href="javascript:getTest();" class="btn-user">
                    <span class="user-name"><?php echo $this->session->userdata('memName'); ?></span>
                    <spin class="ico-user"></spin>
                </a>
            </div>
        </div>
    </header>
    <!-- HEADING -->

    <!-- MAIN -->
    <div class="container" role="main" id="container">
        <div class="contents">
            <div class="con-group">
                <div class="con-heading">
                    <div class="swiper main-swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <button type="button" class="btn-swiper">
                                    <div class="img-group">
                                        <img src="/public/images/thum0.png" alt="">
                                    </div>
                                    <div class="txt-group">
                                        <div class="title">식물연구</div>
                                        <p>인간에게 도움을 주는 식물은 어떤 것이 있을까?<br>
                                            인간에게 도움을 주는 식물은 어떤 것이 있을까?<br>
                                            인간에게 도움을 주는 식물은 어떤 것이 있을까?<br>
                                        </p>
                                    </div>
                                </button>
                            </div>
                            <div class="swiper-slide">
                                <button type="button" class="btn-swiper">
                                    <div class="img-group">
                                        <img src="/public/images/thum1.png" alt="">
                                    </div>
                                    <div class="txt-group">
                                        <div class="title">우주연구</div>
                                        <p>인간에게 도움을 주는 우주에는 어떤 것이 있을까?<br>
                                            인간에게 도움을 주는 우주에는 어떤 것이 있을까?<br>
                                            인간에게 도움을 주는 우주에는 어떤 것이 있을까?<br>
                                        </p>
                                    </div>
                                </button>
                            </div>
                            <div class="swiper-slide">
                                <button type="button" class="btn-swiper">
                                    <div class="img-group">
                                        <img src="/public/images/thum2.png" alt="">
                                    </div>
                                    <div class="txt-group">
                                        <div class="title">동물연구</div>
                                        <p>인간에게 도움을 주는 동물은 어떤 것이 있을까?<br>
                                            인간에게 도움을 주는 동물은 어떤 것이 있을까?<br>
                                            인간에게 도움을 주는 동물은 어떤 것이 있을까?<br>
                                        </p>
                                    </div>
                                </button>
                            </div>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>

                    <script>
                        $(document).ready(function(){
                            var mainSwiper = new Swiper(".main-swiper", {
                                slidesPerView: 'auto',
                                spaceBetween:100,
                                centeredSlides: true,
                                loop:true,
                                navigation: {
                                    nextEl: ".swiper-button-next",
                                    prevEl: ".swiper-button-prev",
                                }
                            });
                        })
                    </script>

                    <div class="scmotion-group">
                        <div class="img-group">
                            <img src="/public/images/ico_scroll.svg" alt="스크롤하세요">
                        </div>
                        <div class="img-group">
                            <img src="/public/images/ico_scroll_txt.png" alt="스크롤하세요">
                        </div>

                    </div>
                </div>
                <div class="con-body loc-center">
                    <div class="science-heading">
                        <div class="img-group text-center">
                            <img src="/public/images/img_neon.png" alt="싸이언스디톡S">
                        </div>

                        <div class="science-title-group">
                            <ul class="science-btn-group">
                                <li>
                                    <button type="button" class="btn-dodebate" title="팝업열기" onclick="Science.popup.open(this,'#popupDebate');">
                                        <span>토론하기</span>
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="btn-doquetion" title="팝업열기" onclick="Science.popup.open(this,'#popupQuestion');">
                                        <span>1:1질문</span>
                                    </button>
                                </li>
                            </ul>
                            <div class="header-group">
                                <h3 class="h3">"식물 연구"</h3>
                            </div>
                        </div>
                    </div>
                    <div class="science-body">
                        <div class="repre-group">
                            <img src="/public/images/thum0_photo.png" alt="식물연구">
                        </div>
                        <p class="science-detail">
                            이상 아름답고 청춘의 청춘에서만 인도하겠다는 찾아다녀도, 것이다. 안고, 있는 바이며,
                            수 크고 천고에 위하여 쓸쓸하랴? 오직 하는 이상 열매를 보배를 사랑의 쓸쓸한 방지하는 약동하다.
                            사랑의 소리다.이것은 풍부하게 원대하고, 두손을 위하여서.<br>
                            피가 장식하는 뭇 무엇을 사막이다. 가슴에 동력은 용감하고 따뜻한 가치를 못할 때문이다. 간에
                            생생하며, 피부가 발휘하기 것이 것이다. 청춘은 가치를 싶이 것이다. 수 피어나기 되려니와,
                            가진 이상은 얼마나 것이다.<br><br>

                            많이 커다란 크고 힘차게 보는 것이다. 보배를 날카로우나 방지하는 같으며, 것이다.보라, 속에 있으며,
                            용감하고 듣는다. 피어나기 풀이 듣기만 싸인 있다. 얼음 들어 행복스럽고 하여도 같은
                            오직 싹이 눈에 이상이 것이다. 피고 오직 품고 사랑의 찾아다녀도, 이것이다. 사랑의 남는 인간이 용기
                            가 얼마나 듣는다. 노래하며 수 생생하며, 힘차게 원대하고, 구하지 얼음과 있으랴? 있음으로써 앞이
                            것은 같이, 커다란 찾아다녀도, 것이다. 장식하는 위하여, 타오르고 아니더면, 이상 이것이야말로
                            풍부하게 예수는 아니한 교향악이다.<br><br>

                            인도하겠다는 무엇이 싹이 것은 피에 살 칼이다. 따뜻한 방황하여도, 위하여 석가는 끓는다. 청춘의
                            불러 그것은 소금이라 청춘은 그들은 그리하였는가? 할지니, 바이며, 안고, 바이며, 이성은 그리하였
                            는가? 힘차게 열락의 청춘이 무한한 따뜻한 인생에 그들의 품었기 이것이다. 얼음에 그들을 보이는
                            인간의 역사를 가진 끓는다. 찾아 천자만홍이 인류의 시들어 있으랴? 남는 방황하여도,
                            가슴이 우리의 무엇을 때문이다. 현저하게 못하다 밝은 안고, 찾아다녀도, 않는 가는 인생을 풀밭에 끓는다.
                        </p>
                        <ul class="science-info">
                            <li>
                                <div class="info-views">
                                    <span class="ico-views"><span class="blind">뷰 카운트</span></span>
                                    <span class="num">12</span>
                                </div>
                            </li>
                            <li>
                                <!-- .btn-like 클릭시 .on추가 -->
                                <button type="button" class="btn-like" title="좋아요"></button>
                            </li>
                            <li>
                                <!-- .btn-bookmark 클릭시 .on추가 -->
                                <button type="button" class="btn-bookmark" title="책갈피 추가"></button>
                            </li>
                            <li>
                                <button type="button" class="btn-sns" title="소셜네트워크"></button>
                            </li>
                        </ul>
                    </div>
                    <div class="science-footer">
                        <div class="header-group text-center">
                            <h5 class="h5">관련 콘텐츠</h5>
                        </div>
                        <ul class="relation-group">
                            <li>
                                <a href="" class="btn-relation">
										<span class="relation-photo">
											<img src="/public/images/thum0_relation_photo0.png" alt="콘텐츠 제목1">
										</span>
                                    <span class="relation-title">콘텐츠 제목1</span>
                                </a>
                            </li>
                            <li>
                                <a href="" class="btn-relation">
										<span class="relation-photo">
											<img src="/public/images/thum0_relation_photo1.png" alt="콘텐츠 제목2">
										</span>
                                    <span class="relation-title">콘텐츠 제목2</span>
                                </a>
                            </li>
                            <li>
                                <a href="" class="btn-relation">
										<span class="relation-photo">
											<img src="/public/images/thum0_relation_photo2.png" alt="콘텐츠 제목3">
										</span>
                                    <span class="relation-title">콘텐츠 제목3</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="quick-group">
                        <button type="button" class="btn-quick do-refresh" title="리플래시"></button>
                        <a href="#header" class="btn-quick do-top" title="탑으로 이동"></a>
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
                        <span>편집인 : 박근태</span>
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
<div class="popup-group" id="popupDebate" role="dialog" aria-labelledby="title-dialog">
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
                                <select name="" id="debateInfo0" class="ui-sct text-center col-6">
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
                                <label for="debateInfo1">카테고리</label>
                            </div>
                            <div class="ui-dd">
                                <select name="" id="debateInfo1" class="ui-sct">
                                    <option value="">카테고리를 선택하세요</option>
                                    <option value="">카테고리1</option>
                                    <option value="">카테고리2</option>
                                    <option value="">카테고리3</option>
                                    <option value="">카테고리4</option>
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
                        <div class="ui-dl align-item-start">
                            <div class="ui-dt ">
                                <label for="debateInfo3">이미지 설정</label>
                            </div>
                            <div class="ui-dd">
                                <div class="file-group">
                                    <label for="a5" class="upload-photo"></label>
                                    <input type="file">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-group flex-center mgt30">
                    <button type="button" class="btn btn-quinary"><span>만들기</span></button>
                        <button type="button" class="btn btn-senary"><span>취소</span></button>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-close"><span class="blind">팝업닫기</span></button>
    </div>
</div>
<!-- POPUP : 토론하기 -->

<!-- POPUP : 1:1질문 -->
<div class="popup-group" id="popupQuestion" role="dialog" aria-labelledby="title-dialog">
    <div class="dim"></div>
    <div class="popup-content" tabindex="-1">
        <div class="popup-cover">
            <div class="popup-heading">
                <h5 class="popup-title" >멘토에게 질문 하기</h5>
            </div>
            <div class="popup-body">
                <div class="popup-inner">
                    <div class="dl-group">
                        <div class="ui-dl">
                            <div class="ui-dt">
                                <label for="QueInfo0">카테고리</label>
                            </div>
                            <div class="ui-dd">
                                <select name="" id="QueInfo0" class="ui-sct text-center col-6">
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
                                <textarea name="" id="QueInfo2" class="ui-txa" cols="30" rows="4" placeholder="내용을 입력해 주세요."></textarea>
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
</body>

</html>
<script>
    function getTest(){

        $.ajax({
            type: "POST",
            url: "http://211.43.210.112:8080/test",
            data: { 'send_text' : '안녕' },
            success: function(response){
                console.log(response)
            }
        });
    }
</script>
