<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/avatar.css">
<style>
#idProductStockSummaryBody .img-fluid {
    max-width: 20%;
    height: auto;
}

</style>
<div class="row">
	<div class="col-sm-12 col-md-12">
		<div class="card  mb-4">
			<div class="card-body">
				<h5 class="card-title text-center"><button class="btn btn-lg btn-block btn-secondary" id="idBtnAddProductStock"
					 title="Add Product Stock">Add Stock</button></h5>
				<div id="idAlertDiV"></div>
				<table id="idProductStockSummary" class="table table-striped table-bordered" style="width:100%">
					<thead>
						<tr>
							<th width="5%">Sr. No.</th>
							<th>Product Name</th>
							<th width="20%">Stock Qty</th>
							<th width="20%">Action</th>
						</tr>
					</thead>
					<tbody id="idProductStockSummaryBody">
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
<div class="modal fade" id="idAddNewProductStockModal" role="dialog" aria-labelledby="idAddNewProductStockModalLabel"
 aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">

		<!--Content-->
		<div class="modal-content">

			<!--Body-->
			<div class="modal-body mb-0 p-8">

				<form id="idProductStockForm">
					<input style="display: none;" id="userID" name="userID" value="<?php if(isset($userID)){ echo $userID; }else{ echo 0; }  ?>">
					<input style="display: none;" id="idStockID" name="stockID" value="0">					
					<div class="form-row">
                        <div class="form-group col-md-12">
							<label for="idStockProduct">Stock Product</label>
							<select class="form-control" id="idStockProduct" name="stockProductId"></select>
						</div>
                        <div class="form-group col-md-12">
							<label for="idStockQuantity">Quantity</label>
							<input type="text" class="form-control" id="idStockQuantity" name="stockQuantity" placeholder="Stock Quantity">
						</div>
						
					</div>
				</form>
				<div id="idAddNewProductStockModalAlertDiV"></div>
			</div>
			<div class="classLoader" style="display: none;"><i class="fa fa-spinner fa-spin"></i>Processing...</div>
			<!--Footer-->
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-sm btn-outline-secondary btn-rounded btn-md ml-4" id="idBtnSubmitProductStock">Add</button>
				<button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-md ml-4" data-dismiss="modal">Close</button>
			</div>

		</div>
		<!--/.Content-->
	</div> 
</div>
<!--Modal: Name-->

<script>
	
	$(document).ready(function () {

		productStockDataTable = $('#idProductStockSummary').DataTable({
			"ajax":{
			    url :  "<?php echo base_url(); ?>pages/getProductStockForDataTable",
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

        $('#idStockProduct').select2({
			selectOnClose: true,
            width: '100%',
			placeholder: 'Choose...',
            minimumInputLength: 3,
            allowClear: true,
			ajax: {
				url: '<?php echo base_url(); ?>pages/getProductSelect2',
				dataType: 'json',
				processResults: function (data) {
					return {
						results: data
					};
				},
				cache: true
			}
		});

     	
	
		$(document).on('click', '#idBtnAddProductStock', function () {
			$('#idAddNewProductStockModal').modal('show');

			// reset all form fields
			let resetArray = [{"id": "idStockProduct", "type": "select2"}, {"id": "idStockQuantity", "type": "input"}];
			
			$.each(resetArray, function(index, val){
				if('id' in val ){
					resetFields(val.id, null, val.type);
				}

				if('class' in val ){
					resetFields(null, val.class, val.type);
				}
			});
			//Remove validation class
			$('#idAddNewProductStockModal input').removeClass('is-valid');
			$('#idAddNewProductStockModal input').removeClass('is-invalid');
			$('#idAddNewProductStockModal select').removeClass('is-valid');
			$('#idAddNewProductStockModal select').removeClass('is-invalid');
			//Set add data
			$('#idAddNewProductStockModal #idBtnSubmitProductStock').show();
			$('#idAddNewProductStockModal #idBtnSubmitProductStock').text('Add');	
			$('#idAddNewProductStockModal #idStockID').val(0);	
		});

		$(document).on('click', '.btnUpdateModal', function(){
			$('#idAddNewProductStockModal').modal('show');
			// reset all form fields
			let resetArray = [{"id": "idStockProduct", "type": "select2"}, {"id": "idStockQuantity", "type": "input"}];
			
			$.each(resetArray, function(index, val){
				if('id' in val ){
					resetFields(val.id, null, val.type);
				}

				if('class' in val ){
					resetFields(null, val.class, val.type);
				}
			});
			//Remove validation class
			$('#idAddNewProductStockModal input').removeClass('is-valid');
			$('#idAddNewProductStockModal input').removeClass('is-invalid');
			$('#idAddNewProductStockModal select').removeClass('is-valid');
			$('#idAddNewProductStockModal select').removeClass('is-invalid');
			$('.avatar-upload .avatar-preview').css('border', '6px solid #032a981f');
			$('#imageProductUpload').val('');
			$('.avatar-upload .avatar-preview #imagePreview').css('background-image', 'url("<?php echo base_url(); ?>assets/images/upload_animation_default.gif")');
			//Data to modal fields
			$('#idAddNewProductStockModal #idBtnSubmitProductStock').show();
			$('#idAddNewProductStockModal #idBtnSubmitProductStock').text('Update');
			$('#idAddNewProductStockModal #idStockID').val($(this).attr('data-stock_id'));

			setProductStockModal($(this).attr('data-stock_id'));
		});

		$(document).on('click', '.btnViewModal', function(){
			$('#idAddNewProductStockModal').modal('show');
			// reset all form fields
			let resetArray = [{"id": "idStockProduct", "type": "select2"}, {"id": "idStockQuantity", "type": "input"}];
			
			$.each(resetArray, function(index, val){
				if('id' in val ){
					resetFields(val.id, null, val.type);
				}

				if('class' in val ){
					resetFields(null, val.class, val.type);
				}
			});
			//Remove validation class
			$('#idAddNewProductStockModal input').removeClass('is-valid');
			$('#idAddNewProductStockModal input').removeClass('is-invalid');
			$('#idAddNewProductStockModal select').removeClass('is-valid');
			$('#idAddNewProductStockModal select').removeClass('is-invalid');
			//Data to modal fields
			$('#idAddNewProductStockModal #idBtnSubmitProductStock').hide();
			$('#idAddNewProductStockModal #idStockID').val($(this).attr('data-stock_id'));
			setProductStockModal($(this).attr('data-stock_id'));
		});

		$(document).on('click', '#idBtnSubmitProductStock', function(){
			let btnAction = $(this).text();
			let productID = $('#idStockProduct').val();
			let quantity = $('#idStockQuantity').val();
			var numberOnlyReg = /^\s*[0-9 \s]+\s*$/;

			if(!productID){
				showMsg('Product required', 'error', 'idAddNewProductStockModalAlertDiV');
				return false;
			}		
					
			if(quantity == '' && !quantity){
				$('#idStockQuantity').removeClass('is-valid');
				$('#idStockQuantity').addClass('is-invalid');
				showMsg('Product stock quantity required', 'error', 'idAddNewProductStockModalAlertDiV');
				return false;
			}else{
				if(!numberOnlyReg.test(quantity)){
					$('#idStockQuantity').removeClass('is-valid');
					$('#idStockQuantity').addClass('is-invalid');
					showMsg('Only numeric value allowed', 'error', 'idAddNewProductStockModalAlertDiV');
					return false;
				}else{
					$('#idStockQuantity').removeClass('is-invalid');
					$('#idStockQuantity').addClass('is-valid');
				}				
			}

			if(btnAction == 'Add'){
				actionURL = "<?php echo base_url(); ?>pages/addNewProductStock";
				successMsg = 'product stock added successfully.'; 
				errorMsg = 'product stock can not be added.'; 
			}else if(btnAction == 'Update'){
				actionURL = "<?php echo base_url(); ?>pages/updateProductStock";
				successMsg = 'product stock updated successfully.'; 
				errorMsg = 'product stock can not be updated.'; 
			}		

			$("form#idProductStockForm").submit()
					
		});		

		$("form#idProductStockForm").submit(function(e) {
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
						// console.log("data : ", data);
						if(data.success){
							successMsg = data.success;
							$('#idAddNewProductStockModal').modal('hide');
							productStockDataTable.ajax.reload();
							showMsg(successMsg, 'success', 'idAlertDiV');
						}else if(data.error){
							errorMsg = data.error;
							showMsg(errorMsg, 'error', 'idAddNewProductStockModalAlertDiV');							
						}						
					},
				error:
					function(data){
						showMsg(data.error, 'error', 'idAddNewProductStockModalAlertDiV');
					}
			});	
		});

		$(document).on('click', '.btnDeleteRecord', function(){
			if(confirm('Do you want to delete this product stock ?')){
				let stockID = $(this).attr('data-stock_id');
				let actionURL = "<?php echo base_url(); ?>pages/deleteProductStockByStockID";
				let successMsg = 'Product stock deleted successfully.'; 
				let errorMsg = 'Product stock can not be deleted.'; 
				$.ajax({
					type: "POST",
					url: actionURL, 
					data: {stockID: stockID, userID: userID},
					dataType: "json",  
					cache:false,
					success: 
						function(data){   
							console.log("data : ", data);
							if(data.success){
								productStockDataTable.ajax.reload();
								showMsg(data.success, 'success', 'idAlertDiV');
							} else if(data.error){
								productStockDataTable.ajax.reload();
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

   

	function setProductStockModal(stockID){
		if(stockID){
			let actionURL = "<?php echo base_url(); ?>pages/getProductStockByStockID";
			$.ajax({
				type: "POST",
				url: actionURL, 
				data: {stockID: stockID, userID: userID},
				dataType: "json",  
				cache:false,
				success: 
					function(data){   
						console.log("data : ", data);
						if(data){
							$.each(data, function(index, value){
								$("#idAddNewProductStockModal #idStockProduct").html('<option value="'+value.product_id+'">'+value.product_name+'</option>');
								$("#idAddNewProductStockModal #idStockProduct").trigger("change");
								$('#idStockID').val(value.stock_id);
								$('#idStockQuantity').val(value.stock_qty);
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
