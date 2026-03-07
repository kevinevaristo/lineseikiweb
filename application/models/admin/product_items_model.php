<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_items_model extends CI_Model
{
    protected $table = 'tbl_product_items';
    protected $types_table = 'tbl_product_types';
    protected $category_table = 'tbl_product_category';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get all product items with category and type information
     */
    public function get_all_items($category_id = null, $type = null)
    {
        $this->db->select('tbl_product_items.*, 
                          tbl_product_category.category_name,
                          tbl_product_types.type_name as type_name');
        $this->db->from($this->table);
        $this->db->join($this->category_table, 
                       'tbl_product_items.product_category = tbl_product_category.id', 
                       'left');
        $this->db->join($this->types_table, 
                       'tbl_product_items.product_type = tbl_product_types.id', 
                       'left');
        
        if ($category_id) {
            $this->db->where('tbl_product_items.product_category', $category_id);
        }
        
        if ($type) {
            $this->db->where('tbl_product_items.product_type', $type);
        }
        
        $this->db->order_by('tbl_product_items.id', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Get single product item by ID
     */
    public function get_item($id)
    {
        $this->db->select('tbl_product_items.*, 
                          tbl_product_category.category_name,
                          tbl_product_types.type_name as type_name');
        $this->db->from($this->table);
        $this->db->join($this->category_table, 
                       'tbl_product_items.product_category = tbl_product_category.id', 
                       'left');
        $this->db->join($this->types_table, 
                       'tbl_product_items.product_type = tbl_product_types.id', 
                       'left');
        $this->db->where('tbl_product_items.id', $id);
        
        $query = $this->db->get();
        return $query->row();
    }
    
    /**
     * Add new product item
     */
    public function add_item($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Update product item
     */
    public function update_item($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }
    
    /**
     * Delete product item
     */
    public function delete_item($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }
    
    /**
     * Get product types for a category
     */
    public function get_types_by_category($category_id)
    {
        $this->db->where('product_category', $category_id);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get($this->types_table);
        return $query->result();
    }
    
    /**
     * Get all product types
     */
    public function get_all_types()
    {
        $this->db->select('tbl_product_types.*, tbl_product_category.category_name');
        $this->db->from($this->types_table);
        $this->db->join($this->category_table, 
                       'tbl_product_types.product_category = tbl_product_category.id', 
                       'left');
        $this->db->order_by('tbl_product_types.id', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_types_by_category($category_id = null)
    {
        if ($category_id) {
            return $this->get_types_by_category($category_id);
        }
        
        $this->db->select('tbl_product_types.*, tbl_product_category.category_name');
        $this->db->from($this->types_table);
        $this->db->join($this->category_table, 
                    'tbl_product_types.product_category = tbl_product_category.id', 
                    'left');
        $this->db->order_by('tbl_product_types.id', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Add product type
     */
    public function add_type($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert($this->types_table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Update product type
     */
    public function update_type($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        $this->db->update($this->types_table, $data);
        return $this->db->affected_rows();
    }
    
    /**
     * Delete product type
     */
    public function delete_type($id)
    {
        // First check if there are items using this type
        $this->db->where('product_type', $id);
        $count = $this->db->count_all_results($this->table);
        
        if ($count > 0) {
            return false; // Cannot delete, items exist
        }
        
        $this->db->where('id', $id);
        $this->db->delete($this->types_table);
        return $this->db->affected_rows();
    }
    
    /**
     * Count items by category
     */
    public function count_by_category($category_id)
    {
        $this->db->where('product_category', $category_id);
        return $this->db->count_all_results($this->table);
    }
    
    /**
     * Count items by type
     */
    public function count_by_type($type_id)
    {
        $this->db->where('product_type', $type_id);
        return $this->db->count_all_results($this->table);
    }
    
    /**
     * Get categories with item counts
     */
    public function get_categories_with_counts()
    {
        $this->db->select('tbl_product_category.*, 
                          COUNT(tbl_product_items.id) as item_count');
        $this->db->from($this->category_table);
        $this->db->join($this->table, 
                       'tbl_product_category.id = tbl_product_items.product_category', 
                       'left');
        $this->db->group_by('tbl_product_category.id');
        $this->db->order_by('tbl_product_category.id', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Get types with item counts for a category
     */
    public function get_types_with_counts($category_id)
    {
        $this->db->select('tbl_product_types.*, 
                          COUNT(tbl_product_items.id) as item_count');
        $this->db->from($this->types_table);
        $this->db->join($this->table, 
                       'tbl_product_types.id = tbl_product_items.product_type', 
                       'left');
        $this->db->where('tbl_product_types.product_category', $category_id);
        $this->db->group_by('tbl_product_types.id');
        $this->db->order_by('tbl_product_types.id', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Search product items
     */
    public function search_items($keyword, $category_id = null, $type_id = null)
    {
        $this->db->select('tbl_product_items.*, 
                          tbl_product_category.category_name,
                          tbl_product_types.type_name as type_name');
        $this->db->from($this->table);
        $this->db->join($this->category_table, 
                       'tbl_product_items.product_category = tbl_product_category.id', 
                       'left');
        $this->db->join($this->types_table, 
                       'tbl_product_items.product_type = tbl_product_types.id', 
                       'left');
        
        $this->db->group_start();
        $this->db->like('tbl_product_items.product_name', $keyword);
        $this->db->or_like('tbl_product_items.description', $keyword);
        $this->db->group_end();
        
        if ($category_id) {
            $this->db->where('tbl_product_items.product_category', $category_id);
        }
        
        if ($type_id) {
            $this->db->where('tbl_product_items.product_type', $type_id);
        }
        
        $this->db->order_by('tbl_product_items.id', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }
}
