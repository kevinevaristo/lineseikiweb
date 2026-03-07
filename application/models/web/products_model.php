<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class products_model extends CI_Model
{
    protected $table = 'tbl_products';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get all products content as key-value pairs
     */
    public function get_products_content()
    {
        $query = $this->db->get($this->table);
        $result = $query->result_array();
        
        // Convert the flat result into a key-value pair array
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
    
    /**
     * Get structured products data
     */
    public function get_products_data()
    {
        $content = $this->get_products_content();
        $products_data = array();
        
        // Background image
        $products_data['bg_image'] = isset($content['bg_image']['image']) ? $content['bg_image']['image'] : 'stockroom.jpg';
        
        // Categories array - maintain the order from your original code
        $categories = array(
            array(
                'title' => 'Safety Switches',
                'image_key' => 'switches_imgage',
                'link' => 'products_details'
            ),
            array(
                'title' => 'Electronic Counters',
                'image_key' => 'electronic_counters_img',
                'link' => 'electronic_counter_details'
            ),
            array(
                'title' => 'Timers',
                'image_key' => 'timers_img',
                'link' => 'timer_details'
            ),
            array(
                'title' => 'Mechanical Counters',
                'image_key' => 'mechanical_counters_img',
                'link' => 'mechanical_counter_details'
            ),
            array(
                'title' => 'Slide Limit Counters',
                'image_key' => 'slide_limit_counters_img',
                'link' => 'slide_limit_counter_details'
            ),
            array(
                'title' => 'Limit Switches',
                'image_key' => 'limit_switch_img',
                'link' => 'limit_switches_details'
            ),
            array(
                'title' => 'Length Counters & Sensors',
                'image_key' => 'length_counters_img',
                'link' => 'length_counter_sensor_details'
            ),
            array(
                'title' => 'Rotary Encoders',
                'image_key' => 'rotary_img',
                'link' => 'rotary_encoders_details'
            ),
            array(
                'title' => 'Tachometers',
                'image_key' => 'tachometers_img',
                'link' => 'tachometers_details'
            ),
            array(
                'title' => 'Thermometers',
                'image_key' => 'thermometer_img',
                'link' => 'thermometers_details'
            ),
            array(
                'title' => 'Measuring Instruments',
                'image_key' => 'measuring_img',
                'link' => 'measuring_instruments_details'
            ),
            array(
                'title' => 'Tally Counters',
                'image_key' => 'tallycounter_img',
                'link' => 'products_details' // Note: This links to same as Safety Switches
            )
        );
        
        // Process each category
        $products_data['categories'] = array();
        foreach ($categories as $index => $category) {
            $cat_data = array(
                'title' => $category['title'],
                'link' => $category['link'],
                'image' => isset($content[$category['image_key']]['image']) ? $content[$category['image_key']]['image'] : '',
                'delay' => ($index % 4) + 1 // Calculate delay for animation: 1,2,3,4,1,2,3,4...
            );
            $products_data['categories'][] = $cat_data;
        }
        
        return $products_data;
    }
    
    /**
     * Get content by specific title/key
     */
    public function get_by_title($title)
    {
        $this->db->where('title', $title);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }
    
    /**
     * Update content by title/key
     */
    public function update_content($title, $data, $user_id = null)
    {
        $existing = $this->get_by_title($title);
        
        if ($existing) {
            // Update existing
            $update_data = array(
                'content' => $data['content'] ?? '',
                'edited_by' => $user_id,
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            if (isset($data['image'])) {
                $update_data['image'] = $data['image'];
            }
            
            $this->db->where('id', $existing['id']);
            return $this->db->update($this->table, $update_data);
        } else {
            // Create new
            $insert_data = array(
                'title' => $title,
                'content' => $data['content'] ?? '',
                'image' => $data['image'] ?? null,
                'edited_by' => $user_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            return $this->db->insert($this->table, $insert_data);
        }
    }
    
    /**
     * Get all content for CMS table view
     */
    public function get_content_for_cms($search = null, $limit = null, $offset = 0)
    {
        if ($search) {
            $this->db->group_start();
            $this->db->like('title', $search);
            $this->db->or_like('content', $search);
            $this->db->group_end();
        }
        
        $this->db->order_by('title', 'ASC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get($this->table);
        return $query->result_array();
    }
    
    /**
     * Count total content items
     */
    public function count_content($search = null)
    {
        if ($search) {
            $this->db->group_start();
            $this->db->like('title', $search);
            $this->db->or_like('content', $search);
            $this->db->group_end();
        }
        
        return $this->db->count_all_results($this->table);
    }
    
    /**
     * Get content by ID
     */
    public function get_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }
    
    /**
     * Delete content by ID
     */
    public function delete_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
    
    /**
     * Create new content
     */
    public function create_content($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->insert($this->table, $data);
    }
    
    public function get_all_products() {
        return $this->db->order_by('id', 'ASC')->get('tbl_product_category')->result();
    }
}