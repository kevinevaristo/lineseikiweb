# Visitor's Location Card - Quick Reference

## 🎯 What Was Implemented

A new "Visitor's Location" card was added to the admin dashboard (after "Device Types") that shows visitor countries based on IP address geolocation.

## 📍 Location in Dashboard

```
Dashboard Overview
├── Stats Cards (Total/Today/Unique/Last Update)
├── Visitor Analytics Chart
└── Additional Analytics Grid
    ├── Device Types Card
    ├── ✨ Visitor's Location Card (NEW!)
    ├── Top Browsers Card
    └── Top Pages Card
```

## 🔧 Technical Implementation

### Files Modified:

1. **`application/models/admin/dashboard_model.php`**
   - Added `get_location_from_ip()` - Calls IP-API service
   - Added `get_location_statistics()` - Aggregates country data
   - Added `get_city_statistics()` - City-level statistics
   - Updated `get_statistics_summary()` - Includes location data

2. **`application/views/admin/home_views.php`**
   - Added new location card HTML
   - Added `renderLocationStats()` JavaScript function
   - Updated `fetchAdditionalAnalytics()` to fetch location data

## 🌐 How It Works

```
User visits website
    ↓
IP address saved in tbl_website_visits
    ↓
Dashboard loads
    ↓
Query top 100 IPs from database
    ↓
For each IP: Call ip-api.com/json/{IP}
    ↓
Get: Country, City, Region
    ↓
Aggregate by country
    ↓
Display with flags and percentages
```

## 📊 What's Displayed

### Example Output:
```
🌍 Visitor's Location
------------------------
🇵🇭 Philippines    ▓▓▓▓▓▓▓▓░░ 45.2%
🇺🇸 United States  ▓▓▓▓▓░░░░░ 23.8%
🇯🇵 Japan          ▓▓▓░░░░░░░ 15.1%
🇸🇬 Singapore      ▓▓░░░░░░░░  8.4%
🇬🇧 United Kingdom ▓░░░░░░░░░  4.2%
```

## ⚡ API Service Used

**Service**: ip-api.com
- **Free**: No API key required
- **Rate Limit**: 45 requests/minute
- **Accuracy**: ~95% for countries
- **Response Time**: ~100-300ms per request

**Example API Call**:
```
GET http://ip-api.com/json/203.177.120.50

Response:
{
  "status": "success",
  "country": "Philippines",
  "countryCode": "PH",
  "city": "Manila",
  "regionName": "National Capital Region"
}
```

## 🔍 Database Query

```sql
-- Gets unique IP addresses with visit counts
SELECT ip_address, COUNT(*) as count 
FROM tbl_website_visits 
WHERE ip_address IS NOT NULL 
  AND ip_address != '' 
GROUP BY ip_address 
ORDER BY count DESC 
LIMIT 100;
```

## 🎨 Visual Features

- **Country Flags**: 18+ pre-mapped flag emojis
- **Progress Bars**: Color-coded (10 colors rotating)
- **Percentages**: Based on total visitor count
- **Responsive**: Truncates long country names
- **Loading State**: Shows spinner while fetching

## 🚀 Performance

| Metric | Value |
|--------|-------|
| IPs Processed | Top 100 |
| API Calls | ~100 per page load |
| Processing Time | ~10-15 seconds |
| Delay Between Calls | 100ms |
| Cache | Not implemented (future) |

## ⚙️ Configuration Options

### Change Number of Countries Shown
In `dashboard_model.php`, line with `get_location_statistics()`:
```php
// Show top 15 instead of 10
return array_slice($location_stats, 0, 15);
```

### Change Number of IPs Processed
```php
$this->db->limit(50); // Process only top 50 IPs
```

### Adjust API Delay
```php
usleep(200000); // 200ms delay (slower but safer)
```

## 🎯 Country Flags Supported

Full list of pre-mapped flags:
- 🇺🇸 United States
- 🇵🇭 Philippines
- 🇯🇵 Japan
- 🇨🇳 China
- 🇮🇳 India
- 🇬🇧 United Kingdom
- 🇩🇪 Germany
- 🇫🇷 France
- 🇨🇦 Canada
- 🇦🇺 Australia
- 🇸🇬 Singapore
- 🇲🇾 Malaysia
- 🇹🇭 Thailand
- 🇻🇳 Vietnam
- 🇮🇩 Indonesia
- 🇰🇷 South Korea
- 🇹🇼 Taiwan
- 🇭🇰 Hong Kong

*All other countries show: 🌍*

## 🧪 Testing

### 1. Quick Test
1. Open admin dashboard
2. Look for "Visitor's Location" card
3. Should show loading spinner → then country list

### 2. Verify Data
Open browser console (F12) and check for:
```javascript
// No errors like:
Error fetching additional analytics: ...
```

### 3. Database Check
```sql
-- Should return > 0
SELECT COUNT(*) FROM tbl_website_visits WHERE ip_address IS NOT NULL;
```

## ⚠️ Common Issues

### Issue: "No location data available"
**Fix**: 
- Check if `tbl_website_visits` has records
- Verify IPs are public (not 127.0.0.1)
- Test API: visit `http://ip-api.com/json/8.8.8.8`

### Issue: Slow loading
**Fix**:
- Reduce IP limit from 100 to 50
- Increase delay to 200ms
- Consider implementing cache

### Issue: Rate limit exceeded
**Fix**:
- Wait 1 minute
- Reduce number of IPs processed
- Implement hourly caching

## 📝 Code Locations

**Model methods**:
```
application/models/admin/dashboard_model.php
├── get_location_from_ip()        (line ~175)
├── get_location_statistics()     (line ~210)
├── get_city_statistics()         (line ~255)
└── get_total_countries()         (line ~300)
```

**View elements**:
```
application/views/admin/home_views.php
├── HTML Card                     (line ~110)
├── fetchAdditionalAnalytics()    (line ~235)
└── renderLocationStats()         (line ~315)
```

## 🔄 Data Flow Diagram

```
┌─────────────────┐
│  Page Loads     │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  JS Calls API   │ home/get_visitor_stats
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Controller     │ home::get_visitor_stats()
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Model Query    │ dashboard_model->get_statistics_summary()
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Get IPs from   │ SELECT ip_address FROM tbl_website_visits
│   Database      │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  For Each IP    │
│  Call API       │ http://ip-api.com/json/{IP}
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Aggregate      │ Group by country
│  Results        │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Return JSON    │ {location_stats: [...]}
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  JavaScript     │ renderLocationStats()
│  Renders Card   │
└─────────────────┘
```

## 💡 Quick Customization

### Add More Flags
Edit `home_views.php` → `renderLocationStats()`:
```javascript
const countryFlags = {
    'Your Country': '🏴',  // Add here
    // ... existing flags
};
```

### Change Colors
```javascript
const colors = [
    'bg-purple-500',  // Your custom color
    'bg-pink-500',
    // ...
];
```

### Make Card Wider
```html
<div class="lg:col-span-2 bg-white rounded-2xl...">
     ^^^^^^^^^^^^^^^^^
     Makes card span 2 columns
```

## ✅ Success Criteria

Card is working correctly when:
- ✅ Shows "Visitor's Location" header with globe icon
- ✅ Displays country names with flag emojis
- ✅ Shows colored progress bars
- ✅ Displays percentages next to each country
- ✅ No console errors in browser
- ✅ Loads within 15 seconds
- ✅ Shows "No location data available" if no visits

## 🎓 For Developers

### To Debug API Calls
Add to `dashboard_model.php` → `get_location_from_ip()`:
```php
log_message('debug', "IP: $ip_address, Location: " . json_encode($data));
```

### To Test Single IP
Create test file `test_ip_location.php`:
```php
<?php
require_once 'application/models/admin/dashboard_model.php';
$model = new Dashboard_model();
$result = $model->get_location_from_ip('8.8.8.8');
var_dump($result);
```

### To Cache Results
Add to `dashboard_model.php`:
```php
$cache_key = 'location_' . md5($ip_address);
$cached = $this->cache->get($cache_key);
if ($cached) return $cached;
// ... API call
$this->cache->save($cache_key, $location, 86400); // 24h
```
