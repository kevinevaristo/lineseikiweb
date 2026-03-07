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
    public function get_all_safety_switches() {
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('tbl_safety_switches');
        return $query->result();
    }
    
    /**
     * Get safety switch by ID
     */
    public function get_safety_switch($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_safety_switches');
        return $query->row();
    }
}