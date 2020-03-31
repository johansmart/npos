
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
<!--       <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url('upload/img_user/'. $this->session->userdata('image'));?>" class="user-image" alt="User Image" style="width: 60px;height: 60px">
        </div>
        <div class="pull-left info">
          <p><?php echo $this->session->userdata('user_name');?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> <?php echo $this->session->userdata('user_id');?></a>
        </div>
      </div> -->

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN MENU</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class=""><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-circle-o"></i> Dashboard</a></li>
          </ul>
        </li>
       <!--  <li class="header">MAIN MENU</li> -->
        <?php if($this->session->userdata('role')==3){ ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-lock"></i> <span>Admin</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class=""><a href="<?php echo base_url('create_user') ?>"><i class="fa fa-circle-o"></i> List User</a></li>
          </ul>
        </li>
        <?php } ?>

        <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-user text-purple"></i> <span>USER</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class=""><a href="<?php echo base_url('profile') ?>"><i class="fa fa-circle-o"></i> Profile</a></li>
          </ul>
        </li> -->
        <?php if($this->session->userdata('role')!=1){ ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-money"></i>
            <span>Penjualan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('Float_shift') ?>"><i class="fa fa-circle-o"></i> Shift</a></li>
            <li><a href="<?php echo base_url('pos') ?>"><i class="fa fa-circle-o"></i> Penjualan (POS)</a></li>
            <li><a href="<?php echo base_url('closing') ?>"><i class="fa fa-circle-o"></i> Closing</a></li>
          </ul>
        </li>
        <?php } ?>

        <?php if($this->session->userdata('role')>=1){ ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-briefcase"></i>
            <span>Pembelian</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('beli_barang') ?>"><i class="fa fa-circle-o"></i> Barang Masuk</a></li>
            <li><a href="<?php echo base_url('list_print_pembelian') ?>"><i class="fa fa-circle-o"></i> List print pembelian</a></li>
            <li><a href="<?php echo base_url('retur_barang') ?>"><i class="fa fa-circle-o"></i> Retur</a></li>
          </ul>
        </li>
        <?php } ?>

        <?php if($this->session->userdata('role')>=1){ ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-tag"></i>
            <span>Produk</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('master_barang') ?>"><i class="fa fa-circle-o"></i> Master Barang</a></li>
            <li><a href="<?php echo base_url('master_supplier') ?>"><i class="fa fa-circle-o"></i> Master Supplier</a></li>
            <li><a href="<?php echo base_url('kategori') ?>"><i class="fa fa-circle-o"></i> Master Kategori</a></li>
            <li><a href="<?php echo base_url('satuan') ?>"><i class="fa fa-circle-o"></i> Master Satuan</a></li>
            <li><a href="<?php echo base_url('diskon') ?>"><i class="fa fa-circle-o"></i> Diskon Barang</a></li>
            <li><a href="<?php echo base_url('promo') ?>"><i class="fa fa-circle-o"></i> Promo Barang</a></li>
            <li><a href="<?php echo base_url('tag_print') ?>"><i class="fa fa-circle-o"></i> Tag Print</a></li>
          </ul>
        </li>
        <?php } ?>

        <?php if($this->session->userdata('role')>=1){ ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Pelanggan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('master_pelanggan') ?>"><i class="fa fa-circle-o"></i> Master Pelanggan</a></li>
          </ul>
        </li>
        <?php } ?>

        <?php if($this->session->userdata('role')>=1){ ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-desktop"></i>
            <span>Inventory</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('Stock') ?>"><i class="fa fa-circle-o"></i> Stock</a></li>
            <li><a href="<?php echo base_url('adjust_barang') ?>"><i class="fa fa-circle-o"></i> Adjust Barang</a></li>
            <li><a href="<?php echo base_url('store_in') ?>"><i class="fa fa-circle-o"></i> Store IN</a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Stock Opname
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('stock_opname') ?>"><i class="fa fa-circle-o"></i>List SO</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <?php } ?>

        <?php if($this->session->userdata('role')>=2){ ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Accounting</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('biaya') ?>"><i class="fa fa-circle-o"></i> Input Biaya</a></li>
            <li><a href="<?php echo base_url('lap_sisa_hutang') ?>"><i class="fa fa-circle-o"></i> List Hutang</a></li>
            <li><a href="<?php echo base_url('lap_sisa_piutang') ?>"><i class="fa fa-circle-o"></i> List Piutang</a></li>
          </ul>
        </li>
        <?php } ?>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Laporan Pembelian
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('lap_pembelian') ?>"><i class="fa fa-circle-o"></i> Lap Pembelian</a></li>
                <li><a href="<?php echo base_url('lap_det_pembelian') ?>"><i class="fa fa-circle-o"></i> Lap Detil Pembelian</a></li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Laporan Penjualan
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('lap_penjualan') ?>"><i class="fa fa-circle-o"></i> Lap Penjualan</a></li>
                <li><a href="<?php echo base_url('lap_det_penjualan') ?>"><i class="fa fa-circle-o"></i> Lap Detil Penjualan</a></li>
                <li><a href="<?php echo base_url('lap_penj_perbarang') ?>"><i class="fa fa-circle-o"></i> Lap Penj. Per Barang</a></li>
                <li><a href="<?php echo base_url('lap_jam') ?>"><i class="fa fa-circle-o"></i> Lap Penj. Perjam</a></li>
                <li><a href="<?php echo base_url('Lap_trans_kartu_kredit') ?>"><i class="fa fa-circle-o"></i> Lap Trans Kartu Kredit</a></li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Laporan Retur
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('lap_retur') ?>"><i class="fa fa-circle-o"></i> Lap Retur</a></li>
                <li><a href="<?php echo base_url('lap_det_retur') ?>"><i class="fa fa-circle-o"></i> Lap Detil Retur</a></li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Laporan Adjust
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('lap_adjust') ?>"><i class="fa fa-circle-o"></i> Lap Adjust</a></li>
                <li><a href="<?php echo base_url('lap_det_adjust') ?>"><i class="fa fa-circle-o"></i> Lap Detil Adjust</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Laporan KAS
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('lap_biaya') ?>"><i class="fa fa-circle-o"></i> Lap Biaya</a></li>
                <li><a href="<?php echo base_url('lap_kas_flow') ?>"><i class="fa fa-circle-o"></i> Lap Alur Kas </a></li>
                <li><a href="<?php echo base_url('lap_bayar_hutang') ?>"><i class="fa fa-circle-o"></i> Lap Pembayaran Hutang</a></li>
                <li><a href="<?php echo base_url('lap_bayar_piutang') ?>"><i class="fa fa-circle-o"></i> Lap Pembayaran Piutang</a></li>
              </ul>
            </li>
            <li><a href="<?php echo base_url('lap_stock_kosong') ?>"><i class="fa fa-circle-o"></i> Lap Stock Kosong</a></li>
            <li><a href="<?php echo base_url('lap_stock_opname') ?>"><i class="fa fa-circle-o"></i> Laporan Stock Opname</a></li>
          </ul>
        </li>
        
        <li class="header">SYSTEM</li>
         <li><a href=""><i class="fa fa-refresh text-green"></i> <span>Refresh </span></a></li>
        <!-- <li><a href="<?php echo base_url('auth/logout') ?>"><i class="fa fa-power-off text-red"></i> <span>LOGOUT </span></a></li> -->
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  