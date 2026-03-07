<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Contact Message Model
 * Handles database operations for contact form submissions
 */
class Contact_message_model extends CI_Model {
    
    private $table = 'tbl_send_us_message';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Insert a new contact message
     * @param array $data Message data
     * @return int|bool Insert ID on success, FALSE on failure
     */
    public function insert_message($data) {
        $insert_data = [
            'name' => $data['name'],
            'email' => $data['email'],
            'subject' => $data['subject'],
            'message' => $data['message'],
            'ip_address' => isset($data['ip_address']) ? $data['ip_address'] : null,
            'user_agent' => isset($data['user_agent']) ? $data['user_agent'] : null,
            'status' => 'new',
            'submitted_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert($this->table, $insert_data);
        
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        
        return false;
    }
    
    /**
     * Get all messages with optional filtering
     * @param int $limit Number of records to return
     * @param int $offset Offset for pagination
     * @param string $status Filter by status (all, new, read, replied, archived)
     * @param string $search Search term
     * @return array Array of message objects
     */
    public function get_all_messages($limit = 50, $offset = 0, $status = 'all', $search = '') {
        $this->db->select('*');
        $this->db->from($this->table);
        
        // Filter by status
        if ($status !== 'all') {
            $this->db->where('status', $status);
        }
        
        // Search filter
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('subject', $search);
            $this->db->or_like('message', $search);
            $this->db->group_end();
        }
        
        $this->db->order_by('submitted_at', 'DESC');
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Get total count of messages
     * @param string $status Filter by status
     * @param string $search Search term
     * @return int Total count
     */
    public function count_all_messages($status = 'all', $search = '') {
        $this->db->from($this->table);
        
        if ($status !== 'all') {
            $this->db->where('status', $status);
        }
        
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('subject', $search);
            $this->db->or_like('message', $search);
            $this->db->group_end();
        }
        
        return $this->db->count_all_results();
    }
    
    /**
     * Get a single message by ID
     * @param int $id Message ID
     * @return object|null Message object or null
     */
    public function get_message($id) {
        $query = $this->db->get_where($this->table, ['id' => $id]);
        return $query->row();
    }
    
    /**
     * Update message status
     * @param int $id Message ID
     * @param string $status New status
     * @param string|null $notes Optional notes
     * @return bool Success status
     */
    public function update_status($id, $status, $notes = null) {
        $data = [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        if ($notes !== null) {
            $data['notes'] = $notes;
        }
        
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Update message notes
     * @param int $id Message ID
     * @param string $notes Notes content
     * @return bool Success status
     */
    public function update_notes($id, $notes) {
        $data = [
            'notes' => $notes,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Delete a message
     * @param int $id Message ID
     * @return bool Success status
     */
    public function delete_message($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
    
    /**
     * Get message statistics
     * @return array Statistics array
     */
    public function get_statistics() {
        $stats = [
            'total' => 0,
            'new' => 0,
            'read' => 0,
            'replied' => 0,
            'archived' => 0
        ];
        
        // Get total
        $stats['total'] = $this->db->count_all($this->table);
        
        // Get counts by status
        $statuses = ['new', 'read', 'replied', 'archived'];
        foreach ($statuses as $status) {
            $this->db->where('status', $status);
            $stats[$status] = $this->db->count_all_results($this->table);
        }
        
        return $stats;
    }
    
    /**
     * Get recent messages
     * @param int $limit Number of messages to return
     * @return array Array of message objects
     */
    public function get_recent_messages($limit = 10) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('submitted_at', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Mark message as read
     * @param int $id Message ID
     * @return bool Success status
     */
    public function mark_as_read($id) {
        return $this->update_status($id, 'read');
    }
    
    /**
     * Mark message as replied
     * @param int $id Message ID
     * @param string|null $notes Reply notes
     * @return bool Success status
     */
    public function mark_as_replied($id, $notes = null) {
        return $this->update_status($id, 'replied', $notes);
    }
    
    /**
     * Archive a message
     * @param int $id Message ID
     * @return bool Success status
     */
    public function archive_message($id) {
        return $this->update_status($id, 'archived');
    }
    
    /**
     * Get messages by email address
     * @param string $email Email address
     * @param int $limit Number of records to return
     * @return array Array of message objects
     */
    public function get_messages_by_email($email, $limit = 10) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('email', $email);
        $this->db->order_by('submitted_at', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result();
    }
}
