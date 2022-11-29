<script src="/public/admin/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="/public/admin/plugins/jquery-validation/additional-methods.min.js"></script>
<section class="content" style="padding-top: 15px">
    <div class="container-fluid">
        <?if( empty($idx) ):?>
            <h3>자주하는질문 등록</h3>
        <?else:?>
            <h3>자주하는질문 수정</h3>
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
                                    <input type="text" class="form-control" id="title" name="" placeholder="" value="<?=$title?>"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="board_sort" class="col-sm-2 col-form-label" style="text-align: right">게시글 순서</label>
                                <select class="custom-select form-control-border border-width-2 col-sm-4" id="board_sort">
                                    <option value="">없음</option>
                                    <option value="1" <?=($sort == '1') ? 'selected' : ''?>>1번째</option>
                                    <option value="2" <?=($sort == '2') ? 'selected' : ''?>>2번째</option>
                                    <option value="3" <?=($sort == '3') ? 'selected' : ''?>>3번째</option>
                                    <option value="4" <?=($sort == '4') ? 'selected' : ''?>>4번째</option>
                                    <option value="5" <?=($sort == '5') ? 'selected' : ''?>>5번째</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" style="text-align: right">메모<span class="text-danger"> *</span></label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" id="description" rows="5" placeholder=""><?=$description?></textarea>
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
            var sort                = $('#board_sort').val();
            var description         = $('#description').val();

            if( title == '' ){
                alert('제목을 입력해 주세요.');
                return;
            }

            param.idx               = idx;
            param.title             = title;
            param.sort              = sort;
            param.description       = description;

            $.ajax({
                url : "/admin/qchat/questionRegistProcess",
                method : "POST",
                dataType : "JSON",
                data : param,
                beforeSend : function(){
                    processStart();
                },
                success: function(result){
                    if(result.status == "success") {
                        alert('저장 되었습니다.');
                        window.location.href = "/admin/qchat/question";
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
                var table   = 'question';
                param.idx = idx;
                param.table = table;

                $.ajax({
                    url : "/admin/qchat/deleteChatbotProcess",
                    method : "POST",
                    dataType : "JSON",
                    data : param,
                    beforeSend : function(){
                        processStart();
                    },
                    success: function (result) {
                        if (result.status == "success") {
                            alert('삭제 되었습니다.');
                            location.href = "/admin/qchat/question";
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

