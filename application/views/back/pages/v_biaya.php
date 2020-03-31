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
              <h3 class="box-title">Biaya</h3>
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
                    <th>USERID</th>
                    <th>USER_NAME</th>        
                    <th>KODE_BIAYA</th>
                    <th>JENIS_BIAYA</th>
                    <th>NILAI_BIAYA</th>
                    <th>KETERANGAN</th>
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
                    <span class="glyphicon glyphicon-plus"></span> TAMBAH BIAYA
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
      "scrollY"     : "370px",
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
          url :"<?php echo base_url() . 'Biaya/fetch_biaya'; ?>", // json datasource
          type: "post",
            // method  , by default get
        }
      });
     });
</script>

<script type="text/javascript">
  $(document).on('shown.bs.modal','#modal_tambah', function (){
    $("#pesan").hide();
    //format hanya angka
    $("#nilai_biaya").keypress(function (e){
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    });
    //format hanya angka
    $('#add_biaya')[0].reset();
    $("#select_biaya").html('');
    $("#kode_barang").focus();
    $('#select_biaya').select2({
      placeholder: '--- Biaya ---',
      ajax: {
        url: 'Biaya/select_biaya',
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

<script type="text/javascript">
  //select kategori
  $('#select_biaya').select2({
    placeholder: '--- Biaya ---',
    ajax: {
      url: 'Master_barang/select_biaya',
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
</script>

<!-- menampilkan modal -->
<script type="text/javascript">
  $(document).ready(function (){
    $('#tambah').click(function(){
      $('#modal_tambah').modal('show');
    })   
  })  
</script>

<!-- insert biaya -->
<script type="text/javascript">
$(document).on('submit', '#add_biaya', function(event){
  event.preventDefault();
  var jenis_biaya   = $("#select_biaya option:selected").text();
  var nilai_biaya   = $('#nilai_biaya').val();
  var keterangan    = $('#keterangan').val();
  
  if (jenis_biaya=='') 
  {
    $('#select_biaya').select2('open');
    return false;
  }
  else if (keterangan.trim() === '' ) {
    $('#keterangan').focus();
    return false;
  }
  else
  {
    bootbox.confirm("Konfirmasi ?",function(confirmed){
    if (confirmed) {
      $.ajax({
      type : "POST",
      url:"<?php echo base_url() . 'Biaya/insert_biaya'?>",
      data : 
      {
        jenis_biaya:jenis_biaya,
        nilai_biaya:nilai_biaya,
        keterangan:keterangan
      },
      success: function(data){
          //menampilkan dan merubah class pesan
          $("#pesan").show();
          $("#msg").html('Biaya berhasil ditambahkan!');
          $('#pesan').addClass('alert alert-success alert-dismissible');
          //menampilkan dan merubah class pesan
          $("#datatable").DataTable().ajax.reload();
          $('#add_biaya')[0].reset();
          $("#select_biaya").html('');
      }
    });
    }
  });
  }
});
</script>

<!-- tambah modal -->
<div class="modal fade modal-info" id="modal_tambah">
  <form class="form-horizontal" id="add_biaya">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Form Tambah Biaya</h4>
        </div>
        <div class="modal-body" style="background-color: white!important;">

          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">JENIS_BIAYA</label>
            <div class="col-md-10">
              <select name="select_kategori" class="form-control select2" id="select_biaya" style="width: 100%;">
                <option value=""></option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">NILAI_BIAYA</label>
            <div class="col-md-10">
              <input type="text" id="nilai_biaya" name="nilai_biaya" required="" class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label for="inputPassword3" class="col-md-2 control-label text-black">KETERANGAN</label>
            <div class="col-md-10">
              <textarea id="keterangan" name="keterangan" rows="5" cols="64" class="form-control" required>
              </textarea>
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



