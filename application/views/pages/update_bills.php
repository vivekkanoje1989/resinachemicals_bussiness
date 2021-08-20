<style>
	.classBottomLine {
		position: absolute;
		left: 40%;
		width: 20%;
		height: 4px;
		background: orange;
		border: 1px solid yellow;
		border-radius: 8px 8px 8px 8px;
		box-shadow: 0px 4px 15px black;
	}
    .panel-heading{
        padding: 8px;
        background-color: #d3d3d352;
        color: #5d5656;
        font-style: oblique;
        border-bottom: 1px solid lightgrey;
        font-size: 14px;
    }
    #idSelectCustomer::after{
        content: "\f007";
        /* content: "\f067";f007 */
        font-family: 'FontAwesome';
		color: #757575;
		font-size: 25px;
        position: absolute;
    	top: 0px;
        right: 18px;
        cursor: pointer;
    }
    #idResetBill::after{
        content: "\f021";
        font-family: 'FontAwesome';
        color: #757575;
		position: absolute;
		font-size: 25px;
    	top: 0px;
        right: 18px;
        cursor: pointer;
    }
	#idSelectDetailsForwardTo::after{		
		content: "\f018";
        font-family: 'FontAwesome';
		color: #757575;
		font-size: 25px;
        position: absolute;
    	top: 0px;
        right: 18px;
        cursor: pointer;
	}
    .classSelCustomer :hover{
        padding: 2px 6px 5px 10px;
        background: gainsboro;
        border-radius: 18px;
        cursor: pointer;
        box-shadow: 0px 5px 8px black;
    }
	#idShopItem::after{
		content: "\f07a";
        font-family: 'FontAwesome';
        color: #757575;
        font-size: 25px;
        position: absolute;
    	top: 0px;
        right: 18px;
        cursor: pointer;
	}
	.rowSelected{
		color: red;
		font-style: oblique;
		font-weight: 500;
	}
	.classOpenBillDetails::after{
		content: "\f044";
		font-family: 'FontAwesome';
        color: #757575;
        font-size: 25px;
        position: absolute;
    	top: 0px;
        right: 18px;
        cursor: pointer;
	}
	.CustomerModalTitle::after{
		content: "\f067";
		font-family: 'FontAwesome';
        color: #757575;
        font-size: 20px;
        position: absolute;
    	top: 5px;
        right: 18px;
        cursor: pointer;
	}

	/* shopping Products modal */
	.param {
		margin-bottom: 7px;
		line-height: 1.4;
	}

	.param-inline dt {
		display: inline-block;
	}

	.param dt {
		margin: 0;
		margin-right: 7px;
		font-weight: 600;
	}

	.param-inline dd {
		vertical-align: baseline;
		display: inline-block;
	}

	.param dd {
		margin: 0;
		vertical-align: baseline;
	}

	.shopping-cart-wrap .price {
		color: #007bff;
		font-size: 18px;
		font-weight: bold;
		margin-right: 5px;
		display: block;
	}

	var {
		font-style: normal;
	}

	.media img {
		margin-right: 1rem;
	}

	.img-sm {
		width: 90px;
		max-height: 75px;
		object-fit: cover;
	}    
	/* shopping Products modal */

</style>
<div class="row">
	<div class="col-sm-12 col-md-12">
		<div class="card  mb-4">
			<div class="card-body">
				<h5 class="card-title text-center"><em style="color: #d95700;text-shadow: 2px 4px 0px lightgrey;">Product
						Billing...</em></h5>
				<div class="classBottomLine"></div>
				<br>
				<div class="row">
					<div class="col-md-4">
						<div class="card  mb-4">
							<div class="panel-heading text-center">Details of Billed To<span id="idSelectCustomer" title="Select Customer"></span></div>
							<div class="card-body">
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>Mr./Ms.</b> &nbsp;</div>
									<div class="col-sm-7 col-md-7" id="idBillToName"></div>
								</div>
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>Address</b>&nbsp;</div>
									<div class="col-sm-7 col-md-7" id="idBillToAddress"></div>
								</div>
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>City</b>&nbsp;</div>
									<div class="col-sm-7 col-md-7" id="idBillToCity"></div>
								</div>
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>State</b>&nbsp;</div>
									<div class="col-sm-7 col-md-7" id="idBillToState"></div>
								</div>
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>State Code</b>&nbsp;</div>
									<div class="col-sm-7 col-md-7" id="idBillToStateCode"></div>
								</div>
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>Contact No.</b>&nbsp;</div>
									<div class="col-sm-7 col-md-7" id="idBillToMobile"></div>
								</div>
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>Email</b>&nbsp;</div>
									<div class="col-sm-7 col-md-7" id="idBillToEmail"></div>
								</div>
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>GSTIN</b>&nbsp;</div>
									<div class="col-sm-7 col-md-7" id="idBillToGSTIN"></div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="card  mb-4">
							<div class="panel-heading text-center">Details of Forwarded To<span id="idSelectDetailsForwardTo" title="Select Customer"></span></div>
							<div class="card-body">
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>Mr./Ms.</b> &nbsp;</div>
									<div class="col-sm-7 col-md-7" id="idFrdToName"></div>
								</div>
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>Address</b>&nbsp;</div>
									<div class="col-sm-7 col-md-7" id="idFrdToAddress"></div>
								</div>
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>City</b>&nbsp;</div>
									<div class="col-sm-7 col-md-7" id="idFrdToCity"></div>
								</div>
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>State</b>&nbsp;</div>
									<div class="col-sm-7 col-md-7" id="idFrdToState"></div>
								</div>
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>State Code</b>&nbsp;</div>
									<div class="col-sm-7 col-md-7" id="idFrdToStateCode"></div>
								</div>
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>Contact No.</b>&nbsp;</div>
									<div class="col-sm-7 col-md-7" id="idFrdToMobile"></div>
								</div>
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>Email</b>&nbsp;</div>
									<div class="col-sm-7 col-md-7" id="idFrdToEmail"></div>
								</div>
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>GSTIN</b>&nbsp;</div>
									<div class="col-sm-7 col-md-7" id="idFrdToGSTIN"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card  mb-4">
							<div class="panel-heading text-center">Bill Details<span class="classOpenBillDetails" title="Add Bill Details"></span></div>
							<div class="card-body">
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>Bill No.</b></div>
									<div class="col-sm-7 col-md-7" id="idBillNo"></div>
								</div>
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>Bill Date</b></div>
									<div class="col-sm-7 col-md-7" id="idBillDate"></div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>Challan No.</b></div>
									<div class="col-sm-7 col-md-7" id="idBillChallanNo"></div>
								</div>
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>CL Date</b></div>
									<div class="col-sm-7 col-md-7" id="idBillCLDate"></div>
								</div>
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>DM NO.</b></div>
									<div class="col-sm-7 col-md-7" id="idBillDMNo"></div>
								</div>
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>DM Date</b></div>
									<div class="col-sm-7 col-md-7" id="idBillDMDate"></div>
								</div>
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>LR /MR No.</b></div>
									<div class="col-sm-7 col-md-7" id="idBillLrMrNo"></div>
								</div>
								<div class="row">
									<div class="col-sm-5 col-md-5"><b>LR /MR Date</b></div>
									<div class="col-sm-7 col-md-7" id="idBillLrMrDate"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="idAlertDiV"></div>
				<div class="row">
					<div class="col-md-12">
						<div class="card  mb-4">
							<div class="panel-heading text-center">Order Details<span id="idShopItem" title="Shop item..."></span></div>
							<div class="card-body">
								<div class="row">
									<div class="table-responsive">
										<table class="table table-striped table-hover table-bordered  " id="idBillItemTable">
											<thead>
												<tr>
													<th>#</th>
													<th>Particulars</th>
													<th>HSN Code</th>
													<th>Unit</th>
													<th>Quantity</th>
													<th>Rate</th>
													<th>Per</th>
													<th>Amount</th>
												</tr>
											</thead>
											<tbody id="idBillItemTableBody">
												<tr>
													<td class="text-center" colspan="8">No Item</td>
												</tr>												
											</tbody>
											<tfoot>
												<tr>
													<td class="font-weight-bold text-right"  colspan="7">SubTotal</td>
													<td id="idBillSubTotal" ></td>
												</tr>
												<tr>
													<td class="font-weight-bold text-right" colspan="7">CGST <small>(<?php echo COMPANY_CGST_TAX; ?>%)</small></td>
													<td id="idBillCGST"></td>
												</tr>
												<tr>
													<td class="font-weight-bold text-right" colspan="7">SGST <small>(<?php echo COMPANY_SGST_TAX; ?>%)</small></td>
													<td id="idBillSGST"></td>
												</tr>
												<tr>
													<td class="font-weight-bold text-right" colspan="7">IGST <small>(<?php echo COMPANY_IGST_TAX; ?>%)</small></td>
													<td id="idBillIGST"></td>
												</tr>
												<tr>
													<td class="font-weight-bold text-right" colspan="7">Total</td>
													<td id="idBillTotal"></td>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="text-right">
					<button type="button" class="btn btn-success btn-sm" id="idSaveBill" "data-submit_action"=""></button>
					<button type="button" class="btn btn-info btn-sm" id="idAllBills">All Bill</button>
					<button type="button" class="btn btn-secondary btn-sm" id="idNextBill">Next Bill</button>
				</div>

			</div>
		</div>
	</div>
</div>

<!--Modal: Name-->
<div class="modal fade" id="idSelectCustomerModal" role="dialog" aria-labelledby="idSelectCustomerModal">
	<div class="modal-dialog modal-md" role="document">
		<!--Content-->
		<div class="modal-content">
			<!--Body-->
			<div class="modal-body mb-0 p-8">
				<div class="card">
					<div class="panel-heading text-center"><span class="CustomerModalTitle" title="Add New Customer">Select Customer</span></div>
					<!-- idIsBillToOrFrdTo = 1 then BillTo else Forward To -->
					<input type="text" class="invisible" id="idIsBillToOrFrdTo" value="0" style="position: absolute;">
					<div class="card-body" style="height: 200px;overflow-y: auto;">
						<div class="row">
							<div class="col-md-3 col-sm-3">
								<input type="text" id="idCustomerSearch" style="position: fixed;right: 38px;top: 60px;border-radius: 15px;outline: none;padding: 0px 0px 0px 6px;"
								 placeholder="Search...">
							</div>

						</div>
						<div class="row rowCustomer" style="margin-top: 13px;overflow-y: auto;height: 145px;"></div>
					</div>
				</div>
				<div id="idModalAlertDiV"></div>
			</div>
			<div class="classLoader" style="display: none;"><i class="fa fa-spinner fa-spin"></i>Processing...</div>
			<!--Footer-->
			<div class="modal-footer justify-content-center">
				<!-- <button type="button" class="btn btn-outline-secondary btn-rounded btn-md ml-4" id="idBtnSubmitProduct">Add</button> -->
				<button type="button" class="btn btn-outline-primary btn-rounded btn-md ml-4" data-dismiss="modal">Close</button>
			</div>

		</div>
		<!--/.Content-->
	</div>
</div>
<!--Modal: Name-->

<!--Modal: Name-->
<div class="modal fade" id="idBillDetailsModal" role="dialog" aria-labelledby="idBillDetailsModal">
	<div class="modal-dialog modal-lg" role="document">
		<!--Content-->
		<div class="modal-content">
			<!--Body-->
			<div class="modal-body mb-0 p-8">
				<form>
					<div class="form-row">
						<div class="form-group col">
							<label for="inputBillDate">Bill Date</label>
							<input type="text" class="form-control" id="inputBillDate" name="inputBillDate" placeholder="dd-mm-yyyy"
							 readonly>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputChallanNo">Challan No</label>
							<input type="text" class="form-control" id="inputChallanNo" name="inputChallanNo" placeholder="Challan No">
						</div>
						<div class="form-group col-md-6">
							<label for="inputCLDate">CL Date</label>
							<input type="text" class="form-control" id="inputCLDate" name="inputCLDate" placeholder="dd-mm-yyyy">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputDMNo">DM No</label>
							<input type="text" class="form-control" id="inputDMNo" name="inputDMNo" placeholder="DM No">
						</div>
						<div class="form-group col-md-6">
							<label for="inputDMDate">DM Date</label>
							<input type="text" class="form-control" id="inputDMDate" name="inputDMDate" placeholder="dd-mm-yyyy">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputLrMrNo">LR/MR No</label>
							<input type="text" class="form-control" id="inputLrMrNo" name="inputLrMrNo" placeholder="LR/MR No">
						</div>
						<div class="form-group col-md-6">
							<label for="inputLrMrDate">LR/MR Date</label>
							<input type="text" class="form-control" id="inputLrMrDate" name="inputLrMrDate" placeholder="dd-mm-yyyy">
						</div>
					</div>
				</form>
				<div id="idBillDetailsModalAlertDiV"></div>
			</div>
			<div class="classLoader" style="display: none;"><i class="fa fa-spinner fa-spin"></i>Processing...</div>
			<!--Footer-->
			<div class="modal-footer justify-content-center">
				<!-- <button type="button" class="btn btn-outline-secondary btn-rounded btn-md ml-4" id="idBtnSubmitBillDetails">Submit</button> -->
				<button type="button" class="btn btn-outline-primary btn-rounded btn-md ml-4" data-dismiss="modal">Close</button>
			</div>

		</div>
		<!--/.Content-->
	</div>
</div>
<!--Modal: Name-->

<!--Modal: Name-->
<div class="modal fade" id="idBillProductModal" role="dialog" aria-labelledby="idBillProductModal">
	<div class="modal-dialog modal-lg" role="document">
		<!--Content-->
		<div class="modal-content">
			<div class="panel-heading text-center">
				<div class="row">
					<div class="col-md-3">
						<select class="form-control" id="idProductSearchOrderBy" title="Order By">
							<option value="name">Product Name</option>
							<option value="rate">Product Rate</option>
						</select>
					</div>
					<div class="col-md-9">						
						<div class="form-inline my-2 my-lg-0">
							<input class="form-control mr-sm-2" style="width: 80%;" type="search" id="idProductSearchTerm" placeholder="Search" aria-label="Search" title="Press Enter to search">
							<button class="btn btn-outline-success my-2 my-sm-0" id="idBtnGetProductsSearch" onClick="getShoppingProducts()" >Search</button>
						</div>
					</div>
				</div>
			</div>
			<!--Body-->
			<div class="modal-body mb-0 p-8">
				<div id="idBillProductModalAlertDiV"></div>
				<div class="row " id="idShoppingProductspane"></div>
			</div>
			<div class="classLoader" style="display: none;"><i class="fa fa-spinner fa-spin"></i>Processing...</div>
			<!--Footer-->
			<div class="modal-footer justify-content-center">
				<!-- <button type="button" class="btn btn-outline-secondary btn-rounded btn-md ml-4" id="idBtnSubmitBillProduct">Submit</button> -->
				<button type="button" class="btn btn-outline-primary btn-rounded btn-md ml-4" data-dismiss="modal">Close</button>
			</div>

		</div>
		<!--/.Content-->
	</div>
</div>
<!--Modal: Name-->
<script id="shoppingProducts-template" type="text/x-handlebars-template">
	{{#each shoppingProducts}}
		<div class="col-md-6">
			<div class="card mb-2">
				<div class="panel-heading text-center">
					<div class="row">
						<div class="col-md-10">
							<h6 class="title text-truncate" id="idProductName_{{product_id}}">{{product_name}}</h6>
						</div>
						<div class="col-md-2">
							<span class="badge badge-pill badge-primary" id="idProductAvalable_{{product_id}}" data-product_available="{{stock_qty}}">{{stock_qty}}</span>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<figure class="media">
							<div class="img-wrap"><img src="<?php echo base_url(); ?>public/uploads/products/{{product_img_name}}" class="img-thumbnail img-sm"></div>
							<figcaption class="media-body">
								<dl class="param param-inline small">
									<dt>Qty: </dt>
									<dd><span id="idProductQty_{{product_id}}">{{product_qty}}</span></dd>
								</dl>
								<dl class="param param-inline small">
									<dt>Rate: </dt>
									<dd>{{whichRate product_id applyOffer offer_rate rate}}</dd>
								</dl>
								<dl class="param param-inline small">
									<dt>Offer: </dt>
									<dd> <span id="idProductOffer_{{product_id}}"><em>{{offer}}</em></span></dd>
								</dl>
							</figcaption>
						</figure>
					</div>
					<div class="row">
						<div class="col-md-3 col-sm-3"></div>
						<div class="col-md-9 col-sm-9" style="display: inline-flex;">
							<button class="btn btn-sm btn-primary mr-1 classAddItem" data-product_id="{{product_id}}" >Add</button>
							<div class="btn-group btn-group-sm mr-1" role="group" aria-label="Basic example">
								<button type="button" class="btn btn-danger classIncItem" data-product_id="{{product_id}}">+</button>
								<button type="button" class="btn btn-default" id="idProductItmeQty_{{product_id}}" data-item_qty="1">1</button>
								<button type="button" class="btn btn-danger classDecItem" data-product_id="{{product_id}}">-</button>
							</div>
							<select class="form-control" id="idItemUnit_{{product_id}}">
								<option value="0">Unit</option>
								<option value="1">Dozen</option>
								<option value="2">Barrel</option>
							</select>	
						</div>
					</div>
				</div>
			</div>
		</div>
	{{/each }}
</script>

<script id="shoppingBillItem-template" type="text/x-handlebars-template" >
	{{#each aShoppingBillItems}}
		<tr class="classRemoveItem" data-product_id="{{iProductId}}" style="cursor: pointer;" title="Click to remove">
			{{#itemSrno @index}}
			{{/itemSrno }}
			<td>{{sProductName}}</td>
			<td>{{sHsnCode}}</td>
			<td>{{unit}}</td>
			<td>{{itemQty}}</td>
			<td>{{sProductRate}}</td>
			<td>{{sItmUnit}}</td>
			<td>{{itemAmount}}</td>
		</tr>
	{{/each }}
</script>

<script type="text/javascript">

	getCustomerOBJ();

	var customerObj = [];
	var billOBJ = {
		"customer_details": [],
		"forwardTo_details": [],
		"bill": [{
					"id": "",
					"bill_no": "",
					"bill_date": "",
					"challan_no": "",
					"challan_date": "",
					"dm_no": "",
					"dm_date": "",
					"lrmr_no": "",
					"lrmr_date": "",
					"bill_subTotal": "",
					"bill_cgst": "",
					"bill_sgst": "",
					"bill_igst": "",
					"bill_total": ""
				}],
		"bill_items": []
	};

	//If bill is to be updated
 	var aUpdateBillOBJ = {};
	aUpdateBillOBJ = <?php if(isset($aUpdateBillOBJ)){ print_r($aUpdateBillOBJ); }else{ echo '{}'; } ?>;

	var aShoppingProducts = [];

	// <.. Handlebar
	var source   = document.getElementById("shoppingProducts-template").innerHTML;
	var template = Handlebars.compile(source);

	Handlebars.registerHelper("whichRate", function(productId, applyOffer, offerRate, defaultRate){
		productId = Handlebars.Utils.escapeExpression(productId);
		applyOffer = Handlebars.Utils.escapeExpression(applyOffer);
		offerRate = Handlebars.Utils.escapeExpression(offerRate);
		defaultRate = Handlebars.Utils.escapeExpression(defaultRate);

		if(applyOffer == 1){
			return new Handlebars.SafeString('<span id="idProductRate_'+ productId +'" style="text-decoration: line-through;">'+ defaultRate +'</span>&nbsp;<span>'+ offerRate +'</span>');
		}else{
			return new Handlebars.SafeString('<span id="idProductRate_'+ productId +'" >'+ defaultRate +'</span>');
		}
	});

	var billItemSource = document.getElementById("shoppingBillItem-template").innerHTML;
	var BillItemtemplate = Handlebars.compile(billItemSource);

	Handlebars.registerHelper("itemSrno", function(index){
		index = Handlebars.Utils.escapeExpression(index);	
		let srNo = parseInt(index) + 1;
		return new Handlebars.SafeString('<td>'+ srNo +'</td>');
	});
	// HandleBar..>
	
	$(document).ready(function () {

		var win = $(this); //this = window
	    if (win.width() < 650) { 
	    	$('.modal-footer').css('display', 'flex');
	    }else{
	    	$('.modal-footer').css('display', 'none');
	    }


		$('#inputBillDate').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			assumeNearbyYear: true,
			keyboardNavigation: true,
			todayHighlight: true,
			todayBtn: 'linked'
		}).val(moment().format('DD-MM-YYYY'));

		$('#inputCLDate').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			assumeNearbyYear: true,
			keyboardNavigation: true,
			todayHighlight: true,
			todayBtn: 'linked'
		});

		$('#inputDMDate').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			assumeNearbyYear: true,
			keyboardNavigation: true,
			todayHighlight: true,
			todayBtn: 'linked'
		});

		$('#inputLrMrDate').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			assumeNearbyYear: true,
			keyboardNavigation: true,
			todayHighlight: true,
			todayBtn: 'linked'
		});

		$(document).on('change', '#inputChallanNo', function () {
			$('#idBillChallanNo').text($(this).val());
			billOBJ.bill[0].challan_no = $(this).val();
		});

		$(document).on('change', '#inputDMNo', function () {
			$('#idBillDMNo').text($(this).val());
			billOBJ.bill[0].dm_no = $(this).val();
		});

		$(document).on('change', '#inputLrMrNo', function () {
			$('#idBillLrMrNo').text($(this).val());
			billOBJ.bill[0].lrmr_no = $(this).val();
		});

		$(document).on('change', '#inputBillDate', function () {
			$('#idBillDate').text($(this).val());
			billOBJ.bill[0].bill_date = $(this).val();
		});

		$(document).on('change', '#inputCLDate', function () {
			$('#idBillCLDate').text($(this).val());
			billOBJ.bill[0].challan_date = $(this).val();
		});

		$(document).on('change', '#inputDMDate', function () {
			$('#idBillDMDate').text($(this).val());
			billOBJ.bill[0].dm_date = $(this).val();
		});

		$(document).on('change', '#inputLrMrDate', function () {
			$('#idBillLrMrDate').text($(this).val());
			billOBJ.bill[0].lrmr_date = $(this).val();
		});

		$(document).on('click', '#idSelectCustomer', function () {
			$('#idSelectCustomerModal').modal('show');
			$('.CustomerModalTitle').text('Select Customer');
			$('#idIsBillToOrFrdTo').val(1);
		});

		$(document).on('click', '#idSelectDetailsForwardTo', function () {
			$('#idSelectCustomerModal').modal('show');
			$('.CustomerModalTitle').text('Select Details Forward To');
			$('#idIsBillToOrFrdTo').val(0);
		});

		$(document).on('click', '.classSelCustomer', function () {
			// console.log('data', $(this).attr('data-customer_details'));
			let isBillToOrFrwrdTo = $('#idIsBillToOrFrdTo').val();
			if (isBillToOrFrwrdTo == 1) {
				billOBJ['customer_details'] = JSON.parse($(this).attr('data-customer_details'));
				setBillTo(billOBJ['customer_details']);
				$('#idSelectCustomerModal').modal('hide');
				setSubTotal();
			} else {
				billOBJ['forwardTo_details'] = JSON.parse($(this).attr('data-customer_details'));
				setForwardTo(billOBJ['forwardTo_details']);
				$('#idSelectCustomerModal').modal('hide');
				setSubTotal();
			}
			console.log('billOBJ : ', billOBJ);
		});

		$(document).on('keyup', '#idCustomerSearch', function () {
			let param = $(this).val();
			if (param.length > 2) {
				// console.log("length : ", param.length);
				// console.log("param : ", param);
				let search = param.toUpperCase();
				var aSearch = $.grep(customerObj, function (v) {
					return v.name.toUpperCase().indexOf(search) >= 0;
				});
				setCustomerSelectBolck(aSearch);
			} else if (param.length == 0) {
				setCustomerSelectBolck(customerObj);
			}
		});
		
		$(document).on('click', '.CustomerModalTitle', function () {
			let url = "<?php echo base_url(); ?>pages/loadView/customer";
			location.href = url;
		});

		$(document).on('click', '#idAllBills', function(){
			location.href = "<?php echo base_url(); ?>pages/loadView/bills";
		});

		$(document).on('click', '#idNextBill', function () {
			let url = "<?php echo base_url(); ?>pages/loadView/add_bills";
			window.open(url, '_blank');
		});

		$(document).on('click', '.classRemoveItem', function () {
			let mainIndex = $(this).index();
			let elem = $('.classRemoveItem');
			$.each(elem, function (index, val) {
				if (index != mainIndex) {
					$(this).removeClass('rowSelected');
				}
			});
			$(this).toggleClass('rowSelected');
			setTimeout(() => {
				if (confirm('Do you want to remove item ?')) {
					//prepare item to remove
					let iBillItemId = $(this).attr('data-product_id');
					let bRemove =false;
					
					billOBJ['bill_items'] = billOBJ['bill_items'].filter(function(val) {
						return val.iProductId != iBillItemId
					});					
					$(this).remove();
					reloadBillItems();
				}else{
					$(this).toggleClass('rowSelected');
				}
			}, 300);
		})

		$(document).on('click', '.classOpenBillDetails', function () {
			$("#idBillDetailsModal").modal('show');
		});

		$(document).on('click', '#idShopItem', function () {
			getShoppingProducts();
			$("#idBillProductModal").modal('show');
		});

		$(document).on('click', '.classIncItem', function(){
			let id = $(this).attr('data-product_id');
			let itemUnit = parseInt($('#idItemUnit_'+id).val());
			let itemQty = $('#idProductItmeQty_'+id).attr('data-item_qty');
			itemQty = parseInt(itemQty);
			let maxQty = parseInt($('#idProductAvalable_'+id).attr('data-product_available'));
			
			if(itemUnit == 1){//dozen
				let newQty = itemQty * 12;
				if(newQty > 0 && newQty < maxQty){
					$('#idProductItmeQty_'+id).text(itemQty+1);
					$('#idProductItmeQty_'+id).attr('data-item_qty', itemQty+1);
				}
			}else{				
				if(itemQty > 0 && itemQty < maxQty){
					$('#idProductItmeQty_'+id).text(itemQty+1);
					$('#idProductItmeQty_'+id).attr('data-item_qty', itemQty+1);
				}
			}		
		});

		$(document).on('click', '.classDecItem', function(){
			let id = $(this).attr('data-product_id');
			let itemQty = $('#idProductItmeQty_'+id).attr('data-item_qty');
			itemQty = parseInt(itemQty);
			if(itemQty > 1){
				$('#idProductItmeQty_'+id).text(itemQty-1);
				$('#idProductItmeQty_'+id).attr('data-item_qty', itemQty-1);
			}
		});

		$(document).on('keydown','#idProductSearchTerm',function(e) {
			var key = e.which;
			if (key == 13) {
				// As ASCII code for ENTER key is "13"
				$('#idBtnGetProductsSearch').click(); // Search
			}
		});
		
		$(document).on('click', '.classAddItem', function(){
			let productID = $(this).attr('data-product_id');
			let itemQty = parseInt( $('#idProductItmeQty_'+productID).attr('data-item_qty'));
			let itemUnit = $('#idItemUnit_'+productID).val();
			// <option 0 = Unit, 1 = Dozen, 2 = Barral />
			let productQtyStr = aShoppingProducts[productID]['product_qty'];
			let aParts = productQtyStr.toString().split(' ');
			let productQty = 0;
			let productUnit = '';
			if(aParts.length > 0){
				productQty = aParts[0];
				productUnit = aParts[1];
			}
			let itemAvailableQty = aShoppingProducts[productID]['stock_qty'];

			//for item unit as UNIT
			var rCheck = checkItemAvialability(productID, itemUnit, itemQty, itemAvailableQty, productQty, productUnit);
			// console.log(`rCheck :  ${rCheck}`);
			if(rCheck == false){
				return false;
			}
			addShopItem(itemQty, itemUnit, aShoppingProducts[productID]);
		});
		
		//If Bill is to be updated
		if(aUpdateBillOBJ.hasOwnProperty('bill')){
			// console.log("aUpdateBillOBJ : ", aUpdateBillOBJ);
			billOBJ = aUpdateBillOBJ;
			reloadBillItems();

			setBillTo(billOBJ['customer_details']);
			setForwardTo(billOBJ['forwardTo_details']);

			$('#idSaveBill').text('Update Bill');
			$('#idSaveBill').attr('data-submit_action', 'update');
			//Setting Bill details
			$("#idBillNo").text(billOBJ['bill'][0]['bill_no']);
			$("#idBillDate").text(billOBJ['bill'][0]['bill_date']);
			$("#idBillChallanNo").text(billOBJ['bill'][0]['challan_no']);
			$("#idBillCLDate").text(billOBJ['bill'][0]['challan_date']);
			$("#idBillDMNo").text(billOBJ['bill'][0]['dm_no']);
			$("#idBillDMDate").text(billOBJ['bill'][0]['dm_date']);
			$("#idBillLrMrNo").text(billOBJ['bill'][0]['lrmr_no']);
			$("#idBillLrMrDate").text(billOBJ['bill'][0]['lrmr_date']);
		}else{
			setBillDetails();

			$('#idSaveBill').text('Save Bill');
			$('#idSaveBill').attr('data-submit_action', 'save');
		}
		
		$(document).on('click', '#idSaveBill', function(){
			if($(this).attr('data-submit_action') == 'save'){
				let $action = 'save';
				addUpdateBill($action);
			}else if($(this).attr('data-submit_action') == 'update'){
				let $action = 'update';
				addUpdateBill($action);
			}
		});
	});

	function getCustomerOBJ() {
		if (userID) {
			let actionURL = "<?php echo base_url(); ?>pages/getCustomerOBJ";
			$.ajax({
				type: "POST",
				url: actionURL,
				data: {
					userID: userID
				},
				dataType: "json",
				cache: false,
				success: function (data) {
					if (data.length > 0) {
						customerObj = data;
						setCustomerSelectBolck(data);
					}
				},
				error: function (data) {
					console.log("data error", data);
				}
			});
		}
	}

	function setCustomerSelectBolck(cObj) {
		if (cObj.length > 0) {
			$('.rowCustomer').empty();
			let sBlock = '';
			$.each(cObj, function (index, value) {
				sBlock = "<div class='col-md-12 col-sm-12 classSelCustomer' title='click to select...' data-customer_details='[" +
					JSON.stringify(value) + "]'><span>" + value.name + " <small>(<em>" + value.city + ", " + value.state +
					"</em>)</small></span></div>";
				$('.rowCustomer').append(sBlock);
			});
		}
	}

	function setBillTo(aDataObj) {
		if (aDataObj.length > 0) {
			$("#idBillToName").text(aDataObj[0].name);
			$("#idBillToAddress").text(aDataObj[0].address);
			$("#idBillToCity").text(aDataObj[0].city);
			$("#idBillToState").text(aDataObj[0].state);
			$("#idBillToStateCode").text(aDataObj[0].state_code);
			$("#idBillToMobile").text(aDataObj[0].mobile);
			if (aDataObj[0].alt_mobile) {
				$("#idBillToMobile").append(', ' + aDataObj[0].alt_mobile);
			}
			$("#idBillToEmail").text(aDataObj[0].email);
			$("#idBillToGSTIN").text(aDataObj[0].gst_in_number);
		}
	}

	function setForwardTo(aDataObj) {

		if (typeof(aDataObj) != 'undefined') {
			if (aDataObj.length > 0) {
				$("#idFrdToName").text(aDataObj[0].name);
				$("#idFrdToAddress").text(aDataObj[0].address);
				$("#idFrdToCity").text(aDataObj[0].city);
				$("#idFrdToState").text(aDataObj[0].state);
				$("#idFrdToStateCode").text(aDataObj[0].state_code);
				$("#idFrdToMobile").text(aDataObj[0].mobile);
				if (aDataObj[0].alt_mobile) {
					$("#idFrdToMobile").append(', ' + aDataObj[0].alt_mobile);
				}
				$("#idFrdToEmail").text(aDataObj[0].email);
				$("#idFrdToGSTIN").text(aDataObj[0].gst_in_number);
			}
		}
	}

	function setBillDetails() {
		if (userID) {
			let actionURL = "<?php echo base_url(); ?>pages/getBillCount";
			$.ajax({
				type: "POST",
				url: actionURL,
				data: {
					userID: userID
				},
				dataType: "json",
				cache: false,
				success: function (data) {
					// console.log("data bill_count : ", data);
					let blNo = '';
					if (data.bill_count == 0) {
						blNo = 'BL-00001';
						$('#idBillNo').text('BL-00001');
					} else if (data.bill_count > 0) {
						blNo = data.bill_count;
						let blNoLnth = data.bill_count.toString().length + 1;
						// console.log(blNoLnth);
						if (blNoLnth == 4) {
							blNo = '0' + (parseInt(data.bill_count) + 1);
						} else if (blNoLnth == 3) {
							blNo = '00' + (parseInt(data.bill_count) + 1);
						} else if (blNoLnth == 2) {
							blNo = '000' + (parseInt(data.bill_count) + 1);
						} else if (blNoLnth == 1) {
							blNo = '0000' + (parseInt(data.bill_count) + 1);
						}
						blNo = 'BL-' + blNo;
						$('#idBillNo').text(blNo);
					} else if (data.error) {
						showMsg(data.error, 'error', 'idAlertDiV');
					}

					let tDay = moment().format("DD-MM-YYYY");
					$('#idBillDate').text(tDay);

					billOBJ['bill'] = [{
						"id": "",
						"bill_no": blNo,
						"bill_date": tDay,
						"challan_no": "",
						"challan_date": "",
						"dm_no": "",
						"dm_date": "",
						"lrmr_no": "",
						"lrmr_date": ""
					}];
				},
				error: function (data) {
					console.log("data error", data);
				}
			});
		}
	}

	function getShoppingProducts() {
		if (userID) {
			let actionURL = "<?php echo base_url(); ?>pages/getShoppingProducts";
			let dBillDate = $('#idBillDate').text();
			let searchOrderBy = $('#idProductSearchOrderBy').val();
			let searchTerm = $('#idProductSearchTerm').val();
			$('.classLoader').css('display', 'block');
			$.ajax({
				type: "POST",
				url: actionURL,
				data: {
					userID: userID,
					dBillDate: dBillDate,
					searchOrderBy: searchOrderBy,
					searchTerm: searchTerm
				},
				dataType: "json",
				cache: false,
				success: function (data) {
					// console.log("data success", data); 
				
					aShoppingProducts = data;
					var context = {
						shoppingProducts: data
					};
					var html = template(context);
					$('#idShoppingProductspane').empty();
					document.getElementById("idShoppingProductspane").innerHTML += html;
					$('.classLoader').css('display', 'none');

				},
				error: function (data) {
					console.log("data error", data);
					$('.classLoader').css('display', 'none');
				}
			});
		}
	}

	function addShopItem(itemQty, itemUnit, item){
		let iProductId = item.product_id;
		let sProductName = item.product_name;
		let productQty = item.product_qty;
		let applyOffer = item.applyOffer;
		let saleRate = item.sale_rate;
		let hsnCode = item.hsn_code;
		let itemAmount = 0;
		let sItmUnit = '';
		if(itemUnit == 0){
			sItmUnit = 'Unit';
			itemAmount = parseFloat(saleRate) * parseInt(itemQty);
		}else if(itemUnit == 1){
			sItmUnit = 'Dozen';
			itemAmount = parseFloat(saleRate) * parseInt(itemQty) * 12;
			saleRate = (parseFloat(saleRate) * 12).toFixed(2);
		}else if(itemUnit == 2){
			sItmUnit = 'Barrel';
			itemAmount = parseFloat(saleRate) * parseInt(itemQty);
		}
		itemAmount = itemAmount.toFixed(2);

		let tempObj = {
			iProductId: iProductId,
			sProductName: sProductName,
			sHsnCode: hsnCode,
			sProductRate: saleRate,
			unit: productQty,
			itemQty: itemQty,
			sItmUnit: sItmUnit,
			itemAmount: itemAmount
		};
		let iAdd = 0;
		if(billOBJ['bill_items'].length > 0){
			$.each(billOBJ['bill_items'], function(indx, val){
				if(val.iProductId == iProductId && val.sItmUnit == sItmUnit){
					billOBJ['bill_items'][indx]['itemQty'] = parseInt(billOBJ['bill_items'][indx]['itemQty']) +  parseInt(itemQty);
					billOBJ['bill_items'][indx]['itemAmount'] =  (parseFloat(billOBJ['bill_items'][indx]['itemAmount']) + parseFloat(itemAmount)).toFixed(2);
					reloadBillItems();
					showToastAlert("blue", "fa fa-info", "Info", "Item added successfully.");
					iAdd = 0;
					return false;
				}else{
					iAdd = parseInt(iAdd) + 1;
				}
			});
			let timeOut = 20;
			if(billOBJ['bill_items'].length > 6){
				timeOut = ((billOBJ['bill_items'].length) * 10);
				setTimeout(() => {
					if(iAdd > 0){
						billOBJ['bill_items'].push(tempObj);
						reloadBillItems();
						showToastAlert("blue", "fa fa-info", "Info", "Item added successfully.");
					}
				}, timeOut);
			}else{
				if(iAdd > 0){
					billOBJ['bill_items'].push(tempObj);
					reloadBillItems();
					showToastAlert("blue", "fa fa-info", "Info", "Item added successfully.");
				}
			}
		}else{
			billOBJ['bill_items'].push(tempObj);
			reloadBillItems();
			showToastAlert("blue", "fa fa-info", "Info", "Item added successfully.");
		}
	}

	//calculate and set Bill subTotal
	function setSubTotal(){
		$('#idBillSubTotal').empty();
		let fBillSubTotal = "0.00";
		$.each(billOBJ['bill_items'], function(index, value){
			fBillSubTotal = parseFloat(fBillSubTotal) + parseFloat(value.itemAmount);
		});
		billOBJ['bill'][0].bill_subTotal = fBillSubTotal;
		$('#idBillSubTotal').text((parseFloat(fBillSubTotal)).toFixed(2));
		let iCustomerStateCode = 0;
		let fBillCGST = 0;
		let fBillSGST = 0;
		let fBillIGST = 0;
		let fBillTotal = 0;
		if(billOBJ['customer_details'].length > 0){
			iCustomerStateCode = billOBJ['customer_details'][0].state_code;
		}else{
			showToastAlert("yellow", "fa fa-warning", "Warning", "Please! Select customer.");
		}

		if(COMPANY_STATE_CODE == iCustomerStateCode){
			if(parseFloat(fBillSubTotal) > 0){
				fBillCGST = (parseFloat(fBillSubTotal) * parseInt(COMPANY_CGST_TAX)) / 100;
				fBillSGST = (parseFloat(fBillSubTotal) * parseInt(COMPANY_SGST_TAX)) / 100;
				fBillTotal = parseFloat(fBillSubTotal) + parseFloat(fBillCGST) + parseFloat(fBillSGST);

				billOBJ['bill'][0].bill_cgst = fBillCGST;
				billOBJ['bill'][0].bill_sgst = fBillSGST;
				billOBJ['bill'][0].bill_igst = fBillIGST;
				billOBJ['bill'][0].bill_total = fBillTotal;

				$("#idBillCGST").text((parseFloat(fBillCGST)).toFixed(2));
				$("#idBillSGST").text((parseFloat(fBillSGST)).toFixed(2));
				$("#idBillIGST").text((parseFloat(fBillIGST)).toFixed(2));
				$("#idBillTotal").text((parseFloat(fBillTotal)).toFixed(2));
			}
		}else{
			if(parseFloat(fBillSubTotal) > 0){
				fBillIGST = (parseFloat(fBillSubTotal) * parseInt(COMPANY_IGST_TAX)) / 100;
				fBillTotal = parseFloat(fBillSubTotal) + parseFloat(fBillIGST);

				billOBJ['bill'][0].bill_cgst = fBillCGST;
				billOBJ['bill'][0].bill_sgst = fBillSGST;
				billOBJ['bill'][0].bill_igst = fBillSGST;
				billOBJ['bill'][0].bill_total = fBillTotal;

				$("#idBillCGST").text((parseFloat(fBillCGST)).toFixed(2));
				$("#idBillSGST").text((parseFloat(fBillSGST)).toFixed(2));
				$("#idBillIGST").text((parseFloat(fBillIGST)).toFixed(2));
				$("#idBillTotal").text((parseFloat(fBillTotal)).toFixed(2));
			}
		}		
	}

	function reloadBillItems(){
		var contextBillItems = {
			aShoppingBillItems: billOBJ['bill_items']
		};
		
		var htmlBillItems = BillItemtemplate(contextBillItems);
		$('#idBillItemTableBody').empty();
		document.getElementById("idBillItemTableBody").innerHTML += htmlBillItems;
		setSubTotal();
	}

	function checkItemAvialability(iProductId, itemUnit, itemQty, itemAvailableQty, productQty, productUnit){
		
		if(billOBJ['bill_items'].length > 0){
			if(itemUnit == 0){
				console.log(`UNIT : ${itemUnit}`);
				sItmUnit = 'Unit';
			}else if(itemUnit == 1){
				sItmUnit = 'Dozen';
				console.log(`DOZEN : ${itemUnit}`);
			}else if(itemUnit == 2){
				sItmUnit = 'Barrel';
			}
			$.each(billOBJ['bill_items'], function(indx, val){
				if(val.iProductId == iProductId){
					if(val.sItmUnit == "Unit"){//0unit
						itemAvailableQty -= parseInt(val.itemQty);
					}else if(val.sItmUnit == "Dozen"){//dozen
						itemAvailableQty -= (parseInt(val.itemQty) * 12);
					}else if(val.sItmUnit == "Barrel"){//2Barrel
						itemAvailableQty -= parseInt(val.itemQty);
					}
				}
			});
		}
		
		if(itemUnit == 0){
			if(itemQty > itemAvailableQty){
				showToastAlert("red", "fa fa-times", "Error", `Item quantity exceeded product available quantity. ${itemQty - itemAvailableQty} more items required`);
				return false;
			}else{
				return true;
			}
		}else if(itemUnit == 1){//Dozen
			let newItemQty = 12 * (parseInt(itemQty));
			if(newItemQty > itemAvailableQty){
				showToastAlert("red", "fa fa-times", "Error", `Item quantity exceeded product available quantity. ${newItemQty - itemAvailableQty} more items required`);
				return false;
			}else{
				return true;
			}
		}else if(itemUnit == 2){//Barral = 159 litres // 200 to 220 LTR
			if(productUnit == 'LTR'){
				if(productQty < 159 || productQty > 220){
					showToastAlert("red", "fa fa-times", "Error", "Product does not ressembles Item unit Barrel. Please! use different unit.");
					return false;
				}else{
					return true;
				}
			}else if(productUnit == 'ML'){
				if(productQty < 159000 || productQty > 220000){
					showToastAlert("red", "fa fa-times", "Error", "Product does not ressembles Item unit Barrel. Please! use different unit.");
					return false;
				}else{
					return true;
				}
			}else{
				return true;
			}
		}else{
			return true;
		}
	}
	
	//add or update Bill
	function addUpdateBill($action){
		let url = "";
		if($action == 'save'){
			url = "<?php echo base_url(); ?>pages/saveBill";
		}else if($action == 'update'){
			url = "<?php echo base_url(); ?>pages/updateBill";
		}
		let aBilldata = billOBJ;
		if(aBilldata.bill.length == 0){
			showToastAlert("red", "fa fa-times", "Error", `Bill details required.`);
			return false;
		}
		if(aBilldata.bill_items.length == 0){
			showToastAlert("red", "fa fa-times", "Error", `Please! add some bill items.`);
			return false;
		}
		if(aBilldata.customer_details.length == 0){
			showToastAlert("red", "fa fa-times", "Error", `Please! Select Customer.`);
			return false;
		}
		console.log('addUpdateBill : aBilldata : ', aBilldata);
		if(aBilldata.forwardTo_details.length == 0){
			showToastAlert("yellow", "fa fa-warning", "Warning", `You have not added forward to details.`);
			// return false;
		}
		$.ajax({
			type: 'POST',
			url: url,
			data: {
				billOBJ: billOBJ,
				userID: userID
			},
			success: function(data) {
				if(data.success_msg){
					showToastAlert("green", "fa fa-check", "Success", data.success_msg);
					location.href = "<?php echo base_url(); ?>pages/loadView/bills";
				}else if(data.error_msg){
					showToastAlert("red", "fa fa-times", "Error", data.error_msg);
				}
			},
			error: function(error) {
				showToastAlert("red", "fa fa-times", "Error", `Unable to add bill.`);
				console.log(`Error: ${error}`);
			}
		});
	}

	$(window).on('resize', function(){
      var win = $(this); //this = window
      // if (win.height() >= 820) { /* ... */ }
      if (win.width() < 650) { 
      	$('.modal-footer').css('display', 'flex');
      }else{
      	$('.modal-footer').css('display', 'none');
      }
	});
</script>
