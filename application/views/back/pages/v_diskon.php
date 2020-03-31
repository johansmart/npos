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
              <h3 class="box-title">Diskon Barang</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- /.box -->
            <div class="box" style="margin-top: -12px">
            </div>
          <!-- /.box -->
              <table id="datatable" class="table table-bordered table-condensed table-striped">
                <thead>
                  <tr class="">
                    <th>ID</th>
                    <th>KODE_BARANG</th>        
                    <th>NAMA_BARANG</th>
                    <th>HARGA</th>
                    <th>PERSEN</th>
                    <th>DISKON</th>
                    <th>MULAI</th>
                    <th>SELESAI</th>
                    <th>HARGA_DISKON</th>
                    <th>REGISTER</th>
                    <th>FLAG_STAT</th>
                    <th>STATUS</th>
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
                    <span class="glyphicon glyphicon-plus"></span> TAMBAH DISKON
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
          url :"<?php echo base_url() . 'Diskon/fetch_diskon'; ?>", // json datasource
          type: "post",
            // method  , by default get
        }
      });
     });
</script>

<script type="text/javascript">
  //update on status diskon
  $(document).on('click', '#on', function(event){
    var currentRow = $(this).closest("tr")[0]; 
    var cells      = currentRow.cells;
    var id         = cells[0].textContent;
    var flag_stat  = cells[10].textContent;
    if (flag_stat==1) {
      return false;
    }
    var on_status = $('input[name=on_status]:checked').val();
    bootbox.confirm("Aktifkan diskon ?",function(confirmed){
    if (confirmed) {
      $.ajax({
        type : "POST",
        url:"<?php echo base_url() . 'Diskon/update_status_on'?>",
        data : 
        {
          id:id,
          on_status:on_status
        },
        success: function(data){
          $("#datatable").DataTable().ajax.reload();
        }
      });
    }
    });
    $(document).on("hidden.bs.modal", ".bootbox.modal", function (e) {
        $("#datatable").DataTable().ajax.reload();
    });  
  });
  //update off status diskon
  $(document).on('click', '#off', function(event){
    var currentRow = $(this).closest("tr")[0]; 
    var cells      = currentRow.cells;
    var id         = cells[0].textContent;
    var flag_stat  = cells[10].textContent;
    if (flag_stat==0) {
      return false;
    }
    var off_status = $('input[name=off_status]').val();
    bootbox.confirm("Nonaktifkan diskon ?",function(confirmed){
    if (confirmed) {
      $.ajax({
        type : "POST",
        url:"<?php echo base_url() . 'Diskon/update_status_off'?>",
        data : 
        {
          id:id,
          off_status:off_status
        },
        success: function(data){
          $("#datatable").DataTable().ajax.reload();
        }
      });
    }
    });
    $(document).on("hidden.bs.modal", ".bootbox.modal", function (e) {
      $("#datatable").DataTable().ajax.reload();
    });   
  });
</script>

<!-- mengambil item info hasil dariajax -->
<script type="text/javascript">
  $(document).on('change', '#kode_barang', function(event){
   var kode_barang = $('#kode_barang').val(); 
   event.preventDefault();
      $.ajax({
      url: "<?php echo base_url() . 'Diskon/get_item_info'?>",
      type : "POST",
      data:{kode_barang:kode_barang},
      dataType : "JSON",
      success: function(data){
        $('#nama_barang').val(data[0])
        $('#harga_brg').val(data[3])
      }
    })
  })
  //kalkulasi diskon
  $(document).on('keyup', '#persen', function () {
    var persen         = $('#persen').val();
    var unit_price     = $("#harga_brg").val(); 
    var nilai_diskon   = $('#nilai_diskon').val();  
    var hasil          = persen * unit_price/100;
    var after_diskon   = unit_price - hasil ;
    $('#nilai_diskon').val(hasil);
    $('#harga_diskon').val(after_diskon);
  }); 
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
    $('#add_diskon')[0].reset();
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
$(document).on('submit', '#add_diskon', function(event){
  event.preventDefault();
  var kode_barang  = $('#kode_barang').val();
  var nama_barang  = $('#nama_barang').val();
  var harga_brg   = $("#harga_brg").val();
  var persen       = $("#persen").val();
  var nilai_diskon = $("#nilai_diskon").val();
  var harga_diskon = $("#harga_diskon").val();
  var start_date   = $("#start_date").val();
  var end_date     = $("#end_date").val();
  if (nilai_diskon==0)
  {
    bootbox.alert('Gagal mengirim data')
    return false;
  }
  else
  {
    bootbox.confirm("Konfirmasi ?",function(confirmed){
      if (confirmed) {
        $.ajax({
        type : "POST",
        url:"<?php echo base_url() . 'Diskon/insert_diskon'?>",
        data : 
        {
          kode_barang:kode_barang,
          nama_barang:nama_barang,
          harga_brg:harga_brg,
          persen:persen,
          nilai_diskon:nilai_diskon,
          harga_diskon:harga_diskon,
          start_date:start_date,
          end_date:end_date
        },
        success: function(data){
          //menampilkan dan merubah class pesan
          $("#pesan").show();
          $("#msg").html('Diskon berhasil ditambahkan!');
          $('#pesan').removeClass('alert alert-danger alert-dismissible').addClass('alert alert-success alert-dismissible');
          //menampilkan dan merubah class pesan
          $("#datatable").DataTable().ajax.reload();
          $('#add_diskon')[0].reset(); 
        }
      });
      }
    });
  }
});
</script>

<!-- event keyup menyembunyikan pesan -->
<script type="text/javascript">
  $(document).on('keyup', '#nama_supplier', function(){
    $('#pesan').hide();
  });
</script>

<!-- tambah modal -->
<div class="modal fade modal-danger" id="modal_tambah">
  <form class="form-horizontal" id="add_diskon">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Form Tambah Diskon</h4>
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
            <label for="inputPassword3" class="col-md-2 control-label text-black">PERSEN</label>
            <div class="col-md-2">
              <input type="text" id="persen" name="persen" required="" maxlength="2" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">NILAI_DISKON</label>
            <div class="col-md-10 col-sm-2">
              <input type="text" class="form-control input-sm" name="nilai_diskon" id="nilai_diskon" readonly="">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">HARGA_DISKON</label>
            <div class="col-md-10 col-sm-2">
              <input type="text" class="form-control input-sm" name="harga_diskon" id="harga_diskon" readonly="">
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



