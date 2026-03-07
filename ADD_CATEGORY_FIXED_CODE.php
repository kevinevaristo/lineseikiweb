/**
 * PALITAN ANG ADD_CATEGORY FUNCTION SA CMS.PHP
 * Copy ang code na ito at replace sa existing add_category() function
 */
public function add_category() {
    // Set JSON header
    header('Content-Type: application/json');
    
    // Start output buffering to catch any unexpected output
    ob_start();
    
    try {
        // Load form validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('category_name', 'Category Name', 'required|trim');
        
        if ($this->form_validation->run() === FALSE) {
            ob_end_clean();
            echo json_encode([
                'success' => false,
                'message' => strip_tags(validation_errors())
            ]);
            return;
        }
        
        // Prepare data array for database
        $data = [
            'category_name' => $this->input->post('category_name'),
            'product_image' => '', // Default empty, will be updated if image uploaded
            'is_active' => 1, // Active by default
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Handle image upload if file is provided
        if (!empty($_FILES['category_image']['name'])) {
            // Configure upload settings
            $config['upload_path'] = FCPATH . 'assets_system/images/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp|svg';
            $config['max_size'] = 2048; // 2MB max
            $config['encrypt_name'] = TRUE; // Encrypt filename for security
            $config['remove_spaces'] = TRUE;
            $config['overwrite'] = FALSE;
            
            // Make sure upload directory exists
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }
            
            // Initialize upload library with config
            $this->load->library('upload');
            $this->upload->initialize($config);
            
            // Attempt upload
            if ($this->upload->do_upload('category_image')) {
                // Upload successful - get file data
                $upload_data = $this->upload->data();
                $data['product_image'] = $upload_data['file_name'];
                
                // Log success
                log_message('info', 'Category image uploaded: ' . $upload_data['file_name']);
            } else {
                // Upload failed - get error and return
                $error = strip_tags($this->upload->display_errors());
                ob_end_clean();
                
                // Log error
                log_message('error', 'Category image upload failed: ' . $error);
                
                echo json_encode([
                    'success' => false,
                    'message' => 'Image upload failed: ' . $error
                ]);
                return;
            }
        }
        
        // Insert into database using products_model
        $new_id = $this->products_model->add_product($data);
        
        if ($new_id) {
            // Success - clear buffer and return success response
            ob_end_clean();
            
            // Log success
            log_message('info', 'New category added: ID=' . $new_id . ', Name=' . $data['category_name']);
            
            echo json_encode([
                'success' => true,
                'message' => 'Category added successfully!',
                'id' => $new_id,
                'category_name' => $data['category_name'],
                'product_image' => $data['product_image'],
                'image_url' => !empty($data['product_image']) 
                    ? base_url('assets_system/images/' . $data['product_image']) 
                    : ''
            ]);
        } else {
            // Database insert failed
            ob_end_clean();
            
            // Log error
            log_message('error', 'Failed to insert category into database');
            
            echo json_encode([
                'success' => false,
                'message' => 'Failed to add category to database.'
            ]);
        }
        
    } catch (Exception $e) {
        // Catch any unexpected errors
        ob_end_clean();
        
        // Log exception
        log_message('error', 'Exception in add_category: ' . $e->getMessage());
        
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
}
