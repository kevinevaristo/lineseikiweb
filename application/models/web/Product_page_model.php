<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Product Page Model
 * Handles all product detail page queries for the dynamic product system
 */
class Product_page_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get product details by slug with all related information
     * 
     * @param string $slug Product slug
     * @return object|null Product object or null if not found
     */
    public function get_product_by_slug($slug)
    {
        $this->db->select('
            pi.*,
            pc.category_name,
            pc.slug as category_slug,
            pt.type_name,
            pt.slug as type_slug
        ');
        $this->db->from('tbl_product_items pi');
        $this->db->join('tbl_product_category pc', 'pi.product_category = pc.id', 'left');
        $this->db->join('tbl_product_types pt', 'pi.product_type = pt.id', 'left');
        $this->db->where('pi.slug', $slug);
        $this->db->where('pi.is_active', 1);
        $this->db->where('pc.is_active', 1);
        
        $query = $this->db->get();
        return $query->row();
    }
    
    /**
     * Get product details by category slug and product slug
     * 
     * @param string $category_slug Category slug
     * @param string $product_slug Product slug
     * @return object|null Product object or null if not found
     */
    public function get_product_by_category_and_slug($category_slug, $product_slug)
    {
        $this->db->select('
            pi.*,
            pc.category_name,
            pc.slug as category_slug,
            pt.type_name,
            pt.slug as type_slug
        ');
        $this->db->from('tbl_product_items pi');
        $this->db->join('tbl_product_category pc', 'pi.product_category = pc.id', 'left');
        $this->db->join('tbl_product_types pt', 'pi.product_type = pt.id', 'left');
        $this->db->where('pc.slug', $category_slug);
        $this->db->where('pi.slug', $product_slug);
        $this->db->where('pi.is_active', 1);
        $this->db->where('pc.is_active', 1);
        
        $query = $this->db->get();
        return $query->row();
    }
    
    /**
     * Get product details by ID
     * 
     * @param int $id Product ID
     * @return object|null Product object or null if not found
     */
    public function get_product_by_id($id)
    {
        $this->db->select('
            pi.*,
            pc.category_name,
            pc.slug as category_slug,
            pt.type_name,
            pt.slug as type_slug
        ');
        $this->db->from('tbl_product_items pi');
        $this->db->join('tbl_product_category pc', 'pi.product_category = pc.id', 'left');
        $this->db->join('tbl_product_types pt', 'pi.product_type = pt.id', 'left');
        $this->db->where('pi.id', $id);
        
        $query = $this->db->get();
        return $query->row();
    }

    public function get_all_types_by_category($category_id)
    {
        $this->db->select('t.*, COUNT(p.id) as item_count');
        $this->db->from('tbl_product_types t');
        $this->db->join('tbl_product_items p', 'p.product_type = t.id', 'left');
        $this->db->where('t.product_category', $category_id);
        $this->db->group_by('t.id');
        $this->db->order_by('t.display_order', 'ASC');
        $this->db->order_by('t.type_name', 'ASC');
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        
        return [];
    }

    public function get_product_types_by_category($category_id, $include_counts = true)
    {
        $this->db->select('t.*');
        
        if ($include_counts) {
            $this->db->select('COUNT(p.id) as item_count');
            $this->db->join('tbl_product_items p', 'p.product_type = t.id AND p.is_active = 1', 'left');
            $this->db->group_by('t.id');
        }
        
        $this->db->from('tbl_product_types t');
        $this->db->where('t.product_category', $category_id);
        $this->db->where('t.is_active', 1); // Only active types
        $this->db->order_by('t.display_order', 'ASC');
        $this->db->order_by('t.type_name', 'ASC');
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        
        return [];
    }
    
    /**
     * Get related products from the same category
     * 
     * @param int $product_id Current product ID (to exclude)
     * @param int $category_id Category ID
     * @param int $limit Number of related products to return
     * @return array Array of product objects
     */
    public function get_related_products($product_id, $category_id, $limit = 3)
    {
        $this->db->select('
            pi.id,
            pi.product_name,
            pi.series_name,
            pi.short_description,
            pi.product_image,
            pi.slug,
            pi.is_new,
            pi.is_featured,
            pc.category_name,
            pc.slug as category_slug
        ');
        $this->db->from('tbl_product_items pi');
        $this->db->join('tbl_product_category pc', 'pi.product_category = pc.id', 'left');
        $this->db->where('pi.product_category', $category_id);
        $this->db->where('pi.id !=', $product_id);
        $this->db->where('pi.is_active', 1);
        $this->db->where('pc.is_active', 1);
        $this->db->order_by('pi.is_featured', 'DESC');
        $this->db->order_by('pi.display_order', 'ASC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Get related products from the same type
     * 
     * @param int $product_id Current product ID (to exclude)
     * @param int $type_id Type ID
     * @param int $limit Number of related products to return
     * @return array Array of product objects
     */
    public function get_related_products_by_type($product_id, $type_id, $limit = 3)
    {
        $this->db->select('
            pi.id,
            pi.product_name,
            pi.series_name,
            pi.short_description,
            pi.product_image,
            pi.slug,
            pi.is_new,
            pi.is_featured,
            pc.category_name,
            pc.slug as category_slug,
            pt.type_name
        ');
        $this->db->from('tbl_product_items pi');
        $this->db->join('tbl_product_category pc', 'pi.product_category = pc.id', 'left');
        $this->db->join('tbl_product_types pt', 'pi.product_type = pt.id', 'left');
        $this->db->where('pi.product_type', $type_id);
        $this->db->where('pi.id !=', $product_id);
        $this->db->where('pi.is_active', 1);
        $this->db->where('pc.is_active', 1);
        $this->db->order_by('pi.is_featured', 'DESC');
        $this->db->order_by('pi.display_order', 'ASC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Get product applications by product ID
     * 
     * @param int $product_id Product ID
     * @return array Array of application objects
     */
    public function get_product_applications($product_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_product_applications');
        $this->db->where('product_id', $product_id);
        $this->db->where('is_active', 1);
        $this->db->order_by('display_order', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Get product downloads by product ID
     * 
     * @param int $product_id Product ID
     * @return array Array of download objects
     */
    public function get_product_downloads($product_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_product_downloads');
        $this->db->where('product_id', $product_id);
        $this->db->where('is_active', 1);
        $this->db->order_by('display_order', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Get all active products for listing
     * 
     * @param int $limit Limit number of products
     * @param int $offset Offset for pagination
     * @return array Array of product objects
     */
    public function get_all_products($limit = null, $offset = 0)
    {
        $this->db->select('
            pi.*,
            pc.category_name,
            pc.slug as category_slug,
            pt.type_name,
            pt.slug as type_slug
        ');
        $this->db->from('tbl_product_items pi');
        $this->db->join('tbl_product_category pc', 'pi.product_category = pc.id', 'left');
        $this->db->join('tbl_product_types pt', 'pi.product_type = pt.id', 'left');
        $this->db->where('pi.is_active', 1);
        $this->db->where('pc.is_active', 1);
        $this->db->order_by('pc.display_order', 'ASC');
        $this->db->order_by('pt.display_order', 'ASC');
        $this->db->order_by('pi.display_order', 'ASC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Get products by category ID
     * 
     * @param int $category_id Category ID
     * @param int $limit Limit number of products
     * @param int $offset Offset for pagination
     * @return array Array of product objects
     */
    public function get_products_by_category($category_id, $limit = null, $offset = 0)
    {
        $this->db->select('
            pi.*,
            pc.category_name,
            pc.slug as category_slug,
            pt.type_name,
            pt.slug as type_slug
        ');
        $this->db->from('tbl_product_items pi');
        $this->db->join('tbl_product_category pc', 'pi.product_category = pc.id', 'left');
        $this->db->join('tbl_product_types pt', 'pi.product_type = pt.id', 'left');
        $this->db->where('pi.product_category', $category_id);
        $this->db->where('pi.is_active', 1);
        $this->db->where('pc.is_active', 1);
        $this->db->order_by('pt.display_order', 'ASC');
        $this->db->order_by('pi.display_order', 'ASC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Get featured products
     * 
     * @param int $limit Limit number of products
     * @return array Array of product objects
     */
    public function get_featured_products($limit = 6)
    {
        $this->db->select('
            pi.*,
            pc.category_name,
            pc.slug as category_slug,
            pt.type_name
        ');
        $this->db->from('tbl_product_items pi');
        $this->db->join('tbl_product_category pc', 'pi.product_category = pc.id', 'left');
        $this->db->join('tbl_product_types pt', 'pi.product_type = pt.id', 'left');
        $this->db->where('pi.is_active', 1);
        $this->db->where('pi.is_featured', 1);
        $this->db->order_by('pi.display_order', 'ASC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Get new products
     * 
     * @param int $limit Limit number of products
     * @return array Array of product objects
     */
    public function get_new_products($limit = 6)
    {
        $this->db->select('
            pi.*,
            pc.category_name,
            pc.slug as category_slug,
            pt.type_name
        ');
        $this->db->from('tbl_product_items pi');
        $this->db->join('tbl_product_category pc', 'pi.product_category = pc.id', 'left');
        $this->db->join('tbl_product_types pt', 'pi.product_type = pt.id', 'left');
        $this->db->where('pi.is_active', 1);
        $this->db->where('pi.is_new', 1);
        $this->db->order_by('pi.created_at', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Search products by keyword
     * 
     * @param string $keyword Search keyword
     * @param int $limit Limit number of results
     * @param int $offset Offset for pagination
     * @return array Array of product objects
     */
    public function search_products($keyword, $limit = 20, $offset = 0)
    {
        $this->db->select('
            pi.*,
            pc.category_name,
            pc.slug as category_slug,
            pt.type_name,
            pt.slug as type_slug
        ');
        $this->db->from('tbl_product_items pi');
        $this->db->join('tbl_product_category pc', 'pi.product_category = pc.id', 'left');
        $this->db->join('tbl_product_types pt', 'pi.product_type = pt.id', 'left');
        
        $this->db->group_start();
            $this->db->like('pi.product_name', $keyword);
            $this->db->or_like('pi.series_name', $keyword);
            $this->db->or_like('pi.description', $keyword);
            $this->db->or_like('pi.tags', $keyword);
            $this->db->or_like('pi.model_number', $keyword);
        $this->db->group_end();
        
        $this->db->where('pi.is_active', 1);
        $this->db->where('pc.is_active', 1);
        $this->db->order_by('pi.is_featured', 'DESC');
        $this->db->order_by('pi.display_order', 'ASC');
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Count total active products
     * 
     * @return int Total count
     */
    public function count_all_products()
    {
        $this->db->from('tbl_product_items pi');
        $this->db->join('tbl_product_category pc', 'pi.product_category = pc.id', 'left');
        $this->db->where('pi.is_active', 1);
        $this->db->where('pc.is_active', 1);
        
        return $this->db->count_all_results();
    }

    public function update_product($id, $data)
    {
        // Remove any unwanted fields
        unset($data['existing_product_image']);
        unset($data['existing_dimensions_image']);
        
        // Ensure JSON fields are properly encoded
        if (isset($data['models_data']) && is_array($data['models_data'])) {
            $data['models_data'] = json_encode($data['models_data'], JSON_UNESCAPED_UNICODE);
        }
        
        if (isset($data['applications_data']) && is_array($data['applications_data'])) {
            $data['applications_data'] = json_encode($data['applications_data'], JSON_UNESCAPED_UNICODE);
        }
        
        if (isset($data['downloads_data']) && is_array($data['downloads_data'])) {
            $data['downloads_data'] = json_encode($data['downloads_data'], JSON_UNESCAPED_UNICODE);
        }
        
        if (isset($data['gallery_images']) && is_array($data['gallery_images'])) {
            $data['gallery_images'] = json_encode($data['gallery_images'], JSON_UNESCAPED_UNICODE);
        }
        
        // Clean up empty values
        foreach ($data as $key => $value) {
            if ($value === '' || $value === null) {
                $data[$key] = null;
            }
        }
        
        $this->db->where('id', $id);
        return $this->db->update('tbl_product_items', $data);
    }
}

