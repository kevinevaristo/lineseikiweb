<?php

?>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>Eyebox HRMS Admin</title>
<link rel="shortcut icon" href="<?= base_url() ?>assets_system/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<?php $this->load->view('templates/css_link'); ?>
<style>
  .btn-primary {
    background-color: #008037 !important;
    border-color: #008037 !important;
  }

  .card-primary.card-outline {
    border-top: 3px solid #008037 !important;
  }
</style>

<body class="hold-transition login-page ">

  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center pt-4 ">
        <!-- <img class="logo_bandai" src="<?= base_url(); ?>assets_system/images/login_logo.png" alt="" width="240"> -->
        <img class="logo_bandai" src="<?= base_url(); ?>assets_system/images/<?= $DISP_LOGO['value'] ?>" alt="" width="240">
      </div>

      <div class="card-body">
        <div class="alert alert-danger text-center">
          <h6 class="mb-0" id="err_login" name="err_login">
            <?= $C_title ?>
          </h6>
        </div>

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
        <?php
        if ($this->session->userdata('SESS_ERR_MSG_INVALID2')) {
        ?>
          <div class="alert alert-danger text-center">
            <h6 class="mb-0" id="err_login" name="err_login">
              <?php echo $this->session->userdata('SESS_ERR_MSG_INVALID2'); ?>
            </h6>
          </div>
        <?php
          $this->session->unset_userdata('SESS_ERR_MSG_INVALID2');
        }
        ?>
        <?php
        if ($this->session->userdata('SESS_ERR_MSG_INCOMPLETE')) {
        ?>

          <div class="alert alert-danger text-center">
            <h6 class="mb-0" id="err_login" name="err_login">
              <?php echo $this->session->userdata('SESS_ERR_MSG_INCOMPLETE'); ?>
            </h6>
          </div>

        <?php
          $this->session->unset_userdata('SESS_ERR_MSG_INCOMPLETE');
        }
        ?>

        <form action="<?php echo base_url($C_action); ?>" id="login_form" method="POST" accept-charset="utf-8" autocomplete='off'>
          <div class="input-group mb-3">
            <input type="text" name="CALC_INPF_EMAIL" id="username" class="form-control custom-input shadow-none" placeholder="Username" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <img style="height: 1rem; width: 1rem;" src="<?php echo base_url('assets_system/icons/user-solid.svg') ?>" alt="">
              </div>
            </div>
          </div>

          <div class="input-group mb-3">
            <input type="password" id="password" name="CALC_INPF_PASS" class="form-control custom-input shadow-none" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <img style="height: 1rem; width: 1rem;" src="<?php echo base_url('assets_system/icons/lock-solid.svg') ?>" alt="">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <button type="submit" id="btn_sign_in" name="CALC_BTN_SAVE" class="btn btn-primary btn-block">Sign In</button>
            </div>
          </div>
        </form>
        <br>
      </div>
    </div>
  </div>

</body>

</html>