# 📊 SMUC Email System - Flow Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                    USER FILLS OUT FORM                          │
│  (Name, Email, Contact Number, Company Name, Optional File)    │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         │ Clicks "Request Quote"
                         ▼
┌─────────────────────────────────────────────────────────────────┐
│               JAVASCRIPT SUBMITS FORM                           │
│  (AJAX POST to: index/submit_quote_request)                     │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────────────┐
│          CONTROLLER: submit_quote_request()                     │
│  1. Validates all required fields                               │
│  2. Validates email format                                      │
│  3. Handles file upload (if provided)                           │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────────────┐
│              DATABASE: tbl_request_quote                        │
│  INSERT INTO tbl_request_quote:                                 │
│  - name                                                          │
│  - email                                                         │
│  - contact_number                                                │
│  - company_name                                                  │
│  - file_name (if uploaded)                                       │
│  - file_path (if uploaded)                                       │
│  - status = 'pending'                                            │
│  - created_at = NOW()                                            │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         │ Success?
                         ▼
┌─────────────────────────────────────────────────────────────────┐
│          CONTROLLER: send_quote_email()                         │
│  Calls PHPMailer to send email notification                     │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────────────┐
│              PHPMAILER CONFIGURATION                            │
│  Server: smtp.gmail.com                                          │
│  Port: 587 (TLS)                                                 │
│  Username: traballojeffrey3@gmail.com                           │
│  Password: [Your App Password]                                   │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────────────┐
│          EMAIL TEMPLATE: get_email_template()                   │
│  Creates beautiful HTML email with:                             │
│  - Company header with gradient                                 │
│  - Customer information cards                                    │
│  - File attachment (if any)                                      │
│  - Professional footer                                           │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────────────┐
│                   GMAIL SMTP SERVER                             │
│  Sends email via Google's servers                               │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────────────┐
│           EMAIL DELIVERED TO YOUR INBOX                         │
│  To: traballojeffrey3@gmail.com                                 │
│  Subject: "New SMUC Quote Request from [Company]"               │
│  Reply-To: [Customer's Email]                                    │
│  Attachment: [Customer's File] (if provided)                     │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────────────┐
│              SUCCESS RESPONSE TO USER                           │
│  JSON: { success: true, message: "Thank you! ..." }            │
│  JavaScript displays success message on page                    │
│  Form resets automatically                                       │
└─────────────────────────────────────────────────────────────────┘
```

---

## 🔄 Error Handling Flow

```
USER SUBMITS FORM
    │
    ├─ Missing Fields? ──> Return Error: "Please fill all fields"
    │
    ├─ Invalid Email? ──> Return Error: "Invalid email address"
    │
    ├─ File Upload Error? ──> Return Error: "File upload failed"
    │
    ├─ Database Error? ──> Return Error: "Database error occurred"
    │
    ├─ Email Sending Error? ──> Return Success with Warning:
    │                          "Submitted but email notification failed"
    │
    └─ All Success ──> Return: "Thank you! We will contact you soon"
```

---

## 📁 File Structure

```
lineseiki.systems-test.com/
│
├── application/
│   ├── config/
│   │   └── email.php ⚙️ (Email settings - ADD APP PASSWORD HERE)
│   │
│   ├── controllers/
│   │   └── index.php 🔧 (Add 3 new methods here)
│   │
│   ├── third_party/ 📦 (CREATE THIS FOLDER)
│   │   └── PHPMailer/
│   │       ├── PHPMailer.php ✉️
│   │       ├── SMTP.php 📡
│   │       └── Exception.php ⚠️
│   │
│   └── views/
│       └── web/
│           └── ps_serv_silicone.php 📄 (Form is here)
│
├── uploads/
│   └── quote_requests/ 📎 (Files uploaded here)
│
├── test_email.php 🧪 (Test script)
├── controller_email_methods.php 📋 (Code to copy)
├── EMAIL_SETUP_CHECKLIST.md ✅
├── SMUC_EMAIL_SETUP_GUIDE.md 📖
└── README_EMAIL_SETUP.md 📚
```

---

## 🎨 Email Template Preview

```
┌──────────────────────────────────────────────┐
│                                              │
│   🔔 New SMUC Quote Request                 │
│   Silicone Molding & Urethane Casting      │
│                                              │
├──────────────────────────────────────────────┤
│                                              │
│   [NEW REQUEST] Badge                        │
│                                              │
│   ┌────────────────────────────────────┐    │
│   │ 👤 Customer Name:                 │    │
│   │ John Doe                           │    │
│   └────────────────────────────────────┘    │
│                                              │
│   ┌────────────────────────────────────┐    │
│   │ 📧 Email Address:                 │    │
│   │ john@company.com                   │    │
│   └────────────────────────────────────┘    │
│                                              │
│   ┌────────────────────────────────────┐    │
│   │ 📞 Contact Number:                │    │
│   │ +63 912 345 6789                   │    │
│   └────────────────────────────────────┘    │
│                                              │
│   ┌────────────────────────────────────┐    │
│   │ 🏢 Company Name:                  │    │
│   │ ABC Manufacturing Inc.             │    │
│   └────────────────────────────────────┘    │
│                                              │
│   ┌────────────────────────────────────┐    │
│   │ 📎 Attached File:                 │    │
│   │ product_design.step                │    │
│   └────────────────────────────────────┘    │
│                                              │
│   ┌────────────────────────────────────┐    │
│   │ 📅 Request Date:                  │    │
│   │ January 17, 2026 10:30 AM         │    │
│   └────────────────────────────────────┘    │
│                                              │
├──────────────────────────────────────────────┤
│   Line Seiki Asia Pacific                   │
│   Automated Quote Request Notification      │
└──────────────────────────────────────────────┘
```

---

## 🔐 Security Features

```
✅ Email Validation
   └─> PHP filter_var(FILTER_VALIDATE_EMAIL)

✅ File Type Restrictions
   └─> Only: pdf, doc, docx, dwg, dxf, step, stp, 
            iges, igs, stl, zip, rar, jpg, jpeg, png

✅ File Size Limit
   └─> Maximum 10MB

✅ Encrypted Filenames
   └─> CodeIgniter's encrypt_name prevents conflicts

✅ Secure Upload Directory
   └─> uploads/quote_requests/ with .htaccess protection

✅ SQL Injection Protection
   └─> CodeIgniter Active Record (prepared statements)

✅ XSS Protection
   └─> htmlspecialchars() on all email output

✅ App Password
   └─> No plain Gmail password stored
```

---

## 📊 What Gets Logged

```
INFO Logs (application/logs/):
  ✓ Quote request started
  ✓ File uploaded successfully: [filename]
  ✓ Quote request submitted for: [email]
  ✓ Quote request email sent successfully

ERROR Logs (application/logs/):
  ✗ Missing required fields
  ✗ Invalid email format: [email]
  ✗ File upload failed: [error]
  ✗ Database insert failed
  ✗ Email sending failed: [error]
```

---

## 🎯 Key Integration Points

| Component | Location | Purpose |
|-----------|----------|---------|
| Form HTML | ps_serv_silicone.php | User interface |
| Form Submit | JavaScript (inline) | AJAX submission |
| Controller | index.php | Request handling |
| PHPMailer | third_party/PHPMailer/ | Email sending |
| Config | config/email.php | SMTP settings |
| Database | tbl_request_quote | Data storage |
| Uploads | uploads/quote_requests/ | File storage |

---

**This diagram shows the complete flow from user submission to email delivery!**
