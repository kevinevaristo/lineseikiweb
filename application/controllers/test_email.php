<?php
/**
 * PHPMailer Test Script
 * 
 * Use this to test if PHPMailer is working correctly
 * Place this file in your project root and access it via browser
 * 
 * URL: http://localhost/lineseiki.systems-test.com/test_email.php
 */

// Load CodeIgniter's paths
define('BASEPATH', TRUE);
define('APPPATH', __DIR__ . '/application/');
define('FCPATH', __DIR__ . '/');

// Include PHPMailer
require_once APPPATH . 'third_party/PHPMailer/PHPMailer.php';
require_once APPPATH . 'third_party/PHPMailer/SMTP.php';
require_once APPPATH . 'third_party/PHPMailer/Exception.php';

// Create instance
$mail = new \PHPMailer\PHPMailer\PHPMailer(true);

echo "<h1>PHPMailer Email Test</h1>";
echo "<hr>";

try {
    // Server settings
    $mail->SMTPDebug = 2; // Enable verbose debug output
    $mail->Debugoutput = 'html'; // Output format
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'traballojeffrey3@gmail.com';
    
    // ⚠️ IMPORTANT: Replace with your actual App Password
    $mail->Password = 'bnag wfwk naaa gfta';
    
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->CharSet = 'UTF-8';
    
    // Recipients
    $mail->setFrom('traballojeffrey3@gmail.com', 'Line Seiki Test');
    $mail->addAddress('traballojeffrey3@gmail.com', 'Jeffrey Traballo');
    
    // Content
    $mail->isHTML(true);
    $mail->Subject = 'PHPMailer Test Email - ' . date('Y-m-d H:i:s');
    $mail->Body = '
    <html>
    <body style="font-family: Arial, sans-serif;">
        <h2 style="color: #0F467B;">✅ PHPMailer Test Successful!</h2>
        <p>If you received this email, your PHPMailer setup is working correctly.</p>
        <p><strong>Test Time:</strong> ' . date('F j, Y g:i A') . '</p>
        <hr>
        <p style="font-size: 12px; color: #666;">
            This is an automated test email from your Line Seiki website.
        </p>
    </body>
    </html>
    ';
    $mail->AltBody = 'PHPMailer Test - If you received this, your setup is working!';
    
    $mail->send();
    
    echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 20px; margin: 20px 0; border-radius: 5px;'>";
    echo "<h3>✅ SUCCESS!</h3>";
    echo "<p>Email sent successfully to traballojeffrey3@gmail.com</p>";
    echo "<p>Check your inbox (and spam folder just in case)</p>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 20px; margin: 20px 0; border-radius: 5px;'>";
    echo "<h3>❌ ERROR!</h3>";
    echo "<p><strong>Error Message:</strong> {$mail->ErrorInfo}</p>";
    echo "<p><strong>Exception:</strong> " . $e->getMessage() . "</p>";
    echo "</div>";
    
    echo "<h3>Common Solutions:</h3>";
    echo "<ol>";
    echo "<li><strong>Authentication failed:</strong> Check if your App Password is correct in this file</li>";
    echo "<li><strong>SMTP connect() failed:</strong> Check your internet connection and firewall</li>";
    echo "<li><strong>Could not authenticate:</strong> Make sure 2-Step Verification is enabled in Google Account</li>";
    echo "<li><strong>Invalid address:</strong> Check email format</li>";
    echo "</ol>";
}

echo "<hr>";
echo "<h3>Setup Checklist:</h3>";
echo "<ol>";
echo "<li>PHPMailer files in: <code>application/third_party/PHPMailer/</code></li>";
echo "<li>2-Step Verification enabled in Google Account</li>";
echo "<li>App Password generated and added to this file (line 32)</li>";
echo "<li>Internet connection active</li>";
echo "<li>Port 587 not blocked by firewall</li>";
echo "</ol>";

echo "<hr>";
echo "<p><strong>File Locations:</strong></p>";
echo "<ul>";
echo "<li>PHPMailer.php: " . (file_exists(APPPATH . 'third_party/PHPMailer/PHPMailer.php') ? '✅ Found' : '❌ NOT FOUND') . "</li>";
echo "<li>SMTP.php: " . (file_exists(APPPATH . 'third_party/PHPMailer/SMTP.php') ? '✅ Found' : '❌ NOT FOUND') . "</li>";
echo "<li>Exception.php: " . (file_exists(APPPATH . 'third_party/PHPMailer/Exception.php') ? '✅ Found' : '❌ NOT FOUND') . "</li>";
echo "</ul>";

echo "<hr>";
echo "<p style='font-size: 12px; color: #666;'>Test completed at " . date('Y-m-d H:i:s') . "</p>";
?>
