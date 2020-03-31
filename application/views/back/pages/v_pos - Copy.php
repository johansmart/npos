<?php $this->load->view('back/meta') ?>
<?php $this->load->view('back/head') ?>
<!-- Datatable -->
<!-- <link rel="stylesheet" href="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables.net/css/dataTables.dt"> -->
<link rel="stylesheet" href="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- <link rel="stylesheet" href="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables.net-keytable/css/datatable.css"> -->
<?php $this->load->view('back/sidebar') ?>


<!-- content -->
<div class="wrapper">
  <div class="content-wrapper">
    <section class="content">
      <div class="box box-default color-palette-box">
        <div class="box-header with-border" style="font-size: 14px">
          <i class="fa fa-calendar-times-o text-blue"></i> Date : <?php echo date('d-m-Y');?>&nbsp;&nbsp;<i class="fa fa-clock-o text-blue"></i><span id="clock"></span>&nbsp;&nbsp;<i class="fa fa-user text-blue"></i> UserID : <?php echo $this->session->userdata('id_karyawan');?>&nbsp;&nbsp;<i class="fa fa-paw text-blue"></i> UserName : <?php echo $this->session->userdata('user_name');?>&nbsp;&nbsp;<i class="fa fa-briefcase text-blue"></i> POS : 1001&nbsp;&nbsp;
        </div>
      </div>

      <div class="box box-default color-palette-box" style="margin-top: -15px;">
        <div class="box-body">
          <div class="col-md-4" style="margin-left: -15px">
            <form id="add_item">
              <input class="form-control input-sm" id="barcode" autocomplete="off" autofocus="" type="text" required=""  placeholder=".Scan barcode..." style="background-color:#ffffe6;">
            </form>
          </div>

          <!-- <div class="col-md-3" style="margin-left: -15px">
              <input class="form-control input-sm" id="cari_barang" autocomplete="off" type="text" placeholder="Cari barang..." style="background-color:#ffffe6;">
          </div> -->
         
          <input class="form-control input-sm" id="id" readonly="" type="hidden">
          <input class="form-control input-sm" id="hide_barcode" readonly="" type="hidden">
          <input class="form-control input-sm" id="hide_prc" readonly="" type="hidden">
          <input class="form-control input-sm" id="hide_qty" readonly="" type="hidden">
          <input class="form-control input-sm" id="remark" readonly="" type="hidden">
          <input class="form-control input-sm" id="status_modal" readonly="" type="hidden">
          
          <div class="col-md-8 col-sm-12 bg-gray" style="font-size: 22px;">
            <span id="description">...</span>
          </div>
        </div>
      </div>

      <div class="box box-default color-palette-box" style="margin-top: -15px;">
        <div class="box-header with-border">
          <table id="example" class="table " style="">
              <thead class="">
                <tr>
                  <th>NO</th>
                  <th>KODE BARANG</th>
                  <th>NAMA BARANG</th>
                  <th>HARGA</th>
                  <th>JUMLAH</th>
                  <th>TOTAL</th>
                  <th>DISKON</th>
                  <th>GRAND_TOTAL</th>
                  <th>KETERANGAN</th>
                </tr>
              </thead>
              <tbody>
              </tbody>  
          </table>
        </div>
        
        <!-- /.box-body -->
      </div>

      <div class="box box-default color-palette-box" style="margin-top: -15px;">
        <div class="box-header with-border">
            <div class="col-md-8" style="border: 0.1px;border-style: dotted;"><br>
              <a class="btn btn-app"  id="void">
                <i class="fa fa-remove text-red"></i> Batal[V]
              </a>
              <a class="btn btn-app" id="add_qty">
                <i class="fa fa-cart-plus text-blue"></i> Add_qty[Q]
              </a>
              <a class="btn btn-app" id="hrg_grosir">
                <i class="fa fa-exchange text-green"></i> Set_grosir[G]
              </a>
              <a class="btn btn-app" id="clear">
                <i class="fa fa-trash text-red"></i> Clear [R]
              </a>
              <a class="btn btn-app" id="save_trx">
                <i class="fa fa-save text-yellow"></i> Save_trx [S]
              </a>
              <a class="btn btn-app" id="call_trx">
                <i class="fa fa-refresh text-green"></i> Call-trx [F8]
              </a>
              <a class="btn btn-app" id="bayar">
                <i class="fa fa-money text-blue"></i> Bayar [F2]
              </a>
              <a class="btn btn-app" id="rbh_harga">
                <i class="fa fa-strikethrough text-blue"></i> Rbh_hrg [U]
              </a>
              <a class="btn btn-app" id="rbh_grosir">
                <i class="fa fa-strikethrough text-red"></i> Rbh_gsir[I]
              </a>
              <a class="btn btn-app" id="search_prod">
                <i class="fa fa-search text-orange"></i> Cari_brg[F4]
              </a>
              <a class="btn btn-app">
                <i class="fa fa-ban text-grey"></i> 
              </a>
              <a class="btn btn-app">
                <i class="fa fa-ban text-grey"></i> 
              </a>
              <!-- <a class="btn btn-app">
                <i class="fa fa-ban text-grey"></i> 
              </a>
              <a class="btn btn-app">
                <i class="fa fa-ban text-grey"></i> 
              </a> -->
            </div>
            <div class="col-md-4" style="font-size: 20px;border: 0.1px;border-style: dotted;border-left: none">
              <table id="" class="table">
                <tr class="text-black">
                  <td style="background-color:#ffffe6">Total</td>
                  <td style="background-color:#ffffe6">:</td>
                  <td align="right" id="total" style="background-color:#ffffe6"></td>
                </tr>
                <tr class="text-black">
                  <td>Diskon</td>
                  <td>:</td>
                  <td align="right" id="diskon"></td>
                </tr>
                <tr class="text-white bg-red">
                  <td id="g_total">Grand_total</td>
                  <td>:</td>
                  <td align="right" id="grand_total"></td>
                </tr>
              </table>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box box-default color-palette-box">
            <div class="box-header with-border bg-black" style="font-size: 14px;">
              <span>TRANSAKSI TERAKHIR : TOTAL : <span id="lt_total"></span> | BAYAR : <span id="lt_bayar"></span>  | KEMBALI : <span id="lt_kembali"></span>| PENJUALAN ID  <?php echo $this->session->userdata('id_karyawan');?>  : <span id="sales_kasir"></span>
            </div>
        </div>
      </div>

    </section>
  </div>
</div>
<!-- content -->

<?php $this->load->view('back/footer') ?>
<?php $this->load->view('back/js') ?>
<!-- datatable -->
<script src="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<!-- highlight datatable -->
<script src="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables_mark/datatables.mark.js"></script>
<script src="<?php echo base_url('assets/template/backend/') ?>bower_components/datatables_mark/jquery.mark.min.js"></script>
<!-- key shorcut js -->
<script src="<?php echo base_url('assets/template/backend/') ?>bower_components/key_shorcut/shortcut.js"></script>
 <!-- jquery mask -->
<script src="<?php echo base_url('assets/template/backend/') ?>bower_components/jquery_mask/jquery.mask.js"></script>

<!-- higlight rowcolor jika resresh -->
<script type="text/javascript">
  function loadRowColor_refresh(){
    setTimeout(function(){
    var barcode = $("#example").find("tr:last td:eq(1)").text();
    $("#hide_barcode").val(barcode)
    var iNum = parseInt($('#hide_barcode').val());
      var elems = $('.no_select').filter(function(){
       return this.textContent == iNum;
      }).click();
    //auto scroll buttom datatable
      var table= $("#example").DataTable();
      var $scrollBody = $(table.table().node()).parent();
      $scrollBody.scrollTop($scrollBody.get(0).scrollHeight);
      //auto scroll buttom datatable  
    },1000);
   } 
</script>

<!-- menampilkan transaksi terakhir -->
<script type="text/javascript">
  $(document).ready(function (){
    //jam
    startTime();
    //load row color
    loadRowColor_refresh();
    //disable shorcut agar tidak mengganggu tampilan
    shortcut.add("f1", function(){
      return false;
    });
    shortcut.add("f5", function(){
      return false;
    });
    shortcut.add("f12", function(){
      return false;
    });
    shortcut.add("f3", function(){
      return false;
    });
    //disable shorcut agar tidak mengganggu tampilan
    function commaSeparateNumber(val){
      while (/(\d+)(\d{3})/.test(val.toString())){
        val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
      }
      return val;
    }
    $.ajax({
      url: "<?php echo base_url() . 'Pos/last_trx'?>",
      type : "POST",
      dataType : "JSON",
        success: function(data){
          $('#lt_total').html(commaSeparateNumber(data[0]));
          $('#lt_bayar').html(commaSeparateNumber(data[1]));
          $('#lt_kembali').html(commaSeparateNumber(data[2]));
        }
    })
    $.ajax({
      url: "<?php echo base_url() . 'Pos/get_sales_kasir'?>",
      type : "POST",
      dataType : "JSON",
        success: function(data){
          $('#sales_kasir').html(data);
        }
    })
  });
</script>

<!-- datatable fetch data temp_input -->
<script type="text/javascript">
  $(document).ready(function (){
    //kalkulasi total
    total();
    diskon();
    grand_total();
    //kalkulasi total  
    loadRowColor();
    var table = $('#example').DataTable({
      "autoWidth": false, 
      scrollY: 210,
      scrollX: false,
      "lengthMenu": [[100, 200, 300, -1], [100, 200, 300, "All"]],
      'lengthChange': false,
      'searching'   : false,
      'info'        : false,
      'paging': false,
      "ordering":false,
      "lengthChange": false,
      stripeClasses:[],
      processing: true,
      "language": {
       processing: '<div class="bg-gray text-red" style="margin-top:30px;font-size:15px;height:30px;padding-top:3px;z-index:1"><span> &nbsp;&nbsp;Processing... </span></div>'
        },
            //serverSide : true,
        ajax: '<?php echo base_url() . 'Pos/fetch_temp_trx_pos'; ?>',
        //shorcut button
        keys: {
           keys: [ 13 /* ENTER */, 38 /* UP */, 40 /* DOWN */, 86 /* V */, 81 /* Q */, 71 /* G */, 82 /* R */,83 /* S */,113 /* F2 */,85 /* U */,73 /* I */]
        },
        //shorcut button
        // mewarnai cell batal
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          switch(aData[8]){
          case 'Batal':
          $(nRow).css('background-color', '#ffddcc')
          break;
          }
        }
    });
    // Handle event when cell gains focus
    $('#example').on('key-focus.dt', function(e, datatable, cell){
        // Select highlighted row
        //table.row(cell.index().row).select();
        table.row(cell.index().row).select();
        var data    = table.row(cell.index().row).data();
        var id      = (data[0]);
        var barcode = (data[1]).replace(/\D/g, '');
        var desc    = (data[2]);
        var price   = (data[3]);
        var qty     = (data[4]);
        var remark  = (data[8]);
        number      = barcode;
        $("#description").html(desc);
        $("#hide_barcode").val(number);
        $("#hide_prc").val(price);
        $("#hide_qty").val(qty);
        $("#remark").val(remark);
        $("#id").val(id);
        if ( data[8] == "Batal" ) {        
             $(table.row(cell.index().row).node()).addClass('replace_color');
           }
    });

    // Handle event when cell looses focus
    $('#example').on('key-blur.dt', function(e, datatable, cell){
        // Deselect highlighted row
        $(table.row(cell.index().row).node()).removeClass('selected');
        $(table.row(cell.index().row).node()).removeClass('replace_color');
    });
        
    // Handle key event that hasn't been handled by KeyTable
    $('#example').on('key.dt', function(e, datatable, key, cell, originalEvent){
        // If ENTER key is pressed
        var status_modal = $('#status_modal').val();
        if(key === 86 && status_modal!='open')
        {
          $('#void').trigger('click')
          $('#barcode').val('');
        }
        else if (key === 81 && status_modal!='open')
        {
          $('#add_qty').trigger('click')
          $('#barcode').val('');
        }
        else if (key === 71 && status_modal!='open')
        {
          $('#hrg_grosir').trigger('click')
          $('#barcode').val('');
        }
        else if (key === 82 && status_modal!='open')
        {
          $('#clear').trigger('click')
          $('#barcode').val('');
        }
        else if (key === 83 && status_modal!='open')
        {
          $('#save_trx').trigger('click')
          $('#barcode').val('');
        }
        else if (key === 113 && status_modal!='open')
        {
          $('#bayar').trigger('click')
          $('#barcode').val('');
        }
        else if (key === 85 && status_modal!='open')
        {
          $('#rbh_harga').trigger('click')
          $('#barcode').val('');
        }
        else if (key === 73 && status_modal!='open')
        {
          $('#rbh_grosir').trigger('click')
          $('#barcode').val('');
        }
    });
  });
</script>

<!-- insert item ke tbl temp_trx_pos -->
<script type="text/javascript">
  $(document).on('submit', '#add_item', function(event){  
    event.preventDefault();  
    var barcode = $('#barcode').val();  
    $.ajax({  
      url:"<?php echo base_url() . 'Pos/add_item'?>",  
      method:'POST',  
      data:{barcode:barcode},   
      success:function(data)  
      {  
        $("#hide_barcode").val(barcode);
        if (data=='') {
          $("#description").html('Barang tidak ditemukan !');
          $("#barcode").val('');
        }
        else{
          $("#example").DataTable().ajax.reload();
          //kalkulasi total
          total();
          diskon();
          grand_total();
          //kalkulasi total
          loadRowColor();
          $("#barcode").val('');
          
        }
      }  
    }); 
  });
</script>

<!-- higlight row color dan kalkulasi total-->
<script type="text/javascript">
  function loadRowColor(){
    setTimeout(function(){
      //function for highlight row
      /*convert string to number*/
      var iNum = parseInt($('#hide_barcode').val());
      var elems = $('.no_select').filter(function(){
       return this.textContent == iNum;
      }).click();
      //function for highlight row

      //auto scroll buttom datatable
      var table= $("#example").DataTable();
      var $scrollBody = $(table.table().node()).parent();
      $scrollBody.scrollTop($scrollBody.get(0).scrollHeight);
      //auto scroll buttom datatable
    },300);
  } 
  function total(){
    $.ajax({  
      url:"<?php echo base_url() . 'Pos/total'?>",  
      method:'POST',    
      success:function(data)  
      { 
        $("#total").html(data);
      }  
    }); 
  }
  function diskon(){
    $.ajax({  
      url:"<?php echo base_url() . 'Pos/diskon'?>",  
      method:'POST',    
      success:function(data)  
      { 
        $("#diskon").html(data);
      }  
    }); 
  }
  function grand_total(){
    $.ajax({  
      url:"<?php echo base_url() . 'Pos/grand_total'?>",  
      method:'POST',    
      success:function(data)  
      { 
        $("#grand_total").html(data);
      }  
    }); 
  }
</script>

<!-- event klik button batal -->
<script type="text/javascript">
  $('#void').click(function(){
    var table = $('#example').DataTable();
    var data = table .rows().data();
    var isi_table = data.length;
    var remark = $("#remark").val();
    if (isi_table=='0')
    {
      $("#barcode").focus();
      return false;
    }
    else if (remark=='Batal') 
    {
      $("#barcode").focus();
      loadRowColor();
      return false;
    }
    else
    {
    var id = $('#id').val();
    $.ajax({  
      url:"<?php echo base_url() . 'Pos/product_batal'?>",  
      method:'POST',  
      data:{id:id},   
      success:function(data)  
      {  
        $("#example").DataTable().ajax.reload();
        //kalkulasi total
        total();
        diskon();
        grand_total();
        //kalkulasi total
        loadRowColor();
        $("#barcode").focus();
      }
     });
     }    
  });
</script>

<!-- event klik button add_qty -->
<script type="text/javascript">
  $(document).ready(function (){
    $('#add_qty').click(function(){
      var table = $('#example').DataTable();
      var data = table .rows().data();
      var isi_table = data.length;
      var remark = $("#remark").val();
      if (isi_table=='0')
      {
        $("#barcode").focus();
        return false;
      }
      else if (remark=='Batal') 
      {
      $("#barcode").focus();
      loadRowColor();
      return false;
      }
      else
      {
        $('#mdl_add_qty').modal('show');
      }
    });

    $('#mdl_add_qty').on('shown.bs.modal', function(e) {
      loadRowColor();
      var id    = $('#id').val();
      var qty   = $('#hide_qty').val();
      var desc  = $('#description').html();
      $("#tmbah_qty").val('');
      $('#id_add_qty').val(id);
      $('#prod_name').val(desc);
      $('#jumlah_qty').val(qty);
      $('#tmbah_qty').focus();
    })
    $('#mdl_add_qty').on('hide.bs.modal', function(e) {
      $("#barcode").focus();
      $("#barcode").val('');
      loadRowColor();
    });
    //focus barcode on hide bootbox
    $(document).on('hidden.bs.modal','.bootbox', function () {
        loadRowColor();
       $('#barcode').focus();
    });
    $('#submit').click(function(){
      event.preventDefault();
      var id         = $('#id').val();
      var tambah_qty = $('#tmbah_qty').val();
      if (tambah_qty=='')
      {
        $('#tmbah_qty').focus();
        return false;
      }
      else
      {
        $.ajax({
        type : "POST",
        url:"<?php echo base_url() . 'Pos/add_qty'?>",
        dataType : "JSON",
        data : {id:id , tambah_qty:tambah_qty},
        success: function(data){
          $('#mdl_add_qty').modal('hide');
          $("#example").DataTable().ajax.reload();
          //kalkulasi total
          total();
          diskon();
          grand_total();
          //kalkulasi total
        }
      });
      }
    });
  })  
</script>

<!-- event klik button hrg_grosir -->
<script type="text/javascript">
  $('#hrg_grosir').click(function(){
    var table = $('#example').DataTable();
    var data = table .rows().data();
    var isi_table = data.length;
    var remark = $("#remark").val();
    if (isi_table=='0')
    {
      $("#barcode").focus();
      return false;
    }
    else if (remark=='Batal') 
    {
    $("#barcode").focus();
    loadRowColor();
    return false;
    }
    else
    {
    var id = $('#id').val();
    $.ajax({  
      url:"<?php echo base_url() . 'Pos/set_harga_grosir'?>",  
      method:'POST',  
      data:{id:id},   
      success:function(data)  
      {  
        if (data==0)
        {
          loadRowColor();
          setTimeout(function(){
            $('#description').html('Barang ini tidak mempunya harga grosir !');
          },200);
          return false;
        }
        else
        {
          $("#example").DataTable().ajax.reload();
          //kalkulasi total
          total();
          diskon();
          grand_total();
          //kalkulasi total
          loadRowColor();
          $("#barcode").focus();
        }
      }
     });
    }    
  });
</script>

<!-- event klik button clear -->
<script type="text/javascript">
  $('#clear').click(function(){
    var table = $('#example').DataTable();
    var data = table .rows().data();
    var isi_table = data.length;
    if (isi_table=='0')
    {
      $("#barcode").focus();
      return false;
    }
    else
    {
      bootbox.confirm("Hapus transaksi ?",function(confirmed){
        if (confirmed) {
          $.ajax({
          url: "<?php echo base_url() . 'Pos/clear_tmp_trx'?>",
            success: function(data){
              location.reload();
            }
          })
        }
      }); 
    }
  });
</script>

<!-- event klik button save_trx -->
<script type="text/javascript">
  $('#save_trx').click(function(){
    var table = $('#example').DataTable();
    var data = table .rows().data();
    var isi_table = data.length;
    if (isi_table=='0')
    {
      $("#barcode").focus();
      return false;
    }
    else
    {
      bootbox.confirm("Simpan transaksi ?",function(confirmed){
        if (confirmed) {
          $.ajax({
          url: "<?php echo base_url() . 'Pos/simpan_trx'?>",
            success: function(data){
              location.reload();
            }
          })
        }
      }); 
    }
  });
</script>

<!-- event klik button call_trx -->
<script type="text/javascript">
  $('#call_trx').click(function(){
    var table = $('#example').DataTable();
    var data = table .rows().data();
    var isi_table = data.length;
    if (isi_table>0)
    {
      $("#barcode").focus();
      loadRowColor();
      return false;
    }
    else
    {
      bootbox.confirm("Panggil transaksi ?",function(confirmed){
        if (confirmed) {
          $.ajax({
          url: "<?php echo base_url() . 'Pos/call_trx'?>",
            success: function(data){
              $("#example").DataTable().ajax.reload();
              loadRowColor_refresh();
              //kalkulasi total
              total();
              diskon();
              grand_total();
              //kalkulasi total
            }
          })
        }
      }); 
    }
  });
  //menggunakan external shorcut 
  shortcut.add("f8", function() {
      $('#call_trx').click();
  }); 
</script>

<!-- event klik button bayar -->
<script type="text/javascript">
  $(document).ready(function (){
    //jquery mask format angka koma
    $('#mdl_tot_bayar').mask('000,000,000,000,000', {reverse: true});
    //jquery mask format angka koma
    $('#bayar').click(function(){
    //cegah modal bayar tampil pada saat modal kembali tampil
    var mdl_kembali = $('#mdl_kembali').hasClass('in');
    if (mdl_kembali==true)
    {
      return false
    }
    //cegah modal bayar tampil pada saat modal kembali tampil
      var table = $('#example').DataTable();
      var data = table .rows().data();
      var isi_table = data.length;
      var grand_total = $('#grand_total').html();
      if (isi_table==0)
      {
        $("#barcode").focus();
        loadRowColor();
        return false;
      }
      else if (grand_total==0) 
      {
        $("#barcode").focus();
        return false;
      }
      else
      {
        $('#mdl_bayar').modal('show');
        $('#mdl_bayar').on('shown.bs.modal', function(e) {
          $('#status_modal').val('open');
          var total = $('#grand_total').html();
          $('#mdl_total').val(total);
          $('#mdl_tot_bayar').focus();
        });
        $('#mdl_bayar').on('hide.bs.modal', function(e) {
          $('#status_modal').val('');
          $("#mdl_tot_bayar").val('');
          $("#mdl_kembali").val('');
          loadRowColor();
          $("#barcode").focus();
          $("#barcode").val('');
        });
        $(document).on('hidden.bs.modal','.bootbox', function () {
          $('#mdl_tot_bayar').focus();
        });
        //kalkulasi total - bayar
        $("#mdl_tot_bayar").keyup(function(){
          $("#msg").html('')
          var convert_tot = parseInt($("#mdl_total").val().replace(/,/g,'')); 
          var convert_byr = parseInt($("#mdl_tot_bayar").val().replace(/,/g,''));
          var kembali = convert_byr-convert_tot;
        });
        //kalkulasi total - bayar
      }
      //submit data
      $('#submit_bayar').click(function(){
      event.preventDefault();
      var convert_tot = parseInt($("#mdl_total").val().replace(/,/g,'')); 
      var convert_byr = parseInt($("#mdl_tot_bayar").val().replace(/,/g,''));
      var kembali = convert_byr-convert_tot;
      //var kembali = parseInt($("#mdl_kembali").val().replace(/,/g,''));
      if (kembali<0)
      {
        $("#mdl_tot_bayar").focus()
        $("#msg").html('PEMBAYARAN TIDAK MENCUKUPI !')
      }
      else if ($("#mdl_tot_bayar").val()=='') 
      {
        $("#mdl_tot_bayar").focus()
      }
      else
      {
        var nilai_bayar = $("#mdl_tot_bayar").val().replace(/,/g, '')
        var bayar = parseInt(nilai_bayar);
        bootbox.hideAll();
        bootbox.confirm("Konfirmasi pembayaran "+nilai_bayar ,function(confirmed){
          if (confirmed) {
            $('#mdl_bayar').modal('hide');
            $.ajax({
            url: "<?php echo base_url() . 'Pos/ins_penjualan'?>",
            type : "POST",
            dataType : "JSON",
            data : {bayar:bayar},
              success: function(data){
                $.ajax({
                  url: "<?php echo base_url() . 'Pos/clear_tmp_trx'?>",
                  })
                $('#mdl_kembali').modal('show');
              }
            })
          }
        }); 
      }
    });
    //submit data
    });
  }); 
</script>

<!-- event klik button lanjut modal kembali -->
<script type="text/javascript">
  $(document).ready(function (){
    $('#mdl_kembali').on('shown.bs.modal', function(e) {
      shortcut.add("enter", function() {
        $('#submit_kembali').click()
      });
      $.ajax({
        url: "<?php echo base_url() . 'Pos/kembalian'?>",
        type : "POST",
        dataType : "JSON",
        success: function(data){
          $('#msg_kembalian').html('Rp. '+data)
        }
      })
      
      $('#submit_kembali').click(function(){
          $('#mdl_kembali').modal('hide');
          //ajax call
          $.ajax({
            url: "<?php echo base_url() . 'Pos/clear_tmp_trx'?>",
            type : "POST",
            dataType : "JSON",
              success: function(data){
                //print faktur
                $.ajax({
                  url: "<?php echo base_url() . 'Print_faktur/direct_print'?>",
                  type : "POST",
                  dataType : "JSON",
                  success: function(data){
                    location.reload()
                  }
                })
              }
          })
       }); 
    });
  }); 
</script>

<!-- event klik button rubah harga -->
<script type="text/javascript">
  $(document).ready(function (){
    $('#rbh_harga').click(function(){
      //cegah modal rubah harga tampil pada saat modal kembali tampil
      var mdl_kembali = $('#mdl_kembali').hasClass('in');
      if (mdl_kembali==true)
      {
        return false
      }
      //cegah modal harga tampil pada saat modal kembali tampil
      var table = $('#example').DataTable();
      var data = table .rows().data();
      var isi_table = data.length;
      var remark = $("#remark").val();
      if (isi_table=='0')
      {
        $("#barcode").focus();
        return false;
      }
      else if (remark=='Batal') 
      {
      $("#barcode").focus();
      loadRowColor();
      return false;
      }
      else
      {
        $('#mdl_rubah_harga').modal('show');
      }
    });

    $('#mdl_rubah_harga').on('shown.bs.modal', function(e) {
      var barcode    = $('#hide_barcode').val();
      var price      = $('#hide_prc').val();
      var prod_name  = $('#description').html();
      $('#barcode_chg_prc').val(barcode);
      $('#prod_name_chg_prc').val(prod_name);
      $("#price").val(price);
      $('#chg_prc').val('');
      $('#chg_prc').focus();
    })
    $('#mdl_rubah_harga').on('hide.bs.modal', function(e) {
      loadRowColor();
      $("#barcode").focus();
      $("#barcode").val('');
    });
    //focus barcode on hide bootbox
    $('#submit_chg').click(function(){
      event.preventDefault();
      var barcode_chg_prc  = $('#barcode_chg_prc').val();
      var chg_prc = $('#chg_prc').val();
      if (chg_prc=='')
      {
        $('#chg_prc').focus();
        loadRowColor();
        return false;
      }
      else
      {
        $.ajax({
        type : "POST",
        url:"<?php echo base_url() . 'Pos/change_price'?>",
        dataType : "JSON",
        data : {barcode_chg_prc:barcode_chg_prc , chg_prc:chg_prc},
        success: function(data){
          $('#mdl_rubah_harga').modal('hide');
          $("#example").DataTable().ajax.reload();
          //kalkulasi total
          total();
          diskon();
          grand_total();
          //kalkulasi total
        }
      });
      }
    });
  })  
</script>

<!-- event klik button rubah harga grosir -->
<script type="text/javascript">
  $(document).ready(function (){
    $('#rbh_grosir').click(function(){
      //cegah modal rubah harga tampil pada saat modal kembali tampil
      var mdl_kembali = $('#mdl_kembali').hasClass('in');
      if (mdl_kembali==true)
      {
        return false
      }
      //cegah modal harga tampil pada saat modal kembali tampil
      var table = $('#example').DataTable();
      var data = table .rows().data();
      var isi_table = data.length;
      var remark = $("#remark").val();
      if (isi_table=='0')
      {
        $("#barcode").focus();
        return false;
      }
      else if (remark=='Batal') 
      {
      $("#barcode").focus();
      loadRowColor();
      return false;
      }
      else
      {
        $('#mdl_rubah_grosir').modal('show');
      }
    });

    $('#mdl_rubah_grosir').on('shown.bs.modal', function(e) {
      var barcode    = $('#hide_barcode').val();
      var price      = $('#hide_prc').val();
      var prod_name  = $('#description').html();
      $('#barcode_chg_grosir').val(barcode);
      $('#prod_name_chg_grosir').val(prod_name);
      $("#price_grosir").val(price);
      $('#chg_grosir').val('');
      $('#chg_grosir').focus();
    })
    $('#mdl_rubah_grosir').on('hide.bs.modal', function(e) {
      loadRowColor();
      $("#barcode").focus();
      $("#barcode").val('');
    });
    //focus barcode on hide bootbox
    $('#submit_grosir').click(function(){
      event.preventDefault();
      var barcode_chg_grosir  = $('#barcode_chg_grosir').val();
      var chg_grosir = $('#chg_grosir').val();
      if (chg_grosir=='')
      {
        $('#chg_grosir').focus();
        loadRowColor();
        return false;
      }
      else
      {
        $.ajax({
        type : "POST",
        url:"<?php echo base_url() . 'Pos/change_price_grosir'?>",
        dataType : "JSON",
        data : {barcode_chg_grosir:barcode_chg_grosir , chg_grosir:chg_grosir},
        success: function(data){
          $('#mdl_rubah_grosir').modal('hide');
          $("#example").DataTable().ajax.reload();
          //kalkulasi total
          total();
          diskon();
          grand_total();
          //kalkulasi total
        }
      });
      }
    });
  })  
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
          url :"<?php echo base_url() . 'Pos/fetch_master_barang'; ?>", // json datasource
          type: "post",
            // method  , by default get
        },
        initComplete: function () {
          $('#datatable2_filter label input').focus();
        }
      });
    });
    $('#mdl_cari_barang').on('hide.bs.modal', function(e) {
      loadRowColor();
      $("#barcode").focus();
      $("#barcode").val('');
      $('#datatable2').DataTable().clear().destroy();
    });
    //memindahkan kode barang search barang ke scan barcode
    $(document).on('click', '#barcode', function(event){  
        var currentRow    = $(this).closest("tr")[0]; 
        var cells         = currentRow.cells;
        var kode_barang       = cells[0].textContent;
        $('#mdl_cari_barang').modal('hide');
        $('#barcode').val(kode_barang);
        $('#add_item').submit();
    });
  })
  //menggunakan external shorcut 
  shortcut.add("f4", function() {
    $('#search_prod').click();
  });  
</script>

<!-- modal kembali -->
<script type="text/javascript">
  $(document).ready(function (){
  $('#mdl_kembali').on('shown.bs.modal', function(e) {
      $('#mdl_add_qty').modal('hide');
      //alert('ok');
    })
  })
</script>

<!-- number only forinput barcode -->
<script type="text/javascript">
  $("#barcode,#tmbah_qty").keypress(function (e){
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
  });
</script>

<!-- control modal open agar modal lain tidak ikut terbuka -->
<script type="text/javascript">
  $(document).on('show.bs.modal', '.modal', function () {
    $('#status_modal').val('open');
  })
  $(document).on('hide.bs.modal', '.modal', function () {
    $('#status_modal').val('');
  })
</script>

<!-- modal add qty -->
<div class="modal modal-info fade" id="mdl_add_qty" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom-style: solid;border-bottom-color: blue;border-width: 1px">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">TAMBAH JUMLAH</h4>
      </div>

      <div class="modal-body"  style="background-color: white!important;">
        <form class="form-horizontal" id="add_entri">
          <div class="box-body">

            <input type="hidden" class="form-control" id="id_add_qty" name="id_add_qty" readonly="">

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label text-blue">Product_name</label>
              <div class="col-sm-10">
                <input type="text" id="prod_name" name="prod_name" required="" class="form-control" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label text-blue">Jumlah</label>
              <div class="col-sm-10">
                <input type="text" id="jumlah_qty" name="jumlah_qty" required="" class="form-control" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label text-blue">Tambah</label>
              <div class="col-sm-10">
                <input type="number" id="tmbah_qty" autocomplete="off" name="tmbah_qty" class="form-control" placeholder="Tambahkan jumlah..." required="">
              </div>
            </div>
          </div>
          <!-- /.box-body -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline btn pull-left" data-dismiss="modal">Cancel [esc]</button>
        <button type="submit" id="submit" class="btn btn-outline">Tambah [enter]</button>
      </div>
      </form>
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
        <form class="form-horizontal" id="add_entri">
          <div class="box-body">

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label text-blue">TOTAL TAGIHAN</label>
              <div class="col-sm-10">
                <input type="text" id="mdl_total" name="mdl_total" required="" class="form-control input-lg" readonly="" style="font-size: 30px;">
              </div>
            </div>

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label text-blue">BAYAR</label>
              <div class="col-sm-5">
                <input type="text" id="mdl_tot_bayar" name="mdl_tot_bayar" class="form-control input-lg" required="" autocomplete="off" style="font-size: 30px;" >
              </div>

              <label for="inputPassword3" class="col-sm-5 control-label" style="margin-left: -20px"><span class="text-red" id="msg"></span></label>
            </div>
            <div class="callout callout-warning">
                <h4>Warning :</h4>
                <p>Masukkan pembayaran yang benar</p>
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

<!-- modal kembalian -->
<div class="modal modal-info fade" id="mdl_kembali" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"  aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>

      <div class="modal-body"  style="background-color: white!important;">
            <div class="callout callout-danger text-black">
              <h4>Kembalian :</h4>
              <p style="font-size: 60px" class="text-right" id="msg_kembalian"></p>
          </div>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-outline btn pull-left" data-dismiss="modal">Cancel [esc]</button> -->
        <button type="submit" id="submit_kembali" class="btn btn-outline">Lanjut [enter]</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- modal rubah harga -->
<div class="modal modal-info fade" id="mdl_rubah_harga" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom-style: solid;border-bottom-color: blue;border-width: 1px">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">FORM PERUBAHAN HARGA</h4>
      </div>

      <div class="modal-body"  style="background-color: white!important;">
        <form class="form-horizontal" id="add_entri">
          <div class="box-body">

            <!-- <input type="hidden" class="form-control" id="id_add_qty" name="id_add_qty" readonly=""> -->

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label text-blue">Barcode</label>
              <div class="col-sm-10">
                <input type="text" id="barcode_chg_prc" name="barcode_chg_prc" required="" class="form-control" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label text-blue">Product_name</label>
              <div class="col-sm-10">
                <input type="text" id="prod_name_chg_prc" name="prod_name_chg_prc" required="" class="form-control" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label text-blue">Harga barang</label>
              <div class="col-sm-10">
                <input type="text" id="price" autocomplete="off" name="price" class="form-control" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label text-blue">Set harga baru</label>
              <div class="col-sm-10">
                <input type="number" id="chg_prc" autocomplete="off" name="chg_prc" class="form-control" placeholder="Set harga..." required="">
              </div>
            </div>
          </div>
          <!-- /.box-body -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline btn pull-left" data-dismiss="modal">Cancel [esc]</button>
        <button type="submit" id="submit_chg" class="btn btn-outline">Save [enter]</button>
      </div>
      </form>
    </div>

    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- modal rubah harga grosir-->
<div class="modal modal-success fade" id="mdl_rubah_grosir" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom-style: solid;border-bottom-color: blue;border-width: 1px">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">FORM PERUBAHAN HARGA GROSIR</h4>
      </div>

      <div class="modal-body"  style="background-color: white!important;">
        <form class="form-horizontal" id="add_entri">
          <div class="box-body">
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label text-blue">Barcode</label>
              <div class="col-sm-10">
                <input type="text" id="barcode_chg_grosir" name="barcode_chg_grosir" required="" class="form-control" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label text-blue">Product_name</label>
              <div class="col-sm-10">
                <input type="text" id="prod_name_chg_grosir" name="prod_name_chg_grosir" required="" class="form-control" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label text-blue">Harga barang</label>
              <div class="col-sm-10">
                <input type="text" id="price_grosir" autocomplete="off" name="price_grosir" class="form-control" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label text-blue">Set harga grosir</label>
              <div class="col-sm-10">
                <input type="number" id="chg_grosir" autocomplete="off" name="chg_grosir" class="form-control" placeholder="Set harga..." required="">
              </div>
            </div>
          </div>
          <!-- /.box-body -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline btn pull-left" data-dismiss="modal">Cancel [esc]</button>
        <button type="submit" id="submit_grosir" class="btn btn-outline">Save [enter]</button>
      </div>
      </form>
    </div>

    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- modal cari barang-->
<div class="modal modal-info fade" id="mdl_cari_barang" data-backdrop="static">
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


<style type="text/css">
 /*keytable style*/

table.dataTable td.focus {
    outline: 0px solid #3366FF;
}
td.dataTables_empty{
  background-color: #ccccff
}
.replace_color{
  background-color: #ccccff !important;
  z-index: 1
}
.selected
{
  background-color: #ccccff;
}
div.dataTables_wrapper  div.dataTables_filter {
/*  width: 100%;*/
  margin-top: -30px;color: black
}
.dataTables_length {
    margin-top: 0px;color: black
    /*margin-left: 40%;*/
}
</style>