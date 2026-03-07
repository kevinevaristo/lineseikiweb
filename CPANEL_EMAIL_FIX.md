# 🌐 Fixing Email on cPanel/Online Hosting

## 🔍 The Problem

Your quote requests work locally (XAMPP) but emails don't send on your live cPanel hosting. This happens because:

1. **cPanel blocks external SMTP** (like Gmail's smtp.gmail.com)
2. **Port 587 is often blocked** by hosting providers
3. **Gmail may block connections** from unknown servers

## ✅ Solution Options

---

## 🎯 OPTION 1: Use cPanel's Built-in Email (RECOMMENDED)

This is the easiest and most reliable solution for cPanel hosting.

### Step 1: Create Email Configuration for cPanel

Create a new file or update your existing email config:

**File:** `application/config/email.php`

```php
<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Detect if we're on local or live server
$is_local = ($_SERVER['SERVER_NAME'] == 'localhost' || 
             strpos($_SERVER['SERVER_NAME'], '127.0.0.1') !== false);

if ($is_local) {
    // LOCAL XAMPP - Use Gmail SMTP
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'smtp.gmail.com';
    $config['smtp_port'] = 587;
    $config['smtp_user'] = 'traballojeffrey3@gmail.com';
    $config['smtp_pass'] = 'YOUR_APP_PASSWORD_HERE';  // Your Gmail App Password
    $config['smtp_crypto'] = 'tls';
} else {
    // LIVE cPANEL - Use PHP mail() function
    $config['protocol'] = 'mail';  // Use cPanel's mail server
    $config['smtp_host'] = '';
    $config['smtp_port'] = '';
    $config['smtp_user'] = '';
    $config['smtp_pass'] = '';
    $config['smtp_crypto'] = '';
}

// Common settings for both
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";
$config['wordwrap'] = TRUE;
$config['from_email'] = 'noreply@yourdomain.com';  // Change this!
$config['from_name'] = 'Line Seiki Asia Pacific - SMUC';
```

**⚠️ IMPORTANT:** Change `noreply@yourdomain.com` to an actual email address on your domain (like `noreply@lineseiki.systems-test.com`)

---

## 🎯 OPTION 2: Use CodeIgniter's Email Library (Simpler)

If Option 1 doesn't work, use CodeIgniter's built-in email library instead of PHPMailer.

### Update Your Controller

Replace the `send_quote_email()` method with this simpler version:

```php
/**
 * Send email using CodeIgniter Email Library
 */
private function send_quote_email($quote_data)
{
    // Load email library
    $this->load->library('email');
    
    // Detect environment
    $is_local = ($_SERVER['SERVER_NAME'] == 'localhost' || 
                 strpos($_SERVER['SERVER_NAME'], '127.0.0.1') !== false);
    
    if ($is_local) {
        // LOCAL - Use Gmail SMTP
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp.gmail.com';
        $config['smtp_port'] = 587;
        $config['smtp_user'] = 'traballojeffrey3@gmail.com';
        $config['smtp_pass'] = 'YOUR_APP_PASSWORD_HERE';  // Your Gmail App Password
        $config['smtp_crypto'] = 'tls';
    } else {
        // LIVE cPanel - Use mail() function
        $config['protocol'] = 'mail';
    }
    
    // Common settings
    $config['mailtype'] = 'html';
    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $config['wordwrap'] = TRUE;
    
    $this->email->initialize($config);
    
    // Set email parameters
    $this->email->from('noreply@yourdomain.com', 'Line Seiki SMUC');  // Change domain!
    $this->email->to('traballojeffrey3@gmail.com');
    $this->email->reply_to($quote_data['email'], $quote_data['name']);
    $this->email->subject('New SMUC Quote Request from ' . $quote_data['company_name']);
    
    // Attach file if exists
    if (!empty($quote_data['file_path'])) {
        $full_path = FCPATH . $quote_data['file_path'];
        if (file_exists($full_path)) {
            $this->email->attach($full_path);
        }
    }
    
    // Set email body
    $this->email->message($this->get_email_template($quote_data));
    
    // Send email
    if ($this->email->send()) {
        log_message('info', 'Quote request email sent successfully');
        return true;
    } else {
        log_message('error', 'Email failed: ' . $this->email->print_debugger());
        return false;
    }
}
```

---

## 🎯 OPTION 3: Create Email Account in cPanel

If you want to use SMTP on cPanel, use cPanel's own mail server:

### Step 1: Create Email Account in cPanel
1. Log into cPanel
2. Go to "Email Accounts"
3. Create: `noreply@yourdomain.com`
4. Set a password (save it!)

### Step 2: Update Email Config

```php
<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Use your cPanel email SMTP
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'mail.yourdomain.com';  // or 'localhost' on cPanel
$config['smtp_port'] = 587;  // or 465 for SSL
$config['smtp_user'] = 'noreply@yourdomain.com';  // Email you created
$config['smtp_pass'] = 'your_email_password';  // Password you set
$config['smtp_crypto'] = 'tls';  // or 'ssl'
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";
$config['wordwrap'] = TRUE;
$config['from_email'] = 'noreply@yourdomain.com';
$config['from_name'] = 'Line Seiki Asia Pacific - SMUC';
```

---

## 🎯 OPTION 4: Use SendGrid or Mailgun (Professional)

For high-volume and reliable email:

### SendGrid (Free tier: 100 emails/day)
1. Sign up: https://sendgrid.com
2. Get API key
3. Update config:

```php
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.sendgrid.net';
$config['smtp_port'] = 587;
$config['smtp_user'] = 'apikey';
$config['smtp_pass'] = 'YOUR_SENDGRID_API_KEY';
$config['smtp_crypto'] = 'tls';
```

---

## 🧪 Testing on Live Server

### Enable Debug Mode

Add this temporarily to see what's wrong:

```php
// In send_quote_email() method, add:
$this->email->set_newline("\r\n");
$this->email->set_crlf("\r\n");

// After $this->email->send(), add:
if (!$this->email->send()) {
    echo $this->email->print_debugger();  // Shows detailed error
    exit;
}
```

---

## 🔍 Common cPanel Issues & Solutions

### Issue 1: "Could not send email via SMTP"
**Solution:** Use `mail` protocol instead of `smtp`
```php
$config['protocol'] = 'mail';
```

### Issue 2: "Connection refused on port 587"
**Solution:** cPanel blocks external SMTP. Use Option 1 or 3.

### Issue 3: "From address rejected"
**Solution:** Use an email address on your domain, not Gmail
```php
$config['from_email'] = 'noreply@yourdomain.com';
```

### Issue 4: Emails go to Spam
**Solution:** 
1. Add SPF record in cPanel DNS
2. Add DKIM in cPanel Email Authentication
3. Use domain email, not Gmail

---

## 📝 Quick Fix - Copy This Entire Controller Method

Here's the complete working version for both local and live:

```php
private function send_quote_email($quote_data)
{
    $this->load->library('email');
    
    // Detect if local or live
    $is_local = (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false);
    
    if ($is_local) {
        // Gmail for local testing
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_user' => 'traballojeffrey3@gmail.com',
            'smtp_pass' => 'YOUR_APP_PASSWORD_HERE',
            'smtp_crypto' => 'tls',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n",
            'wordwrap' => TRUE
        );
    } else {
        // cPanel mail() for live server
        $config = array(
            'protocol' => 'mail',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n",
            'wordwrap' => TRUE
        );
    }
    
    $this->email->initialize($config);
    
    // Use domain email on live, Gmail on local
    $from_email = $is_local ? 'traballojeffrey3@gmail.com' : 'noreply@yourdomain.com';
    
    $this->email->from($from_email, 'Line Seiki SMUC');
    $this->email->to('traballojeffrey3@gmail.com');
    $this->email->reply_to($quote_data['email'], $quote_data['name']);
    $this->email->subject('New SMUC Quote Request from ' . $quote_data['company_name']);
    
    // Attach file
    if (!empty($quote_data['file_path'])) {
        $full_path = FCPATH . $quote_data['file_path'];
        if (file_exists($full_path)) {
            $this->email->attach($full_path);
        }
    }
    
    $this->email->message($this->get_email_template($quote_data));
    
    if ($this->email->send()) {
        log_message('info', 'Email sent successfully');
        return true;
    } else {
        log_message('error', 'Email failed: ' . $this->email->print_debugger());
        return false;
    }
}
```

---

## ✅ What to Do Now

**For cPanel hosting, I recommend Option 1 or 2:**

1. **Use `mail` protocol** instead of `smtp` (easiest)
2. **Use domain email** (`noreply@yourdomain.com`) not Gmail
3. **Keep PHPMailer for local** testing with Gmail

---

## 📧 Still Not Working?

Check your cPanel:
1. Email Deliverability - Make sure it's green
2. Track Delivery - See if emails are being sent
3. Email Routing - Should be "Local Mail Exchanger"

**Let me know which option you want to try and I'll help you implement it!**
