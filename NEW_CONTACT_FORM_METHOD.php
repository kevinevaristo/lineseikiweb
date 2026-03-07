  /**
   * Handle Contact Us form submission
   * Saves message to tbl_send_us_message table
   */
  public function submit_contact_message()
  {
    // Load the Contact_message_model
    $this->load->model('web/Contact_message_model');
    
    // Set JSON header
    header('Content-Type: application/json');
    
    // Enable error logging
    log_message('debug', 'Contact form submission started');
    
    // Validate required fields
    $name = trim($this->input->post('name'));
    $email = trim($this->input->post('email'));
    $subject = trim($this->input->post('subject'));
    $message = trim($this->input->post('message'));
    
    // Check if all required fields are filled
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
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
    
    // Validate message length
    if (strlen($message) < 10) {
      echo json_encode([
        'success' => false,
        'message' => 'Message must be at least 10 characters long.'
      ]);
      exit;
    }
    
    // Prepare data for insertion
    $data = [
      'name' => $name,
      'email' => $email,
      'subject' => $subject,
      'message' => $message,
      'ip_address' => $this->input->ip_address(),
      'user_agent' => $this->input->user_agent()
    ];
    
    try {
      // Insert into database using the model
      $insert_id = $this->Contact_message_model->insert_message($data);
      
      if ($insert_id) {
        log_message('info', 'Contact message submitted: ID ' . $insert_id . ' from ' . $email);
        
        // Optional: Send email notification to admin
        // $this->send_contact_notification($data);
        
        echo json_encode([
          'success' => true,
          'message' => 'Thank you for your message! We will get back to you soon.'
        ]);
      } else {
        log_message('error', 'Failed to insert contact message to database');
        echo json_encode([
          'success' => false,
          'message' => 'Failed to submit your message. Please try again.'
        ]);
      }
    } catch (Exception $e) {
      log_message('error', 'Contact form error: ' . $e->getMessage());
      echo json_encode([
        'success' => false,
        'message' => 'An error occurred. Please try again later.'
      ]);
    }
    exit;
  }
  
  /**
   * Optional: Send email notification to admin when contact form is submitted
   * Uncomment the call in submit_contact_message() to enable
   */
  private function send_contact_notification($data)
  {
    $this->load->library('email');
    
    // Email configuration
    $config = array(
      'protocol' => 'mail',
      'mailtype' => 'html',
      'charset' => 'utf-8',
      'newline' => "\r\n",
      'wordwrap' => TRUE
    );
    
    $this->email->initialize($config);
    
    // Set email parameters
    $admin_email = 'admin@lineseiki.systems-test.com'; // Change to your admin email
    $this->email->from($data['email'], $data['name']);
    $this->email->to($admin_email);
    $this->email->reply_to($data['email'], $data['name']);
    $this->email->subject('New Contact Form Message: ' . $data['subject']);
    
    // Email body
    $email_body = '
    <!DOCTYPE html>
    <html>
    <head>
      <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #0F467B, #17A2DC); color: white; padding: 20px; text-align: center; }
        .content { background: #f8f9fa; padding: 20px; }
        .info-row { margin: 15px 0; padding: 10px; background: white; border-radius: 5px; }
        .label { font-weight: bold; color: #0F467B; }
      </style>
    </head>
    <body>
      <div class="container">
        <div class="header">
          <h2>New Contact Form Message</h2>
        </div>
        <div class="content">
          <div class="info-row">
            <div class="label">From:</div>
            <div>' . htmlspecialchars($data['name']) . '</div>
          </div>
          <div class="info-row">
            <div class="label">Email:</div>
            <div>' . htmlspecialchars($data['email']) . '</div>
          </div>
          <div class="info-row">
            <div class="label">Subject:</div>
            <div>' . htmlspecialchars($data['subject']) . '</div>
          </div>
          <div class="info-row">
            <div class="label">Message:</div>
            <div>' . nl2br(htmlspecialchars($data['message'])) . '</div>
          </div>
          <div class="info-row">
            <div class="label">Submitted:</div>
            <div>' . date('F j, Y g:i A') . '</div>
          </div>
        </div>
      </div>
    </body>
    </html>
    ';
    
    $this->email->message($email_body);
    
    // Try to send
    try {
      $this->email->send();
      log_message('info', 'Contact notification email sent to admin');
    } catch (Exception $e) {
      log_message('error', 'Failed to send contact notification email: ' . $e->getMessage());
    }
  }
