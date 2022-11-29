<script src="/public/admin/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="/public/admin/plugins/jquery-validation/additional-methods.min.js"></script>
<section class="content" style="padding-top: 15px">
    <div class="container-fluid">
        <h3>1:1 질문 답변</h3>
        <div class="row">
            <div class="col-12">
                <form id="regist_form" method="post" onsubmit="return false">
                    <div class="card card-info">
                        <div class="card-body">
                            <input type="hidden" id="idx" value="<?=$idx?>" />
                            <input type="hidden" id="mento_idx" value="<?=$mento_idx?>" />
                            <div class="form-group row">
                                <label for="company_name" class="col-sm-2 col-form-label" style="text-align: right">타이틀<span class="text-danger"> *</span></label>
                                <div class="col-sm-4" style="margin: auto 0;">
                                    <input type="text" class="form-control" id="title" name="" placeholder="" value="<?=$title?>" disabled/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="job_category" class="col-sm-2 col-form-label" style="text-align: right">질문</label>
                                <div class="col-sm-4" style="margin: auto 0;">
                                    <textarea class="form-control" rows="5" placeholder="메모" id="content" disabled><?=$content?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="job_category" class="col-sm-2 col-form-label" style="text-align: right">답변</label>
                                <div class="col-sm-4" style="margin: auto 0;">
                                    <textarea class="form-control" rows="5" placeholder="메모" id="request_content"><?=$request_content?></textarea>
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
        $("#regist").click(function () {
            var param           = {};
            var idx             = $("#idx").val();
            var mento_idx       = $('#mento_idx').val();
            var request_content = $('#request_content').val();

            if( request_content == '' ){
                alert('답변을 입력해 주세요.');
                return;
            }

            param.idx               = idx;
            param.request_content   = request_content;

            $.ajax({
                url : "/admin/qchat/mentoQnaRegistProcess",
                method : "POST",
                dataType : "JSON",
                data : param,
                success: function(result){
                    if(result.status == "success") {
                        alert('저장 되었습니다.');
                        window.location.href = "/admin/qchat/mentoQna?idx="+mento_idx;
                    }else {
                        alert('오류가 발생 되었습니다.');
                    }
                },
            });
        });

        $("#delete").click(function() {
            if(confirm("정말 삭제 하시겠습니까?")){
                var param           = {};
                var idx             = $("#idx").val();
                var table           = 'mento_question';
                var mento_idx       = $('#mento_idx').val();
                param.idx = idx;
                param.table = table;

                $.ajax({
                    url : "/admin/qchat/deleteMentoQnaProcess",
                    method : "POST",
                    dataType : "JSON",
                    data : param,
                    beforeSend : function(){
                        processStart();
                    },
                    success: function (result) {
                        if (result.status == "success") {
                            alert('삭제 되었습니다.');
                            window.location.href = "/admin/qchat/mentoQna?idx="+mento_idx;
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
            var mento_idx   = $('#mento_idx').val();
            location.href   = "/admin/qchat/mentoQna?idx="+mento_idx;
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

