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
              <h3 class="box-title">Stock Barang</h3>
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
                    <th>KODE_BARANG</th> 
                    <th>NAMA_BARANG</th>
                    <th>HARGA_JUAL</th>
                    <th>SATUAN</th>
                    <th>PURC</th>        
                    <th>SALES</th>
                    <th>RETUR</th>
                    <th>ADJUST</th>
                    <th>STR_IN</th>
                    <th>STOCK</th>   
                    <th>NILAI_STOCK</th> 
                  </tr>
                </thead>
                <tfoot>
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
                </tbody>
              </table>
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

<?php $this->load->view('back/footer') ?>
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

<!-- datatable and number only -->
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
    var col_11 = api
      .column( 11 )
      .data()
      .reduce( function (a, b) {
      return intVal(a) + intVal(b);
      }, 0 );
      // Update footer by showing the total with the reference of the column index   
      $( api.column( 11 ).footer() ).html(col_11.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    },    
      "autoWidth": false,
      "mark": true, 
      "scrollY"     : "400px",
      'lengthChange': true,
      "lengthMenu"  : [[100, 2000, 3000, -1], [100, 2000, 3000, "All"]],
      'paging'      : true,
      'searching'   : true,
      'info'        : true,
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
      processing: true,
           "language": {
          processing: '<div style="margin-top:-4px"><img src="images/index.gif" alt="" class=""><span> &nbsp;&nbsp;Loading... </span></div>'},
        "serverSide" : true,

       "ajax":{
          url :"<?php echo base_url() . 'Stock/fetch_stock'; ?>", // json datasource
          type: "POST",
        }
      });

      /*begin edit*/
      $(document).on('click', '#edit', function(event){
        event.preventDefault();
        //menampilkan data ke input text
        var currentRow = $(this).closest("tr")[0]; 
        var cells      = currentRow.cells;
        var data_1     = cells[1].textContent;
        var data_2     = cells[2].textContent;
        var data_7     = cells[7].textContent;
        $('#modal_edit').modal('show');
        $('#edit_kode_barang').val(data_1);
        $('#edit_nama_barang').val(data_2);
        $('#stock').val(data_7);
        //menampilkan data ke input text
      }); 
      /*end edit*/ 
} );
</script>

<!-- event modal edit barang tampil -->
<script type="text/javascript">
  $(document).on('shown.bs.modal','#modal_edit', function (){
    $("#edit_pesan").hide();
    $('#update_stock').val('');
    $('#update_stock').focus();
    //format hanya angka
    $("#update_stock").keypress(function (e){
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    });
  }); 
</script>

<!-- edit barang -->
<script type="text/javascript">
$(document).on('submit', '#edit_barang', function(event){
  event.preventDefault();
  var kode_barang   = $('#edit_kode_barang').val();
  var nama_barang   = $('#edit_nama_barang').val();
  var update_stock  = $('#update_stock').val();

  bootbox.confirm("Konfirmasi ?",function(confirmed){
    if (confirmed) {
      $.ajax({
      type : "POST",
      url:"<?php echo base_url() . 'Stock/update_stock'?>",
      data : 
      {
        kode_barang:kode_barang,
        nama_barang:nama_barang,
        update_stock:update_stock
      },
      success: function(data){
        //menampilkan dan merubah class pesan
        $("#edit_pesan").show();
        $("#edit_msg").html('Update stock berhasil!');
        $('#edit_pesan').removeClass('alert alert-danger alert-dismissible').addClass('alert alert-warning alert-dismissible');
        //menampilkan dan merubah class pesan
        $("#datatable").DataTable().ajax.reload();
        //$("#update_stock").val();
      }
      });

    }
  });
});
</script>



<!-- edit modal -->
<div class="modal fade modal-success" id="modal_edit">
  <form class="form-horizontal" id="edit_barang">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Form Update Stock</h4>
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
            <label for="inputPassword3" class="col-md-2 control-label text-black">STOCK</label>
            <div class="col-md-6">
              <input type="text" id="stock" name="stock" readonly="" class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">UPDATE_STOCK</label>
            <div class="col-md-6">
              <input type="text" id="update_stock" name="update_stock" required="" class="form-control">
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
.btn-default.btn-on-2.active{
  background-color: #00a65a;color: white;
  
}
.btn-default.btn-off-2.active{
  background-color: #dd4b39;color: white;

}
/*div.container { max-width: 1200px }*/
</style>


