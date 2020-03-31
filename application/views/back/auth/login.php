
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>NPOS | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/backend') ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/backend') ?>/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/backend') ?>/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/backend') ?>/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/backend') ?>/plugins/iCheck/square/blue.css">
  <!-- PNotify -->
  <link href="<?php echo base_url('assets/template/backend/') ?>bower_components/pnotify/dist/pnotify.css" rel="stylesheet">
  <link href="<?php echo base_url('assets/template/backend/') ?>bower_components/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
  <link href="<?php echo base_url('assets/template/backend/') ?>bower_components/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
</head>
<body class="hold-transition login-page">
<div class="login-box">
 <!--  <div class="login-logo" style="font-size: 25px">
    <a href="#"><span class="text-blue">TOKO</span><span class="text-blue"> ALYA</span><span class="text-red"> SINAR</span><span class="text-red"> TAENG</span></a>
  </div> -->
  <!-- /.login-logo -->
  <div class="login-box-body">

    <p class="login-box-msg">Sign in to start your session</p>
<!--     <div id="infoMessage"><?php echo $message;?></div> -->
      <?php echo form_open("auth/login");?>
     <!--  <form action="../../index2.html" method="post"> -->
      <div class="form-group has-feedback">
        <input type="text" name="user_id" class="form-control" placeholder="Userid" required="">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password" required="">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <?php echo form_close();?>
<!--     <div class="social-auth-links text-center">
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-user"></i> Belum punya userid ?</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-lock"></i> Lupa password ?</a>
    </div> -->
    <!-- /.social-auth-links -->

    <!-- <a href="#">I forgot my password</a><br> -->
    <!-- <a href="register.html" class="text-center">Register a new membership</a> -->
       <!--  <p class="login-box-msg">Sign in to start your session</p> -->
       <br>
    <p class="login-box-msg">N_POS WEB APPLICATION</p>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/template/backend') ?>/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/template/backend') ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets/template/backend') ?>/plugins/iCheck/icheck.min.js"></script>
<!-- PNotify -->
<script src="<?php echo base_url('assets/template/backend/') ?>bower_components/pnotify/dist/pnotify.js"></script>
<script src="<?php echo base_url('assets/template/backend/') ?>bower_components/pnotify/dist/pnotify.buttons.js"></script>
<script src="<?php echo base_url('assets/template/backend/') ?>bower_components/pnotify/dist/pnotify.nonblock.js"></script>

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
<?php
 if (isset($_SESSION['login_denied'])){
   echo "
      <script>
      $(document).ready(function() {
      new PNotify({
      title: 'Login Failed!',
      text: 'Mohon Cek Userid dan Password Anda.',
      type: 'error',
      styling: 'bootstrap3',
      stack: {'dir1':'top', 'dir2':'left', 'push':'top'}
      });
      });
      </script>
   ";
 }
?>
</body>
</html>





