<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Product Detail Admin Model
 * Handles all database operations for product management
 */
class Product_detail_admin_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // ============================================
    // PRODUCT ITEMS MANAGEMENT
    // ============================================

    /**
     * Get all product items with category and type info
     */
    public function get_all_products($filters = [])
    {
        $this->db->select('pi.*, pc.category_name, pc.slug as category_slug, 
                          pt.type_name, pt.slug as type_slug');
        $this->db->from('tbl_product_items pi');
        $this->db->join('tbl_product_category pc', 'pi.product_category = pc.id', 'left');
        $this->db->join('tbl_product_types pt', 'pi.product_type = pt.id', 'left');
        
        // Apply filters
        if (!empty($filters['category_id'])) {
            $this->db->where('pi.product_category', $filters['category_id']);
        }
        if (!empty($filters['type_id'])) {
            $this->db->where('pi.product_type', $filters['type_id']);
        }
        if (isset($filters['is_active'])) {
            $this->db->where('pi.is_active', $filters['is_active']);
        }
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('pi.product_name', $filters['search']);
            $this->db->or_like('pi.model_number', $filters['search']);
            $this->db->or_like('pi.tags', $filters['search']);
            $this->db->group_end();
        }
        
        $this->db->order_by('pc.display_order', 'ASC');
        $this->db->order_by('pt.display_order', 'ASC');
        $this->db->order_by('pi.display_order', 'ASC');
        
        return $this->db->get()->result();
    }

    /**
     * Get single product by ID
     */
    public function get_product_by_id($id)
    {
        $this->db->select('pi.*, pc.category_name, pt.type_name');
        $this->db->from('tbl_product_items pi');
        $this->db->join('tbl_product_category pc', 'pi.product_category = pc.id', 'left');
        $this->db->join('tbl_product_types pt', 'pi.product_type = pt.id', 'left');
        $this->db->where('pi.id', $id);
        
        return $this->db->get()->row();
    }

    /**
     * Get product by slug
     */
    public function get_product_by_slug($slug)
    {
        $this->db->select('pi.*, pc.category_name, pc.slug as category_slug, 
                          pt.type_name, pt.slug as type_slug');
        $this->db->from('tbl_product_items pi');
        $this->db->join('tbl_product_category pc', 'pi.product_category = pc.id', 'left');
        $this->db->join('tbl_product_types pt', 'pi.product_type = pt.id', 'left');
        $this->db->where('pi.slug', $slug);
        $this->db->where('pi.is_active', 1);
        
        return $this->db->get()->row();
    }

    /**
     * Create new product
     */
    public function create_product($data)
    {
        // Auto-generate slug if not provided
        if (empty($data['slug']) && !empty($data['product_name'])) {
            $data['slug'] = $this->generate_unique_slug($data['product_name']);
        }
        
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert('tbl_product_items', $data);
        return $this->db->insert_id();
    }

    /**
     * Update existing product
     */
    public function update_product($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        return $this->db->update('tbl_product_items', $data);
    }

    /**
     * Delete product
     */
    public function delete_product($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tbl_product_items');
    }

    /**
     * Toggle product active status
     */
    public function toggle_active($id)
    {
        $product = $this->get_product_by_id($id);
        if ($product) {
            $new_status = $product->is_active ? 0 : 1;
            $this->db->where('id', $id);
            return $this->db->update('tbl_product_items', [
                'is_active' => $new_status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        return false;
    }

    /**
     * Generate unique slug
     */
    private function generate_unique_slug($text, $id = null)
    {
        $slug = url_title($text, '-', true);
        $original_slug = $slug;
        $counter = 1;
        
        while (true) {
            $this->db->where('slug', $slug);
            if ($id) {
                $this->db->where('id !=', $id);
            }
            $exists = $this->db->get('tbl_product_items')->row();
            
            if (!$exists) {
                break;
            }
            
            $slug = $original_slug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    // ============================================
    // CATEGORY MANAGEMENT
    // ============================================

    /**
     * Get all categories
     */
    public function get_all_categories($active_only = false)
    {
        $this->db->select('pc.*, COUNT(pi.id) as product_count');
        $this->db->from('tbl_product_category pc');
        $this->db->join('tbl_product_items pi', 'pc.id = pi.product_category AND pi.is_active = 1', 'left');
        
        if ($active_only) {
            $this->db->where('pc.is_active', 1);
        }
        
        $this->db->group_by('pc.id');
        $this->db->order_by('pc.display_order', 'ASC');
        
        return $this->db->get()->result();
    }

    /**
     * Get category by ID
     */
    public function get_category_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('tbl_product_category')->row();
    }

    /**
     * Create category
     */
    public function create_category($data)
    {
        if (empty($data['slug']) && !empty($data['category_name'])) {
            $data['slug'] = $this->generate_category_slug($data['category_name']);
        }
        
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert('tbl_product_category', $data);
        return $this->db->insert_id();
    }

    /**
     * Update category
     */
    public function update_category($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        return $this->db->update('tbl_product_category', $data);
    }

    /**
     * Delete category
     */
    public function delete_category($id)
    {
        // Check if category has products
        $this->db->where('product_category', $id);
        $count = $this->db->count_all_results('tbl_product_items');
        
        if ($count > 0) {
            return ['success' => false, 'message' => 'Cannot delete category with existing products'];
        }
        
        $this->db->where('id', $id);
        $result = $this->db->delete('tbl_product_category');
        
        return ['success' => $result, 'message' => $result ? 'Category deleted' : 'Delete failed'];
    }

    /**
     * Generate unique category slug
     */
    private function generate_category_slug($text, $id = null)
    {
        $slug = url_title($text, '-', true);
        $original_slug = $slug;
        $counter = 1;
        
        while (true) {
            $this->db->where('slug', $slug);
            if ($id) {
                $this->db->where('id !=', $id);
            }
            $exists = $this->db->get('tbl_product_category')->row();
            
            if (!$exists) {
                break;
            }
            
            $slug = $original_slug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    // ============================================
    // PRODUCT TYPES MANAGEMENT
    // ============================================

    /**
     * Get all types
     */
    public function get_all_types($category_id = null, $active_only = false)
    {
        $this->db->select('pt.*, pc.category_name');
        $this->db->from('tbl_product_types pt');
        $this->db->join('tbl_product_category pc', 'pt.product_category = pc.id', 'left');
        
        if ($category_id) {
            $this->db->where('pt.product_category', $category_id);
        }
        
        if ($active_only) {
            $this->db->where('pt.is_active', 1);
        }
        
        $this->db->order_by('pt.display_order', 'ASC');
        
        return $this->db->get()->result();
    }

    /**
     * Get type by ID
     */
    public function get_type_by_id($id)
    {
        $this->db->select('pt.*, pc.category_name');
        $this->db->from('tbl_product_types pt');
        $this->db->join('tbl_product_category pc', 'pt.product_category = pc.id', 'left');
        $this->db->where('pt.id', $id);
        
        return $this->db->get()->row();
    }

    /**
     * Create type
     */
    public function create_type($data)
    {
        if (empty($data['slug']) && !empty($data['type_name'])) {
            $data['slug'] = $this->generate_type_slug($data['type_name']);
        }
        
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert('tbl_product_types', $data);
        return $this->db->insert_id();
    }

    /**
     * Update type
     */
    public function update_type($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        return $this->db->update('tbl_product_types', $data);
    }

    /**
     * Delete type
     */
    public function delete_type($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tbl_product_types');
    }

    /**
     * Generate unique type slug
     */
    private function generate_type_slug($text, $id = null)
    {
        $slug = url_title($text, '-', true);
        $original_slug = $slug;
        $counter = 1;
        
        while (true) {
            $this->db->where('slug', $slug);
            if ($id) {
                $this->db->where('id !=', $id);
            }
            $exists = $this->db->get('tbl_product_types')->row();
            
            if (!$exists) {
                break;
            }
            
            $slug = $original_slug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    // ============================================
    // SPECIFICATIONS MANAGEMENT
    // ============================================

    /**
     * Get specifications for a product
     */
    public function get_product_specifications($product_id)
    {
        $this->db->where('product_id', $product_id);
        $this->db->order_by('spec_group', 'ASC');
        $this->db->order_by('display_order', 'ASC');
        
        return $this->db->get('tbl_product_specifications')->result();
    }

    /**
     * Add specification
     */
    public function add_specification($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert('tbl_product_specifications', $data);
        return $this->db->insert_id();
    }

    /**
     * Update specification
     */
    public function update_specification($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        return $this->db->update('tbl_product_specifications', $data);
    }

    /**
     * Delete specification
     */
    public function delete_specification($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tbl_product_specifications');
    }

    // ============================================
    // DOWNLOADS MANAGEMENT
    // ============================================

    /**
     * Get downloads for a product
     */
    public function get_product_downloads($product_id)
    {
        $this->db->where('product_id', $product_id);
        $this->db->where('is_active', 1);
        $this->db->order_by('display_order', 'ASC');
        
        return $this->db->get('tbl_product_downloads')->result();
    }

    /**
     * Add download
     */
    public function add_download($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert('tbl_product_downloads', $data);
        return $this->db->insert_id();
    }

    /**
     * Update download
     */
    public function update_download($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        return $this->db->update('tbl_product_downloads', $data);
    }

    /**
     * Delete download
     */
    public function delete_download($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tbl_product_downloads');
    }

    // ============================================
    // APPLICATIONS MANAGEMENT
    // ============================================

    /**
     * Get applications for a product
     */
    public function get_product_applications($product_id)
    {
        $this->db->where('product_id', $product_id);
        $this->db->where('is_active', 1);
        $this->db->order_by('display_order', 'ASC');
        
        return $this->db->get('tbl_product_applications')->result();
    }

    /**
     * Add application
     */
    public function add_application($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert('tbl_product_applications', $data);
        return $this->db->insert_id();
    }

    /**
     * Update application
     */
    public function update_application($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        return $this->db->update('tbl_product_applications', $data);
    }

    /**
     * Delete application
     */
    public function delete_application($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tbl_product_applications');
    }

    // ============================================
    // UTILITY FUNCTIONS
    // ============================================

    /**
     * Get statistics
     */
    public function get_statistics()
    {
        $stats = [];
        
        // Total products
        $stats['total_products'] = $this->db->count_all('tbl_product_items');
        
        // Active products
        $this->db->where('is_active', 1);
        $stats['active_products'] = $this->db->count_all_results('tbl_product_items');
        
        // Total categories
        $stats['total_categories'] = $this->db->count_all('tbl_product_category');
        
        // Total types
        $stats['total_types'] = $this->db->count_all('tbl_product_types');
        
        return $stats;
    }

    /**
     * Duplicate product
     */
    public function duplicate_product($id)
    {
        $product = $this->get_product_by_id($id);
        
        if (!$product) {
            return false;
        }
        
        // Convert object to array
        $data = (array) $product;
        
        // Remove ID and update fields
        unset($data['id']);
        $data['product_name'] = $data['product_name'] . ' (Copy)';
        $data['slug'] = $this->generate_unique_slug($data['product_name']);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->create_product($data);
    }
}
