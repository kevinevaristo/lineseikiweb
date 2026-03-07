    /**
     * Display products management page
     */
    public function products()
    {
        $data['title'] = 'Products Management';
        $data['content'] = $this->products_model->get_products_content();
        $data['products'] = $this->products_model->get_all_products();
        
        $this->load->view('admin/products', $data);
    }
    
    /**
     * Save products page content and settings
     */
    public function save_products()
    {
        // Set JSON response header
        header('Content-Type: application/json');
        
        // Initialize response
        $response = [
            'success' => false,
            'message' => ''
        ];
        
        try {
            // Get user ID (if session exists)
            $user_id = $this->session->userdata('user_id') ?: 1;
            
            // Collect all POST data
            $page_title = $this->input->post('page_title');
            $bg_image = $this->input->post('bg_image');
            $cta_headline = $this->input->post('cta_headline');
            $cta_description = $this->input->post('cta_description');
            $cta_button_text = $this->input->post('cta_button_text');
            $cta_button_link = $this->input->post('cta_button_link');
            
            $update_count = 0;
            
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
                    'content' => '',
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
            
            // Update category images
            $category_images = [
                'switches_imgage',
                'electronic_counters_img',
                'timers_img',
                'mechanical_counters_img',
                'slide_limit_counters_img',
                'limit_switch_img',
                'length_counters_img',
                'rotary_img',
                'tachometers_img',
                'thermometer_img',
                'measuring_img',
                'tallycounter_img'
            ];
            
            foreach ($category_images as $image_key) {
                $image_value = $this->input->post($image_key);
                if (!empty($image_value)) {
                    $this->products_model->update_content($image_key, [
                        'content' => '',
                        'image' => $image_value
                    ], $user_id);
                    $update_count++;
                }
            }
            
            // Success response
            $response['success'] = true;
            $response['message'] = "Successfully updated {$update_count} item(s)!";
            
        } catch (Exception $e) {
            // Error handling
            log_message('error', 'Products save error: ' . $e->getMessage());
            $response['message'] = 'An error occurred while saving: ' . $e->getMessage();
        }
        
        // Return JSON response
        echo json_encode($response);
    }
