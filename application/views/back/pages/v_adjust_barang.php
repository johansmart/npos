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
              <h3 class="box-title"> Form Adjust Barang</h3>
            </div>
            <div class="box">
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top: -7px">
            <form id="addPur" data-parsley-validate class="form-horizontal form-label-left"  method="POST" name="requestForm">
            <table class="table table-bordered table-condensed">
              <thead class="">
                <tr>
                  <th width="150" class="">TANGGAL</th>
                  <th width="150" class="">JAM</th>
                  <th width="150" class="">USER_ID</th>
                  <th style="width: 50%;text-align: center;" class="" colspan="2" align="center"></th>
                </tr>
              </thead>
              <tbody>
              <tr>
                <td>
                  <input class="form-control input-sm" type="text" readonly="" id="tanggal"  name="tanggal" value="<?php echo date(date('d-m-Y'))?>" style="height:25px;width:100%;padding: 0 2.5em 0 0.5em;"/>
                </td> 
                <td>
                  <input class="form-control input-sm" type="text" readonly="" id="jam" name="jam" value="<?php echo date(date('H:i:s'))?>" style="height:25px;width:100%;padding: 0 2.5em 0 0.5em;"/>
                </td>
                <td>
                  <input class="form-control input-sm" type="text" readonly="" id="user_id"  name="user_id" value="<?php echo $this->session->userdata('id_karyawan')?>" style="height:25px;width:100%;padding: 0 2.5em 0 0.5em;"/>
                </td>   
                <td></td>
              </tr>
              </table>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <div class="box" style="margin-top: -50px">
            <!-- /.box-header -->
            <div class="box-body">
              <form id="submit" >
              <table id="datatable" class="table table-bordered table-condensed table-striped" style="width: 100%">
                <thead class="">
                  <tr>
                    <th class="" width="120">KODE_BARANG</th>
                    <th class="" width="250">NAMA_BARANG</th>
                    <th class="">SATUAN</th>
                    <th class="">KODE_SUPP</th>
                    <th class="">HARGA_BELI</th>
                    <!-- <th class="">STOCK</th> -->
                    <th class="">JML_ADJUST</th>
                    <th class="">NILAI_ADJUST</th>
                    <th class="" width="100">ALASAN</th>
                    <th class="" width="100">OPSI</th>
                    </tr>
                </thead>
                <tbody>
                  <tfoot class="">
                    <tr>
                      <!-- <th></th> -->
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
                <button type="reset" name="cancel" id="cancel" class="btn btn-danger btn-sm">
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
      number_only();
      //clear select option
      $('#alasan').val('Please Select')
      $('#kode_barang').focus()
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
    var api = this.api(), data;
      $.ajax({
        url: "<?php echo base_url() . 'Adjust_barang/sum_nilai_adjust'?>",
        type : "POST",
        success: function(data){
        // Update footer
        $( api.column( 5 ).footer() ).html('TOTAL');
        $( api.column( 6 ).footer() ).html(data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        }
      }) 
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
          url :"<?php echo base_url() . 'Adjust_barang/fetch_temp_adjust_barang'; ?>", // json datasource
          type: "post",
            // method  , by default get
        }
      });
     });
    /*end datatable*/
</script>

<!-- mengambil item info hasil dariajax -->
<script type="text/javascript">
  $(document).on('change', '#kode_barang', function(event){
   var kode_barang = $('#kode_barang').val(); 
   event.preventDefault();
      $.ajax({
      url: "<?php echo base_url() . 'Adjust_barang/get_item_info'?>",
      type : "POST",
      data:{kode_barang:kode_barang},
      dataType : "JSON",
      success: function(data){
        if (data!='') {
          $('#nama_barang').val(data[0])
          $('#satuan').val(data[1])
          $('#kode_supp').val(data[2])
          $('#harga_beli').val(data[3])
        }
        /*else{

          bootbox.alert("Barang tidak ditemukan", function(){ 
            console.log(
            setTimeout(function() {
              $('#kode_barang').val('')
              $('#nama_barang').val('')
              $('#satuan').val('')
              $('#kode_supp').val('')
              $('#harga_beli').val(0)
              $('#jumlah').val('');
              $('#kode_barang').focus();
              return false;
            },1000)
            ); 
          });
        }*/
      }
    })
  })
  //kalkulasi total - harga
  $(document).on('keyup', '#jumlah', function () {
    var harga_beli   = $("#harga_beli").val(); 
    var jumlah       = $("#jumlah").val();
    var nilai_adjust = harga_beli*jumlah;
    $("#nilai_adjust").val(nilai_adjust);
  });
  //kalkulasi total - harga  

  //insert ke table tmp_adjust_barang lewat tombol add button
  $(document).on('click', '#add', function (e) {
    e.preventDefault();
    var kode_barang   = $('#kode_barang').val();
    var nama_barang   = $('#nama_barang').val();
    var satuan        = $('#satuan').val();
    var kode_supp     = $('#kode_supp').val();
    var harga_beli    = $('#harga_beli').val();
    var jumlah        = $('#jumlah').val();
    var nilai_adjust  = $('#nilai_adjust').val();
    var alasan        = $('#alasan :selected').text();
    if (kode_barang=='') {
      $('#kode_barang').focus();
      return false;
    }

    else if (jumlah=='' || jumlah<1) {
      $('#jumlah').focus();
      return false;
    }

    else if (alasan=='') {
      $('#alasan').attr('selected','selected');
      return false;
    }

    else {
      $('#kode_barang').focus();
      $.ajax({
        type : "POST",
        url:"<?php echo base_url() . 'Adjust_barang/insert_tmp_adjust_barang'?>",
        data : 
        {
          kode_barang:kode_barang,
          nama_barang:nama_barang,
          satuan:satuan,
          kode_supp:kode_supp,
          harga_beli:harga_beli,
          jumlah:jumlah,
          nilai_adjust:nilai_adjust,
          alasan:alasan
        },
        success: function(data){
        if (data==1) {
          bootbox.alert(nama_barang+' sudah terinput', function(){ 
          console.log(
          setTimeout(function() {
            $('#nama_barang').val('');
            $('#satuan').val('');
            $('#kode_supp').val('');
            $('#harga_beli').val(0)
            $('#jumlah').val('');
            $('#nilai_adjust').val(0);
            //clear select option
            $('#alasan').val('Please Select')
            $('#kode_barang').focus();
          },200)
          ); 
          });
          return false;
        }
        else if (data==2) {
          bootbox.alert('Barang tidak ditemukan', function(){ 
          console.log(
          setTimeout(function() {
            $('#harga_beli').val(0)
            $('#jumlah').val('');
            //clear select option
            $('#alasan').val('Please Select')
            $('#kode_barang').focus();
          },200)
          ); 
          });
          return false;
        }
        else{
          $("#datatable").DataTable().ajax.reload();
          setTimeout(function() {
            $('#kode_barang').focus();
            $('#nama_barang').val('');
            //clear select option
            $('#alasan').val('Please Select');
            number_only();
            },200);
          }
        }
      });
    }
  });
  /*mulai Hapus isi table temp_adjust_barang*/
  $(document).on('click', '#delete', function(event){
    event.preventDefault();
    var currentRow  = $(this).closest("tr")[0]; 
    var cells       = currentRow.cells;
    var prod_name   = cells[1].textContent;
    var kode_barang = cells[0].textContent;
    bootbox.confirm("DELETE : "+ " "+prod_name+" ?",function(confirmed){
        if (confirmed) {
          //alert('delete process');
           $.ajax({
            url: "<?php echo base_url() . 'Adjust_barang/delete_product'?>",
            type: 'POST',
            method:"POST",
            data:{kode_barang:kode_barang},  
          })
          .done(function(data){
           $("#datatable").DataTable().ajax.reload();
           setTimeout(function() {
            $('#kode_barang').focus();
            $('#nama_barang').val('');
            //clear select option
            $('#alasan').val('Please Select');
            number_only();
            },200);
          })
        }
     });    
  }); 
  /*selesai Hapus isi table temp_adjust_barang*/
</script>

<!-- reset tabel temp_adjust_barang -->
<script type="text/javascript">
  $(document).on('click', '#cancel', function(event){
    event.preventDefault();
    var nama_barang   = $('#nama_barang').val();
    var table         = $('#datatable').DataTable();
    var data          = table .rows() .data();
    var isi_table     = data.length;

    if (isi_table=='1' && nama_barang=='') {
      return false;
    }
    else{
      bootbox.confirm("Cancel all ?",function(confirmed){
      if (confirmed) {
        $.ajax({
        url: "<?php echo base_url() . 'Adjust_barang/reset_form'?>",
            success: function(data){
              location.reload();
            }
          })
        }
      });
    }       
  }); 
</script>

<!-- insert data -->
<script type="text/javascript">
$(document).on('click', '#save', function(event){
  event.preventDefault();
  var kode_barang   = $('#kode_barang').val();
  var nama_barang   = $('#nama_barang').val();
  var satuan        = $('#satuan').val();
  var kode_supp     = $('#kode_supp').val();
  var harga_beli    = $('#harga_beli').val();
  var jumlah        = $('#jumlah').val();
  var nilai_adjust  = $('#nilai_adjust').val();
  var alasan        = $('#alasan :selected').text();
  var table         = $('#datatable').DataTable();
  var data          = table .rows() .data();
  var isi_table     = data.length;
  //validasi dan cek no nota yang sudah ada
  if (isi_table=='1' && nama_barang=='') {
    return false;
  }
  else if (isi_table=='1' && nama_barang!='' && jumlah<1) {
    return false;
  }
  else if (isi_table=='1' && nama_barang!='' && alasan=='') {
    return false;
  }
  else{
    bootbox.confirm("Konfirmasi ?",function(confirmed){
          //simpan baris terakhir ke table temp_adjust_barang  
          if (confirmed) {
            $.ajax({
              type : "POST",
              url:"<?php echo base_url() . 'Adjust_barang/insert_tmp_adjust_barang'?>",
              data : 
              {
                kode_barang:kode_barang,
                nama_barang:nama_barang,
                satuan:satuan,
                kode_supp:kode_supp,
                harga_beli:harga_beli,
                jumlah:jumlah,
                nilai_adjust:nilai_adjust,
                alasan:alasan
              },
              success: function(data){
                if (data==1) {
                  bootbox.alert(nama_barang+' sudah terinput', function(){ 
                  console.log(
                  setTimeout(function() {
                    $('#nama_barang').val('');
                    $('#satuan').val('');
                    $('#kode_supp').val('');
                    $('#harga_beli').val(0)
                    $('#jumlah').val('');
                    $('#nilai_adjust').val(0);
                    //clear select option
                    $('#alasan').val('Please Select')
                    $('#kode_barang').focus();
                  },200)
                  ); 
                  });
                  return false;
                }
                else if (kode_barang !='' && data==2) {
                  bootbox.alert('Barang tidak ditemukan', function(){ 
                  console.log(
                  setTimeout(function() {
                    $('#harga_beli').val(0)
                    $('#jumlah').val('');
                    //clear select option
                    $('#alasan').val('Please Select')
                    $('#kode_barang').focus();
                  },200)
                  ); 
                  });
                  return false;
                }
                else{
                  $.ajax({
                    url: "<?php echo base_url() . 'Adjust_barang/ins_adjust_barang'?>",
                    type : "POST",
                    dataType : "JSON",
                    success: function(data){
                      location.reload();
                    }
                  }) 
                }
              }
            });
          }
        }); 

  }


        



});
</script>

<script type="text/javascript">
  function number_only(){
    $('#kode_barang,#jumlah').keypress(function (e){
      var charCode = (e.which) ? e.which : e.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
      }
    });
  } 
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


