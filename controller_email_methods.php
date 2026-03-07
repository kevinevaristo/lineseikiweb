<?php
/**
 * ADD THESE 3 METHODS TO YOUR index.php CONTROLLER
 * 
 * Place these methods before the existing submit_quote_request() function
 * Then replace the submit_quote_request() function with the new version below
 */

/**
 * Send email using PHPMailer
 */
private function send_quote_email($quote_data)
{
  // Load email config
  $this->config->load('email');
  
  // Include PHPMailer files
  require_once APPPATH . 'third_party/PHPMailer/PHPMailer.php';
  require_once APPPATH . 'third_party/PHPMailer/SMTP.php';
  require_once APPPATH . 'third_party/PHPMailer/Exception.php';
  
  $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
  
  try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = $this->config->item('smtp_host');
    $mail->SMTPAuth = true;
    $mail->Username = $this->config->item('smtp_user');
    $mail->Password = $this->config->item('smtp_pass');
    $mail->SMTPSecure = $this->config->item('smtp_crypto');
    $mail->Port = $this->config->item('smtp_port');
    $mail->CharSet = $this->config->item('charset');
    
    // Recipients
    $mail->setFrom(
      $this->config->item('from_email'),
      $this->config->item('from_name')
    );
    $mail->addAddress('traballojeffrey3@gmail.com', 'Jeffrey Traballo');
    $mail->addReplyTo($quote_data['email'], $quote_data['name']);
    
    // Attachments
    if (!empty($quote_data['file_path'])) {
      $full_path = FCPATH . $quote_data['file_path'];
      if (file_exists($full_path)) {
        $mail->addAttachment($full_path, $quote_data['file_name']);
      }
    }
    
    // Content
    $mail->isHTML(true);
    $mail->Subject = 'New SMUC Quote Request from ' . $quote_data['company_name'];
    
    // Email body
    $mail->Body = $this->get_email_template($quote_data);
    $mail->AltBody = $this->get_email_plain_text($quote_data);
    
    $mail->send();
    log_message('info', 'Quote request email sent successfully');
    return true;
  } catch (Exception $e) {
    log_message('error', 'Email failed: ' . $mail->ErrorInfo);
    return false;
  }
}

/**
 * Get HTML email template
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
 * Get plain text email version
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

// ===== REPLACE YOUR EXISTING submit_quote_request() FUNCTION WITH THIS: =====

function submit_quote_request()
{
  // Load database if not already loaded
  if (!$this->db->conn_id) {
    $this->load->database();
  }
  
  // Set JSON header
  header('Content-Type: application/json');
  
  // Enable error logging for debugging
  log_message('debug', 'Quote request started');
  
  // Validate required fields
  $name = trim($this->input->post('name'));
  $email = trim($this->input->post('email'));
  $contact_number = trim($this->input->post('contact_number'));
  $company_name = trim($this->input->post('company_name'));
  
  if (empty($name) || empty($email) || empty($contact_number) || empty($company_name)) {
    echo json_encode([
      'success' => false,
      'message' => 'Please fill in all required fields.'
    ]);
    exit;
  }
  
  // Validate email format
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
      'success' => false,
      'message' => 'Please enter a valid email address.'
    ]);
    exit;
  }
  
  // Handle file upload
  $file_name = null;
  $file_path = null;
  
  if (!empty($_FILES['project_file']['name'])) {
    $upload_path = FCPATH . 'uploads/quote_requests/';
    
    // Create directory if it doesn't exist
    if (!is_dir($upload_path)) {
      if (!mkdir($upload_path, 0755, true)) {
        echo json_encode([
          'success' => false,
          'message' => 'Failed to create upload directory. Please contact administrator.'
        ]);
        exit;
      }
    }
    
    if (!is_writable($upload_path)) {
      echo json_encode([
        'success' => false,
        'message' => 'Upload directory is not writable. Please contact administrator.'
      ]);
      exit;
    }
    
    $config['upload_path'] = $upload_path;
    $config['allowed_types'] = 'pdf|doc|docx|dwg|dxf|step|stp|iges|igs|stl|zip|rar|jpg|jpeg|png';
    $config['max_size'] = 10240; // 10MB
    $config['encrypt_name'] = TRUE;
    
    $this->upload->initialize($config);
    
    if ($this->upload->do_upload('project_file')) {
      $upload_data = $this->upload->data();
      $file_name = $upload_data['file_name'];
      $file_path = 'uploads/quote_requests/' . $file_name;
      log_message('debug', 'File uploaded successfully: ' . $file_name);
    } else {
      $error = $this->upload->display_errors('', '');
      log_message('error', 'File upload failed: ' . $error);
      echo json_encode([
        'success' => false,
        'message' => 'File upload failed: ' . $error
      ]);
      exit;
    }
  }
  
  // Insert into database
  $data = [
    'name' => $name,
    'email' => $email,
    'contact_number' => $contact_number,
    'company_name' => $company_name,
    'file_name' => $file_name,
    'file_path' => $file_path,
    'status' => 'pending',
    'created_at' => date('Y-m-d H:i:s')
  ];
  
  try {
    $this->db->insert('tbl_request_quote', $data);
    
    if ($this->db->affected_rows() > 0) {
      log_message('info', 'Quote request submitted for: ' . $email);
      
      // Send email notification
      $email_sent = $this->send_quote_email($data);
      
      if ($email_sent) {
        echo json_encode([
          'success' => true,
          'message' => 'Thank you! Your quote request has been submitted successfully. We will contact you soon.'
        ]);
      } else {
        echo json_encode([
          'success' => true,
          'message' => 'Your quote request has been submitted, but email notification failed. We will still process your request.'
        ]);
      }
    } else {
      echo json_encode([
        'success' => false,
        'message' => 'Failed to submit request. Please try again.'
      ]);
    }
  } catch (Exception $e) {
    log_message('error', 'Database error: ' . $e->getMessage());
    echo json_encode([
      'success' => false,
      'message' => 'Database error occurred. Please contact administrator.'
    ]);
  }
  exit;
}
