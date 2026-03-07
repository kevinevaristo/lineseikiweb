# Application Image Upload Fix

## Problem
In the admin side product edit page (`products_edit.php`), images were not being saved for applications in the Applications section.

## Root Cause
The image upload handling in the `update_product_item()` method was:
1. Processing the application JSON data first
2. Then attempting to handle file uploads in a separate method
3. The separate method was trying to update the already-encoded JSON data, which was inefficient and not working correctly

## Solution
Modified the `cms.php` controller to properly handle application image uploads:

### Changes Made:

#### 1. Modified `update_product_item()` method
- Changed the flow to process application images BEFORE encoding to JSON
- Split the file upload handling into two separate methods for clarity

```php
// OLD FLOW:
1. Decode applications JSON
2. Save to $data['applications_data']
3. Try to handle file uploads separately

// NEW FLOW:
1. Decode applications JSON into array
2. Process file uploads and update the array
3. Encode the updated array to JSON and save
```

#### 2. Created new `process_application_image_uploads()` method
This new method:
- Takes the applications array and product ID
- Loops through each application
- Checks for uploaded files using the key pattern `app_file_{index}`
- Validates file type (JPEG, PNG, GIF, WebP)
- Validates file size (max 2MB)
- Moves the uploaded file to `./assets_system/images/`
- Updates the application's image field with the filename
- Deletes old images if they're being replaced
- Returns the processed applications array

#### 3. Simplified `handle_main_product_image()` method
- Renamed from `handle_file_uploads_item()`
- Now only handles the main product image upload
- No longer tries to handle application images

## File Upload Pattern

The frontend sends files with this naming pattern:
```javascript
formData.append(`app_file_${index}`, fileInput.files[0]);
```

The backend processes them like this:
```php
foreach ($applications as $index => $app) {
    $file_key = 'app_file_' . $index;
    if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] === UPLOAD_ERR_OK) {
        // Process the file...
    }
}
```

## Testing the Fix

1. Navigate to the product edit page
2. Go to the Applications section
3. Add a new application or edit an existing one
4. Upload an image using the file input
5. Click "Save Product"
6. Verify that:
   - The image appears in the preview
   - The image is saved to `./assets_system/images/`
   - The image filename is stored in the `applications_data` JSON field
   - The product displays correctly on the frontend

## Files Modified

- `/application/controllers/cms.php`
  - Modified: `update_product_item()` method (lines ~3927-4000)
  - Added: `process_application_image_uploads()` method (new)
  - Modified: `handle_file_uploads_item()` → `handle_main_product_image()` (renamed and simplified)

## Image Storage Location

All application images are stored in:
```
./assets_system/images/
```

With filenames in the format:
```
app_{timestamp}_{uniqid}_{original_filename}
```

Or using the existing filename if already present.

## Database Structure

The `applications_data` field in `tbl_product_items` stores JSON:
```json
[
  {
    "title": "Door of Food Processing Machinery",
    "image": "app_1737123456_abc123_machinery.jpg",
    "badge": "Safety",
    "link": "https://example.com"
  }
]
```

## Future Improvements

Consider:
1. Adding image compression/optimization
2. Generating thumbnails for better performance
3. Moving to a dedicated uploads table instead of JSON
4. Adding image validation on the frontend
5. Implementing drag-and-drop image upload
