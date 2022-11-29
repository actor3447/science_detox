
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>동아사이언스 | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/public/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/public/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/public/admin/dist/css/adminlte.min.css">
    <!-- jQuery -->
    <script src="/public/admin/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/public/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/public/admin/dist/js/adminlte.min.js"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <b>동아사이언스 </b>관리자
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
             <form action="/public/admin/index3.html" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="admin_id" placeholder="ID">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" id="admin_pwd" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
<!--                        <div class="icheck-primary">-->
<!--                            <input type="checkbox" id="remember">-->
<!--                            <label for="remember">-->
<!--                                Remember Me-->
<!--                            </label>-->
<!--                        </div>-->
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="button" class="btn btn-primary btn-block" onclick="loginCheck()">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->
<script>
    $(document).ready(function() {
        $("#admin_id, #admin_pwd").keydown(function(key) {
            if (key.keyCode == 13) {
                loginCheck();
            }
        });
    });

    function loginCheck(){
        var admin_id     = $("#admin_id").val();
        var admin_pwd    = $("#admin_pwd").val();

        if (admin_id == ""){
            alert("아이디를 입력해 주세요.");
            return;
        }

        if (admin_pwd == ""){
            alert("비밀번호를 입력해 주세요.");
            return;
        }

        $.ajax({
            url : "/admin/login/loginProcess",
            type : "POST",
            dataType : "JSON",
            data : {"admin_id" : admin_id , "admin_pwd" : admin_pwd},
            success : function(result) {
                if (result.status == 'success'){
                    location.href="/admin/main";
                }else{
                    alert("아이디와 패스워드를 다시 확인 바랍니다.");
                    return;
                }
            }
        });

    }
</script>

</body>
</html>
