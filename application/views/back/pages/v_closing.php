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
              <h3 class="box-title">Closing Harian</h3>
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
                    <th>END_OF_SHIFT_1</th>
                    <th>END_OF_SHIFT_2</th>
                    <th>TOTAL_KAS</th>
                    <th>PENGELUARAN</th>
                    <th>KAS_AKHIR</th>
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
                <button type="button" name="tambah" id="tambah" class="btn bg-blue btn-sm">
                    <span class="glyphicon glyphicon-plus"></span> CLOSING
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
      "autoWidth": false,
      "mark": true, 
      "scrollY"     : "370px",
      'lengthChange': true,
      "lengthMenu": [[100, 200, 300, -1], [100, 200, 300, "All"]],
      'paging'      : true,
      'searching'   : true,
      'info'        : true,
      "ordering": true,
      dom: 'Blfrtip',
      buttons: [
      'copy', 'csv',
        {
          extend: 'excelHtml5',
          filename: 'Data export'
        },
        {
          extend: 'pdfHtml5',
          orientation: 'landscape',
          pageSize: 'LEGAL',
          filename: 'Data export'
        }
      ],
      processing: false,
        "language": {
        processing: '<div style="margin-top:-4px"><img src="images/index.gif" alt="" class=""><span> &nbsp;&nbsp;Loading... </span></div>'},
        "serverSide" : true,
        "ajax":{
          url :"<?php echo base_url() . 'Closing/fetch_closing'; ?>", // json datasource
          type: "post",
            // method  , by default get
        }
      });
     });
</script>

<!-- event modal tambah dan edit tampil -->
<script type="text/javascript">
  $(document).on('shown.bs.modal','#modal_tambah', function (){
    $("#pesan").hide();
    $('#add_closing')[0].reset();
    $('#start_date').val('');
  }); 
</script>

<!-- hide message on click start date -->
<script type="text/javascript">
  $(document).on('click','#start_date', function (){
    $("#pesan").hide();
  }); 
</script>

<!-- menampilkan modal -->
<script type="text/javascript">
  $(document).ready(function (){
    $('#tambah').click(function(){
      $.ajax({
        type : "POST",
        dataType:"json",
        url:"<?php echo base_url() . 'Closing/cek_end_shift'?>",
        success: function(data){
          if (data==0) {
            bootbox.alert('Anda belum melakukan End Of Shift')
          }
          else{
            $('#modal_tambah').modal('show');
          }
        }
      });
      //$('#modal_tambah').modal('show');
    })   
  })  
</script>

<!-- get float -->
<script type="text/javascript">
$(document).on('change', '#start_date', function(event){
  event.preventDefault();
  var start_date   = $("#start_date").val();
  $.ajax({
    type : "POST",
    dataType:"json",
    url:"<?php echo base_url() . 'Closing/get_data'?>",
    data : 
    {
      start_date:start_date
    },
    success: function(data){
      if (data==0) {
        $('#shift_1').val('');
        $('#shift_2').val('');
        $('#pengeluaran').val('');
        $('#total_kas').val('');
        $('#kas_akhir').val('');
      }
      else{
        $('#shift_1').val(data[0]);
        $('#shift_2').val(data[1]);
        $('#pengeluaran').val(data[2]);
        $('#total_kas').val(parseInt(data[0])+parseInt(data[1]));
        $('#kas_akhir').val(parseInt(data[0])+parseInt(data[1])-parseInt(data[2]));
      }
    }
  });
});
</script>

<!-- insert closing -->
<script type="text/javascript">
$(document).on('submit', '#add_closing', function(event){
  event.preventDefault();
  //var id_kasir     = $('#id_kasir').val();
  var start_date  = $('#start_date').val();
  var no_pos      = $('#no_pos').val();
  var shift_1     = $('#shift_1').val();
  var shift_2     = $("#shift_2").val();
  var total_kas   = $("#total_kas").val();
  var pengeluaran = $("#pengeluaran").val();
  var kas_akhir   = $("#kas_akhir").val();
  if (shift_1==0) {
    $("#pesan").show();
    $("#msg").html('Data tidak ditemukan');
    $('#pesan').removeClass('alert alert-success alert-dismissible').addClass('alert alert-warning alert-dismissible');
    //menampilkan dan merubah class pesan
    return false;
  }
  bootbox.confirm("Konfirmasi ?",function(confirmed){
    if (confirmed) {
      $.ajax({
      type : "POST",
      url:"<?php echo base_url() . 'Closing/insert_closing'?>",
      data : 
      {
        start_date:start_date,
        no_pos:no_pos,
        shift_1:shift_1,
        shift_2:shift_2,
        total_kas:total_kas,
        pengeluaran:pengeluaran,
        kas_akhir:kas_akhir
      },
      success: function(data){
       if (data=='already') {
          //menampilkan dan merubah class pesan
          $("#pesan").show();
          $("#msg").html('Closing hari ini sudah dilakukan!');
          $('#pesan').removeClass('alert alert-success alert-dismissible').addClass('alert alert-warning alert-dismissible');
          //menampilkan dan merubah class pesan
          return false;
        }
        else{
          //menampilkan dan merubah class pesan
          $("#pesan").show();
          $("#msg").html('Closing berhasil !');
          $('#pesan').removeClass('alert alert-danger alert-dismissible').addClass('alert alert-success alert-dismissible');
          //menampilkan dan merubah class pesan
          $("#datatable").DataTable().ajax.reload();
          $('#add_closing')[0].reset();
          $.ajax({
            type : "POST",
            url:"<?php echo base_url() . 'Print_closing/print_closing'?>",
          }) 
        } 
      }
    });
    }
  });
});
</script>

<!-- event keyup menyembunyikan pesan -->
<script type="text/javascript">
  $(document).on('keyup', '#nama_supplier', function(){
    $('#pesan').hide();
  });
</script>

<!-- tambah modal -->
<div class="modal fade modal-danger" id="modal_tambah" data-backdrop="static">
  <form class="form-horizontal" id="add_closing">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Form Closing Harian </h4>
        </div>
        <div class="modal-body" style="background-color: white!important;">
          <div class="form-group">
            <label class="col-xs-3 control-label text-black">TANGGAL</label>
            <div class="col-md-5 col-sm-5">
              <input type="text" class="form-control input-sm" required="" name="start_date" id="start_date" value="<?php echo date("Y-m-d");?>" placeholder="...Pilih tanggal closing...">
            </div>
          </div>
          <!-- <div class="form-group">
            <label class="col-xs-2 control-label text-black">ID_KASIR</label>
            <div class="col-md-10 col-sm-10">
              <input id="id_kasir" class="form-control input-sm bg-gray" type="text" name="id_kasir" value="<?php echo $this->session->userdata('id_karyawan'); ?>" readonly="">
            </div>
          </div> -->
          <input id="no_pos" name="no_pos" class="form-control input-sm bg-gray" type="hidden" readonly="" value="1001">
           
          <div class="form-group">
            <label class="col-xs-3 control-label text-black">END_OF_SHIFT 1</label>
            <div class="col-md-8 col-sm-8">
              <input id="shift_1" name="shift_1" class="form-control input-sm bg-gray" type="text" readonly="" >
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-3 control-label text-black">END_OF_SHIFT 2</label>
            <div class="col-md-8 col-sm-8">
              <input id="shift_2" name="shift_2" class="form-control input-sm bg-gray" type="text" readonly="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-3 control-label text-black">TOTAL KAS</label>
            <div class="ccol-md-8 col-sm-8">
              <input type="text" class="form-control input-sm bg-gray" name="total_kas" id="total_kas" readonly="" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-3 control-label text-black">PENGELUARAN</label>
            <div class="col-md-8 col-sm-8">
              <input id="pengeluaran" name="pengeluaran" class="form-control input-sm bg-gray" type="text" readonly="" >
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-3 control-label text-black">KAS_AKHIR</label>
            <div class="ccol-md-8 col-sm-8">
              <input type="text" class="form-control input-sm bg-gray" name="kas_akhir" id="kas_akhir" readonly="" >
            </div>
          </div>
          <div class="callout bg-blue">
              <h4>Warning :</h4>
              <p>Setelah closing maka POS tidak dapat digunakan lagi untuk hari ini, dan pastikan yang melakukan clossing adalah shift akhir</p>
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



