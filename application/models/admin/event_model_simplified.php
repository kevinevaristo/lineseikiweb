<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Simplified Event Model
 * Clean, streamlined database operations for events
 */
class Event_model_simplified extends CI_Model {
    
    private $table = 'tbl_events';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    // ========================================
    // GET METHODS
    // ========================================
    
    /**
     * Get all active events
     */
    public function get_all($limit = null, $offset = 0) {
        $this->db->where('deleted_at IS NULL', null, false);
        $this->db->order_by('event_date', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Get single event by ID
     */
    public function get_by_id($id) {
        return $this->db->where('id', $id)
                        ->where('deleted_at IS NULL', null, false)
                        ->get($this->table)
                        ->row_array();
    }
    
    /**
     * Get events by category
     */
    public function get_by_category($category, $limit = null) {
        $this->db->where('category', $category)
                 ->where('deleted_at IS NULL', null, false)
                 ->order_by('event_date', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit);
        }
        
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Get featured events
     */
    public function get_featured($limit = 3) {
        return $this->db->where('is_featured', 1)
                        ->where('status', 'active')
                        ->where('deleted_at IS NULL', null, false)
                        ->order_by('event_date', 'DESC')
                        ->limit($limit)
                        ->get($this->table)
                        ->result_array();
    }
    
    // ========================================
    // COUNT METHODS
    // ========================================
    
    /**
     * Count total events
     */
    public function count_all() {
        return $this->db->where('deleted_at IS NULL', null, false)
                        ->count_all_results($this->table);
    }
    
    /**
     * Count by status
     */
    public function count_by_status($status) {
        return $this->db->where('status', $status)
                        ->where('deleted_at IS NULL', null, false)
                        ->count_all_results($this->table);
    }
    
    /**
     * Count featured
     */
    public function count_featured() {
        return $this->db->where('is_featured', 1)
                        ->where('deleted_at IS NULL', null, false)
                        ->count_all_results($this->table);
    }
    
    /**
     * Count upcoming events
     */
    public function count_upcoming() {
        return $this->db->where('event_date >=', date('Y-m-d'))
                        ->where('deleted_at IS NULL', null, false)
                        ->count_all_results($this->table);
    }
    
    // ========================================
    // CRUD OPERATIONS
    // ========================================
    
    /**
     * Create new event
     */
    public function create($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->insert($this->table, $data);
    }
    
    /**
     * Update event
     */
    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->where('id', $id)
                        ->update($this->table, $data);
    }
    
    /**
     * Soft delete event
     */
    public function delete($id) {
        return $this->db->where('id', $id)
                        ->update($this->table, [
                            'deleted_at' => date('Y-m-d H:i:s'),
                            'status' => 'inactive'
                        ]);
    }
    
    /**
     * Toggle status
     */
    public function toggle_status($id) {
        $event = $this->get_by_id($id);
        if (!$event) return false;
        
        $new_status = $event['status'] == 'active' ? 'inactive' : 'active';
        
        return $this->update($id, ['status' => $new_status]);
    }
    
    // ========================================
    // UTILITY METHODS
    // ========================================
    
    /**
     * Search events
     */
    public function search($keyword) {
        return $this->db->like('title', $keyword)
                        ->or_like('content', $keyword)
                        ->where('deleted_at IS NULL', null, false)
                        ->order_by('event_date', 'DESC')
                        ->get($this->table)
                        ->result_array();
    }
    
    /**
     * Check if slug exists
     */
    public function slug_exists($slug, $exclude_id = null) {
        $this->db->where('slug', $slug);
        
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        
        return $this->db->count_all_results($this->table) > 0;
    }
}
