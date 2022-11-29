<section class="content" style="padding-top: 15px">
    <div class="container-fluid">
        <h3>보스이챗 관리</h3>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="main_list" class="table table-bordered table-striped" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th style="width:10%">순번</th>
                                    <th style="width:40%">방제목</th>
                                    <th style="width:10%">카테고리</th>
                                    <th style="width:10%">인원</th>
                                    <th style="width:7%">활성화</th>
                                    <th style="width:7%">작성자</th>
                                    <th style="width:10%">등록일자</th>
                                    <th style="width:6%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?foreach($result as $rows):?>
                                <tr>
                                    <td><?=$total_cnt?></td>
                                    <td><a href="/admin/debate/chat?idx=<?=$rows['idx']?>"><?=$rows['title']?></a></td>
                                    <td><?=$rows['category_title']?></td>
                                    <td><?=($rows['member_cnt'] == 0)? '무제한': $rows['member_cnt']?></td>
                                    <td><?=($rows['open_yn'] == 'Y')? '': '마감'?></td>
                                    <td><?=$rows['user_name']?></td>
                                    <td><?=$rows['reg_date']?></td>
                                    <td><button type="button" class="btn btn-block bg-gradient-danger" onclick="deleteDebate('<?=$rows['idx']?>');">삭제</button></td>
                                </tr>
                                <?$total_cnt--?>
                                <?endforeach;?>
                            </tbody>

                        </table>
                    </div>
                    <!-- /.card-body -->

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

    });

    function deleteDebate( idx ){
        if( confirm('삭제 하시겠습니까?') ){
            $.ajax({
                url : "/admin/debate/deleteDebate",
                method : "POST",
                dataType : "JSON",
                data : {'idx' : idx},
                success: function(result){
                    if(result.status == "success") {
                        alert('삭제가 완료되었습니다.')
                    }else {
                        alert('오류가 발생 되었습니다.');
                    }
                },

            });
        }
    }
</script>
