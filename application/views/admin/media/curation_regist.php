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
            <h3>큐레이션 등록</h3>
        <?else:?>
            <h3>큐레이션 수정</h3>
        <?endif;?>
        <div class="row">
            <div class="col-12">
                <form id="regist_form" method="post" onsubmit="return false">
                    <div class="card card-info">
                        <div class="card-body">
                            <input type="hidden" id="idx" value="<?=$idx?>" />
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
            var title           = $('#title').val();
            var hash_tag        = $('#hash_tag').val();

            if( title == '' ){
                alert('타이틀을 입력해 주세요.');
                return;
            }

            if( hash_tag == '' ){
                alert('해시태그를 입력해 주세요.');
                return;
            }

            param.idx           = idx;
            param.title         = title;
            param.hash_tag      = hash_tag;

            $.ajax({
                url : "/admin/media/curationRegistProcess",
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
                            window.location.href = "/admin/media/curation";
                        }else{
                            window.location.href = "/admin/media/curationRegist?idx="+idx;
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
                var table   = 'contents_curation';
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
                            location.href = "/admin/media/curation";
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
            location.href = "/admin/media/curation";
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

