# 📥 PHPMailer Installation Guide - Step by Step

## Option 1: Direct Download (Recommended)

### Step 1: Download PHPMailer
1. Click this link: https://github.com/PHPMailer/PHPMailer/archive/refs/tags/v6.9.1.zip
2. Save the ZIP file to your Downloads folder
3. Extract/Unzip the file

### Step 2: Locate the Files
After extracting, you'll see a folder named `PHPMailer-6.9.1`
Inside that folder, go to: `PHPMailer-6.9.1/src/`

You need these 3 files:
- ✅ PHPMailer.php
- ✅ SMTP.php  
- ✅ Exception.php

### Step 3: Create the Destination Folder
1. Open Windows Explorer
2. Navigate to: `C:\xampp\htdocs\lineseiki.systems-test.com\application\`
3. Create a new folder called: `third_party`
4. Inside `third_party`, create another folder called: `PHPMailer`

**Final path should be:**
```
C:\xampp\htdocs\lineseiki.systems-test.com\application\third_party\PHPMailer\
```

### Step 4: Copy the Files
Copy these 3 files from the extracted folder's `src` directory:
- PHPMailer.php
- SMTP.php
- Exception.php

Paste them into:
```
C:\xampp\htdocs\lineseiki.systems-test.com\application\third_party\PHPMailer\
```

### Step 5: Verify Installation
Your folder structure should look like this:
```
application/
└── third_party/
    └── PHPMailer/
        ├── PHPMailer.php
        ├── SMTP.php
        └── Exception.php
```

---

## Option 2: Alternative Download Link

If the above link doesn't work:

1. Go to: https://github.com/PHPMailer/PHPMailer/releases
2. Find the latest version (v6.9.1 or newer)
3. Click "Source code (zip)"
4. Follow Steps 2-5 above

---

## Option 3: Manual File Creation

If you can't download, I can provide the file contents and you can create them manually.
Let me know if you need this option.

---

## ✅ Verification

After copying the files, run this verification script:

1. Open: http://localhost/lineseiki.systems-test.com/verify_phpmailer.php
2. You should see ✅ checkmarks for all 3 files

---

## 🆘 Still Having Issues?

If you're still getting errors, check:
1. **Folder names are EXACTLY**: `third_party` and `PHPMailer` (case-sensitive on some systems)
2. **No extra folders**: Files should be directly in PHPMailer folder, not in a subfolder
3. **File permissions**: Make sure the files are readable

**Wrong Structure:**
```
❌ application/third_party/PHPMailer/src/PHPMailer.php
❌ application/third_party/phpmailer/PHPMailer.php
❌ application/Third_Party/PHPMailer/PHPMailer.php
```

**Correct Structure:**
```
✅ application/third_party/PHPMailer/PHPMailer.php
✅ application/third_party/PHPMailer/SMTP.php
✅ application/third_party/PHPMailer/Exception.php
```

---

## Next Steps

Once PHPMailer is installed correctly:
1. Update `application/config/email.php` with your Gmail App Password
2. Update `application/controllers/index.php` with the email methods
3. Test using `test_email.php`

---

**Need Help?** If you're still stuck, let me know and I can help troubleshoot!
