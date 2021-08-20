<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
	<title>
		<?php echo $title; ?>
	</title>
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="icon" href="<?php echo base_url(); ?>assets/images/logo.png" type="image/x-icon" sizes="16x16">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fontfamilyRaleway.css">
	<link rel='stylesheet' href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/styles.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/smoothness-jquery-ui.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker3.min.css" />
	<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/moment-with-locales.min.js"></script>
	<script>
		$(document).ready(function(){
                moment.locale('en');
            });
        </script>

	<script>
		var userID = "<?php if(isset($userID)){ echo $userID; }else{ echo 0; } ?>";
		var base_url = "<?php echo base_url(); ?>";
		var COMPANY_STATE_CODE = "<?php echo COMPANY_STATE_CODE; ?>";
		var COMPANY_CGST_TAX = "<?php echo COMPANY_CGST_TAX; ?>";
		var COMPANY_SGST_TAX = "<?php echo COMPANY_SGST_TAX; ?>";
		var COMPANY_IGST_TAX = "<?php echo COMPANY_IGST_TAX; ?>";

		$(document).ready(function(){                
			//set active class to current nav
			var sActivePage = "<?php if(isset($title)){ $sTtl = explode("|", $title); echo $sTtl[0]; }else{ echo 'home';} ?>";
			$('.nav-link').removeClass('active');
			$('#id'+sActivePage).addClass('active');
		});
	</script>
	<link href="<?php echo base_url(); ?>assets/css/select2.min.css" rel="stylesheet" />
	<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
    <!-- My Toast Alert -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/myToastAlert.css">
    <!-- /My Toast Alert -->
    <script src="<?php echo base_url(); ?>assets/js/handlebars-v4.0.12.js"></script>
</head>

<body>
	<div class="container">
		<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
			<a class="navbar-brand" href="#"><img src="<?php echo base_url(); ?>assets/images/logo.png" alt="Logo" class="rounded-0"
				 width="50" height="50"><em>Resina Chemicals</em></a>
			<!--Add here -->
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
				<span class="navbar-toggler-icon"></span>
			</button>
			<!--Add here -->
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link active" id="idHome" href="<?php echo base_url(); ?>pages/loadView/home">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link " id="idBilling" href="<?php echo base_url(); ?>pages/loadView/add_bills">Billing</a>
					</li>
					<?php	
						if($this->session->userdata['user_type'] == 1){	
						?>			
						<li class="nav-item">
							<a class="nav-link" id="idStock" href="<?php echo base_url(); ?>pages/loadView/stock">Stock</a>
						</li>
						<?php
						}
					?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" data-toggle="dropdown">
							<?php if(isset($userFullName)){echo $userFullName; } ?>
						</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="<?php echo base_url(); ?>pages/do_logout">Log Out</a>
							<?php	
								if($this->session->userdata['user_type'] == 1){	
								?>
								<a class="dropdown-item" href="<?php echo base_url(); ?>pages/loadView/manage_users">Manage Users</a>
								<!-- <div class="dropdown-divider"></div> -->
								<!-- <a class="dropdown-item" href="#">Settings</a> -->
								<?php
								}
							?>
						</div>
					</li>
				</ul>
			</div>
		</nav>
        <!-- My Toast Alert -->
		<div class="toast__container"><div class="toast__cell"></div></div>
        <!-- /My Toast Alert -->
