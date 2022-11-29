<script src="/public/admin/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="/public/admin/plugins/jquery-validation/additional-methods.min.js"></script>
<section class="content" style="padding-top: 15px">
    <div class="container-fluid">
        <?if( empty($idx) ):?>
            <h3>관리자 등록</h3>
        <?else:?>
            <h3>관리자 수정</h3>
        <?endif;?>
        <div class="row">
            <div class="col-12">
                <form id="regist_form" method="post" onsubmit="return false">
                    <div class="card card-info">
                        <div class="card-body">
                            <input type="hidden" id="idx" value="<?=$idx?>" />
                            <div class="form-group row">
                                <label for="company_name" class="col-sm-2 col-form-label" style="text-align: right">아이디<span class="text-danger"> *</span></label>
                                <div class="col-sm-4" style="margin: auto 0;">
                                    <input type="text" class="form-control" name="" id="id" placeholder="" value="<?=$id?>" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="company_name" class="col-sm-2 col-form-label" style="text-align: right">비밀번호<span class="text-danger"> *</span></label>
                                <div class="col-sm-4" style="margin: auto 0;">
                                    <input type="password" class="form-control" name="" id="passwd" placeholder="" value="<?=$passwd?>" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="company_name" class="col-sm-2 col-form-label" style="text-align: right">이름<span class="text-danger"> *</span></label>
                                <div class="col-sm-4" style="margin: auto 0;">
                                    <input type="text" class="form-control" name="" placeholder="" id="name" value="<?=$name?>" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="company_name" class="col-sm-2 col-form-label" style="text-align: right">멘토 여부<span class="text-danger"> *</span></label>
                                <div class="col-sm-4" style="margin: auto 0;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="mento_yn" value="Y" <?=($mento_yn == 'Y') ? 'checked' : ''?>>
                                        <label class="form-check-label"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mento hide">
                                <label for="company_name" class="col-sm-2 col-form-label" style="text-align: right">학력<span class="text-danger"> *</span></label>
                                <div class="col-sm-4" style="margin: auto 0;">
                                    <input type="text" class="form-control" name="" placeholder="" id="education" value="<?=$education?>" />
                                </div>
                            </div>
                            <div class="form-group row mento <?=($mento_yn == 'Y') ? '' : ' hide'?>">
                                <label for="sido" class="col-sm-2 col-form-label" style="text-align: right">카테고리<span class="text-danger"> *</span></label>
                                <div class="col-sm-4"  style="margin: auto 0;">
                                    <select class="form-control" id="category" name="category">
                                        <option value="" >선택</option>
                                        <?foreach ($category as $rows):?>
                                            <option value="<?=$rows['idx']?>" <?=($rows['idx'] == $category_idx) ? 'selected' : ''?>><?=$rows['name']?></option>
                                        <?endforeach;?>
                                    </select>
                                </div>
                                <div class="col-sm-1"><button type="button" class="btn btn-block bg-gradient-info right" id="category_modal" style="font-size: 12px;">카테고리 추가</button></div>
                            </div>
                            <div class="form-group row <?=($mento_yn == 'Y') ? '' : ' hide'?>">
                                <label for="job_category" class="col-sm-2 col-form-label" style="text-align: right">메모</label>
                                <div class="col-sm-4" style="margin: auto 0;">
                                    <textarea class="form-control" rows="5" placeholder="메모" id="comment"><?=$comment?></textarea>
                                </div>
                            </div>
                            <?if( !empty($img_info) ):?>
                                <div class="form-group row mento <?=($mento_yn == 'Y') ? '' : ' hide'?>">
                                    <label for="job" class="col-sm-2 col-form-label" style="text-align: right">사진 파일<span class="text-danger"> *</span></label>
                                    <div class="col-sm-4" style="margin: auto 0;">
                                        <label for="input-file" style="margin-right: 30px;" id="1_text"><?=$img_info['img_name']?></label>
                                        <input type="file" id="1_file" name="1_file" style=display:none; onchange="imageUpload('1')" />
                                        <input type="hidden" id="1_path" name="1_path" style=display:none; value="<?=$img_info['img_path']?>"/>
                                        <input type="hidden" id="1_name" name="1_name" style=display:none; value="<?=$img_info['img_name']?>"/>
                                        <button type="button" class="btn bg-gradient-info" id="upload_button" style="font-size: 12px;">+</button>
                                        <button type="button" class="btn bg-gradient-danger" id="upload_delete_button" style="font-size: 12px;">-</button>
                                    </div>
                                </div>
                            <?else:?>
                                <div class="form-group row mento <?=($mento_yn == 'Y') ? '' : ' hide'?>">
                                    <label for="job" class="col-sm-2 col-form-label" style="text-align: right">사진 파일<span class="text-danger"> *</span></label>
                                    <div class="col-sm-4" style="margin: auto 0;">
                                        <label for="input-file" style="margin-right: 30px;" id="1_text"></label>
                                        <input type="file" id="1_file" name="1_file" style=display:none; onchange="imageUpload('1')" />
                                        <input type="hidden" id="1_path" name="1_path" style=display:none; value=""/>
                                        <input type="hidden" id="1_name" name="1_name" style=display:none; value=""/>
                                        <button type="button" class="btn bg-gradient-info" id="upload_button" style="font-size: 12px;">+</button>
                                        <button type="button" class="btn bg-gradient-danger" id="upload_delete_button" style="font-size: 12px;">-</button>
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
        $('#mento_yn').click(function(){
            var mento_yn    = $('#mento_yn').is(':checked');

            if( mento_yn === true){
                $('.mento').removeClass('hide');
            }else{
                $('.mento').addClass('hide');
            }
        });

        $('#category_modal').click(function(){
            $('#category_popup').modal('show')
        });

        $('#upload_button').click(function(){
            $('#1_file').click();
        });

        $("#regist").click(function () {
            var param           = {};
            var idx             = $("#idx").val();
            var member_id       = $('#id').val();
            var passwd          = $('#passwd').val();
            var name            = $('#name').val();
            var mento_check     = $('#mento_yn').is(':checked');
            var education       = $('#education').val();
            var category_idx    = $('#category').val();
            var comment         = $('#comment').val();
            var img_path        = $('#1_path').val();
            var img_name        = $('#1_name').val();
            var mento_yn        = 'N';

            if( member_id == '' ){
                alert('아이디를 입력해 주세요.');
                return;
            }

            if( passwd == '' ){
                alert('비밀번호를 입력해 주세요.');
                return;
            }

            if( name == '' ){
                alert('이름을 입력해 주세요.');
                return;
            }

            if( mento_check === true ){
                mento_yn    = 'Y';
                if( education == '' ){
                    alert('학력을 입력해 주세요.');
                    return;
                }

                if( category_idx == '' ){
                    alert('카테고리를 선택해 주세요.');
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
            }

            param.idx           = idx;
            param.member_id     = member_id;
            param.passwd        = passwd;
            param.name          = name;
            param.education     = education;
            param.category_idx  = category_idx;
            param.comment       = comment;
            param.mento_yn      = mento_yn;
            param.img_path      = img_path;
            param.img_name      = img_name;

            $.ajax({
                url : "/admin/member/memberRegistProcess",
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
                            window.location.href = "/admin/member";
                        }else{
                            window.location.href = "/admin/member/regist?idx="+idx;
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
            location.href = "/admin/member";
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

