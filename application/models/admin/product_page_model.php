<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Product Page Model
 * Handles all database operations for dynamic product pages
 * Supports JSON data for flexible content management
 */
class Product_page_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all products with optional filtering
     * @param array $filters - Optional filters (category, is_active, etc.)
     * @return array
     */
    public function get_all_products($filters = []) {
        if (isset($filters['category']) && !empty($filters['category'])) {
            $this->db->where('category', $filters['category']);
        }
        
        if (isset($filters['is_active'])) {
            $this->db->where('is_active', $filters['is_active']);
        }
        
        if (isset($filters['is_featured'])) {
            $this->db->where('is_featured', $filters['is_featured']);
        }
        
        $this->db->order_by('display_order', 'ASC');
        $this->db->order_by('product_name', 'ASC');
        $query = $this->db->get('tbl_product_items');
        return $query->result();
    }

    /**
     * Get active products only
     */
    public function get_active_products() {
        return $this->get_all_products(['is_active' => 1]);
    }

    /**
     * Get featured products
     */
    public function get_featured_products($limit = null) {
        $this->db->where('is_active', 1);
        $this->db->where('is_featured', 1);
        $this->db->order_by('display_order', 'ASC');
        
        if ($limit) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get('tbl_product_items');
        return $query->result();
    }

    /**
     * Get product by ID
     * Decodes JSON fields automatically
     */
    public function get_product_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_product_items');
        return $query->row();
    }

    /**
     * Get product by slug (for frontend display)
     * Only returns active products
     */
    public function get_product_by_slug($slug) {
        $this->db->where('slug', $slug);
        $this->db->where('is_active', 1);
        $query = $this->db->get('tbl_product_items');
        $product = $query->row();
        
        if ($product) {
            $product = $this->decode_json_fields($product);
        }
        
        return $product;
    }

    /**
     * Get products by category
     */
    public function get_products_by_category($category, $active_only = true) {
        $this->db->where('category', $category);
        
        if ($active_only) {
            $this->db->where('is_active', 1);
        }
        
        $this->db->order_by('display_order', 'ASC');
        $query = $this->db->get('tbl_product_items');
        return $query->result();
    }

    /**
     * Insert new product
     * Encodes JSON fields automatically
     */
    public function insert_product($data) {
        $data = $this->encode_json_fields($data);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->insert('tbl_product_items', $data);
    }

    /**
     * Update product
     * Encodes JSON fields automatically
     */
    public function update_product($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tbl_product_items', $data);
    }
    /**
     * Delete product
     */
    public function delete_product($id) {
        $this->db->where('id', $id);
        return $this->db->delete('tbl_product_items');
    }

    /**
     * Toggle product active status
     */
    public function toggle_active($id) {
        $product = $this->get_product_by_id($id);
        if ($product) {
            $new_status = $product->is_active ? 0 : 1;
            return $this->update_product($id, ['is_active' => $new_status]);
        }
        return false;
    }

    /**
     * Toggle featured status
     */
    public function toggle_featured($id) {
        $product = $this->get_product_by_id($id);
        if ($product) {
            $new_status = $product->is_featured ? 0 : 1;
            return $this->update_product($id, ['is_featured' => $new_status]);
        }
        return false;
    }

    /**
     * Check if slug exists (excluding current product ID)
     */
    public function check_slug_exists($slug, $exclude_id = null) {
        $this->db->where('slug', $slug);
        
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        
        $query = $this->db->get('tbl_product_items');
        return $query->num_rows() > 0;
    }

    /**
     * Generate unique slug from product name
     */
    public function generate_slug($product_name, $exclude_id = null) {
        $slug = url_title(strtolower($product_name), '-', TRUE);
        $original_slug = $slug;
        $counter = 1;
        
        while ($this->check_slug_exists($slug, $exclude_id)) {
            $slug = $original_slug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    /**
     * Get related products (excluding current product)
     */
    public function get_related_products($product_id, $limit = 3) {
        $product = $this->get_product_by_id($product_id);
        
        if ($product && !empty($product->category)) {
            // Get products in same category
            $this->db->where('category', $product->category);
        }
        
        $this->db->where('is_active', 1);
        $this->db->where('id !=', $product_id);
        $this->db->order_by('display_order', 'ASC');
        $this->db->limit($limit);
        
        $query = $this->db->get('tbl_product_items');
        return $query->result();
    }

    /**
     * Get all unique categories
     */
    public function get_categories() {
        $this->db->distinct();
        $this->db->select('category');
        $this->db->where('category IS NOT NULL');
        $this->db->where('category !=', '');
        $this->db->where('is_active', 1);
        $this->db->order_by('category', 'ASC');
        
        $query = $this->db->get('tbl_product_items');
        return $query->result();
    }

    /**
     * Update display order
     */
    public function update_display_order($id, $order) {
        $this->db->where('id', $id);
        return $this->db->update('tbl_product_items', ['display_order' => $order]);
    }

    /**
     * Search products
     */
    public function search_products($keyword, $active_only = true) {
        $this->db->group_start();
        $this->db->like('product_name', $keyword);
        $this->db->or_like('subtitle', $keyword);
        $this->db->or_like('category', $keyword);
        $this->db->or_like('tags', $keyword);
        $this->db->or_like('features', $keyword);
        $this->db->group_end();
        
        if ($active_only) {
            $this->db->where('is_active', 1);
        }
        
        $this->db->order_by('display_order', 'ASC');
        $query = $this->db->get('tbl_product_items');
        return $query->result();
    }

    // ========================================
    // PRIVATE HELPER METHODS
    // ========================================

    /**
     * Decode JSON fields for display
     */
    private function decode_json_fields($product) {
        $json_fields = ['models_data', 'specifications_data', 'downloads_data', 'applications_data', 'gallery_images'];
        
        foreach ($json_fields as $field) {
            if (isset($product->$field) && !empty($product->$field)) {
                $decoded = json_decode($product->$field);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $product->$field = $decoded;
                } else {
                    // If JSON decode fails, set to null or empty array
                    $product->$field = is_string($product->$field) ? null : [];
                }
            } else {
                $product->$field = null;
            }
        }
        
        // Process tags and features as arrays
        if (isset($product->tags)) {
            $product->tags_array = !empty($product->tags) ? array_map('trim', explode(',', $product->tags)) : [];
        }
        
        if (isset($product->features)) {
            $product->features_array = !empty($product->features) ? array_filter(array_map('trim', explode("\n", $product->features))) : [];
        }
        
        return $product;
    }

    /**
     * Encode JSON fields for storage
     */
    private function encode_json_fields($data) {
        $json_fields = ['models_data', 'specifications_data', 'downloads_data', 'applications_data', 'gallery_images'];
        
        foreach ($json_fields as $field) {
            if (isset($data[$field])) {
                if (is_array($data[$field]) || is_object($data[$field])) {
                    $data[$field] = json_encode($data[$field], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                }
            }
        }
        
        return $data;
    }
}
