# News & Events Extension - Dynamic Database Integration

## 📋 Overview
Updated the news_events_extension page to dynamically pull data from the `tbl_events` database table instead of using hardcoded static content.

## ✅ Changes Made

### 1. **Controller Update** (`application/controllers/index.php`)
**Modified Method:** `news_events_extension()`

**Changes:**
- Added parameter `$id` to accept event ID from URL
- Added redirect to news_event page if no ID is provided
- Retrieves event data from database using `event_model->get_event_by_id($id)`
- Shows 404 error if event is not found
- Passes event data to the view

**Code:**
```php
function news_events_extension($id = null)
{
  // If no ID provided, redirect to news_event page
  if (!$id) {
    redirect('index/news_event');
    return;
  }
  
  // Get specific event by ID
  $data['event'] = $this->event_model->get_event_by_id($id);
  
  // If event not found, show 404
  if (!$data['event']) {
    show_404();
    return;
  }
  
  $this->load->view('web/news_events_extension', $data);
}
```

### 2. **View Update** (`application/views/web/news_events_extension.php`)
**Completely rewritten to use dynamic data from database**

**Key Features:**
- **Dynamic Page Title:** Uses event title from database
- **Badge Display:** Shows custom badge_text or category name
- **Event Date:** Formatted from event_date field
- **Event Title:** From database title field
- **Meta Description:** Displays in detail box if available
- **Featured Image:** Loads from `uploads/events/` directory with fallback to placeholder
- **Content Area:** Renders full HTML content from database
- **Back Button:** Returns to news listing page

**Database Fields Used:**
- `title` - Event title
- `badge_text` - Custom badge (fallback to category)
- `category` - Event category (news, events, product, webinars)
- `event_date` - Event date
- `meta_description` - Short description
- `image` - Event image filename
- `content` - Full HTML content

### 3. **URL Structure**
**Access Event Detail Page:**
```
http://your-domain/index/news_events_extension/{event_id}
```

**Examples:**
- `http://localhost/lineseiki/index/news_events_extension/1`
- `http://localhost/lineseiki/index/news_events_extension/7`

### 4. **Database Table Structure** (`tbl_events`)
```sql
CREATE TABLE `tbl_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `badge_text` varchar(50) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `image` varchar(255) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;
```

## 🔗 Integration Points

### News Event Listing Page (`newsevent.php`)
Already correctly links to detail page:
```php
<a href="<?= base_url('index/news_events_extension/' . $event['id']) ?>" class="news-read-more">
    Learn More <i class="fas fa-arrow-right"></i>
</a>
```

## 📁 File Upload Directory
**Important:** Event images should be uploaded to:
```
uploads/events/
```

**Current Status:** This directory needs to be created. 

**To Create:**
1. Navigate to your website root
2. Create folder: `uploads/events/`
3. Set permissions: `chmod 755 uploads/events/`

## 🎨 Features

### Responsive Design
- Mobile-friendly layout
- Grid system for image and description
- Fade-in animations
- Smooth scrolling

### Fallback Handling
- **No Image:** Shows placeholder with event title
- **No Meta Description:** Hides description box
- **No Badge Text:** Uses category name as badge
- **No Content:** Content section is hidden

### Visual Elements
- Professional styling matching site design
- Blue gradient color scheme (#0F467B to #17A2DC)
- Clean typography with Inter font
- Smooth hover effects and transitions

## 🚀 How to Use

### For Administrators:
1. Create/edit events in the admin panel
2. Fill in all relevant fields:
   - Title
   - Content (full HTML description)
   - Meta Description (short summary)
   - Category
   - Event Date
   - Badge Text (optional)
   - Upload Image
3. Set status to 'active'
4. Event will automatically appear in listings with proper detail page link

### For Users:
1. Browse news/events on the listing page
2. Click "Learn More" on any event
3. View full event details with all information
4. Click "Back to News" to return to listing

## 📝 Sample Event Entry

```php
INSERT INTO tbl_events (
  title, 
  content, 
  meta_description, 
  category, 
  event_date, 
  is_featured, 
  badge_text, 
  status, 
  image
) VALUES (
  'Line Seiki to exhibit at JAPAN PACK 2025',
  '<p>Join us at JAPAN PACK 2025 where we will showcase our latest measuring instruments, sensors, and IoT solutions.</p>
   <h3>Exhibition Details</h3>
   <ul>
     <li>Latest product demonstrations</li>
     <li>Expert consultations</li>
     <li>Live IoT solution presentations</li>
   </ul>',
  'Line Seiki Co., Ltd. will be exhibiting at JAPAN PACK 2025, Tokyo Japan.',
  'events',
  '2025-10-07',
  1,
  'Notice',
  'active',
  'japan_pack_2025.jpg'
);
```

## ⚠️ Important Notes

1. **Image Path:** Make sure event images are in `uploads/events/` folder
2. **Permissions:** Ensure proper folder permissions for uploads
3. **Active Status:** Only events with `status='active'` and `deleted_at IS NULL` are shown
4. **URL Routing:** Event ID must be numeric and valid
5. **Error Handling:** Invalid IDs show 404 error page

## 🔧 Testing Checklist

- [ ] Create test event in database
- [ ] Upload test image to `uploads/events/`
- [ ] Verify event appears in listing page
- [ ] Click "Learn More" link
- [ ] Confirm all fields display correctly
- [ ] Test back button functionality
- [ ] Test with missing image (fallback)
- [ ] Test with missing meta_description
- [ ] Test 404 error for invalid ID

## 📞 Support
For questions or issues, contact the development team.

---
**Last Updated:** January 19, 2026
**Version:** 1.0
