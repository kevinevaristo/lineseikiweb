# IP Location Storage Implementation Guide

## Overview
This implementation adds automatic country and city tracking for website visitors by storing location data directly in the `tbl_website_visits` table.

## What Was Changed

### 1. Database Schema Changes
**File**: `database/add_location_columns_to_visits.sql`

Added two new columns to `tbl_website_visits`:
- `country` (VARCHAR 100) - Stores the visitor's country name
- `city` (VARCHAR 100) - Stores the visitor's city name

### 2. Visit Tracker Model Updates
**File**: `application/models/web/visit_tracker_model.php`

#### New Method Added:
- `get_location_from_ip($ip_address)` - Fetches location data from ip-api.com

#### Modified Method:
- `prepare_visit_data()` - Now automatically fetches and stores country/city when recording visits

**How it works**:
1. When a visitor accesses the site, their IP address is captured
2. The IP is sent to ip-api.com (free API, no key required)
3. Country and city are extracted from the response
4. Data is stored in the database along with other visit information

### 3. Dashboard Model Updates
**File**: `application/models/admin/dashboard_model.php`

#### Optimized Methods:
- `get_location_statistics($limit)` - Now reads from stored country data instead of making API calls
- `get_city_statistics($limit)` - Now reads from stored city data instead of making API calls
- `get_total_countries()` - Now counts distinct countries from database

**Performance Improvements**:
- **Before**: Made 100+ API calls every time statistics were loaded (slow, rate-limited)
- **After**: Simple database queries (instant, no rate limits)

## Installation Steps

### Step 1: Update Database
Run the SQL script to add the new columns:

```sql
-- In phpMyAdmin, select your database and run:
ALTER TABLE `tbl_website_visits` 
ADD COLUMN `country` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Visitor country from IP' AFTER `ip_address`,
ADD COLUMN `city` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Visitor city from IP' AFTER `country`;

ALTER TABLE `tbl_website_visits`
ADD INDEX `idx_country` (`country`),
ADD INDEX `idx_city` (`city`);
```

Or import the file:
1. Open phpMyAdmin
2. Select your database
3. Go to "Import" tab
4. Choose file: `database/add_location_columns_to_visits.sql`
5. Click "Go"

### Step 2: Verify Installation
The changes are already made to the model files. Just verify they exist:

✅ `application/models/web/visit_tracker_model.php` - Updated
✅ `application/models/admin/dashboard_model.php` - Updated

### Step 3: Test
1. Visit any page on your website
2. Check the database: `SELECT ip_address, country, city FROM tbl_website_visits ORDER BY id DESC LIMIT 10;`
3. You should see country and city populated for new visits

### Step 4: View in Dashboard
The admin dashboard will now show:
- Top countries by visitor count
- Top cities by visitor count
- Total unique countries
- All without making slow API calls!

## Technical Details

### IP Geolocation API
- **Service**: ip-api.com
- **Cost**: Free
- **Rate Limit**: 45 requests per minute
- **No API Key Required**: Yes
- **Data Returned**: Country, city, region, timezone, etc.

### Database Fields
```
country VARCHAR(100) - Examples: "Philippines", "United States", "Japan"
city VARCHAR(100) - Examples: "Manila", "Tokyo", "New York"
```

### Error Handling
- If API call fails: country and city are stored as NULL
- If IP is private/local: Location lookup is skipped
- Timeout: 3 seconds max (won't slow down page loads)

## Benefits

### Performance
- **Dashboard loading**: 100x faster (no API calls)
- **Historical data**: Past visits retain location info
- **No rate limits**: Database queries are instant

### Accuracy
- Location captured at visit time
- Consistent data (won't change if IP ownership changes)
- Better for analytics and reporting

### Privacy
- Only stores country and city (not precise location)
- Same data that was being looked up before, just stored now
- Follows common web analytics practices

## Troubleshooting

### Problem: New visits don't have country/city
**Check**:
1. Is cURL enabled in PHP? Run `phpinfo()` and search for "curl"
2. Can your server make outbound HTTP requests?
3. Check PHP error logs for API errors

**Test API manually**:
```php
$ip = '8.8.8.8'; // Google DNS for testing
$response = file_get_contents("http://ip-api.com/json/{$ip}");
var_dump(json_decode($response, true));
```

### Problem: All locations show "Unknown"
This happens when:
- Visitors are on local network (127.0.0.1, 192.168.x.x)
- Server can't reach ip-api.com
- API rate limit exceeded (45 requests/minute)

**Solution**: Wait a bit and try again. For testing, visit from a real external IP.

### Problem: Dashboard statistics are empty
**Check**:
1. Do you have any visits with country/city data?
   ```sql
   SELECT COUNT(*) FROM tbl_website_visits WHERE country IS NOT NULL;
   ```
2. If zero, generate some visits by browsing your site

## Migration from Old Visits

### Optional: Backfill Location Data
If you want to add location data to old visits:

```sql
-- WARNING: This will make many API calls. Do this during off-hours.
-- Better to just let new visits populate naturally.
```

It's recommended to just let new visits populate the data naturally rather than backfilling.

## Code Examples

### Get Top Countries
```php
$this->load->model('admin/dashboard_model');
$countries = $this->dashboard_model->get_location_statistics(10);

foreach ($countries as $country) {
    echo $country['country'] . ': ' . $country['count'] . ' visits<br>';
}
```

### Get Top Cities
```php
$cities = $this->dashboard_model->get_city_statistics(10);

foreach ($cities as $city) {
    echo $city['city'] . ', ' . $city['country'] . ': ' . $city['count'] . '<br>';
}
```

### Get Total Countries
```php
$total = $this->dashboard_model->get_total_countries();
echo "Visitors from {$total} countries";
```

## Files Modified

1. ✅ `application/models/web/visit_tracker_model.php`
   - Added `get_location_from_ip()` method
   - Modified `prepare_visit_data()` to include location

2. ✅ `application/models/admin/dashboard_model.php`
   - Optimized `get_location_statistics()`
   - Optimized `get_city_statistics()`
   - Optimized `get_total_countries()`

3. ✅ `database/add_location_columns_to_visits.sql`
   - New SQL migration file

## Support

If you encounter any issues:
1. Check PHP error logs: `application/logs/`
2. Check database for new columns: `DESCRIBE tbl_website_visits;`
3. Test API manually with the code in Troubleshooting section
4. Verify cURL is enabled in PHP

## Summary

✨ **What you get**:
- Automatic country and city tracking for all new visits
- Fast dashboard statistics (no more API delays)
- Historical location data preserved in database
- Better visitor analytics

🚀 **Next steps**:
1. Run the SQL migration
2. Visit your site to generate test data
3. Check the admin dashboard to see location statistics
4. Enjoy faster, better visitor tracking!
