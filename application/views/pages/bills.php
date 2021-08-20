<style>
    #idAddBill::after{
        content: "\f067";
		font-family: 'FontAwesome';
        color: #757575;
        font-size: 20px;
        position: absolute;
        top: 21px;
        right: 28px;
        cursor: pointer;
    }
    #idAddBill:hover:after{
        content: "Add Bill";
    }
    .searchNOCollapse::after{
        content: "\f150";
        /* content: "\f151"; */        
		font-family: 'FontAwesome';
        color: #757575;
        font-size: 20px;
        position: absolute;
        top: 5px;
        right: 10px;
        cursor: pointer;
    }
    .searchCollapse::after{
        /* content: "\f150"; */
        content: "\f151";        
		font-family: 'FontAwesome';
        color: #757575;
        font-size: 20px;
        position: absolute;
        top: 5px;
        right: 10px;
        cursor: pointer;
    }
    .panel-heading{
        padding: 8px;
        background-color: #d3d3d352;
        color: #5d5656;
        font-style: oblique;
        border-bottom: 1px solid lightgrey;
        font-size: 14px;
    }
    .hideSearch{
        display: none;
        transition: height 2s ease;
    }

    #idSearchBillCustomer ~ .select2{
        width: 100%;
        height: 38px;
        padding: 7px 0px 0px 0px;
        border-radius: 4px;
        border: 1px solid lightgray;
    }

</style>
<div class="row">
    <div class="col-sm-12 col-md-12">
    <div class="card mt-2 mb-2">
        <div class="panel-heading text-center searchCollapse" id="idSearchTitle">Search By</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4 col-md-4">
                    <div class="form-group">
                        <label for="idSearchBillFrmDT">Bill Date From</label>
                        <input type="text" class="form-control" id="idSearchBillFrmDT" placeholder="dd-mm-yyyy">
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="form-group">
                        <label for="idSearchBillToDT">Bill Date To</label>
                        <input type="text" class="form-control" id="idSearchBillToDT" placeholder="dd-mm-yyyy">
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="form-group">
                        <label for="idSearchBillCustomer">Bill To Customer</label>
                        <select class="form-control" id="idSearchBillCustomer" placeholder="Select Customer">
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col text-right">
                    <button class="btn btn-sm btn-secondary" id="idBtnSearch">Search</button>
                </div>
            </div>

        </div>
    </div>
    </div>
    <div class="col-sm-12 col-md-12">
        <div class="card  mb-4">
            <div class="card-body">
                <h5 class="card-title text-center" id="idAddBill">All Bills</h5>
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
        $('#idSearchBillFrmDT').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			assumeNearbyYear: true,
			keyboardNavigation: true,
			todayHighlight: true,
			todayBtn: 'linked'
		}).val(moment().startOf('month').format('DD-MM-YYYY'));

        $('#idSearchBillToDT').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
            startDate: $('#idSearchBillFrmDT').val(),
			assumeNearbyYear: true,
			keyboardNavigation: true,
			todayHighlight: true,
			todayBtn: 'linked'
		}).val(moment().endOf('month').format('DD-MM-YYYY'));

        $(document).on('change', '#idSearchBillFrmDT', function(){
            $('#idSearchBillToDT').datepicker('remove');
            $('#idSearchBillToDT').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                startDate: $('#idSearchBillFrmDT').val(),
                assumeNearbyYear: true,
                keyboardNavigation: true,
                todayHighlight: true,
                todayBtn: 'linked'
            }).val('');
        });

        $( "#idSearchBillCustomer" ).select2({
            theme: "bootstrap",
            placeholder: 'Choose...',
            allowClear: true,
            minimumInputLength: 3,
            ajax: {
                url: "<?php echo base_url(); ?>pages/getAllCustomerForSelect2",
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term,
                        userID: userID
                    }
                    return query;
                }
            }
        });
        //call datatable
        oBilltable();

        $(document).on('click', '#idAddBill', function(){
           location.href = "<?php echo base_url(); ?>pages/loadView/add_bills";
        });

        $(document).on('click', '#idSearchTitle', function(){
            // console.log("search");
            $('#idSearchTitle ~ .card-body').toggleClass('hideSearch');
            let isCollapse = $('#idSearchTitle').hasClass('searchCollapse');
            let noCollapse = $('#idSearchTitle').hasClass('searchNOCollapse');

            if(isCollapse){
                $('#idSearchTitle').removeClass('searchCollapse');
                $('#idSearchTitle').addClass('searchNOCollapse');
            }else if(noCollapse){
                $('#idSearchTitle').removeClass('searchNOCollapse');
                $('#idSearchTitle').addClass('searchCollapse');
            }
        });

        $(document).on('click', '#idBtnSearch', function(){
            oBilltable();
        });
        
        // $(document).on('click', '.classViewBillBtn', function(){
        //     console.log("classViewBillBtn : ", $(this).attr('data-bill_id'));
        // });

        $(document).on('click', '.classUpdateBillBtn', function(){
            // console.log("classUpdateBillBtn : ", $(this).attr('data-bill_id'));
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

    function oBilltable(){
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
                    bill_type: 'all',
                    dBillFrmDate: $('#idSearchBillFrmDT').val(),
                    dBillToDate: $('#idSearchBillToDT').val(),
                    iBillCustomerID: $('#idSearchBillCustomer').val(),
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
            // scrollY: 400
            scrollX: 400,
            destroy: true
        } );
    }
   
</script>