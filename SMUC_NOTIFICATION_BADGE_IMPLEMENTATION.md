# SMUC Notification Badge Implementation

## Overview
Added a notification badge to the admin header navigation that displays the count of **pending project submissions** from the SMUC page's quote request form.

## What Was Implemented

### 1. Database Query
The header now queries the `tbl_request_quote` table to count submissions with `status = 'pending'`:

```php
$this->load->database();
$pending_count = $this->db->where('status', 'pending')
                          ->from('tbl_request_quote')
                          ->count_all_results();
```

### 2. Visual Badge Component
- **Location**: SMUC Page menu item in the admin sidebar
- **Appearance**: 
  - Red gradient badge with white text
  - Positioned on the right side of the menu item
  - Pulsing animation to draw attention
  - Shows count up to 99, then displays "99+"
  - Tooltip shows exact count on hover

### 3. Styling Features
```css
.notification-badge {
    - Gradient red background (#ef4444 to #dc2626)
    - Small, rounded badge (18px height)
    - Pulsing animation (scales between 100% and 110%)
    - Box shadow for depth
    - Always visible when count > 0
}
```

## File Modified
- **`application/views/admin/header.php`**
  - Added CSS for notification badge styling
  - Added database query to count pending submissions
  - Added conditional badge display logic
  - Badge only shows when `pending_count > 0`

## How It Works

### Display Logic
```php
$show_badge = ($function_name == 'smuc_page' && $pending_count > 0);
```

1. The badge only appears on the "SMUC Page" menu item
2. Only displays when there are pending submissions (status = 'pending')
3. Updates automatically on each page load
4. Shows exact count, or "99+" if count exceeds 99

### User Experience
- **Admin sees the badge**: Knows there are pending quote requests to review
- **Clicks on SMUC Page**: Goes to the page with the quote requests table
- **Reviews and updates status**: Once status changes from 'pending', count decreases
- **Badge disappears**: When all requests are reviewed/contacted/completed

## Database Table Reference
**Table**: `tbl_request_quote`

**Relevant Columns**:
- `id` - Primary key
- `name` - Customer name
- `email` - Customer email
- `company_name` - Company name
- `contact_number` - Phone number
- `file_name` - Uploaded file name
- `file_path` - File storage path
- `status` - ENUM('pending', 'reviewed', 'contacted', 'completed')
- `notes` - Internal notes
- `created_at` - Submission timestamp
- `updated_at` - Last update timestamp

## Status Values
- **pending** - New submission (counts toward badge)
- **reviewed** - Admin has viewed the request
- **contacted** - Admin has contacted the customer
- **completed** - Request is fulfilled

## Testing
1. Submit a new quote request from the SMUC page on the website
2. Check admin sidebar - badge should appear on "SMUC Page" with count "1"
3. Click on SMUC Page to view the request
4. Change status from "pending" to "reviewed"
5. Refresh admin - badge count should decrease

## Future Enhancements
Consider adding:
1. **Real-time updates**: Use AJAX to update count without page refresh
2. **Sound notification**: Play sound when new submission arrives
3. **Email notifications**: Send email to admin on new submissions
4. **Desktop notifications**: Browser push notifications for new requests
5. **Badge on other pages**: Show total unread count in header
6. **Color coding**: Different colors for different priority levels

## Visual Preview
```
📋 Dashboard
━━━━━━━━━━━━━━━
🏠 Home
👥 About Us
📦 Products
🧪 Simulation Analysis
🎓 SMUC Page [3]  ← Red pulsing badge
🌐 IOT Solution
📰 News & Events
📚 Library
📞 Contact Us
```

## Browser Compatibility
- Works on all modern browsers (Chrome, Firefox, Safari, Edge)
- CSS animations supported
- Responsive design maintained
- No JavaScript dependencies

## Performance
- Minimal database query (simple COUNT)
- Query runs once per page load
- No impact on page load speed
- Cached by database engine

## Maintenance
- **Update badge logic**: Modify condition in header.php
- **Change badge style**: Update CSS in header.php `<style>` section
- **Add to other pages**: Copy badge logic and adjust `$function_name` check
- **Modify status logic**: Update WHERE clause in database query

## Notes
- Badge auto-hides when count is 0
- Count is fetched fresh on every page load
- Works with existing Quote_requests_model.php
- No changes needed to database structure
- Fully integrated with existing SMUC page functionality
