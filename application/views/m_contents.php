<!-- MAIN -->
<div class="container" role="main" id="container">
    <div class="contents">
        <div class="body-group">
            <div class="body-heading">
                <h3 class="h3">싸이언스<span class="font-bold primary">디톡s</span> 콘텐츠를<br>검색해 보세요</h3>
                <div class="ipt-group">
                    <input type="text" class="ui-ipt" id="search_text" placeholder="검색어를 입력하세요.">
                    <button type="button" class="btn-search" title="검색"></button>
                </div>
            </div>
            <div class="body-con">
                <ul class="category-txt-lists">
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
                <?if( $search_field == 'curation' ):?>
                <?foreach($contents_curation_list as $cuaration_list):?>
                <div class="category_group_wrap">
                    <h2><?=$cuaration_list['title']?></h2>
                    <div class="category-group" id="contents_list_<?=$cuaration_list['idx']?>">
                        <input type="hidden" id="search_field" value="<?=$search_field?>">
                        <input type="hidden" id="search_text_ajax" value="<?=$search_text?>">
                        <?foreach ($cuaration_list['contents'] as $rows):?>
                            <?$contents_img = json_decode($rows['img_info'], JSON_UNESCAPED_UNICODE)?>
                            <li style="background-image:url(<?=$contents_img['img_path']?>); background-size:cover; background-repeat:no-repeat;">
                                <a href="/main?link_idx=<?=$rows['idx']?>" class="btn-category" style="background-color:red;">
        <!--                            --><?//if($rows['type'] == 'youtube'):?>
        <!--                                <iframe width="560" height="315" src="https://www.youtube.com/embed/--><?//=$rows['youtube_link']?><!--" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->
        <!--                            --><?//else:?>

                                    <span class="title"><?=$rows['title']?></span>
                                </a>
                            </li>
                        <?endforeach;?>
                    </div>
                    <?if( $cuaration_list['contents_next_prev'] > 0):?>
                    <div class="btn-group" id="contents_list_btn_<?=$cuaration_list['idx']?>">
                        <button type="button" class="btn-more" onclick="moreMobileCurationContents('2', '<?=$cuaration_list['idx']?>', '<?=$cuaration_list['hash_tag']?>')"><span>더보기</span></button>
                    </div>
                    <?endif;?>
                </div>
                <?endforeach;?>
                <?endif;?>
                <div class="category_group_wrap">
                    <h2></h2>
                    <div class="category-group" id="contents_list" >
                        <input type="hidden" id="search_field" value="<?=$search_field?>">
                        <input type="hidden" id="search_text_ajax" value="<?=$search_text?>">
                        <?foreach ($contents_list as $rows):?>
                            <?$contents_img = json_decode($rows['img_info'], JSON_UNESCAPED_UNICODE)?>
                            <li style="background-image:url(<?=$contents_img['img_path']?>); background-size:cover; background-repeat:no-repeat;">
                                <a href="/main?link_idx=<?=$rows['idx']?>" class="btn-category" style="background-color:red;">
                                    <!--                            --><?//if($rows['type'] == 'youtube'):?>
                                    <!--                                <iframe width="560" height="315" src="https://www.youtube.com/embed/--><?//=$rows['youtube_link']?><!--" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->
                                    <!--                            --><?//else:?>

                                    <span class="title"><?=$rows['title']?></span>
                                </a>
                            </li>
                        <?endforeach;?>
                    </div>
                    <?if( $contents_list_next_prev > 0 ):?>
                    <div class="btn-group" id="contents_list_btn">
                        <button type="button" class="btn-more" onclick="moreMobileContents('2')"><span>더보기</span></button>
                    </div>
                    <?endif;?>
                </div>
            </div>

            <div class="top-btn-group">
                <button type="button" class="btn-top" title="상단으로 이동"></button>
            </div>
        </div>
    </div>
</div>
<!-- // MAIN -->
<script>
    $(function(){
        $("#search_text").on("keyup", function (key) {
            var search_text = $('#search_text').val();
            if (key.keyCode == 13) {
                location.href = '/contents?search_text='+search_text
            }
        });
    });

    function moreMobileContents(page){
        var user_idx        = $('#user_idx').val();
        var search_field    = $('#search_field').val();
        var search_text     = $('#search_text_ajax').val();

        $.ajax({
            url : "/contents/moreMobileContents",
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

    function moreMobileCurationContents(page, contents_idx, hash_tag){

        $.ajax({
            url : "/contents/moreMobileCurationContents",
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