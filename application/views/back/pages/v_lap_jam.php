<?php $this->load->view('back/meta') ?>
<?php $this->load->view('back/head') ?>
<?php $this->load->view('back/sidebar') ?>
<?php 
  $hari_ini     = date("Y-m-d");
  $tgl_pertama  = date('Y-m-01', strtotime($hari_ini));
?>
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-solid box-white">
            <div class="box-header">
              <h3 class="box-title"> Laporan Penjualan Per Jam</h3>
            </div>

            <div class="box-body">
              <!-- /.box -->
            <div class="box" style="margin-top: -7px">

            <div class="box-body">
              <div class='col-lg-2 col-md-4 col-sm-4 pull-left'>
                <div class="input-group date" style="margin-left: -15px">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control input-sm" name="start_date" id="start_date" autocomplete="off" value="<?php echo $hari_ini; ?>">
              </div>
            </div>

              <div class="form-group">
                <button type="button" name="search" id="search" class="btn bg-blue btn-sm">
                <span class="glyphicon glyphicon-search"></span> SUBMIT
                </button>
              </div>

              <table id="datatable" class="table table-bordered table-striped table-condensed">
                <thead>
                  <tr class="">
                    <th style="width: 100px">KATEGORI</th>
                    <th>06:00</th>
                    <th>07:00</th>
                    <th>08:00</th>
                    <th>09:00</th>
                    <th>10:00</th>
                    <th>11:00</th>
                    <th>12:00</th>
                    <th>13:00</th>
                    <th>14:00</th>
                    <th>15:00</th>
                    <th>16:00</th>
                    <th>17:00</th>
                    <th>18:00</th>
                    <th>19:00</th>
                    <th>20:00</th>
                    <th>21:00</th>
                    <th>22:00</th>
                  </tr>
                </thead>

                <tbody>
                </tbody>

                  <tfoot>
                      <tr class="">
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th> </th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th> </th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th> </th>
                        <th></th>
                      </tr>
                  </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>

   </div>
   <?php $this->load->view('back/footer') ?>
   <?php $this->load->view('back/js') ?>
   <!-- datatable -->
    <script src="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables.net-responsive-bs/js/dataTables.responsive.min.js"></script>
    <!-- highlight datatable -->
    <script src="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables_mark/datatables.mark.js"></script>
    <script src="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables_mark/jquery.mark.min.js"></script>
    <script src="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
    <!-- button component datatable -->
    <script src="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="<?php echo base_url('assets/template/backend/') ?>bower_components/jszip/dist/jszip.min.js"></script>
    <script src="<?php echo base_url('assets/template/backend/') ?>bower_components/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?php echo base_url('assets/template/backend/') ?>bower_components/pdfmake/build/vfs_fonts.js"></script>
    <script src="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
</body>
</html>

<script type="text/javascript">
$(document).ready(function(){
   $('#start_date').datepicker({
    todayBtn:'linked',
    format: "yyyy-mm-dd",
    autoclose: true
   });
  }); 

 $('#search').click(function(){
  $('#datatable').DataTable().clear().destroy();
  var start_date = $('#start_date').val();
  var end_date = $('#end_date').val();
    $('#datatable').DataTable( {
  "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            
                    // Total over all pages
        total = api
            .column( 0)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        enam = api
            .column( 1)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        tujuh = api
            .column( 2)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        delapan = api
            .column( 3)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        sembilan = api
            .column( 4)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        sepuluh = api
            .column( 5)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        sebelas = api
            .column( 6)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 ); 

        duabelas = api
            .column( 7)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        tigabelas = api
            .column( 8)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        empatbelas = api
            .column( 9)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        limabelas = api
            .column( 10)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        enambelas = api
            .column( 11)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );                                           

        tujuhbelas = api
            .column( 12)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        delapanbelas = api
            .column( 13)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        sembilanbelas = api
            .column( 14)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            
        duapuluh = api
            .column( 15)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        
        duasatu = api
            .column( 16)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        duadua = api
            .column( 17)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );                         
        // Update footer

        $( api.column( 0 ).footer() ).html('TOTAL');
        $( api.column( 1 ).footer() ).html(enam.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $( api.column( 2 ).footer() ).html(tujuh.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $( api.column( 3 ).footer() ).html(delapan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $( api.column( 4 ).footer() ).html(sembilan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $( api.column( 5 ).footer() ).html(sepuluh.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $( api.column( 6 ).footer() ).html(sebelas.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $( api.column( 7 ).footer() ).html(duabelas.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $( api.column( 8 ).footer() ).html(tigabelas.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $( api.column( 9 ).footer() ).html(empatbelas.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $( api.column( 10 ).footer() ).html(limabelas.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $( api.column( 11 ).footer() ).html(enambelas.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $( api.column( 12 ).footer() ).html(tujuhbelas.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $( api.column( 13 ).footer() ).html(delapanbelas.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $( api.column( 14 ).footer() ).html(sembilanbelas.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $( api.column( 15 ).footer() ).html(duapuluh.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $( api.column( 16 ).footer() ).html(duasatu.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $( api.column( 17 ).footer() ).html(duadua.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    },    

    "fnInitComplete": function(){
        // Disable TBODY scoll bars
        $('.dataTables_scrollBody').css({
            'overflow': 'hidden',
            'border': '0'
        });
        // Enable TFOOT scoll bars
        $('.dataTables_scrollFoot').css('overflow', 'auto');
        // Sync TFOOT scrolling with TBODY
        $('.dataTables_scrollFoot').on('scroll', function () {
            $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
        });                    
    },
 // mark: true,
  "autoWidth": false,
  "scrollX": true,
  'lengthChange': false,
  'info'        : false,
  'paging'      : false,
  'info'        : false,
  'searching'   : false,
  'ordering'   : false,

 dom: 'Blfrtip',
  buttons: [
  'copy', 'csv',
    {
        extend: 'excelHtml5', footer: true,
        filename: 'Lap_jam_'+'<?php echo date('dmY');?>'
    },
    {
        extend: 'pdfHtml5',
        orientation: 'landscape',
        pageSize: 'LEGAL',
        filename: 'Data export'
    }
  ],
   processing: true,
       "language": {
      processing: '<div style="margin-top:-4px"><img src="images/index.gif" alt="" class=""><span> &nbsp;&nbsp;Loading... </span></div>'},

   "serverSide" : true,
   "order" : [],
   "ajax" : {
    url:"<?php echo base_url() . 'Lap_jam/fetch_lap_jam'; ?>",
    type:"POST",
    data:{
     start_date:start_date
    }
   }
  });
 }); 
</script>

<style type="text/css">
  div.dt-buttons {
    float: right;
    /*margin-right:550px;*/
    margin-top: -93px;
    /*display: inline;*/
}
</style>


