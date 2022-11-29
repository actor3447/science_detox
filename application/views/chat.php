<style>
    .ui-que-dl{max-height: 420px; overflow-y: scroll;}
</style>
<div class="contents">
    <div class="con-group">
        <div class="con-heading">
            <h2 class="h2 loc-center">
                <img src="/public/images/bg_chat.png" alt="Q챗 궁금한 것은 Q챗에 질문하세요/">
            </h2>
        </div>
        <div class="con-body loc-center pdl0-pdr0 pdt0 mgt41 bg-white">
            <div class="chat-group">
                <div class="chat-side">
                    <div class="header-group">
                        <h5 class="h5-small darkgray">멘토 질문 하기</h5>
                        <span>멘토에게 1:1로 질문해 보아요</span>
                    </div>
                    <!-- 멘토 리스트 -->
                    <ul class="mento-lists">
                        <?foreach ( $mento_list as $mento_rows ):?>
                            <li>
                                <div class="mento-group">
                                    <button type="button" class="btn-mento" title="팝업열기" onclick="mentoInfo('<?=$mento_rows['idx']?>')">
                                        <div class="mento-heading">
                                            <?$mento_img = json_decode($mento_rows['img_info'])?>
                                            <img src="<?=$mento_img->img_path?>" alt="홍 길동 멘토 사진">
                                        </div>
                                        <div class="mento-body">
                                            <div class="mento-body-title"><?=$mento_rows['name']?> 멘토</div>
                                            <ul class="mento-detail-lists">
                                                <li><?=$mento_rows['education']?></li>
                                                <li><?=$mento_rows['category_name']?></li>
                                            </ul>
                                        </div>
                                    </button>
                                    <div class="mento-footer">
                                        <button type="button" title="팝업열기" class="btn-question" onclick="mentoAsk('<?=$mento_rows['idx']?>')">
                                            <span>1:1 질문하기</span>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        <?endforeach;?>
                    </ul>
                    <!-- // 멘토 리스트 -->
                    <?if( count($mento_next_list) > 0 ):?>
                    <div class="btn-group" id="mentoMoreBtn">
                        <button type="button" class="btn-more-gray" onclick="mentoMoreView('2')">
                            <span>더보기</span>
                        </button>
                    </div>
                    <?endif;?>
                </div>
                <div class="chat-side">
                    <div class="header-group">
                        <h5 class="h5-small darkgray">자주 하는 질문</h5>
                        <span>다른 친구들은 어떤 질문을 했을까요?</span>
                    </div>

                    <!-- 자주하는 질문 -->
                    <div class="qna-group">
                        <ul class="qna-lists" id="message_ul">
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
                        </ul>
                    </div>
                    <!-- // 자주하는 질문 -->

                    <div class="header-group">
                        <h5 class="h5-small darkgray">Q봇에게 물어 보세요</h5>
                        <span>Q봇에게 궁금한 점을 질문해 보세요</span>
                    </div>

                    <!-- Q봇 -->
                    <div class="chatque-group">
                        <div class="ui-que-dl ui-scroll">
                            <div class="ui-que-dt">
                                <div class="que-heading">
                                    <img src="/public/images/ico_qbot.png" alt="Q.bot">
                                </div>
                                <div class="que-body">
                                    무엇이 궁금하세요?
                                </div>
                            </div>
                        </div>
                        <div class="ipt-group que-ipt-group">
                            <input type="text" class="ui-que-ipt" id="qa_text" placeholder="질문을 입력하세요." onkeyup="enterkey()">
                            <button type="button" class="btn-send"  title="질문보내기"></button>
                        </div>
                    </div>
                    <!-- // Q봇 -->
                </div>
            </div>

            <div class="quick-group">
                <button type="button" class="btn-quick do-refresh" title="리플래시"></button>
                <a href="#header" class="btn-quick do-top" title="탑으로 이동"></a>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#mento_info_close').click(function(){
            $('#popupMento').removeClass('active');
        })
    })

    function enterkey(){

        if (window.event.keyCode == 13) {
            var message = $.trim($("#qa_text").val());
            if (message != ''){
                getChatbotMassage();
                $("#qa_text").val('');
            }
        }
    }

    function getChatbotMassage(){
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
            url: "https://chat.scitalks.co.kr/join",
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
                const chatMessages = document.querySelector('.ui-que-dl');
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });
    }

    function mentoAsk(mento_idx){
        $('#mento_idx').val(mento_idx);
        $('#popupQuestion').addClass('active');
        $('#popupMento').removeClass('active');
    }

    function mentoInfo(mento_idx){
        $('#popupMento').addClass('active');
        $.ajax({
            url : "/chat/mentoInfo",
            method : "POST",
            dataType : "JSON",
            data : {'mento_idx' : mento_idx},
            success: function(result){
                if(result.status == "success") {
                    $('#mento_info_img').attr('src', result.mento_img.img_path);
                    $('#mento_info_name').text(result.mento_name);
                    $('#mento_info_education').text(result.mento_education);
                    $('#mento_info_category').text(result.mento_category);
                    $('#mento_info_comment').text(result.mento_comment);
                    $('#mento_info_question').attr('onclick', 'mentoAsk(\''+result.mento_idx+'\')');
                }else {
                    alert('오류가 발생 되었습니다.');
                }
            },
        });
    }

    function mentoMoreView(page){
        $.ajax({
            url : "/chat/mentoMoreView",
            method : "POST",
            dataType : "JSON",
            data : {'page' : page},
            success: function(result){
                if(result.status == "success") {
                    $('.mento-lists').append(result.html)
                    $('#mentoMoreBtn').html('')
                    $('#mentoMoreBtn').append(result.btn_html)
                }else {
                    alert('오류가 발생 되었습니다.');
                }
            },

        });
    }
/*자주하는 질문*/ 
    window.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('details').forEach(function(item){
        item.addEventListener("toggle", event => {
        let toggled = event.target;
        if (toggled.attributes.open) {
          document.querySelectorAll('details[open]').forEach(function(opened){
              if(toggled != opened)
                opened.removeAttribute('open');
          });
        }
      });
    });
});

/*자주하는 질문-더보기*/
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