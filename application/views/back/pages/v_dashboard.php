<?php $this->load->view('back/meta') ?>
<?php $this->load->view('back/head') ?>
<?php $this->load->view('back/sidebar') ?>


<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="background-color: #17a2b8;color: white">
            <div class="inner">
              <h3><span id="jml_barang" style="font-size: 30px"></span></h3>
              <p>JUMLAH BARANG</p>
            </div>
            <div class="icon">
              <i class="fa fa-database"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="background-color: #28a745;color: white">
            <div class="inner">
              <h3><span id="stock_kosong" style="font-size: 30px"></h3>

              <p>STOCK KOSONG</p>
            </div>
            <div class="icon">
              <i class="fa fa-ban"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="background-color: #ffc107">
            <div class="inner">
              <h3><span id="sales_hari_ini" style="font-size: 30px"></h3>
              <p>SALES HARI INI</p>
            </div>
            <div class="icon">
              <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple" >
            <div class="inner">
              <h3><span id="sales_bulan_ini" style="font-size: 30px"></h3>
              <p>SALES BULAN INI</p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
            <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Chart Report</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <p class="text-center text-blue">
                    <strong>GRAFIK TANGGAL PENJUALAN BULAN INI</strong>
                  </p>
                  <div class="chart">
                    <canvas id="line-chart" style="height: 180px;"></canvas>
                  </div>
                </div>
              </div>
              <!-- /.row -->
            </div>

            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <p class="text-center text-blue">
                    <strong>GRAFIK JAM PENJUALAN HARI INI</strong>
                  </p>
                  <div class="chart">
                    <canvas id="time-line-chart" style="height: 180px;"></canvas>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>

            <!-- ./box-body -->

          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- /.row -->

    </section>
    </div>
  </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
<?php $this->load->view('back/js') ?>
</body>
</html>

<script type="text/javascript">
  $(document).ready(function() {
    //data untuk jumlah barang
    $.ajax({  
        url:"<?php echo base_url() . 'Dashboard/jml_barang'?>",  
        method:'POST',  
        success:function(jml_barang){  
          $('#jml_barang').html(jml_barang);
        }  
     });
    //data untuk stock kosong
     $.ajax({  
        url:"<?php echo base_url() . 'Dashboard/stock_kosong'?>",  
        method:'POST',  
        success:function(stock_kosong){  
          $('#stock_kosong').html(stock_kosong);
        }  
     });
     //data untuk sales hari ini
     $.ajax({  
        url:"<?php echo base_url() . 'Dashboard/sales_hari_ini'?>",  
        method:'POST',  
        success:function(sales_hari_ini){  
          $('#sales_hari_ini').html(sales_hari_ini);
        }  
     });
     //data untuk sales bilan ini
     $.ajax({  
        url:"<?php echo base_url() . 'Dashboard/sales_bulan_ini'?>",  
        method:'POST',  
        success:function(sales_bulan_ini){  
          $('#sales_bulan_ini').html(sales_bulan_ini);
        }  
     });
  } );
</script>

<!-- line chart -->
<script>
  var data_tanggal  = [];
  var data_jumlah   = [];
  $.post("<?php echo base_url() . 'Dashboard/getdata_chart_date'?>",function(data){
      var obj = JSON.parse(data);
      $.each(obj, function(test,item){
      data_tanggal.push(item.left_date);
      data_jumlah.push(item.jml_sales)
   });

  var chartColors = {
      red: 'rgb(255, 99, 132)',
      orange: 'rgb(255, 159, 64)',
      yellow: 'rgb(255, 205, 86)',
      green: '#008ffb',
      blue: 'rgb(54, 162, 235)',
      purple: '#546e7a',
      grey: 'rgb(231,233,237)',
      bg_blue : '#37b7f3',
      white : '#ffffff'
  }; 

  new Chart(document.getElementById("line-chart"), {
      type: 'line',
      data: {
        labels: data_tanggal,
        datasets: [
          {
              borderColor: chartColors.green,
              pointBorderColor: chartColors.green,
              pointBackgroundColor: chartColors.green,
              borderWidth:2,
              borderDash: [2],
              pointRadius: 2,
              pointHoverRadius: 5,
              pointHitRadius: 30,
              pointBorderWidth: 2,
              pointStyle: 'rectRounded',
              data: data_jumlah
          }
        ]
      },

      options: {
          elements: {
          line: {
            tension: 0
          }
        },

          display: true,
          legend: {
           display: false 
         },

         scales: {
            xAxes: [{
                gridLines: {
                    display:true,
                    //borderDash: [5, 5],
                }
            }],
            yAxes: [{
                gridLines: {
                    display:true,
                    //borderDash: [5, 5],
                }   
            }],
        }
      }
    });
  });
</script>

<script>
  var data_jam      = [];
  var data_jumlah_perjam   = [];
  $.post("<?php echo base_url() . 'Dashboard/getdata_chart_time'?>",function(data2){
      var obj = JSON.parse(data2);
      $.each(obj, function(test2,item2){
      data_jam.push(item2.jam);
      data_jumlah_perjam.push(item2.jml_kendaraan)
   });

  var chartColors = {
      red: 'rgb(255, 99, 132)',
      orange: 'rgb(255, 159, 64)',
      yellow: 'rgb(255, 205, 86)',
      green: '#008ffb',
      blue: 'rgb(54, 162, 235)',
      purple: '#546e7a',
      grey: 'rgb(231,233,237)',
      bg_blue : '#37b7f3',
      white : '#ffffff'
  };
      
  new Chart(document.getElementById("time-line-chart"), {
      type: 'line',
      data: {
        labels: data_jam,
        datasets: [
          {
            //backgroundColor: 'transparent',
              borderColor: chartColors.red,
              pointBorderColor: chartColors.red,
              pointBackgroundColor: chartColors.red,
              borderWidth:2,
              borderDash: [2],
              pointRadius: 2,
              pointHoverRadius: 5,
              pointHitRadius: 30,
              pointBorderWidth: 2,
              pointStyle: 'rectRounded',
              data: data_jumlah_perjam
          }
        ]
      },
      options: {
          elements: {
          line: {
            tension: 0
          }
        },

          display: true,
          legend: {
           display: false 
         },

         scales: {
            xAxes: [{
                gridLines: {
                    display:true,
                    //borderDash: [5, 5],
                }
            }],
            yAxes: [{
                gridLines: {
                    display:true,
                    //borderDash: [5, 5],
                }   
            }]
        }
      }
    });
  });
</script>


