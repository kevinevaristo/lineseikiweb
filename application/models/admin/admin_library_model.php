<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin_library_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all library items for admin
     */
    public function get_all_items() {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('tbl_library');
        return $query->result_array();
    }
    
    /**
     * Get item by ID
     */
    public function get_item($id) {
        $query = $this->db->get_where('tbl_library', array('id' => $id));
        return $query->row_array();
    }
    
    /**
     * Count total videos
     */
    public function count_videos() {
        $this->db->where("(image IS NOT NULL OR content LIKE '%Watch%')");
        return $this->db->count_all_results('tbl_library');
    }
    
    /**
     * Count total PDFs
     */
    public function count_pdfs() {
        $this->db->like('content', 'Download PDF');
        return $this->db->count_all_results('tbl_library');
    }
    
    /**
     * Count total items
     */
    public function count_all() {
        return $this->db->count_all('tbl_library');
    }
    
    /**
     * Get featured resource (ID 2)
     */
    public function get_featured_resource() {
        $query = $this->db->get_where('tbl_library', array('id' => 2));
        return $query->row_array();
    }
    
    /**
     * Create new resource
     */
    public function create_resource($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('tbl_library', $data);
    }
    
    /**
     * Update resource
     */
    public function update_resource($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('tbl_library', $data);
    }
    
    /**
     * Delete resource
     */
    public function delete_resource($id) {
        $this->db->where('id', $id);
        return $this->db->delete('tbl_library');
    }
    
    // ==================== WEBINAR METHODS ====================

    /**
     * Get all webinars
     */
    public function get_all_webinars() {
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('tbl_webinar');
        return $query->result_array();
    }

    /**
     * Get webinar by ID
     */
    public function get_webinar($id) {
        $query = $this->db->get_where('tbl_webinar', array('id' => $id));
        return $query->row_array();
    }

    /**
     * Create new webinar
     */
    public function create_webinar($data) {
        $this->db->insert('tbl_webinar', $data);
        return $this->db->insert_id();
    }

    /**
     * Update webinar
     */
    public function update_webinar($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tbl_webinar', $data);
    }

    /**
     * Delete webinar
     */
    public function delete_webinar($id) {
        // First remove webinar_id from all library items linked to this webinar
        $this->db->where('webinar_id', $id);
        $this->db->update('tbl_library', array('webinar_id' => NULL));
        // Then delete the webinar
        $this->db->where('id', $id);
        return $this->db->delete('tbl_webinar');
    }

    /**
     * Count webinars
     */
    public function count_webinars() {
        return $this->db->count_all('tbl_webinar');
    }

    /**
     * Search resources
     */
    public function search_resources($keyword) {
        $this->db->like('title', $keyword);
        $this->db->or_like('content', $keyword);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('tbl_library');
        return $query->result_array();
    }
    
    /**
     * Get items by type
     */
    public function get_items_by_type($type) 
    {
        $this->db->where('resource_type', $type);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('tbl_library');
        return $query->result_array();
    }
     public function upload_image($file_input_name) {
        $config['upload_path'] = './assets_system/images/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;
        
        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload($file_input_name)) {
            return array('error' => $this->upload->display_errors());
        } else {
            return array('success' => $this->upload->data());
        }
    }
    
    /**
     * Upload PDF file
     */
    public function upload_pdf($file_input_name) {
        $config['upload_path'] = './assets_system/documents/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 5120; // 5MB
        $config['encrypt_name'] = FALSE; // Keep original name for easy reference
        $config['file_name'] = $this->generate_pdf_filename();
        
        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload($file_input_name)) {
            return array('error' => $this->upload->display_errors());
        } else {
            return array('success' => $this->upload->data());
        }
    }
    
    /**
     * Generate clean PDF filename
     */
    private function generate_pdf_filename() {
        return 'document_' . date('Ymd_His') . '.pdf';
    }
}