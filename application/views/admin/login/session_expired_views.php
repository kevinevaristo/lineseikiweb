<!doctype html>
<html>

<head>

    <link rel="shortcut icon" href="<?= base_url() ?>images/system/favicon.ico" type="image/x-icon">
    <title>Session Expired</title>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url('assets_system/vendor/bootstrap-5.3.2/css/bootstrap.min.css'); ?>" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Helvetica, Arial, sans-serif;
            background-color: #0F467B;
            color: #ffffff;
        }

        .expired-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 50px 40px;
            max-width: 480px;
            width: 90%;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
        }

        .expired-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #e7f1ff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }

        .expired-icon svg {
            width: 40px;
            height: 40px;
            color: #0F467B;
        }

        .expired-card h1 {
            font-size: 26px;
            font-weight: 700;
            color: #0F467B;
            margin-bottom: 12px;
        }

        .expired-card p {
            font-size: 15px;
            color: #5a6a7a;
            line-height: 1.6;
            margin-bottom: 8px;
        }

        .expired-card .team-note {
            font-size: 13px;
            color: #8a9bae;
            margin-bottom: 30px;
        }

        .btn-login {
            display: inline-block;
            padding: 12px 36px;
            background-color: #0F467B;
            color: #ffffff !important;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-login:hover {
            background-color: #17A2DC;
            color: #ffffff !important;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="expired-card">
        <div class="expired-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h1>Session Expired</h1>
        <p>Your session has timed out. Please sign in again to continue.</p>
        <p class="team-note">&mdash; Lineseiki Support Team</p>
        <a href="<?= base_url() . 'panel_72c81' ?>" class="btn-login">Go to Login Page</a>
    </div>
</body>

</html>
