<!doctype html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<link href="<?= base_url(); ?>css/loginStyles.css" rel="stylesheet">
	<title>HRCare Login</title>

</head>

<style>
	* {
		margin: 0;
		padding: 0;
	}

	body {
		background-color: #f2f7fe;
	}

	.box_container {
		height: 100vh;
		width: 100%;
		text-align: center;
		padding-top: 25vh;
	}

	.login-page {
		margin: auto;
		height: auto;
		width: 500px;
		display: block;
		background-color: white;
		border-radius: 5px;
		box-shadow: 0px 4px 25px -3px rgba(0, 0, 0, 0.10);
		padding: 50px 5px 50px;
	}

	.forgot-inputs {
		margin: auto;
		width: 400px;
		margin-top: 20px;
	}

	.forgot-custom-input {
		padding: 12px;
		font-size: 14px;
	}

	.have-label {
		font-size: 14px;
		text-decoration: none;
	}

	.btn-block {
		width: 100%;
		padding: 10px;
		font-size: 15px;
		margin-top: 20px;
	}

	.alert-danger {
		background-color: #DC3545 !important;
		color: #fff !important;
	}
</style>

<body>

	<div class="box_container">
		<div class="login-page" style="text-align:center">
			<p style="font-size:30px; font-family: 'Lato',san-serif;" class="text-primary text-bold"><b>New Password</b></p>

			<?php
			if ($this->session->userdata('SESS_ERR_PASSWORD')) {

			?>

				<div class="alert alert-danger text-center">
					<h6 class="mb-0" id="err_login" name="err_login">
						<?php echo $this->session->userdata('SESS_ERR_PASSWORD'); ?>
					</h6>
				</div>

			<?php
				$this->session->unset_userdata('SESS_ERR_PASSWORD');
			}
			?>

			<form action="<?= base_url() ?>login/submit_new_password" method="post">
				<div class="forgot-inputs">
					<div class="input-group mb-3">
						<input type="password" name="new_password" class="form-control forgot-custom-input shadow-none" placeholder="New Password" required>
					</div>

					<div class="input-group">
						<input type="password" name="retype_password" class="form-control forgot-custom-input shadow-none" placeholder="Retype Password" required>
					</div>

					<input type="hidden" name="user_id" value="<?= $this->session->userdata('SESS_USER_ID') ?>">
					<button type="submit" name="CALC_BTN_SEND" class="btn btn-primary btn-block shadow-none">Submit</button>
				</div>
				
			</form>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</body>

</html>