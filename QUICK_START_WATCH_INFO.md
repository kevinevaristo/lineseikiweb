# Quick Start Guide - Watch Info Tracking

## Installation (3 Steps)

### Step 1: Import Database Table
1. Open phpMyAdmin
2. Select database
3. Import → `database/add_tbl_watch_info.sql`
4. Click Go

### Step 2: Test
1. Visit: `http://localhost/lineseiki.systems-test.com/index/library`
2. Click any "Watch Now" button
3. Fill the form and submit
4. Video should open!

### Step 3: Verify
1. phpMyAdmin → `tbl_watch_info` table
2. Click Browse
3. See your test record!

---

## Quick Test SQL Queries

```sql
-- View all records
SELECT * FROM tbl_watch_info ORDER BY submitted_at DESC;

-- Count videos watched
SELECT COUNT(*) as total_videos FROM tbl_watch_info WHERE resource_type = 'video';

-- Count PDFs downloaded  
SELECT COUNT(*) as total_pdfs FROM tbl_watch_info WHERE resource_type = 'pdf';

-- Most popular videos
SELECT video_title, COUNT(*) as views 
FROM tbl_watch_info 
WHERE resource_type = 'video'
GROUP BY video_title 
ORDER BY views DESC 
LIMIT 5;
```

---

## What Was Changed

✅ **Model** - Added save methods
✅ **Controller** - Added 2 new endpoints
✅ **View** - AJAX form submission
✅ **Database** - New table created

---

## Support

Issues? Check:
1. Console errors (F12)
2. CodeIgniter logs
3. Database connection
4. Table exists

That's it! 🚀
