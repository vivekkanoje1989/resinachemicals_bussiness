<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/avatar.css">
<div class="row">
	<div class="col-sm-12 col-md-12">
		<div class="card  mb-4">
			<div class="card-body">
				<h5 class="card-title text-center"><button class="btn btn-lg btn-block btn-secondary" id="idBtnAddNewProduct"
					 title="Add New Product">Product</button></h5>
				<div id="idAlertDiV"></div>
				<table id="idProductSummary" class="table table-striped table-bordered" style="width:100%">
					<thead>
						<tr>
							<th>Sr. No.</th>
							<th>Product Name</th>
							<th>HSN Code</th>
							<th>Rate</th>
							<th>Effective From Date</th>
							<th>Effective upto Date</th>
							<th width="20%">Action</th>
						</tr>
					</thead>
					<tbody id="idProductSummaryBody">
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
<div class="modal fade" id="idAddNewProductModal" role="dialog" aria-labelledby="myModalLabel"
 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">

		<!--Content-->
		<div class="modal-content">

			<!--Body-->
			<div class="modal-body mb-0 p-8">

				<form id="idProductForm" method="post" enctype="multipart/form-data">
					<input style="display: none;" id="idProductID" name="productId">
					<input style="display: none;" id="userID" name="userID" value="<?php if(isset($userID)){ echo $userID; }else{ echo 0; }  ?>">
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputFname">Product name</label>
							<input type="text" class="form-control" id="inputProductName" name="productName" placeholder="Product name">
						</div>
						<div class="form-group col-md-6">
							<label for="inputLname">HSN Code</label>
							<input type="text" class="form-control" id="inputHsnCode" name="hsnCode" placeholder="HSN Code">
						</div>
					</div>
					
					<div class="form-row">
                        <div class="form-group col-md-4">
							<label for="inputQuantity">Quantity</label>
							<input type="text" class="form-control" id="inputQuantity" name="quantity" placeholder="Quantity">
						</div>
						<div class="form-group col-md-4">
							<label for="inputUnit">Unit</label>
							<select class="form-control" id="inputUnit" name="unit">
								<option value="ML">ML</option>
								<option value="KG">KG</option>
								<option value="LTR">LTR</option>
							</select>
						</div>						
						<div class="form-group col-md-4">
							<label for="inputRate">Rate</label>
							<input type="text" class="form-control" id="inputRate" name="rate" placeholder="Rate">
						</div>
					</div>

					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="isOfferAvailable" id="idIsOfferAvailable" value="1" >
						<label class="form-check-label" for="idIsOfferAvailable">
							<em>Apply offer period</em>
						</label>
					</div>

                    <div class="form-row classIsOfferAvail">
						<div class="form-group col-md-4">
							<label for="inputRate">Offer Rate</label>
							<input type="text" class="form-control" id="inputOfferRate" name="OfferRate" placeholder="Offer Rate">
						</div>
						<div class="form-group col-md-4">
							<label for="inputEfctFromDate">Effective From Date</label>
							<input type="email" class="form-control" id="inputEfctFromDate" name="efctFromDate"  placeholder="Effective from date">
						</div>
						<div class="form-group col-md-4">
							<label for="inputEfctToDate">Effective upto Date</label>
							<input type="text" class="form-control" id="inputEfctToDate" name="efctToDate" placeholder="Effective to date">
						</div>
					</div>

					<div class="container">
						<small><em>Upload a Product Image</em></small>
						<div class="avatar-upload">
							<div class="avatar-edit">
								<input type='file' id="imageProductUpload" name="imageProductUpload" accept=".png, .jpg, .jpeg, .gif" />
								<label for="imageProductUpload"></label>
							</div>
							<div class="avatar-preview">
								<div id="imagePreview" style="background-image: url('<?php echo base_url(); ?>assets/images/upload_animation_default.gif');">
								</div>
							</div>
						</div>
					</div>
				</form>
				<div id="idModalAlertDiV"></div>
			</div>
			<div class="classLoader" style="display: none;"><i class="fa fa-spinner fa-spin"></i>Processing...</div>
			<!--Footer-->
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-outline-secondary btn-rounded btn-md ml-4" id="idBtnSubmitProduct">Add</button>
				<button type="button" class="btn btn-outline-primary btn-rounded btn-md ml-4" data-dismiss="modal">Close</button>
			</div>

		</div>
		<!--/.Content-->
	</div>
</div>
<!--Modal: Name-->

<script>
	// var userID = "< ?php if(isset($userID)){ echo $userID; }else{ echo 0; } ?>";
	var MAX_UPLOAD_SIZE_PRODUCT_IMG_BYTE = "<?php echo MAX_UPLOAD_SIZE_PRODUCT_IMG_BYTE; ?>";
	var MAX_UPLOAD_SIZE_PRODUCT_IMG_MB = "<?php echo MAX_UPLOAD_SIZE_PRODUCT_IMG_MB; ?>";
	var productDataTable = '';
	let actionURL = ''; 
	let successMsg = ''; 
	let errorMsg = '';
	let productId = 0;
	$(document).ready(function () {

		$('#inputEfctFromDate').datepicker({
			autoclose: true,
			format: 'dd-mm-yyyy',
			todayBtn: 'linked',
			todayHighlight: true,
			keyboardNavigation: true
		});

		$('#inputEfctToDate').datepicker({
			autoclose: true,
			format: 'dd-mm-yyyy',
			todayBtn: 'linked',
			todayHighlight: true,
			keyboardNavigation: true
		});

		productDataTable = $('#idProductSummary').DataTable({
			"ajax":{
			    url :  "<?php echo base_url(); ?>pages/getAllProductsForDataTable",
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
		
		$(document).on('click', '#idIsOfferAvailable', function () {		
            if($(this).prop("checked") == true){
				$('.classIsOfferAvail').show(700);
            }
            else if($(this).prop("checked") == false){
				$('.classIsOfferAvail').hide(700);
            }
        });

		$(document).on('click', '#idBtnAddNewProduct', function () {
			$('#idAddNewProductModal').modal('show');
			$('.classIsOfferAvail').hide();

			// reset all form fields
			let resetArray = [{"id": "inputProductName", "type": "input"}, {"id": "inputHsnCode", "type": "input"},	{"id": "inputQuantity", "type": "input"},{"id": "inputUnit", "type": "select"},{"id": "inputRate", "type": "input"},{"id": "inputOfferRate", "type": "input"},{"id": "idIsOfferAvailable", "type": "checkbox"},{"id": "inputEfctFromDate", "type": "input"},{"id": "inputEfctToDate", "type": "input"}];
			
			$.each(resetArray, function(index, val){
				if('id' in val ){
					resetFields(val.id, null, val.type);
				}

				if('class' in val ){
					resetFields(null, val.class, val.type);
				}
			});
			//Remove validation class
			$('#idAddNewProductModal input').removeClass('is-valid');
			$('#idAddNewProductModal input').removeClass('is-invalid');
			$('#idAddNewProductModal select').removeClass('is-valid');
			$('#idAddNewProductModal select').removeClass('is-invalid');
			$('.avatar-upload .avatar-preview').css('border', '6px solid #032a981f');
			$('#imageProductUpload').val('');
			$('.avatar-upload .avatar-preview #imagePreview').css('background-image', 'url("<?php echo base_url(); ?>assets/images/upload_animation_default.gif")');
			//Set add data
			$('#idAddNewProductModal #idBtnSubmitProduct').show();
			$('#idAddNewProductModal #idBtnSubmitProduct').text('Add');			
			$('#idAddNewProductModal #idProductID').val(0);		
		});

		$(document).on('click', '.btnUpdateModal', function(){
			$('#idAddNewProductModal').modal('show');
			// reset all form fields
			let resetArray = [{"id": "inputProductName", "type": "input"}, {"id": "inputHsnCode", "type": "input"},	{"id": "inputQuantity", "type": "input"},{"id": "inputUnit", "type": "select"},{"id": "inputRate", "type": "input"},{"id": "inputOfferRate", "type": "input"},{"id": "idIsOfferAvailable", "type": "checkbox"},{"id": "inputEfctFromDate", "type": "input"},{"id": "inputEfctToDate", "type": "input"}];
			
			$.each(resetArray, function(index, val){
				if('id' in val ){
					resetFields(val.id, null, val.type);
				}

				if('class' in val ){
					resetFields(null, val.class, val.type);
				}
			});
			//Remove validation class
			$('#idAddNewProductModal input').removeClass('is-valid');
			$('#idAddNewProductModal input').removeClass('is-invalid');
			$('#idAddNewProductModal select').removeClass('is-valid');
			$('#idAddNewProductModal select').removeClass('is-invalid');
			$('.avatar-upload .avatar-preview').css('border', '6px solid #032a981f');
			$('#imageProductUpload').val('');
			$('.avatar-upload .avatar-preview #imagePreview').css('background-image', 'url("<?php echo base_url(); ?>assets/images/upload_animation_default.gif")');
			//Data to modal fields
			$('#idAddNewProductModal #idBtnSubmitProduct').show();
			$('#idAddNewProductModal #idBtnSubmitProduct').text('Update');
			$('#idAddNewProductModal #idProductID').val($(this).attr('data-product_id'));

			setProductModal($(this).attr('data-product_id'));
		});

		$(document).on('click', '.btnViewModal', function(){
			$('#idAddNewProductModal').modal('show');
			// reset all form fields
			let resetArray = [{"id": "inputProductName", "type": "input"}, {"id": "inputHsnCode", "type": "input"},	{"id": "inputQuantity", "type": "input"},{"id": "inputUnit", "type": "select"},{"id": "inputRate", "type": "input"},{"id": "inputOfferRate", "type": "input"},{"id": "idIsOfferAvailable", "type": "checkbox"},{"id": "inputEfctFromDate", "type": "input"},{"id": "inputEfctToDate", "type": "input"}];
			
			$.each(resetArray, function(index, val){
				if('id' in val ){
					resetFields(val.id, null, val.type);
				}

				if('class' in val ){
					resetFields(null, val.class, val.type);
				}
			});
			//Remove validation class
			$('#idAddNewProductModal input').removeClass('is-valid');
			$('#idAddNewProductModal input').removeClass('is-invalid');
			$('#idAddNewProductModal select').removeClass('is-valid');
			$('#idAddNewProductModal select').removeClass('is-invalid');
			$('.avatar-upload .avatar-preview').css('border', '6px solid #032a981f');
			$('#imageProductUpload').val('');
			$('.avatar-upload .avatar-preview #imagePreview').css('background-image', 'url("<?php echo base_url(); ?>assets/images/upload_animation_default.gif")');
			//Data to modal fields
			$('#idAddNewProductModal #idBtnSubmitProduct').hide();
			$('#idAddNewProductModal #idProductID').val($(this).attr('data-product_id'));
			setProductModal($(this).attr('data-product_id'));
		});

		$(document).on('click', '#idBtnSubmitProduct', function(){
			let btnAction = $(this).text();
			let productName = $('#inputProductName').val();
			let hsnCode = $('#inputHsnCode').val();
			let quantity = $('#inputQuantity').val();
			let unit = $('#inputUnit').val();
			let rate = $('#inputRate').val();
			let offerRate = $('#inputOfferRate').val();
			let efctFromdate = $('#inputEfctFromDate').val();
			let efctTodate = $('#inputEfctToDate').val();
			let productImage = $('#imageProductUpload')[0].files[0];
			let isOfferAvail = $('#idIsOfferAvailable').prop("checked");
			var noSpecialCharReg = /^\s*[a-zA-Z0-9 _-\s]+\s*$/;			
			var numberOnlyReg = /^\s*[0-9 \s]+\s*$/;

			if(productName == '' && !productName){
				$('#inputProductName').removeClass('is-valid');
				$('#inputProductName').addClass('is-invalid');
				return false;
			}else{
				if(!noSpecialCharReg.test(productName)){
					$('#inputProductName').removeClass('is-valid');
					$('#inputProductName').addClass('is-invalid');
					showMsg('Special characters are not allowed', 'error', 'idModalAlertDiV');
					return false;
				}else{
					$('#inputProductName').removeClass('is-invalid');
					$('#inputProductName').addClass('is-valid');
				}			
			} 
			
			if(hsnCode == '' && !hsnCode){
				$('#inputHsnCode').removeClass('is-valid');
				$('#inputHsnCode').addClass('is-invalid');
				return false;
			}else{
				$('#inputHsnCode').removeClass('is-invalid');
				$('#inputHsnCode').addClass('is-valid');
			}			
					
			if(quantity == '' && !quantity){
				$('#inputQuantity').removeClass('is-valid');
				$('#inputQuantity').addClass('is-invalid');
				return false;
			}else{
				if(!numberOnlyReg.test(quantity)){
					$('#inputQuantity').removeClass('is-valid');
					$('#inputQuantity').addClass('is-invalid');
					showMsg('Only numeric value allowed', 'error', 'idModalAlertDiV');
					return false;
				}else{
					$('#inputQuantity').removeClass('is-invalid');
					$('#inputQuantity').addClass('is-valid');
				}				
			} 
			
			if(rate == '' && !rate){
				$('#inputRate').removeClass('is-valid');
				$('#inputRate').addClass('is-invalid');
				return false;
			}else{
				if(!(parseFloat(rate))){
					$('#inputRate').removeClass('is-valid');
					$('#inputRate').addClass('is-invalid');
					showMsg('Enter a valid rate (<em>info! : do not use comma</em>) ', 'error', 'idModalAlertDiV');
					return false;
				}else{
					$('#inputRate').removeClass('is-invalid');
					$('#inputRate').addClass('is-valid');
				}				
			}
			
			if(isOfferAvail){
				
				if(offerRate == '' && !offerRate){
					$('#inputOfferRate').removeClass('is-valid');
					$('#inputOfferRate').addClass('is-invalid');
					return false;
				}else{
					if(!(parseFloat(offerRate))){
						$('#inputOfferRate').removeClass('is-valid');
						$('#inputOfferRate').addClass('is-invalid');
						showMsg('Enter a valid offer rate (<em>info! : do not use comma</em>) ', 'error', 'idModalAlertDiV');
						return false;
					}else{
						$('#inputOfferRate').removeClass('is-invalid');
						$('#inputOfferRate').addClass('is-valid');
					}
				}

				if(efctFromdate == '' && !efctFromdate){
					$('#inputEfctFromDate').removeClass('is-valid');
					$('#inputEfctFromDate').addClass('is-invalid');
					return false;
				}else{
					$('#inputEfctFromDate').removeClass('is-invalid');
					$('#inputEfctFromDate').addClass('is-valid');
				}

				if(efctTodate == '' && !efctTodate){
					$('#inputEfctToDate').removeClass('is-valid');
					$('#inputEfctToDate').addClass('is-invalid');
					return false;
				}else{
					$('#inputEfctToDate').removeClass('is-invalid');
					$('#inputEfctToDate').addClass('is-valid');
				}
			}
		
			prdStartDate = efctFromdate.split('-');
			prdEndDate = efctTodate.split('-');
			var effStartDate = new Date(prdStartDate[2],(prdStartDate[1] - 1),prdStartDate[0]);
			var effEndDate = new Date(prdEndDate[2],(prdEndDate[1] - 1),prdEndDate[0]);

			if(effEndDate < effStartDate) {
				$('#inputEfctToDate').removeClass('is-valid');
				$('#inputEfctToDate').addClass('is-invalid');
				showMsg('Upto date should not be lesser than from date', 'error', 'idModalAlertDiV');
				return false;
			}else{
				$('#inputEfctToDate').removeClass('is-invalid');
				$('#inputEfctToDate').addClass('is-valid');
			}			
				
			if(productImage){
				let imageSize = productImage.size;
				let aParts = (productImage.name).split('.');
				let apartLength = aParts.length;
				let fileExt = aParts[apartLength - 1];
				let aValidExt = ["gif", "jpeg", "jpg", "png", "svg"];
			
				if(aValidExt.indexOf(fileExt) > -1){
					$('.avatar-upload .avatar-preview').css('border', '6px solid lightgreen');
				}else{
					$('.avatar-upload .avatar-preview').css('border', '6px solid coral');
					showMsg(fileExt+' : files are not allowed', 'error', 'idModalAlertDiV');
					return false;	
				}

				if(imageSize > MAX_UPLOAD_SIZE_PRODUCT_IMG_BYTE){
					$('.avatar-upload .avatar-preview').css('border', '6px solid coral');
					showMsg(imageSize+' :byte files size is not allowed (Should be less than '+MAX_UPLOAD_SIZE_PRODUCT_IMG_MB+'='+MAX_UPLOAD_SIZE_PRODUCT_IMG_BYTE+' byte)', 'error', 'idModalAlertDiV');
					return false;
				}else{
					$('.avatar-upload .avatar-preview').css('border', '6px solid lightgreen');
				}

			}else{
				if(btnAction == 'Add'){	
					$('.avatar-upload .avatar-preview').css('border', '6px solid coral');
					showMsg('Please! Select product image', 'error', 'idModalAlertDiV');
					return false;
				}
			}

			if(btnAction == 'Add'){
				actionURL = "<?php echo base_url(); ?>pages/addNewProduct";
				successMsg = 'product added successfully.'; 
				errorMsg = 'product can not be added.'; 
			}else if(btnAction == 'Update'){
				actionURL = "<?php echo base_url(); ?>pages/updateProduct";
				successMsg = 'product updated successfully.'; 
				errorMsg = 'product can not be updated.'; 
				productId = $('#idProductID').val();
			}		

			$("form#idProductForm").submit()
					
		});		

		$("form#idProductForm").submit(function(e) {
			e.preventDefault();    
			var formData = new FormData(this);
			$.ajax({
				type: "POST",
				url: actionURL, 
				data: formData,
				dataType: "json",  
				cache:false,
				contentType: false,
				processData: false,
				success: 
					function(data){
						if(data.success){
							successMsg = data.success;
							$('#idAddNewProductModal').modal('hide');
							productDataTable.ajax.reload();
							showMsg(successMsg, 'success', 'idAlertDiV');
						}else if(data.error){
							errorMsg = data.error;
							showMsg(errorMsg, 'error', 'idModalAlertDiV');							
						}						
					},
				error:
					function(data){
						showMsg(data.error, 'error', 'idModalAlertDiV');
					}
			});	
		});

		$(document).on('click', '.btnDeleteRecord', function(){
			if(confirm('Do you want to delete this product ?')){
				let productId = $(this).attr('data-product_id');
				let actionURL = "<?php echo base_url(); ?>pages/deleteProduct";
				let successMsg = 'product deleted successfully.'; 
				let errorMsg = 'product can not be deleted.'; 
				$.ajax({
					type: "POST",
					url: actionURL, 
					data: {productId: productId, userID: userID},
					dataType: "json",  
					cache:false,
					success: 
						function(data){   
							if(data.success){
								productDataTable.ajax.reload();
								showMsg(data.success, 'success', 'idAlertDiV');
							} else if(data.error){
								productDataTable.ajax.reload();
								showMsg(data.error, 'error', 'idAlertDiV');
							}
						},
					error:
						function(data){
							showMsg(errorMsg, 'error', 'idAlertDiV');
						}
				});
			}
		});
	});

	function setProductModal(productId){
		if(productId){
			let actionURL = "<?php echo base_url(); ?>pages/getProductByID";
			$.ajax({
				type: "POST",
				url: actionURL, 
				data: {productId: productId, userID: userID},
				dataType: "json",  
				cache:false,
				success: 
					function(data){   
						if(data.product){
							$.each(data, function(index, value){
								let productImgUrl = base_url+"<?php $temp = str_replace("./", "", UPLOAD_PRODUCT_IMG_PATH);  echo $temp; ?>"+value.product_img_name;
								$('#inputProductName').val(value.product_name);
								$('#inputHsnCode').val(value.hsn_code);
								$('#inputQuantity').val(value.quantity);
								$('#inputUnit').val(value.unit);
								$('#inputRate').val(value.rate);
								if(value.is_offer_avilable == 1){
									$('#idIsOfferAvailable').prop('checked',true);
									$('.classIsOfferAvail').show();
									$('#inputOfferRate').val(value.offer_rate);
									$('#inputEfctFromDate').val(value.effective_from_date);
									$('#inputEfctToDate').val(value.effective_till_date);
								}else{
									$('.classIsOfferAvail').hide();
									$('#idIsOfferAvailable').prop('checked',false);
								}			
								$('#imagePreview').css('background-image', 'url('+productImgUrl+')');
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

	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#imagePreview').css('background-image', 'url('+e.target.result +')');
				$('#imagePreview').hide();
				$('#imagePreview').fadeIn(650);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#imageProductUpload").change(function() {
		readURL(this);
	});
</script>
