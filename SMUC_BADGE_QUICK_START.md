# SMUC Notification Badge - Quick Start Guide

## ✅ Implementation Complete!

A **notification badge** has been added to your admin sidebar that shows the count of pending project submissions from the SMUC page.

---

## 🎯 Where to Find It

Look at your admin sidebar navigation, under "Website Pages" section:

```
📋 Dashboard
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Website Pages
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

🏠 Home
👥 About Us  
📦 Products
🧪 Simulation Analysis
🎓 SMUC Page  [🔴 3]  ← HERE! Red badge shows pending count
🌐 IOT Solution
📰 News & Events
📚 Library
📞 Contact Us
```

---

## 🔴 Badge Behavior

### When Badge Appears
- ✅ Shows when there are **NEW** project submissions
- ✅ Only counts submissions with status = "**pending**"
- ✅ Updates automatically on page refresh

### Badge Features
- 🔴 **Red pulsing badge** - Gets attention
- 🔢 **Shows exact count** - Up to 99 (displays "99+" if more)
- 💭 **Tooltip on hover** - "3 pending quote requests"
- 📍 **Positioned right** - On the right side of menu item

### When Badge Disappears
- ❌ All submissions have been reviewed/contacted/completed
- ❌ Count reaches zero
- ❌ Status changes from "pending" to anything else

---

## 📊 How It Works

### Step-by-Step Flow

**1. Customer submits quote request on SMUC page**
   - Fills out form with name, email, company, contact
   - Uploads CAD/design file (optional)
   - Clicks "Request Quote"
   - Entry created in database with status = "pending"

**2. Badge appears in admin sidebar**
   - Count increases by 1
   - Red badge shows on "SMUC Page" menu item
   - Badge pulses to draw attention

**3. Admin clicks on SMUC Page**
   - Sees full table of quote requests
   - Can view details, download files, add notes

**4. Admin updates status**
   - Changes from "pending" to "reviewed"
   - Or changes to "contacted" or "completed"

**5. Badge count decreases**
   - Reflects only "pending" requests
   - Disappears when count = 0

---

## 🗂️ Status Management

The quote request system uses 4 statuses:

| Status | Badge Count | Meaning |
|--------|------------|---------|
| **pending** | ✅ YES | New, unreviewed submission |
| **reviewed** | ❌ NO | Admin has viewed it |
| **contacted** | ❌ NO | Admin contacted customer |
| **completed** | ❌ NO | Request fulfilled |

Only **"pending"** submissions contribute to the badge count.

---

## 🧪 Testing Instructions

### Test 1: Create New Submission

1. Go to your SMUC website page (public side)
2. Scroll to "Project Submission" section
3. Fill out the quote request form:
   - Name: Test User
   - Email: test@example.com
   - Company: Test Company
   - Contact: 123-456-7890
   - Upload a test file (optional)
4. Click "Request Quote"
5. **Check admin sidebar** → Badge should show "1"

### Test 2: Review Submission

1. Click on "🎓 SMUC Page" in admin sidebar
2. Scroll to the "Project Submission" table
3. Find the test submission
4. Click "View" to see details
5. Change status dropdown from "pending" to "reviewed"
6. Refresh admin page
7. **Check sidebar** → Badge count should decrease

### Test 3: Multiple Submissions

1. Create 3 different quote requests
2. **Check sidebar** → Badge should show "3"
3. Review 1 submission (change to "reviewed")
4. **Check sidebar** → Badge should show "2"
5. Review all submissions
6. **Check sidebar** → Badge should disappear

---

## 🎨 Visual Design

### Badge Style
```css
- Background: Red gradient (#ef4444 → #dc2626)
- Text: White, bold, 10px
- Size: 18px height, auto width
- Shape: Rounded pill (10px radius)
- Animation: Gentle pulse (scale 1.0 → 1.1)
- Shadow: Subtle shadow for depth
```

### Animation
```
0% ───► 50% ───► 100%
Scale: 1.0 → 1.1 → 1.0
Repeats every 2 seconds
```

---

## 📁 Files Modified

**Single File Changed:**
- ✅ `application/views/admin/header.php`

**What was added:**
1. CSS for badge styling and animation
2. Database query to count pending requests
3. Badge display logic (only on SMUC Page)
4. Conditional rendering (only when count > 0)

---

## 🔧 Customization Options

### Change Badge Color

Edit in `application/views/admin/header.php`:

```css
.notification-badge {
    /* Current: Red */
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    
    /* Alternative: Blue */
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    
    /* Alternative: Green */
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    
    /* Alternative: Orange */
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
}
```

### Disable Animation

```css
.notification-badge {
    /* Remove this line: */
    animation: pulse-badge 2s infinite;
}
```

### Change Position

```css
.notification-badge {
    /* Current: Right side */
    right: 8px;
    
    /* Alternative: Left side */
    left: 8px;
    right: auto;
}
```

---

## 🐛 Troubleshooting

### Badge not showing?

**✅ Check:**
1. Are there any pending submissions in database?
   - Query: `SELECT COUNT(*) FROM tbl_request_quote WHERE status = 'pending'`
2. Is database connection working?
   - Check `application/config/database.php`
3. Clear browser cache
   - Hard refresh: Ctrl+Shift+R (Windows) or Cmd+Shift+R (Mac)

### Count seems wrong?

**✅ Solutions:**
1. Check database directly:
   ```sql
   SELECT * FROM tbl_request_quote WHERE status = 'pending';
   ```
2. Verify status values are exactly 'pending' (case-sensitive)
3. Refresh admin page to reload count

### Badge looks broken?

**✅ Check:**
1. Browser compatibility (use Chrome, Firefox, Safari, or Edge)
2. CSS loaded properly (check browser console for errors)
3. Clear cache and hard refresh

---

## 📞 Support

**Files to check:**
- `application/views/admin/header.php` - Badge implementation
- `application/views/admin/smuc_page.php` - Quote requests table
- `application/models/admin/Quote_requests_model.php` - Database operations
- `database/lineseiki_db.sql` - Table structure

**Need help?** Check the detailed implementation guide: `SMUC_NOTIFICATION_BADGE_IMPLEMENTATION.md`

---

## ✨ Quick Reference

| Feature | Details |
|---------|---------|
| **Location** | Admin sidebar → "SMUC Page" menu item |
| **Trigger** | New quote request submitted on website |
| **Count** | Only "pending" status submissions |
| **Appearance** | Red pulsing badge with white text |
| **Update** | Auto-updates on page refresh |
| **Maximum** | Shows "99+" if count > 99 |

---

**🎉 Implementation Complete!**

The notification badge is now live and will help you stay on top of new project submission requests from the SMUC page.
