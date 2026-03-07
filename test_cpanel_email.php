<?php
/**
 * SIMPLE EMAIL TEST SCRIPT PARA SA CPANEL
 * 
 * I-upload ito sa root folder ng website mo
 * Tapos buksan sa browser: http://yourdomain.com/test_cpanel_email.php
 */

// CodeIgniter paths
define('BASEPATH', TRUE);
$system_path = 'system';
$application_folder = 'application';

// Load basic CI setup
define('APPPATH', $application_folder . '/');
define('FCPATH', __DIR__ . '/');

echo "<html><head><title>cPanel Email Test</title>";
echo "<style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
    .success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; margin: 10px 0; border-radius: 5px; }
    .error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; margin: 10px 0; border-radius: 5px; }
    .info { background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; padding: 15px; margin: 10px 0; border-radius: 5px; }
    h1 { color: #0F467B; }
    pre { background: #f4f4f4; padding: 10px; border-radius: 5px; overflow-x: auto; }
</style></head><body>";

echo "<h1>📧 cPanel Email Test</h1><hr>";

// Simple mail test using PHP's mail() function
$to = "traballojeffrey3@gmail.com";
$subject = "Test Email from cPanel - " . date('Y-m-d H:i:s');
$message = "
<html>
<head>
    <title>Test Email</title>
</head>
<body style='font-family: Arial, sans-serif;'>
    <h2 style='color: #0F467B;'>✅ cPanel Email Test</h2>
    <p>Kung nakita mo to, <strong>GUMAGANA ANG EMAIL!</strong></p>
    <p><strong>Sent at:</strong> " . date('F j, Y g:i A') . "</p>
    <p><strong>Server:</strong> " . $_SERVER['SERVER_NAME'] . "</p>
    <hr>
    <p style='font-size: 12px; color: #666;'>
        This is a test email from Line Seiki SMUC Quote Request System
    </p>
</body>
</html>
";

// Email headers
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: noreply@" . $_SERVER['SERVER_NAME'] . "\r\n";  // Auto-detect domain

echo "<div class='info'>";
echo "<strong>Test Details:</strong><br>";
echo "• To: <code>$to</code><br>";
echo "• From: <code>noreply@" . $_SERVER['SERVER_NAME'] . "</code><br>";
echo "• Subject: <code>$subject</code><br>";
echo "• Server: <code>" . $_SERVER['SERVER_NAME'] . "</code><br>";
echo "</div>";

// Try to send email
if (mail($to, $subject, $message, $headers)) {
    echo "<div class='success'>";
    echo "<h3>✅ EMAIL SENT SUCCESSFULLY!</h3>";
    echo "<p>Nag-send na ang email. Check mo sa:</p>";
    echo "<ol>";
    echo "<li><strong>Gmail Inbox:</strong> traballojeffrey3@gmail.com</li>";
    echo "<li><strong>Spam Folder:</strong> Baka nandun</li>";
    echo "<li><strong>cPanel Track Delivery:</strong> Para sa detailed logs</li>";
    echo "</ol>";
    echo "</div>";
    
    echo "<div class='info'>";
    echo "<h3>📋 Next Steps:</h3>";
    echo "<ol>";
    echo "<li>Check your Gmail now (traballojeffrey3@gmail.com)</li>";
    echo "<li>Look for email with subject: \"Test Email from cPanel\"</li>";
    echo "<li>Check Spam/Junk folder if not in Inbox</li>";
    echo "<li>If received, your cPanel email is working! ✅</li>";
    echo "</ol>";
    echo "</div>";
} else {
    echo "<div class='error'>";
    echo "<h3>❌ EMAIL SENDING FAILED!</h3>";
    echo "<p>Hindi nag-send ang email. Possible reasons:</p>";
    echo "<ol>";
    echo "<li>Email functions disabled sa server</li>";
    echo "<li>No email account configured sa cPanel</li>";
    echo "<li>Email deliverability issue</li>";
    echo "<li>Spam/sending limits reached</li>";
    echo "</ol>";
    echo "</div>";
    
    echo "<div class='info'>";
    echo "<h3>🔧 Troubleshooting Steps:</h3>";
    echo "<ol>";
    echo "<li><strong>cPanel Email Deliverability:</strong>";
    echo "<ul>";
    echo "<li>Login to cPanel</li>";
    echo "<li>Go to 'Email Deliverability'</li>";
    echo "<li>Make sure your domain shows GREEN ✅</li>";
    echo "<li>If RED ❌, click 'Manage' and fix issues</li>";
    echo "</ul></li>";
    echo "<li><strong>Create Email Account:</strong>";
    echo "<ul>";
    echo "<li>Go to 'Email Accounts' in cPanel</li>";
    echo "<li>Create: noreply@" . $_SERVER['SERVER_NAME'] . "</li>";
    echo "</ul></li>";
    echo "<li><strong>Check Email Routing:</strong>";
    echo "<ul>";
    echo "<li>Go to 'Email Routing' in cPanel</li>";
    echo "<li>Should be 'Local Mail Exchanger'</li>";
    echo "</ul></li>";
    echo "</ol>";
    echo "</div>";
}

// Server info
echo "<hr>";
echo "<h3>🖥️ Server Information</h3>";
echo "<pre>";
echo "Server Name: " . $_SERVER['SERVER_NAME'] . "\n";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "\n";
echo "PHP Version: " . phpversion() . "\n";
echo "mail() function: " . (function_exists('mail') ? '✅ Available' : '❌ Not Available') . "\n";
echo "</pre>";

echo "<hr>";
echo "<p style='text-align: center; color: #666; font-size: 12px;'>";
echo "Test completed at " . date('Y-m-d H:i:s');
echo "<br>Delete this file after testing for security.";
echo "</p>";

echo "</body></html>";
?>
