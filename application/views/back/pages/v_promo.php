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
              <h3 class="box-title">Promo Barang</h3>
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
                    <th>ID</th>
                    <th>KODE_BARANG</th>        
                    <th>NAMA_BARANG</th>
                    <th>HARGA</th>
                    <th>HARGA_PROMO</th>
                    <th>MULAI</th>
                    <th>SELESAI</th>
                    <th>REGISTER</th>
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
                    <span class="glyphicon glyphicon-plus"></span> TAMBAH PROMO
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

<!-- <?php $this->load->view('back/footer') ?> -->
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
      "scrollY"     : "400px",
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
          url :"<?php echo base_url() . 'Promo/fetch_promo'; ?>", // json datasource
          type: "post",
            // method  , by default get
        }
      });
     });
</script>

<!-- mengambil item info hasil dariajax -->
<script type="text/javascript">
  $(document).on('change', '#kode_barang', function(event){
   var kode_barang = $('#kode_barang').val(); 
   event.preventDefault();
      $.ajax({
      url: "<?php echo base_url() . 'Promo/get_item_info'?>",
      type : "POST",
      data:{kode_barang:kode_barang},
      dataType : "JSON",
      success: function(data){
        $('#nama_barang').val(data[0])
        $('#harga_brg').val(data[3])
      }
    })
  })

</script>

<!-- event modal tambah dan edit tampil -->
<script type="text/javascript">
  $(document).on('shown.bs.modal','#modal_tambah', function (){
    //number only
    $("#kode_barang,#persen").keypress(function (e){
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    });
    $("#pesan").hide();
    $('#add_promo')[0].reset();
    $('#kode_barang').focus();
  }); 
</script>

<!-- menampilkan modal -->
<script type="text/javascript">
  $(document).ready(function (){
    $('#tambah').click(function(){
      $('#modal_tambah').modal('show');
    })   
  })  
</script>

<!-- insert diskon -->
<script type="text/javascript">
$(document).on('submit', '#add_promo', function(event){
  event.preventDefault();
  var kode_barang  = $('#kode_barang').val();
  var nama_barang  = $('#nama_barang').val();
  var harga_brg    = $("#harga_brg").val();
  var harga_promo  = $("#harga_promo").val();
  var start_date   = $("#start_date").val();
  var end_date     = $("#end_date").val();
    bootbox.confirm("Konfirmasi ?",function(confirmed){
      if (confirmed) {
        $.ajax({
        type : "POST",
        url:"<?php echo base_url() . 'Promo/insert_promo'?>",
        data : 
        {
          kode_barang:kode_barang,
          nama_barang:nama_barang,
          harga_brg:harga_brg,
          harga_promo:harga_promo,
          start_date:start_date,
          end_date:end_date
        },
        success: function(data){
          //menampilkan dan merubah class pesan
          $("#pesan").show();
          $("#msg").html('Promo berhasil ditambahkan!');
          $('#pesan').removeClass('alert alert-danger alert-dismissible').addClass('alert alert-success alert-dismissible');
          //menampilkan dan merubah class pesan
          $("#datatable").DataTable().ajax.reload();
          $('#add_promo')[0].reset(); 
        }
      });
      }
    });
});
</script>

<!-- event keyup menyembunyikan pesan -->
<script type="text/javascript">
  $(document).on('keyup', '#kode_barang', function(){
    $('#pesan').hide();
  });
</script>

<!-- tambah modal -->
<div class="modal fade modal-danger" id="modal_tambah">
  <form class="form-horizontal" id="add_promo">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Form Tambah Promo</h4>
        </div>
        <div class="modal-body" style="background-color: white!important;">
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">KODE_BARANG</label>
            <div class="col-md-10">
              <input id="kode_barang" class="form-control input-sm" type="text" name="kode_barang" value="" required="">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">NAMA_BARANG</label>
            <div class="col-md-10">
              <input id="nama_barang" name="nama_barang" class="form-control col-md-7 col-xs-12  input-sm" type="text" readonly="" >
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">HARGA</label>
            <div class="col-md-10 col-sm-2">
              <input type="text" class="form-control input-sm" name="harga_brg" id="harga_brg" readonly="">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">HARGA_PROMO</label>
            <div class="col-md-10 col-sm-2">
              <input type="text" class="form-control input-sm" name="harga_promo" id="harga_promo" required="">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">TGL_MULAI</label>
            <div class="col-md-4 col-sm-2">
              <input type="text" class="form-control input-sm" name="start_date" id="start_date" value="" required="">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">TGL_SELESAI</label>
            <div class="col-md-4 col-sm-2">
              <input type="text" class="form-control input-sm" name="end_date" id="end_date" value="" required="">
            </div>
          </div>
          <div class="alert alert-success alert-dismissible" id="pesan">
              <i class="icon fa fa-check"></i> <span id="msg"></span>
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

/*div.dataTables_wrapper  div.dataTables_filter {
  margin-top: -37px;
}*/

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



