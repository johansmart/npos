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
              <h3 class="box-title">Store IN</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- /.box -->
            <div class="box" style="margin-top: -12px">
            </div>
          <!-- /.box -->
              <table id="datatable" class="table table-bordered table-striped table-condensed table-striped">
                <thead>
                  <tr class="">
                    <th>#</th>
                    <th>TANGGAL</th>
                    <th>JAM</th>
                    <th>KODE_BARANG</th>        
                    <th>NAMA_BARANG</th>
                    <th>SATUAN</th>
                    <th>KATEGORI</th>
                    <th>STOCK_AWAL</th>
                    <th>QTY_IN</th>
                    <th>STOCK_AKHIR</th>
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
                    <span class="glyphicon glyphicon-plus"></span> TAMBAH
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

<!-- datatable and number only -->
<script type="text/javascript">
  $(document).ready(function(){
    $("#pesan").hide();
    /*begin datatable*/
    $('#datatable').DataTable( {
      "autoWidth": false,
      "mark": true, 
      "scrollY"     : "370px",
      'lengthChange': false,
      "lengthMenu": [[100, 200, 300, -1], [100, 200, 300, "All"]],
      'paging'      : true,
      'searching'   : false,
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
      processing: true,
           "language": {
          processing: '<div style="margin-top:-4px"><img src="images/index.gif" alt="" class=""><span> &nbsp;&nbsp;Loading... </span></div>'},
        "serverSide" : true,

        "ajax":{
          url :"<?php echo base_url() . 'Store_in/fetch_store_in'; ?>", // json datasource
          type: "post",
            // method  , by default get
        }
      });
     });
</script>

<!-- mengambil item info hasil dari ajax -->
<script type="text/javascript">
$(document).on('change', '#kode_barang', function(event){  
   var kode_barang = $('#kode_barang').val(); 
    $.ajax({
    url: "<?php echo base_url() . 'Store_in/get_item_info'?>",
    type : "POST",
    data:{kode_barang:kode_barang},
    dataType : "JSON",
    success: function(data){
      $('#nama_barang').val(data[0])
      $('#satuan').val(data[1])
      $('#harga_jual').val(data[2])
      $('#stock').val(data[3])
    }
  })
}) 
</script>

<!-- menampilkan modal -->
<script type="text/javascript">
  $(document).ready(function (){
    $('#tambah').click(function(){
      $('#modal_tambah').modal('show');
    })   
  })  
</script>

<!-- event modal tambah barang tampil -->
<script type="text/javascript">
  $(document).on('shown.bs.modal','#modal_tambah', function (){
    $('#kode_barang').focus();
    $("#pesan").hide();
    //format hanya angka
    $("#kode_barang,#qty").keypress(function (e){
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    });
    //format hanya angka
    $('#add_barang')[0].reset();
    $('#kode_barang').focus();
  }); 
</script>

<!-- insert barng -->
<script type="text/javascript">
$(document).on('submit', '#add_barang', function(event){
  event.preventDefault();
  var kode_barang = $('#kode_barang').val();
  var stock       = $('#stock').val();
  var qty         = $('#qty').val();
  bootbox.confirm("Konfirmasi ?",function(confirmed){
    if (confirmed) {
      $.ajax({
      type : "POST",
      url:"<?php echo base_url() . 'Store_in/insert_barang'?>",
      data : 
      {
        kode_barang:kode_barang,
        stock:stock,
        qty:qty,
      },
      success: function(data){
          if (data == 'empty_err') {
            $("#pesan").show();
            $("#msg").html('Gagal menmabahkan stok barang!');
            $('#pesan').removeClass('alert alert-success alert-dismissible').addClass('alert alert-danger alert-dismissible');
            return false;
          }
          else{
            //menampilkan dan merubah class pesan
            $("#pesan").show();
            $("#msg").html('Stok barang berhasil ditambahkan!');
            $('#pesan').removeClass('alert alert-danger alert-dismissible').addClass('alert alert-success alert-dismissible');
            //menampilkan dan merubah class pesan
            $("#datatable").DataTable().ajax.reload();
            $('#add_barang')[0].reset();
            $("#kode_barang").focus();
          }
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
  <form class="form-horizontal" id="add_barang">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Form Store In</h4>
        </div>
        <div class="modal-body" style="background-color: white!important;">
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">KODE_BARANG</label>
            <div class="col-md-10">
              <input type="text" id="kode_barang" name="kode_barang" required="" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">NAMA_BARANG</label>
            <div class="col-md-10">
              <input type="text" id="nama_barang" name="nama_barang" readonly class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">SATUAN</label>
            <div class="col-md-10">
              <input type="text" id="satuan" name="satuan" readonly class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">HARGA_JUAL</label>
            <div class="col-md-10">
              <input type="text" id="harga_jual" name="harga_jual" readonly class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">STOCK</label>
            <div class="col-md-10">
              <input type="text" id="stock" name="stock" readonly class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">QTY IN</label>
            <div class="col-md-10">
              <input type="text" id="qty" name="qty" required="" class="form-control">
            </div>
          </div>
          <div class="alert alert-success alert-dismissible" id="pesan">
              <i class="icon fa fa-check"></i> <span id="msg">Stock barang berhasil ditambahkan!</span>
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
    margin-top: -45px;
    /*display: inline;*/
}
.dataTables_scrollHead{
  margin-top: -12px;
}
</style>


