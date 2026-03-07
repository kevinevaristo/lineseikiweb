<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model {

    protected $table = 'tbl_emails';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Insert new email subscription
     */
    public function insert($data) {
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    /**
     * Update email subscription
     */
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Get email by email address
     */
    public function get_by_email($email) {
        return $this->db->get_where($this->table, ['email' => $email])->row();
    }

    /**
     * Get email by ID
     */
    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    /**
     * Get all active subscribers
     */
    public function get_active_subscribers() {
        return $this->db->get_where($this->table, ['status' => 'active'])->result();
    }

    /**
     * Count active subscribers
     */
    public function count_active() {
        return $this->db->where('status', 'active')->count_all_results($this->table);
    }

    /**
     * Count total subscribers
     */
    public function count_all() {
        return $this->db->count_all($this->table);
    }

    /**
     * Get subscribers with pagination (for admin)
     */
    public function get_subscribers($limit, $offset, $status = null) {
        if ($status) {
            $this->db->where('status', $status);
        }
        $this->db->order_by('subscribed_at', 'DESC');
        return $this->db->get($this->table, $limit, $offset)->result();
    }

    /**
     * Delete subscriber (hard delete - use with caution)
     */
    public function delete($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    /**
     * Soft delete (unsubscribe)
     */
    public function unsubscribe($id) {
        $data = [
            'status' => 'unsubscribed',
            'unsubscribed_at' => date('Y-m-d H:i:s')
        ];
        return $this->update($id, $data);
    }

    /**
     * Get subscribers by date range
     */
    public function get_by_date_range($start_date, $end_date) {
        $this->db->where('subscribed_at >=', $start_date);
        $this->db->where('subscribed_at <=', $end_date);
        $this->db->order_by('subscribed_at', 'DESC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Export subscribers (for admin)
     */
    public function export_subscribers($status = 'active') {
        $this->db->select('email, subscribed_at, status');
        if ($status) {
            $this->db->where('status', $status);
        }
        $this->db->order_by('subscribed_at', 'DESC');
        return $this->db->get($this->table)->result();
    }
    
    // Add to Email_model.php

/**
 * Count subscribers by status
 */
public function count_by_status($status) {
    return $this->db->where('status', $status)->count_all_results($this->table);
}

/**
 * Count today's subscribers
 */
public function count_today() {
    $today = date('Y-m-d');
    $this->db->where('DATE(subscribed_at)', $today);
    return $this->db->count_all_results($this->table);
}

/**
 * Get recent subscribers
 */
public function get_recent($limit = 5) {
    $this->db->order_by('subscribed_at', 'DESC');
    $this->db->limit($limit);
    return $this->db->get($this->table)->result();
}

/**
 * Get all subscribers
 */
public function get_all() {
    $this->db->order_by('subscribed_at', 'DESC');
    return $this->db->get($this->table)->result();
}
}