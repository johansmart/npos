  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b></b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"  id="notif">
              <i class="fa fa-bell-o"></i>
              <span id="bell_notif" class="label label-success"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">PEMBERITAHUAN HARI INI</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-pie-chart text-aqua"></i>Total Kendaraan <span id="header_notif_total"></span> 
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-circle text-red"></i>Belum keluar <span id="header_notif"></span> 
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-circle text-green"></i>Sudah keluar <span id="header_notif_keluar"></span> 
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-motorcycle text-maroon"></i> Motor <span id="header_notif_motor"></span> 
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-car text-blue"></i> Mobil <span id="header_notif_mobil"></span> 
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url('upload/img_user/'. $this->session->userdata('image'));?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo  $this->session->userdata('user_name')?></span>
            </a>
            
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url('upload/img_user/'. $this->session->userdata('image'));?>" class="img-circle" alt="User Image">

                <p>
                  <?php $div=$this->session->userdata('role') ?>
                  <?php echo $this->session->userdata('user_name');?> - 
                  <?php 
                    if ($div==3) {
                      echo 'ADMIN';
                    }
                    else if ($div==2) {
                      echo 'SGM';
                    }
                    else if ($div==1) {
                      echo 'MANAGER';
                    }
                    else if ($div==0) {
                      echo 'STAFF';
                    }
                  ?>
                  <small>Member since <?php echo $this->session->userdata('memb_date');?></small>
                </p>
              </li>
              <!-- Menu Body -->
<!--               <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div> -->
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url('profile') ?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url('Auth/logout') ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>




