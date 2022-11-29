<script>
    $(function(){
        //토론방 만들기
        $(document).on("click", "#btn-regist-room", function () {
            Debate.checkRegistRoom();
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


        //더보기
        $(document).on("click", ".btn-more", function () {
            var category = $(this).attr('data-category');
            Debate.getDebateRoomList(category)
        });

        Debate.init();
    })



    var Debate = {
        init : function(){

            $.ajax({
                url         : "/index.php/api/getDebateCategory",
                type        : "POST",
                dataType    : "JSON",
                success     : function (result) {
                    var html = "";
                    $.each(result, function(key, value){
                        html += '<option value="' + value.idx +'">' + value.title+'</option>';
                        Debate.getDebateRoomList(value.idx);
                        var page = $("#page_" + value.idx).val();
                        $("#page_" + value.idx).val(parseInt(page) + 1)
                    });
                    $('#debateInfo1').append(html);
                }
            });

        },
        getDebateRoomList : function(category){
            var page = $("#page_" + category).val();
            var html = '';
            $.ajax({
                url         : "/api/getDebateRoomList",
                type        : "POST",
                data        : {category:category, page:page},
                dataType    : "JSON",
                success     : function (result) {
                    if (result.length <= 0 && page > 1){

                    }else{
                        $.each(result, function(index, item){
                            if (item['open_yn'] == 'Y'){
                                var open_yn = 'ing';
                                var open_title = '토론진행중';
                                var join_title = '참여 하기';
                                var join_class = 'btn-primary';
                            }else{
                                var open_yn = 'end';
                                var open_title = '토론 종료';
                                var join_title = '다시 보기';
                                var join_class = 'btn-secondary';
                            }

                            if (item['img_path'] != ''){
                                var img_src = item['img_path'];
                            }else{
                                var img_src = '/public/images/' +category + '.jpg';
                            }

                            html += '<li class="' + open_yn +'">';
                            html += '    <div class="debate-group">';
                            html += '        <div class="debate-heading" style="background-image: url(' + img_src +') ">';
                            html += '            <div class="debate-flag">' + open_title +'</div>';
                            // html += '            <img src="' + img_src +'" alt="">';
                            html += '        </div>';
                            html += '        <div class="debate-body">';
                            html += '            <div class="dbbody-top">';
                            html += '                <div class="dbbody-right-wrap">';
                            html += '                   <div class="dbbody-right2">' + item['like_cnt'] + '</div>';
                            if (item['member_cnt'] == 0 ){
                                html += '                   <div class="dbbody-right">' + '무제한' + '</div>';
                            }else{
                                html += '                   <div class="dbbody-right">' + item['member_cnt'] +'</div>';
                            }
                            html += '                </div>';
                            html += '                <div class="dbbody-left">' + item['hash_tag']  +'</div>';
                            html += '            </div>';
                            html += '             <p class="dbbody-middle">' + item['title'] +'</p>';
                            html += '         </div>';
                            html += '    </div>';
                            html += '    <div class="debate-footer flex-center">';
                            html += '           <a href="/debate/chat?room_idx=' + item['idx']  +'" class="' + join_class + '"><span>' + join_title +'</span></a>';
                            html += '    </div>';
                            html += '</li>';
                        });

                        $("#debate-list-" + category).append(html);
                        $("#page_" + category).val(parseInt(page) + 1)
                    }

                }
            });
        },
        checkRegistRoom: function (){
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
        },


    };

</script>


<input type="hidden" id="room_idx" name="room_idx" >


<div class="contents">
    <div class="con-group">
        <div class="con-heading">
            <h2 class="h2 loc-center">
                <img src="/public/images/bg_debate.png" alt="V토론 관심분야토론에 참여해 보세요./" >
            </h2>
        </div>
        <div class="con-body loc-center">

            <?PHP foreach ($category as $cate):?>
                <?if( $cate['title'] != '생물학' && $cate['title'] != '화학' && $cate['title'] != '물리학' && $cate['title'] != '지구과학' ):?>
                <input type="hidden" id="page_<?=$cate['idx']?>" name="page_<?=$cate['idx']?>" value="1" >

                <div class="header-group">
                    <h4 class="h4 darkgray"><?=$cate['title']?></h4>
                </div>


                <!-- 토론 리스트 -->
                <ul class="debate-lists" id="debate-list-<?=$cate['idx']?>">

                </ul>
                <!-- // 토론 리스트 -->

                <div class="btn-group">
                    <button class="btn-more" data-category="<?=$cate['idx']?>">
                        <span>더보기</span>
                    </button>
                </div>
                <?endif;?>
            <?PHP endforeach;?>


            <!-- QUICK -->
            <div class="quick-group">
                <button class="btn-debate-make" onclick="Science.popup.open(this,'#popupDebate');"><span>토론방<br>만들기</span></button>
                <button class="btn-quick do-refresh" title="리플래시" onclick="location.reload()"></button>
                <a href="#header" class="btn-quick do-top" title="탑으로 이동"></a>
            </div>
            <!-- // QUICK -->


        </div>
    </div>
</div>

