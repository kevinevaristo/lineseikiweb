# 📧 Paano Makita ang Emails - Complete Guide

## 🎯 Quick Answer

Ang emails ay papunta sa: **traballojeffrey3@gmail.com**

Dapat mo i-check dito:
1. Gmail Inbox
2. Gmail Spam/Junk folder
3. cPanel Track Delivery (para malaman kung nag-send)

---

## 📬 Paraan 1: Check Gmail (Main Destination)

### Step-by-step:
1. Open browser, go to: https://gmail.com
2. Login gamit ang:
   - **Email:** traballojeffrey3@gmail.com
   - **Password:** (your Gmail password)

3. **Check Inbox:**
   - Hanapin ang email na may subject: "New SMUC Quote Request from [Company Name]"

4. **Check Spam Folder:**
   - Click "Spam" sa left sidebar
   - Baka nandun ang email (lalo na first time)

5. **Kung nandun sa Spam:**
   - Click ang email
   - Click "Not Spam" button
   - Next emails na, pupunta na sa Inbox

---

## 🖥️ Paraan 2: Check via cPanel Webmail

Kung gusto mo makita yung sent emails from your server:

### Step A: Access Webmail
1. Login sa cPanel (usually: https://yourdomain.com:2083)
2. Scroll down, hanapin **"Email Accounts"**
3. Sa row ng email mo (noreply@yourdomain.com), click **"Check Email"** or **"Access Webmail"**
4. Lalabas ang 3 options:
   - **RoundCube** (recommended - modern interface)
   - **Horde** (classic)
   - **SquirrelMail** (simple)
5. Choose **RoundCube**

### Step B: Navigate Webmail
1. Click **"Sent"** folder - makikita mo yung mga na-send
2. Click **"Inbox"** - kung may reply ang customer
3. Search bar - pwede mo i-search ang recipient

---

## 🔍 Paraan 3: Track Delivery sa cPanel

Para malaman mo kung successfully na-send:

### Step-by-step:
1. Login sa cPanel
2. Sa search box sa top, i-type: **"Track Delivery"**
3. Click **"Track Delivery"**
4. Sa form:
   - **Recipient:** traballojeffrey3@gmail.com
   - **Sender:** (leave blank or noreply@yourdomain.com)
   - **Time Range:** Last 24 hours
5. Click **"Run Report"**

### Results meaning:
- ✅ **"delivered"** - Success! Email delivered
- ❌ **"failed"** - May problema, may error message
- ⏳ **"deferred"** - Pending, retry later
- 📤 **No results** - Hindi nag-send talaga

---

## 🧪 Paraan 4: Test Kung Gumagana (RECOMMENDED!)

I-upload ko sa'yo yung test file. Gawin mo to:

### Step 1: Upload Test File
1. Upload ang file na `test_cpanel_email.php` sa root ng website mo
2. Access sa browser:
   ```
   https://yourdomain.com/test_cpanel_email.php
   ```

### Step 2: Check Results
- ✅ Kung nakita mo "EMAIL SENT SUCCESSFULLY" - gumagana!
- ❌ Kung may error - may instructions dun kung paano ayusin

### Step 3: Check Gmail
- Within 1-5 minutes, dapat may email ka na
- Subject: "Test Email from cPanel - [date time]"

---

## 📊 Paraan 5: Check Logs

Para sa advanced troubleshooting:

### A. cPanel Email Delivery Report
1. cPanel → **"Email Deliverability"**
2. Check kung GREEN ang domain mo
3. Kung RED, click "Manage" at ayusin ang issues

### B. Application Logs
1. Sa server mo, check:
   ```
   application/logs/log-2025-01-17.php
   ```
2. Hanapin ang lines na may:
   - "Email sent successfully" ✅
   - "Email failed" ❌

### C. cPanel Mail Queue
1. cPanel → **"Mail Queue Manager"**
2. Makikita mo dito kung may stuck na emails
3. Pwede mo i-delete or retry

---

## ❓ Common Questions

### Q1: Bakit walang email sa Gmail?
**Possible reasons:**
1. Nasa Spam folder
2. Hindi actually nag-send (check Track Delivery)
3. Email deliverability issue sa cPanel
4. Wrong email address sa code

### Q2: How long bago dumating ang email?
**Normal delivery time:**
- cPanel to Gmail: **Instant to 5 minutes**
- Kung lampas 10 minutes: May problema na

### Q3: Paano ko ma-setup na hindi mapunta sa Spam?
**Solutions:**
1. **SPF Record** - Add sa cPanel DNS
2. **DKIM** - Enable sa cPanel Email Authentication
3. **DMARC** - Add DNS record
4. **Use domain email** - Not Gmail

---

## 🎯 Quick Test Checklist

Sundin mo to in order:

- [ ] **Test 1:** I-submit ang quote request form
- [ ] **Test 2:** Check application logs (may "Email sent"?)
- [ ] **Test 3:** Check cPanel Track Delivery (delivered ba?)
- [ ] **Test 4:** Check Gmail Inbox
- [ ] **Test 5:** Check Gmail Spam
- [ ] **Test 6:** Run test_cpanel_email.php

Kung may isa dito na may ✅, alam mo na yung problema!

---

## 🔧 Troubleshooting Guide

### Problem: No email anywhere
**Solution:**
1. Check Track Delivery - nag-send ba?
2. Check Email Deliverability - green ba?
3. Run test_cpanel_email.php

### Problem: Email sa Spam
**Solution:**
1. Mark as "Not Spam" sa Gmail
2. Add SPF/DKIM sa cPanel
3. Use domain email instead of Gmail

### Problem: "Email sent" pero wala pa rin
**Solution:**
1. Wait 5-10 minutes
2. Check all Gmail folders (Promotions, Social, etc.)
3. Check if traballojeffrey3@gmail.com is correct

---

## 📞 Need Help?

Kung wala pa rin after all these steps:

1. **Send me:**
   - Screenshot ng Track Delivery results
   - Screenshot ng Email Deliverability
   - Error from test_cpanel_email.php

2. **Check these:**
   - Email address correct ba? (traballojeffrey3@gmail.com)
   - cPanel email account created ba?
   - Internet working ba?

---

## ✅ Success Checklist

Kung nakita mo ang email, dapat:
- ✅ May subject: "New SMUC Quote Request from..."
- ✅ May lahat ng customer details
- ✅ May file attachment (kung may upload)
- ✅ Professional HTML format with colors
- ✅ Pwede ka mag-reply directly to customer

---

**TL;DR:** Check mo sa Gmail (traballojeffrey3@gmail.com) yung Inbox at Spam folder. Kung wala, run yung test_cpanel_email.php para malaman kung gumagana ang email sa server!

**Test file location:** `test_cpanel_email.php` - Upload mo yan sa website root! 🚀
