<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>싸이언스 디톡s | 관리자</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/public/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/public/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/public/admin/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/public/admin/dist/css/adminlte.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/public/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/public/admin/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/public/admin/plugins/summernote/summernote-bs4.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/public/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="/public/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/public/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/public/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/public/admin/dist/css/adminlte.min.css">
    <!-- develop style -->
    <link rel="stylesheet" href="/public/admin/css/style.css">

    <script src="/public/admin/js/common.js"></script>
    <script src="/public/admin/js/scrollspy.js"></script>
    <link rel="stylesheet" href="/public/admin/css/style2.css">



    <!-- jQuery -->
    <script src="/public/admin/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/public/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="/public/admin/plugins/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- ChartJS -->
    <script src="/public/admin/plugins/chart.js/Chart.js"></script>
    <!-- Sparkline -->
    <script src="/public/admin/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="/public/admin/plugins/jqvmap/jquery.vmap.js"></script>
    <script src="/public/admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="/public/admin/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="/public/admin/plugins/moment/moment.min.js"></script>
    <script src="/public/admin/plugins/moment/locale/ko.js"></script>
    <script src="/public/admin/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/public/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js"></script>
    <!-- Summernote -->
    <script src="/public/admin/plugins/summernote/summernote-bs4.min.js"></script>
    <script src="/public/admin/plugins/summernote/lang/summernote-ko-KR.js"></script>
    <!-- overlayScrollbars -->
    <script src="/public/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.js"></script>
    <!-- AdminLTE App -->
    <script src="/public/admin/dist/js/adminlte.js"></script>




    <!-- DataTables  & Plugins -->
    <script src="/public/admin/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/public/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <script src="/public/admin/plugins/datatables-responsive/js/dataTables.responsive.js"></script>
    <script src="/public/admin/plugins/datatables-responsive/js/responsive.bootstrap4.js"></script>
    <script src="/public/admin/plugins/datatables-buttons/js/dataTables.buttons.js"></script>
    <script src="/public/admin/plugins/datatables-buttons/js/buttons.bootstrap4.js"></script>
    <script src="/public/admin/plugins/jszip/jszip.js"></script>
    <script src="/public/admin/plugins/pdfmake/pdfmake.js"></script>
    <script src="/public/admin/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="/public/admin/plugins/datatables-buttons/js/buttons.html5.js"></script>
    <script src="/public/admin/plugins/datatables-buttons/js/buttons.print.js"></script>
    <script src="/public/admin/plugins/datatables-buttons/js/buttons.colVis.js"></script>


    <link rel="stylesheet" href="/public/admin/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <script src="/public/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <script src="/public/admin/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="/public/admin/plugins/jquery-validation/additional-methods.min.js"></script>
    <script type="text/javascript" src="/public/admin/js/jquery.bpop.js"></script>

</head>
<?$CI =& get_instance();?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="loading_wrap overlay-wrapper" style="display:none; position:fixed; width:100%; height:100%; z-index:9999;">
    <div class="overlay dark"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Loading...</div></div>
</div>
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="/public/admin/#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>


        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" href="/admin/login/logout">
                    <i class="fa fa-font-awesome-logo-full">logout</i>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>

        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/admin" class="brand-link">
            <img src="/public/images/main_img.PNG" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity:0.8; background-color: white;">
            <span class="brand-text font-weight-light" style="font-size: 15px;">싸이언스 디톡s</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <?$controller   = $this->uri->segment(2, 0);?>
                    <?$view         = $this->uri->segment(3, 'index');?>
                    <li class="nav-item internship <?=($controller == 'member' && $controller != '0') ? 'menu-is-opening menu-open active' : ''?>">
                        <a href="javascript:;" class="nav-link" id="menu1">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                관리자 관리
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="<?=($controller == 'contents' && $controller != '0') ? 'display:block' : 'display:none'?>">
                            <li class="nav-item">
                                <a href="/admin/member" class="nav-link <?=($controller == 'member' && $view == 'index' && $controller != '0') ? 'active' : ''?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>관리자 리스트</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview" style="<?=($controller == 'member' && $view == 'user' && $controller != '0') ? 'display:block' : 'display:none'?>">
                            <li class="nav-item">
                                <a href="/admin/member/user" class="nav-link <?=($controller == 'member' && $view == 'user' && $controller != '0') ? 'active' : ''?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>회원 리스트</p>
                                </a>
                            </li>
                        </ul>

                    </li>
                    <li class="nav-item internship <?=($controller == 'media' && $controller != '0') ? 'menu-is-opening menu-open active' : ''?>">
                        <a href="javascript:;" class="nav-link" id="menu1">
                            <i class="nav-icon fas fa-layer-group"></i>
                            <p>
                                컨텐츠
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="<?=($controller == 'contents' && $controller != '0') ? 'display:block' : 'display:none'?>">
                            <li class="nav-item">
                                <a href="/admin/media" class="nav-link <?=($controller == 'media' && $view == 'index' && $controller != '0') ? 'active' : ''?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>컨텐츠 관리</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview" style="<?=($controller == 'contents' && $controller != '0') ? 'display:block' : 'display:none'?>">
                            <li class="nav-item">
                                <a href="/admin/media/curation" class="nav-link <?=($controller == 'media' && $controller != '0' && $view == 'curation' || $view == 'curation_regist' ) ? 'active' : ''?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>큐레이션</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item internship <?=($controller == 'debate' && $controller != '0') ? 'menu-is-opening menu-open active' : ''?>">
                        <a href="javascript:;" class="nav-link" id="menu1">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                V토론
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="<?=($controller == 'debate' && $controller != '0') ? 'display:block' : 'display:none'?>">
                            <li class="nav-item">
                                <a href="/admin/debate" class="nav-link <?=($controller == 'debate' && $controller != '0') ? 'active' : ''?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>토론방 관리</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item internship <?=($controller == 'qchat' && $controller != '0') ? 'menu-is-opening menu-open active' : ''?>">
                        <a href="javascript:;" class="nav-link" id="menu1">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Q챗
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="<?=($controller == 'contents' && $controller != '0') ? 'display:block' : 'display:none'?>">
                            <li class="nav-item">
                                <a href="/admin/qchat" class="nav-link <?=($controller == 'qchat' && $view == 'index' && $controller != '0') ? 'active' : ''?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>챗봇 관리</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview" style="<?=($controller == 'contents' && $controller != '0') ? 'display:block' : 'display:none'?>">
                            <li class="nav-item">
                                <a href="/admin/qchat/question" class="nav-link <?=($controller == 'qchat' && $controller != '0' && $view == 'question' || $view == 'question_regist') ? 'active' : ''?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>자주 하는 질문</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview" style="<?=($controller == 'contents' && $controller != '0') ? 'display:block' : 'display:none'?>">
                            <li class="nav-item">
                                <a href="/admin/qchat/mento" class="nav-link <?=($controller == 'qchat' && $controller != '0' && $view == 'mento' || $view == 'mentoQna') ? 'active' : ''?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>1:1 질문하기</p>
                                </a>
                            </li>
                        </ul>
                    </li>

            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >
        {yield}
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy;  싸이언스 디톡s</strong>
        All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

</body>
</html>
<script>
    $(function(){
        $('#menu1 i').trigger('click');
    })
</script>