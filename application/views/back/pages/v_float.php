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
              <h3 class="box-title">Shift POS</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- /.box -->
            <div class="box" style="margin-top: -12px">
            </div>
          <!-- /.box -->
              <table id="datatable" class="table table-bordered table-condensed">
                <thead>
                  <tr class="">
                    <th>TANGGAL</th>
                    <th>JAM</th>
                    <th>ID_KASIR</th>
                    <th>NAMA_KASIR</th>        
                    <th>NO_POS</th>
                    <th>SHIFT</th>
                    <th>START_OF_SHIFT</th>
                    <th>END_OF_SHIFT</th>
                  </tr>
                </thead>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- /.col -->
      </div>
      <div class="box" style="margin-top: -15px">
            <!-- /.box-header -->
            <div class="box-body">
              <div align="left">
                <button type="button" name="tambah" id="start_shift" class="btn bg-blue btn-sm">
                    <span class="fa fa-flag-o"></span> Start Of Shift
                </button>
                <button type="button" name="tambah" id="end_shift" class="btn bg-red btn-sm">
                    <span class="fa fa-flag-checkered"></span> End Of Shift
                </button>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php $this->load->view('back/js') ?>
<!-- datatable -->
<script src="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
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
<!-- Select2 -->
<script src="<?php echo base_url('assets/template/backend/') ?>bower_components/select2/dist/js/select2.full.min.js"></script>

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

<!-- datatable and number only -->
<script type="text/javascript">
  $(document).ready(function(){
    $("#pesan").hide();
    $("#edit_pesan").hide();
    /*begin datatable*/
    $('#datatable').DataTable( {
      "autoWidth": true,
      "mark": true, 
      "scrollY"     : "350px",
      'lengthChange': true,
      "lengthMenu": [[100, 200, 300, -1], [100, 200, 300, "All"]],
      'paging'      : true,
      'searching'   : true,
      'info'        : true,
      "ordering": true,
      dom: 'Blfrtip',
      buttons: [
      /*'copy', 'csv',
        {
          extend: 'excelHtml5',
          filename: 'Data export'
        },
        {
          extend: 'pdfHtml5',
          orientation: 'landscape',
          pageSize: 'LEGAL',
          filename: 'Data export'
        }*/
      ],
      processing: false,
        "language": {
        processing: '<div style="margin-top:-4px"><img src="images/index.gif" alt="" class=""><span> &nbsp;&nbsp;Loading... </span></div>'},
        "serverSide" : true,
        "ajax":{
          url :"<?php echo base_url() . 'Float_shift/fetch_float'; ?>", // json datasource
          type: "post",
            // method  , by default get
        }
      });
     });
</script>

<!-- event modal start shift-->
<script type="text/javascript">
  $(document).on('shown.bs.modal','#modal_tambah', function (){
    //number only
    $("#setoran_awal").keypress(function (e){
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    });
    $("#pesan").hide();
    $('#add_float')[0].reset();
    $('#setoran_awal').focus();
  }); 
</script>

<!-- event modal end shift-->
<script type="text/javascript">
  $(document).on('shown.bs.modal','#modal_end', function (){
    //number only
    $("#end_shift_setoran").keypress(function (e){
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    $("#end_shift_pesan").hide();
    });
    $.ajax({
      type : "POST",
      url:"<?php echo base_url() . 'Float_shift/get_sales_kasir'?>",
      success: function(data){
        $('#end_shift_tot_penjualan').val(data)
      }
    });
    $("#end_shift_pesan").hide();
    $('#end_float')[0].reset();
    $('#end_shift_setoran').focus();
  }); 
</script>

<!-- menampilkan modal -->
<script type="text/javascript">
  $(document).ready(function (){
    $('#start_shift').click(function(){
      $('#modal_tambah').modal('show');
    })
    $('#end_shift').click(function(){
      $('#modal_end').modal('show');
    })    
  })  
</script>

<!-- insert start shift -->
<script type="text/javascript">
$(document).on('submit', '#add_float', function(event){
  event.preventDefault();
  var id_kasir     = $('#id_kasir').val();
  var no_pos       = $('#no_pos').val();
  var shift        = $("#shift option:selected").html();
  var setoran_awal = $("#setoran_awal").val();
  bootbox.confirm("Konfirmasi ?",function(confirmed){
    if (confirmed) {
      $.ajax({
      type : "POST",
      url:"<?php echo base_url() . 'Float_shift/insert_float'?>",
      data : 
      {
        id_kasir:id_kasir,
        no_pos:no_pos,
        shift:shift,
        setoran_awal:setoran_awal
      },
      success: function(data){
        if (data=='already') {
          //menampilkan dan merubah class pesan
          $("#pesan").show();
          $("#msg").html('Float untuk hari ini sudah terinput!');
          $('#pesan').removeClass('alert alert-success alert-dismissible').addClass('alert alert-warning alert-dismissible');
          //menampilkan dan merubah class pesan
          return false;
        }
        else{
          //menampilkan dan merubah class pesan
          $("#pesan").show();
          $("#msg").html('Float berhasil, silahkan memulai penjualan');
          $('#pesan').removeClass('alert alert-danger alert-dismissible').addClass('alert alert-success alert-dismissible');
          //menampilkan dan merubah class pesan
          $("#datatable").DataTable().ajax.reload();
          $('#add_float')[0].reset();
          $.ajax({
            type : "POST",
            url:"<?php echo base_url() . 'Print_shift/print_start_shift'?>",
          })   
        }
      }
    });
    }
  });
});
</script>

<!-- update end shift -->
<script type="text/javascript">
$(document).on('submit', '#end_float', function(event){
  event.preventDefault();
  var id_kasir     = $('#end_shift_id_kasir').val();
  var no_pos       = $('#end_shift_no_pos').val();
  var shift        = $("#end_shift_shift option:selected").html();
  var setoran_akhir= $("#end_shift_setoran").val();
  bootbox.confirm("Konfirmasi ?",function(confirmed){
    if (confirmed) {
      $.ajax({
      type : "POST",
      url:"<?php echo base_url() . 'Float_shift/update_end_shift'?>",
      data : 
      {
        id_kasir:id_kasir,
        no_pos:no_pos,
        shift:shift,
        setoran_akhir:setoran_akhir
      },
      success: function(data){
        if (data=='already') {
          //menampilkan dan merubah class pesan
          $("#end_shift_pesan").show();
          $("#end_shift_msg").html('End shift untuk hari ini sudah terinput!');
          $('#end_shift_pesan').removeClass('alert alert-success alert-dismissible').addClass('alert alert-warning alert-dismissible');
          //menampilkan dan merubah class pesan
          return false;
        }
        else if (data=='not_found') {
          $("#end_shift_pesan").show();
          $("#end_shift_msg").html('Gagal mengirim data pastikan shift sudah sesuai!');
          $('#end_shift_pesan').removeClass('alert alert-success alert-dismissible').addClass('alert alert-warning alert-dismissible');
        }
        else{
          //menampilkan dan merubah class pesan
          $("#end_shift_pesan").show();
          $("#end_shift_msg").html('Setoran end shift berhasil');
          $('#end_shift_pesan').removeClass('alert alert-warning alert-dismissible').addClass('alert alert-success alert-dismissible');
          //menampilkan dan merubah class pesan
          $("#datatable").DataTable().ajax.reload();
          $.ajax({
            type : "POST",
            url:"<?php echo base_url() . 'Print_shift/print_end_shift'?>",
          })
          //$('#end_float')[0].reset(); 
        }
      }
    });
    }
  });
});
</script>

<!-- event keyup menyembunyikan pesan -->
<script type="text/javascript">
  $(document).on('keyup', '#end_shift_setoran', function(){
    $("#end_shift_pesan").hide();
  });
</script>

<!-- start shift modal -->
<div class="modal fade modal-info" id="modal_tambah" data-backdrop="static">
  <form class="form-horizontal" id="add_float">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Form Start Shift</h4>
        </div>
        <div class="modal-body" style="background-color: white!important;">
          <div class="form-group">
            <label class="col-xs-2 control-label text-black">ID_KASIR</label>
            <div class="col-md-10 col-sm-10">
              <input id="id_kasir" class="form-control input-sm bg-gray" type="text" name="id_kasir" value="<?php echo $this->session->userdata('id_karyawan'); ?>" readonly="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-2 control-label text-black">NO_POS</label>
            <div class="col-md-5 col-sm-5">
              <input id="no_pos" name="no_pos" class="form-control input-sm bg-gray" type="text" readonly="" value="1001">
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-2 control-label text-black">SHIFT</label>
            <div class="col-md-5 col-sm-5">
              <select class="form-control select-sm" id="shift" name="shift" required="">
                    <option>SHIFT 1</option>
                    <option>SHIFT 2</option>
                    <option>SHIFT 3</option>
                </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-2 control-label text-black">SETORAN_AWAL</label>
            <div class="ccol-md-10 col-sm-10">
              <input type="text" class="form-control input-sm" name="setoran_awal" id="setoran_awal" autocomplete="off" required="">
            </div>
          </div>
          <div class="callout callout-danger">
              <h4>Warning :</h4>
              <p>Masukkan setoran yang benar</p>
          </div>
          <div class="alert alert-success alert-dismissible" id="pesan">
              <i class="icon fa fa-check"></i> <span id="msg">Setoran berhasil!.</span>
          </div>  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline  pull-left" data-dismiss="modal">Close</button>
          <button type="submit" id="save" class="btn btn-outline">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
  </form>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- end shift modal -->
<div class="modal fade modal-danger" id="modal_end" data-backdrop="static">
  <form class="form-horizontal" id="end_float">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Form End Shift</h4>
        </div>
        <div class="modal-body" style="background-color: white!important;">
          <div class="form-group">
            <label class="col-xs-3 control-label text-black">ID_KASIR</label>
            <div class="col-md-9 col-sm-9">
              <input id="end_shift_id_kasir" class="form-control input-sm bg-gray" type="text" name="end_shift_id_kasir" value="<?php echo $this->session->userdata('id_karyawan'); ?>" readonly="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-3 control-label text-black">NO_POS</label>
            <div class="col-md-5 col-sm-5">
              <input id="end_shift_no_pos" name="end_shift_no_pos" class="form-control input-sm bg-gray" type="text" readonly="" value="1001">
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-3 control-label text-black">SHIFT</label>
            <div class="col-md-5 col-sm-5">
              <select class="form-control select-sm" id="end_shift_shift" name="end_shift_shift" required="">
                    <option>SHIFT 1</option>
                    <option>SHIFT 2</option>
                    <option>SHIFT 3</option>
                </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-3 control-label text-black">TOTAL_PENJUALAN</label>
            <div class="ccol-md-5 col-sm-5">
              <input type="text" class="form-control bg-gray input-sm" name="end_shift_tot_penjualan" id="end_shift_tot_penjualan" autocomplete="off" readonly="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-3 control-label text-black">SETORAN_AKHIR</label>
            <div class="ccol-md-9 col-sm-9">
              <input type="text" class="form-control input-sm" name="end_shift_setoran" id="end_shift_setoran" autocomplete="off" required="">
            </div>
          </div>
          <div class="callout bg-blue">
              <h4>Warning :</h4>
              <p>Setelah end of shift anda tidak dapat lagi melakukan penjualan,dan pastikan setelah melakukan end of shift lakukan closing, jika tidak maka anda tidak dapat melakukan penjualan pada esok harinya </p>
          </div>
          <div class="alert alert-warning alert-dismissible" id="end_shift_pesan">
              <i class="icon fa fa-check"></i> <span id="end_shift_msg"></span>
          </div>  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline  pull-left" data-dismiss="modal">Close</button>
          <button type="submit" id="save" class="btn btn-outline">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
  </form>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<style type="text/css">
.table tbody tr:hover td, .table tbody tr:hover th {
  background-color: white;
}
input 
{
  border:1px solid white;
  padding: 3px;
}

div.dataTables_wrapper  div.dataTables_filter {
/*  width: 100%;*/
  margin-top: -37px;
}
.dataTables_length {
    margin-top: -1%;
    /*margin-left: 40%;*/
}
div.dt-buttons {
    float: right;
    /*margin-right:550px;*/
    margin-top: -50px;
    /*display: inline;*/
}
.btn-default.btn-on-2.active{
  background-color: #245884;color: white;
}
.btn-default.btn-off-2.active{
  background-color: #dd4b39;color: white;
}
</style>



