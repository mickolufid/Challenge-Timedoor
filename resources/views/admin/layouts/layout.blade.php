<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Timedoor Admin | Dashboard</title>

    <!-- CSS Start -->
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('assets/plugin/bootstrap/bootstrap.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugin/font-awesome/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('assets/plugin/Ionicons/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin/admin.css') }}">
    <!-- TMDR Preset -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin/tmdrPreset.css') }}">
    <!-- Custom css -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin/custom.css') }}">
    <!-- Skin -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin/skin.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('assets/plugin/bootstrap-datepicker/bootstrap-datetimepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/plugin/daterangepicker/daterangepicker.css') }}">
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ asset('assets/plugin/datatable/datatables.min.css') }}">
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ asset('assets/plugin/selectpicker/bootstrap-select.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- CSS End -->

   

</head>

<body class="hold-transition skin sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            @include('admin.layouts.header')
        </header>
        <aside class="main-sidebar">
            @include('admin.layouts.menu')
        </aside>
        <main>
            @yield('content')
        </main>
        <footer class="main-footer">
            @include('admin.layouts.footer')
        </footer>

       
    </div>
	
	
	 <!-- JS Start -->
    <!-- jQuery 3 -->
    <script src="{{ asset('assets/plugin/jquery/jquery.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('assets/plugin/jquery/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('assets/plugin/bootstrap/bootstrap.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('assets/plugin/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugin/daterangepicker/daterangepicker.js') }}"></script>
    <!-- datepicker -->
    <script src="{{ asset('assets/plugin/bootstrap-datepicker/bootstrap-datetimepicker.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/js/admin/adminlte.min.js') }}"></script>
    <!-- DataTable -->
    <script src="{{ asset('assets/plugin/datatable/datatables.min.js') }}"></script>
    <!-- CKEditor -->
    <script src="{{ asset('assets/plugin/ckeditor/ckeditor.js') }}"></script>
    <!-- Selectpicker -->
    <script src="{{ asset('assets/plugin/selectpicker/bootstrap-select.js') }}"></script>
    <!-- JS End -->
	
	
    @yield('script')
</body>
</html>