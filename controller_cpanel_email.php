<?php
/**
 * UPDATED CONTROLLER CODE FOR CPANEL HOSTING
 * 
 * This version works on BOTH local (XAMPP) and live (cPanel) servers
 * 
 * Replace the send_quote_email() method in your index.php controller with this:
 */

/**
 * Send email - Works on both Local and Live servers
 */
private function send_quote_email($quote_data)
{
    // Load CodeIgniter's email library
    $this->load->library('email');
    
    // Detect if we're on local or live server
    $is_local = (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || 
                 strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false);
    
    if ($is_local) {
        // LOCAL XAMPP - Use Gmail SMTP
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_user' => 'traballojeffrey3@gmail.com',
            'smtp_pass' => 'bnag wfwk naaa gfta',  // ⚠️ Replace with your App Password!
            'smtp_crypto' => 'tls',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n",
            'wordwrap' => TRUE
        );
        
        log_message('debug', 'Using Gmail SMTP for local development');
    } else {
        // LIVE cPANEL - Use PHP mail() function
        $config = array(
            'protocol' => 'mail',  // Uses cPanel's mail server
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n",
            'wordwrap' => TRUE
        );
        
        log_message('debug', 'Using cPanel mail() for live server');
    }
    
    // Initialize email with config
    $this->email->initialize($config);
    
    // Use appropriate FROM email based on environment
    // ⚠️ IMPORTANT: Replace 'yourdomain.com' with your actual domain!
    $from_email = $is_local ? 'traballojeffrey3@gmail.com' : 'admin@lineseiki.systems-test.com';
    $from_name = 'Line Seiki Asia Pacific - SMUC';
    
    // Set email parameters
    $this->email->from($from_email, $from_name);
    $this->email->to('traballojeffrey3@gmail.com');
    $this->email->reply_to($quote_data['email'], $quote_data['name']);
    $this->email->subject('New SMUC Quote Request from ' . $quote_data['company_name']);
    
    // Attach file if exists
    if (!empty($quote_data['file_path'])) {
        $full_path = FCPATH . $quote_data['file_path'];
        if (file_exists($full_path)) {
            $this->email->attach($full_path);
            log_message('debug', 'File attached: ' . $quote_data['file_name']);
        } else {
            log_message('warning', 'Attachment file not found: ' . $full_path);
        }
    }
    
    // Set email body (HTML)
    $this->email->message($this->get_email_template($quote_data));
    
    // Try to send email
    try {
        if ($this->email->send()) {
            log_message('info', 'Quote email sent successfully to traballojeffrey3@gmail.com');
            return true;
        } else {
            // Log the error
            $error = $this->email->print_debugger(array('headers'));
            log_message('error', 'Email send failed: ' . $error);
            return false;
        }
    } catch (Exception $e) {
        log_message('error', 'Email exception: ' . $e->getMessage());
        return false;
    }
}

/**
 * Get HTML email template (SAME AS BEFORE)
 */
private function get_email_template($data)
{
    $html = '
    <!DOCTYPE html>
    <html>
    <head>
      <meta charset="UTF-8">
      <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #0F467B, #17A2DC); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { background: #f8f9fa; padding: 30px; }
        .info-row { margin-bottom: 20px; padding: 15px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .label { font-weight: bold; color: #0F467B; margin-bottom: 5px; }
        .value { color: #333; }
        .footer { background: #0F467B; color: white; padding: 20px; text-align: center; border-radius: 0 0 10px 10px; }
        .badge { background: #28a745; color: white; padding: 5px 10px; border-radius: 4px; font-size: 12px; }
      </style>
    </head>
    <body>
      <div class="container">
        <div class="header">
          <h1>🔔 New SMUC Quote Request</h1>
          <p style="margin: 10px 0 0 0;">Silicone Molding & Urethane Casting</p>
        </div>
        
        <div class="content">
          <p style="text-align: center; margin-bottom: 30px;">
            <span class="badge">NEW REQUEST</span>
          </p>
          
          <div class="info-row">
            <div class="label">👤 Customer Name:</div>
            <div class="value">' . htmlspecialchars($data['name']) . '</div>
          </div>
          
          <div class="info-row">
            <div class="label">📧 Email Address:</div>
            <div class="value">' . htmlspecialchars($data['email']) . '</div>
          </div>
          
          <div class="info-row">
            <div class="label">📞 Contact Number:</div>
            <div class="value">' . htmlspecialchars($data['contact_number']) . '</div>
          </div>
          
          <div class="info-row">
            <div class="label">🏢 Company Name:</div>
            <div class="value">' . htmlspecialchars($data['company_name']) . '</div>
          </div>
          
          <div class="info-row">
            <div class="label">📎 Attached File:</div>
            <div class="value">' . (!empty($data['file_name']) ? htmlspecialchars($data['file_name']) : 'No file attached') . '</div>
          </div>
          
          <div class="info-row">
            <div class="label">📅 Request Date:</div>
            <div class="value">' . date('F j, Y g:i A') . '</div>
          </div>
        </div>
        
        <div class="footer">
          <p style="margin: 0;">Line Seiki Asia Pacific</p>
          <p style="margin: 5px 0 0 0; font-size: 14px; opacity: 0.8;">Automated Quote Request Notification</p>
        </div>
      </div>
    </body>
    </html>
    ';
    
    return $html;
}

/**
 * Get plain text email version (SAME AS BEFORE)
 */
private function get_email_plain_text($data)
{
    $text = "NEW SMUC QUOTE REQUEST\n";
    $text .= "=====================================\n\n";
    $text .= "Customer Name: " . $data['name'] . "\n";
    $text .= "Email: " . $data['email'] . "\n";
    $text .= "Contact Number: " . $data['contact_number'] . "\n";
    $text .= "Company: " . $data['company_name'] . "\n";
    $text .= "Attached File: " . (!empty($data['file_name']) ? $data['file_name'] : 'None') . "\n";
    $text .= "Request Date: " . date('F j, Y g:i A') . "\n\n";
    $text .= "-------------------------------------\n";
    $text .= "Line Seiki Asia Pacific\n";
    $text .= "Automated Quote Request Notification";
    
    return $text;
}

// Keep the submit_quote_request() function EXACTLY THE SAME as before
// The only change is in send_quote_email() above

/**
 * ⚠️ IMPORTANT NOTES:
 * 
 * 1. Replace 'YOUR_GMAIL_APP_PASSWORD_HERE' with your actual Gmail App Password
 * 
 * 2. Replace 'noreply@lineseiki.systems-test.com' with your actual domain email
 *    (You may need to create this email in cPanel first)
 * 
 * 3. This code automatically detects if you're on local or live server
 *    - Local: Uses Gmail SMTP
 *    - Live: Uses cPanel's mail() function
 * 
 * 4. Make sure your cPanel has proper email settings:
 *    - Email Routing: "Local Mail Exchanger"
 *    - Email Deliverability: All checks should be green
 * 
 * 5. Check logs for errors:
 *    - application/logs/log-YYYY-MM-DD.php
 */
?>
