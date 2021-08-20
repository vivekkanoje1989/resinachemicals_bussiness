<script src="<?php echo base_url(); ?>assets/js/jsPdf.js"></script>
<script src="<?php echo base_url(); ?>assets/js/html2canvas.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
#invoice{
    padding: 30px;
}

.invoice {
    position: relative;
    background-color: #FFF;
    min-height: 680px;
    padding: 15px
}

.invoice header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #3989c6
}

.invoice .company-details {
    text-align: right
}

.invoice .company-details .name {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .contacts {
    margin-bottom: 20px
}

.invoice .invoice-to {
    text-align: left
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: right
}

.invoice .invoice-details .invoice-id {
    margin-top: 0;
    color: #3989c6
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    margin-top: -20px;
    font-size: 2em;
    margin-bottom: 10px;
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #3989c6
}

.invoice main .notices .notice {
    font-size: 1.2em
}

.invoice table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px
}

.invoice table td,.invoice table th {
    padding: 15px;
    background: #eee;
    border-bottom: 1px solid #fff
}

.invoice table th {
    white-space: nowrap;
    font-weight: 400;
    font-size: 16px
}

.invoice table td h3 {
    margin: 0;
    font-weight: 400;
    color: #3989c6;
    font-size: 1.2em
}

.invoice table .qty,.invoice table .total,.invoice table .rate {
    text-align: right;
    font-size: 1.2em
}

.invoice table .hsnCode, .invoice table .productUnit,.invoice table .unit{
    text-align: center;
    font-size: 1.2em
}

.invoice table .hsnCode {
    background: #ddd
}

.invoice table .qty {
    background: #ddd
}

.invoice table .no {
    color: #fff;
    font-size: 1.6em;
    background: #3989c6
}

.invoice table .unit {
    background: #ddd
}

.invoice table .total {
    background: #3989c6;
    color: #fff
}

.invoice table tbody tr:last-child td {
    border: none
}

.invoice table tfoot td {
    background: 0 0;
    border-bottom: none;
    white-space: nowrap;
    text-align: right;
    padding: 10px 20px;
    font-size: 1.2em;
    border-top: 1px solid #aaa
}

.invoice table tfoot tr:first-child td {
    border-top: none
}

.invoice table tfoot tr:last-child td {
    color: #3989c6;
    font-size: 1.4em;
    border-top: 1px solid #3989c6
}

.invoice table tfoot tr td:first-child {
    border: none
}

.invoice footer {
    width: 100%;
    text-align: center;
    color: #777;
    border-top: 1px solid #aaa;
    padding: 8px 0
}

@media print {
    body {
        visibility: hidden;
        background: white;
    }

    .invoice {       
        padding: 0px;
        margin: -50px -75px -75px -75px;
        font-size: 11px!important;
        overflow: hidden!important;
        visibility: visible;
    }

    .invoice footer {
        position: absolute;
        bottom: 30px;
        page-break-after: always
    }

    .invoice>div:last-child {
        page-break-before: always
    }

    .hidden-print{
        display: none;
    }

    .company-details a, .email a{
        text-decoration: none;
    }
}
</style>
<div id="invoice">
    <div class="toolbar hidden-print">
        <div class="text-right">
            <button id="idPrintInvoice" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
            <button id="idMakePdfInvoice" class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Export as PDF</button>
        </div>
        <hr>
    </div>
    <div id="idInvoicePrint" class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header>
                <div class="row">
                    <div class="col">
                        <a target="_blank" href="<?php echo base_url(); ?>pages/loadView/home" style="text-decoration: none;">
                            <img src="<?php echo base_url(); ?>assets/images/logo.png" data-holder-rendered="true" height="150" width="150" />
                        </a>
                    </div>
                    <div class="col company-details">
                        <h2 class="name">
                            <a target="_blank" href="<?php echo base_url(); ?>pages/loadView/home">
                            Resina Chemicals Industries
                            </a>
                        </h2>
                        <div><i class="fa fa-industry mr-1" ></i>KH. No. 501/9, Mordongri, Nagpur - Bhopal Highway Road,Pandhurna, Madhya Pradesh 480334</div>
                        <div><i class="fa fa-phone mr-1" ></i>0 99222 33445, 0 97307 68629</div>
                        <div><i class="fa fa-at mr-1" ></i>resinachemicals@gmail.com</div>
                        <div><b>GSTIN/UIN : 23DCCPK5744J1ZK</b></div>
                    </div>
                </div>
            </header>
            <main>
                <div class="row contacts">
                    <div class="col-md-4 col-sm-4 invoice-to" id="idCustomerDetails"></div>
                    <div class="col-md-4 col-sm-4 invoice-to" id="idCustomerFrdToDetails"></div>
                    <div class="col-md-4 col-sm-4 invoice-details" id="idBillDetails"></div>
                </div>
                <table>
                    <thead id="idParticularstable">
                        <tr>
                            <th>#</th>
                            <th class="text-left" width="25%">Particulars</th>
                            <th class="text-center">HSN Code</th>
                            <th class="text-center">Unit</th>
                            <th class="text-right">Quantity</th>
                            <th class="text-right">Rate</th>
                            <th class="text-center">Per</th>
                            <th class="text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody id="idParticularstableBody"></tbody>
                    <tfoot id="idParticularstableFooter"></tfoot>
                </table>
                <div class="thanks">Thank you!</div>
                <div class="row ml-2">
                    <div class="col-md-8 notices">
                        <div><em>Terms:</em></div>
                        <div class="notice">
                            <h6>1) Goods once sold will not be taken back.</h6>
                            <h6>2) We are not responsible for leakage and breakage in transit.</h6>
                            <!-- <h6>3) Strictly 30 days Credit surcharge @ 1.75 per month will be charge on over due account.</h6> -->
                            <h6>3) E.& O.E.</h6>
                            <h6>4) AMOUNT OF TAX SUBJECTED TO REVERSE CHARGE.</h6>
                        </div>
                    </div>
                    <div class="col-md-4 notices">
                        <div><em>Company Bank Details:</em></div>
                        <div class="notice">
                            <h6>Branch : Union Bank Of India, Pandhurna</h6>
                            <h6>Acc No . : 440605010051024</h6>
                            <h6>IFSC CODE : UBIN0544060</h6>
                        </div>
                    </div>
                </div>
                
            </main>
            <footer>
                Invoice was created on a computer and is valid without the signature and seal.
            </footer>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
    </div>
</div>

<script id="idBillDetails-template" type="text/x-handlebars-template">
    {{#each aBill}}
    <h1 class="invoice-id">{{bill_no}}</h1>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-5">Bill Date :</div>
        <div class="col-md-4">{{bill_date}}</div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-5">Challan No. :</div>
        <div class="col-md-4">{{challan_no}}</div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-5">Challan Date :</div>
        <div class="col-md-4">{{challan_date}}</div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-5">DM No. :</div>
        <div class="col-md-4">{{dm_no}}</div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-5">DM Date :</div>
        <div class="col-md-4">{{dm_date}}</div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-5">LR/MR No. :</div>
        <div class="col-md-4">{{lrmr_no}}</div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-5">LR/MR Date :</div>
        <div class="col-md-4">{{lrmr_date}}</div>
    </div>
    {{/each}}
</script>

<script id="idCustomerDetails-template" type="text/x-handlebars-template">
    {{#each aCustomerDetails}}
    <div class="text-gray-light">Invoice TO:</div>
    <h3 class="to">{{name}}</h3>
    <div class="address">{{address}}, {{city}}, {{state}}<b>({{state_code}})</b>{{#if pin}}, - {{pin}}{{/if}}</div>
    <div class="email"><a href="mailto:{{email}}">{{email}}</a></div>
    <div class="mobile">{{#if mobile}}<i class="fa fa-phone mr-1" ></i>{{mobile}}{{/if}}{{#if alt_mobile}}, {{alt_mobile}} {{/if}}</div>
    <div class="gstnNo">{{#if gst_in_number}} <b>GSTIN: {{gst_in_number}}</b> {{/if}}</div>
    {{/each}}
</script>

<script id="idCustomerFrdDetails-template" type="text/x-handlebars-template">
    {{#each aCustomerFrdDetails}}
    <div class="text-gray-light">Forward TO:</div>
    <h3 class="to">{{name}}</h3>
    <div class="address">{{address}}, {{city}}, {{state}}<b>({{state_code}})</b>{{#if pin}}, - {{pin}}{{/if}}</div>
    <div class="email"><a href="mailto:{{email}}">{{email}}</a></div>
    <div class="mobile">{{#if mobile}}<i class="fa fa-phone mr-1" ></i>{{mobile}}{{/if}}{{#if alt_mobile}}, {{alt_mobile}} {{/if}}</div>
    <div class="gstnNo">{{#if gst_in_number}} <b>GSTIN: {{gst_in_number}}</b> {{/if}}</div>
    {{/each}}
</script>

<script id="idParticularTableBody-template" type="text/x-handlebars-template">
    {{#each aBillItems}}
    <tr>
        {{#itemSrno @index}}
        {{/itemSrno}}
        <td class="text-left"><h3>{{sProductName}}</h3></td>
        <td class="hsnCode">{{sHsnCode}}</td>
        <td class="productUnit">{{unit}}</td>
        <td class="qty">{{itemQty}}</td>
        <td class="rate">{{sProductRate}}</td>
        <td class="unit">{{sItmUnit}}</td>
        <td class="total">{{itemAmount}}</td>
    </tr>
    {{/each}}
</script>

<script id="idParticularTableFooter-template" type="text/x-handlebars-template">
    {{#each aBill}}
    <tr>
        <td colspan="5"></td>
        <td colspan="2">SUBTOTAL</td>
        <td><i class="fa fa-rupee mr-1"></i>{{bill_subTotal}}</td>
    </tr>
    <tr>
        <td colspan="5"></td>
        <td colspan="2">CGST <?php echo COMPANY_CGST_TAX; ?>%</td>
        <td><i class="fa fa-rupee mr-1"></i>{{bill_cgst}}</td>
    </tr>
    <tr>
        <td colspan="5"></td>
        <td colspan="2">SGST <?php echo COMPANY_SGST_TAX; ?>%</td>
        <td><i class="fa fa-rupee mr-1"></i>{{bill_sgst}}</td>
    </tr>
    <tr>
        <td colspan="5"></td>
        <td colspan="2">IGST <?php echo COMPANY_IGST_TAX; ?>%</td>
        <td><i class="fa fa-rupee mr-1"></i>{{bill_igst}}</td>
    </tr>
    <tr>
        <td colspan="5" style="font-size: 15px;max-width: 400px;"><em>{{bill_amount_words}}</em></td>
        <td colspan="2">GRAND TOTAL</td>
        <td><i class="fa fa-rupee mr-1"></i>{{bill_total}}</td>
    </tr>
    {{/each}}
</script>

<script>
    // console.log("aViewBillOBJ : ",<?php print_r($aViewBillOBJ); ?>);
    var aViewBillOBJ = <?php if(isset($aViewBillOBJ)){ print_r($aViewBillOBJ); }else{ echo '{}'; } ?>;
    
    var billDtlsSource   = document.getElementById("idBillDetails-template").innerHTML;
	var billTemplate = Handlebars.compile(billDtlsSource);

    var billItemsSource   = document.getElementById("idParticularTableBody-template").innerHTML;
	var billItemsTemplate = Handlebars.compile(billItemsSource);

    var billFooterSource   = document.getElementById("idParticularTableFooter-template").innerHTML;
	var billFooterTemplate = Handlebars.compile(billFooterSource);
    
    var custDtlsSource   = document.getElementById("idCustomerDetails-template").innerHTML;
	var custDtlsTemplate = Handlebars.compile(custDtlsSource);

    var custFrdDtlsSource   = document.getElementById("idCustomerFrdDetails-template").innerHTML;
	var custFrdDtlsTemplate = Handlebars.compile(custFrdDtlsSource);

    Handlebars.registerHelper("itemSrno", function(index){
		index = Handlebars.Utils.escapeExpression(index);	
		let srNo = parseInt(index) + 1;
        if(srNo < 10){
            srNo = '0'+srNo;
        }
		return new Handlebars.SafeString('<td class="no">'+ srNo +'</td>');
	});

    setInvoiceDetails(aViewBillOBJ);
    $(document).ready(function(){

        $('#idPrintInvoice').click(function(){
            Popup($('.invoice')[0].outerHTML);         
        });

        $('#idMakePdfInvoice').click(function(){
            $sFilename = '';
            if(aViewBillOBJ.bill.length > 0){
                $sFilename = 'invoice_'+ aViewBillOBJ.bill[0].bill_no + '.pdf';
            }else{
                $sFilename = 'invoice.pdf';
            }
            html2canvas(document.getElementById('idInvoicePrint')).then(function(canvas) {
                var img = canvas.toDataURL("image/png");
                var doc = new jsPDF();
                doc.addImage(img, 'JPEG', 15, 10, 180, 180);
                doc.save($sFilename);
            });
        });
    });
    function Popup(data){
        window.print();
        return true;
    }

    function setInvoiceDetails(aViewBillOBJ){
        if(aViewBillOBJ.hasOwnProperty('bill')){

            if(aViewBillOBJ.bill.length > 0){
                var billContext = {
                    aBill: aViewBillOBJ.bill
                };
                var billHtml = billTemplate(billContext);
                $('#idBillDetails').empty();
                document.getElementById("idBillDetails").innerHTML += billHtml;

                var billFooterHtml = billFooterTemplate(billContext);
                $('#idParticularstableFooter').empty();
                document.getElementById("idParticularstableFooter").innerHTML += billFooterHtml;            
            }

            if(aViewBillOBJ.customer_details.length > 0){
                var custDtlContext = {
                    aCustomerDetails: aViewBillOBJ.customer_details
                };
                var custDtlHtml = custDtlsTemplate(custDtlContext);
                $('#idCustomerDetails').empty();
                document.getElementById("idCustomerDetails").innerHTML += custDtlHtml;
            }

            if(typeof(aViewBillOBJ.forwardTo_details) != 'undefined'){
                if(aViewBillOBJ.forwardTo_details.length > 0){
                    var custFrdContext = {
                        aCustomerFrdDetails: aViewBillOBJ.forwardTo_details
                    };
                    var custFrdHtml = custFrdDtlsTemplate(custFrdContext);
                    $('#idCustomerFrdToDetails').empty();
                    document.getElementById("idCustomerFrdToDetails").innerHTML += custFrdHtml;
                }
            }

            if(aViewBillOBJ.bill_items.length > 0){
                var billItemsContext = {
                    aBillItems: aViewBillOBJ.bill_items
                };
                var billItemsHtml = billItemsTemplate(billItemsContext);
                $('#idParticularstableBody').empty();
                document.getElementById("idParticularstableBody").innerHTML += billItemsHtml;
            }            
        }
    }
</script>