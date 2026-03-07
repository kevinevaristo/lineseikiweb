# 📧 SMUC Email Notification System - Complete Setup

## 🎯 What You're Setting Up

When someone fills out the "Request Quote" form on your SMUC page and clicks "Request Quote", the system will:

1. ✅ Save the request to your database (tbl_request_quote)
2. ✅ Send a beautiful HTML email to your Gmail (traballojeffrey3@gmail.com)
3. ✅ Include all customer details (Name, Email, Contact, Company)
4. ✅ Attach any uploaded files (CAD models, drawings, etc.)
5. ✅ Allow you to reply directly to the customer

---

## 📁 Files Created for You

I've created the following files in your project root:

1. **SMUC_EMAIL_SETUP_GUIDE.md** - Detailed step-by-step instructions
2. **EMAIL_SETUP_CHECKLIST.md** - Quick checklist to follow
3. **controller_email_methods.php** - Code to add to your controller
4. **test_email.php** - Test script to verify PHPMailer works
5. **application/config/email.php** - Email configuration file

---

## 🚀 Quick Start (5 Steps)

### Step 1: Download PHPMailer
```
1. Go to: https://github.com/PHPMailer/PHPMailer/releases/latest
2. Download the latest release (ZIP file)
3. Extract these 3 files from the 'src' folder:
   - PHPMailer.php
   - SMTP.php
   - Exception.php
```

### Step 2: Create Folders
```
Create this folder structure:
C:\xampp\htdocs\lineseiki.systems-test.com\application\third_party\PHPMailer\

Then copy the 3 PHPMailer files into that folder
```

### Step 3: Get Gmail App Password
```
1. Visit: https://myaccount.google.com/security
2. Enable "2-Step Verification" (if not already)
3. Scroll down to "App passwords"
4. Select: Mail + Other (custom name: "Line Seiki Website")
5. Click Generate
6. COPY the 16-character password (no spaces)
```

### Step 4: Update Email Config
```
1. Open: application/config/email.php
2. Find line 11: $config['smtp_pass'] = 'YOUR_APP_PASSWORD_HERE';
3. Replace YOUR_APP_PASSWORD_HERE with your 16-char password
4. Save the file
```

### Step 5: Update Controller
```
1. Open: application/controllers/index.php
2. Open: controller_email_methods.php (in project root)
3. Copy the 3 methods (send_quote_email, get_email_template, get_email_plain_text)
4. Paste them BEFORE your existing submit_quote_request() function
5. Replace your entire submit_quote_request() function with the new version
6. Save the file
```

---

## 🧪 Testing

### Test 1: PHPMailer Test Script
```
1. Open: test_email.php (in project root)
2. Line 32: Replace YOUR_APP_PASSWORD_HERE with your App Password
3. Visit: http://localhost/lineseiki.systems-test.com/test_email.php
4. You should see "✅ SUCCESS!" and receive a test email
```

### Test 2: Quote Request Form
```
1. Visit: http://localhost/lineseiki.systems-test.com/index/ps_serv_silicone
2. Scroll to "Request Quote" section
3. Fill in all fields
4. (Optional) Attach a file
5. Click "Request Quote"
6. Check Gmail for the email
```

---

## 📧 Email Features

Your automated emails will have:

### Design
- ✨ Professional HTML layout with Line Seiki branding
- 🎨 Blue gradient header matching your brand colors
- 📱 Mobile-responsive design
- 🔔 "NEW REQUEST" badge
- 💼 Clean, organized information cards

### Content
- 👤 Customer Name
- 📧 Email Address (with reply-to functionality)
- 📞 Contact Number
- 🏢 Company Name
- 📎 Attached File (if provided)
- 📅 Request Date & Time

### Technical
- HTML version (beautiful design)
- Plain text version (email client compatibility)
- Direct reply-to customer email
- File attachments supported
- UTF-8 encoding for international characters

---

## 🔧 Troubleshooting

### Email Not Sending?

**Check These:**
1. ✅ App Password is correct in `email.php`
2. ✅ PHPMailer files exist in `application/third_party/PHPMailer/`
3. ✅ 2-Step Verification is enabled in Google Account
4. ✅ Internet connection is active
5. ✅ Port 587 is not blocked by firewall

**View Logs:**
```
Check: application/logs/log-YYYY-MM-DD.php
Look for: "Email failed" or error messages
```

**Enable Debug Mode:**
```php
// Add this line in send_quote_email() before $mail->send()
$mail->SMTPDebug = 2;
$mail->Debugoutput = 'html';
```

---

## 🔒 Security Notes

### Protect Your App Password
- ❌ Never commit `email.php` to version control
- ❌ Never share your App Password
- ✅ Add to `.gitignore`: `application/config/email.php`
- ✅ Revoke App Password if compromised

### File Upload Security
The system includes:
- ✅ File type restrictions (CAD files, documents, images only)
- ✅ File size limit (10MB maximum)
- ✅ Encrypted filenames (prevents overwrites)
- ✅ Secure upload directory

---

## 📊 Database Table

The quote requests are saved to: `tbl_request_quote`

**Columns:**
- id (auto-increment)
- name
- email
- contact_number
- company_name
- file_name
- file_path
- status ('pending')
- created_at (timestamp)

---

## 🎨 Customization

### Change Email Recipient
Edit `application/controllers/index.php`:
```php
// Line in send_quote_email()
$mail->addAddress('traballojeffrey3@gmail.com', 'Jeffrey Traballo');

// Add more recipients:
$mail->addAddress('another@email.com', 'Name');
$mail->addCC('cc@email.com', 'CC Name');
```

### Customize Email Design
Edit `get_email_template()` function in controller:
- Change colors in `<style>` section
- Modify content structure
- Add your company logo

### Change Email Subject
Edit `send_quote_email()` function:
```php
$mail->Subject = 'New SMUC Quote Request from ' . $quote_data['company_name'];
```

---

## 📞 Support & Help

### If You're Stuck:

1. **Read**: `SMUC_EMAIL_SETUP_GUIDE.md` (detailed guide)
2. **Check**: `EMAIL_SETUP_CHECKLIST.md` (quick checklist)
3. **Test**: `test_email.php` (verify PHPMailer)
4. **Logs**: `application/logs/` (check for errors)

### Common Solutions:

| Problem | Solution |
|---------|----------|
| "Could not authenticate" | Re-generate App Password |
| "SMTP connect() failed" | Check firewall/internet |
| "Invalid address" | Verify email format |
| "File not found" | Check PHPMailer file paths |

---

## ✅ Success Checklist

- [ ] PHPMailer files downloaded and placed correctly
- [ ] Gmail App Password generated
- [ ] `email.php` updated with App Password
- [ ] Controller code added successfully
- [ ] Test script (`test_email.php`) runs successfully
- [ ] Quote request form sends email successfully
- [ ] Email received in Gmail inbox
- [ ] Can reply to customer email directly

---

## 🎉 You're All Set!

Once all steps are complete, your SMUC quote request system will:
- ✅ Collect customer information
- ✅ Save to database
- ✅ Send professional email notifications
- ✅ Include file attachments
- ✅ Allow direct customer communication

**Your customers will receive a confirmation message, and you'll be notified instantly via email!**

---

**Last Updated:** January 2025  
**Created For:** Line Seiki Asia Pacific - SMUC Page  
**Email:** traballojeffrey3@gmail.com
