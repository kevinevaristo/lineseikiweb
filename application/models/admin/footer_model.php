<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class footer_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    // Get all footer items
    public function get_all_items() {
        $this->db->order_by('title', 'ASC');
        $query = $this->db->get('tbl_footer');
        return $query->result_array();
    }
    
    // Get single item by ID
    public function get_item($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_footer');
        return $query->row_array();
    }
    
    // Get item by title
    public function get_item_by_title($title) {
        $this->db->where('title', $title);
        $query = $this->db->get('tbl_footer');
        return $query->row_array();
    }
    
    // Create new item
    public function create_item($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('tbl_footer', $data);
    }
    
    // Update item
    public function update_item($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('tbl_footer', $data);
    }
    
    // Delete item
    public function delete_item($id) {
        // Get item first to check for image
        $item = $this->get_item($id);
        if ($item && !empty($item['image'])) {
            // Delete image file
            $image_path = FCPATH . 'assets_system/images/' . $item['image'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
        
        $this->db->where('id', $id);
        return $this->db->delete('tbl_footer');
    }
    
    // Update batch items
    public function update_batch_items($data) {
        foreach ($data as &$item) {
            $item['updated_at'] = date('Y-m-d H:i:s');
        }
        return $this->db->update_batch('tbl_footer', $data, 'id');
    }
    
    // Simple update content by ID
    public function update_content_by_id($id, $content) {
        $data = [
            'content' => $content,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id', $id);
        return $this->db->update('tbl_footer', $data);
    }
    
    // Bulk update multiple items at once
    public function bulk_update_items($items) {
        $this->db->trans_start();
        
        $success_count = 0;
        $total_count = count($items);
        
        foreach ($items as $id => $content) {
            if (!empty($id) && $id !== '') {
                $data = [
                    'content' => $content,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                $this->db->where('id', $id);
                $result = $this->db->update('tbl_footer', $data);
                
                if ($result) {
                    $success_count++;
                }
            }
        }
        
        $this->db->trans_complete();
        
        return [
            'success' => $this->db->trans_status(),
            'count' => $success_count,
            'total' => $total_count
        ];
    }
    
    // Count items by category
    public function count_by_category($prefix) {
        if ($prefix === 'other') {
            $this->db->where("title NOT LIKE 'contact_%'");
            $this->db->where("title NOT LIKE 'menu_%'");
            $this->db->where("title NOT LIKE 'social_%'");
            $this->db->where("title NOT LIKE 'policy_%'");
            $this->db->where("title != 'footer_logo'");
            $this->db->where("title != 'copyright'");
        } elseif ($prefix === 'footer_logo' || $prefix === 'copyright') {
            $this->db->where('title', $prefix);
        } else {
            $this->db->like('title', $prefix . '_', 'after');
        }
        return $this->db->count_all_results('tbl_footer');
    }
    
    public function get_footer_items_by_type($type = 'social') {
        if ($type == 'social') {
            $this->db->like('title', 'social_');
        } elseif ($type == 'contact') {
            $this->db->where_in('title', ['contact_section_title', 'contact_section_description']);
        } elseif ($type == 'copyright') {
            $this->db->where('title', 'copyright');
        }
        
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('tbl_footer');
        return $query->result_array();
    }
    
    // Get items by category
    public function get_by_category($category) {
        if ($category === 'footer_logo' || $category === 'copyright') {
            $this->db->where('title', $category);
        } else {
            $this->db->like('title', $category . '_', 'after');
        }
        $this->db->order_by('title', 'ASC');
        $query = $this->db->get('tbl_footer');
        return $query->result_array();
    }
    
    // Search items
    public function search_items($keyword) {
        $this->db->like('title', $keyword);
        $this->db->or_like('content', $keyword);
        $this->db->order_by('title', 'ASC');
        $query = $this->db->get('tbl_footer');
        return $query->result_array();
    }
    
    // Get categories with counts
    public function get_categories_with_counts() {
        $categories = [
            'contact' => 'Contact Section',
            'menu' => 'Menu Items', 
            'social' => 'Social Media',
            'policy' => 'Policy Links',
            'footer_logo' => 'Footer Logo',
            'copyright' => 'Copyright',
            'other' => 'Other Items'
        ];
        
        $result = [];
        foreach ($categories as $key => $name) {
            $result[$key] = [
                'name' => $name,
                'count' => $this->count_by_category($key)
            ];
        }
        
        return $result;
    }
    
    // Upload image
    public function upload_image($field_name = 'image') {
        $config['upload_path'] = FCPATH . 'assets_system/images/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|svg';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;
        
        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload($field_name)) {
            return [
                'success' => false,
                'error' => $this->upload->display_errors()
            ];
        } else {
            return [
                'success' => true,
                'data' => $this->upload->data()
            ];
        }
    }
    function get_header_text() 
    {
        
    }
}
?>