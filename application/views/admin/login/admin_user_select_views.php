<?php
$data['DISP_NAME'] = $this->admin_model->get_name();
?>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>Eyebox HRMS Admin</title>
<link rel="shortcut icon" href="<?= base_url() ?>assets_system/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
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
  <div class="login-box" style="width: 800px !important">
    <div class="card card-outline card-primary">
      <div class="card-header text-center pt-4 ">
        <!-- <img class="logo_bandai" src="<?= base_url(); ?>assets_system/images/login_logo.png" alt="" width="240"> -->
        <img class="logo_bandai" src="<?= base_url(); ?>assets_system/images/<?= $DISP_LOGO['value'] ?>" alt="" width="240">
      </div>

      <div class="card-body">
        <div class="alert alert-danger text-center">
          <h6 class="mb-0" id="err_login" name="err_login">
            Admin Login
          </h6>
        </div>

        <?php
        if ($this->session->userdata('SESS_ERR_MSG_DISABLED')) {
        ?>
          <div class="alert alert-danger text-center">
            <h6 class="mb-0" id="err_login" name="err_login">
              <?php echo $this->session->userdata('SESS_ERR_MSG_DISABLED'); ?>
            </h6>
          </div>

        <?php
          $this->session->unset_userdata('SESS_ERR_MSG_DISABLED');
        }
        ?>
        <form action="<?php echo base_url('admin/login_user'); ?>" id="login_form" method="POST" accept-charset="utf-8" autocomplete='off'>
          <div class="row">
            <div class="col-12">
              <a href="<?= base_url() ?>admin/signout" id="btn_sign_out" class="btn btn-secondary btn-block">Sign Out</a>
            </div>
          </div>
        </form>
        <br>
      </div>
    </div>

    <div class="card border-0 mt-2" style="padding: 0px; margin: 0px">
      <div class="row">
          <div class="table-responsive col-9 col-lg-12" style="max-height: 300px; overflow-y: scroll;">
            <table class="table table-striped ">
              <thead>
                <tr>
                  
                  <th scope="col">User ID</th>
                  <th scope="col">Name</th>
                  <th scope="col">User Access</th>
                  <th scope="col">Status</th>
                  <th style="text-align: right; " scope="col">Action </th>
                </tr>
              </thead>

              <tbody>
                <?php foreach ($Users as $user) { ?>

                  <tr>
                    <td><?= $user->id; ?></td>
                    <td><?= $user->col_last_name . ',' . $user->col_frst_name . ' ' . $user->col_midl_name; ?></td>

                    <!-- <?php
                    $position_name = "Not in Database";
                    foreach ($positions as $position) {
                      if ($user->col_empl_posi == $position->id) {
                        $position_name = $position->name;
                      }
                    }
                    ?> -->

                    <!-- <td><?= $position_name ?></td> -->
                    <td><?= $user->user_access ?></td>
                    <?php
                    $disabled_name = "Enabled";

                    if ($user->disabled == 1) {
                      $disabled_name = "Disabled";
                    }

                    ?>
                    <td><?= $disabled_name ?></td>
                    <td style="text-align: right;">
                      <?php
                      if ($user->disabled == 1) { ?>
                        <a id="btn_sign_in" class="btn btn-secondary btn-block">Sign In</a>
                      <?php
                      } else { ?>
                        <a href="<?= base_url() ?>admin/login_user?id=<?= $user->id ?>" id="btn_sign_in" class="btn btn-success btn-block">Sign In</a>
                      <?php
                      }
                      ?>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="../../plugins/jquery/jquery.min.js"></script>
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../dist/js/adminlte.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

  <script>
    $(document).ready(function() {
      $('select').selectize({
        sortField: 'text'
      });
    });
  </script>
</body>

</html>