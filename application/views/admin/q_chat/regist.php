<script src="/public/admin/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="/public/admin/plugins/jquery-validation/additional-methods.min.js"></script>
<section class="content" style="padding-top: 15px">
    <div class="container-fluid">
        <?if( empty($idx) ):?>
            <h3>챗봇 등록</h3>
        <?else:?>
            <h3>챗봇 수정</h3>
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
                                    <input type="text" class="form-control" id="title" name="" placeholder="" value="<?=$title?>" <?=($idx != '') ? 'readonly' : ''?>/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="job_category" class="col-sm-2 col-form-label" style="text-align: right">설명<span class="text-danger"> *</span></label>
                                <div class="col-sm-4" style="margin: auto 0;">
                                    <input type="text" class="form-control" id="description" name="" placeholder="" value="<?=$description?>" <?=($idx != '') ? 'readonly' : ''?>/>
                                </div>
                            </div>
                            <?if( !empty($file_info) ):?>
                                <div class="form-group row">
                                    <label for="job" class="col-sm-2 col-form-label" style="text-align: right">업로드 파일<span class="text-danger"> *</span></label>
                                    <div class="col-sm-4" style="margin: auto 0;">
                                        <label for="input-file" style="margin-right: 30px;" id="1_text"><?=$file_info['file_name']?></label>
                                        <input type="file" id="1_file" name="1_file" style=display:none; onchange="chatbotFileUpload('1')" />
                                        <input type="hidden" id="1_path" name="1_path" style=display:none; value="<?=$file_info['file_path']?>"/>
                                        <input type="hidden" id="1_name" name="1_name" style=display:none; value="<?=$file_info['file_name']?>"/>
                                        <button type="button" class="btn bg-gradient-info" id="upload_button" style="font-size: 12px;">+</button>
                                        <button type="button" class="btn bg-gradient-danger" id="upload_delete_button" style="font-size: 12px;">-</button>
                                    </div>
                                </div>
                            <?else:?>
                                <div class="form-group row">
                                    <label for="job" class="col-sm-2 col-form-label" style="text-align: right">업로드 파일<span class="text-danger"> *</span></label>
                                    <div class="col-sm-4" style="margin: auto 0;">
                                        <label for="input-file" style="margin-right: 30px;" id="1_text"></label>
                                        <input type="file" id="1_file" name="1_file" style=display:none; onchange="chatbotFileUpload('1')" />
                                        <input type="hidden" id="1_path" name="1_path" style=display:none; value=""/>
                                        <input type="hidden" id="1_name" name="1_name" style=display:none; value=""/>
                                        <button type="button" class="btn bg-gradient-info" id="upload_button" style="font-size: 12px;">+</button>
                                        <button type="button" class="btn bg-gradient-danger" id="upload_delete_button" style="font-size: 12px;">-</button>
                                    </div>
                                </div>
                            <?endif;?>
                        </div>
                        <div class="card-footer " style="text-align: center">
                            <?if(empty($idx)):?>
                            <button type="button" class="btn btn-primary" id="regist">저장</button>
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

<script>
    $(function () {
        $('#category_modal').click(function(){
            $('#category_popup').modal('show')
        });

        $('#upload_button').click(function(){
            $('#1_file').click();
        });

        $("#regist").click(function () {
            var param               = {};
            var idx                 = $("#idx").val();
            var title               = $('#title').val();
            var description         = $('#description').val();
            var file_path           = $('#1_path').val();
            var file_name           = $('#1_name').val();

            if( title == '' ){
                alert('제목을 입력해 주세요.');
                return;
            }

            if( file_path == '' ){
                alert('csv파일을 등록해 주세요.');
                return;
            }

            if( file_name == '' ){
                alert('csv파일을 등록해 주세요.');
                return;
            }


            param.idx               = idx;
            param.title             = title;
            param.description       = description;
            param.file_path         = file_path;
            param.file_name         = file_name;

            $.ajax({
                url : "/admin/qchat/chatbotRegistProcess",
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
                            window.location.href = "/admin/chatbot/regist";
                        }else{
                            window.location.href = "/admin/chatbot/regist?idx="+idx;
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
                    url : "/admin/qchat/deleteContentsProcess",
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
            location.href = "/admin/qchat";
        })

        $('#upload_delete_button').click(function(){
            $('#1_path').val('');
            $('#1_name').val('');
            $('#1_text').text('');
        })
    });
</script>

