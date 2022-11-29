<section class="content" style="padding-top: 15px">
    <div class="container-fluid">
        <h3>관리자 리스트</h3>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="main_list" class="table table-bordered table-striped" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th>순번</th>
                                    <th style="width:40%">이름</th>
                                    <th>등록일자</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?foreach ($result as $rows):?>
                                <tr>
                                    <td><?=$total_cnt?></td>
                                    <td><a href="/admin/member/regist?idx=<?=$rows['idx']?>"><?=$rows['name']?></a></td>
                                    <td><?=$rows['reg_date']?></td>
                                </tr>
                                <?$total_cnt--;?>
                            <?endforeach;?>
                            </tbody>
                        </table>
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
            document.location.href='/admin/member/regist';
        });

    });
</script>
