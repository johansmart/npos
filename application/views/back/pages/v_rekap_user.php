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
          <div class="box box-solid box-default">
            <div class="box-header">
              <h3 class="box-title"> LAPORAN REKAP USER</h3>
            </div>
              <div class="box-body">
              <div class="col-lg-2 col-md-4 col-sm-4 ">
                <div class="input-group date"  style="margin-left: -15px">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control input-sm" name="start_date" id="start_date" autocomplete="off" value="<?php echo $hari_ini; ?>">
              </div>
                </div>
              <div class='col-lg-2 col-md-4 col-sm-4 pull-left'>
                <div class="input-group date" style="margin-left: -15px">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
                <input type="text" class="form-control pull-right input-sm" name="end_date" id="end_date" autocomplete="off" value="<?php echo $hari_ini; ?>">
              </div>
              </div>
              <div class="form-group">
                <button type="button" name="search" id="search" class="btn btn-primary btn-sm btn-flat">
                <span class="glyphicon glyphicon-search"></span> SUBMIT
                </button>
              </div>
              <table id="datatable" class="table table-bordered table-striped table-condensed">
                <thead>
                  <tr class="danger">
                   <!--  <th width="10%">NO</th> -->
                    <th width="10%">USER_ID</th>
                    <th width="20%">USER_NAME</th>
                    <th width="10%">MOTOR</th>        
                    <th width="10%">MOBIL</th>
                    <th width="100%">TOTAL</th>
                  </tr>
                </thead>
                <tbody id="show_data">
                    
                </tbody>
                <tfoot>
                  <tr class="">
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
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
</body>
</html>

<script type="text/javascript">
  $(document).ready(function(){
     $('#start_date,#end_date').datepicker({
      todayBtn:'linked',
      format: "yyyy-mm-dd",
      autoclose: true
     });
    }); 
    //fetch_data('no');
   function fetch_data(is_date_search, start_date='', end_date='')
   {
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
        user_id = api
            .column( 0)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        user_name = api
            .column( 1)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        motor = api
            .column( 2)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        mobil = api
            .column( 3)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        total = api
            .column( 4)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

                        
        // Update footer

        $( api.column( 0 ).footer() ).html('');
        $( api.column( 1 ).footer() ).html('TOTAL');
        $( api.column( 2 ).footer() ).html(motor);
        $( api.column( 3 ).footer() ).html(mobil);
        $( api.column( 4 ).footer() ).html(total);
      },   
    "autoWidth": true,
    'lengthChange': false,
    'info'        : false,
    'paging'      : false,
    'info'        : false,
    'searching'   : false,
    'ordering'    : false,

    "lengthMenu": [[100, 200, 300, -1], [100, 200, 300, "All"]],
    "responsive": true,
     fixedColumns: true,
  /*   "columnDefs": [ {
        "targets": [ 11],
        "orderable": false
      } ],*/
   dom: 'Blfrtip',
    buttons: [
    'copy', 'csv',
        {
            extend: 'excelHtml5',footer: true,
            filename: 'Data export'
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
      url:"<?php echo base_url() . 'Rekap_user/fetch_rekap_user'; ?>",
      type:"POST",
      data:{
       is_date_search:is_date_search, start_date:start_date, end_date:end_date
      }
     }

    });
    
   }

   $('#search').click(function(){
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    if(start_date != '' && end_date !='')
    {
     $('#datatable').DataTable().destroy();
     fetch_data('yes', start_date, end_date);
    }
    else
    {
     /*alert("Both Date is Required");*/
     if (start_date=='') {
        $('#start_date').focus()
     }
     else if (end_date=='') {
        $('#end_date').focus()
     }
     
    }
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

