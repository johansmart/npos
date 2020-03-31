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
              <h3 class="box-title">List Sisa Piutang</h3>
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
                    <th>ID</th>
                    <th>NO_PIUTANG</th>
                    <th>TGL_PIUTANG</th>
                    <th>NO_PIUTANG</th>         
                    <th>KODE_PELANGGAN</th>
                    <th>NAMA_PELANGGAN</th>
                    <th>JUMLAH_PIUTANG</th>
                    <th>JUMLAH_BAYAR</th>
                    <th>SISA_PIUTANG</th>
                    <th width="50">BAYAR</th>
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

<!-- datatable-->
<script type="text/javascript">
  $(document).ready(function(){
    $("#pesan").hide();
    $("#edit_pesan").hide();
    /*begin datatable*/
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
        var col_6 = api
          .column( 6 )
          .data()
          .reduce( function (a, b) {
          return intVal(a) + intVal(b);
          }, 0 );
        var col_7 = api
          .column( 7 )
          .data()
          .reduce( function (a, b) {
          return intVal(a) + intVal(b);
          }, 0 );
        var col_8 = api
          .column( 8 )
          .data()
          .reduce( function (a, b) {
          return intVal(a) + intVal(b);
          }, 0 );    
          // Update footer by showing the total with the reference of the column index   
          $( api.column( 6 ).footer() ).html(col_6.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
          $( api.column( 7 ).footer() ).html(col_7.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
          $( api.column( 8 ).footer() ).html(col_8.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
      },    
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
          url :"<?php echo base_url() . 'Lap_sisa_piutang/fetch_sisa_piutang'; ?>", // json datasource
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
        var data_3     = cells[3].textContent;
        var data_4     = cells[4].textContent;
        var data_5     = cells[5].textContent;
        var data_8     = cells[8].textContent;
        $('#modal_bayar').modal('show');
        $('#no_piutang').val(data_3);
        $('#kode_pelanggan').val(data_4);
        $("#nama_pelanggan").val(data_5);
        $("#jumlah_piutang").val(data_8);
        //menampilkan data ke input text
      }); 
      /*end edit*/ 
</script>

<!-- event modal bayar piutang tampil -->
<script type="text/javascript">
  $(document).on('shown.bs.modal','#modal_bayar', function (){
    $("#edit_pesan").hide();
    $("#bayar_piutang").focus();
  }); 
</script>

<!-- menampilkan modal bayar -->
<script type="text/javascript">
  $(document).ready(function (){
    $('#edit').click(function(){
      $('#modal_bayar').modal('show');
    })   
  })  
</script>

<!-- insert bayar piutang -->
<script type="text/javascript">
$(document).on('submit', '#frm_bayar_piutang', function(event){
  event.preventDefault();
  var no_piutang      = $('#no_piutang').val();
  var kode_pelanggan = $('#kode_pelanggan').val();
  var jumlah_piutang = $('#jumlah_piutang').val();
  var bayar_piutang  = $('#bayar_piutang').val();
  if (parseInt($('#bayar_piutang').val()) > parseInt($('#jumlah_piutang').val())) {
    $("#pesan").show();
    $("#msg").html('Transaksi gagal, melebihi sisa piutang!');
    return false;
  }
  bootbox.confirm("Konfirmasi ?",function(confirmed){
    if (confirmed) {
      $.ajax({
      type : "POST",
      url:"<?php echo base_url() . 'Lap_sisa_piutang/insert_bayar_piutang'?>",
      data : 
      {
        no_piutang:no_piutang,
        kode_pelanggan:kode_pelanggan,
        jumlah_piutang:jumlah_piutang,
        bayar_piutang:bayar_piutang
      },
      success: function(data){
        $('#modal_bayar').modal('hide');
        bootbox.alert("Transaksi pembayaran piutang berhasil", function(){ 
          console.log(
          location.reload()
          ); 
        });
      }
    });
    }
  });
});
</script>
 
<!-- event keyup menyembunyikan pesan -->
<script type="text/javascript">
  $(document).on('keyup', '#bayar_piutang', function(){
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
<div class="modal fade modal-info" id="modal_bayar">
  <form class="form-horizontal" id="frm_bayar_piutang">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Form Pembayaran Piutang</h4>
        </div>
        <div class="modal-body" style="background-color: white!important;">
          <div class="form-group">
            <label for="inputPassword3" class="col-md-3 control-label text-black">NO_PIUTANG</label>
            <div class="col-md-8">
              <input type="text" id="no_piutang" name="no_piutang" readonly class="form-control bg-gray">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-3 control-label text-black">KODE_PELANGGAN</label>
            <div class="col-md-8">
              <input type="text" id="kode_pelanggan" name="kode_pelanggan" readonly class="form-control bg-gray">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-3 control-label text-black">NAMA_PELANGGAN</label>
            <div class="col-md-8">
              <input type="text" id="nama_pelanggan" name="nama_pelanggan" readonly class="form-control bg-gray">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-3 control-label text-black">SISA_PIUTANG</label>
            <div class="col-md-8">
              <input type="text" id="jumlah_piutang" name="jumlah_piutang" readonly class="form-control bg-gray">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-3 control-label text-black">BAYAR</label>
            <div class="col-md-8">
              <input type="number" id="bayar_piutang" name="bayar_piutang" required="" class="form-control">
            </div>
          </div>

          <div class="alert alert-danger alert-dismissible" id="pesan">
              <i class="icon fa fa-remove"></i> <span id="msg"></span>
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

</style>


