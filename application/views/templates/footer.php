</div>
<!-- Footer -->
<footer style="position: fixed; left:0; right:0; bottom: 0;">
    <!-- Copyright -->
    <div class="text-center">&copy; <a href="mailto:vivekkanoje1989@gmail.com" > <span id="idlastThisYear"></span> </a> </div>
    <!-- Copyright -->
</footer>
 <!-- Footer -->
<!-- <script src="< ?php echo base_url(); ?>assets/js/jquery.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap4.min.js"></script>

<!-- My Toast Alert handlebar -->
<script id="toastAlert-template" type="text/x-handlebars-template">
	<div class="toast toast--{{toast_alert_type}}">
		<div class="toast__close">
			<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642" xmlns:xlink="http://www.w3.org/1999/xlink"
				enable-background="new 0 0 15.642 15.642">
				<path fill-rule="evenodd" d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z"></path>
			</svg>
		</div>
		<i class="toast__icon {{toast_icon}}"></i>

		<div class="toast__content">
			<p class="toast__type">{{toast_heading}}</p>
			<p class="toast__message">{{toast_msg}}</p>
		</div>
	</div>
</script>
<!-- /My Toast Alert handlebar -->

<script>
	// My Toast Alert
	var toast_source   = document.getElementById("toastAlert-template").innerHTML;
	var toast_template = Handlebars.compile(toast_source);
	$(document).ready(function(){
		let currentYear = parseInt(moment().format('YYYY'));
		let lastYear = currentYear - 1;
		$('#idlastThisYear').text(lastYear + "-" + currentYear);
	});
	$(document).on("click", '.toast__close', function(){
		$(this).parent().hide(800);
	});
	// /My Toast Alert

    function resetFields(idName, className, typeName){
		if(idName){
			if(typeName == 'input'){
				$('#'+idName).val("");
			}else if(typeName == 'select'){
				$('#'+idName).prop('selectedIndex',0);
			}else if(typeName == 'checkbox'){
				$('#'+idName).prop('checked',false);
			}else if(typeName == 'select2'){
				$('#'+idName).val('').trigger('change');
			}
		}

		if(className){			
			if(typeName == 'input'){
				$('.'+className).val("");
			}else if(typeName == 'select'){
				$('.'+className).prop('selectedIndex',0);
			}else if(typeName == 'select2'){
				$('.'+className).val('').trigger('change');
			}
		}
	}

	function showMsg(msg, type, msgBlockSpace) {
		let msgBlock = '';
		if (type == 'error') {
			msgBlock += '<div class="col-sm-12 col-md-12"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Error!</strong> <span>' + msg +
				'</span></div></div>';
		} else if (type == 'success') {
			msgBlock += '<div class="col-sm-12 col-md-12"><div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Success!</strong> <span>' +
				msg +
				'</span></div></div>';
		} else if (type == 'info') {
			msgBlock += '<div class="col-sm-12 col-md-12"><div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Info!</strong> <span>' + msg +
				'</span></div></div>';
		}
		$('#'+msgBlockSpace).html(msgBlock);
		setTimeout(() => {
			$('#'+msgBlockSpace).empty();
		}, 2000);
    }

	//My Toast Alert handlebar call function
	function showToastAlert(type, icon, heading, msg){
		//green= success, blue=info, yellow=warning, red=error
		var context = {
			toast_alert_type: type,
			toast_icon: icon,
			toast_heading: heading,
			toast_msg: msg
		};
		var html = toast_template(context);
		$('.toast__cell').empty();
		$('.toast__cell').append(html);
		setTimeout(() => {
			$('.toast__cell .toast').hide(700);
		}, 2000);
	}

</script>
<script>
    $(document).ready(function(){
        //Disable right-click on page
        $(document).bind("contextmenu",function(e){
           return false;
        });
    });
</script>
</body>
</html>