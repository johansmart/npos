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
              <h3 class="box-title">Tag Print</h3>
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
                    <th>TANGGAL</th>
                    <th>JAM</th>
                    <th>USER_ID</th>
                    <th>USER_NAME</th>        
                    <th>KODE_BARANG</th>
                    <th>NAMA_BARANG</th>
                    <th>HARGA_JUAL</th>
                    <th>KATEGORI</th>
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
            <button type="button" name="manual_print" id="manual_print" class="btn bg-blue btn-sm">
              <span class="fa fa-pencil"></span> Manual
            </button>
            <button type="button" name="cat_print" id="cat_print" class="btn bg-blue btn-sm">
              <span class="fa fa-reorder "></span> By Category
            </button>
            <button type="button" name="all_print" id="all_print" class="btn bg-blue btn-sm">
              <span class="fa fa-database "></span> All Product
            </button>
            <button type="button" name="reset" id="reset" class="btn bg-maroon btn-sm">
              <span class="fa fa-remove "></span> Reset
            </button>
            <a href="<?php  echo base_url('print_label/prev'); ?>" id="print" class="btn bg-gray btn-sm">
              <span class="fa fa-print"></span> Print
            </a>
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

<!-- datatable tag print -->
<script type="text/javascript">
  $(document).ready(function(){
    $("#pesan").hide();
    $("#edit_pesan").hide();
    /*begin datatable*/
    $('#datatable').DataTable( {
      "autoWidth": false,
      "mark": true, 
      "scrollY"     : "350px",
      'lengthChange': true,
      "lengthMenu": [[100, 200, 300, -1], [100, 200, 300, "All"]],
      'paging'      : true,
      'searching'   : false,
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
          url :"<?php echo base_url() . 'Tag_print/fetch_print'; ?>", // json datasource
          type: "post",
            // method  , by default get
        }
      });
     });
</script>


<!-- event load select 2 modal category print-->
<script type="text/javascript">
  $(document).on('shown.bs.modal','#modal_cat_print', function (){
    //select kategori
    $('#select_kategori').select2({
      placeholder: '--- kategori ---',
      ajax: {
        url: 'Tag_print/select_kategori',
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

<!-- menampilkan modal -->
<script type="text/javascript">
  $(document).ready(function (){
    $('#cat_print').click(function(){
      $('#modal_cat_print').modal('show');
    })    
  })  
</script>

<!-- event klik cari barang / insert maual print-->
<script type="text/javascript">
  $(document).ready(function (){
    $('#manual_print').click(function(){
      $('#mdl_cari_barang').modal('show');
    });
    $('#mdl_cari_barang').on('shown.bs.modal', function(e) {
    $('#datatable2').DataTable( {
      "autoWidth": false,
      "ordering": true,
      "mark": true, 
      "scrollY"     : "400px",
      'lengthChange': true,
      "lengthMenu": [[30, 100, 200, -1], [50, 100, 200, "All"]],
      'paging'      : true,
      'searching'   : true,
      'info'        : false,
      //dom: 'Blfrtip',
      processing: true,
           "language": {
          processing: '<div style="margin-top:-4px"><img src="images/index.gif" alt="" class=""><span> &nbsp;&nbsp;Loading... </span></div>'},
        "serverSide" : true,

        "ajax":{
          url :"<?php echo base_url() . 'Tag_print/fetch_master_barang'; ?>", // json datasource
          type: "post",
            // method  , by default get
        },
        initComplete: function () {
          $('#datatable2_filter label input').focus();
        }
      });
    });
    $('#mdl_cari_barang').on('hide.bs.modal', function(e) {
      $('#datatable2').DataTable().clear().destroy();
    });
    //memindahkan kode barang search barang ke scan barcode
    $(document).on('click', '#barcode', function(event){  
        var currentRow    = $(this).closest("tr")[0]; 
        var cells         = currentRow.cells;
        var kode_barang   = cells[1].textContent;
        var kategori      = cells[4].textContent;
        $.ajax({
        type : "POST",
        url:"<?php echo base_url() . 'Tag_print/insert_manual_print'?>",
        data : 
        {
          kode_barang:kode_barang, kategori: kategori
        },
        success: function(data){
          $("#datatable").DataTable().ajax.reload();
        }
      });
    });
  })
</script>

<!-- insert kategori print -->
<script type="text/javascript">
  $(document).on('change', '#select_kategori', function(event){
    event.preventDefault();
    var start_date  = $("#start_date").val();
    var kategori    = $("#select_kategori option:selected").text();
    var cat         = kategori.substring(0,2);
    $("#kode_kategori").val(cat);
  });
  $(document).on('submit', '#add_cat_print', function(event){
  event.preventDefault();
  var post_cat = $("#kode_kategori").val();
  var kategori = $("#select_kategori option:selected").text();
  bootbox.confirm("Konfirmasi ?",function(confirmed){
    if (confirmed) {
    $('#modal_cat_print').modal('hide');  
    $.ajax({
      type : "POST",
      dataType:"json",
      url:"<?php echo base_url() . 'Tag_print/ins_cat_print'?>",
      data : 
      {
        post_cat:post_cat,kategori:kategori
      },
      beforeSend: function(){
        $('#loading_modal').modal('show');
      },
      complete: function(){
        //$('#loading_modal').modal('show');
      },
      success: function(data){
        $('#loading_modal').modal('hide');
        $("#datatable").DataTable().ajax.reload();
      }
    });
    }
  });
  });
</script>

<!-- insert all print -->
<script type="text/javascript">
  $(document).on('click', '#all_print', function(event){
    event.preventDefault();
    bootbox.confirm("Load all product ?",function(confirmed){
      if (confirmed) {
        $.ajax({
        url: "<?php echo base_url() . 'Tag_print/ins_all_print'?>",
        beforeSend: function(){
          $('#loading_modal').modal('show');
        },
        complete: function(){
          //$('#loading_modal').modal('show');
        },
        success: function(data){
          $('#loading_modal').modal('hide');
          $("#datatable").DataTable().ajax.reload();
        } 
        })
      }
    });       
  }); 
</script>

<!-- reset print -->
<script type="text/javascript">
  $(document).on('click', '#reset', function(event){
    event.preventDefault();
    bootbox.confirm("Reset print ?",function(confirmed){
      if (confirmed) {
        $.ajax({
        url: "<?php echo base_url() . 'Tag_print/reset_print'?>",
          success: function(data){
            $("#datatable").DataTable().ajax.reload();
          }
        })
      }
    });       
  }); 
</script>


<script type="text/javascript">
  $('#print').click(function (event) {
    event.preventDefault();
    window.open($(this).attr("href"), "popupWindow", "width=1000,height=600,scrollbars=yes");
});
</script>

<!-- modal cari barang-->
<div class="modal modal-danger fade" id="mdl_cari_barang" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Cari Produk</h4>
      </div>
      <div class="modal-body"  style="background-color: white!important;">
        <table id="datatable2" class="table table-bordered table-condensed" style="color: black">
          <thead>
            <tr class="bg-gray">
              <th>#</th> 
              <th>KODE_BARANG</th>        
              <th>NAMA_BARANG</th>
              <th>SATUAN</th>
              <th>KATEGORI</th>
              <th>HRG_BELI</th>
              <th>STOCK</th>
            </tr>
          </thead>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline btn pull-left" data-dismiss="modal">Cancel [esc]</button>
        <!-- <button type="submit" id="submit_grosir" class="btn btn-outline">Save [enter]</button> -->
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- category print modal -->
<div class="modal fade modal-danger" id="modal_cat_print" data-backdrop="static">
  <form class="form-horizontal" id="add_cat_print">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Category Print</h4>
        </div>
        <div class="modal-body" style="background-color: white!important;">
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label text-blue">Category</label>
            <div class="col-sm-10">
              <select name="select_kategori" class="form-control select2" id="select_kategori" style="width: 100%;">
                <option value=""></option>
              </select>
            </div>
          </div>
          <input type="hidden" id="kode_kategori" name="kode_kategori" readonly="" class="form-control bg-gray">
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

<!-- loading animation modal -->
<div class="modal fade modal-danger" id="loading_modal" data-backdrop="static">
    <div class="modal-dialog modal-sm" style="margin-top: 20%">
      <div class="box box-danger box-solid">
          <div class="box-header">
            <h3 class="box-title">Processing</h3>
          </div>
          <div class="box-body">
            Please wait....
          </div>
          <div class="overlay">
            <i class="fa fa-circle-o-notch fa-spin text-black"></i>
          </div>
        </div>
      <!-- /.modal-content -->
    </div>
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

div.dt-buttons {
    float: right;
    /*margin-right:550px;*/
    margin-top: -60px;
    /*display: inline;*/
}
div.dataTables_wrapper  div.dataTables_filter {
/*  width: 100%;*/
  margin-top: 0px;color: black
}
.btn-default.btn-on-2.active{
  background-color: #245884;color: white;
}
.btn-default.btn-off-2.active{
  background-color: #dd4b39;color: white;
}
</style>


