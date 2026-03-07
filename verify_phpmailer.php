<?php
/**
 * PHPMailer Installation Verification
 * 
 * This script checks if PHPMailer is installed correctly
 * 
 * URL: http://localhost/lineseiki.systems-test.com/verify_phpmailer.php
 */

define('BASEPATH', TRUE);
define('APPPATH', __DIR__ . '/application/');

echo "<!DOCTYPE html>";
echo "<html><head>";
echo "<meta charset='UTF-8'>";
echo "<title>PHPMailer Installation Verification</title>";
echo "<style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
    h1 { color: #0F467B; }
    .success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; margin: 10px 0; border-radius: 5px; }
    .error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; margin: 10px 0; border-radius: 5px; }
    .info { background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; padding: 15px; margin: 10px 0; border-radius: 5px; }
    .file-check { padding: 10px; margin: 5px 0; }
    .check-mark { color: #28a745; font-weight: bold; font-size: 20px; }
    .x-mark { color: #dc3545; font-weight: bold; font-size: 20px; }
    code { background: #f4f4f4; padding: 2px 5px; border-radius: 3px; }
</style>";
echo "</head><body>";

echo "<h1>🔍 PHPMailer Installation Verification</h1>";
echo "<hr>";

// Check if third_party folder exists
$third_party_path = APPPATH . 'third_party';
echo "<h2>Step 1: Check Folders</h2>";

if (is_dir($third_party_path)) {
    echo "<div class='success'><span class='check-mark'>✅</span> Folder 'third_party' exists</div>";
} else {
    echo "<div class='error'><span class='x-mark'>❌</span> Folder 'third_party' NOT FOUND</div>";
    echo "<div class='info'><strong>Solution:</strong> Create folder: <code>" . $third_party_path . "</code></div>";
}

// Check if PHPMailer folder exists
$phpmailer_path = APPPATH . 'third_party/PHPMailer';
if (is_dir($phpmailer_path)) {
    echo "<div class='success'><span class='check-mark'>✅</span> Folder 'PHPMailer' exists</div>";
} else {
    echo "<div class='error'><span class='x-mark'>❌</span> Folder 'PHPMailer' NOT FOUND</div>";
    echo "<div class='info'><strong>Solution:</strong> Create folder: <code>" . $phpmailer_path . "</code></div>";
}

// Check if PHPMailer files exist
echo "<h2>Step 2: Check PHPMailer Files</h2>";

$files = [
    'PHPMailer.php' => APPPATH . 'third_party/PHPMailer/PHPMailer.php',
    'SMTP.php' => APPPATH . 'third_party/PHPMailer/SMTP.php',
    'Exception.php' => APPPATH . 'third_party/PHPMailer/Exception.php'
];

$all_files_exist = true;
foreach ($files as $name => $path) {
    if (file_exists($path)) {
        $size = filesize($path);
        echo "<div class='file-check success'>";
        echo "<span class='check-mark'>✅</span> <strong>$name</strong> - Found (" . number_format($size) . " bytes)";
        echo "</div>";
    } else {
        $all_files_exist = false;
        echo "<div class='file-check error'>";
        echo "<span class='x-mark'>❌</span> <strong>$name</strong> - NOT FOUND";
        echo "<br><small>Expected at: <code>$path</code></small>";
        echo "</div>";
    }
}

// Overall status
echo "<hr>";
echo "<h2>Overall Status</h2>";

if ($all_files_exist) {
    echo "<div class='success'>";
    echo "<h3>🎉 PHPMailer is Installed Correctly!</h3>";
    echo "<p>All required files are present. You can now:</p>";
    echo "<ol>";
    echo "<li>Configure your Gmail App Password in <code>application/config/email.php</code></li>";
    echo "<li>Add the email methods to <code>application/controllers/index.php</code></li>";
    echo "<li>Test the email functionality with <code>test_email.php</code></li>";
    echo "</ol>";
    echo "</div>";
    
    // Try to include files to verify they're valid
    echo "<h2>Step 3: Verify File Integrity</h2>";
    try {
        require_once APPPATH . 'third_party/PHPMailer/Exception.php';
        require_once APPPATH . 'third_party/PHPMailer/SMTP.php';
        require_once APPPATH . 'third_party/PHPMailer/PHPMailer.php';
        
        echo "<div class='success'>";
        echo "<span class='check-mark'>✅</span> All files can be loaded successfully!";
        echo "</div>";
        
        // Check if classes exist
        if (class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
            echo "<div class='success'>";
            echo "<span class='check-mark'>✅</span> PHPMailer class found and ready to use!";
            echo "</div>";
        }
        
    } catch (Exception $e) {
        echo "<div class='error'>";
        echo "<span class='x-mark'>❌</span> Error loading files: " . $e->getMessage();
        echo "</div>";
    }
    
} else {
    echo "<div class='error'>";
    echo "<h3>❌ PHPMailer is NOT Installed Correctly</h3>";
    echo "<p>Some required files are missing. Please follow these steps:</p>";
    echo "<ol>";
    echo "<li>Download PHPMailer from: <a href='https://github.com/PHPMailer/PHPMailer/archive/refs/tags/v6.9.1.zip' target='_blank'>Download Link</a></li>";
    echo "<li>Extract the ZIP file</li>";
    echo "<li>Navigate to the <code>src</code> folder inside the extracted folder</li>";
    echo "<li>Copy these 3 files: PHPMailer.php, SMTP.php, Exception.php</li>";
    echo "<li>Paste them into: <code>" . APPPATH . "third_party/PHPMailer/</code></li>";
    echo "<li>Refresh this page to verify</li>";
    echo "</ol>";
    echo "</div>";
    
    echo "<div class='info'>";
    echo "<strong>📖 Need detailed instructions?</strong><br>";
    echo "Read: <code>PHPMAILER_INSTALLATION.md</code> in your project root folder.";
    echo "</div>";
}

// Show directory structure
echo "<hr>";
echo "<h2>Current Directory Structure</h2>";
echo "<pre>";
echo "application/\n";
echo "├── config/\n";
echo "├── controllers/\n";
echo "├── models/\n";
echo "├── views/\n";

if (is_dir($third_party_path)) {
    echo "└── third_party/ <span class='check-mark'>✅</span>\n";
    if (is_dir($phpmailer_path)) {
        echo "    └── PHPMailer/ <span class='check-mark'>✅</span>\n";
        foreach ($files as $name => $path) {
            if (file_exists($path)) {
                echo "        ├── $name <span class='check-mark'>✅</span>\n";
            } else {
                echo "        ├── $name <span class='x-mark'>❌ MISSING</span>\n";
            }
        }
    } else {
        echo "    └── PHPMailer/ <span class='x-mark'>❌ NOT FOUND</span>\n";
    }
} else {
    echo "└── third_party/ <span class='x-mark'>❌ NOT FOUND</span>\n";
}
echo "</pre>";

echo "<hr>";
echo "<p style='text-align: center; color: #666; font-size: 12px;'>";
echo "Verification completed at " . date('Y-m-d H:i:s');
echo "</p>";

echo "</body></html>";
?>
