
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
                $(".upload-photo").css("background-image", "url(/public/mobile/images/bg_plus.png)");
            }
        });

        //카테고리 클릭
        $(document).on("click", ".btn-sw-category", function () {
            $("#debate-list").html('');
            var category = $(this).attr('data-category');
            var title    = $(this).attr('data-category_title');
            $("#page_" + category).val(1);
            $('#category_title').text(title);
            Debate.getDebateRoomList(category);

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
                    });
                    $('#dbt2').append(html);
                    var now_category        = ($('button[name=btn-category]').eq(0).attr('data-category'));
                    var now_category_title  = ($('button[name=btn-category]').eq(0).attr('data-category_title'));
                    $('#category_title').text(now_category_title);
                    $("#category_idx").val(now_category);
                    Debate.getDebateRoomList(now_category);
                }
            });

        },
        getDebateRoomList : function(category){

            var page = $("#page_" + category).val();

            var html = '';
            $.ajax({
                url         : "/api/getDebateRoomList",
                type        : "POST",
                data        : {category:category, page:page, size:4},
                dataType    : "JSON",
                success     : function (result) {
                    if (result.length <= 0 && page > 1){
                        // alert('데이터가 없습니다.');
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
                            html += '            <p class="dbbody-middle">' + item['title'] +'</p>';
                            html += '         </div>';
                            html += '    </div>';
                            html += '    <div class="debate-footer flex-center">';
                            html += '           <a href="/debate/chat?room_idx=' + item['idx']  +'" class="' + join_class + '"><span>' + join_title +'</span></a>';
                            html += '    </div>';
                            html += '</li>';

                        });

                        $("#debate-list").append(html);
                        $("#page_" + category).val(parseInt(page) + 1)
                    }

                }
            });
        },
        checkRegistRoom: function (){
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
        },
    };


    function scrollEnd(){
        var category_idx = $("#category_idx").val();
        Debate.getDebateRoomList(category_idx);
    }



    

</script>


<input type="hidden" id="room_idx" name="room_idx" />
<input type="hidden" id="category_idx" name="category_idx" />

<div class="contents">
    <div class="body-group">
        <div class="body-heading">
            <div class="header-group">
                <h3 class="other">V토론<span>카테고리를 선택해보세요!</span></h3>
            </div>
            <div class="swiper debate-swiper">
                <div class="swiper-wrapper">

                    <?PHP foreach ($category as $cate):?>
                        <?if( $cate['title'] != '생물학' && $cate['title'] != '화학' && $cate['title'] != '물리학' && $cate['title'] != '지구과학' ):?>
                        <div class="swiper-slide">
                            <button type="button" class="btn-sw-category" name="btn-category" data-category="<?=$cate['idx']?>" data-category_title="<?=$cate['title']?>">
                                <div class="img-group">
                                    <img src="/public/mobile/images/ico_cate<?=$cate['idx']?>.png" alt="<?=$cate['title']?>">
                                </div>
                                <span class="title"><?=$cate['title']?></span>
                            </button>
                            <input type="hidden" id="page_<?=$cate['idx']?>" name="page_<?=$cate['idx']?>" value="1" />
                        </div>
                        <?endif;?>
                    <?PHP endforeach;?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <script>

                window.onload = function() {
                    var swiper = new Swiper(".debate-swiper", {
                        slidesPerView: 5,
                        spaceBetween: 10,
                        slidesPerGroup: 4,
                        // loop: true,
                        // loopFillGroupWithBlank: true,
                        pagination: {
                            el: ".swiper-pagination",
                            clickable: true,
                        },
                    });

                    $(".btn-debate-people").click(function(){
                        if( $(this).hasClass("on") ){
                            $(this).removeClass("on");
                            $(".partic_list").addClass("none");
                        }else{
                            $(this).addClass("on");
                            $(".partic_list").removeClass("none");
                        }
                    });
                }
            </script>
        </div>

        <div class="body-con">
            <div class="header-group pdt17">
                <h4 class="h4" id="category_title"></h4>
            </div>

            <!-- 토론 목록 -->
            <ul class="debate-lists" id="debate-list" >

            </ul>
            <!-- // 토론 목록 -->


        </div>

        <div class="make-debate-group">
            <button type="button" class="btn-make-debate" onclick="Science.popup.open(this,'#popupDebate')"><span>토론방<br>만들기</span></button>
        </div>
    </div>

</div>
