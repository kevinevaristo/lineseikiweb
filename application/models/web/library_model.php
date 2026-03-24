<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class library_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all library items
     */
    public function get_all_items() {
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('tbl_library');
        return $query->result_array();
    }
    
    /**
     * Get item by ID
     */
    public function get_item($id) {
        $query = $this->db->get_where('tbl_library', array('id' => $id));
        return $query->row_array();
    }
    
    /**
     * Get specific items by IDs
     */
    public function get_items_by_ids($ids) {
        $this->db->where_in('id', $ids);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('tbl_library');
        return $query->result_array();
    }
    
    /**
     * Get items with images (videos)
     */
    public function get_items_with_images() {
        $this->db->where('resource_type', 'videos');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('tbl_library');
        return $query->result_array();
    }
    
    /**
     * Get items without images (PDFs)
     */
    public function get_items_without_images() {
        $this->db->where('resource_type', 'brochure');
        $this->db->where('id >', 5); // Exclude first 5 items
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('tbl_library');
        return $query->result_array();
    }
    
    /**
     * Save watch info to database
     */
    public function save_watch_info($data) {
        return $this->db->insert('tbl_watch_info', $data);
    }
    
    /**
     * Get all watch info records
     */
    public function get_all_watch_info() {
        $this->db->order_by('submitted_at', 'DESC');
        $query = $this->db->get('tbl_watch_info');
        return $query->result_array();
    }
    
    /**
     * Get watch info by email
     */
    public function get_watch_info_by_email($email) {
        $this->db->where('email', $email);
        $this->db->order_by('submitted_at', 'DESC');
        $query = $this->db->get('tbl_watch_info');
        return $query->result_array();
    }
    
    /**
     * Get case studies from simulation content
     */
    public function get_case_studies() {
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('tbl_simulation_content');
        return $query->result_array();
    }

    /**
     * Get watch statistics
     */
    public function get_watch_statistics() {
        // Most watched videos
        $this->db->select('video_title, COUNT(*) as watch_count');
        $this->db->where('resource_type', 'video');
        $this->db->where('video_title IS NOT NULL');
        $this->db->group_by('video_title');
        $this->db->order_by('watch_count', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get('tbl_watch_info');
        return $query->result_array();
    }
}