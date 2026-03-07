# 🚨 Quick Fix: PHPMailer Not Found Error

## Your Error:
```
Warning: require_once(application/third_party/PHPMailer/PHPMailer.php): 
Failed to open stream: No such file or directory
```

## ✅ Quick Solution (5 Minutes)

### Step 1: Download PHPMailer (2 minutes)
**Click this direct download link:**
👉 https://github.com/PHPMailer/PHPMailer/archive/refs/tags/v6.9.1.zip

This will download `PHPMailer-6.9.1.zip` to your Downloads folder.

### Step 2: Extract the ZIP (1 minute)
1. Right-click `PHPMailer-6.9.1.zip` in your Downloads
2. Click "Extract All..."
3. Extract to your Downloads folder

### Step 3: Create Folders (1 minute)
Open File Explorer and navigate to:
```
C:\xampp\htdocs\lineseiki.systems-test.com\application\
```

Create these folders (if they don't exist):
1. Right-click → New → Folder → Name it: `third_party`
2. Open the `third_party` folder
3. Right-click → New → Folder → Name it: `PHPMailer`

**Final path:**
```
C:\xampp\htdocs\lineseiki.systems-test.com\application\third_party\PHPMailer\
```

### Step 4: Copy Files (1 minute)
1. Go to your Downloads folder
2. Open: `PHPMailer-6.9.1` folder
3. Open: `src` folder
4. You'll see many files. **Copy ONLY these 3 files:**
   - `PHPMailer.php`
   - `SMTP.php`
   - `Exception.php`

5. Paste them into:
```
C:\xampp\htdocs\lineseiki.systems-test.com\application\third_party\PHPMailer\
```

### Step 5: Verify Installation (30 seconds)
Open your browser and go to:
```
http://localhost/lineseiki.systems-test.com/verify_phpmailer.php
```

You should see ✅ checkmarks for all 3 files.

---

## 🎯 What Your Folder Should Look Like

```
C:\xampp\htdocs\lineseiki.systems-test.com\
└── application\
    └── third_party\          ← Create this folder
        └── PHPMailer\        ← Create this folder
            ├── PHPMailer.php ← Copy this file
            ├── SMTP.php      ← Copy this file
            └── Exception.php ← Copy this file
```

---

## ⚠️ Common Mistakes to Avoid

❌ **WRONG:** Copying the entire folder
```
application\third_party\PHPMailer-6.9.1\src\PHPMailer.php  ← WRONG!
```

✅ **CORRECT:** Copy only the 3 files from the src folder
```
application\third_party\PHPMailer\PHPMailer.php  ← CORRECT!
```

---

❌ **WRONG:** Wrong folder names (case matters sometimes)
```
application\Third_Party\PHPMailer\
application\third_party\phpmailer\
application\third_party\PHPMailer\src\
```

✅ **CORRECT:** Exact folder names
```
application\third_party\PHPMailer\
```

---

## 🔍 Troubleshooting

### Still getting the error?

**Check #1: Folder names are correct**
Run the verification script:
```
http://localhost/lineseiki.systems-test.com/verify_phpmailer.php
```

**Check #2: Files are in the right place**
Open File Explorer and verify this exact path exists:
```
C:\xampp\htdocs\lineseiki.systems-test.com\application\third_party\PHPMailer\PHPMailer.php
```

**Check #3: You copied from the 'src' folder**
Inside the downloaded ZIP, files are in: `PHPMailer-6.9.1/src/`
NOT in the root folder!

---

## 📞 Still Need Help?

If you're still stuck:

1. Run `verify_phpmailer.php` and take a screenshot
2. Let me know which files are showing ❌
3. I'll help you troubleshoot

---

## ✅ Next Steps

Once PHPMailer is installed (all ✅ checkmarks):

1. **Update email config:**
   - Open: `application/config/email.php`
   - Add your Gmail App Password

2. **Update controller:**
   - Open: `application/controllers/index.php`
   - Add the email methods from `controller_email_methods.php`

3. **Test:**
   - Run: `test_email.php`
   - Or submit a quote request form

---

**Download Link Again (Just in Case):**
https://github.com/PHPMailer/PHPMailer/archive/refs/tags/v6.9.1.zip

**Good luck! 🎉**
