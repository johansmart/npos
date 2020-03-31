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
              <h3 class="box-title">Master Pelanggan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- /.box -->
            <div class="box" style="margin-top: -12px">
            </div>
          <!-- /.box -->
            <table id="datatable" class="table table-bordered table-striped table-condensed" style="width: 100%">
                <thead>
                  <tr class="">
                    <th>KODE_PELANGGAN</th>
                    <th>NAMA_PELANGGAN</th>
                    <th>ALAMAT</th>
                    <th>NO_TELEPON</th>
                    <th>EMAIL</th>
                    <th>REGISTER</th>
                    <th>TANGGAL</th>
                    <th>OPSI</th>        
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
                    <span class="glyphicon glyphicon-plus"></span> TAMBAH PELANGGAN
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
    $("#pesan").hide();
    /*begin datatable*/
    $('#datatable').DataTable( {
      "autoWidth"   : false,
      "mark"        : true, 
      "scrollY"     : "400px",
      "scrollX"     : true,
      'lengthChange': true,
      "lengthMenu"  : [[100, 200, 300, -1], [100, 200, 300, "All"]],
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
      processing: true,
           "language": {
          processing: '<div style="margin-top:-4px"><img src="images/index.gif" alt="" class=""><span> &nbsp;&nbsp;Loading... </span></div>'},
        "serverSide" : true,

        "ajax":{
          url :"<?php echo base_url() . 'Master_pelanggan/fetch_master_pelanggan'; ?>", // json datasource
          type: "post",
            // method  , by default get
        }
      });
     });
   
      /*begin edit*/
      $(document).on('click', '#edit', function(event){
        event.preventDefault();
        //menampilkan data ke input text
        var currentRow = $(this).closest("tr")[0]; 
        var cells      = currentRow.cells;
        var data_0     = cells[0].textContent;
        var data_1     = cells[1].textContent;
        var data_2     = cells[2].textContent;
        var data_3     = cells[3].textContent;
        var data_4     = cells[4].textContent;

        $('#modal_edit').modal('show');
        $('#edit_kode_pelanggan').val(data_0);
        $('#edit_nama_pelanggan').val(data_1);
        $('#edit_alamat').val(data_2);
        $('#edit_no_telepon').val(data_3);
        $('#edit_email').val(data_4);
        //menampilkan data ke input text
      }); 
      /*end edit*/ 

      /*begin delete*/
      $(document).on('click', '#delete', function(event){
        event.preventDefault(); 
        var currentRow     = $(this).closest("tr")[0]; 
        var cells          = currentRow.cells;
        var kode_pelanggan = cells[0].textContent;
        var desc           = cells[1].textContent;
        bootbox.confirm("Hapus pelanggan: "+ " "+desc+" ?",function(confirmed){
        if (confirmed) {
          //alert('delete process');
           $.ajax({
            url: "<?php echo base_url() . 'Master_pelanggan/delete_pelanggan'?>",
            type: 'POST',
            method:"POST",
            data:{kode_pelanggan:kode_pelanggan},  
          })
          .done(function(data){
           $("#datatable").DataTable().ajax.reload();
          })
        }
      });
        return false;
      }); 
      /*end delete*/ 
</script>

<!-- event modal tambah dan edit tampil -->
<script type="text/javascript">
  $(document).on('shown.bs.modal','#modal_tambah', function (){
    $("#pesan").hide();
    //format hanya angka
    $('#add_pelanggan')[0].reset();
    $('#nama_pelanggan').focus();
  }); 
  $(document).on('shown.bs.modal','#modal_edit', function (){
    $("#edit_pesan").hide();
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

<!-- insert kategori -->
<script type="text/javascript">
$(document).on('submit', '#add_pelanggan', function(event){
  event.preventDefault();
  var nama_pelanggan = $('#nama_pelanggan').val();
  var alamat        = $('#alamat').val();
  var no_telepon    = $('#no_telepon').val();
  var email         = $('#email').val();
    bootbox.confirm("Konfirmasi ?",function(confirmed){
    if (confirmed) {
      $.ajax({
      type : "POST",
      url:"<?php echo base_url() . 'Master_pelanggan/insert_pelanggan'?>",
      data : 
      {
        nama_pelanggan:nama_pelanggan,alamat:alamat,no_telepon:no_telepon,email:email
      },
      success: function(data){
          //menampilkan dan merubah class pesan
        $("#pesan").show();
        $("#msg").html('Pelanggan berhasil ditambahkan!');
        $('#pesan').removeClass('alert alert-danger alert-dismissible').addClass('alert alert-success alert-dismissible');
          //menampilkan dan merubah class pesan
        $("#datatable").DataTable().ajax.reload();
        $('#add_pelanggan')[0].reset(); 
        $('#nama_pelanggan').focus();
      }
    });
    }
  });
});
</script>

<!-- edit pelanggan -->
<script type="text/javascript">
$(document).on('submit', '#edit_pelanggan', function(event){
  event.preventDefault();
  var id             = $('#edit_kode_pelanggan').val();
  var nama_pelanggan = $('#edit_nama_pelanggan').val();
  var alamat         = $('#edit_alamat').val();
  var no_telepon     = $('#edit_no_telepon').val();
  var email          = $('#edit_email').val();

    bootbox.confirm("Konfirmasi ?",function(confirmed){
    if (confirmed) {
      $.ajax({
      type : "POST",
      url:"<?php echo base_url() . 'Master_pelanggan/update_pelanggan'?>",
      data : 
      {
        id:id,
        nama_pelanggan:nama_pelanggan,
        alamat:alamat,
        no_telepon:no_telepon,
        email:email
      },
      success: function(data){
        //menampilkan dan merubah class pesan
        $("#edit_pesan").show();
        $("#edit_msg").html('Edit pelanggan berhasil!');
        $('#edit_pesan').removeClass('alert alert-danger alert-dismissible').addClass('alert alert-warning alert-dismissible');
        //menampilkan dan merubah class pesan
        $("#datatable").DataTable().ajax.reload();
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

<!-- add modal pelanggan -->
<div class="modal fade modal-danger" id="modal_tambah">
  <form class="form-horizontal" id="add_pelanggan">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Form Tambah Pelanggan</h4>
        </div>
        <div class="modal-body" style="background-color: white!important;">

          <input type="hidden" id="edit_id_kategori" name="edit_id_kategori" required="" class="form-control">

          <div class="form-group">
            <label for="inputPassword3" class="col-md-3 control-label text-black">NAMA_PELANGGAN</label>
            <div class="col-md-9">
              <input type="text" id="nama_pelanggan" name="nama_pelanggan" required="" class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label for="inputPassword3" class="col-md-3 control-label text-black">ALAMAT</label>
            <div class="col-md-9">
              <input type="text" id="alamat" name="alamat" required="" class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label for="inputPassword3" class="col-md-3 control-label text-black">NO_TELEPON</label>
            <div class="col-md-9">
              <input type="text" id="no_telepon" name="no_telepon" required="" class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label for="inputPassword3" class="col-md-3 control-label text-black">EMAIL</label>
            <div class="col-md-9">
              <input type="email" id="email" name="email" class="form-control">
            </div>
          </div>

          <div class="alert alert-primary alert-dismissible" id="pesan">
              <i class="icon fa fa-check"></i> <span id="msg">Edit barang berhasil!</span>
          </div>      
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
          <button type="submit" id="update" class="btn btn-outline">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
  </form>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- edit modal pelanggan -->
<div class="modal fade modal-info" id="modal_edit">
  <form class="form-horizontal" id="edit_pelanggan">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Form Update Pelanggan</h4>
        </div>
        <div class="modal-body" style="background-color: white!important;">

          <input type="hidden" id="edit_kode_pelanggan" name="edit_kode_pelanggan" required="" class="form-control">

          <div class="form-group">
            <label for="inputPassword3" class="col-md-3 control-label text-black">NAMA_PELANGGAN</label>
            <div class="col-md-9">
              <input type="text" id="edit_nama_pelanggan" name="edit_nama_pelanggan" required="" class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label for="inputPassword3" class="col-md-3 control-label text-black">ALAMAT</label>
            <div class="col-md-9">
              <input type="text" id="edit_alamat" name="edit_alamat" required="" class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label for="inputPassword3" class="col-md-3 control-label text-black">NO_TELEPON</label>
            <div class="col-md-9">
              <input type="number" id="edit_no_telepon" name="edit_no_telepon" required="" class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label for="inputPassword3" class="col-md-3 control-label text-black">EMAIL</label>
            <div class="col-md-9">
              <input type="email" id="edit_email" name="edit_email" class="form-control">
            </div>
          </div>

          <div class="alert alert-primary alert-dismissible" id="edit_pesan">
              <i class="icon fa fa-check"></i> <span id="edit_msg">Edit barang berhasil!</span>
          </div>      
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
          <button type="submit" id="update" class="btn btn-outline">Save changes</button>
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
    margin-top: -46px;
    /*display: inline;*/
}
</style>


