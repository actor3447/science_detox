<section class="content" style="padding-top: 15px">
    <div class="container-fluid">
        <h3>1:1 질문 관리</h3>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="main_list" class="table table-bordered table-striped" style="text-align: center;">
                            <div class="card-body">
                                <div class="input-group col-sm-3 float-right">
                                    <input type="text" class="form-control form-control-lg" id="search" placeholder="컨텐츠명 검색">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-lg btn-default" onclick="search()">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <thead>
                            <tr>
                                <th>순번</th>
                                <th style="width:40%">컨텐츠명</th>
                                <th>작성자</th>
                                <th>등록일자</th>
                                <th>답변여부</th>
                            </tr>
                            </thead>
                            <tbody>
                            <input type="hidden" id="idx" value="<?=$idx?>">
                            <?foreach($result as $rows):?>
                                <tr>
                                    <td><?=$cur_num?></td>
                                    <td><a href="/admin/qchat/mentoQnaRegist?idx=<?=$rows['idx']?>"><?=$rows['title']?></a></td>
                                    <td><?=$rows['user_name']?></td>
                                    <td><?=$rows['reg_date']?></td>
                                    <td><?=$rows['request_yn']?></td>
                                </tr>
                                <?$cur_num--?>
                            <?endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body">
                        <?=$paging?>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary" id="regist">등록</button>
                    </div>
                </div>
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
        $('#regist').click(function() {
            document.location.href='/admin/qchat/regist';
        });

        $("#search").on("keyup",function(key){
            if(key.keyCode==13) {
                search()
            }
        });

        function search(){
            var idx                 = $('#idx').val()
            var search_title        = $('#search').val();
            document.location.href  = '/admin/qchat/mentoQna?idx='+ idx +'&search_title=' + search_title;
        }
    });
</script>
