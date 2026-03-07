# Products Save Button Fix

## Problem
The "Save All Changes" button in `/application/views/admin/products.php` is not working because:
1. The JavaScript function is incomplete/incorrect
2. The form submission doesn't match the new category-based system
3. The button click handler is trying to save individual categories instead of page settings

## Solution

### Step 1: Fix the JavaScript (Around line 550 in products.php)

Find the section with the "Save All Changes" button handler and replace it with:

```javascript
// Update the main save button to save page settings only
document.addEventListener('DOMContentLoaded', function() {
    const mainSaveBtn = document.getElementById('saveAllChanges');
    if (mainSaveBtn) {
        mainSaveBtn.addEventListener('click', function(e) {
            e.preventDefault();
            savePageSettings();
        });
    }
});

// Save page settings (NOT individual categories)
function savePageSettings() {
    const saveBtn = document.getElementById('saveAllChanges');
    const originalHTML = saveBtn.innerHTML;
    
    // Show loading state
    saveBtn.innerHTML = `
        <svg class="animate-spin h-5 w-5 mr-2 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Saving...
    `;
    saveBtn.disabled = true;
    
    // Collect page settings
    const formData = new FormData();
    formData.append('page_title', document.getElementById('page_title').value);
    formData.append('bg_image', document.getElementById('bg_image').value);
    formData.append('cta_headline', document.getElementById('cta_headline').value);
    formData.append('cta_description', document.getElementById('cta_description').value);
    formData.append('cta_button_text', document.getElementById('cta_button_text').value);
    formData.append('cta_button_link', document.getElementById('cta_button_link').value);
    
    // Upload background image if changed
    const bgUpload = document.getElementById('bgUpload');
    if (bgUpload && bgUpload.files && bgUpload.files[0]) {
        formData.append('bg_image_file', bgUpload.files[0]);
    }
    
    // Send to server
    fetch('<?php echo base_url("cms/save_products_settings"); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Restore button
        saveBtn.innerHTML = originalHTML;
        saveBtn.disabled = false;
        
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Settings Saved!',
                text: data.message || 'Page settings updated successfully!',
                confirmButtonColor: '#059669',
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Save Failed',
                text: data.message || 'There was an error saving your settings.',
                confirmButtonColor: '#dc3545'
            });
        }
    })
    .catch(error => {
        // Restore button
        saveBtn.innerHTML = originalHTML;
        saveBtn.disabled = false;
        
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Network Error',
            text: 'Please check your connection and try again.',
            confirmButtonColor: '#dc3545'
        });
    });
}

// Remove the old saveAllChanges and resetAllChanges functions if they exist
```

### Step 2: Add New Controller Method

Add this method to `/application/controllers/cms.php`:

```php
/**
 * Save products page settings (NOT individual categories)
 */
public function save_products_settings()
{
    // Set JSON response header
    header('Content-Type: application/json');
    
    // Initialize response
    $response = [
        'success' => false,
        'message' => ''
    ];
    
    try {
        // Get user ID
        $user_id = $this->session->userdata('user_id') ?: 1;
        
        // Collect POST data
        $page_title = $this->input->post('page_title');
        $bg_image = $this->input->post('bg_image');
        $cta_headline = $this->input->post('cta_headline');
        $cta_description = $this->input->post('cta_description');
        $cta_button_text = $this->input->post('cta_button_text');
        $cta_button_link = $this->input->post('cta_button_link');
        
        $update_count = 0;
        
        // Handle background image upload
        if (!empty($_FILES['bg_image_file']['name'])) {
            $config['upload_path'] = FCPATH . 'assets_system/images/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = TRUE;
            
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('bg_image_file')) {
                $upload_data = $this->upload->data();
                $bg_image = $upload_data['file_name'];
                
                // Delete old image if exists
                $old_image = $this->input->post('bg_image');
                if (!empty($old_image) && file_exists($config['upload_path'] . $old_image)) {
                    @unlink($config['upload_path'] . $old_image);
                }
            }
        }
        
        // Update page title
        if (!empty($page_title)) {
            $this->products_model->update_content('page_title', [
                'content' => $page_title
            ], $user_id);
            $update_count++;
        }
        
        // Update background image
        if (!empty($bg_image)) {
            $this->products_model->update_content('bg_image', [
                'image' => $bg_image
            ], $user_id);
            $update_count++;
        }
        
        // Update CTA section
        if (!empty($cta_headline)) {
            $this->products_model->update_content('cta_headline', [
                'content' => $cta_headline
            ], $user_id);
            $update_count++;
        }
        
        if (!empty($cta_description)) {
            $this->products_model->update_content('cta_description', [
                'content' => $cta_description
            ], $user_id);
            $update_count++;
        }
        
        if (!empty($cta_button_text)) {
            $this->products_model->update_content('cta_button_text', [
                'content' => $cta_button_text
            ], $user_id);
            $update_count++;
        }
        
        if (!empty($cta_button_link)) {
            $this->products_model->update_content('cta_button_link', [
                'content' => $cta_button_link
            ], $user_id);
            $update_count++;
        }
        
        // Success response
        $response['success'] = true;
        $response['message'] = "Successfully updated {$update_count} setting(s)!";
        
    } catch (Exception $e) {
        // Error handling
        log_message('error', 'Products settings save error: ' . $e->getMessage());
        $response['message'] = 'An error occurred while saving: ' . $e->getMessage();
    }
    
    // Return JSON response
    echo json_encode($response);
}
```

### Step 3: Verify Products Model

Make sure your `/application/models/admin/products_model.php` has the `update_content` method:

```php
/**
 * Update or create content item
 */
public function update_content($title, $data, $user_id = 1)
{
    // Check if item exists
    $this->db->where('title', $title);
    $query = $this->db->get($this->table);
    
    // Prepare data
    $update_data = $data;
    $update_data['edited_by'] = $user_id;
    $update_data['updated_at'] = date('Y-m-d H:i:s');
    
    if ($query->num_rows() > 0) {
        // Update existing
        $this->db->where('title', $title);
        return $this->db->update($this->table, $update_data);
    } else {
        // Create new
        $update_data['title'] = $title;
        $update_data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert($this->table, $update_data);
    }
}
```

## Testing

1. Go to the Products management page
2. Change the page title, background image, or CTA section
3. Click "Save All Changes" button
4. You should see a success message
5. Refresh the page to verify changes were saved

## Note

Individual categories are now managed through their own "Edit" buttons in each category card. The "Save All Changes" button is ONLY for page-level settings like:
- Page title
- Background image
- CTA (Call-to-Action) section at the bottom

This separation makes the system more intuitive and prevents accidental overwrites.
