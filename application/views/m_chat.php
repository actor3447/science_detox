<!-- MAIN -->
<div class="container chat-body-group" role="main" id="container">
    <div class="contents">
        <div class="body-group">
            <div class="body-heading">
                <div class="header-group">
                    <h3 class="other">Q챗<span>멘토에게 1 : 1 로 질문해보세요!</span></h3>
                </div>
                <div class="swiper debate-swiper">
                    <div class="swiper-wrapper">
                        <?foreach ($mento_list as $rows):?>
                        <div class="swiper-slide">
                            <button type="button" class="btn-mento" onclick="Science.popup.open(this,'#popupMento'); mentoAsk(<?=$rows['idx']?>);">
                                <div class="img-group">
                                    <?$mento_img = json_decode($rows['img_info'])?>
                                    <img src="<?=$mento_img->img_path?>" alt="<?=$rows['name']?> 멘토">
                                </div>
                                <span class="title"><?=$rows['name']?> 멘토</span>
                            </button>
                        </div>
                        <?endforeach;?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <script>
                    $(document).ready(function(){
                        var swiper = new Swiper(".debate-swiper", {
                            slidesPerView: 4,
                            spaceBetween: 10,
                            slidesPerGroup: 4,
                            // loop: true,
                            // loopFillGroupWithBlank: true,
                            pagination: {
                                el: ".swiper-pagination",
                                clickable: true,
                            },
                        });
                    });
                </script>
            </div>

            <div class="body-con chat-con">
                <!-- 자주하는 질문 -->
                <div class="qna-group">
                    <ul class="qna-lists" id="message_ul">
                        <details class="details_wrap">
                            <summary class="qna-heading2">
                                <span class="btn-qna2">
                                    <span><span class="font-bold">Q.&nbsp; </span>자주 하는 질문 <span class="btn_arrow"></span></span>
                                </span>
                            </summary>
                            <?foreach ($qa_list as $rows):?>
                            <details class="details">
                                <summary class="qna-heading">
                                    <span class="btn-qna">
                                        <span><span class="font-bold">Q.&nbsp; </span><?=$rows['title']?></span>
                                    </span>
                                </summary>
                                <span class="qna-body"><?=$rows['description']?></span>
                            </details>
                            <?endforeach;?>
                        </details>
                    </ul>
                </div>
                <div class="chatque-group">
                    <div class="ui-que-dl ui-scroll">
                        <div class="ui-que-dt">
                            <div class="que-heading">
                                <img src="/public/mobile/images/ico_qbot.png" alt="Q.bot">
                            </div>
                            <div class="que-body">
                                무엇이 궁금하세요?
                            </div>
                        </div>
                    </div>

                    <div class="ipt-group que-ipt-group">
                        <input type="text" class="ui-que-ipt" id="qa_text" placeholder="질문을 입력하세요." onkeyup="enterKey();">
                        <button type="button" class="btn-send" title="질문보내기" onclick="getChatbotMassage()"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- // MAIN -->
<script>
    $(function(){
        $('#message_ul').click(function(){
            var open_yn = $('.details_wrap').attr('open');
            if( open_yn == 'open' ){
                $('.btn_arrow').removeClass('on');
            }else{
                $('.btn_arrow').addClass('on');
            }
        })
    });

    function enterKey(){
        if (window.event.keyCode == 13) {
            var message = $.trim($("#qa_text").val());
            if (message != ''){
                getChatbotMassage();
                $("#qa_text").val('');
            }
        }
    };

    function getChatbotMassage(){
        var send_text        = $('#qa_text').val();
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
            url: "https://chat.scitalks.co.kr/join",
            data: { 'send_text' : send_text },
            success: function(response){
                request_html    += '<div class="ui-que-dt">';
                request_html    += '    <div class="que-heading">';
                request_html    += '        <img src="/public/mobile/images/ico_qbot.png" alt="Q.bot">';
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

    function mentoAsk(mento_idx){
        $.ajax({
            url : "/chat/mentoMobileView",
            method : "POST",
            dataType : "JSON",
            data : {'mento_idx' : mento_idx},
            success: function(result){
                if(result.status == "success") {
                    $('#mento_idx').val('');
                    $('#mento_title').text('');
                    $('#mento_img').attr('src', '');
                    $('#mento_name').text('');
                    $('#mento_comment').text('');

                    $('#mento_idx').val(result.mento_idx);
                    $('#mento_title').text(result.mento_category);
                    $('#mento_img').attr('src', result.mento_img.img_path);
                    $('#mento_name').text(result.mento_name);
                    $('#mento_comment').text(result.mento_comment);
                }else {
                    alert('오류가 발생 되었습니다.');
                }
            },

        });
    }
    $(document).ready(function(){

        $('.details').each(function(){
            var content             = $(this).children('.qna-body');
            var content_txt         = $.trim(content.text());
            var content_txt_short   = content_txt.substring(0, 5) + "...";
            var content_btn_more    = $('<a href="javascript:toggle_content();">더 보기</a>');
            
            $(this).append(content_btn_more);

            if(content_txt.length >= 5){
                content.text(content_txt_short);
            }else{
                content_btn_more.hide();
            }

            content_btn_more.click(toggleContent);

            function toggleContent(){
                if($(this).hasClass('short')){
                    // 접기 상태
                    $(this).text('더 보기');
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