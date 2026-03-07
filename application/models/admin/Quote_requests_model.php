<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quote_requests_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get all quote requests with pagination
     */
    public function get_all_requests($limit = 50, $offset = 0, $status = 'all', $search = '') {
        $this->db->select('*');
        $this->db->from('tbl_request_quote');
        
        // Filter by status if not 'all'
        if ($status !== 'all') {
            $this->db->where('status', $status);
        }
        
        // Search filter
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('company_name', $search);
            $this->db->or_like('contact_number', $search);
            $this->db->group_end();
        }
        
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Get total count of requests
     */
    public function count_all_requests($status = 'all', $search = '') {
        $this->db->from('tbl_request_quote');
        
        if ($status !== 'all') {
            $this->db->where('status', $status);
        }
        
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('company_name', $search);
            $this->db->or_like('contact_number', $search);
            $this->db->group_end();
        }
        
        return $this->db->count_all_results();
    }
    
    /**
     * Get a single quote request by ID
     */
    public function get_request($id) {
        $query = $this->db->get_where('tbl_request_quote', ['id' => $id]);
        return $query->row();
    }
    
    /**
     * Update request status
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
        return $this->db->update('tbl_request_quote', $data);
    }
    
    /**
     * Update request notes
     */
    public function update_notes($id, $notes) {
        $data = [
            'notes' => $notes,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id', $id);
        return $this->db->update('tbl_request_quote', $data);
    }
    
    /**
     * Delete a quote request
     */
    public function delete_request($id) {
        // Get the request to delete associated file
        $request = $this->get_request($id);
        
        if ($request && !empty($request->file_path)) {
            $file_path = FCPATH . $request->file_path;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        $this->db->where('id', $id);
        return $this->db->delete('tbl_request_quote');
    }
    
    /**
     * Get statistics
     */
    public function get_statistics() {
        $stats = [
            'total' => 0,
            'pending' => 0,
            'reviewed' => 0,
            'contacted' => 0,
            'completed' => 0
        ];
        
        // Get total
        $stats['total'] = $this->db->count_all('tbl_request_quote');
        
        // Get counts by status
        $statuses = ['pending', 'reviewed', 'contacted', 'completed'];
        foreach ($statuses as $status) {
            $this->db->where('status', $status);
            $stats[$status] = $this->db->count_all_results('tbl_request_quote');
        }
        
        return $stats;
    }
    
    /**
     * Get recent requests
     */
    public function get_recent_requests($limit = 10) {
        $this->db->select('*');
        $this->db->from('tbl_request_quote');
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Export requests to CSV
     */
    public function export_to_csv($status = 'all', $search = '') {
        $requests = $this->get_all_requests(10000, 0, $status, $search);
        
        $csv_data = [];
        $csv_data[] = ['ID', 'Name', 'Email', 'Contact Number', 'Company Name', 'Status', 'File Name', 'Notes', 'Created At'];
        
        foreach ($requests as $request) {
            $csv_data[] = [
                $request->id,
                $request->name,
                $request->email,
                $request->contact_number,
                $request->company_name,
                ucfirst($request->status),
                $request->file_name ?: 'No file',
                $request->notes ?: '',
                $request->created_at
            ];
        }
        
        return $csv_data;
    }
}
