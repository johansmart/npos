<?php $this->load->view('back/meta') ?>
<?php $this->load->view('back/head') ?>
<?php $this->load->view('back/sidebar') ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
<!--     <section class="content-header">
      <h1>
        Pembelian
        <small>Penerimaan Barang</small>
      </h1>
    </section> -->

        <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"> Form Retur Pembelian Barang</h3>
            </div>
            <div class="box">
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top: -7px">
            <form id="addPur" data-parsley-validate class="form-horizontal form-label-left"  method="POST" name="requestForm">
            <table class="table table-bordered table-condensed">
              <thead class="">
                <tr>
                  <th width="150" class="">PURC_NO</th>
                  <th width="50" class="">SEARCH</th>
                  <th class=""></th>
                </tr>
              </thead>
              <tbody>
              <tr>
                <td>
                  <input class="form-control input-sm" type="text" autofocus="" id="no_nota"  name="no_nota" placeholder="Wajib diisi..."  tabindex="1" style="height:25px;width:100%;padding: 0 2.5em 0 0.5em;background-color: #f2e6ff"/>
                </td>
                <td>
                  <button type="submit" id="srcButton" class="btn btn-default btn-xs btn-flat" data-toggle="modal" data-target="#userModal">
                    <span class="glyphicon glyphicon-search"></span> SEARCH
                  </button>
                </td> 
                <td></td>
              </tr>
              </table>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <div class="box" style="margin-top: -40px">
            <!-- /.box-header -->
            <div class="box-body">
              <form id="submit" >
              <table id="datatable" class="table table-bordered table-condensed" style="width: 100%">
                <thead class="">
                  <tr>
                    <th class="">NO_NOTA</th>
                    <th class="" width="120">KODE_BARANG</th>
                    <th class="" width="250">NAMA_BARANG</th>
                    <th class="">SATUAN</th>
                    <th class="">KODE_SUPP</th>
                    <th class="">HARGA_BELI</th>
                    <th class="">JML_BELI</th>
                    <th class="">TOT_HARGA</th>
                    <th class="" width="100">RETUR</th>
                    <th class="" width="100">ALASAN</th>
                    </tr>
                </thead>
                <tbody>
                  <tfoot class="">
                    <tr>
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

          <div class="box" style="margin-top: -15px">
            <!-- /.box-header -->
            <div class="box-body">
              <div align="center">
                <button type="reset" name="cancel" id="cancel" class="btn bg-red btn-sm">
                    <span class="glyphicon glyphicon-remove"></span> RESET
                  </button>
                  <button type="submit" name="save" id="save" class="btn bg-blue btn-sm">
                    <span class="fa fa-save"></span> SAVE
                  </button>
              </div>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
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

<!-- datatable and number only -->
<script type="text/javascript">
  $(document).ready(function(){
    //script number only  
    setTimeout(function() {
      $('input[name="jml_retur[]"]').keypress(function (e){
      var charCode = (e.which) ? e.which : e.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
      }
      });
      //clear select option
      $('select[name="alasan[]"]').val('Please Select')
    },500);
    /*begin datatable*/
    $('#datatable').DataTable( {

      //menampilkan total pada footer
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
    var col_7 = api
      .column( 7 )
      .data()
      .reduce( function (a, b) {
      return intVal(a) + intVal(b);
      }, 0 );
      // Update footer by showing the total with the reference of the column index 
      $( api.column( 6 ).footer() ).html('TOTAL');  
      $( api.column( 7 ).footer() ).html(col_7.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        //menampilkan total pada footer
      }, 
      "autoWidth": true, 
      "scrollY": "250px",
      scrollX:        true,
      'lengthChange': false,
      'paging': false,
      'searching'   : false,
      'info'        : false,
      "lengthChange": false,
      "ordering": false,
      processing: true,
           "language": {
          processing: '<div style="margin-top:-4px"><img src="images/index.gif" alt="" class=""><span> &nbsp;&nbsp;Loading... </span></div>'},
        "serverSide" : true,

        "ajax":{
          url :"<?php echo base_url() . 'Retur_barang/fetch_temp_retur_barang'; ?>", // json datasource
          type: "post",
            // method  , by default get
        }
      });
     });
    /*end datatable*/
</script>

<!-- insert temp retur -->
<script type="text/javascript">
  $(document).on('submit', '#addPur', function(event){
    event.preventDefault();
    var no_nota      = $('#no_nota').val();
    if (no_nota=='') {
      $('#no_nota').focus();
      return false;
    }
    else{
      $.ajax({
        url: "<?php echo base_url() . 'Retur_barang/insert_temp_retur'?>",
        type: 'POST',
        data: { no_nota: no_nota},
        method:"POST",
        success: function(data){
          $("#datatable").DataTable().ajax.reload();
          setTimeout(function() {
            //clear select option
            $('select[name="alasan[]"]').val('Please Select')
          },200);
        }
      })
    }
  });    
</script>

<script type="text/javascript">
  $("#save").click(function(event) {
    event.preventDefault();

    //mulai variable input text array
    var kode_barang = $('input[name="kode_barang[]"]').map(function(){ 
      return this.value; 
    }).get();
    var jml_retur = $('input[name="jml_retur[]"]').map(function(){ 
        return this.value; 
    }).get();
    var jml_beli = $('input[name="jml_beli[]"]').map(function(){ 
        return this.value; 
    }).get();
    var harga_beli = $('input[name="harga_beli[]"]').map(function(){ 
        return this.value; 
    }).get();
    var alasan = $('select[name="alasan[]"]').map(function(){ 
        return this.value; 
    }).get();
    //selesai variable input text array

    //mulai variable validasi isitable
    var table = $('#datatable').DataTable();
    var data = table .rows() .data();
    var isi_table = data.length;
    //selesai variable validasi isitable

    //mulai variable sum input jml retur
    var tot = 0;
    $('input[name="jml_retur[]"]').each(function(){
      tot += Number($(this).val());
    });
    //selesai variable sum input jml retur
    if (isi_table=='0') {
      return false;
    }
    else if (tot==0) {
      return false;
    }
    else{
      bootbox.confirm("Konfirmasi",function(confirmed){
        if (confirmed) {
          $.ajax({
              url: "<?php echo base_url() . 'Retur_barang/save_retur'?>",
              type: 'POST',
              data:
              {
                'kode_barang[]': kode_barang,
                'jml_beli[]': jml_beli,
                'jml_retur[]': jml_retur,
                'harga_beli[]': harga_beli,
                'alasan[]': alasan,
                // other data
              },
              success: function(data){
                if (data=='err_jml') 
                {
                  alert('Gagal menyimpan, jumlah retur melebihi jumlah pembelian');
                  return false;
                }
                else if (data=='over_limit') 
                {
                  alert('Gagal menyimpan, jumlah retur over limit');
                  return false;
                }
                else if (data=='err_opt') 
                {
                  alert('Mohon lakukan pengisian dengan benar.!');
                  return false;
                }
                else if (data=='success') 
                {
                  bootbox.alert("Proses retur berhasil. !", function(){ 
                    console.log(
                    location.reload()
                    ); 
                  });
                }
              }
          })
        }
      }); 
    }
  });
</script>

<!-- reset temp beli barang -->
<script type="text/javascript">
  $(document).on('click', '#cancel', function(event){
    event.preventDefault();
    bootbox.confirm("Cancel all ?",function(confirmed){
      if (confirmed) {
        $.ajax({
        url: "<?php echo base_url() . 'Retur_barang/reset_form'?>",
          success: function(data){
            $('#no_nota').val('');
            $("#datatable").DataTable().ajax.reload();
            $('#no_nota').focus();
          }
        })
      }
    });       
  }); 
</script>

<style type="text/css">
.table tbody tr:hover td, .table tbody tr:hover th {
  background-color: white;
}
input 
{
  border:1px solid white;
  padding: 3px;
}
</style>


