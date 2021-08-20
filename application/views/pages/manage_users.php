<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card  mb-4">
            <div class="card-body">
            <h5 class="card-title text-center"><button class="btn btn-lg btn-block btn-secondary" id="idBtnAddNewUser"
					 title="Add New User">Users</button></h5>
                <table id="idUserSummary" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th width="10%">Sr. No.</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Password</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="idUserSummaryBody"></tbody>     
                </table>
            </div>
        </div>
    </div>
</div>

<!--Modal: Name-->
<div class="modal fade" id="idAddNewUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">

		<!--Content-->
		<div class="modal-content">

			<!--Body-->
			<div class="modal-body mb-0 p-8">

				<form>
					<input style="display: none;" id="idUserID">
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputFname">First name</label>
							<input type="text" class="form-control" id="inputFname" placeholder="First name">
						</div>
						<div class="form-group col-md-6">
							<label for="inputLname">Last Name</label>
							<input type="text" class="form-control" id="inputLname" placeholder="Last Name">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputEmail">Email</label>
							<input type="email" class="form-control" id="inputEmail" placeholder="Email">
						</div>
						<div class="form-group col-md-6">
							<label for="inputMobile">Mobile</label>
							<input type="text" class="form-control" id="inputMobile" placeholder="Mobile">
						</div>
					</div>
                    <div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputUsername">Username</label>
							<input type="text" class="form-control" id="inputUsername" placeholder="Username">
						</div>
						<div class="form-group col-md-3">
							<label for="inputPassword">Password</label>
							<input type="password" class="form-control" id="inputPassword" placeholder="Password">
						</div>
                        <div class="form-group col-md-3">
							<label for="inputUserType">User Type</label>
                            <select id="inputUserType" class="form-control">
                                <option value="0">User</option>
                                <option value="1">Admin</option>
                            </select>
						</div>
					</div>
					
				</form>
				<div id="idModalAlertDiV"></div>
			</div>
			<div class="classLoader" style="display: none;"><i class="fa fa-spinner fa-spin"></i>Processing...</div>
			<!--Footer-->
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-outline-secondary btn-rounded btn-md ml-4" id="idBtnSubmitUser">Add</button>
				<button type="button" class="btn btn-outline-primary btn-rounded btn-md ml-4" data-dismiss="modal">Close</button>
			</div>

		</div>
		<!--/.Content-->
	</div>
</div>
<!--Modal: Name-->


<script type="text/javascript">
    $(document).ready(function(){
        oUsersTable();
        $(document).on('click', '#idBtnAddNewUser', function(){
            $('#idAddNewUserModal').modal('show');
            $('#idAddNewUserModal #idUserID').val(0);
            $('#idAddNewUserModal input').val('');
            $('#idAddNewUserModal select').val(0);
        });

        $(document).on('click', '.classDeleteUserBtn', function(){
            deleteUser($(this).attr('data-id'));
        });   
        
        $(document).on('click', '.classUpdateUserBtn', function(){
            setUser($(this).attr('data-id'));
        });

        $(document).on('click', '#idBtnSubmitUser', function(){
            let ID = $('#idAddNewUserModal #idUserID').val();
            addUpdateUser(ID);
        });
        
    })

    function oUsersTable(){
        $('#idUserSummary').DataTable( {
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ordering": false,
            "ajax":{
                url :  "<?php echo base_url(); ?>pages/getAllUserForDataTable",
                type : 'GET',
                data: {
                    userID: userID
                }
            },           
            paging: true,
            scrollX: 400,
            destroy: true
        } );
    }

    function validateForm(formID){
        console.log("validate : ", $('#'+formID+' #inputFname').val());
        if($('#'+formID+' #inputFname').val() == ''){
			showToastAlert("red", "fa fa-times", "Error", "First name required.");
            return false;
        }else if($('#'+formID+' #inputLname').val() == ''){
			showToastAlert("red", "fa fa-times", "Error", "Last name required.");
            return false;
        }else if($('#'+formID+' #inputUsername').val() == ''){
            showToastAlert("red", "fa fa-times", "Error", "Username required.");
            return false;
        }else if($('#'+formID+' #inputPassword').val() == ''){
            showToastAlert("red", "fa fa-times", "Error", "Password required.");
            return false;
        }else{
            return true;
        }
    }

    function setUser(ID){
        if(ID > 0){
            var actionURL = "<?php echo base_url(); ?>pages/getUserByID";
            $.ajax({
                type: "POST",
                url: actionURL, 
                data: {ID: ID, userID: userID},
                dataType: "json",  
                cache:false,
                success: 
                    function(data){
                        if(data.length > 0){
                            $('#idAddNewUserModal').modal('show');
                            $('#idAddNewUserModal input').val('');
                            $('#idAddNewUserModal select').val(0);
                            $('#idAddNewUserModal #idUserID').val(ID);
                            $('#idAddNewUserModal #idBtnSubmitUser').text('Update');
                            $('#idAddNewUserModal #inputFname').val(data[0].fname);
                            $('#idAddNewUserModal #inputLname').val(data[0].lname);
                            $('#idAddNewUserModal #inputEmail').val(data[0].email);
                            $('#idAddNewUserModal #inputUsername').val(data[0].username);
                            $('#idAddNewUserModal #inputPassword').val(data[0].password);
                            $('#idAddNewUserModal #inputMobile').val(data[0].mobile);
                            $('#idAddNewUserModal #inputUserType').val(data[0].user_type);
                        }
                    },
                error:
                    function(data){
                        console.log("Error : ", data);
                    }
            });
        }
    }

    function addUpdateUser(ID){
        var valFrm = validateForm('idAddNewUserModal');
        let fname = $('#idAddNewUserModal #inputFname').val();
        let lname = $('#idAddNewUserModal #inputLname').val();
        let email = $('#idAddNewUserModal #inputEmail').val();
        let username = $('#idAddNewUserModal #inputUsername').val();
        let password = $('#idAddNewUserModal #inputPassword').val();
        let mobile = $('#idAddNewUserModal #inputMobile').val();
        let userType = $('#idAddNewUserModal #inputUserType').val();
        if(valFrm){
            actionURL = ""; 
            if(ID > 0){
                actionURL = "<?php echo base_url(); ?>pages/updateUser";
            } else{
                actionURL = "<?php echo base_url(); ?>pages/addUser";
            }
            $.ajax({
                type: "POST",
                url: actionURL, 
                data: {ID: ID, fname: fname, lname: lname, email: email, username:username, password: password, mobile: mobile, userType: userType, userID: userID},
                dataType: "json",  
                cache:false,
                success: 
                    function(data){
                        if(data.success){
                            showToastAlert("green", "fa fa-check", "Success", data.success);
                            $('#idAddNewUserModal').trigger('reset'); // reset form
                            $('#idAddNewUserModal').modal('hide');
                            oUsersTable();
                        }else if(data.error){
                            showToastAlert("red", "fa fa-times", "Error", data.error);
                        }
                    },
                error:
                    function(data){
                        showToastAlert("red", "fa fa-times", "Error", "Unable to delete User.");
                    }
            });
        }
    }

    function deleteUser(delUserID){
        if(confirm('Do you want to delete user ?')){  
            actionURL = "<?php echo base_url(); ?>pages/deleteUser";      
            $.ajax({
                type: "POST",
                url: actionURL, 
                data: {delUserID: delUserID, userID: userID},
                dataType: "json",  
                cache:false,
                success: 
                    function(data){
                        if(data.success){
                            showToastAlert("green", "fa fa-check", "Success", data.success);
                            oUsersTable();
                        }else if(data.error){
                            showToastAlert("red", "fa fa-times", "Error", data.error);
                        }
                    },
                error:
                    function(data){
                        showToastAlert("red", "fa fa-times", "Error", "Unable to delete User.");
                    }
            });
        }
    }
</script>