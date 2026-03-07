<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class about_us_model extends CI_Model
{
    protected $table = 'tbl_about_us';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get all about us content as key-value pairs
     */
    public function get_about_content()
    {
        $query = $this->db->get($this->table);
        $result = $query->result_array();
        
        // Convert the flat result into a key-value pair array
        $content = array();
        foreach ($result as $row) {
            $content[$row['title']] = array(
                'id'      => $row['id'],
                'content' => $row['content'],
                'image'   => $row['image']
            );
        }
        return $content;
    }
    
    /**
     * Get structured about us data
     */
    public function get_about_data()
    {
        $content = $this->get_about_content();
        $about_data = array();
        
        // Hero section
        $about_data['hero_image'] = isset($content['hero_about_img']['image']) ? $content['hero_about_img']['image'] : 'Hero.jpg';
        
        // Header section
        $about_data['header'] = isset($content['header']['content']) ? $content['header']['content'] : 'Line Seiki Asia Pacific Inc.';
        $about_data['header_text'] = isset($content['header_text']['content']) ? $content['header_text']['content'] : 'Default header text';
        
        // Concept boxes
        $about_data['concepts'] = array();
        for ($i = 1; $i <= 4; $i++) {
            $concept = array(
                'header' => isset($content["concept_header_$i"]['content']) ? $content["concept_header_$i"]['content'] : '',
                'label' => isset($content["concept_label_$i"]['content']) ? $content["concept_label_$i"]['content'] : ''
            );
            $about_data['concepts'][] = $concept;
        }
        
        // Sections (Our Regional Commitment, Collaboration Across Borders, Delivering Reliable Support)
        $about_data['sections'] = array();
        for ($i = 1; $i <= 3; $i++) {
            $section = array(
                'header' => isset($content["section_header_$i"]['content']) ? $content["section_header_$i"]['content'] : '',
                'text' => isset($content["section_text_$i"]['content']) ? $content["section_text_$i"]['content'] : '',
                'image' => isset($content["section_img_$i"]['image']) ? $content["section_img_$i"]['image'] : ''
            );
            $about_data['sections'][] = $section;
        }
        
        // Mission & Vision
        $about_data['mission'] = isset($content['mission']['content']) ? $content['mission']['content'] : 'Default mission';
        $about_data['vision'] = isset($content['vission']['content']) ? $content['vission']['content'] : 'Default vision';
        $about_data['mission_bg'] = isset($content['mission_bg']['image']) ? $content['mission_bg']['image'] : 'm-and-v.jpg';
        
        // Partners
        $about_data['partner_header'] = isset($content['partner_header']['content']) ? $content['partner_header']['content'] : 'Our Valued Partners & Associations';
        $about_data['partner_text'] = isset($content['partner_text']['content']) ? $content['partner_text']['content'] : 'Default partner text';
        
        $about_data['partners'] = array();
        for ($i = 1; $i <= 4; $i++) {
            $partner = array(
                'name' => isset($content["partner_{$i}_name"]['content']) ? $content["partner_{$i}_name"]['content'] : '',
                'logo' => isset($content["partner_logo_$i"]['image']) ? $content["partner_logo_$i"]['image'] : (isset($content["partner_{$i}_img"]['image']) ? $content["partner_{$i}_img"]['image'] : '')
            );
            $about_data['partners'][] = $partner;
        }
        
        return $about_data;
    }
    
    /**
     * Get content by specific title/key
     */
    public function get_by_title($title)
    {
        $this->db->where('title', $title);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }
    
    /**
     * Update content by title/key
     */
    public function update_content($title, $data, $user_id = null)
    {
        $existing = $this->get_by_title($title);
        
        if ($existing) {
            // Update existing
            $update_data = array(
                'content' => $data['content'] ?? '',
                'edited_by' => $user_id,
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            if (isset($data['image'])) {
                $update_data['image'] = $data['image'];
            }
            
            $this->db->where('id', $existing['id']);
            return $this->db->update($this->table, $update_data);
        }
        
        return false;
    }
    
    public function get_all_partners() {
        return $this->db->order_by('id', 'ASC')->get('tbl_partners')->result();
    }
    
    public function get_stats() {
        $this->db->select('*');
        $this->db->from('tbl_stats');
        $this->db->where('is_active', 1);
        $this->db->order_by('stat_order', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
}