<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class privacy_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        // Load database if not autoloaded
        $this->load->database();
    }

    /**
     * Get all privacy policy content
     * @return array Privacy policy data
     */
    public function get_all_privacy_policy() {
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('tbl_privacy_policy');
        return $query->result_array();
    }

    /**
     * Get specific privacy policy by ID
     * @param int $id Privacy policy ID
     * @return array Privacy policy data
     */
    public function get_privacy_policy($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_privacy_policy');
        return $query->row_array();
    }

    /**
     * Get privacy policy by title (exact match)
     * @param string $title Privacy policy title
     * @return array Privacy policy data
     */
    public function get_privacy_by_title($title) {
        $this->db->where('title', $title);
        $query = $this->db->get('tbl_privacy_policy');
        return $query->row_array();
    }

    /**
     * Get all sections grouped by main sections
     * @return array Grouped privacy policy data
     */
    public function get_privacy_sections() {
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('tbl_privacy_policy');
        $results = $query->result_array();
        
        // Group sections if needed (for example purposes)
        $grouped = [];
        foreach ($results as $item) {
            $grouped[] = $item;
        }
        
        return $grouped;
    }
}
?>