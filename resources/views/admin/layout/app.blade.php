@php

  $admin = Auth::user(); 
    if(!empty($admin->profile_photo_path)) 
        $admin->profile_photo_path = asset('uploads/images/'.$admin->profile_photo_path);
    else
        $admin->profile_photo_path = asset('uploads/images/user.png');

  $notification = 0;// getNotificationCount();
@endphp
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>GGPA</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('admin/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('admin/bower_components/font-awesome/css/font-awesome.min.css')}}">
  
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('admin/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin/dist/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{ asset('admin/css/style.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('admin/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
  <!-- icheck -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/iCheck/all.css')}}">
  <link rel="stylesheet" href="{{ asset('admin/css/sweet-alert.css')}}">

  <!--  Custom croppie css -->
  <link rel="stylesheet" href="{{ asset('admin/css/croppie.css')}}">

  <!-- sol -->
  <link rel="stylesheet" href="{{ asset('admin/css/sol.css')}}">
  <link rel="stylesheet" href="{{ asset('admin/dist/css/skins/_all-skins.min.css')}}">

  <link rel="stylesheet" href="{{ asset('admin/css/jquery-te-1.4.0.css')}}">  
  <!-- datatable -->
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/dataTables.bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/responsive.bootstrap.min.css') }}">
  <!-- Google Font -->
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/bootstrap-datetimepicker.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/jquery.jqChart.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/styles.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/bootstrap-datepicker.css') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<div class="loader" style="display: none;">
   <div class="InnerLoader">
     <div class="LoaderImage">
     <img src="{{ asset('admin/image/loader.gif')}}">
     </div>
   </div>
 </div>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{ route('admin.dashboard') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>D</b>C</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>GGPA</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ $admin->profile_photo_path }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ $admin->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ $admin->profile_photo_path }}" class="img-circle" alt="User Image">

                <p>
                  {{ $admin->name }} - GGPA Admin
                  <small></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ route('admin.profile') }}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ URL('admin/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ $admin->profile_photo_path }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ $admin->name }}</p>
        </div>
      </div>

      <ul class="sidebar-menu" data-widget="tree">
        <li class="@if ($pagename=='dashboard') {{ 'active' }} @endif">
          <a href="{{ route('admin.dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>

        <li class="@if ($pagename=='blog') {{ 'active' }} @endif">
          <a href="{{ route('admin.blog') }}">
            <i class="fa fa-tags"></i> <span>Blog Management</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        
        <li class="@if ($pagename=='business') {{ 'active' }} @endif">
          <a href="{{ route('admin.business') }}">
            <i class="fa fa-briefcase"></i> <span>Business Management</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>

        <li class="@if ($pagename=='user') {{ 'active' }} @endif">
          <a href="{{ route('admin.user') }}">
            <i class="fa fa-user"></i> <span>User Management</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>

        <li class="@if ($pagename=='broadcast') {{ 'active' }} @endif">
          <a href="{{ route('admin.broadcast.message') }}">
            <i class="fa fa-bullhorn" aria-hidden="true"></i><span>Broadcast Message</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>

        <li class="@if ($pagename=='logout') {{ 'active' }} @endif">
          <a href="{{ route('admin.logout') }}">
            <i class="fa fa-sign-out"></i> <span>Sign out</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <div class="content-wrapper">
      @yield('page')
  </div>



  <footer class="main-footer">
    <div class="pull-right hidden-xs">
    </div>
    <strong>Copyright &copy; 2017-2018 <a >GGPA</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ asset('admin/bower_components/jquery/dist/jquery.min.js')}}"></script>

<script type="text/javascript" src="{{ asset('admin/js/jquery.jqChart.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('admin/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('admin/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Morris.js charts -->
<script src="{{ asset('admin/bower_components/raphael/raphael.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{ asset('admin/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap -->
<!-- <script src="{{ asset('admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script> -->
<!-- <script src="{{ asset('admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script> -->
<!-- jQuery Knob Chart -->
<script src="{{ asset('admin/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{ asset('admin/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- jsvalidation -->
<script src="{{ asset('admin/js/jsvalidation.js') }}" defer></script>

<!-- Sweet alert -->
<script src="{{ asset('admin/js/sweet-alert.min.js') }}" defer></script>
<!-- Edit Text -->
<script type="text/javascript" src="{{ asset('admin/js/jquery-te-1.4.0.min.js') }}"></script>
<!-- datatable -->
<script type="text/javascript" src="{{ asset('admin/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/js/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/js/responsive.bootstrap.min.js') }}"></script>
<!-- CanvasCrop  -->
<script src="{{ asset('admin/js/jquery.canvasCrop.js') }}" defer></script>
<!-- Daterange picker -->
<script src="{{ asset('admin/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

<!-- iCheck -->
<script type="text/javascript" src="{{ asset('admin/plugins/iCheck/icheck.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('admin/js/bootstrap-datetimepicker.js') }}"></script>
<!-- sol -->
<script type="text/javascript" src="{{ asset('admin/js/sol.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->

<!-- AdminLTE App -->
<script src="{{ asset('admin/dist/js/adminlte.min.js')}}"></script>

<script src="{{ asset('admin/dist/js/demo.js')}}"></script>

<script type="text/javascript" src="{{ asset('admin/js/custom.js') }}"></script>
@yield('js_bottom')

</body>
</html>




