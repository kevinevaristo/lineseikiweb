<?php
/**
 * UPDATED FOOTER SAVE ALL METHOD FOR CMS CONTROLLER
 * Replace the existing footer_save_all() method in cms.php with this one
 * 
 * Location: application/controllers/cms.php
 * Line: ~153 (replace the existing footer_save_all method)
 */

// AJAX: Save all footer content changes
public function footer_save_all() {
    // Set JSON header
    header('Content-Type: application/json');
    
    // Initialize response
    $response = [
        'success' => false,
        'message' => '',
        'updated_count' => 0
    ];
    
    try {
        // Get all POST data
        $post_data = $this->input->post();
        
        // Extract items to update (format: item_[id] = content)
        $items_to_update = [];
        
        foreach ($post_data as $key => $value) {
            // Check if this is an item field (starts with 'item_')
            if (strpos($key, 'item_') === 0) {
                // Extract the ID
                $id = str_replace('item_', '', $key);
                
                // Only process if ID is valid and not empty
                if (!empty($id) && is_numeric($id)) {
                    $items_to_update[$id] = $value;
                }
            }
        }
        
        // Check if we have items to update
        if (empty($items_to_update)) {
            $response['message'] = 'No changes to save.';
            echo json_encode($response);
            return;
        }
        
        // Log what we're updating (for debugging)
        log_message('debug', 'Footer save all - Updating ' . count($items_to_update) . ' items');
        
        // Use the bulk update method from model
        $result = $this->footer_model->bulk_update_items($items_to_update);
        
        if ($result['success']) {
            $response['success'] = true;
            $response['message'] = "{$result['count']} item(s) updated successfully!";
            $response['updated_count'] = $result['count'];
            
            // Log success
            log_message('info', "Footer content updated successfully. {$result['count']} items updated.");
        } else {
            $response['message'] = 'Failed to save changes. Please try again.';
            log_message('error', 'Footer save all - Database update failed');
        }
        
    } catch (Exception $e) {
        // Log error with details
        log_message('error', 'Footer save all error: ' . $e->getMessage());
        log_message('error', 'Stack trace: ' . $e->getTraceAsString());
        
        $response['message'] = 'An error occurred while saving. Please try again.';
    }
    
    // Return JSON response
    echo json_encode($response);
}

?>