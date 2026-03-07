<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class event_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get all events
     */
    public function get_all_events($limit = null, $offset = 0, $category = null) {
        $this->db->select('*');
        $this->db->from('tbl_events');
        $this->db->where('status', 'active');
        $this->db->where('deleted_at IS NULL', null, false);
        
        if ($category && $category !== 'all') {
            $this->db->where('category', $category);
        }
        
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get featured events
     */
    public function get_featured_events($limit = 1) {
        $this->db->select('*');
        $this->db->from('tbl_events');
        $this->db->where('status', 'active');
        $this->db->where('is_featured', 1);
        $this->db->where('deleted_at IS NULL', null, false);
        $this->db->order_by('event_date', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get event by ID
     */
    public function get_event_by_id($id) {
        $this->db->select('*');
        $this->db->from('tbl_events');
        $this->db->where('id', $id);
        $this->db->where('status', 'active');
        $this->db->where('deleted_at IS NULL', null, false);
        
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /**
     * Get event by slug or other identifier
     * Since we don't have a slug column, we'll search by title
     */
    public function get_event_by_title($title) {
        $this->db->select('*');
        $this->db->from('tbl_events');
        $this->db->where('title', $title);
        $this->db->where('status', 'active');
        $this->db->where('deleted_at IS NULL', null, false);
        
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /**
     * Get total count of events
     */
    public function get_total_events($category = null) {
        $this->db->from('tbl_events');
        $this->db->where('status', 'active');
        $this->db->where('deleted_at IS NULL', null, false);
        
        if ($category && $category !== 'all') {
            $this->db->where('category', $category);
        }
        
        return $this->db->count_all_results();
    }
    
    /**
     * Get events by category
     */
    public function get_events_by_category($category, $limit = null, $offset = 0) {
        $this->db->select('*');
        $this->db->from('tbl_events');
        $this->db->where('category', $category);
        $this->db->where('status', 'active');
        $this->db->where('deleted_at IS NULL', null, false);
        $this->db->order_by('event_date', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
      public function save_event($data) {
        return $this->db->insert('tbl_events', $data);
    }
    
    /**
     * Update existing event
     */
    public function update_event($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tbl_events', $data);
    }
    
    /**
     * Get events for admin (including inactive)
     */
    public function get_admin_events($limit = null, $offset = 0, $category = null) {
        $this->db->select('*');
        $this->db->from('tbl_events');
        $this->db->where('deleted_at IS NULL', null, false);
        
        if ($category && $category !== 'all') {
            $this->db->where('category', $category);
        }
        
        $this->db->order_by('event_date', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get total count for admin
     */
    public function get_admin_total_events($category = null) {
        $this->db->from('tbl_events');
        $this->db->where('deleted_at IS NULL', null, false);
        
        if ($category && $category !== 'all') {
            $this->db->where('category', $category);
        }
        
        return $this->db->count_all_results();
    }
    
    /**
     * Permanently delete event
     */
    public function permanent_delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('tbl_events');
    }
    
    /**
     * Get categories with counts
     */
    public function get_categories_with_counts() {
        $sql = "SELECT category, COUNT(*) as count 
                FROM tbl_events 
                WHERE deleted_at IS NULL 
                GROUP BY category 
                ORDER BY category";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
?>