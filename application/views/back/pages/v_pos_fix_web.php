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
      <!-- barcode, shift, pos name, date -->
      <div class="box box-default color-palette-box" style="margin-top: -10px;">
        <div class="box-header with-border">
          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-addon bg-gray"><i class="fa fa-barcode"></i></span>
              <form id="add_item">
                <input class="form-control input-sm" id="barcode" autocomplete="off" autofocus="" type="text" required=""  placeholder=".Scan barcode..." style="background-color: #f2dede">
              </form>
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group" style="height: 10px">
              <span class="input-group-addon bg-gray"><i class="fa fa-desktop"></i></span>
              <input type="text" id="" class="form-control input-sm text-black" style="background-color: white" readonly="" value="POS : 1001">
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-addon bg-gray"><i class="fa fa-clock-o"></i></span>
              <input type="text" id="shift_kasir" class="form-control input-sm text-black" style="background-color: white" readonly="">
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-addon bg-gray"><i class="fa fa-calendar"></i></span>
              <input type="text" id="" class="form-control input-sm text-black" style="background-color: white" readonly="" value="<?php echo date('d-m-Y');?>">
            </div>
          </div>

        </div>
      </div>

      <!-- datatable -->
      <div class="box box-default color-palette-box" style="margin-top: -20px;">
        <div class="box-header with-border" style="margin-top: -10px">
          <table id="example" class="table">
              <thead class=" text-black" style="background-color: #f2dede">
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

      <!-- input description -->
      <div class="box box-default color-palette-box" style="margin-top: -20px;">
        <div class="box-body">
          <input class="form-control input-sm" id="id" readonly="" type="hidden">
          <input class="form-control input-sm" id="hide_barcode" readonly="" type="hidden">
          <input class="form-control input-sm" id="hide_prc" readonly="" type="hidden">
          <input class="form-control input-sm" id="hide_qty" readonly="" type="hidden">
          <input class="form-control input-sm" id="remark" readonly="" type="hidden">
          <input class="form-control input-sm" id="status_modal" readonly="" type="hidden">
          <strong><input type="text" id="description" class="form-control input-sm " readonly="" style="font-size: 16px;background-color: #f2dede;color: black"></strong>
      </div>

      <!-- button -->
      <div class="box box-default color-palette-box" style="margin-top: -2px;">
        <div class="box-body">
          <div>
            <a class="btn btn-xs bg-gray" id="void" style="width:10.8%">
              <i class="fa fa-remove"></i> Batal [V]
            </a>
            <a class="btn btn-xs bg-gray" id="add_qty" style="width:10.8%">
              <i class="fa fa-cart-plus"></i> Qty [Q]
            </a>
            <a class="btn btn-xs bg-gray" id="hrg_grosir" style="width:10.8%">
              <i class="fa fa-exchange"></i> Grosir [G]
            </a>
            <a class="btn btn-xs bg-gray" id="clear" style="width:10.8%">
              <i class="fa fa-trash"></i> Clear [R]
            </a>
            <a class="btn btn-xs bg-gray" id="save_trx" style="width:10.8%">
              <i class="fa fa-hand-stop-o"></i> Hold [S]
            </a>
            <a class="btn btn-xs bg-gray" id="call_trx" style="width:10.8%">
              <i class="fa fa-refresh"></i> Call [F8]
            </a>
            <a class="btn btn-xs bg-gray" id="rbh_harga" style="width:10.8%">
              <i class="fa fa-strikethrough"></i> Chg_Price [U]
            </a>
            <a class="btn btn-xs bg-gray" id="rbh_grosir" style="width:10.8%">
              <i class="fa fa-strikethrough"></i> Chg_Grosir [I]
            </a>
            <a class="btn btn-xs bg-gray" id="search_prod" style="width:10.8%">
              <i class="fa fa-search"></i> Search [F4]
            </a>
          </div>
          <div style="margin-top: 5px">
            <a class="btn btn-xs bg-red" id="bayar" style="width:10.8%">
              <i class="fa fa-money text-white"></i> Tunai [F2]
            </a>
            <a class="btn btn-xs bg-red" id="piutang" style="width:10.8%">
              <i class="fa fa-money text-white"></i> Piutang [F9]
            </a>
            <a class="btn btn-xs bg-red" id="kartu_kredit" style="width:10.8%">
              <i class="fa fa-money text-white"></i> Credit_card [F12]
            </a>
          </div>
        </div>
      </div>
       
       <!-- transaksi terakhir, promo, total --> 
      <div class="box box-default color-palette-box" style="margin-top: -15px;">
        <div class="box-body">
          <div class="col-md-4">
            <div class="panel panel-danger" style="margin-left: -15px">
              <div class="panel-heading" style="height: 35px">Transaksi Terakhir</div>
              <div class="panel-body" style="font-size: 12px;text-align: left;font-weight: bold">
                
                  <?php
                    foreach ($last_trx as $last) {
                      echo '
                         <table style="width:100%">
                          <tr>
                            <th>TOTAL</th>
                            <th>BAYAR</th>
                            <th>KEMBALI</th>
                            <th>TRANS</th>
                            <th>NO_FAKTUR</th>
                          </tr>
                          <tr>
                            <td><span class="text-blue">'.number_format($last->grand_total).'</span></td>
                            <td><span class="text-blue">'.number_format($last->bayar).'</span></td>
                            <td><span class="text-blue">'.number_format($last->kembali).'</span></td>
                            <td><span class="text-blue">'.$last->tipe_bayar.'</span></td>
                            <td><span class="text-blue">'.$last->no_faktur.'</span></td>
                          </tr>
                        </table>
                        <br> 
                        <p><b>TUNAI - '.$this->session->userdata('user_name').' ( Today ) : '.'<span class="text-red">'.number_format($sls_kasir['grand_total']).'</span></b></p>
                      ';
                     } 
                  ?>
                 
              </div>
            </div>
          </div>

          <!-- promo -->
          <div class="col-md-4">
            <div class="panel panel-danger" style="margin-left: -15px">
              <div class="panel-heading" style="height: 35px">Promo</div>
              <div class="panel-body" style="font-size: 14px;text-align: center;overflow-y:scroll; height:90px">
                <table style="width:100%;margin-top: -15px;font-size: 12px;font-weight: bold">
                  <?php
                    foreach ($result_promo as $promo) {
                      echo '
                      <tr>
                        <td>'.$promo->nama_barang.'<br>'.'<span class="text-blue">'.number_format($promo->harga_promo).'</span></td>
                      </tr>
                      ';
                     } 
                  ?>
                </table>  
              </div>
            </div>
          </div>

          <div class="col-md-4 bg-gray">
              <form class="form-horizontal" style="margin-top: 10px">
                <div class="form-group">
                  <label class="col-xs-4 control-label" style="text-align: left">TOTAL</label>
                  <div class="col-md-8">
                    <strong><input type="text" class="form-control text-black text-right" id="total"  readonly="" style="font-size: 16px;margin-left:10px;background-color: white "></strong>
                  </div>
                </div>
                <div class="form-group" style="margin-top: -10px">
                  <label class="col-xs-4 control-label" style="text-align: left">DISKON</label>
                  <div class="col-md-8">
                    <strong><input type="text" class="form-control text-right" id="diskon"  readonly="" style="font-size: 16px;margin-left:10px;background-color: white"></strong>
                  </div>
                </div>
                <div class="form-group" style="margin-top: -10px">
                  <label class="col-xs-4 control-label" style="text-align: left">GRAND_TOTAL</label>
                  <div class="col-md-8">
                    <strong><input type="text" class="form-control bg-red text-right" id="grand_total"  readonly="" style="font-size: 16px;margin-left:10px;"></strong>
                  </div>
                </div>
              </form>
          </div>
      </div>
    </section>
  </div>
</div>
<!-- content -->

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
<!-- Select2 -->
<script src="<?php echo base_url('assets/template/backend/') ?>bower_components/select2/dist/js/select2.full.min.js"></script>

<!-- slim scroll panel -->
<script type="text/javascript">
  $(function(){
    $('.panel-body').slimScroll({
        height: '100px',
        color: 'white'
    });
  });
</script>

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

<!-- menampilkan transaksi terakhir dan shift-->
<script type="text/javascript">
  $(document).ready(function (){
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
    //mengambil data shift
    $.ajax({
      url: "<?php echo base_url() . 'Pos/get_shift'?>",
      type : "POST",
      dataType : "JSON",
        success: function(data){
          $('#shift_kasir').val(data);
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
    loadRowColor_refresh();
    var table = $('#example').DataTable({
      "autoWidth": false, 
      scrollY: 270,
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
           keys: [ 13 /* ENTER */, 38 /* UP */, 40 /* DOWN */, 86 /* V */, 81 /* Q */, 71 /* G */, 82 /* R */,83 /* S */,113 /* F2 */,85 /* U */,73 /* I */,120 /* f9 */,123 /* f12 */]
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
        $("#description").val(desc);
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
        else if (key === 120 && status_modal!='open')
        {
          $('#piutang').trigger('click')
          $('#barcode').val('');
        }
        else if (key === 123 && status_modal!='open')
        {
          $('#kartu_kredit').trigger('click')
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
          $("#description").val('Barang tidak ditemukan !');
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
        $("#total").val(data);
      }  
    }); 
  }
  function diskon(){
    $.ajax({  
      url:"<?php echo base_url() . 'Pos/diskon'?>",  
      method:'POST',    
      success:function(data)  
      { 
        $("#diskon").val(data);
      }  
    }); 
  }
  function grand_total(){
    $.ajax({  
      url:"<?php echo base_url() . 'Pos/grand_total'?>",  
      method:'POST',    
      success:function(data)  
      { 
        $("#grand_total").val(data);
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
      //loadRowColor();
      var id    = $('#id').val();
      var qty   = $('#hide_qty').val();
      var desc  = $('#description').val();
      $("#tmbah_qty").val('');
      $('#id_add_qty').val(id);
      $('#prod_name').val(desc);
      $('#jumlah_qty').val(qty);
      $('#tmbah_qty').focus();
    })
    $('#mdl_add_qty').on('hide.bs.modal', function(e) {
      $("#barcode").focus();
      $("#barcode").val('');
      //loadRowColor();
    });
    //focus barcode on hide bootbox
    $(document).on('hidden.bs.modal','.bootbox', function () {
        //loadRowColor();
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
        
        if (data=='0')
        {
          bootbox.alert('Barang ini tidak mempunyai harga grosir')
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
          
          $("#barcode").focus();
          loadRowColor();
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

      var table = $('#example').DataTable();
      var data = table .rows().data();
      var isi_table = data.length;
      var grand_total = $('#grand_total').val();
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
          var total = $('#grand_total').val();
          $('#mdl_total').val(total);
          $('#mdl_tot_bayar').focus();
        });
        $('#mdl_bayar').on('hide.bs.modal', function(e) {
          $('#status_modal').val('');
          $("#mdl_tot_bayar").val('');
          $("#mdl_kembali").val('');
          //loadRowColor();
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

<!-- event klik button putang -->
<script type="text/javascript">
  $(document).ready(function (){
    $('#piutang').click(function(){
      var table = $('#example').DataTable();
      var data = table .rows().data();
      var isi_table = data.length;
      var grand_total = $('#grand_total').val();
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
        $('#mdl_piutang').modal('show');
        $('#mdl_piutang').on('shown.bs.modal', function(e) {
          $('#status_modal').val('open');
          var total = $('#grand_total').val();
          $('#mdl_sisa_piutang').val(total);
          $('#mdl_sisa_piutang').focus();
          $("#select_pelanggan").html('');
        });
        $('#mdl_piutang').on('hide.bs.modal', function(e) {
          $('#status_modal').val('');
        });
        $(document).on('hidden.bs.modal','.bootbox', function () {
          $('#mdl_bayar_tagihan').focus();
        });
        //kalkulasi total - bayar
        $("#mdl_bayar_tagihan").keyup(function(){
          $("#msg").html('')
          var convert_tot = $("#tot_tagihan").val().replace(/,/g,''); 
          var convert_byr = $("#mdl_bayar_tagihan").val().replace(/,/g,'');
          var kembali = convert_tot-convert_byr;
          $("#mdl_sisa_piutang").val(kembali.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        });
        //kalkulasi total - bayar
        $('#select_pelanggan').select2({
        placeholder: '--- Pilih pelanggan ---',
        ajax: {
          url: 'Pos/select_pelanggan',
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
      }
      //submit data
      $('#submit_piutang').click(function(){
      event.preventDefault();
      var select_pelanggan = $("#select_pelanggan option:selected").text();
      if (select_pelanggan =='') 
      {
        $('#select_pelanggan').select2('open');
        return false;
      }
      else
      {
        var nilai_piutang = $("#mdl_sisa_piutang").val().replace(/,/g, '')
        var piutang = parseInt(nilai_piutang);
        bootbox.hideAll();
        bootbox.confirm("Konfirmasi transaksi piutang "+nilai_piutang ,function(confirmed){
          if (confirmed) {
            $('#mdl_piutang').modal('hide');
            $.ajax({
            url: "<?php echo base_url() . 'Pos/ins_piutang'?>",
            type : "POST",
            dataType : "JSON",
            data : {piutang:piutang,pelanggan:select_pelanggan},
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

<!-- event klik button credit card -->
<script type="text/javascript">
  $(document).ready(function (){
    $('#kartu_kredit').click(function(){
      var table = $('#example').DataTable();
      var data = table .rows().data();
      var isi_table = data.length;
      var grand_total = $('#grand_total').val();
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
        $('#mdl_kartu_kredit').modal('show');
        $('#mdl_kartu_kredit').on('shown.bs.modal', function(e) {
          var total = $('#grand_total').val();
          $('#mdl_jumlah_tagihan').val(total);
          $('#mdl_nomor_kartu').focus();
        });
        $('#mdl_kartu_kredit').on('hide.bs.modal', function(e) {
          $('#status_modal').val('');
          $("#mdl_bank").html('');
          $('#frm_kartu_kredit')[0].reset();
        });
        $(document).on('hidden.bs.modal','.bootbox', function () {
          $('#mdl_bayar_tagihan').focus();
        });
        $('#mdl_bank').select2({
        placeholder: '--- Pilih bank ---',
        ajax: {
          url: 'Pos/select_bank',
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
      $('#mdl_bank').on('select2:close', function (e) {
       $('#mdl_validity').focus();
      });
      }
      //submit data
      $('#frm_kartu_kredit').submit(function(){
      event.preventDefault();
      var jumlah_tagihan = $("#mdl_jumlah_tagihan").val().replace(/,/g, '');
      var jml_debit      = parseInt(jumlah_tagihan);
      var no_kartu       = $("#mdl_nomor_kartu").val();
      var bank           = $("#mdl_bank option:selected").text();
      var validity       = $("#mdl_validity").val();
      var approval_no    = $("#mdl_approval_no").val();
      bootbox.hideAll();
      bootbox.confirm("Konfirmasi transaksi kartu kredit "+jml_debit ,function(confirmed){
        if (confirmed) {
          $('#mdl_kartu_kredit').modal('hide');
          $.ajax({
          url: "<?php echo base_url() . 'Pos/ins_kartu_kredit'?>",
          type : "POST",
          dataType : "JSON",
          data : {jml_debit:jml_debit,no_kartu:no_kartu,bank:bank,validity:validity,approval_no:approval_no},
            success: function(data){
              $.ajax({
                url: "<?php echo base_url() . 'Pos/clear_tmp_trx'?>",
                })
              $('#mdl_kembali').modal('show');
            }
          })
        }
      }); 
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
      var prod_name  = $('#description').val();
      $('#barcode_chg_prc').val(barcode);
      $('#prod_name_chg_prc').val(prod_name);
      $("#price").val(price);
      $('#chg_prc').val('');
      $('#chg_prc').focus();
    })
    $('#mdl_rubah_harga').on('hide.bs.modal', function(e) {
      //loadRowColor();
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
      var prod_name  = $('#description').val();
      $('#barcode_chg_grosir').val(barcode);
      $('#prod_name_chg_grosir').val(prod_name);
      $("#price_grosir").val(price);
      $('#chg_grosir').val('');
      $('#chg_grosir').focus();
    })
    $('#mdl_rubah_grosir').on('hide.bs.modal', function(e) {
      //loadRowColor();
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
      var status_modal = $('#status_modal').val();
      if (status_modal!='open')
        {
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
      //loadRowColor();
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

<!-- membuat control modal open agar modal lain tidak ikut terbuka -->
<script type="text/javascript">
  $(document).on('show.bs.modal', '.modal', function () {
    $('#status_modal').val('open');
  })
  $(document).on('hide.bs.modal', '.modal', function () {
    $('#status_modal').val('');
    loadRowColor();
  })
</script>

<!-- modal add qty -->
<div class="modal modal-danger fade" id="mdl_add_qty" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">TAMBAH QTY</h4>
      </div>

      <div class="modal-body"  style="background-color: white!important;">
        <form class="form-horizontal" id="add_entri">
          <div class="box-body">

            <input type="hidden" class="form-control" id="id_add_qty" name="id_add_qty" readonly="">

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label text-blue">Product_name</label>
              <div class="col-sm-10">
                <input type="text" id="prod_name" name="prod_name" required="" class="form-control bg-gray" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label text-blue">Jumlah</label>
              <div class="col-sm-10">
                <input type="text" id="jumlah_qty" name="jumlah_qty" required="" class="form-control bg-gray" readonly="">
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
<div class="modal modal-danger fade" id="mdl_bayar" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">FORM PEMBAYARAN TUNAI</h4>
      </div>

      <div class="modal-body"  style="background-color: white!important;">
        <form class="form-horizontal" id="add_entri">
          <div class="box-body">

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label text-blue">TOTAL TAGIHAN</label>
              <div class="col-sm-10">
                <input type="text" id="mdl_total" name="mdl_total" required="" class="form-control bg-gray input-lg" readonly="" style="font-size: 30px;">
              </div>
            </div>

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label text-blue">BAYAR</label>
              <div class="col-sm-5">
                <input type="text" id="mdl_tot_bayar" name="mdl_tot_bayar" class="form-control input-lg" required="" autocomplete="off" style="font-size: 30px;" >
              </div>

              <label for="inputPassword3" class="col-sm-5 control-label" style="margin-left: -20px"><span class="text-red" id="msg"></span></label>
            </div>
            <div class="callout callout-info">
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

<!-- modal piutang -->
<div class="modal modal-danger fade" id="mdl_piutang" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">FORM PEMBAYARAN PIUTANG</h4>
      </div>

      <div class="modal-body"  style="background-color: white!important;">
        <form class="form-horizontal" id="add_piutang">
          <div class="box-body">
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-3 control-label text-blue">JUMLAH_PIUTANG</label>
              <div class="col-sm-5">
                <input type="text" id="mdl_sisa_piutang" name="mdl_sisa_piutang" class="form-control bg-gray" readonly="" autocomplete="off" style="font-size: 20px;" >
              </div>
            </div>

            <div class="form-group" id="hidden_supp">
              <label for="inputPassword3" class="col-sm-3 control-label text-blue">PELANGGAN</label>
              <div class="col-sm-8">
                <select name="select_pelanggan" class="form-control select2" id="select_pelanggan" required="" style="width: 100%;">
                <option value=""></option>
              </select>
              </div>
            </div>

              <label for="inputPassword3" class="col-sm-5 control-label" style="margin-left: -20px"><span class="text-red" id="msg"></span></label>
            </div>
            <div class="callout callout-info">
                <h4>Warning :</h4>
                <p>Masukkan pembayaran yang benar</p>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline btn pull-left" data-dismiss="modal">Cancel [esc]</button>
        <button type="submit" id="submit_piutang" class="btn btn-outline">Save [enter]</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- modal kartu kredit -->
<div class="modal modal-danger fade" id="mdl_kartu_kredit" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">FORM PEMBAYARAN KARTU KREDIT</h4>
      </div>

      <div class="modal-body"  style="background-color: white!important;">
        <form class="form-horizontal" id="frm_kartu_kredit">
          <div class="box-body">
            <div class="form-group">
              <label for="inputPassword4" class="col-sm-4 control-label text-blue">JUMLAH_TAGIHAN</label>
              <div class="col-sm-7">
                <input type="text" id="mdl_jumlah_tagihan" name="mdl_jumlah_tagihan" class="form-control bg-gray" readonly="" autocomplete="off" style="font-size: 16px;" >
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-4 control-label text-blue">NOMOR_KARTU</label>
              <div class="col-sm-7">
                <input type="text" id="mdl_nomor_kartu" name="mdl_nomor_kartu" class="form-control" required="" autocomplete="off" style="font-size: 16px;" >
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword4" class="col-sm-4 control-label text-blue">PERUSAHAAN / BANK</label>
              <div class="col-sm-7">
                <select class="form-control select2 option-sm" id="mdl_bank" name="mdl_bank" style="width: 100%;" required=>
                  <option value=""></option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword4" class="col-sm-4 control-label text-blue">TRACE_NO</label>
              <div class="col-sm-7">
                <input type="text" id="mdl_validity" name="mdl_validity" class="form-control" required="" autocomplete="off" style="font-size: 16px;" >
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword4" class="col-sm-4 control-label text-blue">APPROVAL_CODE</label>
              <div class="col-sm-7">
                <input type="text" id="mdl_approval_no" name="mdl_approval_no" class="form-control" required="" autocomplete="off" style="font-size: 16px;" >
              </div>
            </div>
            <label for="inputPassword3" class="col-sm-5 control-label" style="margin-left: -16px"><span class="text-red" id="msg"></span></label>
            </div>
            <div class="callout callout-info">
                <h4>Warning :</h4>
                <p>Masukkan pembayaran yang benar</p>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline btn pull-left" data-dismiss="modal">Cancel [esc]</button>
        <button type="submit" id="submit_kartu_kredit" class="btn btn-outline">Save [enter]</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- modal kembalian -->
<div class="modal modal-danger fade" id="mdl_kembali" data-backdrop="static">
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
<div class="modal modal-danger fade" id="mdl_rubah_harga" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
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
                <input type="text" id="barcode_chg_prc" name="barcode_chg_prc" required="" class="form-control bg-gray" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label text-blue">Product_name</label>
              <div class="col-sm-10">
                <input type="text" id="prod_name_chg_prc" name="prod_name_chg_prc" required="" class="form-control bg-gray" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label text-blue">Harga barang</label>
              <div class="col-sm-10">
                <input type="text" id="price" autocomplete="off" name="price" class="form-control bg-gray" readonly="">
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
<div class="modal modal-danger fade" id="mdl_rubah_grosir" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
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
                <input type="text" id="barcode_chg_grosir" name="barcode_chg_grosir" required="" class="form-control bg-gray" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label text-blue">Product_name</label>
              <div class="col-sm-10">
                <input type="text" id="prod_name_chg_grosir" name="prod_name_chg_grosir" required="" class="form-control bg-gray" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label text-blue">Harga barang</label>
              <div class="col-sm-10">
                <input type="text" id="price_grosir" autocomplete="off" name="price_grosir" class="form-control bg-gray" readonly="">
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


<style type="text/css">
 /*keytable style*/

table.dataTable td.focus {
    outline: 0px solid #b5a6f9;
}
td.dataTables_empty{
  background-color: #c5cae9
}
.replace_color{
  background-color: #c5cae9 !important;
  z-index: 1
}
.selected
{
  background-color: #c5cae9 !important;
}
div.dataTables_wrapper  div.dataTables_filter {
/*  width: 100%;*/
  margin-top: -30px;color: black
}
.dataTables_length {
    margin-top: 0px;color: black
    /*margin-left: 40%;*/
}
/*.bg-red-active, .modal-danger .modal-header, .modal-danger .modal-footer {
  background-color: #605ca8 !important;
}*/
/*decrease height row datatable*/
table tr td {
   padding:4px !important;
   padding-left: 5px !important;
}
.table > thead > tr > td, .table > thead > tr > th {
  line-height: 1;
}
.input-group-addon {
  padding: 6px 10px;
  font-size: 10px;
}
.input-sm {
  height: 25px;
  padding: 5px 10px;
  font-size: 12px;

}
.bg-red{
  background-color: #ff4444;
}
</style>