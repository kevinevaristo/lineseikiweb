# 📧 SMUC Email Setup - Quick Checklist

## ✅ Setup Steps

### 1. Download PHPMailer
- [ ] Go to https://github.com/PHPMailer/PHPMailer/releases/latest
- [ ] Download the ZIP file
- [ ] Extract `PHPMailer.php`, `SMTP.php`, and `Exception.php` from the `src/` folder

### 2. Create Folder Structure
- [ ] Create folder: `C:\xampp\htdocs\lineseiki.systems-test.com\application\third_party`
- [ ] Create subfolder: `C:\xampp\htdocs\lineseiki.systems-test.com\application\third_party\PHPMailer`
- [ ] Copy the 3 files into the PHPMailer folder

### 3. Configure Gmail
- [ ] Go to https://myaccount.google.com/security
- [ ] Enable "2-Step Verification"
- [ ] Go to "App passwords" (at the bottom of 2-Step Verification)
- [ ] Create new App Password:
  - App: Mail
  - Device: Other (Custom name) → "Line Seiki Website"
- [ ] Copy the 16-character password

### 4. Update Email Config
- [ ] Open `application/config/email.php`
- [ ] Find line: `$config['smtp_pass'] = 'YOUR_APP_PASSWORD_HERE';`
- [ ] Replace with your 16-character App Password (keep the quotes)
- [ ] Save the file

### 5. Update Controller
- [ ] Open `application/controllers/index.php`
- [ ] Open the file `controller_email_methods.php` in your project root
- [ ] Copy the 3 new methods from `controller_email_methods.php`:
  - `send_quote_email()`
  - `get_email_template()`
  - `get_email_plain_text()`
- [ ] Paste them BEFORE the existing `submit_quote_request()` function
- [ ] Replace the entire `submit_quote_request()` function with the new version
- [ ] Save the file

### 6. Test the System
- [ ] Open browser: http://localhost/lineseiki.systems-test.com/index/ps_serv_silicone
- [ ] Scroll to "Request Quote" section
- [ ] Fill in all fields:
  - Name
  - Email
  - Contact Number
  - Company Name
- [ ] (Optional) Attach a CAD file
- [ ] Click "Request Quote"
- [ ] Check for success message
- [ ] Check Gmail: traballojeffrey3@gmail.com for the email

## 🔍 Troubleshooting

### If email doesn't send:
1. **Check logs**: `application/logs/log-YYYY-MM-DD.php`
2. **Verify App Password** is correct in `email.php`
3. **Check PHPMailer files** are in correct location
4. **Enable debug mode** (see Setup Guide)

### Common Issues:
- ❌ Wrong App Password → Re-generate
- ❌ 2-Step not enabled → Enable in Google Account
- ❌ PHPMailer not found → Check file paths
- ❌ Port 587 blocked → Check firewall

## 📁 File Structure Check

Your structure should look like this:

```
application/
├── config/
│   └── email.php ✓
├── controllers/
│   └── index.php ✓ (updated)
└── third_party/
    └── PHPMailer/
        ├── PHPMailer.php ✓
        ├── SMTP.php ✓
        └── Exception.php ✓
```

## 📧 What the Email Will Look Like

Subject: `New SMUC Quote Request from [Company Name]`

Content:
- Customer Name
- Email Address
- Contact Number  
- Company Name
- Attached File (if any)
- Request Date & Time

Reply-to: Customer's email (so you can reply directly)

## 🎉 You're Done!

Once all checkboxes are ticked, your system will automatically send email notifications to `traballojeffrey3@gmail.com` whenever someone submits a quote request!

---

**Need Help?** Check `SMUC_EMAIL_SETUP_GUIDE.md` for detailed instructions.
