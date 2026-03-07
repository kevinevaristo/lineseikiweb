# 🚀 Quick Fix for cPanel Email Issue

## Your Situation:
✅ Works on local (XAMPP) - Data saves AND email sends  
❌ Works on cPanel - Data saves but email DOESN'T send

## 🎯 The Solution (5 Minutes)

### Step 1: Update Your Controller (2 minutes)

Open: `application/controllers/index.php`

**Find the `send_quote_email()` method and REPLACE IT with the version from:**
`controller_cpanel_email.php`

**Key Changes:**
```php
// OLD (PHPMailer - doesn't work on cPanel)
require_once APPPATH . 'third_party/PHPMailer/PHPMailer.php';
$mail = new \PHPMailer\PHPMailer\PHPMailer(true);

// NEW (CodeIgniter Email - works on cPanel)
$this->load->library('email');
```

---

### Step 2: Update the FROM Email (1 minute)

In the new `send_quote_email()` method, find this line:

```php
$from_email = $is_local ? 'traballojeffrey3@gmail.com' : 'noreply@lineseiki.systems-test.com';
```

**Change** `noreply@lineseiki.systems-test.com` **to your actual domain email.**

**Examples:**
- If your domain is `lineseiki.com` → use `noreply@lineseiki.com`
- If your domain is `yourdomain.com` → use `noreply@yourdomain.com`

---

### Step 3: (Optional) Create Domain Email in cPanel (2 minutes)

This step is optional but recommended:

1. Login to cPanel
2. Go to **"Email Accounts"**
3. Click **"Create"**
4. Create email: `noreply@yourdomain.com`
5. Set any password (you won't use it)

---

## ✅ Why This Works

| Environment | Method | Why |
|------------|--------|-----|
| **Local (XAMPP)** | Gmail SMTP | Your internet can access Gmail servers |
| **Live (cPanel)** | PHP mail() | cPanel's built-in mail server (no SMTP needed) |

---

## 🧪 Test It

### On Local (XAMPP):
1. Submit quote request
2. Should save to database ✅
3. Should send email via Gmail ✅

### On Live (cPanel):
1. Upload updated controller
2. Submit quote request  
3. Should save to database ✅
4. Should send email via cPanel ✅

---

## 📋 Complete Code to Copy

Open `controller_cpanel_email.php` and copy the entire `send_quote_email()` method.

**Important notes in that file:**
1. Line 13: Add your Gmail App Password (for local)
2. Line 38: Change domain email (for live)

---

## 🔍 Still Not Working?

### Check cPanel Email Settings:

**1. Email Deliverability**
- Login to cPanel
- Go to "Email Deliverability"
- All domains should show green ✅
- If red ❌, click "Manage" and follow instructions

**2. Email Routing**
- Go to "Email Routing"
- Should be set to "Local Mail Exchanger"

**3. Track Delivery**
- Go to "Track Delivery"
- Send a test email
- Check if it's being delivered

---

## 📧 Alternative: Use Domain Email for SMTP

If PHP mail() doesn't work, you can use your domain's SMTP:

```php
// In send_quote_email(), for live server use:
$config = array(
    'protocol' => 'smtp',
    'smtp_host' => 'localhost',  // or 'mail.yourdomain.com'
    'smtp_port' => 587,
    'smtp_user' => 'noreply@yourdomain.com',
    'smtp_pass' => 'the_password_you_set',
    'smtp_crypto' => 'tls',
    'mailtype' => 'html',
    'charset' => 'utf-8',
    'newline' => "\r\n",
    'wordwrap' => TRUE
);
```

---

## 🎯 Summary

**What you're doing:**
1. Keep PHPMailer for local Gmail testing
2. Switch to CodeIgniter's email library for cPanel
3. Code automatically detects which environment

**Files to update:**
- ✅ `application/controllers/index.php` - Update send_quote_email() method

**No other changes needed!**

---

## 💡 Pro Tip

Add this to your controller to see which method is being used:

```php
// In send_quote_email(), after $is_local check:
if ($is_local) {
    log_message('debug', '📧 Using Gmail SMTP (Local)');
} else {
    log_message('debug', '📧 Using cPanel mail() (Live)');
}
```

Then check logs: `application/logs/log-YYYY-MM-DD.php`

---

**Ready to fix it? Copy the code from `controller_cpanel_email.php`!** 🚀
