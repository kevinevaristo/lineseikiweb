<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Line Seiki Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="<?= base_url() ?>assets_system/images/favicon.ico" type="image/x-icon">
  <link href="<?php echo base_url('assets_system/vendor/bootstrap-5.3.3/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets_system/vendor/google-fonts/quicksand/quicksand.css'); ?>" rel="stylesheet">

  <style>
    :root {
      --primary-color: #0056D2;
      --bg-gradient: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      --glass-bg: rgba(255, 255, 255, 0.9);
    }

    body {
      background: var(--bg-gradient);
      font-family: 'Quicksand', sans-serif;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
      padding: 1.5rem;
    }

    .login-box {
      background: var(--glass-bg);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 420px;
      padding: 2.5rem;
      border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .login-box h5 {
      color: #2d3436;
      font-weight: 700;
      letter-spacing: -0.5px;
    }

    .login-box h5 b {
      color: var(--primary-color);
    }

    .form-label {
      font-weight: 600;
      color: #4a4a4a;
      font-size: 0.9rem;
      margin-left: 2px;
    }

    .form-control {
      border-radius: 12px;
      border: 1.5px solid #e0e0e0;
      padding: 0.75rem 1rem;
      transition: all 0.3s ease;
      background: #fdfdfd;
    }

    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 4px rgba(0, 86, 210, 0.1);
      background: #fff;
    }

    .input-group-text, .btn-toggle-password {
      background-color: #f8f9fa;
      border: 1.5px solid #e0e0e0;
      border-left: none;
      border-radius: 0 12px 12px 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .input-group .form-control {
      border-right: none;
    }

    .btn-primary {
      background-color: var(--primary-color);
      border: none;
      border-radius: 12px;
      padding: 0.8rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      transition: transform 0.2s, background-color 0.2s;
    }

    .btn-primary:hover {
      background-color: #0044aa;
      transform: translateY(-1px);
      box-shadow: 0 5px 15px rgba(0, 86, 210, 0.3);
    }

    .btn-primary:active {
      transform: translateY(0);
    }

    .alert {
      border-radius: 12px;
      border: none;
      background-color: #fff1f0;
      color: #d93025;
      font-weight: 500;
    }

    footer {
      text-align: center;
      font-size: 0.85rem;
      color: #636e72;
      margin-top: 2.5rem;
      line-height: 1.6;
    }

    .footer-logo {
      opacity: 0.8;
      filter: grayscale(20%);
      transition: opacity 0.3s;
    }

    .footer-logo:hover {
      opacity: 1;
    }

    /* Loading Spinner Refinement */
    .loading-overlay {
      position: fixed;
      inset: 0;
      background: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(4px);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    .loading-spinner {
      border: 3px solid #f3f3f3;
      border-top: 3px solid var(--primary-color);
      border-radius: 50%;
      width: 45px;
      height: 45px;
      animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    @media (max-width: 480px) {
      .login-box {
        padding: 1.5rem;
      }
    }
  </style>
</head>

<body>
  <div id="loadingOverlay" class="loading-overlay" hidden>
    <div class="loading-spinner"></div>
  </div>

  <?php 
    // Removed tbl_system_setup dependency
    // $data['DISP_NAME'] = $this->login_model->get_name(); 
  ?>

  <div class="login-box">
    <div class="text-center mb-4">
      <?php /* Removed dynamic logo - using default logo */ ?>
      <img class="img-fluid" src="<?= base_url('assets_system/images/header_logo.png') ?>" alt="Logo" width="180">
    </div>

    <h5 class="text-center mb-4">Welcome to <b>Line Seiki Admin</b></h5>

    <?php foreach (['SESS_ERR_MSG_INVALID1', 'SESS_ERR_MSG_INVALID2', 'SESS_ERR_MSG_INCOMPLETE'] as $msgKey): ?>
      <?php if ($this->session->userdata($msgKey)): ?>
        <div class="alert alert-danger text-center mb-3">
          <small><?= $this->session->userdata($msgKey); ?></small>
        </div>
        <?php $this->session->unset_userdata($msgKey); ?>
      <?php endif; ?>
    <?php endforeach; ?>

    <form action="<?= base_url('panel_72c81/sign_in'); ?>" method="POST" id="login_form" autocomplete="off" onsubmit="return validateForm()">
      <div class="mb-3">
        <label for="username" class="form-label">Admin ID</label>
        <div class="input-group">
          <input type="text" id="username" name="CALC_INPF_EMPL_ID" class="form-control" placeholder="Enter your ID" required>
          <span class="input-group-text">
            <img src="<?= base_url('assets_system/icons/user-solid.svg') ?>" alt="User" width="16">
          </span>
        </div>
      </div>

      <div class="mb-4">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
          <input type="password" id="password" name="CALC_INPF_PASS" class="form-control" placeholder="••••••••" required>
          <button type="button" class="btn-toggle-password" id="togglePassword">
            <img id="toggleIcon" src="<?= base_url('assets_system/icons/eye-slash-solid_pass.svg') ?>" 
                 data-eye="<?= base_url('assets_system/icons/eye-solid_pass.svg') ?>" 
                 data-eye-slash="<?= base_url('assets_system/icons/eye-slash-solid_pass.svg') ?>" 
                 alt="Toggle" style="width: 18px;">
          </button>
        </div>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Sign In</button>
      </div>
    </form>
  </div>

  <footer>
    <div class="mb-3">
      <img class="img-fluid footer-logo" src="<?= base_url('assets_system/images/header_logo.png') ?>" alt="BrightHRMS Logo" width="90">
    </div>
    <p>Licensed for <strong>Line Seiki</strong><br>
      &copy; 2025 Line Seiki by TSES. All Rights Reserved<br>
      <span class="text-muted" style="font-size: 11px;">Ver 1.0.100.2 • 20251222</span>
    </p>
  </footer>

  <script src="<?php echo base_url('assets_system/vendor/jquery/jquery-3.7.0.min.js'); ?>"></script>
  <script>
    function validateForm() {
      const username = document.getElementById('username').value.trim();
      const password = document.getElementById('password').value.trim();
      if (username !== '' && password !== '') {
        showLoading();
        return true;
      }
      return false;
    }

    function showLoading() {
      document.getElementById('loadingOverlay').hidden = false;
    }
    
    document.getElementById('togglePassword').addEventListener('click', function () {
      const pwdInput = document.getElementById('password');
      const icon = document.getElementById('toggleIcon');
      const isHidden = pwdInput.type === 'password';
      
      pwdInput.type = isHidden ? 'text' : 'password';
      icon.src = isHidden ? icon.dataset.eye : icon.dataset.eyeSlash;
    });

    // Prevent back button after logout
    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function () {
      window.history.pushState(null, "", window.location.href);
    };
  </script>
</body>
</html>