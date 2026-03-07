<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class contact_us_model extends CI_Model {
    
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
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }
    
    /**
     * Get content by title
     */
    public function get_by_title($title) {
        $this->db->where('title', $title);
        $query = $this->db->get('tbl_contact_us');
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    
    /**
     * Get content by ID
     */
    public function get_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_contact_us');
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    
    /**
     * Get specific sections - FIXED VERSION
     */
    public function get_contact_info_cards() {
        $titles = array(
            'Office Address Title', 'Office Address Content',
            'Phone Title', 'Phone Content',
            'Email Title', 'Email Content',
            'Operating Hours Title', 'Operating Hours Content'
        );
        
        $this->db->where_in('title', $titles);
        $query = $this->db->get('tbl_contact_us');
        
        if ($query->num_rows() > 0) {
            $results = $query->result_array();
            
            // Manually order the results
            $ordered_results = array();
            foreach ($titles as $title) {
                foreach ($results as $row) {
                    if ($row['title'] == $title) {
                        $ordered_results[] = $row;
                        break;
                    }
                }
            }
            
            return $ordered_results;
        }
        return array();
    }
    
    /**
     * Alternative method for getting contact info cards (simpler)
     */
    public function get_contact_info_cards_simple() {
        $titles = array(
            'Office Address Title', 'Office Address Content',
            'Phone Title', 'Phone Content',
            'Email Title', 'Email Content',
            'Operating Hours Title', 'Operating Hours Content'
        );
        
        $this->db->where_in('title', $titles);
        $query = $this->db->get('tbl_contact_us');
        
        return $query->result_array();
    }
    
    /**
     * Update content
     */
    public function update_content($id, $data) {
        $this->db->where('id', $id);
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->update('tbl_contact_us', $data);
    }
}