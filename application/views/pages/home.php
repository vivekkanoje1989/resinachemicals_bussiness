<style>
    .goCard {
        box-shadow: 6px 8px 6px darkgrey;
    }
    div .card-body p{
        color: aqua;
    }
</style>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card mt-4 mb-4">
            <div class="card-body text-center">
                <div class="row" >
                    <div class="col-sm-6 col-md-3 mb-2">
                        <div class="card goCard" id="idManageProducts" style="background: #d95700;cursor: pointer;" title="Manage Products...">
                            <div class="card-body" >
                                <div style="color: white;font-size: 20px;">Products</div>
                                <div class="BadgeCount" style="font-size: 30px;color: yellow;" id="idCardProductCount">0</div>
                                <p style="font-size: 10px;" >Manage Products...</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 mb-2">
                        <div class="card goCard" id="idManageCustomers" style="background: #6c757d;cursor: pointer;" title="Manage Customers...">
                            <div class="card-body" >
                                <div style="color: white;font-size: 20px;">Customers</div>
                                <div class="BadgeCount" style="font-size: 30px;color: yellow;" id="idCardCustomerCount">0</div>
                                <p style="font-size: 10px;" >Manage Customers...</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 mb-2">
                        <div class="card goCard" id="idManageRevenue" style="background: #28a745;cursor: pointer;" title="Monthly Revenue">
                            <div class="card-body" >
                                <div style="color: white;font-size: 20px;">Revenue</div>
                                <div class="BadgeCount" style="font-size: 30px;color: yellow;" id="idMonthlyRevenue">0</div>
                                <p style="font-size: 10px;" >Monthly Revenue</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 mb-2">
                        <div class="card goCard" id="idManageBills" style="background: #117a8b;cursor: pointer;" title="Manage Bills...">
                            <div class="card-body" >
                                <div style="color: white;font-size: 20px;">Bill</div>
                                <div class="BadgeCount" style="font-size: 30px;color: yellow;" id="idMonthlyBillCount">0</div>
                                <p style="font-size: 10px;" >Monthly Bills...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card  mb-4">
            <div class="card-body">
                <h5 class="card-title text-center">Today's Bills</h5>
                <table id="idTodayBillSummary" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th width="10%">Sr. No.</th>
                            <th>Bill No.</th>
                            <th>Bill Date</th>
                            <th>Customer</th>
                            <th>Bill Amount</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="idTodayBillSummaryBody"></tbody>     
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-right">Total</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>            
                </table>
            </div>
        </div>
    </div>
</div>

<script>
  
    $(document).ready(function() {
        $(document).on('click', '.goCard', function(){
            let goCardAttr = $(this).attr('id');
            if(goCardAttr == 'idManageProducts'){
                let url = base_url+'pages/loadView/products'
                location.href = url;
            }else if(goCardAttr == 'idManageCustomers'){
                let url = base_url+'pages/loadView/customer'
                location.href = url;
            }else if(goCardAttr == 'idManageBills'){
                let url = base_url+'pages/loadView/add_bills'
                location.href = url;
            }
        });
        oTodayBillTable();
        getMonthyRevenueAndCount();
        displayCardCount();

        $(document).on('click', '.classUpdateBillBtn', function(){
            let iBillID = parseInt($(this).attr('data-bill_id'));
            if( iBillID > 0){
                location.href = "<?php echo base_url(); ?>pages/updateBillPage/"+iBillID;
            }
        });

        $(document).on('click', '.classViewBillBtn', function(){
		    //update = 0 , view = 1
            let iBillID = parseInt($(this).attr('data-bill_id'));
            if( iBillID > 0){
                let url = "<?php echo base_url(); ?>pages/updateBillPage/"+iBillID+"/1";
                window.open(url, '_blank');
            }
        });
    });

    function oTodayBillTable(){
        $('#idTodayBillSummary').DataTable( {
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ordering": false,
            "ajax":{
                url :  "<?php echo base_url(); ?>pages/getBillForDataTable",
                type : 'GET',
                data: {
                    userID: userID,
                    bill_type: 'today'                   
                }
            },
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
    
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
    
                // Total over all pages
                total = api
                    .column( 4 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
    
                // Total over this page
                // pageTotal = api
                //     .column( 4, { page: 'current'} )
                //     .data()
                //     .reduce( function (a, b) {
                //         return intVal(a) + intVal(b);
                //     }, 0 );
    
                // Update footer
                $( api.column( 4 ).footer() ).html(
                    parseFloat(total).toFixed(2)
                );
            },
            paging: true,
            // scrollY: 400,
            scrollX: 400,
            destroy: true
        } );
    }

    function displayCardCount(){
        if(userID){
			let actionURL = "<?php echo base_url(); ?>pages/displayCardCount";
            let startOfMonth = moment().startOf('month').format('YYYY-MM-DD');
            let endOfMonth = moment().endOf('month').format('YYYY-MM-DD');
			$.ajax({
				type: "POST",
				url: actionURL, 
				data: {
                    userID: userID,
                    from_date: startOfMonth,
                    to_date: endOfMonth
                },
				dataType: "json",  
				cache:false,
				success: 
					function(data){   
                        $('#idCardProductCount').text(data.products);
                        $('#idCardCustomerCount').text(data.customers);
					},
				error:
					function(data){
						console.log("data error", data); 
					}
			});
		}
    }

    function getMonthyRevenueAndCount(){
        if(userID){
			let actionURL = "<?php echo base_url(); ?>pages/getBillCount";
            let startOfMonth = moment().startOf('month').format('YYYY-MM-DD');
            let endOfMonth = moment().endOf('month').format('YYYY-MM-DD');
			$.ajax({
				type: "POST",
				url: actionURL, 
				data: {
                    userID: userID,
                    from_date: startOfMonth,
                    to_date: endOfMonth
                },
				dataType: "json",  
				cache:false,
				success: 
					function(data){
                        if(data.bill_amount){
                            $('#idMonthlyRevenue').text((parseFloat(data.bill_amount)).toFixed(2));
                        }else{
                            $('#idMonthlyRevenue').text(0);
                        }
                        $('#idMonthlyBillCount').text(data.bill_count);
					},
				error:
					function(data){
						console.log("data error", data); 
					}
			});
		}
    }
</script>