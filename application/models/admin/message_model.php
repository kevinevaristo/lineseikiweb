<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message_model extends CI_Model {
    
    private $table = 'tbl_send_us_message';
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all messages with most important columns
     */
    public function get_all_messages() {
        $this->db->select('id, name, email, subject, status, submitted_at');
        $this->db->from($this->table);
        $this->db->order_by('submitted_at', 'DESC');
        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
     * Get message statistics for dashboard
     */
    public function get_statistics() {
        $stats = array();
        
        // Total messages
        $stats['total'] = $this->db->count_all($this->table);
        
        // New messages
        $this->db->where('status', 'new');
        $stats['new'] = $this->db->count_all_results($this->table);
        
        // Read messages
        $this->db->where('status', 'read');
        $stats['read'] = $this->db->count_all_results($this->table);
        
        // Replied messages
        $this->db->where('status', 'replied');
        $stats['replied'] = $this->db->count_all_results($this->table);
        
        // Archived messages
        $this->db->where('status', 'archived');
        $stats['archived'] = $this->db->count_all_results($this->table);
        
        // Today's messages
        $this->db->where('DATE(submitted_at)', 'CURDATE()', false);
        $stats['today'] = $this->db->count_all_results($this->table);
        
        return $stats;
    }
    
    /**
     * Get single message details
     */
    public function get_message($id) {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        
        return $query->row();
    }
    
    /**
     * Update message status
     */
    public function update_status($id, $status) {
        $data = array(
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Update message notes
     */
    public function update_notes($id, $notes) {
        $data = array(
            'notes' => $notes,
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Get recent messages for dashboard
     */
    public function get_recent_messages($limit = 5) {
        $this->db->select('id, name, email, subject, status, submitted_at');
        $this->db->from($this->table);
        $this->db->order_by('submitted_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        
        return $query->result();
    }
}