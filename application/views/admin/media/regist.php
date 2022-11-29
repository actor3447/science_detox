<script src="/public/admin/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="/public/admin/plugins/jquery-validation/additional-methods.min.js"></script>
<style>
    .note-editable{line-height: 1.4;;}
    .note-editable p{margin: 0;;} 
    .note-editable ul, .note-editable ol{margin: 0;padding:0;padding-left:15px;;} 
    .note-group-select-from-files .note-form-label{padding:5px 10px; border:solid 1px #999;border-radius:3px;background-color:#eee;cursor:pointer}
</style>
<section class="content" style="padding-top: 15px">
    <div class="container-fluid">
        <?if( empty($idx) ):?>
            <h3>컨텐츠 등록</h3>
        <?else:?>
            <h3>컨텐츠 수정</h3>
        <?endif;?>
        <div class="row">
            <div class="col-12">
                <form id="regist_form" method="post" onsubmit="return false">
                    <div class="card card-info">
                        <div class="card-body">
                            <input type="hidden" id="idx" value="<?=$idx?>" />
<!--                            <div class="form-group row">-->
<!--                                <label class="col-sm-2 col-form-label" style="text-align: right">지원서<span class="text-danger"> *</span></label>-->
<!--                                <div class="col-sm-5">-->
<!--                                    <div class="input-group-prepend">-->
<!--                                        <input type="file" class="form-control" id="attached_file" name="attached_file" />-->
<!--                                        <input type="hidden" class="form-control" id="attached_file_path" name="attached_file_path" value="--><?//=$attached_file_path?><!--" />-->
<!--                                        <input type="hidden" class="form-control" id="attached_file_name" name="attached_file_name" value="--><?//=$attached_file_name?><!--" />-->
<!--                                        <input type="text" class="form-control" id="attached_file_desc" value="--><?//=$attached_file_name?><!--" placeholder="파일을 선택해 주세요." disabled />-->
<!--                                        <div class="input-group-append" style="width:200px;">-->
<!--                                            <button type="button" class="btn btn-block btn-info" onclick="fileAdd('attached_file');" >파일첨부</button>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="form-group row">
                                <label for="company_name" class="col-sm-2 col-form-label" style="text-align: right">타입<span class="text-danger"> *</span></label>
                                <div class="col-sm-4" style="margin: auto 0;" style="display: flex;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" value="contents" <?=($type == 'content') ? 'checked' : ''?>>
                                        <label class="form-check-label">컨텐츠</label>
                                        <input class="form-check-input" type="radio" name="type" style="margin-left: 30px;" value="youtube" <?=($type == 'youtube') ? 'checked' : ''?>>
                                        <label class="form-check-label" style="margin-left: 48px;">유튜브</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row <?=($type != 'youtube') ? 'hide' : ''?>" id="youtube">
                                <label for="company_name" class="col-sm-2 col-form-label" style="text-align: right">유튜브 링크<span class="text-danger"> *</span></label>
                                <div class="col-sm-4" style="margin: auto 0;">
                                    <input type="text" class="form-control" id="youtube_link" name="" placeholder="" value="<?=$youtube_link?>" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="company_name" class="col-sm-2 col-form-label" style="text-align: right">타이틀<span class="text-danger"> *</span></label>
                                <div class="col-sm-4" style="margin: auto 0;">
                                    <input type="text" class="form-control" id="title" name="" placeholder="" value="<?=$title?>" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="company_name" class="col-sm-2 col-form-label" style="text-align: right">해시태그<span class="text-danger"> *</span></label>
                                <div class="col-sm-4" style="margin: auto 0;">
                                    <input type="text" class="form-control" id="hash_tag" name="" placeholder="ex ) #화학#신소재" value="<?=$hash_tag?>" />
                                </div>
                            </div>

<!--                            <div class="form-group row">-->
<!--                                <label for="sido" class="col-sm-2 col-form-label" style="text-align: right">카테고리<span class="text-danger"> *</span></label>-->
<!--                                <div class="col-sm-4"  style="margin: auto 0;">-->
<!--                                    <select class="form-control" id="category" name="category">-->
<!--                                        <option value="" >선택</option>-->
<!--                                        --><?//foreach ($category as $rows):?>
<!--                                            <option value="--><?//=$rows['idx']?><!--" --><?//=($rows['idx'] == $category_idx) ? 'selected' : ''?><!--><?//=$rows['name']?><!--</option>-->
<!--                                        --><?//endforeach;?>
<!--                                    </select>-->
<!--                                </div>-->
<!--                                <div class="col-sm-1"><button type="button" class="btn btn-block bg-gradient-info right" id="category_modal" style="font-size: 12px;">카테고리 추가</button></div>-->
<!--                            </div>-->

                            <div class="form-group row">
                                <label for="job_category" class="col-sm-2 col-form-label" style="text-align: right" id="contents_text">내용<span class="text-danger"> *</span></label>
                                <div class="col-sm-4" style="margin: auto 0;">
                                    <textarea id="edit_contents"><?=$edit_contents?></textarea>
                                </div>
                            </div>
                            <?if( !empty($img_info) ):?>
                                <div class="form-group row">
                                    <label for="job" class="col-sm-2 col-form-label" style="text-align: right">썸네일 파일<span class="text-danger"> *</span></label>
                                    <div class="col-sm-4" style="margin: auto 0;">
                                        <label for="input-file" style="margin-right: 30px;" id="1_text"><?=$img_info['img_name']?></label>
                                        <input type="file" id="1_file" name="1_file" style=display:none; onchange="imageUpload('1')" />
                                        <input type="hidden" id="1_path" name="1_path" style=display:none; value="<?=$img_info['img_path']?>"/>
                                        <input type="hidden" id="1_name" name="1_name" style=display:none; value="<?=$img_info['img_name']?>"/>
                                        <button type="button" class="btn bg-gradient-info" id="upload_button" style="font-size: 12px;">+</button>
                                        <button type="button" class="btn bg-gradient-danger" id="upload_delete_button" style="font-size: 12px;">-</button>
                                        <span class="text-muted" style="padding-left:20px;font-size:12px;font-weight: bold;">*권장 사이즈 600*800 px</span>
                                    </div>
                                </div>
                            <?else:?>
                                <div class="form-group row">
                                    <label for="job" class="col-sm-2 col-form-label" style="text-align: right">업로드 파일<span class="text-danger"> *</span></label>
                                    <div class="col-sm-4" style="margin: auto 0;">
                                        <label for="input-file" style="margin-right: 30px;" id="1_text"></label>
                                        <input type="file" id="1_file" name="1_file" style=display:none; onchange="imageUpload('1')" />
                                        <input type="hidden" id="1_path" name="1_path" style=display:none; value=""/>
                                        <input type="hidden" id="1_name" name="1_name" style=display:none; value=""/>
                                        <button type="button" class="btn bg-gradient-info" id="upload_button" style="font-size: 12px;">+</button>
                                        <button type="button" class="btn bg-gradient-danger" id="upload_delete_button" style="font-size: 12px;">-</button>
                                        <span class="text-muted" style="padding-left:20px;font-size:12px;font-weight: bold;">*권장 사이즈 600*800 px</span>
                                    </div>
                                </div>
                            <?endif;?>
                        </div>
                        <div class="card-footer " style="text-align: center">
                            <button type="button" class="btn btn-primary" id="regist">저장</button>
                            <?if($idx != "" ):?>
                                <button type="button" class="btn btn-danger" id="delete">삭제</button>
                            <?endif;?>
                            <button type="button" class="btn btn-secondary" id="cancle">취소</button>
                            
                        </div>

                    </div>

                </form>

                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>

<!-- modal-->
<div class="modal fade" id="category_popup" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">카테고리 관리</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="box-body category_wrap">
                    <div class="depth_wrap">
                        <div class="depth_inner depth_inner1">
                            <p class="top">카테고리</p>
                            <ul id="category_list">
                                <?foreach ($category as $rows):?>
                                    <li class="category_list">
                                        <input style="" type="text" data-idx="" class="form-control" value="<?=$rows['name']?>" readonly/>
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-danger btn-flat" style="border-radius: 0.25rem;" onclick="deleteContentsProcess('<?=$rows['idx']?>', 'category')">삭제</button>
                                        </span>
                                    </li>
                                <?endforeach;?>
                            </ul>
                        </div>
                    </div>

                    <div class="right">
                        <div class="add_category">
                            <label for="str_val" class="control-label title">카테고리 추가</label>
                            <div class="write">
                                <input type="text" class="form-control" id="str_val" value="" placeholder="카테고리를 입력해주세요.">
                            </div>
                            <button type="button" class="btn btn-primary" style="width:70px;" onclick="addCategory();">추가</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
                <button type="button" class="btn btn-primary" onclick="categoryRegistProcess()">저장</button>
            </div>
        </div>
    </div>
</div>
<script>

    $(function () {
        var toolbar = [
            // 글꼴 설정
            ['fontname', ['fontname']],
            // 글자 크기 설정
            ['fontsize', ['fontsize']],
            // 굵기, 기울임꼴, 밑줄,취소 선, 서식지우기
            ['style', ['bold', 'italic', 'underline','strikethrough', 'clear']],
            // 글자색
            ['color', ['forecolor','color']],
            // 표만들기
            ['table', ['table']],
            // 글머리 기호, 번호매기기, 문단정렬
            ['para', ['ul', 'ol', 'paragraph']],
            // 줄간격
            ['height', ['height']],
            // 그림첨부, 링크만들기, 동영상첨부
            ['insert',['picture','link','video']],
            // 코드보기, 확대해서보기, 도움말
            ['view', ['codeview','fullscreen', 'help']]
        ];

        $('#edit_contents').summernote({
            dialogsInBody: true,
            width: 840,
            height: 400,                // 에디터 높이
            minHeight: 400,             // 에디터 높이
            lang: "ko-KR",              // 한글 설정
            disableResizeEditor: true,  // 리사이즈
            placeholder: '',            // placeholder 설정
            toolbar: toolbar,            // 툴바
            fontNames: ['맑은 고딕','궁서','굴림체','굴림','돋움체','바탕체','Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
            fontSizes: ['8','9','10','11','12','14','16','18','20','22','24','28','30','36','50','72'],
            callbacks: {
                // 이미지를 업로드할 경우 이벤트를 발생
                onImageUpload: function(files, editor, welEditable) {
                    sendFile(files[0],editor,welEditable,'edit_contents');
                },
                onPaste: function (e) {
                    var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                    e.preventDefault();
                    document.execCommand('insertText', false, bufferText);
                }
            }
        });
        $('#edit_contents').summernote({})

        $('#edit_contents').summernote('fontName', 'Pretendard');
        $('#edit_contents').summernote('fontSize', 14);
        $('#edit_contents').summernote('fontSizeUnit', 'px');
        $('#edit_contents').css('line-height','1.4');

        $('#category_modal').click(function(){
            $('#category_popup').modal('show')
        });
        $('#edit_contents').summernote({ prettifyHtml: true });

        $('#upload_button').click(function(){
            $('#1_file').click();
        });

        $('input[name=type]').click(function(){
            var type    = $('input[name=type]:checked').val();
            if( type == 'youtube' ){
                $('#youtube').removeClass('hide');
                $('#contents_text').text('');
                $('#contents_text').text('설명');
            }else{
                $('#youtube').addClass('hide');
                $('#contents_text').text('');
                $('#contents_text').text('컨텐츠');
            }
        });

        $("#regist").click(function () {
            var param           = {};
            var idx             = $("#idx").val();
            var type            = $('input[name=type]:checked').val();
            var title           = $('#title').val();
            var hash_tag        = $('#hash_tag').val();
            var contents_info   = $('#edit_contents').summernote('code');
            var youtube_link    = $('#youtube_link').val();
            var img_path        = $('#1_path').val();
            var img_name        = $('#1_name').val();

            if( type == undefined ){
                alert('타입을 선택해 주세요.');
                return;
            }

            if( type == 'youtube' ){
                if( youtube_link == '' ){
                    alert('유튜브 링크를 입력해 주세요.');
                    return;
                }
            }

            if( title == '' ){
                alert('컨텐츠명을 입력해 주세요.');
                return;
            }

            if( hash_tag == '' ){
                alert('해시태그를 입력해 주세요.');
                return;
            }

            if( contents_info == '' ){
                alert('컨텐츠를 입력해 주세요.');
                return;
            }

            if( img_path == '' ){
                alert('이미지를 등록해 주세요.');
                return;
            }

            if( img_name == '' ){
                alert('이미지를 등록해 주세요.');
                return;
            }


            param.idx           = idx;
            param.type          = type;
            param.title         = title;
            param.hash_tag      = hash_tag;
            param.contents_info = contents_info;
            param.youtube_link  = youtube_link;
            param.img_path      = img_path;
            param.img_name      = img_name;

            $.ajax({
                url : "/admin/media/contentsRegistProcess",
                method : "POST",
                dataType : "JSON",
                data : param,
                beforeSend : function(){
                    processStart();
                },
                success: function(result){
                    if(result.status == "success") {
                        alert('저장 되었습니다.');
                        if( idx == '' ){
                            window.location.href = "/admin/media/regist";
                        }else{
                            window.location.href = "/admin/media/regist?idx="+idx;
                        }

                    }else {
                        alert('오류가 발생 되었습니다.');
                    }
                },
                complete : function(){
                    processEnd();
                }

            });

        });

        $("#delete").click(function() {
            if(confirm("정말 삭제 하시겠습니까?")){
                var param   = {};
                var idx     = $("#idx").val();
                var table   = 'contents';
                param.idx = idx;
                param.table = table;

                $.ajax({
                    url : "/admin/media/deleteContentsProcess",
                    method : "POST",
                    dataType : "JSON",
                    data : param,
                    beforeSend : function(){
                        processStart();
                    },
                    success: function (result) {
                        if (result.status == "success") {
                            alert('삭제 되었습니다.');
                            location.href = "/admin/media";
                        } else {
                            alert('입력한 정보를 다시 확인하여 주세요.');
                        }
                    },
                    complete    : function(){
                        processEnd();
                    }
                });
            }
        });

        $("#cancle").click(function(){
            location.href = "/admin/media";
        })

        $('#upload_delete_button').click(function(){
            $('#1_path').val('');
            $('#1_name').val('');
            $('#1_text').text('');
        })
    });

    function categoryRegistProcess(){
        var category        = [];

        $(".category_list").each(function(){
            var category_str    = $(this).find(".category_str").val();
            if( category_str != "" ){
                category.push(category_str);
            }else{
                alert("카테고리를 입력해 주세요.");
                $(this).focus();
                status  = false;
                return false;
            }
        });

        if( category == undefined ){
            alert("카테고리를 입력해 주세요.");
            return;
        }

        $.ajax({
            url : "/admin/media/categoryRegistProcess",
            method : "POST",
            dataType : "JSON",
            data : {'category' : category},
            beforeSend : function(){
                processStart();
            },
            success: function (result) {
                if (result.status == "success") {
                    alert('저장 되었습니다.');
                    location.reload();
                } else {
                    alert('입력한 정보를 다시 확인하여 주세요.');
                }
            },
            complete    : function(){
                processEnd();
            }
        });

    }

    function deleteContentsProcess(idx, table){
        if(confirm('카테고리를 삭제 하시겠습니까?')){
            $.ajax({
                url : "/admin/media/deleteContentsProcess",
                method : "POST",
                dataType : "JSON",
                data : {'idx' : idx, 'table' : table},
                beforeSend : function(){
                    processStart();
                },
                success: function (result) {
                    if (result.status == "success") {
                        alert('삭제 되었습니다.');
                        location.reload();
                    } else {
                        alert('입력한 정보를 다시 확인하여 주세요.');
                    }
                },
                complete    : function(){
                    processEnd();
                }
            });
        }
    }
</script>

