<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class simulation_model extends CI_Model
{
    protected $table = 'tbl_simulation';
    protected $table1 = 'tbl_benefits';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_all_benefits() {
        $query = $this->db->get($this->table1);
        return $query->result_array(); // returns array of rows
    }
    
    public function get_content_by_id($id) {
        $query = $this->db->get_where('tbl_simulation_content', array('id' => $id));
        return $query->row();
    }
    
    public function get_count() {
        return $this->db->count_all('tbl_simulation_content');
    }
    
    public function get_simulation_content()
    {
        $query = $this->db->get($this->table);
        $result = $query->result_array();
        
        // Convert to key-value pairs
        $content = array();
        foreach ($result as $row) {
            $content[$row['title']] = array(
                'id' => $row['id'],
                'content' => $row['content'],
                'image' => $row['image']
            );
        }
        return $content;
    }
    
    public function get_all_capabilities() {
        $this->db->order_by('sort_order', 'ASC');
        $capabilities = $this->db->get_where('tbl_capabilities', ['is_active' => 1])->result();
        
        foreach ($capabilities as $capability) {
            $capability->items = $this->get_capability_items($capability->id);
        }
        
        return $capabilities;
    }
    
    public function get_capability_items($capability_id) {
        $this->db->order_by('sort_order', 'ASC');
        return $this->db->get_where('tbl_capability_items', [
            'capability_id' => $capability_id,
            'is_active' => 1
        ])->result();
    }
    
    public function get_carousel_items()
    {
        $this->db->order_by('id', 'ASC');
        
        return $this->db->get('tbl_simulation_content')->result();
    }
    
    public function get_carousel_item($id)
    {
        return $this->db->get_where('tbl_simulation_carousel', ['id' => $id])->row();
    }

    public function get_other_capabilities()
    {
        $this->db->where('is_active', 1);
        $this->db->order_by('sort_order', 'ASC');
        $results = $this->db->get('tbl_other_capabilities')->result();

        $grouped = [];
        foreach ($results as $row) {
            $grouped[$row->category][] = $row;
        }
        return $grouped;
    }

    public function get_capability_category_settings()
    {
        $this->db->order_by('sort_order', 'ASC');
        $results = $this->db->get('tbl_other_capability_categories')->result();
        $settings = [];
        foreach ($results as $row) {
            $settings[$row->category] = $row;
        }
        return $settings;
    }
}