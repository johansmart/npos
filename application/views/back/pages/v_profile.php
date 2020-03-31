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
          <div class="box box-solid box-info">
            <div class="box-header">
              <h3 class="box-title ion-ios-locked ion-2x"> USER</h3>
            </div>
            <div class="box-body">
              
              <div class="row">
                <div class="col-md-12">
                  <div>
                    <div class="box-body box-profile">
                       <img src="<?php echo base_url('upload/img_user/'. $this->session->userdata('image'));?>" class="profile-user-img img-responsive" alt="User Image" style="width: 180px;height: 225px">
                      <h3 class="profile-username text-center"><?php echo $this->session->userdata('user_name');?></h3>
                      <p class="text-muted text-center"><?php echo $this->session->userdata('user_id');?></p>
                      <?php $div=$this->session->userdata('role') ?>
                      <p class="text-muted text-center">
                        <?php 
                          if ($div==3) {
                            echo 'ADMIN';
                          }
                          else if ($div==2) {
                            echo 'SGM';
                          }
                          else if ($div==1) {
                            echo 'MANAGER';
                          }
                          else if ($div==0) {
                            echo 'STAFF';
                          }
                        ?>
                      </p>
                      <p class="text-muted text-center">
                        Member since <?php echo $this->session->userdata('memb_date');?>
                      </p>
                    </div>
                    <div class="col-md-12 text-center">
                      <button type="submit" id="chg_pict" class="btn btn-success btn-flat pull-center">CHANGE IMAGE</button>
                      <button type="submit" id="chg_pass" class="btn btn-primary btn-flat pull-center">CHANGE PASSWORD</button>
                    </div>
             
                  </div>
                </div>
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
</body>
</html>

<script type="text/javascript">

</script>

<script type="text/javascript">
    /*show modal*/
    $(document).on('click', '#chg_pass', function(event){   
      $('#chgPass').modal('show');
    });
    $(document).on('click', '#chg_pict', function(event){   
      $('#chgPict').modal('show');
    });  
    /*get old password*/
    $(document).ready(function(){
      $('#old_pass').keyup(function(){ 
      $('#msgerr').html('');
      $('#msgerr').removeClass("glyphicon glyphicon-remove");
      var old_pass = $('#old_pass').val(); 
      $.ajax({ 
        method: "POST",      
        url: "<?php echo base_url() . 'Profile/get_old_pass'; ?>", 
        data: { old_pass: old_pass}, 
      })
        .done(function( hasilajax ) { 
          $('#get_pass').val(hasilajax)
        });
     })
    });
    /*validate before send*/
     $(document).on('submit', '#update_pass', function(event){  
      event.preventDefault(); 
      var get_pass  = $('#get_pass').val()
      var new_pass  = $('#new_pass').val()
      var conf_pass = $('#conf_pass').val()
      var user_id   = $('#user_id').val()
      if (get_pass ==0) {
        $("#msgerr").addClass("glyphicon glyphicon-remove");
        $('#msgerr').html('  PASSWORD LAMA TIDAK SESUAI').css({"font-size": "10px"});
        $('#old_pass').focus();
        return false;
      }
      else if (new_pass!=conf_pass) {
        $("#msgerr_new_pass").addClass("glyphicon glyphicon-remove");
        $('#msgerr_new_pass').html('  NEW PASSWORD DAN CONFIRM PASSWORD HARUS SESUAI').css({"font-size": "10px"});
        return false;
      }
      else if ($('#old_pass').val() == $('#new_pass').val()) {
        $('#msg').html('PASSWORD LAMA TIDAK BOLEH SAMA DENGAN PASSWORD BARU');
        $('#new_pass').val('')
        $('#conf_pass').val('')
        $('#new_pass').focus();
        return false;
      }
      else{
        /*update action*/
        $.ajax({
              type : "POST",
              url:"<?php echo base_url() . 'Profile/update_pass'?>",
              dataType : "JSON",
              data : {user_id:user_id , new_pass:new_pass},
              success: function(data){
                $('#chgPass').modal('hide');
                bootbox.confirm("GANTI PASSWORD BERHASIL, LOGOUT DARI SISTEM ?",function(confirmed){
                  if (confirmed) {
                    location.replace('Auth/logout');
                  }
                  else{
                    location.reload();
                  }
                });
                
              }
          });
      }
   })

  /*begin update image*/
    $(document).on('submit', '#update_pict', function(event){
       event.preventDefault();    
       var user_id_chgpict      = $('#user_id_chgpict').val();  
       var extension    = $('#user_image').val().split('.').pop().toLowerCase();
       //alert(user_id_chgpict);
       $.ajax({  
         url:"<?php echo base_url() . 'Profile/update_image'?>",  
         method:'POST',  
         /*data:{user_id_chgpict:user_id_chgpict,extension:extension},*/
         data:new FormData(this),
         contentType:false,  
         processData:false,  
         success:function(data)  
         {  
          $('#chgPict').modal('hide');
            bootbox.confirm("GANTI IMAGE BERHASIL, LOGOUT DARI SISTEM ?",function(confirmed){
              if (confirmed) {
                location.replace('Auth/logout');
              }
              else{
                location.reload();
              }
            });
        }  
      });  
    });
  /*end insert  user*/

    /*empty msg*/
    $(document).on('keyup', '#new_pass', function(event){
      $("#msgerr_new_pass").removeClass("glyphicon glyphicon-remove");
      $('#msgerr_new_pass').html('');  
    });
    $(document).on('keyup', '#conf_pass', function(event){
      $("#msgerr_new_pass").removeClass("glyphicon glyphicon-remove");
      $('#msgerr_new_pass').html('');  
    });
</script>

<!-- modal change password -->
<div class="modal fade" id="chgPass" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
        <div class="modal-body">
          <div class="box box-solid box-primary">
            <div class="box-header">
                <h3 class="box-title" ><i class="glyphicon glyphicon-lock"></i> &nbsp;CHANGE PASSWORD</h3>
            </div><br>
            <form method="post" id="update_pass" class="form-horizontal form-label-left">  
            <div class="form-group">
              <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">USERID</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="user_id" class="form-control col-md-7 col-xs-12  input-sm" name="user_id"  disabled="" value="<?php echo $this->session->userdata('id_karyawan');?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">USERNAME</label> 
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="user_name" name="user_name" class="date-picker form-control col-md-7 col-xs-12  input-sm" required="required" type="text" disabled="" value="<?php echo $this->session->userdata('user_name');?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">OLD PASSWORD</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="password" class="form-control col-md-7 col-xs-12  input-sm" name="old_pass" id="old_pass" required="" minlength="4" value="" autocomplete="off">
                  <label class="text-danger"><span id="msgerr"></span></label>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>

              <input type="hidden" id="get_pass" class="form-control col-md-7 col-xs-12  input-sm" name="get_pass"   value="">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">NEW PASSWORD</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="password" class="form-control col-md-7 col-xs-12  input-sm" name="new_pass" id="new_pass" required="" minlength="4" value="">
                  <label class="text-danger"><span id="msgerr_new_pass"></span></label>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">CONFIRM NEW PASSWORD</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="password" class="form-control col-md-7 col-xs-12  input-sm" name="conf_pass" id="conf_pass" required="" minlength="4" value="">
                </div>
                  <div class="col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>

              <div  style="height: 40px;background-color: #e6f2ff;padding-top: 10px;padding-left: 10px;font-size: 15px;text-align: center;"><b><label class="text-success"><p id="msg"></p></label></b></div>
              <br>

              <div class="form-group text-center" >
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                   <button type="button" class="btn bg-red btn-flat" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Close</button>
                  <button type="submit"  name="btn_change" id="btn_change" class="btn btn-primary btn-flat"/><i class="glyphicon glyphicon-plus"></i> Change</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- modal change picture -->
<div class="modal fade" id="chgPict" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
        <div class="modal-body">
          <div class="box box-solid box-primary">
            <div class="box-header">
                <h3 class="box-title" ><i class="glyphicon glyphicon-lock"></i> &nbsp;CHANGE IMAGE</h3>
            </div><br>
            <form method="post" id="update_pict" class="form-horizontal form-label-left">  
              <img src="<?php echo base_url('upload/img_user/'. $this->session->userdata('image'));?>" class="profile-user-img img-responsive" alt="User Image" style="width: 180px;height: 225px">
              <div class="form-group" style="margin-left: 8px"><br>
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">SELECT_IMAGE</label>
                  <input type="file" name="user_image" id="user_image" value="0" required="" />  
              <span id="user_uploaded_image"></span>  
              </div>
              <div  style="height: 40px;background-color: #e6f2ff;padding-top: 10px;padding-left: 10px;font-size: 15px;text-align: center;"><b><label class="text-success"><p id="msg_chgpict"></p></label></b></div>
              <br>

              <div class="form-group text-center" >
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                   <button type="button" class="btn bg-red btn-flat" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Close</button>
                  <button type="submit"  name="btn_change_pict" id="btn_change_pict" class="btn btn-primary btn-flat"/><i class="glyphicon glyphicon-plus"></i> Change</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>