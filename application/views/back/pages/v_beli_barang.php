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
              <h3 class="box-title"> Form Input Pembelian Barang</h3>
            </div>
            <div class="box">
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top: -7px">
            <form id="addPur" data-parsley-validate class="form-horizontal form-label-left"  method="POST" name="requestForm">
            <table class="table table-bordered table-condensed">
              <thead>
                <tr>
                  <th width="50" class="">TANGGAL</th>
                  <th width="50" class="">USER_ID</th>
                  <th style="width: 70%;text-align: center;" class="" colspan="2" align="center"></th>
                </tr>
              </thead>
              <tbody>
              <tr>
                <td>
                  <input class="form-control input-sm" type="text" id=""  name="" tabindex="1" value="<?php echo date(date('Y-m-d'))?>" readonly="" style="height:25px;width:100%;padding: 0 2.5em 0 0.5em;"/>
                </td> 
                <!-- <td>
                  <input class="form-control input-sm" type="text" readonly="" id="jam" name="jam" tabindex="1" value="<?php echo date(date('H:i:s'))?>" style="height:25px;width:100%;padding: 0 2.5em 0 0.5em;"/>
                </td> -->
                <td>
                  <input class="form-control input-sm" type="text" readonly="" id="user_id"  name="user_id" value="<?php echo $this->session->userdata('id_karyawan')?>" tabindex="1" style="height:25px;width:100%;padding: 0 2.5em 0 0.5em;"/>
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
              <table id="datatable" class="table table-bordered table-condensed table-striped">
                <thead class="">
                  <tr>
                    <th width="120">KODE_BARANG</th>
                    <th width="250">NAMA_BARANG</th>
                    <th>SATUAN</th>
                    <th>KATEGORI</th>
                    <th>HARGA_BELI</th>
                    <th>JUMLAH</th>
                    <th width="50">TOTAL_HARGA</th>
                    <th width="50">PILIHAN</th>
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
                      <th  id="grand_total"></th>
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
              <div align="left">
                  <button type="button" id="search_prod" class="btn bg-gray btn-sm">
                    <span class="glyphicon glyphicon-search"></span> CARI_BRG
                  </button>
                  <button type="submit" name="cancel" id="cancel" class="btn bg-red btn-sm">
                    <span class="glyphicon glyphicon-remove"></span> RESET
                  </button>
                  <button type="submit" name="save" id="save" class="btn bg-blue btn-sm">
                    <span class="fa fa-save"></span> PROSES
                  </button>
              </div>
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
<!-- highlight datatable -->
<script src="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables_mark/datatables.mark.js"></script>
<script src="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables_mark/jquery.mark.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url('assets/template/backend/') ?>bower_components/select2/dist/js/select2.full.min.js"></script>

<!-- date picker -->
<script type="text/javascript">
  $(document).ready(function(){
   $('#tanggal').datepicker({
    todayBtn:'linked',
    format: "yyyy-mm-dd",
    autoclose: true
   });
}); 
</script>

<!-- get no fakur  -->
<!-- <script type="text/javascript">
  $(document).ready(function(){
    $.ajax({
      url: "<?php echo base_url() . 'Beli_barang/get_no_nota'?>",
      type : "POST",
      success: function(data){
        if (data==0) 
        {
          $('#no_nota').focus();
        }
        else
        {
         $('#no_nota').val(data);
          setTimeout(function() {
          $('#kode_barang').focus();
          },200); 
        }  
      }
    }) 
  });  
</script> -->

<!-- datatable and number only -->
<script type="text/javascript">
  $(document).ready(function(){
    //script number only  
    setTimeout(function() {
      $("#kode_barang,#jumlah").keypress(function (e){
      var charCode = (e.which) ? e.which : e.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
      }
      });
    },1000);
    /*begin datatable*/
    $('#datatable').DataTable( {
      //menampilkan total pada footer
      "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;
        $.ajax({
          url: "<?php echo base_url() . 'Beli_barang/sum_total_beli'?>",
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
      "scrollY": "300px",
      scrollX:        false,
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
          url :"<?php echo base_url() . 'Beli_barang/fetch_temp_beli_barang'; ?>", // json datasource
          type: "post",
            // method  , by default get
        }
      });
     });
    /*end datatable*/
</script>

<script type="text/javascript">
//validasi jika no nota kosong
$(document).on('focus','.isi', function(event){
  var no_nota  = $('#no_nota').val();
  var jumlah   = $('#jumlah').val();

  if ( no_nota=='') {
    bootbox.alert("Mohon lengkapi nomor nota", function(){ 
      console.log(
      setTimeout(function() {$('#no_nota').focus()},200)
      ); 
    });
    return false;
  }

  else if (no_nota !='') {
    $.ajax({
    url: "<?php echo base_url() . 'Beli_barang/check_no_nota'?>",
    type : "POST",
    data:{no_nota:no_nota},
    dataType : "JSON",
    success: function(data){
      if (data>0) {
        bootbox.alert("Nomor nota sudah terdaftar.!", function(){ 
          console.log(
          setTimeout(function() {$('#no_nota').focus()},200)
          ); 
        });
        return false;
      }
    }
  }) 
  }
});
// mengambil item info hasil dari ajax
$(document).on('focus', '#jumlah', function(event){  
   var kode_barang = $('#kode_barang').val(); 
    $.ajax({
    url: "<?php echo base_url() . 'Beli_barang/get_item_info'?>",
    type : "POST",
    data:{kode_barang:kode_barang},
    dataType : "JSON",
    success: function(data){
      $('#nama_barang').val(data[0])
      $('#satuan').val(data[1])
      $('#nama_kategori').val(data[2])
      $('#harga_beli').val(data[3])
    }
  }) 
});

//kalkulasi total - harga
$(document).on('keyup', '#jumlah', function () {
  var harga_beli = $("#harga_beli").val(); 
  var jumlah = $("#jumlah").val();
  var total_harga = harga_beli*jumlah;
  $("#total_harga").val(total_harga);
});
//kalkulasi total - harga

//insert ke table tmp_beli_barang lewat tombol enter
$(document).on('keypress', 'input,select', function (e) {
  if (e.which == 13) {
    e.preventDefault();
    var no_nota       = $('#no_nota').val();
    var kode_barang   = $('#kode_barang').val();
    var nama_barang   = $('#nama_barang').val();
    var satuan        = $('#satuan').val();
    var nama_kategori = $('#nama_kategori').val();
    var harga_beli    = $('#harga_beli').val();
    var jumlah        = $('#jumlah').val();
    var total_harga   = $('#total_harga').val();
    var tanggal       = $('#tanggal').val();
    var $next         = $('[tabIndex=' + (+this.tabIndex + 1) + ']');
    //console.log($next.length);
    if (!$next.length) {
      //$next = $('[tabIndex=1]');
      if (kode_barang=='') {
        $('#kode_barang').focus();
        return false;
      }

      else if (kode_barang!='' && nama_barang=='') {
        bootbox.alert("Barang tidak ditemukan", function(){ 
        console.log(
        setTimeout(function() {
          $('#jumlah').val('');
          $('#kode_barang').focus();
        },200)
        ); 
        });
        return false;
      }

      else if (jumlah=='' || jumlah<1) {
        $('#jumlah').focus();
        return false;
      }

      else {
        $('#kode_barang').focus();
        $.ajax({
          type : "POST",
          url:"<?php echo base_url() . 'Beli_barang/insert_tmp_beli_barang'?>",
          data : 
          {
            no_nota:no_nota,
            kode_barang:kode_barang,
            nama_barang:nama_barang,
            satuan:satuan,
            nama_kategori:nama_kategori,
            harga_beli:harga_beli,
            jumlah:jumlah,
            total_harga:total_harga,
            tanggal:tanggal
          },
          success: function(data){
          if (data==1) {
            bootbox.alert(nama_barang+' sudah terinput', function(){ 
            console.log(
            setTimeout(function() {
              $('#nama_barang').val('');
              $('#satuan').val('');
              $('#nama_kategori').val('');
              $('#harga_beli').val('');
              $('#jumlah').val('');
              $('#total_harga').val('');
              $('#kode_barang').focus();
            },200)
            ); 
            });
            return false;
          }
          $("#datatable").DataTable().ajax.reload();
          setTimeout(function() {
          $('#kode_barang').focus();
          $('#nama_barang').val('');
          $("#kode_barang,#jumlah").keypress(function (e){
            var charCode = (e.which) ? e.which : e.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
              return false;
            }
          });
          },200);
          }
        });
      }
    }
  $next.focus();
  }
});

//insert ke table tmp_beli_barang lewat tombol add button
$(document).on('click', '#add', function (e) {
  e.preventDefault();
  var no_nota       = $('#no_nota').val();
  var kode_barang   = $('#kode_barang').val();
  var nama_barang   = $('#nama_barang').val();
  var satuan        = $('#satuan').val();
  var nama_kategori = $('#nama_kategori').val();
  var harga_beli    = $('#harga_beli').val();
  var jumlah        = $('#jumlah').val();
  var total_harga   = $('#total_harga').val();
  var tanggal       = $('#tanggal').val();
  if (kode_barang=='') {
    $('#kode_barang').focus();
    return false;
  }
  else if (kode_barang!='' && nama_barang=='') {
    bootbox.alert("Barang tidak ditemukan", function(){ 
    console.log(
    setTimeout(function() {
      $('#jumlah').val('');
      $('#kode_barang').focus();
    },200)
    ); 
    });
    return false;
  }
  else if (jumlah=='' || jumlah<1) {
    $('#jumlah').focus();
    return false;
  }
  else {
    $('#kode_barang').focus();
    $.ajax({
      type : "POST",
      url:"<?php echo base_url() . 'Beli_barang/insert_tmp_beli_barang'?>",
      data : 
      {
        no_nota:no_nota,
        kode_barang:kode_barang,
        nama_barang:nama_barang,
        satuan:satuan,
        nama_kategori:nama_kategori,
        harga_beli:harga_beli,
        jumlah:jumlah,
        total_harga:total_harga,
        tanggal:tanggal
      },
      success: function(data){
      if (data==1) {
        bootbox.alert(nama_barang+' sudah terinput', function(){ 
        console.log(
        setTimeout(function() {
          $('#nama_barang').val('');
          $('#satuan').val('');
          $('#nama_kategori').val('');
          $('#harga_beli').val('');
          $('#jumlah').val('');
          $('#total_harga').val('');
          $('#kode_barang').focus();
        },200)
        ); 
        });
        return false;
      }
      $("#datatable").DataTable().ajax.reload();
      setTimeout(function() {
      $('#kode_barang').focus();
      $('#nama_barang').val('');
      $("#kode_barang,#jumlah").keypress(function (e){
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
        }
      });
      },200);
      }
    });
  }
});

/*mulai Hapus isi table temp_beli_barang*/
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
          url: "<?php echo base_url() . 'Beli_barang/delete_product'?>",
          type: 'POST',
          method:"POST",
          data:{kode_barang:kode_barang},  
        })
        .done(function(data){
         $("#datatable").DataTable().ajax.reload();
        })
      }
   });    
}); 
/*selesai Hapus isi table temp_beli_barang*/
</script>

<!-- insert data last row -->
<script type="text/javascript">
$(document).on('click', '#save', function(event){
  event.preventDefault();
  var no_nota       = $('#no_nota').val();
  var kode_barang   = $('#kode_barang').val();
  var nama_barang   = $('#nama_barang').val();
  var satuan        = $('#satuan').val();
  var nama_kategori = $('#nama_kategori').val();
  var harga_beli    = $('#harga_beli').val();
  var jumlah        = $('#jumlah').val();
  var total_harga   = $('#total_harga').val();
  var tanggal       = $('#tanggal').val();
  var table         = $('#datatable').DataTable();
  var data          = table .rows() .data();
  var isi_table     = data.length;
  //validasi dan cek no nota yang sudah ada
  $.ajax({
    url: "<?php echo base_url() . 'Beli_barang/check_no_nota'?>",
    type : "POST",
    data:{no_nota:no_nota},
    dataType : "JSON",
    success: function(data){
      if (data>0)
      {
        bootbox.alert("Nomor nota sudah terdaftar.!", function(){ 
          console.log(
          setTimeout(function() {$('#no_nota').focus()},200)
          ); 
        });
        return false;
      }
      else 
      {
        if (isi_table=='1' && nama_barang=='') {
          return false;
        }
        else if (no_nota =='') {
        bootbox.alert("Mohon lengkapi nomor nota", function(){ 
          console.log(
          setTimeout(function() {$('#no_nota').focus()},1000)
          ); 
        });
        return false;
        }
        else if (kode_barang!='' && nama_barang!='' && jumlah=='') {
          $('#jumlah').focus();
          return false;
        }
        else if (kode_barang!='' && nama_barang=='') {
          return false;
        }
        else
        {
          $.ajax({
            type : "POST",
            url:"<?php echo base_url() . 'Beli_barang/insert_tmp_beli_barang'?>",
            data : 
            {
              no_nota:no_nota,
              kode_barang:kode_barang,
              nama_barang:nama_barang,
              satuan:satuan,
              nama_kategori:nama_kategori,
              harga_beli:harga_beli,
              jumlah:jumlah,
              total_harga:total_harga,
              tanggal:tanggal
            },
            //simpan data ke table pembelian dan det_pembelian  
            success: function(data){
              $("#datatable").DataTable().ajax.reload();
              $('#mdl_bayar').modal('show');
            }
          });
        }
      }
    }
  });
});
</script>

<!-- insert data -->
<script type="text/javascript">
  $(document).on('submit', '#add_bayar', function(event){
    event.preventDefault();
    var tipe_bayar      = $('#tipe_bayar').val();
    var no_nota         = $('#no_nota').val();
    var tanggal         = $('#tanggal').val();
    var jumlah_hutang   = $('#mdl_tot_bayar').val();
    var select_supplier = $("#select_supplier option:selected").text();
    if (tipe_bayar=='HUTANG') {
      if (select_supplier=='') {
        $('#select_supplier').select2('open');
        return false;
      }
      else if (jumlah_hutang=='') {
        $('#mdl_tot_bayar').focus();
        return false;
      }
      else{
        bootbox.confirm("Konfirmasi pembayaran",function(confirmed){
          if (confirmed) {
            $('#mdl_bayar').modal('hide');
            $.ajax({
            url: "<?php echo base_url() . 'Beli_barang/ins_pembelian'?>",
            type : "POST",
            dataType : "JSON",
            data : {tipe_bayar:tipe_bayar,no_nota:no_nota,select_supplier:select_supplier,jumlah_hutang:jumlah_hutang},
              success: function(data){
                location.reload();
              }
            })
          }
        }); 
      }
    }
    else if (tipe_bayar=='TUNAI') {
      bootbox.confirm("Konfirmasi pembayaran",function(confirmed){
        if (confirmed) {
          $('#mdl_bayar').modal('hide');
          $.ajax({
          url: "<?php echo base_url() . 'Beli_barang/ins_pembelian'?>",
          type : "POST",
          dataType : "JSON",
          data : {tipe_bayar:tipe_bayar,no_nota:no_nota,select_supplier:select_supplier,jumlah_hutang:jumlah_hutang},
            success: function(data){
              location.reload();
            }
          })
        }
      }); 
    }
  }); 
  //submit data
</script>

<!-- reset temp beli barang -->
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
          url: "<?php echo base_url() . 'Beli_barang/reset_form'?>",
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
      var no_nota   = $('#no_nota').val();
      if (no_nota=='') {
        $('#no_nota').focus();
        return false;
      }
      else{
        $('#mdl_cari_barang').modal('show');
      }
    });

    $('#mdl_cari_barang').on('shown.bs.modal', function(e) {
    $('#datatable2').DataTable( {
      "autoWidth": false,
      "ordering": false,
      "mark": true, 
      "scrollY"     : "400px",
      'lengthChange': true,
      "lengthMenu": [[30, 100, 200, -1], [50, 100, 200, "All"]],
      'paging'      : true,
      'searching'   : true,
      'info'        : false,
      dom: 'Blfrtip',
      processing: true,
           "language": {
          processing: '<div style="margin-top:-4px"><img src="images/index.gif" alt="" class=""><span> &nbsp;&nbsp;Loading... </span></div>'},
        "serverSide" : true,

        "ajax":{
          url :"<?php echo base_url() . 'Beli_barang/fetch_master_barang'; ?>", // json datasource
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
        var kode_barang   = cells[0].textContent;
        $('#mdl_cari_barang').modal('hide');
        $('#kode_barang').val(kode_barang);
        $('#jumlah').focus();
    });
  })
</script>

<!-- event modal bayar tampil -->
<script type="text/javascript">
  $(document).on('shown.bs.modal','#mdl_bayar', function (){
    $('#hidden_supp').hide();
    $('#hidden_bayar').hide();
    var no_nota = $("#no_nota").val();
    $.ajax({
      url: "<?php echo base_url() . 'Beli_barang/sum_total_beli'?>",
      type : "POST",
      success: function(data){
      $("#mdl_total").val(data);
      $("#mdl_no_nota").val(no_nota);
      }
    }) 
    //format hanya angka
    $("#kode_barang,#harga_beli,#harga_jual,#harga_grosir").keypress(function (e){
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    });
    //format hanya angka
    $('#add_bayar')[0].reset();
    $("#select_supplier").html('');
    //select tipe bayar
    $('#tipe_bayar').select2({
      placeholder: '--- Pilih tipe ---',
      
    });
    //select supplier
    $('#select_supplier').select2({
      placeholder: '--- Pilih supplier ---',
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
  $(document).on('change', '#tipe_bayar', function(event){
    var tipe_bayar = $("#tipe_bayar option:selected").html();
    if (tipe_bayar=='HUTANG') {
      $('#hidden_supp').show();
      $('#hidden_bayar').show();
    }
    else{
      $('#hidden_supp').show();
      $('#hidden_bayar').hide();
    }
  })
</script>

<!-- modal cari barang-->
<div class="modal modal-danger fade" id="mdl_cari_barang" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">CARI BARANG</h4>
      </div>
      <div class="modal-body"  style="background-color: white!important;">
        <table id="datatable2" class="table table-bordered table-condensed" style="color: black">
          <thead>
            <tr class="bg-gray">
              <th>KODE_BARANG</th>        
              <th>NAMA_BARANG</th>
              <th>SATUAN</th>
              <th>KATEGORI</th>
              <th>STOCK</th>
              <th>HRG_JUAL</th>
              <th>GROSIR</th>
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

<!-- modal bayar -->
<div class="modal modal-info fade" id="mdl_bayar" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">FORM PEMBAYARAN</h4>
      </div>

      <div class="modal-body"  style="background-color: white!important;">
        <form class="form-horizontal" id="add_bayar">
          <div class="box-body">
           <!--  <div class="form-group">
              <label for="inputPassword3" class="col-sm-3 control-label text-blue">NO_NOTA</label>
              <div class="col-sm-8">
                <input type="text" id="mdl_no_nota" name="mdl_no_nota" required="" class="form-control input-sm bg-gray" readonly="">
              </div>
            </div> -->
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-3 control-label text-blue">TOTAL TAGIHAN</label>
              <div class="col-sm-8">
                <input type="text" id="mdl_total" name="mdl_total" required="" class="form-control input-sm bg-gray" readonly="">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-3 control-label text-blue">TIPE_PEMBAYARAN</label>
              <div class="col-sm-8">
                <select class="form-control select2 option-sm" id="tipe_bayar" name="tipe_bayar" required="" style="width: 100%;">
                    <option></option>
                    <option>TUNAI</option>
                    <option>HUTANG</option>
                    </select>
              </div>
            </div>
            <div class="form-group" id="hidden_supp">
              <label for="inputPassword3" class="col-sm-3 control-label text-blue">SUPPLIER</label>
              <div class="col-sm-8">
                <select name="select_supplier" class="form-control select2" id="select_supplier" required="" style="width: 100%;">
                <option value=""></option>
              </select>
              </div>
            </div>

            <div class="form-group" id="hidden_bayar">
              <label for="inputPassword3" class="col-sm-3 control-label text-blue">JUMLAH_HUTANG</label>
              <div class="col-sm-8">
                <input type="text" id="mdl_tot_bayar" name="mdl_tot_bayar" class="form-control input-sm" autocomplete="off">
              </div>
            </div>
            <div class="callout callout-warning">
                <h4>Warning :</h4>
                <p>Masukkan data yang benar</p>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline btn pull-left" data-dismiss="modal">Cancel [esc]</button>
        <button type="submit" id="submit_bayar" class="btn btn-outline">Save [enter]</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<style type="text/css">
#datatable2 tbody tr:hover td, #datatable2 tbody tr:hover th {
  background-color: #ccccff;
}
input 
{
  border:1px solid white;
  padding: 3px;
}
</style>


