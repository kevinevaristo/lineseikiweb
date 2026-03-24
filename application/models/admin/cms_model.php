<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cms_model extends CI_Model {

    // Existing function for general content
    public function get_home_content() {
        $query = $this->db->get('tbl_home_page');
        $result = $query->result_array();
        $content = array();
        foreach ($result as $row) {
            $content[$row['title']] = array(
                'id'      => $row['id'],
                'content' => $row['content'],
                'image'   => $row['image']
            );
        }
        return $content;
    }

    // NEW: Fetch all carousel slides
    public function get_carousel_slides() {
        return $this->db->order_by('id', 'ASC')->get('tbl_home_carousel')->result_array();
    }
    
     public function get_services_data()

    {

        $content = $this->get_home_content();

        $services_data = array();

        

        // Services header

        $services_data['tagline'] = isset($content['serv_tagline']['content']) ? $content['serv_tagline']['content'] : 'Beyond Measurement — We Engineer Possibilities';

        

        // Services

        $services_data['services'] = array();

        for ($i = 1; $i <= 3; $i++) {

            $service = array();

            

            // Basic fields

            $fields = array(

                'featured_badge' => "feat_badge_$i",

                'badge' => "serv_badge_$i",

                'title' => "serv_title_$i",

                'description' => "serv_desc_$i",

                'link_label' => "serv_link_label_$i",

                'image' => "serv_image_$i"

            );

            

            foreach ($fields as $key => $field) {

                if (isset($content[$field])) {

                    $service[$key] = !empty($content[$field]['content']) ? $content[$field]['content'] : $content[$field]['image'];

                }

            }

            

            // Features

            $service['features'] = array();

            if ($i == 1) {

                for ($j = 1; $j <= 4; $j++) {

                    if (isset($content["serv_feat_$j"]['content'])) {

                        $service['features'][] = $content["serv_feat_$j"]['content'];

                    }

                }

            } else {

                for ($j = 1; $j <= 4; $j++) {

                    $field = "serv_feat_{$i}_$j";

                    if (isset($content[$field]['content'])) {

                        $service['features'][] = $content[$field]['content'];

                    }

                }

            }

            

            $services_data['services'][] = $service;

        }

        

        // Background image

        $services_data['bg_image'] = isset($content['serv_bg_img']['image']) ? $content['serv_bg_img']['image'] : 'simulation2.jpg';

        

        return $services_data;

    }

    // Existing update for general content (upsert - insert if not exists)
    public function update_content($title, $data) {
        // Check if the row exists
        $exists = $this->db->where('title', $title)->count_all_results('tbl_home_page');
        if ($exists > 0) {
            $this->db->where('title', $title);
            return $this->db->update('tbl_home_page', $data);
        } else {
            $data['title'] = $title;
            return $this->db->insert('tbl_home_page', $data);
        }
    }

    // NEW: Sync Carousel (Delete all and Re-insert)
    public function sync_carousel($slides) {
        $this->db->trans_start();
        // Clear existing slides
        $this->db->empty_table('tbl_home_carousel');
        // Insert new set
        if (!empty($slides)) {
            $this->db->insert_batch('tbl_home_carousel', $slides);
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    // Sa Cms_model.php:
public function delete_carousel_slide($id)
{
    // Kunin muna ang image filename para ma-delete ang file
    $slide = $this->db->get_where('tbl_home_carousel', array('id' => $id))->row_array();
    
    if($slide) {
        // Delete images from server
        if(!empty($slide['hero_image'])) {
            $image_path = FCPATH . 'assets_system/images/' . $slide['hero_image'];
            if(file_exists($image_path)) {
                unlink($image_path);
            }
        }
        
        if(!empty($slide['hero_bg_img'])) {
            $bg_path = FCPATH . 'assets_system/images/' . $slide['hero_bg_img'];
            if(file_exists($bg_path)) {
                unlink($bg_path);
            }
        }
    }
    
    // Delete from database - gamitin ang tamang table name
    $this->db->where('id', $id);
    return $this->db->delete('tbl_home_carousel');
}

    public function get_categories() {
        $this->db->order_by('id', 'ASC');
        return $this->db->get('tbl_card_categories')->result_array();
    }
    
    // Get single category
    public function get_category($id) {
        return $this->db->get_where('tbl_card_categories', ['id' => $id])->row_array();
    }
    
    // Add new category
    public function add_category($data) {
        $this->db->insert('tbl_card_categories', $data);
        return $this->db->insert_id();
    }
    
    // Update category
    public function update_category($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tbl_card_categories', $data);
    }
    
    public function update_category_icon($category_id, $icon_filename) {
        return $this->db->where('id', $category_id)
                        ->update('tbl_card_categories', ['icon' => $icon_filename]);
    }
    
    // Delete category
    public function delete_category($id) {
        $this->db->where('id', $id);
        return $this->db->delete('tbl_card_categories');
    }
    
    // Get all stats
    public function get_stats() {
        $this->db->order_by('id', 'ASC');
        return $this->db->get('tbl_key_stats')->result_array();
    }
    
    // Add new stat
    public function add_stat($data) {
        $this->db->insert('tbl_key_stats', $data);
        return $this->db->insert_id();
    }
    
    // Update stat
    public function update_stat($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tbl_key_stats', $data);
    }
    
    // Delete stat
    public function delete_stat($id) {
        $this->db->where('id', $id);
        return $this->db->delete('tbl_key_stats');
    }
    
    public function save_stats($new_stats, $update_stats)
    {
        $new_ids = [];
        
        // 1. Add NEW stats
        foreach ($new_stats as $stat) {
            $data = [
                'stat_number' => $stat['stat_number'],
                'stat_label' => $stat['stat_label'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $new_ids[] = $this->add_stat($data);
        }
        
        // 2. Update existing stats
        foreach ($update_stats as $stat) {
            $data = [
                'stat_number' => $stat['stat_number'],
                'stat_label' => $stat['stat_label'],
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $this->update_stat($stat['id'], $data);
        }
        
        return ['new_ids' => $new_ids];
    }
    
    public function save_new_products_data($data)
{
    $this->db->trans_start(); // Start transaction
    
    try {
        // Save main fields
        $main_fields = [
            'new_badge' => $data['new_badge'] ?? '',
            'new_product_header' => $data['new_product_header'] ?? '',
            'new_product_text' => $data['new_product_text'] ?? '',
            'new_product_button' => $data['new_product_button'] ?? ''
        ];
        
        foreach ($main_fields as $field => $value) {
            $this->db->where('title', $field);
            $this->db->update('tbl_home_page', ['content' => $value]);
        }
        
        if (!empty($data['new_product_image'])) {
            $this->db->where('title', 'new_product_image');
            $this->db->update('tbl_home_page', [
                'image' => $data['new_product_image'],
                'content' => $data['new_product_image']  // Kung gusto mo pareho
            ]);
        }
        
        // Save features
        if (!empty($data['features']) && is_array($data['features'])) {
            foreach ($data['features'] as $index => $feature) {
                // Save feature title
                if (isset($feature['title'])) {
                    $this->db->where('title', "new_prod_feat_$index");
                    $this->db->update('tbl_home_page', ['content' => $feature['title']]);
                }
                
                // Save feature image
                if (!empty($feature['image'])) {
                    $this->db->where('title', "feat_image_$index");
                    $this->db->update('tbl_home_page', ['image' => $feature['image']]);
                }
            }
        }
        
        $this->db->trans_complete(); // Complete transaction
        
        return $this->db->trans_status(); // Return true if successful
        
    } catch (Exception $e) {
        $this->db->trans_rollback();
        log_message('error', 'Save new products failed: ' . $e->getMessage());
        return false;
    }
}

}