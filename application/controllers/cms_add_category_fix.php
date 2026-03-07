<?php
// FIX FOR ADD CATEGORY FUNCTION
// Replace the add_category() function in cms.php with this version

public function add_category() {
    // Set JSON header
    header('Content-Type: application/json');
    
    // Start output buffering to catch any errors
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
        
        $data = [
            'category_name' => $this->input->post('category_name'),
            'product_image' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Handle image upload
        if (!empty($_FILES['category_image']['name'])) {
            $config['upload_path'] = FCPATH . 'assets_system/images/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp|svg';
            $config['max_size'] = 2048; // 2MB
            $config['encrypt_name'] = TRUE;
            $config['remove_spaces'] = TRUE;
            
            // Initialize upload library
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('category_image')) {
                $upload_data = $this->upload->data();
                $data['product_image'] = $upload_data['file_name'];
            } else {
                $error = strip_tags($this->upload->display_errors());
                ob_end_clean();
                echo json_encode([
                    'success' => false,
                    'message' => 'Image upload failed: ' . $error
                ]);
                return;
            }
        }
        
        // Insert into database
        $new_id = $this->products_model->add_product($data);
        
        if ($new_id) {
            ob_end_clean();
            echo json_encode([
                'success' => true,
                'message' => 'Category added successfully!',
                'id' => $new_id,
                'category_name' => $data['category_name'],
                'product_image' => $data['product_image']
            ]);
        } else {
            ob_end_clean();
            echo json_encode([
                'success' => false,
                'message' => 'Failed to add category to database.'
            ]);
        }
    } catch (Exception $e) {
        ob_end_clean();
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
}
