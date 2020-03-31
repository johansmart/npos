<?php $this->load->view('back/meta') ?>
<?php $this->load->view('back/head') ?>
<?php $this->load->view('back/sidebar') ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List Stock Opname</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- /.box -->
            <div class="box" style="margin-top: -7px">
            </div>
          <!-- /.box -->
            <table id="datatable" class="table table-bordered table-condensed table-striped" style="width: 100%">
                <thead>
                  <tr class="">
                    <th>#</th>
                    <th>REG_DATE</th>  
                    <th>KODE_BARANG</th> 
                    <th>NAMA_BARANG</th>
                    <th>HARGA_BELI</th>
                    <th>SATUAN</th>
                    <th>KATEGORI</th>
                    <th>STOCK</th>
                    <th width="6%">FISIK</th>
                    <th>DIFF</th> 
                    <th>DIFF_VALUE</th>
                    <th>OPSI</th> 
                  </tr>
                </thead>
                </tbody>
                <tfoot class="">
                    <tr class="">
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <div class="box" style="margin-top: -15px">
            <!-- /.box-header -->
            <div class="box-body">
              <div align="left">
                <button type="button" name="search_prod" id="search_prod" class="btn bg-blue btn-sm">
                  <span class="fa fa-pencil"></span> By Product
                </button>
                <button type="button" name="cat_reg" id="cat_reg" class="btn bg-blue btn-sm">
                  <span class="fa fa-reorder "></span> By Category
                </button>
                <button type="button" name="all_reg" id="all_reg" class="btn bg-blue btn-sm">
                  <span class="fa fa-database "></span> All Product
                </button>
                <button type="button" name="reset" id="reset" class="btn bg-maroon btn-sm">
                  <span class="fa fa-remove "></span> Reset
                </button>
                <button id="transfer" class="btn bg-gray btn-sm">
                  <span class="fa fa-print"></span> Transfer
                </button>
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
</body>

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

<!-- menampilkan modal -->
<script type="text/javascript">
  $(document).ready(function (){
    $('#cat_reg').click(function(){
      $('#modal_cat_reg').modal('show');
    })    
  })  
</script>

<!-- event load select 2 modal category reg-->
<script type="text/javascript">
  $(document).on('shown.bs.modal','#modal_cat_reg', function (){
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

<!-- insert reg cataegory -->
<script type="text/javascript">
  $(document).on('change', '#select_kategori', function(event){
    event.preventDefault();
    var start_date  = $("#start_date").val();
    var kategori    = $("#select_kategori option:selected").text();
    var cat         = kategori.substring(0,2);
    $("#kode_kategori").val(cat);
  });
  $(document).on('submit', '#add_cat_reg', function(event){
  event.preventDefault();
  var post_cat = $("#kode_kategori").val();
  var kategori = $("#select_kategori option:selected").text();
  bootbox.confirm("Konfirmasi ?",function(confirmed){
    if (confirmed) {
    $('#modal_cat_reg').modal('hide');  
    $.ajax({
      type : "POST",
      dataType:"json",
      url:"<?php echo base_url() . 'Stock_opname/register_by_category'?>",
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

<!-- insert reg all product -->
<script type="text/javascript">
  $(document).on('click', '#all_reg', function(event){
    event.preventDefault();
    bootbox.confirm("Register all product ?",function(confirmed){
      if (confirmed) {
        $.ajax({
        url: "<?php echo base_url() . 'Stock_opname/register_by_allproduct'?>",
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

<!-- datatable fetch_stock_opname -->
<script type="text/javascript">
$(document).ready(function() {
$('#datatable').DataTable( {
  "footerCallback": function ( row, data, start, end, display ) {
    var api = this.api(), data;
    // converting to interger to find total
    var intVal = function ( i ) {
        return typeof i === 'string' ?
            i.replace(/[\$,]/g, '')*1 :
            typeof i === 'number' ?
                i : 0;
    };
    
    // computing column Total the complete result 
    var col_9 = api
      .column( 9 )
      .data()
      .reduce( function (a, b) {
      return intVal(a) + intVal(b);
      }, 0 );

    var col_10 = api
      .column( 10 )
      .data()
      .reduce( function (a, b) {
      return intVal(a) + intVal(b);
      }, 0 );

      // Update footer by showing the total with the reference of the column index   
      $( api.column( 9 ).footer() ).html(col_9.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
      $( api.column( 10 ).footer() ).html(col_10.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  },    
      "autoWidth": false,
      "mark": true, 
      "scrollY"     : "420px",
      'lengthChange': true,
      "lengthMenu"  : [[15, 50, 100, -1], [15, 50, 100, "All"]],
      'paging'      : false,
      'searching'   : true,
      'info'        : false,
      "ordering": true,
      dom: 'Blfrtip',
      responsive: true,
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
          url :"<?php echo base_url() . 'Stock_opname/fetch_stock_opname'; ?>", // json datasource
          type: "POST",
        },
        "rowCallback": function (row, data, index) {
          var baris = $(row);
          //qty_penitipan
          baris.find('.fisik').on('change', function () {
            post_fisik = ($.isNumeric(baris.find("#post_fisik").val())) ? baris.find("#post_fisik").val() : 0;
            kode_barang = data[2];
             baris.find('#update_fisik').val(post_fisik);
              $.ajax({ 
               type : "POST",
                url:"<?php echo base_url() . 'Stock_opname/update_fisik'?>",
                data : 
                {
                  kode_barang:kode_barang,
                  fisik:post_fisik
                },
                success: function(data){
                  $("#datatable").DataTable().ajax.reload();
                }
              })
          });
          }  
      });

      /*begin edit*/
      $(document).on('click', '#edit', function(event){
        event.preventDefault();
        //menampilkan data ke input text
        var currentRow = $(this).closest("tr")[0]; 
        var cells      = currentRow.cells;
        var data_2     = cells[2].textContent;
        var data_3     = cells[3].textContent;
        $('#modal_edit').modal('show');
        $('#edit_kode_barang').val(data_2);
        $('#edit_nama_barang').val(data_3);
        $('#stock').val(data_7);
        //menampilkan data ke input text
      }); 
      /*end edit*/ 

      /*begin delete*/
      $(document).on('click', '#delete', function(event){
        event.preventDefault();
        var currentRow = $(this).closest("tr")[0]; 
        var cells      = currentRow.cells;
        var data_2     = cells[2].textContent;
        var data_3     = cells[3].textContent;

        bootbox.confirm("Hapus dari list "+"<span class='text-red'>"+data_3+"</span>"+" ?",function(confirmed){
          if (confirmed) {
            $.ajax({
              type : "POST",
              url:"<?php echo base_url() . 'Stock_opname/delete_register'?>",
              data : 
              {
                kode_barang:data_2
              },
              success: function(data){
                $("#datatable").DataTable().ajax.reload();
              }
            });
          }
        });
      }); 
    /*end delete*/ 
} );
</script>

<!-- event modal edit barang tampil -->
<script type="text/javascript">
  $(document).on('shown.bs.modal','#modal_edit', function (){
    $('#fisik').val('');
    $('#fisik').focus();
    //format hanya angka
    $("#fisik").keypress(function (e){
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    });
  }); 
</script>

<!-- update fisik barang -->
<!-- <script type="text/javascript">
$(document).on('change', '#fisik', function(event){
  event.preventDefault();
  var currentRow  = $(this).closest("tr")[0]; 
  var cells       = currentRow.cells;
  var kode_barang = cells[2].textContent;
  var fisik       = cells[8].textContent;
  alert(fisik)
  $.ajax({
    type : "POST",
    url:"<?php echo base_url() . 'Stock_opname/update_fisik'?>",
    data : 
    {
      kode_barang:kode_barang,
      fisik:fisik
    },
    success: function(data){
      //$('#modal_edit').modal('hide');
      $("#datatable").DataTable().ajax.reload();
    }
  });
});
</script> -->

<!-- insert data -->
<script type="text/javascript">
$(document).on('click', '#transfer', function(event){
  event.preventDefault();
  var table         = $('#datatable').DataTable();
  var data          = table .rows() .data();
  var isi_table     = data.length;
  bootbox.confirm("Konfirmasi transfer stock opname ?",function(confirmed){
    if (confirmed) {
      $.ajax({
      type : "POST",
      url:"<?php echo base_url() . 'Stock_opname/ins_det_stock_opname'?>",
      beforeSend: function(){
        $('#loading_modal').modal('show');
      },
      complete: function(){
        //$('#loading_modal').modal('show');
      },
      success: function(data){
        $('#loading_modal').modal('hide');
        bootbox.alert('Transfer stock opname berhasil')
        $("#datatable").DataTable().ajax.reload();
      }
    });
    }
  });    
});
</script>

<!-- reset temp stock opname -->
<script type="text/javascript">
  $(document).on('click', '#reset', function(event){
    event.preventDefault();
    var table         = $('#datatable').DataTable();
    var data          = table .rows() .data();
    var isi_table     = data.length;
    if (isi_table=='0') {
      return false;
    }
    else{
      bootbox.confirm("Yakin menghapus list stock opname ?",function(confirmed){
      if (confirmed) {
        $.ajax({
          url: "<?php echo base_url() . 'Stock_opname/reset_stock_opname'?>",
            success: function(data){
              $('#no_nota').val('');
              $("#datatable").DataTable().ajax.reload();
              $('#no_nota').focus();
            }
          })
        }
      });
    }  
  }); 
</script>

<!-- event klik cari barang -->
<script type="text/javascript">
  $(document).ready(function (){
    $('#search_prod').click(function(){
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
          url :"<?php echo base_url() . 'Stock_opname/fetch_master_barang'; ?>", // json datasource
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
        var stock         = cells[6].textContent;
        $.ajax({
        type : "POST",
        url:"<?php echo base_url() . 'Stock_opname/register_by_product'?>",
        data : 
        {
          kode_barang:kode_barang, kategori: kategori,
          stock:stock
        },
        success: function(data){
          $("#datatable").DataTable().ajax.reload();
        }
      });
        
    });
  })
</script>

<!-- category so modal -->
<div class="modal fade modal-danger" id="modal_cat_reg" data-backdrop="static">
  <form class="form-horizontal" id="add_cat_reg">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Register By Category</h4>
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
            <button type="submit" id="save_reg_cat" class="btn btn-outline">Save changes</button>
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

<!-- edit modal -->
<div class="modal fade modal-info" id="modal_edit">
  <form class="form-horizontal" id="edit_barang">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Form Entri Fisik SO</h4>
        </div>
        <div class="modal-body" style="background-color: white!important;">

          <input type="hidden" id="edit_id" name="edit_id" required="" class="form-control">

          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">KODE_BARANG</label>
            <div class="col-md-7">
              <input type="text" id="edit_kode_barang" name="edit_kode_barang" readonly="" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">NAMA_BARANG</label>
            <div class="col-md-10">
              <input type="text" id="edit_nama_barang" name="edit_nama_barang" readonly="" class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">FISIK_BARANG</label>
            <div class="col-md-6">
              <input type="text" id="fisik" required="" name="fisik" class="form-control">
            </div>
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
    margin-top: -60px;
    /*display: inline;*/
}
div.dataTables_wrapper  div.dataTables_filter {
/*  width: 100%;*/
  margin-top: 0px;color: black
}
</style>


