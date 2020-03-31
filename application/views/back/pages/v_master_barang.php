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
              <h3 class="box-title">Master Barang</h3>
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
                    <th>KODE_BARANG</th>        
                    <th>NAMA_BARANG</th>
                    <th>SATUAN</th>
                    <th>KODE_KTG</th>
                    <th>NAMA_KTG</th>
                    <th>HRG_BELI</th>
                    <th>HRG_JUAL</th>
                    <th>HRG_GROSIR</th>
                    <th>KODE_SUPP</th>
                    <th>NAMA_SUPP</th>
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
                    <span class="glyphicon glyphicon-plus"></span> TAMBAH BARANG
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
    $("#edit_pesan").hide();
    /*begin datatable*/
    $('#datatable').DataTable( {
      "autoWidth": false,
      "mark": true, 
      "scrollY"     : "400px",
      'lengthChange': true,
      "lengthMenu": [[1000, 2000, 3000, -1], [1000, 2000, 3000, "All"]],
      'paging'      : true,
      'searching'   : true,
      'info'        : true,
      "ordering": true,
      dom: 'Blfrtip',
      buttons: [
      'copy', 'csv',
        {
          extend: 'excelHtml5',
          filename: 'Master_barang_'+'<?php echo date('dmY');?>'
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
          url :"<?php echo base_url() . 'Master_barang/fetch_master_barang'; ?>", // json datasource
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
        var data_4     = cells[5].textContent;
        var data_5     = cells[10].textContent;
        var data_6     = cells[6].textContent;
        var data_7     = cells[7].textContent;
        var data_8     = cells[8].textContent;
        $('#modal_edit').modal('show');
        $('#edit_id').val(data_0);
        $('#edit_kode_barang').val(data_1);
        $('#edit_nama_barang').val(data_2);
        $("#edit_select_satuan option:selected").html(data_3);
        $("#edit_select_kategori option:selected").html(data_4);
        $("#edit_select_supplier option:selected").html(data_5);
        $('#edit_harga_beli').val(data_6);
        $('#edit_harga_jual').val(data_7);
        $('#edit_harga_grosir').val(data_8);
        //menampilkan data ke input text
      }); 
      /*end edit*/ 

      /*begin delete*/
      $(document).on('click', '#delete', function(event){
        event.preventDefault(); 
        var currentRow  = $(this).closest("tr")[0]; 
        var cells       = currentRow.cells;
        var kode_barang = cells[1].textContent;
        var desc        = cells[2].textContent;
        bootbox.confirm("Hapus barang: "+ " "+desc+" ?",function(confirmed){
        if (confirmed) {
          //alert('delete process');
           $.ajax({
            url: "<?php echo base_url() . 'Master_barang/delete_product'?>",
            type: 'POST',
            method:"POST",
            data:{kode_barang:kode_barang},  
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

<!-- event modal tambah barang tampil -->
<script type="text/javascript">
  $(document).on('shown.bs.modal','#modal_tambah', function (){
    $("#pesan").hide();
    //format hanya angka
    $("#kode_barang,#harga_beli,#harga_jual,#harga_grosir").keypress(function (e){
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    });
    //format hanya angka
    $('#add_barang')[0].reset();
    $("#select_satuan").html('');
    $("#select_kategori").html('');
    $("#select_supplier").html('');
    $("#kode_barang").focus();
    $('#select_satuan').select2({
      placeholder: '--- Satuan ---',
      ajax: {
        url: 'Master_barang/select_satuan',
        dataType: 'json',
        delay: 250,
        type : "POST",
        data: function (params) {
          var queryParameters = {
            q: params.term
          }
          return queryParameters;
        },
        processResults: function (data) {
          return {
            results: data,
          };
        },
        cache: true
      }
    });
    //select kategori
    $('#select_kategori').select2({
      placeholder: '--- kategori ---',
      ajax: {
        url: 'Master_barang/select_kategori',
        dataType: 'json',
        delay: 250,
        type : "POST",
        data: function (params) {
          var queryParameters = {
            q: params.term
          }
          return queryParameters;
        },
        processResults: function (data) {
          return {
            results: data,
          };
        },
        cache: true
      }
    });
    //select supplier
    $('#select_supplier').select2({
      placeholder: '--- supplier ---',
      ajax: {
        url: 'Master_barang/select_supplier',
        dataType: 'json',
        delay: 250,
        type : "POST",
        data: function (params) {
          var queryParameters = {
            q: params.term
          }
          return queryParameters;
        },
        processResults: function (data) {
          return {
            results: data,
          };
        },
        cache: true
      }
    });
  }); 
</script>

<!-- event modal edit barang tampil -->
<script type="text/javascript">
  $(document).on('shown.bs.modal','#modal_edit', function (){
    $("#edit_pesan").hide();
    //format hanya angka
    $("#edit_kode_barang,#edit_harga_beli,#edit_harga_jual,#edit_harga_grosir").keypress(function (e){
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    });
    //format hanya angka
    $('#edit_select_satuan').select2({
      placeholder: '--- Satuan ---',
      ajax: {
        url: 'Master_barang/select_satuan',
        dataType: 'json',
        delay: 250,
        type : "POST",
        data: function (params) {
          var queryParameters = {
            q: params.term
          }
          return queryParameters;
        },
        processResults: function (data) {
          return {
            results: data,
          };
        },
        cache: true
      }
    });
    //select kategori
    $('#edit_select_kategori').select2({
      placeholder: '--- kategori ---',
      ajax: {
        url: 'Master_barang/select_kategori',
        dataType: 'json',
        delay: 250,
        type : "POST",
        data: function (params) {
          var queryParameters = {
            q: params.term
          }
          return queryParameters;
        },
        processResults: function (data) {
          return {
            results: data,
          };
        },
        cache: true
      }
    });
    //select supplier
    $('#edit_select_supplier').select2({
      placeholder: '--- supplier ---',
      ajax: {
        url: 'Master_barang/select_supplier',
        dataType: 'json',
        delay: 250,
        type : "POST",
        data: function (params) {
          var queryParameters = {
            q: params.term
          }
          return queryParameters;
        },
        processResults: function (data) {
          return {
            results: data,
          };
        },
        cache: true
      }
    });
  }); 
</script>

<script type="text/javascript">
  $(document).ready(function (){
    $('#tambah').click(function(){
      $('#modal_tambah').modal('show');
    })   
  })  
</script>

<!-- insert barng -->
<script type="text/javascript">
$(document).on('submit', '#add_barang', function(event){
  event.preventDefault();
  var kode_barang   = $('#kode_barang').val();
  var nama_barang   = $('#nama_barang').val();
  var satuan        = $("#select_satuan option:selected").text();
  var kategori      = $("#select_kategori option:selected").text();
  var supplier      = $("#select_supplier option:selected").text();
  var harga_beli    = $('#harga_beli').val();
  var harga_jual    = $('#harga_jual').val();
  var harga_grosir  = $('#harga_grosir').val();
  if (satuan=='') 
  {
    $('#select_satuan').select2('open');
    return false;
  }
  else if (kategori=='') 
  {
    $('#select_kategori').select2('open');
    return false;
  }
  else if (supplier=='') 
  {
    $('#select_supplier').select2('open');
    return false;
  }
  else
  {
    bootbox.confirm("Konfirmasi ?",function(confirmed){
    if (confirmed) {
      $.ajax({
      type : "POST",
      url:"<?php echo base_url() . 'Master_barang/insert_barang'?>",
      data : 
      {
        kode_barang:kode_barang,
        nama_barang:nama_barang,
        satuan:satuan,
        kategori:kategori,
        supplier:supplier,
        harga_beli:harga_beli,
        harga_jual:harga_jual,
        harga_grosir:harga_grosir
      },
      success: function(data){
        if (data>0) 
        {
          //menampilkan dan merubah class pesan
          $("#pesan").show();
          $("#msg").html('Barang sudah terdaftar!');
          $('#pesan').removeClass('alert alert-success alert-dismissible').addClass('alert alert-danger alert-dismissible');
          //menampilkan dan merubah class pesan
          return false;
        }
        else
        {
          //menampilkan dan merubah class pesan
          $("#pesan").show();
          $("#msg").html('Barang berhasil ditambahkan!');
          $('#pesan').removeClass('alert alert-danger alert-dismissible').addClass('alert alert-success alert-dismissible');
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
  }
});
</script>

<!-- edit barang -->
<script type="text/javascript">
$(document).on('submit', '#edit_barang', function(event){
  event.preventDefault();
  var id            = $('#edit_id').val();
  var kode_barang   = $('#edit_kode_barang').val();
  var nama_barang   = $('#edit_nama_barang').val();
  var satuan        = $("#edit_select_satuan option:selected").text();
  var kategori      = $("#edit_select_kategori option:selected").text();
  var supplier      = $("#edit_select_supplier option:selected").text();
  var harga_beli    = $('#edit_harga_beli').val();
  var harga_jual    = $('#edit_harga_jual').val();
  var harga_grosir  = $('#edit_harga_grosir').val();
  if (satuan=='') 
  {
    $('#edit_select_satuan').select2('open');
    return false;
  }
  else if (kategori=='') 
  {
    $('#edit_select_kategori').select2('open');
    return false;
  }
  else if (supplier=='') 
  {
    $('#edit_select_supplier').select2('open');
    return false;
  }
  else
  {
    bootbox.confirm("Konfirmasi ?",function(confirmed){
    if (confirmed) {
      $.ajax({
      type : "POST",
      url:"<?php echo base_url() . 'Master_barang/update_product'?>",
      data : 
      {
        id:id,
        kode_barang:kode_barang,
        nama_barang:nama_barang,
        satuan:satuan,
        kategori:kategori,
        supplier:supplier,
        harga_beli:harga_beli,
        harga_jual:harga_jual,
        harga_grosir:harga_grosir
      },
      success: function(data){
        if (data>0) 
        {
          //menampilkan dan merubah class pesan
          $("#edit_pesan").show();
          $("#edit_msg").html('Kode barang sudah terdaftar!');
          $('#edit_pesan').removeClass('alert alert-warning alert-dismissible').addClass('alert alert-danger alert-dismissible');
          //menampilkan dan merubah class pesan
          return false;
        }
        else
        {
          //menampilkan dan merubah class pesan
          $("#edit_pesan").show();
          $("#edit_msg").html('Edit barang berhasil!');
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
  }
});
</script>

<!-- auto generate kode barang -->
<script>
  //tambah barang
  $(document).on('click', '#auto_kode', function(e){
    e.preventDefault();
    $.ajax({
      type : "GET",
      url:"<?php echo base_url() . 'Master_barang/auto_barcode'?>",
      success: function(data){
        $('#kode_barang').val(data);
      }
    });
  });
  //edit barang
  $(document).on('click', '#edit_auto_kode', function(e){
    e.preventDefault();
    $.ajax({
      type : "GET",
      url:"<?php echo base_url() . 'Master_barang/auto_barcode'?>",
      success: function(data){
        $('#edit_kode_barang').val(data);
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
  <form class="form-horizontal" id="add_barang">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Form Tambah Barang</h4>
        </div>
        <div class="modal-body" style="background-color: white!important;">
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">KODE_BARANG</label>
            <div class="col-md-7">
              <input type="text" id="kode_barang" name="kode_barang" required="" class="form-control">
            </div>
            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-3"><a href="#" id="auto_kode"><i class="fa fa-cogs text-black"> </i>&nbsp; AUTO KODE</a></label>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">NAMA_BARANG</label>
            <div class="col-md-10">
              <input type="text" id="nama_barang" name="nama_barang" required="" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">SATUAN</label>
            <div class="col-md-10">
              <select name="select_satuan" class="form-control select2" id="select_satuan" style="width: 100%;">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">KATEGORI</label>
            <div class="col-md-10">
              <select name="select_kategori" class="form-control select2" id="select_kategori" style="width: 100%;">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">SUPPLIER</label>
            <div class="col-md-10">
              <select name="select_supplier" class="form-control select2" id="select_supplier" style="width: 100%;">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">HARGA_BELI</label>
            <div class="col-md-10">
              <input type="text" id="harga_beli" name="harga_beli" required="" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">HARGA_JUAL</label>
            <div class="col-md-10">
              <input type="text" id="harga_jual" name="harga_jual" required="" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">HARGA_GROSIR</label>
            <div class="col-md-10">
              <input type="text" id="harga_grosir" name="harga_grosir" required="" class="form-control">
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
  <form class="form-horizontal" id="edit_barang">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Form Edit Barang</h4>
        </div>
        <div class="modal-body" style="background-color: white!important;">

          <input type="hidden" id="edit_id" name="edit_id" required="" class="form-control">

          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">KODE_BARANG</label>
            <div class="col-md-7">
              <input type="text" id="edit_kode_barang" name="edit_kode_barang" required="" class="form-control">
            </div>
            <label for="middle-name" class="control-label col-md-3 col-sm-4 col-xs-4"><a href="#" id="edit_auto_kode"><i class="fa fa-cogs text-black"> </i>&nbsp; AUTO KODE</a></label>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">NAMA_BARANG</label>
            <div class="col-md-10">
              <input type="text" id="edit_nama_barang" name="edit_nama_barang" required="" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">SATUAN</label>
            <div class="col-md-10">
              <select name="edit_select_satuan" class="form-control select2" id="edit_select_satuan" style="width: 100%;">
                <option selected="selected"></option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">KATEGORI</label>
            <div class="col-md-10">
              <select name="edit_select_kategori" class="form-control select2" id="edit_select_kategori" style="width: 100%;">
                <option selected="selected"></option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">SUPPLIER</label>
            <div class="col-md-10">
              <select name="edit_select_supplier" class="form-control select2" id="edit_select_supplier" style="width: 100%;">
                <option selected="selected"></option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">HARGA_BELI</label>
            <div class="col-md-10">
              <input type="text" id="edit_harga_beli" name="edit_harga_beli" required="" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">HARGA_JUAL</label>
            <div class="col-md-10">
              <input type="text" id="edit_harga_jual" name="edit_harga_jual" required="" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">HARGA_GROSIR</label>
            <div class="col-md-10">
              <input type="text" id="edit_harga_grosir" name="edit_harga_grosir" required="" class="form-control">
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
}
*/
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


