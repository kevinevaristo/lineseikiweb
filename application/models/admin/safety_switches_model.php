<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class safety_switches_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get all safety switches
     */
    public function get_all_switches() {
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('tbl_safety_switches');
        return $query->result();
    }
    
    /**
     * Get safety switch by ID
     */
    public function get_switch($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_safety_switches');
        return $query->row();
    }
    
    /**
     * Create new safety switch
     */
    public function create_switch($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('tbl_safety_switches', $data);
    }
    
    /**
     * Update safety switch
     */
    public function update_switch($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('tbl_safety_switches', $data);
    }
    
    /**
     * Delete safety switch
     */
    public function delete_switch($id) {
        $this->db->where('id', $id);
        return $this->db->delete('tbl_safety_switches');
    }
    
    /**
     * Check if image exists
     */
    public function get_image_path($id) {
        $this->db->select('image');
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_safety_switches');
        $result = $query->row();
        return $result ? $result->image : null;
    }
}