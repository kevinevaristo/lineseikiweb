# Adding Visitor's Location Card to Admin Dashboard

## Summary
This guide shows you how to add a **Visitor's Location** card to the admin dashboard overview, displaying data from the `tbl_website_visits` table.

## Files Modified

### 1. Dashboard Model (✅ ALREADY UPDATED)
**File**: `application/models/admin/dashboard_model.php`

The following methods have been added to retrieve location data:
- `get_location_statistics($limit = 10)` - Get visitor counts by country
- `get_city_statistics($limit = 10)` - Get visitor counts by city
- `get_total_countries()` - Get total number of unique countries
- Updated `get_statistics_summary()` to include location data

### 2. View File (NEEDS MANUAL UPDATE)
**File**: `application/views/admin/home.php`

You need to add the visitor location card HTML **after** the device types section.

## HTML Code to Add

Add this code right after the "Device Types" card in your dashboard:

```html
<!-- Visitor's Location Card -->
<section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
        <h3 class="font-bold text-slate-800 flex items-center">
            🌍 Visitor's Location
        </h3>
        <p class="text-sm text-slate-500 mt-1">Geographic distribution of website visitors</p>
    </div>
    
    <div class="p-6">
        <?php if(!empty($location_stats)): ?>
            <!-- Countries Statistics -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-semibold text-slate-700">Top Countries</h4>
                    <span class="text-xs text-slate-500"><?php echo $total_countries; ?> total countries</span>
                </div>
                
                <div class="space-y-3">
                    <?php foreach($location_stats as $location): ?>
                        <?php
                            $percentage = ($total_visitors > 0) ? round(($location['count'] / $total_visitors) * 100, 1) : 0;
                        ?>
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-medium text-slate-700"><?php echo htmlspecialchars($location['country']); ?></span>
                                    <span class="text-xs text-slate-500"><?php echo number_format($location['count']); ?> visits</span>
                                </div>
                                <div class="w-full bg-slate-200 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full transition-all duration-300" 
                                         style="width: <?php echo $percentage; ?>%"></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Cities Statistics -->
            <?php if(!empty($city_stats)): ?>
            <div class="border-t pt-6">
                <h4 class="font-semibold text-slate-700 mb-4">Top Cities</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <?php foreach($city_stats as $city): ?>
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                            <div>
                                <div class="font-medium text-sm text-slate-700"><?php echo htmlspecialchars($city['city']); ?></div>
                                <div class="text-xs text-slate-500"><?php echo htmlspecialchars($city['country']); ?></div>
                            </div>
                            <span class="text-sm font-semibold text-indigo-600"><?php echo number_format($city['count']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            
        <?php else: ?>
            <div class="text-center py-8">
                <svg class="w-16 h-16 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-slate-500">No location data available yet</p>
            </div>
        <?php endif; ?>
    </div>
</section>
```

## Where to Place the Code

1. Open `application/views/admin/home.php`
2. Find the section with "Device Types" card (look for `<!-- Device Types Card -->` or similar)
3. Add the above HTML code **right after** that section closes (after its `</section>` tag)
4. Save the file

## Controller Update (IF NEEDED)

If the `cms/home` function doesn't load the dashboard model, add this to your controller:

```php
public function home() {
    // Load dashboard model
    $this->load->model('admin/dashboard_model');
    
    // Get existing CMS data
    $data['cms_data'] = $this->cms_model->get_home_content();
    $data['carousel_slides'] = $this->cms_model->get_carousel_slides();
    $data['categories'] = $this->cms_model->get_categories();
    $data['stats'] = $this->cms_model->get_stats();
    $data['services'] = $this->cms_model->get_services_data();
    
    // Add location statistics
    $dashboard_stats = $this->dashboard_model->get_statistics_summary();
    $data['location_stats'] = $dashboard_stats['location_stats'];
    $data['city_stats'] = $dashboard_stats['city_stats'];
    $data['total_countries'] = $dashboard_stats['total_countries'];
    $data['total_visitors'] = $dashboard_stats['total_visitors'];
    
    $this->load->view('admin/home', $data);
}
```

## Database Table Structure

The card uses data from `tbl_website_visits` table with these columns:
- `id` - Primary key
- `ip_address` - Visitor's IP address
- `country` - Visitor's country
- `city` - Visitor's city
- `visit_date` - Visit timestamp
- Other columns (user_agent, device_type, etc.)

## Testing

1. After adding the code, access your admin dashboard
2. The new "Visitor's Location" card should appear after the Device Types card
3. It will show:
   - Top 10 countries with visit counts and percentage bars
   - Top 10 cities with their countries
   - Total unique countries count

## Customization Options

You can customize:
- **Number of items shown**: Change the `$limit` parameter in the model methods
- **Card position**: Move the HTML section to a different location in the view
- **Styling**: Modify the Tailwind CSS classes for different appearance
- **Data display**: Add more fields from the `tbl_website_visits` table

## Troubleshooting

If data doesn't appear:
1. Check that `tbl_website_visits` has records with country/city data populated
2. Verify the dashboard_model methods were added correctly
3. Check that the controller passes the data variables to the view
4. Inspect browser console for any JavaScript errors

## Notes

- The percentages are calculated based on total visitors
- Countries and cities with NULL or empty values are excluded
- The card uses a responsive grid layout for cities
- Progress bars animate on page load using CSS transitions
