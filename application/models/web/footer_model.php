<?php
// application/models/Footer_model.php
class footer_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_all_footer_data() {
        $data = [];
        
        // Get contact section
        $contact_title = $this->db->get_where('tbl_footer', ['title' => 'contact_section_title'])->row();
        $contact_desc = $this->db->get_where('tbl_footer', ['title' => 'contact_section_description'])->row();
        $footer_logo = $this->db->get_where('tbl_footer', ['title' => 'footer_logo'])->row();
        $copyright = $this->db->get_where('tbl_footer', ['title' => 'copyright'])->row();
        
        // Get menu items
        $this->db->like('title', 'menu_', 'after');
        $menu_items = $this->db->get('tbl_footer')->result();
        
        // Get social media items
        $this->db->like('title', 'social_', 'after');
        $social_items = $this->db->get('tbl_footer')->result();
        
        // Get policy items
        $this->db->like('title', 'policy_', 'after');
        $policy_items = $this->db->get('tbl_footer')->result();
        
        // Organize data
        $data['contact_title'] = $contact_title ? $contact_title->content : 'Get in Touch with Us';
        $data['contact_description'] = $contact_desc ? $contact_desc->content : 'We\'re here to assist with your inquiries and needs.';
        $data['logo'] = $footer_logo ? $footer_logo->image : 'footer_logo.png';
        $data['copyright'] = $copyright ? $copyright->content : '© 2025 Line Seiki Asia Pacific. All rights reserved.';
        $data['menu'] = $menu_items;
        $data['social'] = $social_items;
        $data['policies'] = $policy_items;
        
        return $data;
    }
}
?>