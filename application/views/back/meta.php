<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/backend/') ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/backend/') ?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/backend/') ?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/backend/') ?>bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/backend/') ?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/backend/') ?>dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/backend/') ?>bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/backend/') ?>bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/backend/') ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/backend/') ?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/backend/') ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<!-- Datatable -->
   <link rel="stylesheet" href="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<link rel="stylesheet" href="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css">
   <!-- datatable button css -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/backend/') ?>dist/css/dt_custom.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/template/backend/') ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
   <!-- Select2 -->
<!--   <link rel="stylesheet" href="<?php echo base_url('assets/template/backend/') ?>bower_components/select2/dist/css/select2.min.css"> -->
   <!-- datatable button css -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/backend/') ?>dist/css/dt_custom.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/template/backend/') ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/backend') ?>/plugins/iCheck/square/blue.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
</head>
<body class="hold-transition skin-red fixed sidebar-mini">

<!-- clock -->
<!-- <script>
function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  m = checkTime(m);
  s = checkTime(s);
  document.getElementById('clock').innerHTML = 'Time : ' +
  h + ":" + m + ":" + s;
  var t = setTimeout(startTime, 500);
}
function checkTime(i) {
  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
  return i;
}
</script>   -->

<style type="text/css">
  @font-face {
  font-family: 'SourceSansPro-Regular';
  src: url('<?php echo base_url('assets/template/backend/') ?>bower_components/fonts/SourceSansPro-Regular.ttf');
  src: url('<?php echo base_url('assets/template/backend/') ?>bower_components/fonts/SourceSansPro-Regular.ttf') format('ttf'),
       url('<?php echo base_url('assets/template/backend/') ?>bower_components/fonts/SourceSansPro-Regular.ttf') format('truetype');
  }
  body{
    font-family: 'SourceSansPro-Regular';
    font-weight: normal;
    font-size: 12px;
  }
   /*custom header color  #3B5998*/
 .skin-red .main-header .navbar {
     background-color: #f71735;background-image: linear-gradient(147deg, #f71735 0%, #db3445 74%);
  }
  .skin-red .main-header li.user-header {
      background-color: #f71735;background-image: linear-gradient(147deg, #f71735 0%, #db3445 74%);
  }
  .skin-red .main-header .navbar .sidebar-toggle:hover {
      background-color: #f71735;background-image: linear-gradient(147deg, #f71735 0%, #db3445 74%);
  }
  .skin-red .main-header .logo:hover {
      background-color: #f71735;background-image: linear-gradient(147deg, #f71735 0%, #db3445 74%);
  }
  .skin-red .main-header .logo {
      background-color: #f71735;background-image: linear-gradient(147deg, #f71735 0%, #db3445 74%);
  }
  /*custom sidebar color  #3B5998*/
  .main-sidebar { 
  background-color: #263238 !important ;font-size: 14px
  }
  .skin-purple .sidebar-menu > li:hover > a, .skin-purple .sidebar-menu > li.active > a, .skin-purple .sidebar-menu > li.menu-open > a {
    color: #fff;
    background-color: rgba(255,255,255,.1);
  }
  .skin-purple .sidebar-menu > li.header {
   color: #fff;
    background-color: #000000;
  }
  .skin-purple .sidebar-menu .treeview-menu > li > a {
      background-color: #263238 !important ;
  }
  .box {
    position: relative;
    border-radius: 1px;
    background: #ffffff;
    border-top: 1px solid #ececec;
    margin-bottom: 20px;
    width: 100%; 
}
/*.box.box-default {
    border-top-color: gold;
}*/
.modal-danger .modal-header, .modal-danger .modal-footer,.modal-info .modal-header,.modal-primary .modal-header, .modal-info .modal-footer,.modal-success .modal-header, .modal-success .modal-footer,.modal-primary .modal-footer{
padding: 0.7rem;
}

.btn-group-vertical > .btn, .btn-group > .btn {
  display: inline-block;
  padding: 4px 4px;
}
</style> 



