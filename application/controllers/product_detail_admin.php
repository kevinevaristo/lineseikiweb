<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Product Detail Admin Controller
 * Manages product CRUD operations in admin panel
 */
class Product_detail_admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        // Load required libraries
        $this->load->model('admin/Product_detail_admin_model', 'product_model');
        $this->load->library(['session', 'form_validation', 'upload']);
        $this->load->helper(['url', 'form', 'file', 'text']);
        
        // Check admin session (adjust based on your auth system)
        if (!$this->session->userdata('SESS_USER_ID')) {
            redirect('panel_72c81');
        }
    }

    // ============================================
    // PRODUCT LISTING & MANAGEMENT
    // ============================================

    /**
     * Product list view
     */
    public function index()
    {
        $filters = [
            'category_id' => $this->input->get('category'),
            'type_id' => $this->input->get('type'),
            'is_active' => $this->input->get('status'),
            'search' => $this->input->get('search')
        ];
        
        $data['products'] = $this->product_model->get_all_products($filters);
        $data['categories'] = $this->product_model->get_all_categories();
        $data['stats'] = $this->product_model->get_statistics();
        $data['filters'] = $filters;
        
        $this->load->view('admin/product_detail/product_list', $data);
    }

    /**
     * Create new product form
     */
    public function create()
    {
        $data['categories'] = $this->product_model->get_all_categories(true);
        $data['types'] = $this->product_model->get_all_types(null, true);
        $data['mode'] = 'create';
        $data['product'] = null;
        
        $this->load->view('admin/product_detail/product_form', $data);
    }

    /**
     * Edit product form
     */
    public function edit($id)
    {
        $data['product'] = $this->product_model->get_product_by_id($id);
        
        if (!$data['product']) {
            $this->session->set_flashdata('error', 'Product not found');
            redirect('panel_72c81/product_detail_admin');
        }
        
        $data['categories'] = $this->product_model->get_all_categories(true);
        $data['types'] = $this->product_model->get_all_types($data['product']->product_category, true);
        $data['mode'] = 'edit';
        
        $this->load->view('admin/product_detail/product_form', $data);
    }

    /**
     * Save product (create/update)
     */
    public function save()
    {
        // Validation rules
        $this->form_validation->set_rules('product_name', 'Product Name', 'required|trim');
        $this->form_validation->set_rules('product_category', 'Category', 'required|integer');
        
        if ($this->form_validation->run() == FALSE) {
            $product_id = $this->input->post('product_id');
            if ($product_id) {
                $this->edit($product_id);
            } else {
                $this->create();
            }
            return;
        }
        
        // Prepare data
        $data = [
            'product_category' => $this->input->post('product_category'),
            'product_type' => $this->input->post('product_type') ?: null,
            'product_name' => $this->input->post('product_name'),
            'series_name' => $this->input->post('series_name'),
            'sub_title' => $this->input->post('sub_title'),
            'slug' => $this->input->post('slug'),
            'model_number' => $this->input->post('model_number'),
            'description' => $this->input->post('description'),
            'short_description' => $this->input->post('short_description'),
            'features' => $this->input->post('features'),
            'specifications' => $this->input->post('specifications'),
            'operating_distances' => $this->input->post('operating_distances'),
            'complied_standards' => $this->input->post('complied_standards'),
            'models_data' => $this->input->post('models_data'),
            'applications_data' => $this->input->post('applications_data'),
            'downloads_data' => $this->input->post('downloads_data'),
            'tags' => $this->input->post('tags'),
            'video_url' => $this->input->post('video_url'),
            'youtube_embed' => $this->input->post('youtube_embed'),
            'meta_title' => $this->input->post('meta_title'),
            'meta_description' => $this->input->post('meta_description'),
            'meta_keywords' => $this->input->post('meta_keywords'),
            'display_order' => $this->input->post('display_order') ?: 0,
            'is_active' => $this->input->post('is_active') ? 1 : 0,
            'is_featured' => $this->input->post('is_featured') ? 1 : 0,
            'is_new' => $this->input->post('is_new') ? 1 : 0,
        ];
        
        // Handle image upload
        if (!empty($_FILES['product_image']['name'])) {
            $upload_result = $this->upload_image('product_image');
            if ($upload_result['success']) {
                $data['product_image'] = $upload_result['file_name'];
                
                // Delete old image if editing
                $product_id = $this->input->post('product_id');
                if ($product_id) {
                    $old_product = $this->product_model->get_product_by_id($product_id);
                    if ($old_product && $old_product->product_image) {
                        @unlink(FCPATH . 'assets_system/images/' . $old_product->product_image);
                    }
                }
            }
        }
        
        // Handle dimensions image
        if (!empty($_FILES['dimensions_image']['name'])) {
            $upload_result = $this->upload_image('dimensions_image');
            if ($upload_result['success']) {
                $data['dimensions_image'] = $upload_result['file_name'];
            }
        }
        
        // Handle contact configuration image
        if (!empty($_FILES['contact_configuration_image']['name'])) {
            $upload_result = $this->upload_image('contact_configuration_image');
            if ($upload_result['success']) {
                $data['contact_configuration_image'] = $upload_result['file_name'];
            }
        }
        
        // Save or update
        $product_id = $this->input->post('product_id');
        
        if ($product_id) {
            // Update
            $data['updated_by'] = $this->session->userdata('SESS_USER_ID');
            $result = $this->product_model->update_product($product_id, $data);
            $message = 'Product updated successfully';
        } else {
            // Create
            $data['created_by'] = $this->session->userdata('SESS_USER_ID');
            $product_id = $this->product_model->create_product($data);
            $result = $product_id > 0;
            $message = 'Product created successfully';
        }
        
        if ($result) {
            $this->session->set_flashdata('success', $message);
        } else {
            $this->session->set_flashdata('error', 'Failed to save product');
        }
        
        redirect('panel_72c81/product_detail_admin');
    }

    /**
     * Delete product
     */
    public function delete($id)
    {
        $product = $this->product_model->get_product_by_id($id);
        
        if (!$product) {
            $this->session->set_flashdata('error', 'Product not found');
            redirect('panel_72c81/product_detail_admin');
        }
        
        // Delete product images
        if ($product->product_image) {
            @unlink(FCPATH . 'assets_system/images/' . $product->product_image);
        }
        if ($product->dimensions_image) {
            @unlink(FCPATH . 'assets_system/images/' . $product->dimensions_image);
        }
        if ($product->contact_configuration_image) {
            @unlink(FCPATH . 'assets_system/images/' . $product->contact_configuration_image);
        }
        
        $result = $this->product_model->delete_product($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Product deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete product');
        }
        
        redirect('panel_72c81/product_detail_admin');
    }

    /**
     * Toggle product active status
     */
    public function toggle_status($id)
    {
        $result = $this->product_model->toggle_active($id);
        
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update status']);
        }
    }

    /**
     * Duplicate product
     */
    public function duplicate($id)
    {
        $new_id = $this->product_model->duplicate_product($id);
        
        if ($new_id) {
            $this->session->set_flashdata('success', 'Product duplicated successfully');
            redirect('panel_72c81/product_detail_admin/edit/' . $new_id);
        } else {
            $this->session->set_flashdata('error', 'Failed to duplicate product');
            redirect('panel_72c81/product_detail_admin');
        }
    }

    // ============================================
    // CATEGORY MANAGEMENT
    // ============================================

    /**
     * Category list
     */
    public function categories()
    {
        $data['categories'] = $this->product_model->get_all_categories();
        $this->load->view('admin/product_detail/category_list', $data);
    }

    /**
     * Create/Edit category
     */
    public function category_form($id = null)
    {
        if ($id) {
            $data['category'] = $this->product_model->get_category_by_id($id);
            $data['mode'] = 'edit';
        } else {
            $data['category'] = null;
            $data['mode'] = 'create';
        }
        
        $this->load->view('admin/product_detail/category_form', $data);
    }

    /**
     * Save category
     */
    public function save_category()
    {
        $this->form_validation->set_rules('category_name', 'Category Name', 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            $id = $this->input->post('id');
            $this->category_form($id);
            return;
        }
        
        $data = [
            'category_name' => $this->input->post('category_name'),
            'slug' => $this->input->post('slug'),
            'description' => $this->input->post('description'),
            'icon' => $this->input->post('icon'),
            'display_order' => $this->input->post('display_order') ?: 0,
            'is_active' => $this->input->post('is_active') ? 1 : 0,
        ];
        
        // Handle image upload
        if (!empty($_FILES['product_image']['name'])) {
            $upload_result = $this->upload_image('product_image');
            if ($upload_result['success']) {
                $data['product_image'] = $upload_result['file_name'];
            }
        }
        
        $id = $this->input->post('id');
        
        if ($id) {
            $result = $this->product_model->update_category($id, $data);
            $message = 'Category updated successfully';
        } else {
            $result = $this->product_model->create_category($data);
            $message = 'Category created successfully';
        }
        
        if ($result) {
            $this->session->set_flashdata('success', $message);
        } else {
            $this->session->set_flashdata('error', 'Failed to save category');
        }
        
        redirect('panel_72c81/product_detail_admin/categories');
    }

    /**
     * Delete category
     */
    public function delete_category($id)
    {
        $result = $this->product_model->delete_category($id);
        
        if ($result['success']) {
            $this->session->set_flashdata('success', $result['message']);
        } else {
            $this->session->set_flashdata('error', $result['message']);
        }
        
        redirect('panel_72c81/product_detail_admin/categories');
    }

    // ============================================
    // TYPE MANAGEMENT
    // ============================================

    /**
     * Type list
     */
    public function types()
    {
        $category_id = $this->input->get('category');
        $data['types'] = $this->product_model->get_all_types($category_id);
        $data['categories'] = $this->product_model->get_all_categories(true);
        $data['selected_category'] = $category_id;
        
        $this->load->view('admin/product_detail/type_list', $data);
    }

    /**
     * Create/Edit type
     */
    public function type_form($id = null)
    {
        if ($id) {
            $data['type'] = $this->product_model->get_type_by_id($id);
            $data['mode'] = 'edit';
        } else {
            $data['type'] = null;
            $data['mode'] = 'create';
        }
        
        $data['categories'] = $this->product_model->get_all_categories(true);
        
        $this->load->view('admin/product_detail/type_form', $data);
    }

    /**
     * Save type
     */
    public function save_type()
    {
        $this->form_validation->set_rules('type_name', 'Type Name', 'required|trim');
        $this->form_validation->set_rules('product_category', 'Category', 'required|integer');
        
        if ($this->form_validation->run() == FALSE) {
            $id = $this->input->post('id');
            $this->type_form($id);
            return;
        }
        
        $data = [
            'product_category' => $this->input->post('product_category'),
            'type_name' => $this->input->post('type_name'),
            'slug' => $this->input->post('slug'),
            'description' => $this->input->post('description'),
            'display_order' => $this->input->post('display_order') ?: 0,
            'is_active' => $this->input->post('is_active') ? 1 : 0,
        ];
        
        $id = $this->input->post('id');
        
        if ($id) {
            $result = $this->product_model->update_type($id, $data);
            $message = 'Type updated successfully';
        } else {
            $result = $this->product_model->create_type($data);
            $message = 'Type created successfully';
        }
        
        if ($result) {
            $this->session->set_flashdata('success', $message);
        } else {
            $this->session->set_flashdata('error', 'Failed to save type');
        }
        
        redirect('panel_72c81/product_detail_admin/types');
    }

    /**
     * Delete type
     */
    public function delete_type($id)
    {
        $result = $this->product_model->delete_type($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Type deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete type');
        }
        
        redirect('panel_72c81/product_detail_admin/types');
    }

    // ============================================
    // AJAX HELPERS
    // ============================================

    /**
     * Get types by category (AJAX)
     */
    public function get_types_by_category()
    {
        $category_id = $this->input->post('category_id');
        $types = $this->product_model->get_all_types($category_id, true);
        
        echo json_encode($types);
    }

    /**
     * Check slug availability (AJAX)
     */
    public function check_slug()
    {
        $slug = $this->input->post('slug');
        $id = $this->input->post('id');
        
        $this->db->where('slug', $slug);
        if ($id) {
            $this->db->where('id !=', $id);
        }
        
        $exists = $this->db->get('tbl_product_items')->row();
        
        echo json_encode(['available' => !$exists]);
    }

    // ============================================
    // FILE UPLOAD HELPER
    // ============================================

    /**
     * Upload image
     */
    private function upload_image($field_name)
    {
        $config['upload_path'] = FCPATH . 'assets_system/images/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
        $config['max_size'] = 5120; // 5MB
        $config['encrypt_name'] = TRUE;
        
        $this->upload->initialize($config);
        
        if ($this->upload->do_upload($field_name)) {
            return [
                'success' => true,
                'file_name' => $this->upload->data('file_name'),
                'file_path' => $this->upload->data('full_path')
            ];
        } else {
            return [
                'success' => false,
                'error' => $this->upload->display_errors('', '')
            ];
        }
    }
}
