
<script type="text/javascript" src="/public/js/debate.js"></script>


<audio class='audio' src='' autoplay controls style="display: none"></audio>
<input type="hidden" id="room_idx" name="room_idx" value="<?=$room_idx?>">
<input type="hidden" id="user_idx" name="user_idx" value="<?=$user_idx?>">
<input type="hidden" id="user_name" name="user_name" value="<?=$user_name?>">

<div class="body-group debate-body-group">

    <div class="body-heading debate-bg-white">
        <div class="debate-body-heading">
            <a href="/debate/index" class="btn-back" title="뒤로가기"></a>
            <span><?=$room_info['category_title']?></span>
            <h2><?=$room_info['title']?></h2>
        </div>
        <div class="debate-body-body">
            <?PHP if($room_info['open_yn'] == 'Y' &&  $room_info['owner_idx'] == $user_idx):?>
            <button type="button" class="btn-debate-end" onclick="roomClose()">
                <span><img src="/public/images/btn_end.png" alt="토론종료버튼"></span>
            </button>
            <?PHP endif?>
            <ul class="debate-sns-lists">
                <li>
                    <!-- 클릭시 .on추가 -->
                    <button type="button" class="btn-debate-like btn_like <?PHP if($room_like > 0) echo 'on'?>" onclick="Chat.checkLike()" title="좋아요"></button>
                </li>
                <li>
                    <!-- 클릭시 .on추가 -->
                    <button type="button" class="btn-debate-bookmark btn_book <?PHP if($bookmark_cnt > 0) echo 'on'?>" onclick="Chat.checkBookMark()" title="책갈피"></button>
                </li>
                <li class="btn-debate-people-wrap">
                    <button type="button" class="btn-debate-people" title=""></button>
                    <div class="partic_list none" id="user_list" >

                    </div>
                </li>
<!--                <li>-->
<!--                    <button type="button" class="btn-debate-sns" title="SNS"></button>-->
<!--                </li>-->
            </ul>
        </div>
    </div>

    <div class="body-con debate-con">
        <!-- 토론 내용 -->
        <ul class="voicechat-lists ui-scroll" id="message_ul">

            <?PHP if($room_info['open_yn'] == 'Y'):?>
                <iframe id="chat" src="<?=$debate_url?>/chat.html?username=<?=$user_idx?>&room=<?=$room_idx?>" style="display: none"></iframe>
            <?PHP else:?>
                <iframe id="chat" src="" style="display: none"></iframe>
            <?PHP endif?>

        </ul>
        <!-- // 토론 내용 -->
        <div class="voicechat-act-box">
            <?PHP if($room_info['open_yn'] == 'N'):?>
                <div class="v_mask"></div>
            <?PHP endif?>

            <div class="txt_area_wrap">
                <div class="txt_area">
                    <input id="message" name="message" placeholder="메시지를 입력하세요." onkeyup="enterkey()"></input>
                    <span class="icon_keyboard"></span>
                    <span class="btn_send_s" onclick="sendMessageText()"></span>
                </div>
            </div>

            <div class="voicechat-act-group">
                
                <div id="formats" style="display: none">Format: start recording to see sample rate</div>
                <ol id="recordingsList" style="display: none"></ol>
                <div id="start_div"  class="btn-group start-group ">
                    <!-- .none 클래스 추가시 안보임 -->
                    <button type="button" id="recordButton" class="btn-start" title="녹음시작"></button>
                    <div class="txt">클릭하여 녹음을 시작하세요</div>
                </div>

                <div id="stop_div" class="btn-group stop-group none">

                    <button type="button" id="stopButton" class="btn-stop " title="녹음중지"></button>
                    <div class="txt">녹음중···</div>
                </div>

                <div id="send_div"  class="btn-group complete-group none">
                    <!-- .none 클래스 삭제시 보임 -->
                    <button type="button" id="playButton" class="btn-complete" title="녹음완료"></button>
                    <button type="button"  id="cancelButton" class="btn-record-cancel" title="녹음취소"></button>
                    <div class="txt">녹음완료</div>
                </div>
            </div>
            <div id="upload_div" class="btn-group send-group none">
                <button type="button" class="btn-voice-send" title="전송"></button>
            </div>

        </div>


    </div>
</div>

<script>
    $(function(){
        $(document).on("click", ".btn-debate-people", function () {
        if( $(this).hasClass("on") ){
            $(this).removeClass("on");
            $(".partic_list").addClass("none");
        }else{
            $(this).addClass("on");
            $(".partic_list").removeClass("none");
        }
        });
    });
</script>

<?PHP if($room_info['open_yn'] == 'Y'):?>
    <script type="text/javascript" src="/public/js/recorder.js"></script>
    <script type="text/javascript" src="/public/js/app.js"></script>
    <script type="text/javascript" src="/public/js/chat.js"></script>
<?php endif?>
