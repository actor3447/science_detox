<script>
    $(document).ready(function($){
        $('.type_tab li a').click(function(){
        $('.type_tab li a').removeClass("on");
        $(this).addClass("on");
        });
    });
</script>
<div class="contents">
    <div class="con-group">
        <div class="con-heading contents_head">
            <h2 class="h2 loc-center">
                <img src="/public/images/bg_contents.png" alt="사이언스디톡스/">
            </h2>
            <div class="search_form">
                <div class="input_wrap">
                    <input type="text" name="search" id="search_text" placeholder="검색어를 입력하세요.">
                    <span class="icon_search"></span>
                </div>
            </div>
        </div>
        <section class="contents_section">
            <h3 class="none">컨텐츠 리스트</h3>
            <div class="type_tab_wrap">
                <ul class="type_tab">
                    <li>
                        <a href="/contents?search_field=curation"><span class="txt">큐레이션</span></a>
                    </li>
                    <li>
                        <a href="/contents?search_field=last_order"><span class="txt">최신순</span></a>
                    </li>
                    <li>
                        <a href="/contents?search_field=youtube"><span class="txt">영상콘텐츠</span></a>
                    </li>
                    <li>
                        <a href="/contents?search_field=content"><span class="txt">이미지콘텐츠</span></a>
                    </li>
                </ul>
            </div>
            <?if( $search_field == 'curation' ):?>
            <?foreach($contents_curation_list as $cuaration_list):?>
            <div class="result_contents_wrap">
                <h2><?=$cuaration_list['title']?></h2>
                <div class="result_contents">
                    <ul class="result_list result_list1" id="contents_list_<?=$cuaration_list['idx']?>">
                        <?foreach ($cuaration_list['contents'] as $rows):?>
                        <li class="result_box">
                            <a href="/main?link_idx=<?=$rows['idx']?>">
                                <?$contents_img = json_decode($rows['img_info'], JSON_UNESCAPED_UNICODE)?>
                                <div class="result_img" style="background-color:#000;"><img src="<?=$contents_img['img_path']?>" alt="결과 이미지1"></div>
                                <div class="result_txt">
                                    <p class="cont_title"><?=$rows['title']?></p>
                                    <?$date     = explode(' ', $rows['reg_date'])?>
                                    <span class="cont_date"><?=$date[0]?></span>
                                </div>
                            </a>
                        </li>
                        <?endforeach;?>
                    </ul>
                </div>
                <?if( $cuaration_list['contents_next_prev'] > 0):?>
                <div class="btn_group" id="contents_list_btn_<?=$cuaration_list['idx']?>">
                    <button class="btn-more-gray" onclick="moreCurationContents('2', '<?=$cuaration_list['idx']?>', '<?=$cuaration_list['hash_tag']?>')"><span>더 보기</span></button>
                </div>
                <?endif;?>
            </div>
            <?endforeach;?>
            <?endif;?>
            <div class="result_contents_wrap">
                <h2></h2>
                <div class="result_contents">
                    <input type="hidden" id="search_field" value="<?=$search_field?>">
                    <input type="hidden" id="search_text_ajax" value="<?=$search_text?>">
                    <ul class="result_list result_list1" id="contents_list">
                        <?foreach ($contents_list as $rows):?>
                        <li class="result_box">
                            <a href="/main?link_idx=<?=$rows['idx']?>">
                                <?$contents_img = json_decode($rows['img_info'], JSON_UNESCAPED_UNICODE)?>
                                <div class="result_img" style="background-color:#000;"><img src="<?=$contents_img['img_path']?>" alt="결과 이미지1"></div>
                                <div class="result_txt">
                                    <p class="cont_title"><?=$rows['title']?></p>
                                    <?$date     = explode(' ', $rows['reg_date'])?>
                                    <span class="cont_date"><?=$date[0]?></span>
                                </div>
                            </a>
                        </li>
                        <?endforeach;?>
                    </ul>
                </div>
                <?if( $contents_list_next_prev > 0 ):?>
                <div class="btn_group" id="contents_list_btn">
                    <button class="btn-more-gray" onclick="moreContents('2')"><span>더 보기</span></button>
                </div>
                <?endif;?>
            </div>
        </section>
        <div class="quick-group">
            <button type="button" class="btn-quick do-refresh" title="리플래시"></button>
            <a href="#header" class="btn-quick do-top" title="탑으로 이동"></a>
        </div>
    </div>
</div>
<script>
    $(function(){
        $("#search_text").on("keyup", function (key) {
            var search_text = $('#search_text').val();
            if (key.keyCode == 13) {
                location.href = '/contents?search_text='+search_text
            }
        });
    });

    function moreContents(page){
        var user_idx        = $('#user_idx').val();
        var search_field    = $('#search_field').val();
        var search_text     = $('#search_text_ajax').val();

        $.ajax({
            url : "/contents/moreContents",
            method : "POST",
            dataType : "JSON",
            data : {'page' : page, 'user_idx' : user_idx, 'search_field' : search_field, 'search_text' : search_text},
            success: function(result){
                if(result.status == "success") {
                    $('#contents_list').append(result.html);
                    $('#contents_list_btn').html('');
                    $('#contents_list_btn').append(result.btn_html);
                }else {
                    alert('오류가 발생 되었습니다.');
                }
            },

        });
    }

    function moreCurationContents(page, contents_idx, hash_tag){

        $.ajax({
            url : "/contents/moreCurationContents",
            method : "POST",
            dataType : "JSON",
            data : {'page' : page, 'contents_idx' : contents_idx, 'hash_tag' : hash_tag},
            success: function(result){
                if(result.status == "success") {
                    $('#contents_list_'+contents_idx).append(result.html);
                    $('#contents_list_btn_'+contents_idx).html('');
                    $('#contents_list_btn_'+contents_idx).append(result.btn_html);
                }else {
                    alert('오류가 발생 되었습니다.');
                }
            },

        });
    }
</script>