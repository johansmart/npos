 <form method="post" id="user_form" class="form-horizontal form-label-left">  
            <div class="form-group">
              <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">USERID</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="user_id" class="form-control col-md-7 col-xs-12  input-sm" name="user_id" placeholder="exmp : 100135087" required="" autocomplete="off">
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
                  <input type="password" class="form-control col-md-7 col-xs-12  input-sm" name="password" id="password" required="" minlength="4">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">ROLE</label> 
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control select-sm" id="role" name="role" required="">
                    <option></option>
                    <option>0 STAFF</option>
                    <option>1 MANAGER</option>
                    <option>2 SGM</option>
                    <option>3 ADMIN</option>
                </select>
                </div>
              </div>
              <div class="form-group" style="margin-left: 8px">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">SELECT_IMAGE</label>
                  <input type="file" name="user_image" id="user_image"  />  
              <span id="user_uploaded_image"></span>  
              </div>
             
              <div  style="height: 40px;background-color: #e6f2ff;padding-top: 10px;padding-left: 10px;font-size: 15px;text-align: center;"><b><label class="text-success"><p id="msg"></p></label></b></div>
              <br>

              <div class="form-group" align="right">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                   <button type="button" class="btn bg-red btn-flat" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Close</button>
                  <button class="btn btn-warning btn-flat" type="reset"><i class="glyphicon glyphicon-refresh"></i> Reset</button>
                  <button type="submit" name="action" id="action" class="btn btn-primary btn-flat" value="Add" /><i class="glyphicon glyphicon-plus"></i> Add</button>
                </div>
              </div>