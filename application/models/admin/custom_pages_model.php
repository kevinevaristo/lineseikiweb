<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Custom_pages_model extends CI_Model
{
    protected $table = 'tbl_custom_pages';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get all custom pages
     */
    public function get_all_pages()
    {
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get($this->table);
        return $query->result();
    }
    
    /**
     * Get page by ID
     */
    public function get_page_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row();
    }
    
    /**
     * Get page by slug
     */
    public function get_page_by_slug($page)
    {
        $this->db->where('page', $page);
        $query = $this->db->get($this->table);
        return $query->row();
    }
    
    /**
     * Update page content
     */
    public function update_page($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    public function save_page($page_slug, $content)
    {
        // Check if page exists
        $this->db->where('page', $page_slug);
        $query = $this->db->get($this->table);
        $existing = $query->row();
        
        if ($existing) {
            // Update existing
            $data = array(
                'data' => $content,
                'updated_at' => date('Y-m-d H:i:s')
            );
            $this->db->where('page', $page_slug);
            return $this->db->update($this->table, $data);
        } else {
            // Insert new
            $data = array(
                'page' => $page_slug,
                'data' => $content,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            return $this->db->insert($this->table, $data);
        }
    }
    
    /**
     * Create new page
     */
    public function create_page($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->insert($this->table, $data);
    }
    
    /**
     * Delete page
     */
    public function delete_page($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
    
    /**
     * Check if table exists, if not create it
     */
    public function ensure_table_exists()
    {
        if (!$this->db->table_exists($this->table)) {
            $this->db->query("
                CREATE TABLE `{$this->table}` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `page` VARCHAR(100) NOT NULL UNIQUE,
                    `data` LONGTEXT,
                    `created_at` DATETIME,
                    `updated_at` DATETIME
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ");
            
            // Insert default pages
            $default_pages = [
                ['page' => 'privacy_policy', 'data' => NULL],
                ['page' => 'terms_of_service', 'data' => NULL],
                ['page' => 'cookie_policy', 'data' => NULL]
            ];
            
            foreach ($default_pages as $page) {
                $page['created_at'] = date('Y-m-d H:i:s');
                $page['updated_at'] = date('Y-m-d H:i:s');
                $this->db->insert($this->table, $page);
            }
        }
    }
}
