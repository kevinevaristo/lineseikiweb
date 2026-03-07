<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial_model extends CI_Model {
    
    protected $table = 'tbl_testimonial';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get all active testimonials
     * 
     * @param int $limit Optional limit for number of testimonials
     * @return array Array of testimonial objects
     */
    public function get_all_testimonials($limit = null) {
        $this->db->where('is_active', 1);
        $this->db->order_by('sort_order', 'ASC');
        $this->db->order_by('created_at', 'DESC');
        
        if ($limit !== null) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get($this->table);
        return $query->result();
    }
    
    /**
     * Get a single testimonial by ID
     * 
     * @param int $id Testimonial ID
     * @return object|null Testimonial object or null if not found
     */
    public function get_testimonial($id) {
        $this->db->where('id', $id);
        
        $query = $this->db->get($this->table);
        
        return $query->row();
    }
    
    public function get_all_testimonial($limit = null) {
        $this->db->order_by('sort_order', 'ASC');
        $this->db->order_by('created_at', 'DESC');
        
        if ($limit !== null) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get($this->table);
        return $query->result();
    }
    
    /**
     * Insert a new testimonial
     * 
     * @param array $data Testimonial data
     * @return int|bool Inserted ID or false on failure
     */
    public function insert_testimonial($data) {
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }
    
    /**
     * Update an existing testimonial
     * 
     * @param int $id Testimonial ID
     * @param array $data Updated data
     * @return bool True on success, false on failure
     */
    public function update_testimonial($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Delete a testimonial (soft delete by setting is_active to 0)
     * 
     * @param int $id Testimonial ID
     * @return bool True on success, false on failure
     */
    public function delete_testimonial($id) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, ['is_active' => 0]);
    }
    
    /**
     * Hard delete a testimonial from database
     * 
     * @param int $id Testimonial ID
     * @return bool True on success, false on failure
     */
    public function hard_delete_testimonial($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
    
    /**
     * Count total testimonials
     * 
     * @param bool $active_only Count only active testimonials
     * @return int Total count
     */
    public function count_testimonials($active_only = true) {
        if ($active_only) {
            $this->db->where('is_active', 1);
        }
        return $this->db->count_all_results($this->table);
    }
    
    /**
     * Get testimonials with pagination
     * 
     * @param int $limit Number of records per page
     * @param int $offset Offset for pagination
     * @return array Array of testimonial objects
     */
    public function get_testimonials_paginated($limit, $offset) {
        $this->db->where('is_active', 1);
        $this->db->order_by('sort_order', 'ASC');
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get($this->table);
        return $query->result();
    }
    
    /**
     * Update sort order for testimonials
     * 
     * @param array $orders Array of id => sort_order pairs
     * @return bool True on success, false on failure
     */
    public function update_sort_order($orders) {
        $this->db->trans_start();
        
        foreach ($orders as $id => $sort_order) {
            $this->db->where('id', $id);
            $this->db->update($this->table, ['sort_order' => $sort_order]);
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    /**
     * Get random testimonials
     * 
     * @param int $limit Number of random testimonials to fetch
     * @return array Array of testimonial objects
     */
    public function get_random_testimonials($limit = 3) {
        $this->db->where('is_active', 1);
        $this->db->order_by('RAND()');
        $this->db->limit($limit);
        
        $query = $this->db->get($this->table);
        return $query->result();
    }
    
    /**
     * Check if testimonial table exists
     * 
     * @return bool True if table exists, false otherwise
     */
    public function table_exists() {
        return $this->db->table_exists($this->table);
    }
    
    /**
     * Get table field information
     * 
     * @return array Array of field metadata objects
     */
    public function get_table_fields() {
        return $this->db->getFieldData($this->table);
    }
}