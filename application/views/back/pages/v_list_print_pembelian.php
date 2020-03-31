<?php $this->load->view('back/meta') ?>
<?php $this->load->view('back/head') ?>
<?php $this->load->view('back/sidebar') ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List Print Pembelian Barang</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- /.box -->
            <div class="box box-default" style="margin-top: -7px">
            <!-- /.box-header -->
              <div class="box-body">
                <div class="col-md-2 col-xs-4">
                  <div class="input-group date">
                  <!-- <div class="input-group-addon bg-olive">
                    <span>Start</span>
                  </div> -->
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm" name="start_date" id="start_date" value="<?php echo date("Y-m-d");?>">
                </div>
                </div>
                <div class="col-md-2 col-xs-4">
                  <div class="input-group date">
                  <!-- <div class="input-group-addon bg-olive">
                    <span>End</span>
                  </div> -->
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm" name="end_date" id="end_date" value="<?php echo date("Y-m-d");?>">
                </div>
                </div>
                <div class="col-md-2">
                  <button type="button" name="button" id="search" class="btn bg-blue btn-sm">
                    <span class="glyphicon glyphicon-search"></span> CARI
                </button>
                </div>
              </div>
            <!-- /.box-body -->
            </div>
          <!-- /.box -->
            <table id="datatable" class="table table-bordered table-condensed table-striped" style="width: 100%">
                <thead class="th_hide" style='display:none;'>
                  <tr class="">
                    <th>#</th>
                    <th>TANGGAL</th>
                    <th>PURC_NO</th>          
                    <th>KODE_SUPPLIER</th>
                    <th>NAMA_SUPPLIER</th>
                    <th>TOTAL</th>
                    <th>TIPE</th>
                    <th>USER_ID</th>
                    <th width="50">OPSI</th>
                  </tr>
                </thead>
                </tbody>
            </table>
            </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- /.col -->
        
      </div>

      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

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




<!-- date picker -->
<script type="text/javascript">
  $(document).ready(function(){
   $('#start_date,#end_date').datepicker({
    todayBtn:'linked',
    format: "yyyy-mm-dd",
    autoclose: true
   });
}); 
</script>
<!-- datatable-->
<script type="text/javascript">
 $('#search').click(function(){
  $('#datatable').DataTable().clear().destroy();
  var start_date = $('#start_date').val();
  var end_date   = $('#end_date').val();
  $('#datatable').DataTable( {
  mark: true,
  "autoWidth"   : true,
  "scrollY"     : "370px",
  'lengthChange': false,
  'searching'   : false,
  "lengthMenu"  : [[1000, 2000, 3000, -1], [1000, 2000, 3000, "All"]],
  "responsive"  : true,
   fixedColumns : true,
  dom           : 'Blfrtip',
  buttons: [
 
  ],
   processing: true,
  "language": {
   processing: '<div style="margin-top:-4px"><img src="images/index.gif" alt="" class=""><span> &nbsp;&nbsp;Loading... </span></div>'
    },
   "serverSide" : true,
   //"order" : [],
   "ajax" : {
    url :"<?php echo base_url() . 'list_print_pembelian/fetch_list_print'; ?>", // json datasource
    type:"POST",
    data:{
     start_date:start_date, end_date:end_date
    }
   }
  });
  $('.th_hide').show();
 }); 
</script>

<script type="text/javascript">
  $(document).on('click', '#print', function(event){
    event.preventDefault();
    window.open($(this).attr("href"), "popupWindow", "width=1000,height=600,scrollbars=yes");
});
</script>

<style type="text/css">
.table tbody tr:hover td, .table tbody tr:hover th {
  background-color: #ccccff;
}
input 
{
  border:1px solid white;
  padding: 3px;
}

div.dt-buttons {
    float: right;
    /*margin-right:550px;*/
    margin-top: -50px;
    /*display: inline;*/
}
.dataTables_scrollHead{
  margin-top: -12px;
}


</style>


