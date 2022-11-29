<section class="content" style="padding-top: 15px">
    <div class="container-fluid">
        <h3>멘토 리스트</h3>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="" class="table table-bordered table-striped" style="text-align: center;">
                            <div class="card-body">
                                <div class="input-group col-sm-3 float-right">
                                    <input type="text" class="form-control form-control-lg" id="search" placeholder="멘토명 검색">
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
                                    <th style="width:40%">멘토명</th>
                                    <th>등록일자</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?foreach ($result as $rows):?>
                                <tr>
                                    <td><?=$cur_num?></td>
                                    <td><a href="/admin/qchat/mentoQna?idx=<?=$rows['idx']?>"><?=$rows['name']?></a>&nbsp;<span class="badge bg-danger"><?=$rows['cnt']?></span></td>
                                    <td><?=$rows['reg_date']?></td>
                                </tr>
                                <?$cur_num--;?>
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
        $('#main_list').DataTable({
            "language": {
                sEmptyTable: "데이터가 없습니다."
            },
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": false,
            "info": false,
            // "order": [0,"asc"],
            "autoWidth": false,
            "responsive": true,

        }).buttons().container().appendTo('#main_list_wrapper .col-md-7:eq(0)');

        $('#regist').click(function() {
            document.location.href='/admin/qchat/regist';
        });

        $("#search").on("keyup",function(key){
            if(key.keyCode==13) {
                search()
            }
        });

        function search(){
            var search_name         = $('#search').val();
            document.location.href  = '/admin/qchat/mento?search_name=' + search_name;
        }

    });
</script>
