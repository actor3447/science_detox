<script type="text/javascript" src="/public/js/debate.js"></script>


<audio class='audio' src='' autoplay controls style="display: none"></audio>
<input type="hidden" id="room_idx" name="room_idx" value="<?=$room_idx?>">
<input type="hidden" id="user_idx" name="user_idx" value="<?=$user_idx?>">
<input type="hidden" id="user_name" name="user_name" value="<?=$user_name?>">
<div class="contents">
    <div class="con-group">
        <div class="con-heading ">
            <div class="con-heading-inner con-about loc-center">
                <h2 class="h2 ">
                    <div class="sub-title"><?=$room_info['category_title']?></div>
                    <div class="title"><?=$room_info['title']?></div>
                </h2>
                <div class="edit_wrap">
                    <span id="like" class="edit_1 btn_like <?PHP if($room_like > 0) echo 'on'?>" onclick="Chat.checkLike()"> </span>
                    <span class="edit_2 btn_book <?PHP if($bookmark_cnt > 0) echo 'on'?>"  onclick="Chat.checkBookMark()"></span>
                    <span class="edit_3 btn_man">
                        <a href="javascript:;" style="margin-top:-3px;"></a>
                        <div class="partic_list ui_scroll_2" id="user_list"></div>
                    </span>
                    <!--                    <span class="edit_4 btn_share"><a href="javascript:;"></a></span>-->
                </div>
            </div>
        </div>

        <div class="con-body pdl60-pdr60 pdb43 loc-center radius20">
            <div class="voice-group">
                <div class="voice-side">
                    <div class="header-group">
                        <h4 class="h5-small font-bold darkgray ico-voice">음성 토론에 참여해 보세요.</h4>

                        <?PHP if($room_info['open_yn'] == 'Y' &&  $room_info['owner_idx'] == $user_idx):?>
                            <button type="button" class="btn-debate-end" onclick="roomClose()">
                                <span><img src="/public/images/btn_end.png" alt="토론종료버튼"></span>
                            </button>
                        <?PHP endif?>
                    </div>

                    <div class="voicechat-box">
                        <ul class="voicechat-lists ui-scroll" id="message_ul">

                            <?PHP if($room_info['open_yn'] == 'Y'):?>
                                <iframe id="chat" src="<?=$debate_url?>/chat.html?username=<?=$user_idx?>&room=<?=$room_idx?>" style="display: none"></iframe>
                            <?PHP else:?>
                                <iframe id="chat" src="" style="display: none"></iframe>
                            <?PHP endif?>

                        </ul>

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
                                <div id="start_div" class="btn-group start-group"> <!-- .none 클래스 추가시 안보임 -->
                                    <button type="button" id="recordButton" class="btn-start" title="녹음시작"></button>
                                    <div class="txt">클릭하여 녹음을 시작하세요</div>
                                </div>
                                <div id="stop_div" class="btn-group stop-group none"> <!-- .none 클래스 삭제시 보임 -->
                                    <button type="button" id="stopButton" class="btn-stop "  title="녹음중지"></button>
                                    <div class="txt">녹음중&middot;&middot;&middot;</div>
                                </div>

                                <!--
                                <div class="btn-group stop-group ">
                                    <button type="button" id="pauseButton" class="btn-stop " title="녹음정지"></button>
                                    <div class="txt">녹음정지&middot;&middot;&middot;</div>
                                </div>
                                -->

                                <div id="send_div" class="btn-group complete-group none"> <!-- .none 클래스 삭제시 보임 -->
                                    <button type="button" class="btn-record-cancel" id="cancelButton" title="녹음취소"></button>
                                    <button type="button" class="btn-complete" id="playButton" title="녹음완료"></button>
                                    <div class="txt">녹음완료</div>
                                </div>

                            </div>


                            <div id="upload_div" class="btn-group send-group none">
                                <!--                                <button type="button" id="uploadButton" class="btn-voice-send" title="전송"></button>-->
                            </div>

                        </div>
                    </div>
                </div>

                <div class="voice-side">
                    <div class="header-group flex content-center align-item-end">
                        <h6 class="h6-small text-center darkgray">관련 콘텐츠</h6>
                    </div>
                    <ul class="related-lists">
                        <?foreach ($contents  as $row):?>
                            <?$image = json_decode($row['img_info'])?>

                            <li>
                                <button type="button" class="btn-related" onclick="location.href='/?link_idx=<?=$row['idx']?>'">
                                    <div class="related-heading" style="background-image: url(<?=$image->img_path?>)">
                                    <div class="r_mask"></div>
                                        <!--                                    <img src="--><?//=$image->img_path?><!--" alt="콘텐츠 제목">-->
                                    </div>
                                    <div class="related-body">
                                        <!--                                    <div class="category">카테고리</div>-->
                                        <div class="title"><?=$row['title']?></div>
                                    </div>
                                </button>
                            </li>
                        <?endforeach;?>
                    </ul>
                </div>
            </div>

            <!-- QUICK -->
            <div class="quick-group">
                <button type="button" class="btn-debate-out" onclick="Chat.leaveRoom()"><span>토론방<br>나가기</span></button>
                <button type="button" class="btn-quick do-refresh" title="리플래시" onclick="location.reload()"></button>
                <a href="#header" class="btn-quick do-top" title="탑으로 이동"></a>
            </div>
            <!-- // QUICK -->
        </div>
    </div>
</div>

<?PHP if($room_info['open_yn'] == 'Y'):?>
    <script type="text/javascript" src="/public/js/recorder.js"></script>
    <script type="text/javascript" src="/public/js/app.js"></script>
    <script type="text/javascript" src="/public/js/chat.js"></script>

<?php endif?>

