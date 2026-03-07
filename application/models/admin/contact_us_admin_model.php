<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class contact_us_admin_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get all contact us content
     */
    public function get_all_content() {
        $this->db->select('*');
        $this->db->from('tbl_contact_us');
        $this->db->where('is_admin', 1);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get content by ID
     */
    public function get_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_contact_us');
        return $query->row_array();
    }
    
    /**
     * Save content (create or update)
     */
    public function save($data, $id = null) {
        if ($id) {
            // Update existing
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->db->where('id', $id);
            return $this->db->update('tbl_contact_us', $data);
        } else {
            // Create new
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            return $this->db->insert('tbl_contact_us', $data);
        }
    }
    
    /**
     * Delete content
     */
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('tbl_contact_us');
    }
}