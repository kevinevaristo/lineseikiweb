<!doctype html>
<html>

<head>

    <link rel="shortcut icon" href="<?= base_url() ?>images/system/favicon.ico" type="image/x-icon">
    <title>Session Expired</title>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


    <style>

        body {
            text-align: center !important;
            padding: 20px !important;
            font: 20px Helvetica, sans-serif !important;
            color: #ffffff !important;
            background-color: #008037 !important;
        }

        @media (min-width: 768px) {
            body {
                padding-top: 150px !important;
            }
        }

        h1 {
            font-size: 50px !important;
        }

        article {
            display: block !important;
            text-align: left !important;
            max-width: 650px !important;
            margin: 0 auto !important;
        }

        a {
            color: #dc8100 !important;
            text-decoration: none;
        }

        a:hover {
            color: #333 !important;
            text-decoration: none;
        }

    </style>
</head>

<body>
    <article>
        <h1>Session Expired</h1>
        <div>
            <p>Your session timed out. To continue working, sign in again</p>
            <p>&mdash; Eyebox Support Team</p>
        </div>

        <div>
            <a href="<?= base_url() . 'panel_72c81' ?>" type="button" class="btn btn-primary" style="color: #fff !important; background-color: #F4BE20; border-color: #F4BE20;">Go to Login Page</a>
        </div>
    </article>
</body>

</html>