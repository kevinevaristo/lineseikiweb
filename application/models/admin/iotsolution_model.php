<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class iotsolution_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get all IoT solution content
     */
    public function get_all_content() {
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('tbl_iotsolution');
        return $query->result_array();
    }
    
    /**
     * Get content by title
     */
    public function get_by_title($title) {
        $this->db->where('title', $title);
        $query = $this->db->get('tbl_iotsolution');
        $result = $query->row_array();
        return $result ? $result : null;
    }
    
    /**
     * Get content like title
     */
    public function get_like_title($keyword) {
        $this->db->like('title', $keyword);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('tbl_iotsolution');
        return $query->result_array();
    }
    
    /**
     * Update content by ID
     */
    public function update_content($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('tbl_iotsolution', $data);
    }
    
    /**
     * Insert new content
     */
    public function insert_content($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('tbl_iotsolution', $data);
    }
    
    /**
     * Get system setup items with their list items for admin
     */
    public function get_system_setup_for_admin() {
        $all_content = $this->get_all_content();
        $system_setup = array();
        
        foreach ($all_content as $item) {
            $title = $item['title'];
            
            if (strpos($title, 'System Setup') !== false) {
                if (strpos($title, 'Item') === false && $title != 'System Setup Diagram') {
                    // Main accordion items
                    $item_name = str_replace('System Setup - ', '', $title);
                    $system_setup[$item_name] = array(
                        'id' => $item['id'],
                        'title' => $item['content'],
                        'items' => array(),
                        'item_ids' => array(),
                        'image' => $item['image']
                    );
                } else if (strpos($title, 'Item') !== false) {
                    // List items for accordion
                    $main_item = str_replace('System Setup - ', '', $title);
                    $main_item = substr($main_item, 0, strpos($main_item, ' Item'));
                    
                    if (isset($system_setup[$main_item])) {
                        $system_setup[$main_item]['items'][] = $item['content'];
                        $system_setup[$main_item]['item_ids'][] = $item['id'];
                    }
                }
            }
        }
        
        return $system_setup;
    }
    
    /**
     * Get grouped content for specific sections (for frontend)
     */
    public function get_grouped_content() {
        $all_content = $this->get_all_content();
        $grouped = array();
        
        foreach ($all_content as $item) {
            $title = $item['title'];
            
            // Hero Section
            if (strpos($title, 'Real-Time Machine Monitoring') !== false) {
                if (strpos($title, 'Title') !== false) {
                    $grouped['hero']['title'] = $item['content'];
                    $grouped['hero']['image'] = $item['image'];
                } else if (strpos($title, 'Content') !== false) {
                    $grouped['hero']['description'] = $item['content'];
                }
            }
            
            // Solution Section
            else if (strpos($title, 'Our Solution') !== false) {
                if (strpos($title, 'Title') !== false) {
                    $grouped['solution']['title'] = $item['content'];
                } else if (strpos($title, 'Problem') !== false) {
                    $grouped['solution']['problem'] = $item['content'];
                    $grouped['solution']['image'] = $item['image'];
                } else if (strpos($title, 'Content') !== false) {
                    $grouped['solution']['content'] = $item['content'];
                }
            }
            
            // Products Section
            else if (strpos($title, 'Product') !== false && !strpos($title, 'System Setup')) {
                if ($title == 'Base Station Product') {
                    $grouped['products']['base_station']['title'] = $item['content'];
                    $grouped['products']['base_station']['image'] = $item['image'];
                } else if ($title == 'Base Station Description') {
                    $grouped['products']['base_station']['content'] = $item['content'];
                } else if ($title == 'Smart Counter Product') {
                    $grouped['products']['smart_counter']['title'] = $item['content'];
                    $grouped['products']['smart_counter']['image'] = $item['image'];
                } else if ($title == 'Smart Counter Description') {
                    $grouped['products']['smart_counter']['content'] = $item['content'];
                }
            }
            
            // System Setup Section
            else if (strpos($title, 'System Setup') !== false) {
                if (strpos($title, 'Item') === false && $title != 'System Setup Diagram') {
                    // Main accordion items
                    $item_name = str_replace('System Setup - ', '', $title);
                    $grouped['system_setup'][$item_name] = array(
                        'title' => $item['content'],
                        'items' => array(),
                        'image' => $item['image']
                    );
                } else if (strpos($title, 'Item') !== false) {
                    // List items for accordion - SIMPLE FIX
                    $main_item = str_replace('System Setup - ', '', $title);
                    $main_item = substr($main_item, 0, strpos($main_item, ' Item'));
                    
                    if (isset($grouped['system_setup'][$main_item])) {
                        $grouped['system_setup'][$main_item]['items'][] = $item['content'];
                    }
                }
            }
            
            // Production Data Section
            else if (strpos($title, 'Production Data') !== false) {
                if ($title == 'Production Data Title') {
                    $grouped['production_data']['title'] = $item['content'];
                } else if ($title == 'Production Data Description') {
                    $grouped['production_data']['description'] = $item['content'];
                } else if (strpos($title, 'Production Data - ') !== false) {
                    $item_name = str_replace('Production Data - ', '', $title);
                    if (strpos($item_name, 'Content') !== false) {
                        $main_item = str_replace(' Content', '', $item_name);
                        if (isset($grouped['production_data'][$main_item])) {
                            $grouped['production_data'][$main_item]['content'] = $item['content'];
                        }
                    } else {
                        $grouped['production_data'][$item_name] = array(
                            'title' => $item['content'],
                            'image' => $item['image']
                        );
                    }
                }
            }
            
            // Features Section
            else if (strpos($title, 'Feature') !== false) {
                if ($title == 'Make Informed Decisions Title') {
                    $grouped['features']['title'] = $item['content'];
                } else if (strpos($title, 'Feature - ') !== false) {
                    $feature_name = str_replace('Feature - ', '', $title);
                    if (strpos($feature_name, 'Content') !== false) {
                        $main_feature = str_replace(' Content', '', $feature_name);
                        if (isset($grouped['features'][$main_feature])) {
                            $grouped['features'][$main_feature]['content'] = $item['content'];
                        }
                    } else {
                        $grouped['features'][$feature_name] = array(
                            'title' => $item['content']
                        );
                    }
                }
            }
        }
        
        return $grouped;
    }
    
    /**
     * Get production data items in correct order
     */
    public function get_production_data_ordered() {
        $order = array('Control Page', 'Count Dashboard', 'Duration Dashboard', 'Overview');
        $data = array();
        
        foreach ($order as $item) {
            $title_item = $this->get_by_title('Production Data - ' . $item);
            $content_item = $this->get_by_title('Production Data - ' . $item . ' Content');
            
            if ($title_item) {
                $data[$item] = array(
                    'title' => $title_item['content'],
                    'image' => $title_item['image'],
                    'content' => $content_item ? $content_item['content'] : ''
                );
            }
        }
        
        return $data;
    }
    
    /**
     * Get features in correct order
     */
    public function get_features_ordered() {
        $order = array(
            'Real-Time Visibility',
            'Wireless Installation', 
            'Scalable',
            'Automated Records',
            'Cost-Effective',
            'Reliable'
        );
        
        $data = array();
        
        foreach ($order as $feature) {
            $title_item = $this->get_by_title('Feature - ' . $feature);
            $content_item = $this->get_by_title('Feature - ' . $feature . ' Content');
            
            if ($title_item) {
                $data[] = array(
                    'title' => $title_item['content'],
                    'content' => $content_item ? $content_item['content'] : ''
                );
            }
        }
        
        return $data;
    }
    
    /**
     * Get content by ID
     */
    public function get_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_iotsolution');
        return $query->row_array();
    }
    
    /**
     * Delete content by ID
     */
    public function delete_content($id) {
        $this->db->where('id', $id);
        return $this->db->delete('tbl_iotsolution');
    }
    
    /**
     * Get content by exact titles (multiple)
     */
    public function get_by_titles($titles) {
        if (empty($titles)) return array();
        
        $this->db->where_in('title', $titles);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('tbl_iotsolution');
        return $query->result_array();
    }
}