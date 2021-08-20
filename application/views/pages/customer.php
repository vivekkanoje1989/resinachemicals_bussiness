<div class="row">
	<div class="col-sm-12 col-md-12">
		<div class="card  mb-4">
			<div class="card-body">
				<h5 class="card-title text-center"><button class="btn btn-lg btn-block btn-secondary" id="idBtnAddNewCustomer"
					 title="Add New Customer">Customer</button></h5>
				<div id="idAlertDiV"></div>
				<table id="idCustomerSummary" class="table table-striped table-bordered" style="width:100%">
					<thead>
						<tr>
							<th>Sr. No.</th>
							<th>Customer Name</th>
							<th>City</th>
							<th>State</th>
							<th>Mobile</th>
							<th>Email</th>
							<th width="23%">Action</th>
						</tr>
					</thead>
					<tbody id="idCustomerSummaryBody">
						<tr>
							<td class="text-center" colspan="7">No Records</td>						
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!--Modal: Name-->
<div class="modal fade" id="idAddNewCustomerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">

		<!--Content-->
		<div class="modal-content">

			<!--Body-->
			<div class="modal-body mb-0 p-8">

				<form>
					<input style="display: none;" id="idCustomerID">
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
						<div class="form-group col-md-3">
							<label for="inputMobile">Mobile</label>
							<input type="text" class="form-control" id="inputMobile" placeholder="Mobile">
						</div>
						<div class="form-group col-md-3">
							<label for="inputAltMobile">Alternate Mobile</label>
							<input type="text" class="form-control" id="inputAltMobile" placeholder="alternate Mobile">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="inputGendar">Gendar</label>
							<select class="form-control" id="inputGendar">
								<option value="Male">Male</option>
								<option value="Female">Female</option>
								<option value="Transgendar">Transgendar</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="inputStateCode">State Code</label>
							<input type="text" class="form-control" id="inputStateCode" placeholder="State Code">
						</div>
						<div class="form-group col-md-4">
							<label for="inputGstInNum">GST IN</label>
							<input type="text" class="form-control" id="inputGstInNum" placeholder="GST IN Number">
						</div>
					</div>
					<div class="form-group">
						<label for="inputAddress">Address</label>
						<input type="text" class="form-control" id="inputAddress" placeholder="Address">
					</div>				
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="inputCity">City</label>
							<input type="text" class="form-control" id="inputCity" placeholder="City">
						</div>
						<div class="form-group col-md-4">
							<label for="inputState">State</label>
							<input type="text" class="form-control" id="inputState" placeholder="State">
						</div>
						<div class="form-group col-md-4">
							<label for="inputZip">Zip</label>
							<input type="text" class="form-control" id="inputZip" placeholder="Zip code">
						</div>
					</div>
					
				</form>
				<div id="idModalAlertDiV"></div>
			</div>
			<div class="classLoader" style="display: none;"><i class="fa fa-spinner fa-spin"></i>Processing...</div>
			<!--Footer-->
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-outline-secondary btn-rounded btn-md ml-4" id="idBtnSubmitCustomer">Add</button>
				<button type="button" class="btn btn-outline-primary btn-rounded btn-md ml-4" data-dismiss="modal">Close</button>
			</div>

		</div>
		<!--/.Content-->
	</div>
</div>
<!--Modal: Name-->

<script>
	// var userID = "< ?php if(isset($userID)){ echo $userID; }else{ echo 0; } ?>";
	// var base_url = "< ?php echo base_url(); ?>";
	var customerDataTable = '';
	$(document).ready(function () {

		customerDataTable = $('#idCustomerSummary').DataTable({
			"ajax":{
			    url :  "<?php echo base_url(); ?>pages/getAllCustomersForDataTable",
			    type : 'GET',
				data:{
					userID: userID
				}
			},
			// "footerCallback": function ( row, data, start, end, display ) {
			// },
			// serverSide: false,
			paging: true,
			// destroy: true,
			// scrollY: 400,
            scrollX: 400
		});

		$(document).on('click', '#idBtnAddNewCustomer', function () {
			$('#idAddNewCustomerModal').modal('show');
			// reset all form fields
			let resetArray = [{"id": "inputFname", "type": "input"}, {"id": "inputLname", "type": "input"},	{"id": "inputEmail", "type": "input"},{"id": "inputMobile", "type": "input"},{"id": "inputAltMobile", "type": "input"},{"id": "inputGendar", "type": "select"},{"id": "inputStateCode", "type": "input"},{"id": "inputGstInNum", "type": "input"},{"id": "inputAddress", "type": "input"},{"id": "inputCity", "type": "input"},{"id": "inputState", "type": "input"},{"id": "inputZip", "type": "input"}];
			
			$.each(resetArray, function(index, val){
				if('id' in val ){
					resetFields(val.id, null, val.type);
				}

				if('class' in val ){
					resetFields(null, val.class, val.type);
				}
			});
			//Remove validation class
			$('#idAddNewCustomerModal input').removeClass('is-valid');
			$('#idAddNewCustomerModal input').removeClass('is-invalid');
			$('#idAddNewCustomerModal select').removeClass('is-valid');
			$('#idAddNewCustomerModal select').removeClass('is-invalid');
			//Set add data
			$('#idAddNewCustomerModal #idBtnSubmitCustomer').show();
			$('#idAddNewCustomerModal #idBtnSubmitCustomer').text('Add');			
			$('#idAddNewCustomerModal #idCustomerID').val(0);		
		});

		$(document).on('click', '.btnUpdateModal', function(){
			$('#idAddNewCustomerModal').modal('show');
			// reset all form fields
			let resetArray = [{"id": "inputFname", "type": "input"}, {"id": "inputLname", "type": "input"},	{"id": "inputEmail", "type": "input"},{"id": "inputMobile", "type": "input"},{"id": "inputAltMobile", "type": "input"},{"id": "inputGendar", "type": "select"},{"id": "inputStateCode", "type": "input"},{"id": "inputGstInNum", "type": "input"},{"id": "inputAddress", "type": "input"},{"id": "inputCity", "type": "input"},{"id": "inputState", "type": "input"},{"id": "inputZip", "type": "input"}];
			
			$.each(resetArray, function(index, val){
				if('id' in val ){
					resetFields(val.id, null, val.type);
				}

				if('class' in val ){
					resetFields(null, val.class, val.type);
				}
			});
			//Remove validation class
			$('#idAddNewCustomerModal input').removeClass('is-valid');
			$('#idAddNewCustomerModal input').removeClass('is-invalid');
			$('#idAddNewCustomerModal select').removeClass('is-valid');
			$('#idAddNewCustomerModal select').removeClass('is-invalid');

			//Data to modal fields
			$('#idAddNewCustomerModal #idBtnSubmitCustomer').show();
			$('#idAddNewCustomerModal #idBtnSubmitCustomer').text('Update');
			$('#idAddNewCustomerModal #idCustomerID').val($(this).attr('data-customer_id'));

			setCustomerModal($(this).attr('data-customer_id'));
		});

		$(document).on('click', '.btnViewModal', function(){
			$('#idAddNewCustomerModal').modal('show');
			// reset all form fields
			let resetArray = [{"id": "inputFname", "type": "input"}, {"id": "inputLname", "type": "input"},	{"id": "inputEmail", "type": "input"},{"id": "inputMobile", "type": "input"},{"id": "inputAltMobile", "type": "input"},{"id": "inputGendar", "type": "select"},{"id": "inputStateCode", "type": "input"},{"id": "inputGstInNum", "type": "input"},{"id": "inputAddress", "type": "input"},{"id": "inputCity", "type": "input"},{"id": "inputState", "type": "input"},{"id": "inputZip", "type": "input"}];
			
			$.each(resetArray, function(index, val){
				if('id' in val ){
					resetFields(val.id, null, val.type);
				}

				if('class' in val ){
					resetFields(null, val.class, val.type);
				}
			});
			//Remove validation class
			$('#idAddNewCustomerModal input').removeClass('is-valid');
			$('#idAddNewCustomerModal input').removeClass('is-invalid');
			$('#idAddNewCustomerModal select').removeClass('is-valid');
			$('#idAddNewCustomerModal select').removeClass('is-invalid');

			//Data to modal fields
			$('#idAddNewCustomerModal #idBtnSubmitCustomer').hide();
			$('#idAddNewCustomerModal #idCustomerID').val($(this).attr('data-customer_id'));
			setCustomerModal($(this).attr('data-customer_id'));
		});

		$(document).on('click', '#idBtnSubmitCustomer', function(){
			let btnAction = $(this).text();

			let fname = $('#inputFname').val();
			let lname = $('#inputLname').val();
			let email = $('#inputEmail').val();
			let mobile = $('#inputMobile').val();
			let altMobile = $('#inputAltMobile').val();
			let gendar = $('#inputGendar').val();
			let stateCode = $('#inputStateCode').val();
			let gstInNum = $('#inputGstInNum').val();
			let address = $('#inputAddress').val();
			let city = $('#inputCity').val();
			let state = $('#inputState').val();
			let zip = $('#inputZip').val();	

			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
			var tenDigitMobileNoReg = /^[1-9]\d{9}$/; //ten digit mobile number
			var twoDigitStateCodeReg = /^[0-9]\d{1}$/; //two digit state code
			var fifteenDigitGSTINCodeReg = /^[A-Za-z0-9]{15}$/;
			var addressReg = /^\s*[a-zA-Z0-9,.-\s]+\s*$/;
			var onlyLetterReg = /^\s*[a-zA-Z\s]+\s*$/;
			var zipCodeReg = /^[0-9]{6}$/;

			if(fname == '' && !fname){
				$('#inputFname').removeClass('is-valid');
				$('#inputFname').addClass('is-invalid');
				return false;
			}else{
				$('#inputFname').removeClass('is-invalid');
				$('#inputFname').addClass('is-valid');
			} 
			
			if(lname == '' && !lname){
				$('#inputLname').removeClass('is-valid');
				$('#inputLname').addClass('is-invalid');
				return false;
			}else{
				$('#inputLname').removeClass('is-invalid');
				$('#inputLname').addClass('is-valid');
			} 
			
			if(email == '' && !email){
				$('#inputEmail').removeClass('is-valid');
				$('#inputEmail').addClass('is-invalid');
				return false;
			}else{
				if(!emailReg.test(email)){
					$('#inputEmail').removeClass('is-valid');
					$('#inputEmail').addClass('is-invalid');
					showMsg('Not a valid email format !', 'error', 'idModalAlertDiV');
					return false;
				}else{
					$('#inputEmail').removeClass('is-invalid');
					$('#inputEmail').addClass('is-valid');
				}			
			} 
			
			if(mobile == '' && !mobile){
				$('#inputMobile').removeClass('is-valid');
				$('#inputMobile').addClass('is-invalid');
				return false;
			}else{
				if(!tenDigitMobileNoReg.test(mobile)){
					$('#inputMobile').removeClass('is-valid');
					$('#inputMobile').addClass('is-invalid');
					showMsg('Enter a valid mobile number', 'error', 'idModalAlertDiV');
					return false;
				}else{
					$('#inputMobile').removeClass('is-invalid');
					$('#inputMobile').addClass('is-valid');
				}				
			} 

			if(altMobile){
				if(!tenDigitMobileNoReg.test(altMobile)){
					$('#inputAltMobile').removeClass('is-valid');
					$('#inputAltMobile').addClass('is-invalid');
					showMsg('Enter a valid alternate mobile number', 'error', 'idModalAlertDiV');
					return false;
				}else{
					$('#inputAltMobile').removeClass('is-invalid');
					$('#inputAltMobile').addClass('is-valid');
				}				
			}			
			
			if(gendar == '' && !gendar){
				$('#inputGendar').removeClass('is-valid');
				$('#inputGendar').addClass('is-invalid');
				return false;
			}else{
				$('#inputGendar').removeClass('is-invalid');
				$('#inputGendar').addClass('is-valid');
			}

			if(stateCode == '' && !stateCode){
				$('#inputStateCode').removeClass('is-valid');
				$('#inputStateCode').addClass('is-invalid');
				return false;
			}else{
				if(!twoDigitStateCodeReg.test(stateCode) || (parseInt(stateCode) > 35 )){
					$('#inputStateCode').removeClass('is-valid');
					$('#inputStateCode').addClass('is-invalid');
					showMsg('Enter a valid state code for INDIA', 'error', 'idModalAlertDiV');
					return false;
				}else{
					$('#inputStateCode').removeClass('is-invalid');
					$('#inputStateCode').addClass('is-valid');
				}				
			}
			
			if(gstInNum == '' && !gstInNum){
				$('#inputGstInNum').removeClass('is-valid');
				$('#inputGstInNum').addClass('is-invalid');
				return false;
			}else{
				if(!fifteenDigitGSTINCodeReg.test(gstInNum)){
					$('#inputGstInNum').removeClass('is-valid');
					$('#inputGstInNum').addClass('is-invalid');
					showMsg('Enter a valid GSTIN code.', 'error', 'idModalAlertDiV');
					return false;
				}else{
					if(stateCode != '' && stateCode){
						first2Digit = gstInNum.match(/^\d\d/);
						if(stateCode != first2Digit){
							$('#inputGstInNum').removeClass('is-valid');
							$('#inputGstInNum').addClass('is-invalid');
							showMsg('Enter a valid GSTIN code for entered state code.', 'error', 'idModalAlertDiV');
							return false;
						}else{
							$('#inputGstInNum').removeClass('is-invalid');
							$('#inputGstInNum').addClass('is-valid');
						}
					}else{
						$('#inputGstInNum').removeClass('is-invalid');
						$('#inputGstInNum').addClass('is-valid');
					}					
				}				
			} 
			
			if(address == '' && !address){
				$('#inputAddress').removeClass('is-valid');
				$('#inputAddress').addClass('is-invalid');
				return false;
			}else{
				if(!addressReg.test(address)){
					$('#inputAddress').removeClass('is-valid');
					$('#inputAddress').addClass('is-invalid');
					showMsg('Special characters are not allowed.', 'error', 'idModalAlertDiV');
					return false;
				}else{
					$('#inputAddress').removeClass('is-invalid');
					$('#inputAddress').addClass('is-valid');
				}
			} 

			if(city == '' && !city){
				$('#inputCity').removeClass('is-valid');
				$('#inputCity').addClass('is-invalid');
				return false;
			}else{
				if(!onlyLetterReg.test(city)){
					$('#inputCity').removeClass('is-valid');
					$('#inputCity').addClass('is-invalid');
					showMsg('Only letters are allowed.', 'error', 'idModalAlertDiV');
					return false;
				}else{
					$('#inputCity').removeClass('is-invalid');
					$('#inputCity').addClass('is-valid');
				}				
			} 
			
			if(state == '' && !state){
				$('#inputState').removeClass('is-valid');
				$('#inputState').addClass('is-invalid');
				return false;
			}else{
				if(!onlyLetterReg.test(state)){
					$('#inputState').removeClass('is-valid');
					$('#inputState').addClass('is-invalid');
					showMsg('Only letters are allowed.', 'error', 'idModalAlertDiV');
					return false;
				}else{
					$('#inputState').removeClass('is-invalid');
					$('#inputState').addClass('is-valid');
				}		
			}
			
			if(zip == '' && !zip){
				$('#inputZip').removeClass('is-valid');
				$('#inputZip').addClass('is-invalid');
				return false;
			}else{
				if(!zipCodeReg.test(zip)){
					$('#inputZip').removeClass('is-valid');
					$('#inputZip').addClass('is-invalid');
					showMsg('Enter a valid zipcode.', 'error', 'idModalAlertDiV');
					return false;
				}else{
					$('#inputZip').removeClass('is-invalid');
					$('#inputZip').addClass('is-valid');
				}				
			}	
			
			let actionURL = ''; 
			let successMsg = ''; 
			let errorMsg = '';
			let customerId = 0;

			if(btnAction == 'Add'){
				actionURL = "<?php echo base_url(); ?>pages/addNewCustomer";
				successMsg = 'Customer added successfully.'; 
				errorMsg = 'Customer can not be added.'; 
			}else if(btnAction == 'Update'){
				actionURL = "<?php echo base_url(); ?>pages/updateCustomer";
				successMsg = 'Customer updated successfully.'; 
				errorMsg = 'Customer can not be updated.'; 
				customerId = $('#idCustomerID').val();
			}

			$.ajax({
                type: "POST",
                url: actionURL, 
                data: {customerId: customerId, fname: fname,lname: lname,email: email,mobile: mobile, altMobile: altMobile, gendar: gendar,stateCode: stateCode,gstInNum: gstInNum,address: address,city: city,state: state,zip: zip, userID: userID},
                dataType: "json",  
                cache:false,
                success: 
                    function(data){
						$('#idAddNewCustomerModal').modal('hide');					
						customerDataTable.draw();//
						customerDataTable.ajax.reload();
                        showMsg(successMsg, 'success', 'idAlertDiV');
                    },
                error:
                    function(data){
                        showMsg(errorMsg, 'error', 'idModalAlertDiV');
                    }
            });	
		});		

		$(document).on('click', '.btnDeleteRecord', function(){
			if(confirm('Do you want to delete this customer ?')){
				let customerId = $(this).attr('data-customer_id');
				let actionURL = "<?php echo base_url(); ?>pages/deleteCustomer";
				let successMsg = 'Customer deleted successfully.'; 
				let errorMsg = 'Customer can not be deleted.'; 
				$.ajax({
					type: "POST",
					url: actionURL, 
					data: {customerId: customerId, userID: userID},
					dataType: "json",  
					cache:false,
					success: 
						function(data){                 
							// customerDataTable.draw(false);
							customerDataTable.ajax.reload();
							showMsg(successMsg, 'success', 'idAlertDiV');
						},
					error:
						function(data){
							showMsg(errorMsg, 'error', 'idAlertDiV');
						}
				});
			}
		});
	});

	function setCustomerModal(customerId){
		if(customerId){
			let actionURL = "<?php echo base_url(); ?>pages/getCustomersByID";
			$.ajax({
				type: "POST",
				url: actionURL, 
				data: {customerId: customerId, userID: userID},
				dataType: "json",  
				cache:false,
				success: 
					function(data){   
						if(data.length > 0){
							$.each(data, function(index, value){
								$('#inputFname').val(value.first_name);
								$('#inputLname').val(value.last_name);
								$('#inputEmail').val(value.email);
								$('#inputMobile').val(value.mobile);
								$('#inputAltMobile').val(value.alt_mobile);
								$('#inputGendar').val(value.gendar);
								$('#inputStateCode').val(value.state_code);
								$('#inputGstInNum').val(value.gst_in_number);
								$('#inputAddress').val(value.address);
								$('#inputCity').val(value.city);
								$('#inputState').val(value.state);
								$('#inputZip').val(value.pin);	
							});
						}
					},
				error:
					function(data){
						console.log("data", data); 
					}
			});
		}
	}
</script>
