<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin_library_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        // Auto-add is_featured column if it doesn't exist
        if (!$this->db->field_exists('is_featured', 'tbl_webinar')) {
            $this->load->dbforge();
            $this->dbforge->add_column('tbl_webinar', array(
                'is_featured' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0, 'after' => 'description_2')
            ));
            // Set the first webinar as featured by default
            $first = $this->db->order_by('id', 'ASC')->limit(1)->get('tbl_webinar')->row();
            if ($first) {
                $this->db->where('id', $first->id)->update('tbl_webinar', array('is_featured' => 1));
            }
        }
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
     * Get all featured webinars (returns array of webinars)
     */
    public function get_featured_webinars() {
        $this->db->where('is_featured', 1);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('tbl_webinar');
        $result = $query->result_array();
        // Fallback to first webinar if none is featured
        if (empty($result)) {
            $first = $this->db->order_by('id', 'ASC')->limit(1)->get('tbl_webinar')->row_array();
            if ($first) {
                $result = array($first);
            }
        }
        return $result;
    }

    /**
     * Toggle featured status of a webinar (on/off)
     */
    public function toggle_featured_webinar($id) {
        $webinar = $this->get_webinar($id);
        if ($webinar) {
            $new_status = (isset($webinar['is_featured']) && $webinar['is_featured'] == 1) ? 0 : 1;
            $this->db->where('id', $id);
            return $this->db->update('tbl_webinar', array('is_featured' => $new_status));
        }
        return false;
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
        $upload_path = FCPATH . 'assets_system/images/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload');
        $this->upload->initialize($config);

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
        $upload_path = FCPATH . 'assets_system/documents/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 5120; // 5MB
        $config['encrypt_name'] = FALSE; // Keep original name for easy reference
        $config['file_name'] = $this->generate_pdf_filename();

        $this->load->library('upload');
        $this->upload->initialize($config);

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