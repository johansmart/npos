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
              <h3 class="box-title">Master Supplier</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- /.box -->
            <div class="box" style="margin-top: -12px">
            </div>
          <!-- /.box -->
              <table id="datatable" class="table table-bordered table-striped table-condensed">
                <thead>
                  <tr class="">
                    <th>ID</th>
                    <th>KODE_SUPPLIER</th>        
                    <th>NAMA_SUPPLIER</th>
                    <th>NAMA_KONTAK</th>
                    <th>NO_TELP_SUPPLIER</th>
                    <th>ALAMAT</th>
                    <th width="50">OPSI</th>
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
                    <span class="glyphicon glyphicon-plus"></span> TAMBAH SUPPLIER
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
      processing: true,
           "language": {
          processing: '<div style="margin-top:-4px"><img src="images/index.gif" alt="" class=""><span> &nbsp;&nbsp;Loading... </span></div>'},
        "serverSide" : true,

        "ajax":{
          url :"<?php echo base_url() . 'Master_supplier/fetch_master_supplier'; ?>", // json datasource
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
        var data_2     = cells[2].textContent;
        var data_3     = cells[3].textContent;
        var data_4     = cells[4].textContent;
        var data_5     = cells[5].textContent;

        $('#modal_edit').modal('show');
        $('#edit_id_supp').val(data_0);
        $('#edit_nama_supplier').val(data_2);
        $('#edit_nama_kontak').val(data_3);
        $('#edit_telp_supp').val(data_4);
        $('#edit_alamat_supp').val(data_5);
        //menampilkan data ke input text
      }); 
      /*end edit*/ 

      /*begin delete*/
      $(document).on('click', '#delete', function(event){
        event.preventDefault(); 
        var currentRow  = $(this).closest("tr")[0]; 
        var cells       = currentRow.cells;
        var kode_supp   = cells[1].textContent;
        var desc        = cells[2].textContent;
        bootbox.confirm("Hapus supplier: "+ " "+desc+" ?",function(confirmed){
        if (confirmed) {
          //alert('delete process');
           $.ajax({
            url: "<?php echo base_url() . 'Master_supplier/delete_supplier'?>",
            type: 'POST',
            method:"POST",
            data:{kode_supp:kode_supp},  
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
    //number only
    $("#telp_supp").keypress(function (e){
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    });
    $("#pesan").hide();
    //format hanya angka
    $('#add_supplier')[0].reset();
    $('#nama_supplier').focus();
  }); 
  $(document).on('shown.bs.modal','#modal_edit', function (){
    //number only
    $("#edit_telp_supp").keypress(function (e){
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    });
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

<!-- insert supplier -->
<script type="text/javascript">
$(document).on('submit', '#add_supplier', function(event){
  event.preventDefault();
  var nama_supplier = $('#nama_supplier').val();
  var nama_kontak   = $('#nama_kontak').val();
  var telp_supp     = $("#telp_supp").val();
  var alamat_supp   = $("#alamat_supp").val();


    bootbox.confirm("Konfirmasi ?",function(confirmed){
    if (confirmed) {
      $.ajax({
      type : "POST",
      url:"<?php echo base_url() . 'Master_supplier/insert_supplier'?>",
      data : 
      {
        nama_supplier:nama_supplier,
        nama_kontak:nama_kontak,
        telp_supp:telp_supp,
        alamat_supp:alamat_supp
      },
      success: function(data){
        if (data>0) 
        {
          //menampilkan dan merubah class pesan
          $("#pesan").show();
          $("#msg").html('Supplier sudah terdaftar!');
          $('#pesan').removeClass('alert alert-success alert-dismissible').addClass('alert alert-danger alert-dismissible');
          //menampilkan dan merubah class pesan
          return false;
        }
        else
        {
          //menampilkan dan merubah class pesan
          $("#pesan").show();
          $("#msg").html('Supplier berhasil ditambahkan!');
          $('#pesan').removeClass('alert alert-danger alert-dismissible').addClass('alert alert-success alert-dismissible');
          //menampilkan dan merubah class pesan
          $("#datatable").DataTable().ajax.reload();
          $('#add_supplier')[0].reset(); 
        }
      }
    });
    }
  });
});
</script>

<!-- edit supplier -->
<script type="text/javascript">
$(document).on('submit', '#edit_supplier', function(event){
  event.preventDefault();
  var id            = $('#edit_id_supp').val();
  var nama_supplier = $('#edit_nama_supplier').val();
  var nama_kontak   = $('#edit_nama_kontak').val();
  var telp_supp     = $('#edit_telp_supp').val();
  var alamat_supp   = $('#edit_alamat_supp').val();

    bootbox.confirm("Konfirmasi ?",function(confirmed){
    if (confirmed) {
      $.ajax({
      type : "POST",
      url:"<?php echo base_url() . 'Master_supplier/update_supplier'?>",
      data : 
      {
        id:id,
        nama_supplier:nama_supplier,
        nama_kontak:nama_kontak,
        telp_supp:telp_supp,
        alamat_supp:alamat_supp
      },
      success: function(data){
        if (data>0) 
        {
          //menampilkan dan merubah class pesan
          $("#edit_pesan").show();
          $("#edit_msg").html('Supplier sudah terdaftar!');
          $('#edit_pesan').removeClass('alert alert-warning alert-dismissible').addClass('alert alert-danger alert-dismissible');
          //menampilkan dan merubah class pesan
          return false;
        }
        else
        {
          //menampilkan dan merubah class pesan
          $("#edit_pesan").show();
          $("#edit_msg").html('Edit supplier berhasil!');
          $('#edit_pesan').removeClass('alert alert-danger alert-dismissible').addClass('alert alert-warning alert-dismissible');
          //menampilkan dan merubah class pesan
          $("#datatable").DataTable().ajax.reload();
          $('#add_barang')[0].reset();
          $("#select_satuan").html('');
          $("#select_kategori").html('');
          $("#select_supplier").html('');
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
  $(document).on('keyup', '#nama_supplier', function(){
    $('#pesan').hide();
  });
</script>

<!-- number only -->
<script type="text/javascript">
  $("#edit_kode_barang,#edit_harga_beli").keypress(function (e){
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
  });
</script>

<!-- tambah modal -->
<div class="modal fade modal-danger" id="modal_tambah">
  <form class="form-horizontal" id="add_supplier">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Form Tambah Supplier</h4>
        </div>
        <div class="modal-body" style="background-color: white!important;">
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">NAMA_SUPPLIER</label>
            <div class="col-md-10">
              <input type="text" id="nama_supplier" name="nama_supplier" required="" class="form-control">
            </div>
          </div>
          
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">NAMA_KONTAK</label>
            <div class="col-md-10">
              <input type="text" id="nama_kontak" name="nama_kontak" required="" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">TELP_SUPPIER</label>
            <div class="col-md-10">
              <input type="text" id="telp_supp" name="telp_supp" required="" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">ALAMAT</label>
            <div class="col-md-10">
              <input type="text" id="alamat_supp" name="alamat_supp" required="" class="form-control">
            </div>
          </div>
          <div class="alert alert-success alert-dismissible" id="pesan">
              <i class="icon fa fa-check"></i> <span id="msg">Barang berhasil ditambahkan!</span>
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

<!-- edit modal -->
<div class="modal fade modal-info" id="modal_edit">
  <form class="form-horizontal" id="edit_supplier">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Form Edit Supplier</h4>
        </div>
        <div class="modal-body" style="background-color: white!important;">

          <input type="hidden" id="edit_id_supp" name="edit_id_supp" required="" class="form-control">

          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">NAMA_SUPPLIER</label>
            <div class="col-md-10">
              <input type="text" id="edit_nama_supplier" name="edit_nama_supplier" required="" class="form-control">
            </div>
          </div>
          
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">NAMA_KONTAK</label>
            <div class="col-md-10">
              <input type="text" id="edit_nama_kontak" name="edit_nama_kontak" required="" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">TELP_SUPPIER</label>
            <div class="col-md-10">
              <input type="text" id="edit_telp_supp" name="edit_telp_supp" required="" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">ALAMAT</label>
            <div class="col-md-10">
              <input type="text" id="edit_alamat_supp" name="edit_alamat_supp" required="" class="form-control">
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
    margin-top: -42px;
    /*display: inline;*/
}
</style>


