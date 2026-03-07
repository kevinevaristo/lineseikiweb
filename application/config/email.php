<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| EMAIL CONFIGURATION
| -------------------------------------------------------------------
| 
| Configuration for PHPMailer email sending
| 
*/

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'mail.lineseiki.systems-test.com';  // or 'localhost' on cPanel
$config['smtp_port'] = 587;  // or 465 for SSL
$config['smtp_user'] = 'admin@lineseiki.systems-test.com';  // Email you created
$config['smtp_pass'] = 'Technos@2025';  // Password you set
$config['smtp_crypto'] = 'tls';  // or 'ssl'
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";
$config['wordwrap'] = TRUE;
$config['from_email'] = 'admin@lineseiki.systems-test.com';
$config['from_name'] = 'Line Seiki Asia Pacific - SMUC';

/*
| -------------------------------------------------------------------
| IMPORTANT: Gmail App Password Setup
| -------------------------------------------------------------------
| 
| To use Gmail SMTP, you need to create an "App Password":
| 
| 1. Go to your Google Account: https://myaccount.google.com/
| 2. Select "Security" from the left menu
| 3. Under "How you sign in to Google", select "2-Step Verification"
|    (You must enable 2-Step Verification first)
| 4. At the bottom, select "App passwords"
| 5. Select "Mail" as the app and "Other" as the device
| 6. Enter "Line Seiki Website" as the custom name
| 7. Click "Generate"
| 8. Copy the 16-character password and paste it in the 'smtp_pass' above
| 
| DO NOT use your regular Gmail password!
| 
*/
