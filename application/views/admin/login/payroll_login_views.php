
<?php 
    
?>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>Eyebox HRMS Admin</title>
<link rel="shortcut icon" href="<?=base_url()?>assets_system/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<?php $this->load->view('templates/css_link'); ?>
<style>
  .btn-primary{
    background-color: #008037 !important;
    border-color: #008037 !important;
  }

  .card-primary.card-outline {
      border-top: 3px solid #008037 !important;
  }
</style>
<body class="hold-transition login-page ">

<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center pt-4 ">
		<img class="logo_bandai" src="<?= base_url(); ?>assets_system/images/login_logo.png" alt="" width="240"> 
      <!-- <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a> -->
    </div>
    <div class="card-body">

	  <?php
		if ($this->session->userdata('SESS_ERR_MSG_INVALID1')) {
		?>
			<div class="alert alert-danger text-center">
				<h6 class="mb-0" id="err_login" name="err_login">
					<?php echo $this->session->userdata('SESS_ERR_MSG_INVALID1'); ?>
				</h6>
			</div>
		<?php
			$this->session->unset_userdata('SESS_ERR_MSG_INVALID1');
		}
		?>


      <div class="alert alert-danger text-center">
        <h6 class="mb-0" id="err_login" name="err_login">
          <?=$C_title?>
        </h6>
      </div>

 
      <form action="<?php echo base_url($C_action); ?>" id="login_form" method="POST" accept-charset="utf-8" autocomplete='off'>
        <div class="input-group mb-3">
          <input type="text" name="CALC_INPF_EMAIL" id="username" class="form-control custom-input shadow-none" placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" id="password" name="CALC_INPF_PASS" class="form-control custom-input shadow-none" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" id="btn_sign_in" name="CALC_BTN_SAVE" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
     
	  <br>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>


</body>
</html>