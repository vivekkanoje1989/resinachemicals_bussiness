<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
	<title>
		<?php if(isset($title)){ echo $title; }else{ echo "Login"; } ?>
	</title>
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="icon" href="<?php echo base_url(); ?>assets/images/logo.png" type="image/x-icon" sizes="16x16">

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fontfamilyRaleway.css">
	<link rel='stylesheet' href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/styles.css">
	<style>
		html,
        body {
        height: 100%;
        }

        body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
        }

        .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: auto;
        }
        .form-signin .checkbox {
        font-weight: 400;
        }
        .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
        }
        .form-signin .form-control:focus {
        z-index: 2;
        }
        .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
        }
        .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        }
    </style>
</head>

<body class="text-center">
	<form class="form-signin" action="<?php echo base_url(); ?>pages/do_login" method="post">
		<img class="mb-4 rounded-circle" src="<?php echo base_url(); ?>assets/images/logo.png" alt="" width="200" height="150">
		<h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
		<label for="idUsername" class="sr-only">Username</label>
		<input type="text" id="idUsername" name="Username" class="form-control" placeholder="User Name" required autofocus>
		<label for="idPassword" class="sr-only">Password</label>
		<input type="password" id="idPassword" name="Password" class="form-control" placeholder="Password" required>
		<div class="checkbox mb-3">
			<label>
				<input type="checkbox" value="remember-me"> Remember me
			</label>
		</div>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
		<p class="mt-5 mb-3 text-muted">&copy; <?php $currentYr = date("Y"); $nextYr = $currentYr + 1; echo $currentYr." - ".$nextYr; ?></p>
		<?php
            if(isset($error)){
                ?>
                <div class="alert alert-danger">
                    <strong>Error!</strong>
                    <?php echo $error; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
		        <?php
            }

            if(isset($success)){
                ?>
                <div class="alert alert-success">
                    <strong>Success!</strong>
                    <?php echo $success; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
		        <?php
            }
        ?>
	</form>
	<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
</body>
</html>