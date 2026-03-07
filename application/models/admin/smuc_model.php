<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class smuc_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get all SMUC content with titles as keys
     */
    public function get_all_content() {
        $query = $this->db->get('tbl_smuc');
        $result = array();
        
        foreach ($query->result() as $row) {
            $result[$row->title] = array(
                'id' => $row->id,
                'title' => $row->title,
                'content' => $row->content,
                'image' => $row->image
            );
        }
        
        return $result;
    }
    
    /**
     * Get content by title
     */
    public function get_by_title($title) {
        $this->db->where('title', $title);
        $query = $this->db->get('tbl_smuc');
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        
        return null;
    }
    
    /**
     * Update content by title
     */
    public function update_by_title($title, $data) {
        $this->db->where('title', $title);
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->update('tbl_smuc', $data);
    }
    
    /**
     * Update content by ID
     */
    public function update_by_id($id, $data) {
        $this->db->where('id', $id);
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->update('tbl_smuc', $data);
    }
    
    /**
     * Update multiple fields
     */
    public function update_multiple($updates) {
        $this->db->trans_start();
        
        foreach ($updates as $field_name => $data) {
            $this->db->where('title', $field_name);
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->db->update('tbl_smuc', $data);
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    public function get_section_features($section_type)
{
    $this->db->like('title', $section_type . '_feature_', 'after');
    $this->db->order_by('title', 'ASC');
    return $this->db->get('tbl_smuc')->result();
}

public function update_feature($id, $data)
{
    $this->db->where('id', $id);
    return $this->db->update('tbl_smuc', $data);
}

public function insert_feature($data)
{
    return $this->db->insert('tbl_smuc', $data);
}

public function delete_feature($id)
{
    $this->db->where('id', $id);
    return $this->db->delete('tbl_smuc');
}
    
    public function get_all($type = 'urethane_parts') {
        $this->db->where('type', $type);
        $this->db->order_by('position', 'ASC');
        return $this->db->get('tbl_gallery')->result();
    }
    
    // Get gallery item by ID
    public function get_by_id($id) {
        return $this->db->get_where('tbl_gallery', ['id' => $id])->row();
    }
    
    // Add new gallery item
    public function add($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('tbl_gallery', $data);
    }
    
    // Update gallery item
    public function update($id, $data) {
        $this->db->where('id', $id);
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->update('tbl_gallery', $data);
    }
    
    // Delete gallery item
    public function delete_gallery_item($id) {
        $this->db->where('id', $id);
        return $this->db->delete('tbl_gallery');
    }
    
    
    // Get max position for a type
    public function get_max_position($type) {
        $this->db->select_max('position');
        $this->db->where('type', $type);
        $result = $this->db->get('tbl_gallery')->row();
        return $result->position ? $result->position : 0;
    }
    
}