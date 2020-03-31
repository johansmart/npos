<?php $this->load->view('back/meta') ?>
<?php $this->load->view('back/head') ?>
<?php $this->load->view('back/sidebar') ?>
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-solid box-default">
            <div class="box-header">
              <h3 class="box-title ion-ios-locked ion-2x"> ADMIN</h3>
            </div>
            <div class="box-body">
            <button type="button" id="addButton" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#userModal">
              <span class="glyphicon glyphicon-plus"></span>  Add User
            </button>
              <table id="datatable" class="table table-bordered table-striped table-condensed ">
                <thead>
                  <tr class="info">
                    <th>IMAGE</th>
                    <th>USERID</th>        
                    <th>USER_NAME</th>
                    <th>ROLE</th>
                    <th>DATE</th>
                    <th>CREATED</th>
                    <th>OPSI</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
   </div>

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

<!-- get max userid -->
  <script type="text/javascript">
    $('body').on('shown.bs.modal', '#userModal',function() {
      $.ajax({  
         url:"<?php echo base_url() . 'Create_user/max_user_id'?>",  
         method:'POST',  
         success:function(user_id){  
            $('#user_id').val(user_id);
        }  
     }); 
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function() {
      /*begin datatable*/
    $('#datatable').DataTable( {
      mark: true,
      "autoWidth": false, 
      "scrollY": "450px",
      scrollX:        false,
      'lengthChange': false,
      'searching'   : false,
      'info'        : false,
      "order": [[ 0, "desc" ]],
      "lengthChange": false,
      /*"sDom": 'Rfrtlip',*/
      "dom": '<"top"i>rt<"bottom"flp><"clear">',
      fixedColumns: true,
/*      columnDefs: [
          { width: 10, targets: 1 },
          { width: 250, targets: 2 }

      ],*/
      dom: 'Blfrtip',
      buttons: [
/*      'copy', 'csv',
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
        processing: true,
           "language": {
          processing: '<div style="margin-top:-4px"><img src="images/index.gif" alt="" class=""><span> &nbsp;&nbsp;Loading... </span></div>'},

        "serverSide" : true,

        "ajax":{
          url :"<?php echo base_url() . 'Create_user/fetch_user'; ?>", // json datasource
          type: "post",
            // method  , by default get
        }
      } );
      /*remove class msgerr*/
      $('#user_id').keyup(function(){ 
          $('#msgerr').html('');
          $('#msgerr').removeClass("glyphicon glyphicon-remove");
      })
      } );
    /*end datatable*/

    /*begin insert user*/
    $(document).on('submit', '#user_form', function(event){  
         event.preventDefault();  
         var user_id      = $('#user_id').val();  
         var user_name    = $('#user_name').val();
         var password     = $('#password').val();  
         var extension    = $('#user_image').val().split('.').pop().toLowerCase();
          if(extension   != '')  
           {  
              if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)  
              {  
                   $('#msg').html('FORMAT GAMBAR TIDAK SESUAI!');  
                   $('#user_image').val('');  
                   return false;  
              }  
           }       
   
          $.ajax({  
             url:"<?php echo base_url() . 'Create_user/user_action'?>",  
             method:'POST',  
             data:new FormData(this),  
             contentType:false,  
             processData:false,  
             success:function(data)  
             {  
                if (data==1) {
                  $("#msgerr").addClass("glyphicon glyphicon-remove");
                  $('#msgerr').html(' USERID '+ user_id+' SUDAH TERDAFTAR ').css({"font-size": "10px"});
                  return false;
                }
                  //alert(data);  
                  $('#user_form')[0].reset();  
                  //$('#userModal').modal('hide');  
                  $("#datatable").DataTable().ajax.reload();
                  $('#msg').html('USER BERHASIL DITAMBAHKAN !');
                  $.ajax({  
                   url:"<?php echo base_url() . 'Create_user/max_user_id'?>",  
                   method:'POST',  
                   success:function(user_id){  
                      $('#user_id').val(user_id);
                  }  
               }); 
            }  
          });  
          
      });
      /*end insert  user*/

      /*begin delete user*/
      $(document).on('click', '#delete', function(event){  
         event.preventDefault();  
          var user_id    = $(this).data('id');
          var currentRow = $(this).closest("tr")[0]; 
          var cells      = currentRow.cells;
          var firstCell  = cells[2].textContent;
          bootbox.confirm("DELETE : "+ " "+firstCell+" ?",function(confirmed){
          if (confirmed) {
            //alert('delete process');
             $.ajax({
              url: "<?php echo base_url() . 'Create_user/delete_single_user'?>",
              type: 'POST',
              method:"POST",
              data:{user_id:user_id},  
            })
            .done(function(data){
             $("#datatable").DataTable().ajax.reload();
             
            })
          }
        });
      }); 
      /*end delete user*/  

      /*begin update user*/
     $(document).on('click', '#update', function(event){  
      /*get data from datatable*/ 
      var currentRow  = $(this).closest("tr")[0]; 
      var cells       = currentRow.cells;
      var user_id     = cells[1].textContent;
      var user_name   = cells[2].textContent;
      $('#editModal').modal('show');
      $('[name="user_id_edit"]').val(user_id);
      $('[name="user_name_edit"]').val(user_name);
      /*get data from datatable*/ 

        //update record to database
       $('#btn_update').on('click',function(){
          var user_id = $('#user_id_edit').val();
          var user_name = $('#user_name_edit').val();
          var role = $('#role_edit').val();
          if (role !='' && user_name !='') {
            $.ajax({
              type : "POST",
              url:"<?php echo base_url() . 'Create_user/update_user'?>",
              dataType : "JSON",
              data : {user_id:user_id , user_name:user_name,role:role},
              success: function(data){
                  $('#role_edit').val('');  
                  $("#datatable").DataTable().ajax.reload();
                  $('#msg_edit').html('UPDATE USER BERHASIL!');
              }
          });
          }
          else if(role ==''){
            $('#role_edit').focus();
          }
          else if(user_name ==''){
            $('#user_name_edit').focus();
          }
      });
      });
      /*end update user*/  

      /*empty msg/msg_edit*/
      $(document).on('focus', '#user_id', function(event){
        $('#msg').html('');  
      });
      $(document).on('focus', '#user_name_edit', function(event){
        $('#msg_edit').html('');  
      }); 
  </script>
</body>
</html>

<!-- modal add user -->
<div class="modal fade" id="userModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
        <div class="modal-body">
          <div class="box box-solid box-primary">
            <div class="box-header">
                <h3 class="box-title" ><i class="glyphicon glyphicon-plus"></i> &nbsp;ADD USER</h3>
            </div><br>
            <form method="post" id="user_form" class="form-horizontal form-label-left">  
            <div class="form-group">
              <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">USERID</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="user_id" class="form-control col-md-7 col-xs-12  input-sm" name="user_id" readonly="">
                   <label class="text-danger"><span id="msgerr"></span></label>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">USERNAME</label> 
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="user_name" name="user_name" class="date-picker form-control col-md-7 col-xs-12  input-sm" required="required" type="text" placeholder="exmp : HENDRA RAHIM">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">PASSWORD</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="password" class="form-control col-md-7 col-xs-12  input-sm" name="password" id="password" required="" minlength="4" value="">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">ROLE</label> 
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control select-sm" id="role" name="role" required="">
                    <option></option>
                    <option>0 KASIR</option>
                    <option>1 STAFF</option>
                    <option>2 MANAGER</option>
                    <option>3 OWNER</option>
                </select>
                </div>
              </div>
              <div class="form-group" style="margin-left: 8px">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">SELECT_IMAGE</label>
                  <input type="file" name="user_image" id="user_image" value="0" />  
              <span id="user_uploaded_image"></span>  
              </div>
             
              <div  style="height: 40px;background-color: #e6f2ff;padding-top: 10px;padding-left: 10px;font-size: 15px;text-align: center;"><b><label class="text-success"><p id="msg"></p></label></b></div>
              <br>

              <div class="form-group text-center">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                   <button type="button" class="btn bg-red btn-flat" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Close</button>
                  <button type="submit" name="action" id="action" class="btn btn-primary btn-flat" value="Add" /><i class="glyphicon glyphicon-plus"></i> Add</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


<!-- modal add user -->
<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
        <div class="modal-body">
          <div class="box box-solid box-danger">
            <div class="box-header">
                <h3 class="box-title" ><i class="glyphicon glyphicon-edit"></i> &nbsp;UPDATE USER</h3>
            </div><br>
            <form method="post" id="user_form_edit" class="form-horizontal form-label-left">  
            <div class="form-group">
              <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">USERID</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="user_id_edit" class="form-control col-md-7 col-xs-12  input-sm" name="user_id_edit" placeholder="exmp : 100135087" required="" disabled="">
                   <label class="text-danger"><span id="msgerr"></span></label>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">USERNAME</label> 
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="user_name_edit" name="user_name_edit" class="date-picker form-control col-md-7 col-xs-12  input-sm" required="required" type="text" placeholder="exmp : HENDRA RAHIM">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">PASSWORD</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="password" class="form-control col-md-7 col-xs-12  input-sm" name="password" id="password" required="" minlength="4" disabled="" value="******">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">ROLE</label> 
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control select-sm" id="role_edit" name="role_edit" required="">
                    <option>0 KASIR</option>
                    <option>1 STAFF</option>
                    <option>2 MANAGER</option>
                    <option>3 OWNER</option>
                </select>
                </div>
              </div>
<!--               <div class="form-group" style="margin-left: 8px">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">SELECT_IMAGE</label>
                  <input type="file" name="user_image" id="user_image" disabled="" />  
              <span id="user_uploaded_image"></span>  
              </div> -->
             
              <div  style="height: 40px;background-color: #e6f2ff;padding-top: 10px;padding-left: 10px;font-size: 15px;text-align: center;"><b><label class="text-success"><p id="msg_edit"></p></label></b></div>
              <br>

              <div class="form-group text-center" >
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                   <button type="button" class="btn bg-red btn-flat" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Close</button>
                  <button type="button"  name="btn_update" id="btn_update" class="btn btn-primary btn-flat" value="Update" /><i class="glyphicon glyphicon-plus"></i> Update</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>