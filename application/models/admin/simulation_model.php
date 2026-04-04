<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class simulation_model extends CI_Model {
    
    protected $table = 'tbl_benefits';
    protected $table_2 = 'tbl_simulation_content';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_all_simulations() {
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get($this->table_2);
        return $query->result();
    }
    
     public function get_simulation_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table_2);
        return $query->row();
    }
    
    public function update_simulation($id, $data) 
    {
        // Remove empty values for metrics to avoid NULL issues
        $fields = ['prototype_without', 'prototype_with', 'prototype_reduction', 
                  'testing_without', 'testing_with', 'testing_reduction',
                  'development_without', 'development_with', 'development_reduction',
                  'actual_image_filename', 'simulation_image_filename', 'main_image'];
        
        foreach ($fields as $field) {
            if (isset($data[$field]) && $data[$field] === '') {
                $data[$field] = NULL;
            }
        }

        $this->db->where('id', $id);
        return $this->db->update($this->table_2, $data);
    }
    
    public function save_simulation($data) 
    {
        // Remove empty values for metrics to avoid NULL issues
        $fields = ['prototype_without', 'prototype_with', 'prototype_reduction', 
                  'testing_without', 'testing_with', 'testing_reduction',
                  'development_without', 'development_with', 'development_reduction',
                  'actual_image_filename', 'simulation_image_filename', 'main_image'];
        
        foreach ($fields as $field) {
            if (isset($data[$field]) && ($data[$field] === '' || $data[$field] === NULL)) {
                $data[$field] = NULL;
            }
        }

        if ($this->db->insert($this->table_2, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }
    
    public function get_all_benefits() {
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get($this->table);
        return $query->result_array();
    }
    
    public function insert_benefit($data)
    {
        return $this->db->insert('tbl_benefits', $data);
    }
    public function update_benefit($id, $data)
{
    $this->db->where('id', $id);
    return $this->db->update('tbl_benefits', $data);
}

/**
 * Delete benefit from tbl_benefits
 */
public function delete_benefit($id)
{
    $this->db->where('id', $id);
    return $this->db->delete('tbl_benefits');
}
    
    public function update_batch_benefits($benefits_data) {
        $results = [];
        
        foreach ($benefits_data as $benefit) {
            $id = isset($benefit['id']) ? $benefit['id'] : null;
            
            if ($id) {
                // Update existing benefit
                unset($benefit['id']);
                if ($this->update($id, $benefit)) {
                    $results[] = $this->get_benefit($id);
                }
            } else {
                // Create new benefit
                $new_id = $this->create($benefit);
                if ($new_id) {
                    $results[] = $this->get_benefit($new_id);
                }
            }
        }
        
        return $results;
    }
    
    public function get_benefit($id) {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }
    
     public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    public function create($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function validate($data) {
        $errors = [];
        
        if (empty(trim($data['title']))) {
            $errors[] = 'Title is required';
        } elseif (strlen($data['title']) > 255) {
            $errors[] = 'Title must be less than 255 characters';
        }
        
        if (empty(trim($data['description']))) {
            $errors[] = 'Description is required';
        }
        
        if (!empty($data['icon']) && strlen($data['icon']) > 255) {
            $errors[] = 'Icon must be less than 255 characters';
        }
        
        return $errors;
    }
    
    /**
     * Get all simulation content with titles as keys
     */
    public function get_all_content() {
        $query = $this->db->get('tbl_simulation');
        $result = array();
        
        foreach ($query->result() as $row) {
            $result[$row->title] = array(
                'id' => $row->id,
                'title' => $row->title,
                'content' => $row->content,
                'image' => $row->image
            );
        }
        
        return $result;
    }
    
    /**
     * Get content by title
     */
    public function get_by_title($title) {
        $this->db->where('title', $title);
        $query = $this->db->get('tbl_simulation');
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        
        return null;
    }
    
    /**
     * Update content by title
     */
    public function update_by_title($title, $data) {
        $this->db->where('title', $title);
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->update('tbl_simulation', $data);
    }
    
    /**
     * Update content by ID
     */
    public function update_by_id($id, $data) {
        $this->db->where('id', $id);
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->update('tbl_simulation', $data);
    }
    
    /**
     * Update multiple fields
     */
    public function update_multiple($updates) 
    {
        $this->db->trans_start();
        
        foreach ($updates as $field_name => $data) {
            // Check if record exists
            $this->db->where('title', $field_name);
            $query = $this->db->get('tbl_simulation');
            
            $data['updated_at'] = date('Y-m-d H:i:s');
            
            if ($query->num_rows() > 0) {
                // Update existing record
                $this->db->where('title', $field_name);
                $this->db->update('tbl_simulation', $data);
            } else {
                // Insert new record if doesn't exist
                $data['title'] = $field_name;
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->db->insert('tbl_simulation', $data);
            }
            
            // Log the update for debugging
            log_message('debug', "Updating $field_name: " . print_r($data, true));
        }
        
        $this->db->trans_complete();
        
        // Check for any errors
        if ($this->db->trans_status() === FALSE) {
            log_message('error', 'Transaction failed: ' . print_r($this->db->error(), true));
        }
        
        return $this->db->trans_status();
    }
    
    public function get_all_capabilities() {
        $this->db->order_by('sort_order', 'ASC');
        $capabilities = $this->db->get_where('tbl_capabilities', ['is_active' => 1])->result();
        
        foreach ($capabilities as $capability) {
            $capability->items = $this->get_capability_items($capability->id);
        }
        
        return $capabilities;
    }
    
    public function get_capability_items($capability_id) {
        $this->db->order_by('sort_order', 'ASC');
        return $this->db->get_where('tbl_capability_items', [
            'capability_id' => $capability_id,
            'is_active' => 1
        ])->result();
    }
    
    public function add_capability($data) {
        $this->db->insert('tbl_capabilities', $data);
        return $this->db->insert_id();
    }
    
    public function update_capability($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tbl_capabilities', $data);
    }
    
    public function delete_capability($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tbl_capabilities');
    }
    
    public function add_capability_item($data) {
        $this->db->insert('tbl_capability_items', $data);
        return $this->db->insert_id();
    }
    
    public function update_capability_item($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tbl_capability_items', $data);
    }
    
    public function delete_capability_item($id) {
        // Soft delete
        $this->db->where('id', $id);
        return $this->db->update('tbl_capability_items', ['is_active' => 0]);
    }
    
    public function update_sort_order($capabilities) {
        foreach ($capabilities as $order => $capability_id) {
            $this->db->where('id', $capability_id);
            $this->db->update('tbl_capabilities', ['sort_order' => $order + 1]);
        }
        return true;
    }
    
    public function get_carousel_items()
    {
        $this->db->order_by('sort_order', 'ASC');
        $this->db->where('is_active', 1);
        return $this->db->get('tbl_simulation_carousel')->result();
    }
    
    public function get_carousel_items_content()
    {
        $this->db->order_by('id', 'ASC');
        
        return $this->db->get('tbl_simulation_content')->result();
    }
    
    public function get_carousel_item($id)
    {
        return $this->db->get_where('tbl_simulation_carousel', ['id' => $id])->row();
    }
    
    public function save_carousel()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $this->load->library('upload');
        $response = ['success' => false, 'message' => '', 'items' => []];
        
        try {
            $carousel_data = json_decode($this->input->post('carousel_data'), true);
            
            if (!$carousel_data) {
                throw new Exception('Invalid carousel data');
            }
            
            // Process each carousel item
            foreach ($carousel_data as $item) {
                $db_id = isset($item['db_id']) ? intval($item['db_id']) : 0;
                
                $data = [
                    'title' => $item['title'] ?? '',
                    'description' => $item['description'] ?? '',
                    'link' => $item['link'] ?? '',
                    'sort_order' => $item['order'] ?? 0
                ];
                
                // Handle image upload for this carousel item
                $image_uploaded = false;
                
                // Check if a new image file was uploaded
                if (isset($_FILES['carousel_' . $item['id'] . '_image']) && $_FILES['carousel_' . $item['id'] . '_image']['error'] == 0) {
                    $upload_config = [
                        'upload_path' => FCPATH . 'assets_system/images/',
                        'allowed_types' => 'gif|jpg|jpeg|png|webp',
                        'max_size' => 5120, // 5MB
                        'encrypt_name' => true,
                        'overwrite' => false
                    ];
                    
                    $this->upload->initialize($upload_config);
                    
                    if ($this->upload->do_upload('carousel_' . $item['id'] . '_image')) {
                        $upload_data = $this->upload->data();
                        $data['image'] = $upload_data['file_name'];
                        $image_uploaded = true;
                        
                        // Delete old image if exists and we're updating an existing item
                        if ($db_id > 0 && !empty($item['old_image'])) {
                            $old_path = $upload_config['upload_path'] . $item['old_image'];
                            if (file_exists($old_path) && $item['old_image'] != $data['image']) {
                                @unlink($old_path);
                            }
                        }
                    } else {
                        // If upload fails, keep existing image
                        if ($db_id > 0 && !empty($item['old_image'])) {
                            $data['image'] = $item['old_image'];
                        }
                    }
                } elseif (!empty($item['image'])) {
                    // Keep existing image
                    $data['image'] = $item['image'];
                } elseif ($db_id > 0) {
                    // If no image provided and it's an existing item, get current image
                    $current_item = $this->simulation_model->get_carousel_item($db_id);
                    if ($current_item) {
                        $data['image'] = $current_item->image;
                    }
                }
                
                // Add ID if updating
                if ($db_id > 0) {
                    $data['id'] = $db_id;
                }
                
                // Save to database
                $saved_id = $this->simulation_model->save_carousel_item($data);
                
                if ($saved_id) {
                    $response['items'][] = [
                        'id' => $saved_id,
                        'db_id' => $saved_id,
                        'title' => $data['title'],
                        'image' => $data['image'] ?? ''
                    ];
                }
            }
            
            $response['success'] = true;
            $response['message'] = 'Carousel saved successfully!';
            
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
    
    public function delete_carousel_item()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $id = $this->input->post('id');
        $response = ['success' => false, 'message' => ''];
        
        if ($id) {
            // Get the item first to delete the image file
            $item = $this->simulation_model->get_carousel_item($id);
            
            if ($item && !empty($item->image)) {
                $image_path = FCPATH . 'assets_system/images/' . $item->image;
                if (file_exists($image_path) && $item->image != 'placeholder.png') {
                    @unlink($image_path);
                }
            }
            
            $success = $this->simulation_model->delete_carousel_item($id);
            if ($success) {
                $response['success'] = true;
                $response['message'] = 'Carousel item deleted successfully!';
            } else {
                $response['message'] = 'Failed to delete carousel item';
            }
        }
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
    
    public function update_carousel_order()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $items = $this->input->post('items');
        $response = ['success' => false, 'message' => ''];
        
        if ($items && is_array($items)) {
            $success = $this->simulation_model->update_carousel_order($items);
            if ($success) {
                $response['success'] = true;
                $response['message'] = 'Carousel order updated!';
            }
        }
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
    
    // ===== OTHER CAPABILITIES CRUD =====
    public function get_all_other_capabilities()
    {
        $query = $this->db->query("SELECT * FROM tbl_other_capabilities ORDER BY FIELD(category, 'Design', 'Analysis', 'Testing', 'Development') ASC, sort_order ASC");
        return $query->result();
    }

    public function get_other_capability($id)
    {
        return $this->db->get_where('tbl_other_capabilities', ['id' => $id])->row();
    }

    public function get_other_capability_categories()
    {
        $this->db->order_by('sort_order', 'ASC');
        return $this->db->get('tbl_other_capability_categories')->result();
    }

    public function get_capability_category($id)
    {
        return $this->db->get_where('tbl_other_capability_categories', ['id' => $id])->row();
    }

    public function update_capability_category($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_other_capability_categories', $data);
    }

    public function delete_capability_category($id)
    {
        $cat = $this->get_capability_category($id);
        if ($cat) {
            // Delete all items in this category
            $this->db->where('category', $cat->category);
            $this->db->delete('tbl_other_capabilities');
            // Delete the category itself
            $this->db->where('id', $id);
            return $this->db->delete('tbl_other_capability_categories');
        }
        return false;
    }

    public function add_other_capability($data)
    {
        $this->db->insert('tbl_other_capabilities', $data);
        return $this->db->insert_id();
    }

    public function update_other_capability($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_other_capabilities', $data);
    }

    public function delete_other_capability($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tbl_other_capabilities');
    }

    // Remove carousel from main content
    public function get_simulation_content()
    {
        $query = $this->db->get('tbl_simulation');
        $result = array();
        
        foreach ($query->result() as $row) {
            $result[$row->title] = array(
                'content' => $row->content,
                'image' => $row->image
            );
        }
        
        // Remove carousel fields from here
        $carousel_fields = [
            'carousel_1_title', 'carousel_1_description', 'carousel_1_image', 'carousel_1_link',
            'carousel_2_title', 'carousel_2_description', 'carousel_2_image', 'carousel_2_link',
            'carousel_3_title', 'carousel_3_description', 'carousel_3_image', 'carousel_3_link',
            'carousel_4_title', 'carousel_4_description', 'carousel_4_image', 'carousel_4_link',
            'carousel_5_title', 'carousel_5_description', 'carousel_5_image', 'carousel_5_link'
        ];
        
        foreach ($carousel_fields as $field) {
            if (isset($result[$field])) {
                unset($result[$field]);
            }
        }
        
        return $result;
    }
    
    
    
    
    
}