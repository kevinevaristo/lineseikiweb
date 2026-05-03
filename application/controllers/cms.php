<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cms extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('SESS_USER_ID') == '') {
            redirect('panel_72c81/session_expired');
        }

        $this->load->model('admin/cms_model');
        // Loading URL helper for base_url() functionality
        $this->load->helper('url');
        $this->load->library('upload');
        $this->load->model('admin/simulation_model');
        $this->load->model('admin/smuc_model');
        $this->load->model('admin/iotsolution_model');
        $this->load->model('admin/admin_library_model');
        $this->load->model('admin/event_model');
        $this->load->model('admin/contact_us_admin_model');
        $this->load->model('admin/about_us_model');
        $this->load->model('admin/products_model');
        $this->load->model('admin/product_items_model');
        $this->load->model('admin/footer_model');
        $this->load->model('admin/safety_switches_model');
        $this->load->model('admin/image_management_model');
        $this->load->model('admin/custom_pages_model');
        $this->load->model('admin/Quote_requests_model');
        $this->load->model('admin/Video_model');
        $this->load->model('admin/Download_model');
        $this->load->model('admin/message_model');
        $this->load->model('web/testimonial_model');
        $this->load->model('web/email_model');

        $upload_path = FCPATH . 'assets_system/images/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }
        
        // Ensure custom pages table exists
        $this->custom_pages_model->ensure_table_exists();
    }
    
    public function subscribers() {
        // Mark all subscribers as seen (clears the notification badge)
        $this->email_model->mark_all_seen();

        // Get statistics
        $data['statistics'] = [
            'total' => $this->email_model->count_all(),
            'active' => $this->email_model->count_by_status('active'),
            'unsubscribed' => $this->email_model->count_by_status('unsubscribed'),
            'bounced' => $this->email_model->count_by_status('bounced'),
            'today' => $this->email_model->count_today()
        ];
        
        // Get recent subscribers (last 5)
        $data['recent_subscribers'] = $this->email_model->get_recent(5);
        
        // Get all subscribers
        $data['all_subscribers'] = $this->email_model->get_all();
        $this->load->view('admin/header');
        $this->load->view('admin/email_admin_views', $data);
    }
    
    function messages()
    {
        $data['title'] = 'Messages Dashboard';
        $data['statistics'] = $this->message_model->get_statistics();
        $data['recent_messages'] = $this->message_model->get_recent_messages();
        $data['all_messages'] = $this->message_model->get_all_messages();
        
        // Load views
        $this->load->view('admin/header', $data);
        $this->load->view('admin/dashboard', $data);
    }
    
    private function get_next_sort_order() {
        $this->db->where('is_active', 1);
        $count = $this->db->count_all_results('tbl_testimonial');
        return $count + 1;
    }
    
    function testimonial()
    {
        $data['title'] = 'Manage Testimonials';
        $data['testimonials'] = $this->testimonial_model->get_all_testimonial();
        
      
        $this->load->view('admin/testimonial_views', $data);
        
    }
    
     public function add_testimonial() {
        $data['title'] = 'Add New Testimonial';
        
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('position', 'Position', 'trim');
        $this->form_validation->set_rules('content', 'Content', 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            
            $this->load->view('admin/add_testimonial_views', $data);
            
        } else {
            $testimonial_data = [
                'name' => $this->input->post('name', true),
                'position' => $this->input->post('position', true),
                'content' => $this->input->post('content', true),
                'sort_order' => $this->get_next_sort_order(),
                'is_active' => $this->input->post('is_active') ? 1 : 0
            ];
            
            // Handle image upload
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './assets_system/images/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = true;
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('image')) {
                    $upload_data = $this->upload->data();
                    $testimonial_data['image'] = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('cms/add_testimonial');
                }
            }
            
            if ($this->testimonial_model->insert_testimonial($testimonial_data)) {
                $this->session->set_flashdata('success', 'Testimonial added successfully!');
                redirect('cms/testimonial');
            } else {
                $this->session->set_flashdata('error', 'Failed to add testimonial.');
                redirect('cms/add_testimonial');
            }
        }
    }
    
    public function edit_testimonial($id) {
        $data['title'] = 'Edit Testimonial';
        $data['testimonial'] = $this->testimonial_model->get_testimonial($id);
        
        if (empty($data['testimonial'])) {
            show_404();
        }
        
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('position', 'Position', 'trim');
        $this->form_validation->set_rules('content', 'Content', 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            
            $this->load->view('admin/edit_testimonial_views', $data);
            
        } else {
            $testimonial_data = [
                'name' => $this->input->post('name', true),
                'position' => $this->input->post('position', true),
                'content' => $this->input->post('content', true),
                'sort_order' => $this->input->post('sort_order') ?: 0,
                'is_active' => $this->input->post('is_active') ? 1 : 0
            ];
            
            // Handle image upload
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './assets_system/images/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
                $config['max_size'] = 2048;
                $config['encrypt_name'] = true;
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('image')) {
                    $upload_data = $this->upload->data();
                    $testimonial_data['image'] = $upload_data['file_name'];
                    
                    // Delete old image if exists
                    if (!empty($data['testimonial']->image) && file_exists('./assets_system/images/' . $data['testimonial']->image)) {
                        unlink('./assets_system/images/' . $data['testimonial']->image);
                    }
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('cms/edit_testimonial/' . $id);
                }
            }
            
            if ($this->testimonial_model->update_testimonial($id, $testimonial_data)) {
                $this->session->set_flashdata('success', 'Testimonial updated successfully!');
                redirect('cms/testimonial');
            } else {
                $this->session->set_flashdata('error', 'Failed to update testimonial.');
                redirect('cms/edit_testimonial/' . $id);
            }
        }
    }
    
     public function delete_testimonial($id) {
        $testimonial = $this->testimonial_model->get_testimonial($id);
        
        if (empty($testimonial)) {
            show_404();
        }
        
        // If you want to delete the image file as well
        if (!empty($testimonial->image) && file_exists('./assets_system/images/' . $testimonial->image)) {
            unlink('./assets_system/images/' . $testimonial->image);
        }
        
        if ($this->testimonial_model->hard_delete_testimonial($id)) {
            $this->session->set_flashdata('success', 'Testimonial deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete testimonial.');
        }
        
        redirect('cms/testimonial');
    }
    
    public function toggle_status_testi($id) {
        $testimonial = $this->testimonial_model->get_testimonial($id);
        
        if (empty($testimonial)) {
            show_404();
        }
        
        $new_status = $testimonial->is_active ? 0 : 1;
        
        if ($this->testimonial_model->update_testimonial($id, ['is_active' => $new_status])) {
            $this->session->set_flashdata('success', 'Status updated successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to update status.');
        }
        
        redirect('cms/testimonial');
    }
    
     public function bulk_action() {
        $ids = $this->input->post('ids');
        $action = $this->input->post('action');
        
        if (empty($ids) || empty($action)) {
            $this->session->set_flashdata('error', 'No items selected.');
            redirect('cms/testimonial');
        }
        
        $success_count = 0;
        $total_count = count($ids);
        
        foreach ($ids as $id) {
            if ($action == 'delete') {
                if ($this->testimonial_model->hard_delete_testimonial($id)) {
                    $success_count++;
                }
            } elseif ($action == 'activate') {
                if ($this->testimonial_model->update_testimonial($id, ['is_active' => 1])) {
                    $success_count++;
                }
            } elseif ($action == 'deactivate') {
                if ($this->testimonial_model->update_testimonial($id, ['is_active' => 0])) {
                    $success_count++;
                }
            }
        }
        
        $this->session->set_flashdata('success', "$success_count out of $total_count items updated successfully!");
        redirect('cms/testimonial');
    }
    
     public function reorder() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $orders = $this->input->post('orders');
        
        if (!empty($orders)) {
            $this->testimonial_model->update_sort_order($orders);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
    
    public function view($id) {
        $data['message'] = $this->message_model->get_message($id);
        
        if(empty($data['message'])) {
            show_404();
        }
        
        // Update status to 'read' if it's new
        if($data['message']->status == 'new') {
            $this->message_model->update_status($id, 'read');
        }
        
        $data['title'] = 'View Message - ' . $data['message']->subject;
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/view', $data);
        
    }
    
    function update_message($id)
    {
        $status = $this->input->post('status');
        
        if($this->message_model->update_status($id, $status)) {
            $this->session->set_flashdata('success', 'Status updated successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to update status');
        }
        
        redirect('cms/view/' . $id);
    }
    
    public function get_new_count() 
    {
        $this->load->database();
        $count = $this->db->where('status', 'new')
                          ->from('tbl_send_us_message')
                          ->count_all_results();
        
        header('Content-Type: application/json');
        echo json_encode(['count' => $count]);
        exit;
    }
    
    public function update_notes($id) {
        $notes = $this->input->post('notes');
        
        if($this->message_model->update_notes($id, $notes)) {
            $this->session->set_flashdata('success', 'Notes updated successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to update notes');
        }
        
        redirect('cms/view/' . $id);
    }
    
    function add_main_content()
    {
        $this->load->view('admin/add_main_content');
    }
    
    function edit_main_content($id)
    {
        $data['simulation'] = $this->simulation_model->get_simulation_by_id($id);
        $this->load->view('admin/edit_main_content', $data);
    }
    
    /**
 * Update simulation
 * @param int $id
 */
    public function update($id) 
    {
        
        $this->load->helper(array('form', 'url'));
        
        // Set upload configuration
        $config['upload_path'] = './assets_system/images/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = FALSE;
        $config['remove_spaces'] = TRUE;
        
        // Create directory if it doesn't exist
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }
    
        // Initialize upload library with config
        $this->upload->initialize($config);
    
        // Get existing data
        $existing = $this->simulation_model->get_simulation_by_id($id);
        
        if (!$existing) {
            echo json_encode(array('success' => false, 'message' => 'Case study not found'));
            return;
        }
        
        // Prepare data array
        $simulation_data = array(
            'title' => $this->input->post('title'),
            'client' => $this->input->post('client'),
            'analysis_type' => $this->input->post('analysis_type'),
            'abstract' => $this->input->post('abstract'),
            'problem' => $this->input->post('problem'),
            'study' => $this->input->post('study'),
            'root_cause' => $this->input->post('root_cause'),
            'solution' => $this->input->post('solution'),
            'qualitative_benefits' => $this->input->post('qualitative_benefits'),
            
            // Metrics
            'prototype_without' => $this->input->post('prototype_without'),
            'prototype_with' => $this->input->post('prototype_with'),
            'prototype_reduction' => $this->input->post('prototype_reduction'),
            'testing_without' => $this->input->post('testing_without'),
            'testing_with' => $this->input->post('testing_with'),
            'testing_reduction' => $this->input->post('testing_reduction'),
            'development_without' => $this->input->post('development_without'),
            'development_with' => $this->input->post('development_with'),
            'development_reduction' => $this->input->post('development_reduction'),
            
            
            // Timestamp
            'updated_at' => date('Y-m-d H:i:s')
        );
    
        // Handle Main Image Upload
        if (isset($_FILES['main_image_file']) && $_FILES['main_image_file']['error'] == 0) {
            $_FILES['main_image']['name'] = $_FILES['main_image_file']['name'];
            $_FILES['main_image']['type'] = $_FILES['main_image_file']['type'];
            $_FILES['main_image']['tmp_name'] = $_FILES['main_image_file']['tmp_name'];
            $_FILES['main_image']['error'] = $_FILES['main_image_file']['error'];
            $_FILES['main_image']['size'] = $_FILES['main_image_file']['size'];
    
            $config['file_name'] = 'main_' . time() . '_' . rand(1000, 9999);
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('main_image')) {
                // Delete old image if exists
                if (!empty($existing->main_image)) {
                    $old_file = './assets_system/images/' . $existing->main_image;
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                }
                
                $upload_data = $this->upload->data();
                $simulation_data['main_image'] = $upload_data['file_name'];
            } else {
                $error = $this->upload->display_errors();
                echo json_encode(array('success' => false, 'message' => 'Main image upload failed: ' . $error));
                return;
            }
        } else {
            // Keep existing image
            $simulation_data['main_image'] = $this->input->post('main_image_filename');
        }
    
        // Handle Actual Image Upload
        if (isset($_FILES['actual_image_file']) && $_FILES['actual_image_file']['error'] == 0) {
            $_FILES['actual_image']['name'] = $_FILES['actual_image_file']['name'];
            $_FILES['actual_image']['type'] = $_FILES['actual_image_file']['type'];
            $_FILES['actual_image']['tmp_name'] = $_FILES['actual_image_file']['tmp_name'];
            $_FILES['actual_image']['error'] = $_FILES['actual_image_file']['error'];
            $_FILES['actual_image']['size'] = $_FILES['actual_image_file']['size'];
    
            $config['file_name'] = 'actual_' . time() . '_' . rand(1000, 9999);
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('actual_image')) {
                // Delete old image if exists
                if (!empty($existing->actual_image_filename)) {
                    $old_file = './assets_system/images/' . $existing->actual_image_filename;
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                }
                
                $upload_data = $this->upload->data();
                $simulation_data['actual_image_filename'] = $upload_data['file_name'];
            } else {
                $error = $this->upload->display_errors();
                echo json_encode(array('success' => false, 'message' => 'Actual image upload failed: ' . $error));
                return;
            }
        } else {
            // Keep existing image
            $simulation_data['actual_image_filename'] = $this->input->post('actual_image_filename');
        }
    
        // Handle Simulation Image Upload
        if (isset($_FILES['simulation_image_file']) && $_FILES['simulation_image_file']['error'] == 0) {
            $_FILES['simulation_image']['name'] = $_FILES['simulation_image_file']['name'];
            $_FILES['simulation_image']['type'] = $_FILES['simulation_image_file']['type'];
            $_FILES['simulation_image']['tmp_name'] = $_FILES['simulation_image_file']['tmp_name'];
            $_FILES['simulation_image']['error'] = $_FILES['simulation_image_file']['error'];
            $_FILES['simulation_image']['size'] = $_FILES['simulation_image_file']['size'];
    
            $config['file_name'] = 'simulation_' . time() . '_' . rand(1000, 9999);
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('simulation_image')) {
                // Delete old image if exists
                if (!empty($existing->simulation_image_filename)) {
                    $old_file = './assets_system/images/' . $existing->simulation_image_filename;
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                }
                
                $upload_data = $this->upload->data();
                $simulation_data['simulation_image_filename'] = $upload_data['file_name'];
            } else {
                $error = $this->upload->display_errors();
                echo json_encode(array('success' => false, 'message' => 'Simulation image upload failed: ' . $error));
                return;
            }
        } else {
            // Keep existing image
            $simulation_data['simulation_image_filename'] = $this->input->post('simulation_image_filename');
        }
    
        // Remove empty values for metrics to avoid NULL issues
        $fields = ['prototype_without', 'prototype_with', 'prototype_reduction', 
                  'testing_without', 'testing_with', 'testing_reduction',
                  'development_without', 'development_with', 'development_reduction',
                  'actual_image_filename', 'simulation_image_filename', 'main_image'];
        
        foreach ($fields as $field) {
            if (isset($simulation_data[$field]) && $simulation_data[$field] === '') {
                $simulation_data[$field] = NULL;
            }
        }
    
        // Update database
        $result = $this->simulation_model->update_simulation($id, $simulation_data);
    
        if ($result) {
            echo json_encode(array(
                'success' => true,
                'message' => 'Case study updated successfully',
                'redirect_url' => base_url('cms/simulation_analysis')
            ));
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'Failed to update case study'
            ));
        }
    }
    
    /**
 * Add new simulation (Save method)
 */
    public function add_simulation() 
    {
        header('Content-Type: application/json');
        $this->load->helper(array('form', 'url'));
        
        // Set upload configuration
        $config['upload_path'] = './assets_system/images/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = FALSE;
        $config['remove_spaces'] = TRUE;
        
        // Create directory if it doesn't exist
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }
    
        // Initialize upload library
        $this->upload->initialize($config);
    
        // Prepare data array
        $simulation_data = array(
            'title' => $this->input->post('title'),
            'client' => $this->input->post('client'),
            'analysis_type' => $this->input->post('analysis_type'),
            'abstract' => $this->input->post('abstract'),
            'problem' => $this->input->post('problem'),
            'study' => $this->input->post('study'),
            'root_cause' => $this->input->post('root_cause'),
            'solution' => $this->input->post('solution'),
            'qualitative_benefits' => $this->input->post('qualitative_benefits'),
            
            // Metrics
            'prototype_without' => $this->input->post('prototype_without'),
            'prototype_with' => $this->input->post('prototype_with'),
            'prototype_reduction' => $this->input->post('prototype_reduction'),
            'testing_without' => $this->input->post('testing_without'),
            'testing_with' => $this->input->post('testing_with'),
            'testing_reduction' => $this->input->post('testing_reduction'),
            'development_without' => $this->input->post('development_without'),
            'development_with' => $this->input->post('development_with'),
            'development_reduction' => $this->input->post('development_reduction'),
            
            // Timestamps
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
    
        // Handle Main Image Upload
        if (isset($_FILES['main_image_file']) && $_FILES['main_image_file']['error'] == 0) {
            $_FILES['main_image']['name'] = $_FILES['main_image_file']['name'];
            $_FILES['main_image']['type'] = $_FILES['main_image_file']['type'];
            $_FILES['main_image']['tmp_name'] = $_FILES['main_image_file']['tmp_name'];
            $_FILES['main_image']['error'] = $_FILES['main_image_file']['error'];
            $_FILES['main_image']['size'] = $_FILES['main_image_file']['size'];
    
            $config['file_name'] = 'main_' . time() . '_' . rand(1000, 9999);
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('main_image')) {
                $upload_data = $this->upload->data();
                $simulation_data['main_image'] = $upload_data['file_name'];
            } else {
                $error = $this->upload->display_errors();
                echo json_encode(array('success' => false, 'message' => 'Main image upload failed: ' . $error));
                return;
            }
        } else {
            // If no image uploaded, set to empty string (will be handled by model)
            $simulation_data['main_image'] = NULL;
        }
    
        // Handle Actual Image Upload
        if (isset($_FILES['actual_image_file']) && $_FILES['actual_image_file']['error'] == 0) {
            $_FILES['actual_image']['name'] = $_FILES['actual_image_file']['name'];
            $_FILES['actual_image']['type'] = $_FILES['actual_image_file']['type'];
            $_FILES['actual_image']['tmp_name'] = $_FILES['actual_image_file']['tmp_name'];
            $_FILES['actual_image']['error'] = $_FILES['actual_image_file']['error'];
            $_FILES['actual_image']['size'] = $_FILES['actual_image_file']['size'];
    
            $config['file_name'] = 'actual_' . time() . '_' . rand(1000, 9999);
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('actual_image')) {
                $upload_data = $this->upload->data();
                $simulation_data['actual_image_filename'] = $upload_data['file_name'];
            } else {
                $error = $this->upload->display_errors();
                echo json_encode(array('success' => false, 'message' => 'Actual image upload failed: ' . $error));
                return;
            }
        }
    
        // Handle Simulation Image Upload
        if (isset($_FILES['simulation_image_file']) && $_FILES['simulation_image_file']['error'] == 0) {
            $_FILES['simulation_image']['name'] = $_FILES['simulation_image_file']['name'];
            $_FILES['simulation_image']['type'] = $_FILES['simulation_image_file']['type'];
            $_FILES['simulation_image']['tmp_name'] = $_FILES['simulation_image_file']['tmp_name'];
            $_FILES['simulation_image']['error'] = $_FILES['simulation_image_file']['error'];
            $_FILES['simulation_image']['size'] = $_FILES['simulation_image_file']['size'];
    
            $config['file_name'] = 'simulation_' . time() . '_' . rand(1000, 9999);
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('simulation_image')) {
                $upload_data = $this->upload->data();
                $simulation_data['simulation_image_filename'] = $upload_data['file_name'];
            } else {
                $error = $this->upload->display_errors();
                echo json_encode(array('success' => false, 'message' => 'Simulation image upload failed: ' . $error));
                return;
            }
        }
    
        // Remove empty values for metrics to avoid NULL issues
        $fields = ['prototype_without', 'prototype_with', 'prototype_reduction', 
                  'testing_without', 'testing_with', 'testing_reduction',
                  'development_without', 'development_with', 'development_reduction',
                  'actual_image_filename', 'simulation_image_filename', 'main_image'];
        
        foreach ($fields as $field) {
            if (isset($simulation_data[$field]) && ($simulation_data[$field] === '' || $simulation_data[$field] === NULL)) {
                $simulation_data[$field] = NULL;
            }
        }
    
        // Save to database
        $result = $this->simulation_model->save_simulation($simulation_data);
    
        if ($result) {
            echo json_encode(array(
                'success' => true,
                'message' => 'Case study created successfully',
                'redirect_url' => base_url('cms/simulation_analysis')
            ));
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'Failed to save case study to database'
            ));
        }
    }
    
    // In your controller 
    public function video_submissions() {
        $data['videos'] = $this->Video_model->get_video_submissions();
        
        // Get dashboard stats
        $data['stats'] = [
            'total_submissions' => $this->Video_model->get_total_submissions(),
            'today_submissions' => $this->Video_model->get_today_submissions(),
            'video_count' => $this->Video_model->get_count_by_type('video'),
            'pdf_count' => $this->Video_model->get_count_by_type('pdf'),
            'other_count' => $this->Video_model->get_count_by_type('other')
        ];
        
        // Load view
        $this->load->view('admin/video_submissions', $data);
    }
    
    // In your controller 
    public function download_submissions() {
        $data['downloads'] = $this->Download_model->get_download_submissions();
        
        // Get dashboard stats
        $data['stats'] = [
            'total_downloads' => $this->Download_model->get_total_downloads(),
            'today_downloads' => $this->Download_model->get_today_downloads(),
            'unique_files' => $this->Download_model->get_unique_files_count(),
            'top_files' => $this->Download_model->get_top_downloaded_files(5)
        ];
        
        // Load view
        $this->load->view('admin/download_submissions', $data);
    }
    
    public function footer()
    {
    
        $data = [];
        $data['title'] = 'Footer Management';
        
        // Get all items and organize them
        $all_items = $this->footer_model->get_all_items();
        
        // Separate social items and other items
        $data['social_items'] = array_filter($all_items, function($item) {
            return strpos($item['title'], 'social_') === 0;
        });
        
        // Get copyright item
        $data['copyright_item'] = null;
        foreach ($all_items as $item) {
            if ($item['title'] === 'copyright') {
                $data['copyright_item'] = $item;
                break;
            }
        }
        
        // Sort social items by sort_order
        usort($data['social_items'], function($a, $b) {
            return ($a['sort_order'] ?? 0) - ($b['sort_order'] ?? 0);
        });
        
        $data['categories'] = $this->footer_model->get_categories_with_counts();
        
        $contact_items = $this->footer_model->get_footer_items_by_type('contact');
        $data['contact_title'] = null;
        $data['contact_description'] = null;
        
        foreach ($contact_items as $item) {
            if ($item['title'] == 'contact_section_title') {
                $data['contact_title'] = $item;
            }
            if ($item['title'] == 'contact_section_description') {
                $data['contact_description'] = $item;
            }
        }
        
        $this->load->view('admin/header');
        $this->load->view('admin/footer', $data);
    }
    
    public function footer_add_social()
    {
        ob_clean();
        header('Content-Type: application/json');
        
      
        $platform = $this->input->post('platform');
        $icon_class = $this->input->post('icon_class') ?: 'fa-' . $platform;
        
        if (!$platform) {
            echo json_encode(['success' => false, 'message' => 'Platform is required']);
            return;
        }
        
    
        
        $data = [
            'title' => 'social_' . $platform,
            'content' => '',
            'icon_class' => $icon_class, // Save the icon class
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'edited_by' => $this->session->userdata('user_id') ?: 1
        ];
        
        $insert = $this->footer_model->create_item($data);
        
        if ($insert) {
            $insert_id = $this->db->insert_id();
            
            $response = [
                'success' => true, 
                'id' => $insert_id, 
                'title' => $data['title'],
                'platform' => $platform,
                'icon_class' => $icon_class
            ];
        } else {
            $response = [
                'success' => false, 
                'message' => 'Failed to add social item'
            ];
        }
        
        echo json_encode($response);
        return;
    }

    public function footer_delete_social()
    {
       
        
        
        $id = $this->input->post('id');
        
        // Verify it's a social item before deleting
        $item = $this->footer_model->get_item($id);
        if (!$item || strpos($item['title'], 'social_') !== 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid item']);
            return;
        }
        
        if ($this->footer_model->delete_item($id)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete social item']);
        }
    }
    
    public function footer_save_item() {
        $this->output->set_content_type('application/json');
        
        $response = ['success' => false, 'message' => ''];
        
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $content = $this->input->post('content');
        $image = $this->input->post('image');
        
        $data = [
            'title' => $title,
            'content' => $content,
            'image' => $image,
            'edited_by' => $this->session->userdata('user_id') ?: 1
        ];
        
        if ($id) {
            // Update existing
            if ($this->footer_model->update_item($id, $data)) {
                $response['success'] = true;
                $response['message'] = 'Item updated successfully!';
            } else {
                $response['message'] = 'Failed to update item.';
            }
        } else {
            // Create new
            if ($this->footer_model->create_item($data)) {
                $response['success'] = true;
                $response['message'] = 'Item created successfully!';
            } else {
                $response['message'] = 'Failed to create item.';
            }
        }
        
        echo json_encode($response);
    }
    
    // AJAX: Delete item
    public function footer_delete_item() {
        $this->output->set_content_type('application/json');
        
        $response = ['success' => false, 'message' => ''];
        
        $id = $this->input->post('id');
        
        if ($id && $this->footer_model->delete_item($id)) {
            $response['success'] = true;
            $response['message'] = 'Item deleted successfully!';
        } else {
            $response['message'] = 'Failed to delete item.';
        }
        
        echo json_encode($response);
    }
    
    // AJAX: Get item data
    public function footer_get_item() {
        $this->output->set_content_type('application/json');
        
        $response = ['success' => false, 'data' => null];
        
        $id = $this->input->post('id');
        
        if ($id) {
            $item = $this->footer_model->get_item($id);
            if ($item) {
                $response['success'] = true;
                $response['data'] = $item;
            } else {
                $response['message'] = 'Item not found.';
            }
        }
        
        echo json_encode($response);
    }
    
    // AJAX: Upload image
    public function footer_upload_image() {
        $this->output->set_content_type('application/json');
        
        $response = ['success' => false, 'message' => '', 'filename' => ''];
        
        if (!empty($_FILES['image']['name'])) {
            $upload_result = $this->footer_model->upload_image('image');
            
            if ($upload_result['success']) {
                $response['success'] = true;
                $response['message'] = 'Image uploaded successfully!';
                $response['filename'] = $upload_result['data']['file_name'];
            } else {
                $response['message'] = $upload_result['error'];
            }
        } else {
            $response['message'] = 'No file selected.';
        }
        
        echo json_encode($response);
    }
    
    // AJAX: Save all quick edits
    public function footer_save_all()
    {
        // Turn off error display but log them
        ini_set('display_errors', 0);
        error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
        
        // Start output buffering to catch any stray output
        ob_start();
        
        try {
            $response = ['success' => false, 'message' => 'Initial state'];
            
            // Load the model
            $this->load->model('footer_model');
            
            $post_data = $this->input->post();
            
            // Debug log
            log_message('debug', 'Footer save called. POST data: ' . print_r($post_data, true));
            
            if (empty($post_data)) {
                // Try to get raw input
                $raw_input = file_get_contents('php://input');
                if (!empty($raw_input)) {
                    parse_str($raw_input, $post_data);
                }
            }
            
            $items_data = [];
            $updated_count = 0;
            
            if (!empty($post_data)) {
                foreach ($post_data as $key => $value) {
                    // Handle item_ prefixed fields (social media items)
                    if (strpos($key, 'item_') === 0) {
                        $id = str_replace('item_', '', $key);
                        
                        if (is_numeric($id)) {
                            $items_data[] = [
                                'id' => (int)$id,
                                'content' => trim($value),
                                'edited_by' => $this->session->userdata('user_id') ?: 1
                            ];
                        }
                    }
                    
                    // Handle contact_section_title field
                    if ($key === 'contact_section_title') {
                        // Check if it has data-id attribute (exists in database)
                        $data_id = $this->input->post('data-id-' . $key) ?? null;
                        
                        if ($data_id) {
                            // Update by ID
                            $items_data[] = [
                                'id' => (int)$data_id,
                                'content' => trim($value),
                                'edited_by' => $this->session->userdata('user_id') ?: 1
                            ];
                        } else {
                            // Update by title
                            $item = $this->footer_model->get_footer_item('contact_section_title');
                            if ($item) {
                                $items_data[] = [
                                    'id' => $item['id'],
                                    'content' => trim($value),
                                    'edited_by' => $this->session->userdata('user_id') ?: 1
                                ];
                            }
                        }
                    }
                    
                    // Handle contact_section_description field
                    if ($key === 'contact_section_description') {
                        // Check if it has data-id attribute (exists in database)
                        $data_id = $this->input->post('data-id-' . $key) ?? null;
                        
                        if ($data_id) {
                            // Update by ID
                            $items_data[] = [
                                'id' => (int)$data_id,
                                'content' => trim($value),
                                'edited_by' => $this->session->userdata('user_id') ?: 1
                            ];
                        } else {
                            // Update by title
                            $item = $this->footer_model->get_footer_item('contact_section_description');
                            if ($item) {
                                $items_data[] = [
                                    'id' => $item['id'],
                                    'content' => trim($value),
                                    'edited_by' => $this->session->userdata('user_id') ?: 1
                                ];
                            }
                        }
                    }
                }
                
                log_message('debug', 'Items to update: ' . count($items_data));
                
                // Update all items (social + contact fields)
                if (!empty($items_data)) {
                    $result = $this->footer_model->update_batch_items($items_data);
                    if ($result !== false) {
                        $updated_count = count($items_data);
                    }
                }
                
                if ($updated_count > 0) {
                    $response['success'] = true;
                    $response['message'] = 'Updated ' . $updated_count . ' items successfully';
                    $response['updated'] = $updated_count;
                } else {
                    // Check if there was any data at all
                    if (!empty($post_data)) {
                        $response['success'] = true;
                        $response['message'] = 'Changes saved successfully';
                    } else {
                        $response['message'] = 'No items were updated';
                    }
                }
                
            } else {
                $response['message'] = 'No POST data received';
            }
            
        } catch (Exception $e) {
            $response['message'] = 'Exception: ' . $e->getMessage();
            $response['trace'] = $e->getTraceAsString();
            log_message('error', 'Footer save exception: ' . $e->getMessage());
        }
        
        // Clear output buffer
        ob_clean();
        
        // Send JSON response
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    private function output_json_response($response) 
    {
        // Get any buffered output
        $buffer = ob_get_clean();
        
        // If there was unexpected output, include it in the response
        if (!empty($buffer)) {
            $response['unexpected_output'] = $buffer;
            log_message('error', 'Unexpected output in footer_save_all: ' . $buffer);
        }
        
        // Clear any other output and send JSON
        if (ob_get_length()) ob_clean();
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
        
        return;
    }

    public function footer_update_sort_order()
    {
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }
        
        $this->load->model('footer_model');
        
        $order = $this->input->post('order');
        if (!is_array($order)) {
            echo json_encode(['success' => false, 'message' => 'Invalid order data']);
            return;
        }
        
        $this->db->trans_start();
        
        foreach ($order as $index => $id) {
            $this->db->where('id', $id);
            $this->db->update('tbl_footer', ['sort_order' => $index]);
        }
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update order']);
        }
    }
    
    // AJAX: Get items by category
    public function footer_get_category_items() {
        $this->output->set_content_type('application/json');
        
        $response = ['success' => false, 'data' => []];
        
        $category = $this->input->post('category');
        
        if ($category) {
            $items = $this->footer_model->get_by_category($category);
            $response['success'] = true;
            $response['data'] = $items;
        }
        
        echo json_encode($response);
    }

public function home() {
    $data['cms_data'] = $this->cms_model->get_home_content();
    // Fetch carousel specifically
    $data['carousel_slides'] = $this->cms_model->get_carousel_slides();
    $data['categories'] = $this->cms_model->get_categories();
    $data['stats']  = $this->cms_model->get_stats();
    $data['services'] = $this->cms_model->get_services_data();
    $this->db->where('is_active', 1);
        $this->db->order_by('sort_order', 'ASC');
        $this->db->order_by('year', 'DESC');
        $query = $this->db->get('tbl_achievements');
        $data['achievements'] = $query->result_array();
    $this->load->view('admin/home', $data);
}

// Save achievements
public function save_achievements() {
    if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
    
    $success = true;
    $message = 'Achievements saved successfully!';
    
    $achievements_json = $this->input->post('achievements_json');
    $achievements = json_decode($achievements_json, true);
    
    if (!empty($achievements)) {
        foreach ($achievements as $achievement) {
            $data = [
                'title' => $achievement['title'],
                'content' => $achievement['content'],
                'year' => $achievement['year'],
                'sort_order' => $achievement['sort_order'],
                'is_active' => $achievement['is_active'],
                'edited_by' => $this->session->userdata('user_id'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            // Handle image upload
            $achievement_id = $achievement['id'];
            if (isset($_FILES['achievement_image_' . $achievement_id]) && $_FILES['achievement_image_' . $achievement_id]['error'] == 0) {
                $config['upload_path'] = './assets_system/images/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = 2048;
                $config['encrypt_name'] = TRUE;
                
                $this->load->library('upload');
                $this->upload->initialize($config);

                if ($this->upload->do_upload('achievement_image_' . $achievement_id)) {
                    $upload_data = $this->upload->data();
                    $data['image'] = $upload_data['file_name'];
                }
            } else {
                // Keep existing image
                $existing_image = $this->input->post('existing_achievement_image_' . $achievement_id);
                if ($existing_image) {
                    $data['image'] = $existing_image;
                }
            }
            
            // Handle icon upload
            if (isset($_FILES['achievement_icon_' . $achievement_id]) && $_FILES['achievement_icon_' . $achievement_id]['error'] == 0) {
                $config['upload_path'] = './assets_system/images/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif|svg';
                $config['max_size'] = 1024;
                $config['encrypt_name'] = TRUE;
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('achievement_icon_' . $achievement_id)) {
                    $upload_data = $this->upload->data();
                    $data['icon'] = $upload_data['file_name'];
                }
            } else {
                // Keep existing icon
                $existing_icon = $this->input->post('existing_achievement_icon_' . $achievement_id);
                if ($existing_icon) {
                    $data['icon'] = $existing_icon;
                }
            }
            
            if (strpos($achievement_id, 'new_') === 0) {
                // Insert new achievement
                $data['created_at'] = date('Y-m-d H:i:s');
                $insert = $this->db->insert('tbl_achievements', $data);
                if (!$insert) $success = false;
            } else {
                // Update existing achievement
                $this->db->where('id', $achievement_id);
                $update = $this->db->update('tbl_achievements', $data);
                if (!$update) $success = false;
            }
        }
    }
    
    echo json_encode([
        'status' => $success ? 'success' : 'error',
        'message' => $success ? $message : 'Failed to save some achievements'
    ]);
}

// Delete achievement
public function delete_achievement() {
    if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
    
    $id = $this->input->post('id');
    
    if ($id) {
        // Optional: Delete image files from server
        $this->db->select('image, icon');
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_achievements');
        $achievement = $query->row_array();
        
        if ($achievement) {
            if (!empty($achievement['image']) && file_exists('./assets_system/images/' . $achievement['image'])) {
                unlink('./assets_system/images/' . $achievement['image']);
            }
            if (!empty($achievement['icon']) && file_exists('./assets_system/images/' . $achievement['icon'])) {
                unlink('./assets_system/images/' . $achievement['icon']);
            }
        }
        
        $this->db->where('id', $id);
        $delete = $this->db->delete('tbl_achievements');
        
        if ($delete) {
            echo json_encode(['status' => 'success', 'message' => 'Achievement deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete achievement']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid achievement ID']);
    }
}

public function save_new_products()
{
    // Process file uploads
    $config['upload_path'] = './assets_system/images/';
    $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
    $config['max_size'] = 2048; // 2MB
    $config['encrypt_name'] = true;
    
    $this->load->library('upload', $config);
                $this->upload->initialize($config);
    
    // Prepare data array
    $data = [
        'new_badge' => $this->input->post('new_badge'),
        'new_product_header' => $this->input->post('new_product_header'),
        'new_product_text' => $this->input->post('new_product_text'),
        'new_product_button' => $this->input->post('new_product_button'),
        'new_product_image' => $this->input->post('existing_new_product_image') ?: '',
        'features' => []
    ];
    
    // Upload main image
    if (!empty($_FILES['new_product_image_file']['name'])) {
        if ($this->upload->do_upload('new_product_image_file')) {
            $upload_data = $this->upload->data();
            $data['new_product_image'] = $upload_data['file_name'];
            
            // Delete old image if exists
            $old_image = $this->input->post('existing_new_product_image');
            if (!empty($old_image) && file_exists('./assets_system/images/' . $old_image)) {
                @unlink('./assets_system/images/' . $old_image);
            }
        } else {
            echo json_encode([
                'status' => 'error', 
                'message' => 'Main image upload failed: ' . $this->upload->display_errors()
            ]);
            return;
        }
    }
    
    // Process features (1-4)
    for ($i = 1; $i <= 4; $i++) {
        $feature_data = [
            'title' => $this->input->post('new_prod_feat_' . $i) ?: '',
            'image' => $this->input->post('existing_feat_image_' . $i) ?: ''
        ];
        
        // Upload feature image if provided
        $file_key = 'feat_image_' . $i . '_file';
        if (!empty($_FILES[$file_key]['name'])) {
            if ($this->upload->do_upload($file_key)) {
                $upload_data = $this->upload->data();
                $feature_data['image'] = $upload_data['file_name'];
                
                // Delete old image if exists
                $old_feat_image = $this->input->post('existing_feat_image_' . $i);
                if (!empty($old_feat_image) && file_exists('./assets_system/images/' . $old_feat_image)) {
                    @unlink('./assets_system/images/' . $old_feat_image);
                }
            } else {
                echo json_encode([
                    'status' => 'error', 
                    'message' => "Feature $i image upload failed: " . $this->upload->display_errors()
                ]);
                return;
            }
        }
        
        $data['features'][$i] = $feature_data;
    }
    
    // Save to database
    $result = $this->cms_model->save_new_products_data($data);
    
    if ($result) {
        echo json_encode([
            'status' => 'success',
            'message' => 'New products section updated successfully'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update new products section'
        ]);
    }
}

// Sa CMS controller, magdagdag ng method:
public function delete_carousel_slide()
{
   
    
    $slide_id = $this->input->post('slide_id');
    $response = array();
    
    if(!empty($slide_id)) {
        // Delete from database
        $result = $this->cms_model->delete_carousel_slide($slide_id);
        
        if($result) {
            $response['status'] = 'success';
            $response['message'] = 'Slide deleted successfully';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to delete slide';
        }
    } else {
        // For new slides that haven't been saved yet
        $response['status'] = 'success';
        $response['message'] = 'Slide removed from UI';
    }
    
    echo json_encode($response);
}

    // In your CMS controller
    public function home_upload_image()
{
    $config['upload_path'] = FCPATH . 'assets_system/images/';
    $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
    $config['max_size'] = 2048;
    $config['encrypt_name'] = TRUE;
    
    $this->load->library('upload', $config);
                $this->upload->initialize($config);
    
    if ($this->upload->do_upload('image')) {
        $data = $this->upload->data();
        $filename = $data['file_name'];
        
        // Send to website via API
        $this->send_to_website_api($data['full_path'], $filename);
        
        echo json_encode([
            'status' => 'success',
            'filename' => $filename
        ]);
    }
}

private function send_to_website_api($file_path, $filename)
{
    $website_url = 'https://lineseiki.systems-test.com/index/upload_image';
    $api_key = 'YOUR_SECURE_API_KEY';
    
    $post_data = [
        'api_key' => $api_key,
        'filename' => $filename
    ];
    
    $file_data = file_get_contents($file_path);
    $post_data['file'] = base64_encode($file_data);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $website_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}

 public function save_home_changes() {
    if (!$this->input->is_ajax_request()) exit('No direct script access allowed');

    $success = true;
    $slide_ids = [];

    // 1. Handle Carousel Syncing
    $carousel_count = $this->input->post('carousel_count');
    $slides = [];
    for ($i = 1; $i <= $carousel_count; $i++) {
        $slides[] = [
            'hero_text'     => $this->input->post('hero_text_'.$i) ?: '',
            'hero_sub_text' => $this->input->post('hero_sub_text_'.$i) ?: '',
            'hero_image'    => $this->input->post('hero_image_'.$i) ?: '',
            'hero_bg_img'   => $this->input->post('hero_bg_img_'.$i) ?: '',
            'created_at'    => date('Y-m-d H:i:s')
        ];
    }
    
    $carousel_result = $this->cms_model->sync_carousel($slides);
    if (!$carousel_result) {
        $success = false;
    } else {
        if (is_array($carousel_result)) {
            $slide_ids = $carousel_result;
        }
    }

    // 2. Handle Legacy CMS data
    $cms_fields = [
        'trusted_badge', 'legacy_header', 'legacy_text',
        'timeline_years', 'timeline_label'
    ];
    
    foreach ($cms_fields as $field) {
        $value = $this->input->post($field) ?: '';
        $update = $this->cms_model->update_content($field, ['content' => $value]);
        if (!$update) $success = false;
    }

    // 3. Handle dynamic categories from form data
    $category_titles = $this->input->post('category_title[]');
    $category_texts = $this->input->post('category_text[]');
    $category_ids = $this->input->post('category_id[]');
    
    if ($category_titles && $category_texts) {
        $categories = [];
        foreach ($category_titles as $index => $title) {
            $categories[] = [
                'id' => isset($category_ids[$index]) ? $category_ids[$index] : null,
                'title' => $title ?: '',
                'text' => isset($category_texts[$index]) ? $category_texts[$index] : ''
            ];
        }
        
        // Save categories
        $category_ids_result = [];
        foreach ($categories as $category) {
            if (!empty($category['id'])) {
                // Update existing
                $this->cms_model->update_category($category['id'], [
                    'title' => $category['title'],
                    'text' => $category['text']
                ]);
                $category_ids_result[] = $category['id'];
            } else {
                // Insert new
                $new_id = $this->cms_model->add_category([
                    'title' => $category['title'],
                    'text' => $category['text']
                ]);
                $category_ids_result[] = $new_id;
            }
        }
    }

    // 4. Handle dynamic statistics from form data
    $stat_numbers = $this->input->post('stat_number[]');
    $stat_labels = $this->input->post('stat_label[]');
    $stat_ids = $this->input->post('stat_id[]');
    
    if ($stat_numbers && $stat_labels) {
        $stats = [];
        foreach ($stat_numbers as $index => $number) {
            $stats[] = [
                'id' => isset($stat_ids[$index]) ? $stat_ids[$index] : null,
                'stat_number' => $number ?: '',
                'stat_label' => isset($stat_labels[$index]) ? $stat_labels[$index] : ''
            ];
        }
        
        // Save statistics
        $stat_ids_result = [];
        foreach ($stats as $stat) {
            if (!empty($stat['id'])) {
                // Update existing
                $this->cms_model->update_stat($stat['id'], [
                    'stat_number' => $stat['stat_number'],
                    'stat_label' => $stat['stat_label']
                ]);
                $stat_ids_result[] = $stat['id'];
            } else {
                // Insert new
                $new_id = $this->cms_model->add_stat([
                    'stat_number' => $stat['stat_number'],
                    'stat_label' => $stat['stat_label']
                ]);
                $stat_ids_result[] = $new_id;
            }
        }
    }

    // 5. Handle Services Section
    // Save services tagline
    $services_tagline = $this->input->post('services_tagline') ?: '';
    $update = $this->cms_model->update_content('serv_tagline', ['content' => $services_tagline]);
    if (!$update) $success = false;

    // Save services data (3 fixed services)
    for ($i = 1; $i <= 3; $i++) {
        // Save service badge
        $service_badge = $this->input->post('service_badge_' . $i) ?: '';
        $update = $this->cms_model->update_content('serv_badge_' . $i, ['content' => $service_badge]);
        if (!$update) $success = false;

        // Save service title
        $service_title = $this->input->post('service_title_' . $i) ?: '';
        $update = $this->cms_model->update_content('serv_title_' . $i, ['content' => $service_title]);
        if (!$update) $success = false;

        // Save service description
        $service_description = $this->input->post('service_description_' . $i) ?: '';
        $update = $this->cms_model->update_content('serv_desc_' . $i, ['content' => $service_description]);
        if (!$update) $success = false;

        // Save service link label
        $service_link_label = $this->input->post('service_link_label_' . $i) ?: '';
        $update = $this->cms_model->update_content('serv_link_label_' . $i, ['content' => $service_link_label]);
        if (!$update) $success = false;

        // Save featured badge
        $service_featured_badge = $this->input->post('service_featured_badge_' . $i) ?: '';
        $update = $this->cms_model->update_content('feat_badge_' . $i, ['content' => $service_featured_badge]);
        if (!$update) $success = false;

        // Save service features - FIXED VERSION
        $service_features = $this->input->post('service_features_' . $i);
        
        // Only update if features are provided
        if ($service_features !== null) {
            $features = explode("\n", $service_features);
            $features = array_map('trim', $features);
            $features = array_filter($features); // Remove empty lines
            
            // Save up to 4 features
            $max_features = 4;
            
            if ($i == 1) {
                // Service 1: serv_feat_1, serv_feat_2, serv_feat_3, serv_feat_4
                for ($j = 1; $j <= $max_features; $j++) {
                    $feature_content = isset($features[$j-1]) ? $features[$j-1] : '';
                    $update = $this->cms_model->update_content('serv_feat_' . $j, ['content' => $feature_content]);
                    if (!$update) $success = false;
                }
            } elseif ($i == 2) {
                // Service 2: serv_feat_2_1, serv_feat_2_2, serv_feat_2_3, serv_feat_2_4
                for ($j = 1; $j <= $max_features; $j++) {
                    $feature_content = isset($features[$j-1]) ? $features[$j-1] : '';
                    $update = $this->cms_model->update_content('serv_feat_2_' . $j, ['content' => $feature_content]);
                    if (!$update) $success = false;
                }
            } elseif ($i == 3) {
                // Service 3: serv_feat_3_1, serv_feat_3_2, serv_feat_3_3, serv_feat_3_4
                for ($j = 1; $j <= $max_features; $j++) {
                    $feature_content = isset($features[$j-1]) ? $features[$j-1] : '';
                    $update = $this->cms_model->update_content('serv_feat_3_' . $j, ['content' => $feature_content]);
                    if (!$update) $success = false;
                }
            }
        }

        // Handle service image upload
        if (isset($_FILES['service_image_file_' . $i]) && $_FILES['service_image_file_' . $i]['error'] == 0) {
            $config['upload_path'] = './assets_system/images/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // 2MB
            $config['encrypt_name'] = TRUE;
            
            $this->load->library('upload', $config);
                $this->upload->initialize($config);
            
            if ($this->upload->do_upload('service_image_file_' . $i)) {
                $upload_data = $this->upload->data();
                $filename = $upload_data['file_name'];
                
                // Update database with new image filename
                $update = $this->cms_model->update_content('serv_image_' . $i, [
                    'content' => $filename,
                    'image' => $filename
                ]);
                if (!$update) $success = false;
            } else {
                $success = false;
                error_log('Service ' . $i . ' image upload error: ' . $this->upload->display_errors());
            }
        }
    }

    // 5b. Handle CTA / Brochure Section
    $cta_fields = ['cta_heading', 'cta_subtitle', 'cta_btn_primary', 'cta_btn_brochure', 'cta_brochure'];
    foreach ($cta_fields as $field) {
        $value = $this->input->post($field) ?: '';
        $update = $this->cms_model->update_content($field, ['content' => $value]);
        if (!$update) $success = false;
    }

    // 6. Handle New Products Section
    $new_product_fields = [
        'new_badge' => 'new_badge',
        'new_product_header' => 'new_product_header',
        'new_product_text' => 'new_product_text',
        'new_product_button' => 'new_product_button'
    ];
    
    foreach ($new_product_fields as $post_field => $db_field) {
        $value = $this->input->post($post_field) ?: '';
        $update = $this->cms_model->update_content($db_field, ['content' => $value]);
        if (!$update) $success = false;
    }
    
    // Handle new product features (1-4)
    for ($i = 1; $i <= 4; $i++) {
        $value = $this->input->post('new_prod_feat_' . $i) ?: '';
        $update = $this->cms_model->update_content('new_prod_feat_' . $i, ['content' => $value]);
        if (!$update) $success = false;
    }
    
    // Handle new product image upload
    if (isset($_FILES['new_product_image_file']) && $_FILES['new_product_image_file']['error'] == 0) {
        $config['upload_path'] = './assets_system/images/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = TRUE;
        
        $this->load->library('upload', $config);
                $this->upload->initialize($config);
        
        if ($this->upload->do_upload('new_product_image_file')) {
            $upload_data = $this->upload->data();
            $filename = $upload_data['file_name'];
            
            $update = $this->cms_model->update_content('new_product_image', [
                'content' => $filename,
                'image' => $filename
            ]);
            if (!$update) $success = false;
        } else {
            $success = false;
            error_log('New product image upload error: ' . $this->upload->display_errors());
        }
    }
    
    // Handle feature images (1-4)
    for ($i = 1; $i <= 4; $i++) {
        if (isset($_FILES['feat_image_' . $i . '_file']) && $_FILES['feat_image_' . $i . '_file']['error'] == 0) {
            $config['upload_path'] = './assets_system/images/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = TRUE;
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('feat_image_' . $i . '_file')) {
                $upload_data = $this->upload->data();
                $filename = $upload_data['file_name'];
                
                $update = $this->cms_model->update_content('feat_image_' . $i, [
                    'content' => $filename,
                    'image' => $filename
                ]);
                if (!$update) $success = false;
            } else {
                $success = false;
                error_log('Feature ' . $i . ' image upload error: ' . $this->upload->display_errors());
            }
        }
    }

    // 7. Handle Achievements Section
    $achievements_json = $this->input->post('achievements_json');
    $achievements = json_decode($achievements_json, true);

    if (!empty($achievements)) {
        $this->load->library('upload');

        foreach ($achievements as $achievement) {
            $data = [
                'title' => $achievement['title'],
                'content' => $achievement['content'],
                'year' => $achievement['year'],
                'sort_order' => $achievement['sort_order'],
                'is_active' => $achievement['is_active'],
                'edited_by' => $this->session->userdata('user_id'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $achievement_id = $achievement['id'];

            // Handle image upload
            if (isset($_FILES['achievement_image_' . $achievement_id]) && $_FILES['achievement_image_' . $achievement_id]['error'] == 0) {
                $config = [
                    'upload_path' => './assets_system/images/',
                    'allowed_types' => 'jpg|jpeg|png|gif',
                    'max_size' => 2048,
                    'encrypt_name' => TRUE
                ];

                $this->upload->initialize($config);

                if ($this->upload->do_upload('achievement_image_' . $achievement_id)) {
                    $upload_data = $this->upload->data();
                    $data['image'] = $upload_data['file_name'];
                }
            } else {
                $existing_image = $this->input->post('existing_achievement_image_' . $achievement_id);
                if ($existing_image) {
                    $data['image'] = $existing_image;
                }
            }

            // Handle icon upload
            if (isset($_FILES['achievement_icon_' . $achievement_id]) && $_FILES['achievement_icon_' . $achievement_id]['error'] == 0) {
                $config = [
                    'upload_path' => './assets_system/images/',
                    'allowed_types' => 'jpg|jpeg|png|gif|svg',
                    'max_size' => 1024,
                    'encrypt_name' => TRUE
                ];

                $this->upload->initialize($config);

                if ($this->upload->do_upload('achievement_icon_' . $achievement_id)) {
                    $upload_data = $this->upload->data();
                    $data['icon'] = $upload_data['file_name'];
                }
            } else {
                $existing_icon = $this->input->post('existing_achievement_icon_' . $achievement_id);
                if ($existing_icon) {
                    $data['icon'] = $existing_icon;
                }
            }

            if (strpos($achievement_id, 'new_') === 0) {
                $data['created_at'] = date('Y-m-d H:i:s');
                $insert = $this->db->insert('tbl_achievements', $data);
                if (!$insert) $success = false;
            } else {
                $this->db->where('id', $achievement_id);
                $update = $this->db->update('tbl_achievements', $data);
                if (!$update) $success = false;
            }
        }
    }

    echo json_encode([
        'status' => ($success ? 'success' : 'error'),
        'message' => ($success ? 'All changes saved successfully!' : 'Error saving changes.'),
        'slide_ids' => $slide_ids
    ]);
}
    
public function save_categories() {
    $this->load->library('upload');
    
    $categories = json_decode($this->input->post('categories'), true);
    $ids = [];
    
    // Configure upload settings
    $config['upload_path'] = './assets_system/images/';
    $config['allowed_types'] = 'jpg|jpeg|png|gif|svg|webp|ico';
    $config['max_size'] = 2048; // 2MB
    $config['encrypt_name'] = TRUE;
    $config['overwrite'] = FALSE;
    
    $this->upload->initialize($config);
    
    if(!empty($categories)) {
        foreach($categories as $category) {
            $data = [
                'title' => $category['title'] ?? '',
                'text' => $category['text'] ?? '',
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $category_id = null;
            
            // Check if this is a new category (starts with 'new_') or existing
            $is_new_category = empty($category['id']) || str_starts_with($category['id'], 'new_');
            
            if(!$is_new_category) {
                // Update existing category
                $this->cms_model->update_category($category['id'], $data);
                $category_id = $category['id'];
                $ids[] = $category['id'];
            } else {
                // Insert new category
                $data['created_at'] = date('Y-m-d H:i:s');
                $newId = $this->cms_model->add_category($data);
                $category_id = $newId;
                $ids[] = $newId;
            }
            
            // Handle icon upload for this category
            if($category_id) {
                $file_input_name = 'category_icon_file_' . $category['id'];
                
                // Check if file was uploaded for this category
                if(isset($_FILES[$file_input_name]) && !empty($_FILES[$file_input_name]['name'])) {
                    
                    if($this->upload->do_upload($file_input_name)) {
                        $upload_data = $this->upload->data();
                        $icon_filename = $upload_data['file_name'];
                        
                        // Update category with icon filename
                        $this->cms_model->update_category_icon($category_id, $icon_filename);
                        
                        // If there was an existing icon, delete it (for updates only)
                        if(!$is_new_category && !empty($this->input->post('existing_category_icon_' . $category['id']))) {
                            $old_icon = $this->input->post('existing_category_icon_' . $category['id']);
                            $old_icon_path = './assets_system/images/' . $old_icon;
                            if(file_exists($old_icon_path) && is_file($old_icon_path) && $old_icon != $icon_filename) {
                                @unlink($old_icon_path);
                            }
                        }
                        
                    } else {
                        // Log upload error but continue with other categories
                        error_log('Icon upload failed for category ' . $category_id . ': ' . $this->upload->display_errors());
                    }
                }
                // If no new icon uploaded but we have an existing icon from POST, keep it
                else if(!$is_new_category && !empty($this->input->post('existing_category_icon_' . $category['id']))) {
                    // Icon remains the same, no action needed
                }
            }
        }
    }
    
    echo json_encode([
        'status' => 'success', 
        'message' => 'Categories saved successfully', 
        'ids' => $ids
    ]);
}
    
    public function save_stats()
{
   
    
    $new_stats = json_decode($this->input->post('new_stats'), true) ?: [];
    $update_stats = json_decode($this->input->post('update_stats'), true) ?: [];
    
    $result = $this->cms_model->save_stats($new_stats, $update_stats);
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Statistics saved successfully',
        'new_ids' => $result['new_ids']
    ]);
}
    
    // 2. About Us
    function about_us()
    {
        $about_data = $this->about_us_model->get_about_data();
        
        // Also get the raw content for form fields
        $raw_content = $this->about_us_model->get_about_content();
        
        $data = array(
            'data' => $about_data,  // Structured data for display
            'content' => $raw_content,  // Raw content for form inputs
            'section' => 'about'
        );
        $data['partners'] = $this->about_us_model->get_all_partners();
        $data['stats'] = $this->about_us_model->get_stats();
        $this->load->view('admin/about_us', $data);
    }
    
    public function add_stat() {
        $this->load->helper('security');
        
        $data = array(
            'stat_value' => $this->input->post('stat_value'),
            'stat_label' => $this->input->post('stat_label'),
            'stat_order' => $this->input->post('stat_order') ?: ($this->about_us_model->get_max_order() + 1)
        );
        
        $id = $this->about_us_model->add_stat($data);
        
        echo json_encode(array(
            'success' => true,
            'message' => 'Statistic added successfully',
            'id' => $id
        ));
    }
    
    public function delete_stat($id) {
        $success = $this->about_us_model->delete_stat($id);
        echo json_encode(array('success' => $success));
    }
    
     public function partners_add() {
        $data = array(
            'partner_name' => 'New Partner',
            'partner_logo' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        $this->about_us_model->add_partner($data);
        
        // Redirect back to partners section
        redirect('cms/about_us?success=true&action=add');
    }
    
    // Update partner name
    public function partners_update($id) {
        $partner_name = $this->input->post('partner_name');
        
        if (!empty($partner_name)) {
            $data = array(
                'partner_name' => $partner_name,
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            $this->about_us_model->update_partner($id, $data);
        }
        
        redirect('cms/about_us?success=true&action=update');
    }
    
    // Delete partner
    public function partners_delete($id) {
        $this->about_us_model->delete_partner($id);
        redirect('cms/about_us?success=true&action=delete');
    }
    
    // Upload logo
    public function partners_upload_logo($id) {
        $config['upload_path'] = './assets_system/images/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|svg';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = true;
        
        $this->load->library('upload', $config);
                $this->upload->initialize($config);
        
        if ($this->upload->do_upload('logo')) {
            $upload_data = $this->upload->data();
            $filename = $upload_data['file_name'];
            
            // Update partner with new logo
            $this->about_us_model->update_partner($id, array(
                'partner_logo' => $filename,
                'updated_at' => date('Y-m-d H:i:s')
            ));
        }
        
        redirect('cms/about_us?success=true&action=upload');
    }

    public function save_about_us()
{
    if (!$this->input->is_ajax_request()) {
        show_404();
    }

    $this->load->model('about_us_model');
    $content = $this->about_us_model->get_about_content();

    // Define website API details
    $website_url = 'https://lineseiki.systems-test.com';
    $api_endpoint = '/index/upload_image'; // Adjust based on your actual endpoint
    $api_key = 'YOUR_API_KEY_HERE'; // Set your API key

    $fields_to_update = [
        // Text fields
        'header',
        'header_text',
        'partner_header',
        'partner_text',
        'mission',
        'vission',

        // Concept boxes
        'concept_header_1',
        'concept_header_2',
        'concept_header_3',
        'concept_header_4',
        'concept_label_1',
        'concept_label_2',
        'concept_label_3',
        'concept_label_4',

        // Sections
        'section_header_1',
        'section_header_2',
        'section_header_3',
        'section_text_1',
        'section_text_2',
        'section_text_3',
        'section_img_1',
        'section_img_2',
        'section_img_3',

        // Images
        'hero_about_img',
        'mission_bg',

        // Partners
        'partner_1_name',
        'partner_2_name',
        'partner_3_name',
        'partner_4_name',
        'partner_logo_1',
        'partner_logo_2',
        'partner_logo_3',
        'partner_logo_4'
    ];

    $success = true;
    $user_id = $this->session->userdata('user_id') ?? 1;
    
    // Array to track image upload results
    $image_uploads = [];

    foreach ($fields_to_update as $field) {
        $value = $this->input->post($field);
        if ($value !== null) {
            $data = [];

            // Check if this is an image field
            if (strpos($field, 'img') !== false || strpos($field, 'logo') !== false) {
                $data['image'] = $value;
                
                // If this is a new/changed image, upload to website
                if (!empty($value) && $value !== ($content[$field]['image'] ?? '')) {
                    $upload_result = $this->upload_image_to_website($value, $website_url, $api_endpoint, $api_key);
                    $image_uploads[$field] = $upload_result;
                    
                    if (!$upload_result['success']) {
                        log_message('error', 'Website upload failed for ' . $field . ': ' . $upload_result['message']);
                        // Continue anyway, don't fail the entire save
                    }
                }
            } else {
                $data['content'] = $value;
            }

            $result = $this->about_us_model->update_content($field, $data, $user_id);
            $stats = $this->input->post('stats');
    if ($stats) {
        foreach ($stats as $stat) {
            if (isset($stat['id']) && isset($stat['value']) && isset($stat['label'])) {
                $statData = array(
                    'stat_value' => $stat['value'],
                    'stat_label' => $stat['label'],
                    'stat_order' => isset($stat['order']) ? $stat['order'] : 0
                );
                $this->about_us_model->update_stat($stat['id'], $statData);
            }
        }
    }
            if (!$result) {
                $success = false;
            }
        }
    }

    // Prepare response
    $response = [
        'success' => $success,
        'message' => $success ? 'Changes saved successfully' : 'Some fields could not be saved',
        'image_uploads' => $image_uploads
    ];
    
    if (!$success) {
        $response['message'] = 'Database save completed with some errors';
    }

    echo json_encode($response);
}

/**
 * Upload image to website via API
 */
private function upload_image_to_website($filename, $website_url, $api_endpoint, $api_key)
{
    // Check if file exists locally
    $local_path = FCPATH . 'assets_system/images/' . $filename;
    
    if (!file_exists($local_path)) {
        return [
            'success' => false,
            'message' => 'Local file not found: ' . $filename,
            'filename' => $filename
        ];
    }
    
    // Read file content
    $file_content = file_get_contents($local_path);
    
    if ($file_content === false) {
        return [
            'success' => false,
            'message' => 'Cannot read local file',
            'filename' => $filename
        ];
    }
    
    // Encode to base64
    $base64_content = base64_encode($file_content);
    
    // Prepare POST data
    $post_data = [
        'api_key' => $api_key,
        'filename' => $filename,
        'file_data' => $base64_content,
        'overwrite' => true
    ];
    
    // Initialize cURL
    $ch = curl_init();
    
    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $website_url . $api_endpoint);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Set to true in production with valid SSL
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    // Add headers
    $headers = [
        'Content-Type: application/x-www-form-urlencoded',
        'X-API-Request: AboutUsCMS'
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    // Execute request
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    
    curl_close($ch);
    
    // Check for cURL errors
    if ($curl_error) {
        return [
            'success' => false,
            'message' => 'cURL Error: ' . $curl_error,
            'filename' => $filename,
            'http_code' => $http_code
        ];
    }
    
    // Check HTTP status
    if ($http_code != 200) {
        return [
            'success' => false,
            'message' => 'HTTP Error: ' . $http_code,
            'filename' => $filename,
            'response' => $response
        ];
    }
    
    // Decode JSON response
    $json_response = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        return [
            'success' => false,
            'message' => 'Invalid JSON response: ' . $response,
            'filename' => $filename
        ];
    }
    
    // Return API response
    return [
        'success' => isset($json_response['status']) && $json_response['status'] === 'success',
        'message' => $json_response['message'] ?? 'Unknown response',
        'filename' => $filename,
        'api_response' => $json_response
    ];
}

    // 3. Products
    function products()
    {
        
        $content = $this->products_model->get_products_content();

        // Get categories data
        $categories_data = $this->products_model->get_products_data();

        $data = array(
            'content' => $content,
            'section' => 'products'
        );
        $data['products'] = $this->products_model->get_all_products();
        $this->load->view('admin/products', $data);
    }
    
    public function upload_category_image($id)
{
    $response = ['success' => false, 'message' => ''];
    
    // Check if product exists
    $this->load->model('products_model');
    $product = $this->products_model->get_product($id);
    
    if (!$product) {
        $response['message'] = 'Product not found.';
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
        return;
    }
    
    // Handle image upload
    if (!empty($_FILES['product_image']['name'])) {
        $upload_result = $this->category_upload_image();

        if ($upload_result['success']) {
            $new_image = $upload_result['file_name'];
            
            // Delete old image if exists
            if ($product->product_image) {
                $old_image_path = FCPATH . 'assets_system/images/' . $product->product_image;
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }
            
            // Update database with new image
            $data = [
                'product_image' => $new_image,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $result = $this->products_model->update_product($id, $data);
            
            if ($result) {
                $response['success'] = true;
                $response['message'] = 'Image uploaded successfully!';
                $response['image_url'] = base_url('assets_system/images/' . $new_image);
            } else {
                $response['message'] = 'Failed to update database.';
            }
        } else {
            $response['message'] = $upload_result['error'];
        }
    } else {
        $response['message'] = 'No image file selected.';
    }
    
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
}
    
    public function add_category() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $response = ['success' => false, 'message' => ''];
        
        $this->form_validation->set_rules('category_name', 'Category Name', 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            $response['message'] = validation_errors();
        } else {
            $data = [
                'category_name' => $this->input->post('category_name'),
                'is_active' => 1
            ];
            
            // Handle image upload if present
             if (!empty($_FILES['category_image']['name']) && $_FILES['category_image']['error'] == 0) {
                $config['upload_path'] = FCPATH . 'assets_system/images/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif|webp|svg';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = TRUE;
                $config['remove_spaces'] = TRUE;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('category_image')) {
                    $upload_data = $this->upload->data();
                    $data['product_image'] = $upload_data['file_name'];
                } else {
                    $response['message'] = 'Image upload failed: ' . $this->upload->display_errors('', '');
                    echo json_encode($response);
                    return;
                }
            }

            $category_id = $this->products_model->insert_category($data);
            
            if ($category_id) {
                $response['success'] = true;
                $response['message'] = 'Category added successfully!';
                $response['category_id'] = $category_id;
            } else {
                $response['message'] = 'Failed to add category. Please try again.';
            }
        }
        
        echo json_encode($response);
    }


    
    // Update category
    public function update_category($id) {
        // Validate form
        $this->form_validation->set_rules('category_name', 'Category Name', 'required|trim');
        
        if ($this->form_validation->run() === FALSE) {
            $response = [
                'success' => false,
                'message' => validation_errors()
            ];
        } else {
            $data = [
                'category_name' => $this->input->post('category_name'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            // Handle image upload
             if (!empty($_FILES['category_image']['name']) && $_FILES['category_image']['error'] == 0) {
                $config['upload_path'] = FCPATH . 'assets_system/images/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif|webp|svg';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = TRUE;
                $config['remove_spaces'] = TRUE;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('category_image')) {
                    $upload_data = $this->upload->data();
                    $data['product_image'] = $upload_data['file_name'];
                } else {
                    $response['message'] = 'Image upload failed: ' . $this->upload->display_errors('', '');
                    echo json_encode($response);
                    return;
                }
            }

            $result = $this->products_model->update_product($id, $data);
            
            if ($result) {
                $response = [
                    'success' => true,
                    'message' => 'Category updated successfully!'
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Failed to update category.'
                ];
            }
        }
        
        echo json_encode($response);
    }
    
    public function delete_card() {
        $id = $this->input->post('id');
        if ($this->cms_model->delete_category($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Category deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete category']);
        }
    }
    
    // Delete category
    public function delete_category($id) {
        // Get product info to delete image file
        $product = $this->products_model->get_product($id);
        
        if ($product) {
            // Delete image file if exists
            if (!empty($product->product_image)) {
                $image_path = FCPATH . 'assets_system/images/' . $product->product_image;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }
            
            // Delete from database
            $result = $this->products_model->delete_product($id);
            
            if ($result) {
                $response = [
                    'success' => true,
                    'message' => 'Category deleted successfully!'
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Failed to delete category.'
                ];
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'Category not found.'
            ];
        }
        
        echo json_encode($response);
    }
    
    // Get category data for edit
    public function get_category($id) {
        $product = $this->products_model->get_product($id);
        
        if ($product) {
            $response = [
                'success' => true,
                'data' => [
                    'id' => $product->id,
                    'category_name' => $product->category_name,
                    'product_image' => $product->product_image ? base_url('assets_system/images/' . $product->product_image) : ''
                ]
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Category not found.'
            ];
        }
        
        echo json_encode($response);
    }
    
    // Handle image upload
    

    public function save_products() {
    if (!$this->input->is_ajax_request()) {
        show_404();
        return;
    }

    $this->load->model('products_model');
    $user_id = $this->session->userdata('user_id') ?? 1;

    // Initialize response
    $response = array('success' => false, 'message' => 'No data received');

    try {
        // Get all POST data
        $post_data = $this->input->post();

        if (empty($post_data)) {
            echo json_encode($response);
            return;
        }

        $success_count = 0;
        $error_messages = array();

        // List of expected image fields
        $image_fields = array(
            'bg_image',
            'switches_imgage',
            'electronic_counters_img',
            'timers_img',
            'mechanical_counters_img',
            'slide_limit_counters_img',
            'limit_switch_img',
            'length_counters_img',
            'rotary_img',
            'tachometers_img',
            'thermometer_img',
            'measuring_img',
            'tallycounter_img'
        );

        // Handle image fields
        foreach ($image_fields as $field) {
            if (isset($post_data[$field]) && !empty($post_data[$field])) {
                $data = array(
                    'image' => $post_data[$field]
                );

                $result = $this->products_model->update_content($field, $data, $user_id);
                if ($result) {
                    $success_count++;
                } else {
                    $error_messages[] = "Failed to update: $field";
                }
            }
        }

        // Handle text fields
        $text_fields = array(
            'page_title',
            'cta_headline',
            'cta_description',
            'cta_button_text',
            'cta_button_link'
        );

        foreach ($text_fields as $field) {
            if (isset($post_data[$field])) {
                $data = array(
                    'content' => $post_data[$field]
                );

                $result = $this->products_model->update_content($field, $data, $user_id);
                if ($result) {
                    $success_count++;
                } else {
                    // Try to create if it doesn't exist
                    $create_data = array(
                        'title' => $field,
                        'content' => $post_data[$field],
                        'image' => null,
                        'edited_by' => $user_id
                    );
                    $this->products_model->create_content($create_data);
                    $success_count++;
                }
            }
        }

        if ($success_count > 0) {
            $response = array(
                'success' => true,
                'message' => 'Successfully updated ' . $success_count . ' items',
                'updated_count' => $success_count
            );

            if (!empty($error_messages)) {
                $response['warnings'] = $error_messages;
            }
        } else {
            $response = array(
                'success' => false,
                'message' => 'No items were updated'
            );
        }
    } catch (Exception $e) {
        $response = array(
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        );
    }

    // Set JSON header and output
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
}

    // 4. Simulation Analysis
    function simulation_analysis()
    {
        $data['simulations'] = $this->simulation_model->get_all_simulations();
        $data['content'] = $this->simulation_model->get_all_content();
        $data['capabilities'] = $this->simulation_model->get_all_capabilities();
        $data['carousel_items'] = $this->simulation_model->get_carousel_items_content();
        $data['benefits'] = $this->simulation_model->get_all_benefits();
        $data['colors'] = $this->get_color_classes();
        $data['other_capabilities'] = $this->simulation_model->get_all_other_capabilities();
        $data['other_capability_categories'] = $this->simulation_model->get_other_capability_categories();
        $this->load->view('admin/simulation_analysis', $data);
    }
    
    public function update_benefits() 
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        // Get raw input and decode JSON
        $raw_input = file_get_contents('php://input');
        $data = json_decode($raw_input, true);
        
        // Check if data was received
        if (!$data) {
            echo json_encode([
                'success' => false,
                'message' => 'No data received or invalid JSON'
            ]);
            return;
        }
        
        $benefits_data = isset($data['benefits']) ? $data['benefits'] : null;
        
        if (empty($benefits_data) || !is_array($benefits_data)) {
            echo json_encode([
                'success' => false,
                'message' => 'No benefit data provided',
                'debug' => ['raw_input' => $raw_input, 'decoded' => $data]
            ]);
            return;
        }
        
        // Validate each benefit
        $errors = [];
        foreach ($benefits_data as $index => $benefit) {
            $benefit_errors = [];
            
            if (empty(trim($benefit['title']))) {
                $benefit_errors[] = 'Title is required';
            } elseif (strlen($benefit['title']) > 255) {
                $benefit_errors[] = 'Title must be less than 255 characters';
            }
            
            if (empty(trim($benefit['description']))) {
                $benefit_errors[] = 'Description is required';
            }
            
            if (!empty($benefit['icon']) && strlen($benefit['icon']) > 255) {
                $benefit_errors[] = 'Icon must be less than 255 characters';
            }
            
            if (!empty($benefit_errors)) {
                $errors["benefit_{$index}"] = $benefit_errors;
            }
        }
        
        if (!empty($errors)) {
            echo json_encode([
                'success' => false,
                'errors' => $errors,
                'message' => 'Validation failed'
            ]);
            return;
        }
        
        // Start transaction
        $this->db->trans_start();
        
        try {
            $results = [];
            
            foreach ($benefits_data as $benefit) {
                $id = isset($benefit['id']) ? $benefit['id'] : null;
                
                if ($id) {
                    // Update existing benefit
                    unset($benefit['id']);
                    $benefit['updated_at'] = date('Y-m-d H:i:s');
                    
                    $this->db->where('id', $id);
                    if ($this->db->update('tbl_benefits', $benefit)) {
                        $this->db->where('id', $id);
                        $query = $this->db->get('tbl_benefits');
                        $results[] = $query->row_array();
                    }
                } else {
                    // Create new benefit
                    unset($benefit['id']);
                    $benefit['created_at'] = date('Y-m-d H:i:s');
                    $benefit['updated_at'] = date('Y-m-d H:i:s');
                    
                    if ($this->db->insert('tbl_benefits', $benefit)) {
                        $new_id = $this->db->insert_id();
                        $this->db->where('id', $new_id);
                        $query = $this->db->get('tbl_benefits');
                        $results[] = $query->row_array();
                    }
                }
            }
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to update benefits. Database error.'
                ]);
            } else {
                echo json_encode([
                    'success' => true,
                    'message' => 'Benefits updated successfully!',
                    'benefits' => $results
                ]);
            }
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Benefits update error: ' . $e->getMessage());
            
            echo json_encode([
                'success' => false,
                'message' => 'An error occurred while updating benefits: ' . $e->getMessage()
            ]);
        }
    }
    
    public function upload_icon_benefit()
{
    // Check if it's an AJAX request
    if (!$this->input->is_ajax_request()) {
        show_404();
    }

    $response = array('success' => false, 'message' => '', 'filename' => '', 'url' => '');

    try {
        $target_id = $this->input->post('target_id');
        
        if (empty($_FILES['icon_file'])) {
            $response['message'] = 'No file uploaded.';
            echo json_encode($response);
            return;
        }

        // Configure upload
        $config = array(
            'upload_path' => FCPATH . 'assets_system/images/',
            'allowed_types' => 'gif|jpg|jpeg|png|svg',
            'max_size' => 2048, // 2MB
            'encrypt_name' => true,
            'overwrite' => false
        );

        // Create directory if it doesn't exist
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }

        $this->load->library('upload', $config);
                $this->upload->initialize($config);

        if ($this->upload->do_upload('icon_file')) {
            $upload_data = $this->upload->data();
            $filename = $upload_data['file_name'];
            
            // If this is for an existing benefit (numeric ID), update the database
            if (is_numeric($target_id)) {
                $this->load->model('simulation_model');
                
                // Get old icon to delete
                $benefit = $this->simulation_model->get_benefit($target_id);
                
                // Update benefit with new icon
                $this->simulation_model->update_benefit($target_id, array('icon' => $filename));
                
                // Delete old icon if exists and different
                if (!empty($benefit['icon']) && $benefit['icon'] != $filename) {
                    $old_icon_path = $config['upload_path'] . $benefit['icon'];
                    if (file_exists($old_icon_path)) {
                        @unlink($old_icon_path);
                    }
                }
            }
            
            $response['success'] = true;
            $response['filename'] = $filename;
            $response['url'] = base_url('assets_system/images/' . $filename);
            $response['message'] = 'Icon uploaded successfully!';
        } else {
            $response['message'] = $this->upload->display_errors('', '');
        }

    } catch (Exception $e) {
        log_message('error', 'Error in upload_icon: ' . $e->getMessage());
        $response['message'] = 'An unexpected error occurred: ' . $e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
    
    public function upload_icon() {
    // Set header to JSON
    header('Content-Type: application/json');
    
    // Check if it's an AJAX request (optional but good practice)
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        // It's an AJAX request
    } else {
        // Not an AJAX request, but we'll still process it
    }
    
    // Check if file was uploaded
    if (empty($_FILES['icon_file'])) {
        echo json_encode([
            'success' => false,
            'message' => 'No file data received',
            'debug' => ['files' => $_FILES]
        ]);
        return;
    }
    
    if ($_FILES['icon_file']['error'] !== UPLOAD_ERR_OK) {
        $error_messages = [
            UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload'
        ];
        
        echo json_encode([
            'success' => false,
            'message' => $error_messages[$_FILES['icon_file']['error']] ?? 'Unknown upload error',
            'error_code' => $_FILES['icon_file']['error']
        ]);
        return;
    }
    
    if (empty($_FILES['icon_file']['name'])) {
        echo json_encode([
            'success' => false,
            'message' => 'No file selected'
        ]);
        return;
    }
    
    // Check file size
    $max_size = 2 * 1024 * 1024; // 2MB
    if ($_FILES['icon_file']['size'] > $max_size) {
        echo json_encode([
            'success' => false,
            'message' => 'File size must be less than 2MB'
        ]);
        return;
    }
    
    // Check file type
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/svg+xml'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $_FILES['icon_file']['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mime_type, $allowed_types)) {
        echo json_encode([
            'success' => false,
            'message' => 'Only JPG, PNG, SVG, and GIF files are allowed',
            'detected_type' => $mime_type
        ]);
        return;
    }
    
    // Get file extension
    $file_ext = pathinfo($_FILES['icon_file']['name'], PATHINFO_EXTENSION);
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
    
    if (!in_array(strtolower($file_ext), $allowed_extensions)) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid file extension. Allowed: ' . implode(', ', $allowed_extensions)
        ]);
        return;
    }
    
    // Generate unique filename
    $filename = 'benefit_' . time() . '_' . rand(1000, 9999) . '.' . strtolower($file_ext);
    $upload_path = FCPATH . 'assets_system/images/';
    
    // Create directory if it doesn't exist
    if (!is_dir($upload_path)) {
        mkdir($upload_path, 0755, true);
    }
    
    // Configure upload
    $config = [
        'upload_path'   => $upload_path,
        'allowed_types' => 'jpg|jpeg|png|gif|svg',
        'max_size'      => 2048, // 2MB
        'file_name'     => $filename,
        'overwrite'     => false
    ];
    
    $this->load->library('upload', $config);
                $this->upload->initialize($config);
    
    if ($this->upload->do_upload('icon_file')) {
        echo json_encode([
            'success' => true,
            'message' => 'Icon uploaded successfully',
            'filename' => $filename,
            'url' => base_url('assets_system/images/' . $filename)
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => $this->upload->display_errors('', ''),
            'debug' => [
                'file_name' => $_FILES['icon_file']['name'],
                'file_size' => $_FILES['icon_file']['size'],
                'file_type' => $_FILES['icon_file']['type']
            ]
        ]);
    }
}

    
    private function get_color_classes() {
        return [
            ['border' => 'border-orange-100', 'bg' => 'bg-orange-50/30', 'hover' => 'hover:bg-orange-50', 'text' => 'text-orange-600', 'focus' => 'focus:ring-orange-500'],
            ['border' => 'border-teal-100', 'bg' => 'bg-teal-50/30', 'hover' => 'hover:bg-teal-50', 'text' => 'text-teal-600', 'focus' => 'focus:ring-teal-500'],
            ['border' => 'border-rose-100', 'bg' => 'bg-rose-50/30', 'hover' => 'hover:bg-rose-50', 'text' => 'text-rose-600', 'focus' => 'focus:ring-rose-500']
        ];
    }
    
    public function save_capability() {
        if ($this->input->post()) {
            $capability_id = $this->input->post('capability_id');
            $data = [
                'capability_name' => $this->input->post('capability_name'),
                'color_scheme' => $this->input->post('color_scheme')
            ];
            
            if ($capability_id) {
                $this->simulation_model->update_capability($capability_id, $data);
            } else {
                // Get max sort order and add 1
                $this->db->select_max('sort_order');
                $max_order = $this->db->get('tbl_capabilities')->row()->sort_order;
                $data['sort_order'] = $max_order + 1;
                
                $capability_id = $this->simulation_model->add_capability($data);
            }
            
            echo json_encode(['success' => true, 'capability_id' => $capability_id]);
        }
    }
    
    public function save_capability_item() {
        if ($this->input->post()) {
            $item_id = $this->input->post('item_id');
            $capability_id = $this->input->post('capability_id');
            $item_name = $this->input->post('item_name');
            
            $data = [
                'capability_id' => $capability_id,
                'item_name' => $item_name
            ];
            
            if ($item_id) {
                // Update existing item
                $this->simulation_model->update_capability_item($item_id, $data);
            } else {
                // For new items, calculate the next sort_order
                $this->db->select_max('sort_order');
                $this->db->where('capability_id', $capability_id);
                $max_order = $this->db->get('tbl_capability_items')->row()->sort_order;
                
                $data['sort_order'] = ($max_order + 1) ?: 1; // If null, start with 1
                
                $this->simulation_model->add_capability_item($data);
            }
            
            echo json_encode(['success' => true]);
        }
    }
    
    public function delete_capability() {
        $id = $this->input->post('id');
        if ($id) {
            $this->simulation_model->delete_capability($id);
            echo json_encode(['success' => true]);
        }
    }
    
    public function delete_capability_item() {
        $id = $this->input->post('id');
        if ($id) {
            $this->simulation_model->delete_capability_item($id);
            echo json_encode(['success' => true]);
        }
    }
    
    public function update_sort() {
        $capabilities = $this->input->post('capabilities');
        if ($capabilities) {
            $this->simulation_model->update_sort_order($capabilities);
            echo json_encode(['success' => true]);
        }
    }
    
    // In your CMS controller
public function upload_image_simul() {
    $response = ['success' => false, 'message' => '', 'filename' => ''];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
        $config['upload_path'] = './assets_system/images/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 5120; // 5MB
        $config['encrypt_name'] = true;
        
        $this->load->library('upload', $config);
                $this->upload->initialize($config);
        
        if ($this->upload->do_upload('image')) {
            $upload_data = $this->upload->data();
            $filename = $upload_data['file_name'];
            
            $response['success'] = true;
            $response['message'] = 'Image uploaded successfully';
            $response['filename'] = $filename;
        } else {
            $response['message'] = $this->upload->display_errors();
        }
    }
    
    echo json_encode($response);
}

   public function save_all()
    {
        // Check if it's an AJAX request
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $response = array('success' => false, 'message' => '', 'filenames' => array());

        try {
            if ($this->input->post() || !empty($_FILES)) {
                $updates = array();

                // ============ Main content fields (excluding carousel) ============
                $text_fields = array(
                    'hero_title' => $this->input->post('hero_title'),
                    'hero_description' => $this->input->post('hero_description'),
                    'what_we_do_text' => $this->input->post('what_we_do_text'),
                    'simulation_title' => $this->input->post('simulation_title'),
                    'simulation_description' => $this->input->post('simulation_description'),
                    'simulation_button' => $this->input->post('simulation_button'),
                    
                    // Remove old capability items
                    'capability_1_item_1' => $this->input->post('capability_1_item_1'),
                    'capability_1_item_2' => $this->input->post('capability_1_item_2'),
                    'capability_1_item_3' => $this->input->post('capability_1_item_3'),
                    'capability_1_item_4' => $this->input->post('capability_1_item_4'),
                    'capability_1_item_5' => $this->input->post('capability_1_item_5'),
                    'capability_2_item_1' => $this->input->post('capability_2_item_1'),
                    'capability_2_item_2' => $this->input->post('capability_2_item_2'),
                    'capability_2_item_3' => $this->input->post('capability_2_item_3'),
                    'capability_2_item_4' => $this->input->post('capability_2_item_4'),
                    'capability_2_item_5' => $this->input->post('capability_2_item_5'),
                    'capability_3_item_1' => $this->input->post('capability_3_item_1'),
                    'capability_3_item_2' => $this->input->post('capability_3_item_2'),
                    'capability_3_item_3' => $this->input->post('capability_3_item_3'),
                    'capability_3_item_4' => $this->input->post('capability_3_item_4'),
                    'capability_3_item_5' => $this->input->post('capability_3_item_5'),
                    
                    // Webinar section
                    'webinar_title' => $this->input->post('webinar_title'),
                    'webinar_description_1' => $this->input->post('webinar_description_1'),
                    'webinar_description_2' => $this->input->post('webinar_description_2'),
                    
                    // Process section
                    'process_title' => $this->input->post('process_title'),
                    'process_description' => $this->input->post('process_description'),
                    'process_step_1_title' => $this->input->post('process_step_1_title'),
                    'process_step_1_description' => $this->input->post('process_step_1_description'),
                    'process_step_1_icon' => $this->input->post('process_step_1_icon'),
                    'process_step_2_title' => $this->input->post('process_step_2_title'),
                    'process_step_2_description' => $this->input->post('process_step_2_description'),
                    'process_step_2_icon' => $this->input->post('process_step_2_icon'),
                    'process_step_3_title' => $this->input->post('process_step_3_title'),
                    'process_step_3_description' => $this->input->post('process_step_3_description'),
                    'process_step_3_icon' => $this->input->post('process_step_3_icon'),
                    
                    // Benefits section
                    'benefit_1_title' => $this->input->post('benefit_1_title'),
                    'benefit_1_description' => $this->input->post('benefit_1_description'),
                    'benefit_2_title' => $this->input->post('benefit_2_title'),
                    'benefit_2_description' => $this->input->post('benefit_2_description'),
                    'benefit_3_title' => $this->input->post('benefit_3_title'),
                    'benefit_3_description' => $this->input->post('benefit_3_description')
                );

                foreach ($text_fields as $field => $value) {
                    if ($value !== null) {
                        $updates[$field] = array('content' => $value);
                    }
                }

                // Handle file uploads (excluding carousel)
                $upload_config = array(
                    'upload_path' => './assets_system/images/',
                    'allowed_types' => 'gif|jpg|jpeg|png',
                    'max_size' => 5120, // 5MB
                    'encrypt_name' => true,
                    'overwrite' => false
                );

                $this->load->library('upload');

                // Define file upload fields (EXCLUDING carousel images)
                $file_fields = array(
                    'hero_image' => 'hero_image',
                    'hero_bg_img' => 'hero_bg_img',
                    'reduced_cost_gif' => 'reduced_cost_gif',
                    'reduced_cost_image_1' => 'reduced_cost_image_1',
                    'reduced_cost_image_2' => 'reduced_cost_image_2',
                    'webinar_image' => 'webinar_image'
                );

                // Process each file upload
                foreach ($file_fields as $form_field => $db_field) {
                    // Check if file was uploaded via FILES array
                    if (isset($_FILES[$form_field]) && $_FILES[$form_field]['error'] == 0) {
                        // Configure upload for this file
                        $upload_config['file_name'] = uniqid();
                        $this->upload->initialize($upload_config);

                        if ($this->upload->do_upload($form_field)) {
                            $upload_data = $this->upload->data();
                            $filename = $upload_data['file_name'];
                            
                            // Store in updates array
                            $updates[$db_field] = array('image' => $filename);
                            
                            // Add to response for JavaScript
                            $response['filenames'][$db_field] = $filename;
                            
                            // Optional: Delete old image if exists
                            $old_filename = $this->input->post($db_field);
                            if (!empty($old_filename) && $old_filename != $filename) {
                                $old_file_path = $upload_config['upload_path'] . $old_filename;
                                if (file_exists($old_file_path) && is_file($old_file_path)) {
                                    @unlink($old_file_path);
                                }
                            }
                        } else {
                            // Log upload error but don't fail the entire process
                            log_message('error', 'Upload failed for ' . $form_field . ': ' . $this->upload->display_errors());
                        }
                    } else {
                        // If no new file uploaded but we have a post value, use existing filename
                        $existing_filename = $this->input->post($db_field);
                        if (!empty($existing_filename)) {
                            $updates[$db_field] = array('image' => $existing_filename);
                        }
                    }
                }

                // Debug: Log what we're updating
                log_message('debug', 'Main content updates: ' . print_r($updates, true));

                // Update main content fields
                if (!empty($updates)) {
                    $success = $this->simulation_model->update_multiple($updates);
                    
                    if ($success) {
                        $response['success'] = true;
                        $response['message'] = 'Main content saved successfully!';
                    } else {
                        $response['message'] = 'Error saving main content to database.';
                    }
                }

            } else {
                $response['message'] = 'No data received.';
            }
        } catch (Exception $e) {
            log_message('error', 'Error in save_all: ' . $e->getMessage());
            $response['message'] = 'An unexpected error occurred: ' . $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    public function save_all_benefits()
    {
        // Check if it's an AJAX request
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
    
        $response = array('success' => false, 'message' => '', 'reload' => false);
    
        try {
            $benefits_json = $this->input->post('benefits');
            
            if (!$benefits_json) {
                $response['message'] = 'No benefits data received.';
                echo json_encode($response);
                return;
            }
    
            $benefits = json_decode($benefits_json, true);
            
            if (!is_array($benefits)) {
                $response['message'] = 'Invalid benefits data format.';
                echo json_encode($response);
                return;
            }
    
            $success_count = 0;
    
            foreach ($benefits as $benefit) {
                $benefit_id = $benefit['id'] ?? null;
                
                // Check if it's a new benefit (starts with 'new_')
                if (is_string($benefit_id) && strpos($benefit_id, 'new_') === 0) {
                    // Insert new benefit
                    $insert_data = array(
                        'title' => $benefit['title'] ?? '',
                        'description' => $benefit['description'] ?? '',
                        'icon' => $benefit['icon'] ?? ''
                    );
                    
                    if ($this->simulation_model->insert_benefit($insert_data)) {
                        $success_count++;
                        $response['reload'] = true; // Reload to get new IDs
                    }
                } else {
                    // Update existing benefit
                    $update_data = array(
                        'title' => $benefit['title'] ?? '',
                        'description' => $benefit['description'] ?? '',
                        'icon' => $benefit['icon'] ?? ''
                    );
                    
                    if ($this->simulation_model->update_benefit($benefit_id, $update_data)) {
                        $success_count++;
                    }
                }
            }
    
            if ($success_count > 0) {
                $response['success'] = true;
                $response['message'] = $success_count . ' benefit(s) saved successfully!';
            } else {
                $response['message'] = 'No benefits were saved.';
            }
    
        } catch (Exception $e) {
            log_message('error', 'Error in save_all_benefits: ' . $e->getMessage());
            $response['message'] = 'An unexpected error occurred: ' . $e->getMessage();
        }
    
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    public function delete_benefit()
{
    // Check if it's an AJAX request
    if (!$this->input->is_ajax_request()) {
        show_404();
    }

    $response = array('success' => false, 'message' => '');

    try {
        $benefit_id = $this->input->post('id');
        
        if (!$benefit_id) {
            $response['message'] = 'No benefit ID provided.';
            echo json_encode($response);
            return;
        }

        $this->load->model('simulation_model');
        
        // Get benefit info to delete icon file
        $benefit = $this->simulation_model->get_benefit($benefit_id);
        
        if ($this->simulation_model->delete_benefit($benefit_id)) {
            // Delete icon file if exists
            if (!empty($benefit['icon'])) {
                $icon_path = FCPATH . 'assets_system/images/' . $benefit['icon'];
                if (file_exists($icon_path)) {
                    @unlink($icon_path);
                }
            }
            
            $response['success'] = true;
            $response['message'] = 'Benefit deleted successfully!';
        } else {
            $response['message'] = 'Error deleting benefit.';
        }

    } catch (Exception $e) {
        log_message('error', 'Error in delete_benefit: ' . $e->getMessage());
        $response['message'] = 'An unexpected error occurred: ' . $e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
    
    // ============ NEW CAROUSEL METHODS ============
    
    public function save_carousel()
{
    // Enable debugging
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
    ini_set('display_errors', 1);
    
    if (!$this->input->is_ajax_request()) {
        show_404();
    }
    
    $this->load->library('upload');
    $response = ['success' => false, 'message' => '', 'items' => []];
    
    try {
        $carousel_data = $this->input->post('carousel_data');
        
        if (empty($carousel_data)) {
            throw new Exception('No carousel data received');
        }
        
        $carousel_data = json_decode($carousel_data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON data: ' . json_last_error_msg());
        }
        
        if (empty($carousel_data)) {
            throw new Exception('Empty carousel data');
        }
        
        log_message('debug', 'Processing ' . count($carousel_data) . ' carousel items');
        
        // Process each carousel item
        foreach ($carousel_data as $index => $item) {
            $db_id = isset($item['db_id']) ? intval($item['db_id']) : 0;
            
            $data = [
                'title' => isset($item['title']) ? trim($item['title']) : '',
                'abstract' => isset($item['description']) ? trim($item['description']) : ''
            ];
            
            // Handle image
            $current_image = isset($item['image']) ? $item['image'] : '';
            $old_image = isset($item['old_image']) ? $item['old_image'] : $current_image;
            $new_image = '';
            
            // Check for file upload
            $file_key = 'carousel_image_' . ($index + 1);
            
            if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] == 0) {
                $upload_config = [
                    'upload_path' => FCPATH . 'assets_system/images/',
                    'allowed_types' => 'gif|jpg|jpeg|png|webp',
                    'max_size' => 5120,
                    'encrypt_name' => true,
                    'overwrite' => false
                ];
                
                $this->upload->initialize($upload_config);
                
                if ($this->upload->do_upload($file_key)) {
                    $upload_data = $this->upload->data();
                    $new_image = $upload_data['file_name'];
                    $data['main_image'] = $new_image;
                    
                    // Delete old image if it exists and is different from new one
                    if (!empty($old_image) && $old_image != $new_image) {
                        $old_path = $upload_config['upload_path'] . $old_image;
                        if (file_exists($old_path) && $old_image != 'placeholder.png') {
                            @unlink($old_path);
                        }
                    }
                } else {
                    // Upload failed, keep current image
                    $data['main_image'] = !empty($current_image) ? $current_image : 'placeholder.png';
                }
            } elseif (!empty($current_image)) {
                // No new upload, keep current image
                $data['main_image'] = $current_image;
            } else {
                // No image at all
                $data['main_image'] = 'placeholder.png';
            }
            
            // Save to database
            if ($db_id > 0) {
                // Update existing
                $this->db->where('id', $db_id);
                $result = $this->db->update('tbl_simulation_content', $data);
                $saved_id = $result ? $db_id : false;
            } else {
                // Insert new
                $data['created_at'] = date('Y-m-d H:i:s');
                $result = $this->db->insert('tbl_simulation_content', $data);
                $saved_id = $result ? $this->db->insert_id() : false;
            }
            
            if ($saved_id) {
                $response['items'][] = [
                    'db_id' => $saved_id,
                    'title' => $data['title'],
                    'image' => $data['main_image']
                ];
            }
        }
        
        $response['success'] = true;
        $response['message'] = 'Carousel saved successfully!';
        
    } catch (Exception $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
        log_message('error', 'Carousel save error: ' . $e->getMessage());
    }
    
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
}
    
    public function delete_carousel_item()
{
    if (!$this->input->is_ajax_request()) {
        show_404();
    }
    
    $id = $this->input->post('id');
    $response = ['success' => false, 'message' => ''];
    
    if (empty($id)) {
        $response['message'] = 'No ID provided';
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
        return;
    }
    
    // Get the item first to delete the image file
    $this->db->where('id', $id);
    $query = $this->db->get('tbl_simulation_content');
    $item = $query->row();
    
    if (!$item) {
        $response['message'] = 'Item not found';
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
        return;
    }
    
    // Delete image file if it exists and is not placeholder
    if (!empty($item->image) && $item->image != 'placeholder.png') {
        $image_path = FCPATH . 'assets_system/images/' . $item->image;
        if (file_exists($image_path)) {
            @unlink($image_path);
        }
    }
    
    // Delete from database
    $this->db->where('id', $id);
    $success = $this->db->delete('tbl_simulation_content');
    
    if ($success) {
        $response['success'] = true;
        $response['message'] = 'Carousel item deleted successfully!';
    } else {
        $response['message'] = 'Failed to delete carousel item from database';
    }
    
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
}
    
    public function update_carousel_order()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $items = $this->input->post('items');
        $response = ['success' => false, 'message' => ''];
        
        if ($items && is_array($items)) {
            $success = $this->simulation_model->update_carousel_order($items);
            if ($success) {
                $response['success'] = true;
                $response['message'] = 'Carousel order updated!';
            }
        }
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }


    // 5. SMUC Page
    function smuc_page()
    {
        $status = $this->input->get('status') ?: 'all';
    $search = $this->input->get('search') ?: '';
    $page = $this->input->get('page') ?: 1;
    $per_page = 20;
    $offset = ($page - 1) * $per_page;
        $data['requests'] = $this->Quote_requests_model->get_all_requests($per_page, $offset, $status, $search);
        $data['total_requests'] = $this->Quote_requests_model->count_all_requests($status, $search);
        $data['statistics'] = $this->Quote_requests_model->get_statistics();
        $data['current_status'] = $status;
        $data['search_term'] = $search;
        $data['current_page'] = $page;
        $data['total_pages'] = ceil($data['total_requests'] / $per_page);
        $data['content'] = $this->smuc_model->get_all_content();
        $data['gallery_urethane'] = $this->smuc_model->get_all('urethane_parts');
        $data['gallery_overmolding'] = $this->smuc_model->get_all('overmolding');
        $this->load->view('admin/smuc_page', $data);
    }
    
    public function delete_gallery_item() 
    {
        // Check if it's an AJAX request
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
    
        $response = array('success' => false, 'message' => '');
    
        try {
            $item_id = $this->input->post('item_id');
            
            if (empty($item_id)) {
                throw new Exception('Item ID is required');
            }
    
            
            // Delete from database
            $delete_success = $this->smuc_model->delete_gallery_item($item_id);
            
            if ($delete_success) {
                $response['success'] = true;
                $response['message'] = 'Gallery item deleted successfully';
            } else {
                throw new Exception('Failed to delete gallery item');
            }
    
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }
    
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function save_smuc_page()
{
    // Check if it's an AJAX request
    if (!$this->input->is_ajax_request()) {
        show_404();
    }

    $response = array('success' => false, 'message' => '');

    if ($this->input->post() || !empty($_FILES)) {
        $updates = array();
        $filenames = array();

        // Handle file uploads
        $this->handle_file_uploads($filenames);
        
        // Hero Section
        $updates['hero_title'] = array('content' => $this->input->post('hero_title'));
        $updates['hero_description'] = array('content' => $this->input->post('hero_description'));
        $updates['hero_button'] = array('content' => $this->input->post('hero_button'));
        $updates['hero_image'] = array('image' => isset($filenames['hero_image_upload']) ? $filenames['hero_image_upload'] : $this->input->post('hero_image'));
        $updates['hero_bg_img'] = array('image' => isset($filenames['bghero_image_upload']) ? $filenames['bghero_image_upload'] : $this->input->post('bg_hero_image'));
        
        // What We Do Section
        $updates['what_we_do_title'] = array('content' => $this->input->post('what_we_do_title'));
        $updates['what_we_do_subtitle'] = array('content' => $this->input->post('what_we_do_subtitle'));
        $updates['silicone_mold_title'] = array('content' => $this->input->post('silicone_mold_title'));
        $updates['silicone_mold_description'] = array('content' => $this->input->post('silicone_mold_description'));
        $updates['urethane_part_title'] = array('content' => $this->input->post('urethane_part_title'));
        $updates['urethane_part_description'] = array('content' => $this->input->post('urethane_part_description'));

        // Illustration Images
        $updates['illustration_top_mold'] = array('image' => isset($filenames['illustration_top_mold_upload']) ? $filenames['illustration_top_mold_upload'] : $this->input->post('illustration_top_mold'));
        $updates['illustration_internal_part'] = array('image' => isset($filenames['illustration_internal_part_upload']) ? $filenames['illustration_internal_part_upload'] : $this->input->post('illustration_internal_part'));
        $updates['illustration_bottom_mold'] = array('image' => isset($filenames['illustration_bottom_mold_upload']) ? $filenames['illustration_bottom_mold_upload'] : $this->input->post('illustration_bottom_mold'));

        // Silicone Molding Section - DYNAMIC FEATURES
        $updates['silicone_molding_title'] = array('content' => $this->input->post('silicone_molding_title'));
        $updates['silicone_molding_content'] = array('content' => $this->input->post('silicone_molding_content'));
        $updates['silicone_molding_features_title'] = array('content' => $this->input->post('silicone_molding_features_title'));
        
        // Process dynamic silicone molding features
        $silicone_features_success = $this->process_dynamic_features('silicone_molding');

        // Urethane Casting Section - DYNAMIC FEATURES
        $updates['urethane_casting_title'] = array('content' => $this->input->post('urethane_casting_title'));
        $updates['urethane_casting_content'] = array('content' => $this->input->post('urethane_casting_content'));
        $updates['urethane_casting_features_title'] = array('content' => $this->input->post('urethane_casting_features_title'));
        
        // Process dynamic urethane casting features
        $urethane_features_success = $this->process_dynamic_features('urethane_casting');

        // Process Steps
        for ($i = 1; $i <= 4; $i++) {
            $updates['process_step_' . $i . '_title'] = array('content' => $this->input->post('process_step_' . $i . '_title'));
            $updates['process_step_' . $i . '_description'] = array('content' => $this->input->post('process_step_' . $i . '_description'));
            $updates['process_step_' . $i . '_image'] = array('image' => isset($filenames['process_step_' . $i . '_image_upload']) ? $filenames['process_step_' . $i . '_image_upload'] : $this->input->post('process_step_' . $i . '_image'));
        }

        // Why Choose Us Section
        $updates['wcu_subtitle'] = array('content' => $this->input->post('wcu_subtitle'));
        $updates['wcu_title'] = array('content' => $this->input->post('wcu_title'));
        $updates['wcu_description'] = array('content' => $this->input->post('wcu_description'));
        $updates['video_text_header'] = array('content' => $this->input->post('video_text_header'));
        $updates['video_text_sub'] = array('content' => $this->input->post('video_text_sub'));
        for ($i = 1; $i <= 4; $i++) {
            $updates['wcu_card_' . $i . '_title'] = array('content' => $this->input->post('wcu_card_' . $i . '_title'));
            $updates['wcu_card_' . $i . '_description'] = array('content' => $this->input->post('wcu_card_' . $i . '_description'));
        }
        $updates['wcu_video'] = array('image' => isset($filenames['wcu_video_upload']) ? $filenames['wcu_video_upload'] : $this->input->post('wcu_video'));

        // Benefits Section
        $updates['benefits_title'] = array('content' => $this->input->post('benefits_title'));
        $updates['benefits_subtitle'] = array('content' => $this->input->post('benefits_subtitle'));
        for ($i = 1; $i <= 4; $i++) {
            $updates['benefit_' . $i . '_number'] = array('content' => $this->input->post('benefit_' . $i . '_number'));
            $updates['benefit_' . $i . '_title'] = array('content' => $this->input->post('benefit_' . $i . '_title'));
            $updates['benefit_' . $i . '_description'] = array('content' => $this->input->post('benefit_' . $i . '_description'));
            $updates['benefit_' . $i . '_image'] = array('image' => isset($filenames['benefit_' . $i . '_image_upload']) ? $filenames['benefit_' . $i . '_image_upload'] : $this->input->post('benefit_' . $i . '_image'));
        }

        // ISO Section
        $updates['iso_title'] = array('content' => $this->input->post('iso_title'));
        $updates['iso_subtitle'] = array('content' => $this->input->post('iso_subtitle'));
        $updates['iso_description'] = array('content' => $this->input->post('iso_description'));
        $updates['iso_button'] = array('content' => $this->input->post('iso_button'));
        $updates['iso_image'] = array('image' => isset($filenames['iso_image_upload']) ? $filenames['iso_image_upload'] : $this->input->post('iso_image'));

        // Project Submission
        $updates['project_submission_title'] = array('content' => $this->input->post('project_submission_title'));
        $updates['project_submission_description'] = array('content' => $this->input->post('project_submission_description'));
        $updates['project_submission_button'] = array('content' => $this->input->post('project_submission_button'));

        // Update all fields in tbl_smuc
        $smuc_success = $this->smuc_model->update_multiple($updates);
        
        // Process gallery items
        $gallery_success = $this->process_gallery_items($filenames);
        
        if ($smuc_success && $silicone_features_success && $urethane_features_success) {
            $response['success'] = true;
            $response['message'] = 'All changes saved successfully!';
            $response['filenames'] = $filenames; // Return uploaded filenames
        } else {
            $response['message'] = 'Error saving changes. Please try again.';
        }
    } else {
        $response['message'] = 'No data received.';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

private function process_dynamic_features($section_type)
{
    $success = true;
    $i = 1;
    $max_index = 0;
    
    // First, get all existing features for this section
    $existing_features = $this->smuc_model->get_section_features($section_type);
    $existing_ids = array();
    foreach ($existing_features as $feature) {
        $existing_ids[] = $feature->id;
    }
    
    // Process features from POST data
    while ($this->input->post($section_type . '_feature_' . $i) !== null) {
        $feature_content = $this->input->post($section_type . '_feature_' . $i);
        $feature_id = $this->input->post($section_type . '_feature_' . $i . '_id');
        $delete_flag = $this->input->post($section_type . '_feature_' . $i . '_delete');
        
        // Check if this feature should be deleted
        if ($delete_flag === '1' && $feature_id) {
            // Delete the feature
            if (!$this->smuc_model->delete_feature($feature_id)) {
                $success = false;
            }
            
            // Remove from existing IDs array
            $key = array_search($feature_id, $existing_ids);
            if ($key !== false) {
                unset($existing_ids[$key]);
            }
        } 
        // Check if feature has content
        elseif (!empty(trim($feature_content))) {
            $data = array(
                'title' => $section_type . '_feature_' . $i,
                'content' => $feature_content,
                'edited_by' => $this->session->userdata('user_id'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            if ($feature_id) {
                // Update existing feature
                if (!$this->smuc_model->update_feature($feature_id, $data)) {
                    $success = false;
                }
                
                // Remove from existing IDs array
                $key = array_search($feature_id, $existing_ids);
                if ($key !== false) {
                    unset($existing_ids[$key]);
                }
            } else {
                // Insert new feature
                $data['created_at'] = date('Y-m-d H:i:s');
                if (!$this->smuc_model->insert_feature($data)) {
                    $success = false;
                }
            }
        }
        
        $max_index = $i;
        $i++;
    }
    
    // Delete any remaining features that weren't in the POST data
    foreach ($existing_ids as $id_to_delete) {
        if (!$this->smuc_model->delete_feature($id_to_delete)) {
            $success = false;
        }
    }
    
    return $success;
}
    
    
    private function handle_file_uploads(&$filenames) {
    $upload_path = FCPATH . 'assets_system/images/';
    
    // Create directory if it doesn't exist
    if (!is_dir($upload_path)) {
        mkdir($upload_path, 0777, true);
    }
    
    // Make sure it's writable
    chmod($upload_path, 0777);
    
    // Simple manual upload for all files
    foreach ($_FILES as $field => $file) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $filename = time() . '_' . basename($file['name']);
            $destination = $upload_path . $filename;
            
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $filenames[$field] = $filename;
                error_log("Uploaded: {$field} -> {$filename}");
            }
        }
    }
}

private function process_gallery_items($filenames) {
    $success = true;
    
    // Process Urethane Parts gallery
    $this->process_gallery_type('urethane_parts', $filenames);
    
    // Process Overmolding gallery
    $this->process_gallery_type('overmolding', $filenames);
    
    return $success;
}

private function process_gallery_type($type, $filenames) {
    $prefix = $type == 'urethane_parts' ? 'gallery_item_' : 'gallery_overmold_';
    
    // Get all form items
    $i = 1;
    $processed_items = array();
    
    while ($this->input->post($prefix . $i . '_title') !== null) {
        $item_data = array(
            'title' => $this->input->post($prefix . $i . '_title'),
            'description' => $this->input->post($prefix . $i . '_description'),
            'tags' => $this->input->post($prefix . $i . '_tags'),
            'type' => $type,
            'position' => $i
        );
        
        // Check if there's a new uploaded file
        $upload_field = $prefix . $i . '_image_upload';
        if (isset($filenames[$upload_field])) {
            $item_data['image'] = $filenames[$upload_field];
        } else {
            // Use existing image if no new upload
            $item_data['image'] = $this->input->post($prefix . $i . '_image');
        }
        
        $processed_items[] = $item_data;
        $i++;
    }
    
    // Delete existing items for this type
    $this->db->where('type', $type);
    $this->db->delete('tbl_gallery');
    
    // Insert new items
    foreach ($processed_items as $item_data) {
        $item_data['created_at'] = date('Y-m-d H:i:s');
        $item_data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->insert('tbl_gallery', $item_data);
    }
}

    // 6. IOT Solution
    public function iot_solution()
    {
        $data = array();
    
        // Hero Section
        $hero_title_data = $this->iotsolution_model->get_by_title('Real-Time Machine Monitoring Title');
        $hero_content_data = $this->iotsolution_model->get_by_title('Real-Time Machine Monitoring Content');
    
        $data['hero'] = array(
            'title' => $hero_title_data ? $hero_title_data['content'] : 'Real-Time Machine Monitoring That Keeps You in Control',
            'description' => $hero_content_data ? $hero_content_data['content'] : 'No subscription. No fixed cost. Just one setup that keeps you connected.',
            'image' => $hero_title_data ? $hero_title_data['image'] : 'new-herogemba.png'
        );
        $data['hero_title'] = $hero_title_data ? $hero_title_data : null;
        $data['hero_content'] = $hero_content_data ? $hero_content_data : null;
    
        // Solution Section
        $solution_problem_data = $this->iotsolution_model->get_by_title('Our Solution Problem');
        $solution_content_data = $this->iotsolution_model->get_by_title('Our Solution Content');
    
        $data['solution'] = array(
            'problem' => $solution_problem_data ? $solution_problem_data['content'] : 'Manual recording and delayed updates make it difficult to see what\'s really happening on the shop floor.',
            'content' => $solution_content_data ? $solution_content_data['content'] : 'The GEMBA Reporter Machine Monitoring System helps eliminate blind spots by capturing machine data automatically — so you can identify downtime causes, improve efficiency, and make data-driven decisions faster.',
            'image' => $solution_problem_data ? $solution_problem_data['image'] : 'Machine1.png'
        );
        $data['solution_problem'] = $solution_problem_data ? $solution_problem_data : null;
        $data['solution_content'] = $solution_content_data ? $solution_content_data : null;
    
        // Products Section
        $data['products_main_image'] = $this->iotsolution_model->get_by_title('Gemba Reporter Product Image') ?: array('image' => 'Gemba-repo.png');
        $data['base_station_title'] = $this->iotsolution_model->get_by_title('Base Station Product');
        $data['base_station_content'] = $this->iotsolution_model->get_by_title('Base Station Description');
        $data['smart_counter_title'] = $this->iotsolution_model->get_by_title('Smart Counter Product');
        $data['smart_counter_content'] = $this->iotsolution_model->get_by_title('Smart Counter Description');
    
        $data['products'] = array(
            'base_station' => array(
                'title' => $data['base_station_title'] ? $data['base_station_title']['content'] : 'Base Station',
                'content' => $data['base_station_content'] ? $data['base_station_content']['content'] : 'Acts as the control hub, receiving and storing data from up to 10 Smart Counters simultaneously. Loaded with Line Seiki\'s in-house software, it organizes the data and performs real-time analysis.'
            ),
            'smart_counter' => array(
                'title' => $data['smart_counter_title'] ? $data['smart_counter_title']['content'] : 'Smart Counter',
                'content' => $data['smart_counter_content'] ? $data['smart_counter_content']['content'] : 'Mounted directly on your machine, it collects essential data such as production quantity, cycle time, and operating status. It wirelessly transmits all data to the Base Station — no need for complex wiring'
            )
        );
    
        // System Setup
        $system_setup = $this->iotsolution_model->get_system_setup_for_admin();
        $data['system_setup'] = !empty($system_setup) ? $system_setup : array();
        $data['setup_diagram'] = $this->iotsolution_model->get_by_title('System Setup Diagram');
    
        // Production Data
        $production_data = array();
        $production_order = ['Control Page', 'Count Dashboard', 'Duration Dashboard', 'Overview'];
    
        foreach ($production_order as $item) {
            $title_data = $this->iotsolution_model->get_by_title('Production Data - ' . $item);
            $content_data = $this->iotsolution_model->get_by_title('Production Data - ' . $item . ' Content');
    
            $production_data[$item] = array(
                'title_id' => $title_data ? $title_data['id'] : '',
                'content_id' => $content_data ? $content_data['id'] : '',
                'content' => $content_data ? $content_data['content'] : '',
                'image' => $title_data ? $title_data['image'] : ''
            );
        }
        $data['production_data'] = $production_data;
    
        // Features Background Image - using "Section Background" title
        $data['section_background'] = $this->iotsolution_model->get_by_title('Section Background') ?: array('image' => 'decisionsbg.jpg', 'id' => '');
    
        // Features
        $features = array();
        $features_order = ['Real-Time Visibility', 'Wireless Installation', 'Scalable', 'Automated Records', 'Cost-Effective', 'Reliable'];
    
        foreach ($features_order as $feature) {
            $title_data = $this->iotsolution_model->get_by_title('Feature - ' . $feature);
            $content_data = $this->iotsolution_model->get_by_title('Feature - ' . $feature . ' Content');
    
            $features[$feature] = array(
                'title_id' => $title_data ? $title_data['id'] : '',
                'content_id' => $content_data ? $content_data['id'] : '',
                'content' => $content_data ? $content_data['content'] : '',
                'icon' => $title_data ? $title_data['image'] : ''
            );
        }
        $data['features'] = $features;
        $this->load->view('admin/iot_solution', $data);
    }

    public function save_iotsolution()
    {
        if ($this->input->post()) {
            // Handle file uploads for feature icons and background
            $upload_path = './assets_system/images/';
            
            // Create directory if it doesn't exist
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }
    
            // Process feature icon uploads
            $feature_icons = array();
            for ($i = 0; $i < 6; $i++) {
                if (isset($_FILES["feature_icon_file_$i"]) && $_FILES["feature_icon_file_$i"]['error'] == 0) {
                    $file = $_FILES["feature_icon_file_$i"];
                    
                    // Generate unique filename
                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $new_filename = 'feature_' . $i . '_' . time() . '.' . $ext;
                    $destination = $upload_path . $new_filename;
                    
                    // Move uploaded file
                    if (move_uploaded_file($file['tmp_name'], $destination)) {
                        $feature_icons[$i] = $new_filename;
                    }
                }
            }
    
            // Process features background image upload
            $features_background_image = null;
            if (isset($_FILES["features_background_file"]) && $_FILES["features_background_file"]['error'] == 0) {
                $file = $_FILES["features_background_file"];
                
                // Generate unique filename
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $new_filename = 'features_bg_' . time() . '.' . $ext;
                $destination = $upload_path . $new_filename;
                
                // Move uploaded file
                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $features_background_image = $new_filename;
                }
            } else {
                $features_background_image = $this->input->post('features_background_image');
            }
    
            // Hero Section
            $this->save_item('hero_title_id', 'hero_title', 'hero_image');
            $this->save_item('hero_content_id', 'hero_description');
    
            // Solution Section
            $this->save_item('problem_id', 'problem', 'solution_image');
            $this->save_item('solution_id', 'solution_content');
    
            // Products Section
            $this->save_item('products_main_image_id', null, 'products_main_image', 'Gemba Reporter Product Image');
            $this->save_item('base_station_title_id', 'base_station_title');
            $this->save_item('base_station_content_id', 'base_station_content');
            $this->save_item('smart_counter_title_id', 'smart_counter_title');
            $this->save_item('smart_counter_content_id', 'smart_counter_content');
    
            // System Setup Diagram
            $this->save_item('setup_diagram_id', null, 'setup_diagram_image', 'System Setup Diagram');
    
            // System Setup Items - DYNAMIC VERSION
            for ($i = 0; $i < 5; $i++) {
                $title_id = $this->input->post("setup_title_id_$i");
                $title = $this->input->post("setup_title_$i");
    
                // Update step title
                if ($title_id && $title) {
                    $this->iotsolution_model->update_content($title_id, array(
                        'content' => $title,
                        'edited_by' => $this->session->userdata('user_id') ?? 1
                    ));
                }
    
                // Get the item count for this step
                $item_count = $this->input->post("setup_item_count_$i");
                if (!$item_count) {
                    // Fallback to checking existing items
                    $item_count = 0;
                    while ($this->input->post("setup_item_{$i}_{$item_count}") !== null) {
                        $item_count++;
                    }
                }
    
                // Track existing item IDs to detect deletions
                $existing_items = $this->iotsolution_model->get_like_title("System Setup - " . $title . " Item");
                $existing_ids = array();
                foreach ($existing_items as $item) {
                    $existing_ids[] = $item['id'];
                }
                
                $processed_ids = array();
    
                // Process each item for this step
                for ($j = 0; $j < $item_count; $j++) {
                    $item_id = $this->input->post("setup_item_id_{$i}_{$j}");
                    $item_content = $this->input->post("setup_item_{$i}_{$j}");
    
                    if ($item_content !== null && trim($item_content) !== '') {
                        if (!empty($item_id)) {
                            // Update existing item
                            $this->iotsolution_model->update_content($item_id, array(
                                'content' => $item_content,
                                'edited_by' => $this->session->userdata('user_id') ?? 1
                            ));
                            $processed_ids[] = $item_id;
                        } else {
                            // Insert new item
                            $item_number = $j + 1;
                            $new_item_data = array(
                                'title' => "System Setup - $title Item $item_number",
                                'content' => $item_content,
                                'image' => null,
                                'edited_by' => $this->session->userdata('user_id') ?? 1,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            );
                            $new_id = $this->iotsolution_model->insert_content($new_item_data);
                            if ($new_id) {
                                $processed_ids[] = $new_id;
                            }
                        }
                    }
                }
    
                // Delete items that were not processed (removed by user)
                $deleted_ids = array_diff($existing_ids, $processed_ids);
                foreach ($deleted_ids as $del_id) {
                    $this->iotsolution_model->delete_content($del_id);
                }
            }
    
            // Production Data
            for ($i = 0; $i < 4; $i++) {
                $title_id = $this->input->post("production_title_id_$i");
                $content_id = $this->input->post("production_content_id_$i");
                $content = $this->input->post("production_content_$i");
                $image = $this->input->post("production_image_$i");
    
                if ($title_id && $image !== null) {
                    $this->iotsolution_model->update_content($title_id, array(
                        'image' => $image,
                        'edited_by' => $this->session->userdata('user_id') ?? 1
                    ));
                }
    
                if ($content_id && $content !== null) {
                    $this->iotsolution_model->update_content($content_id, array(
                        'content' => $content,
                        'edited_by' => $this->session->userdata('user_id') ?? 1
                    ));
                }
            }
    
            // Save Features Background Image - using "Section Background" title
            $features_background_id = $this->input->post('features_background_id');
            if ($features_background_id && $features_background_image) {
                $this->iotsolution_model->update_content($features_background_id, array(
                    'image' => $features_background_image,
                    'edited_by' => $this->session->userdata('user_id') ?? 1
                ));
            } else if ($features_background_image) {
                // Check if record exists by title "Section Background"
                $existing = $this->iotsolution_model->get_by_title('Section Background');
                if ($existing) {
                    $this->iotsolution_model->update_content($existing['id'], array(
                        'image' => $features_background_image,
                        'edited_by' => $this->session->userdata('user_id') ?? 1
                    ));
                } else {
                    // Create new record
                    $new_data = array(
                        'title' => 'Section Background',
                        'content' => 'Features Section Background',
                        'image' => $features_background_image,
                        'edited_by' => $this->session->userdata('user_id') ?? 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    $this->iotsolution_model->insert_content($new_data);
                }
            }
    
            // Features - WITH ICON HANDLING
            $features_order = [
                'Real-Time Visibility',
                'Wireless Installation',
                'Scalable',
                'Automated Records',
                'Cost-Effective',
                'Reliable'
            ];
    
            for ($i = 0; $i < 6; $i++) {
                $title_id = $this->input->post("feature_title_id_$i");
                $content_id = $this->input->post("feature_content_id_$i");
                $content = $this->input->post("feature_content_$i");
                $icon_filename = $this->input->post("feature_icon_$i");
    
                // If a new icon was uploaded, use that filename
                if (isset($feature_icons[$i])) {
                    $icon_filename = $feature_icons[$i];
                }
    
                // Update feature title with icon
                if ($title_id) {
                    $update_data = array(
                        'edited_by' => $this->session->userdata('user_id') ?? 1
                    );
                    
                    // Update image field with icon filename
                    if ($icon_filename !== null) {
                        $update_data['image'] = $icon_filename;
                    }
                    
                    $this->iotsolution_model->update_content($title_id, $update_data);
                } else {
                    // If no title_id exists, try to find by title
                    $feature_title = $features_order[$i];
                    $existing = $this->iotsolution_model->get_by_title('Feature - ' . $feature_title);
                    
                    if ($existing) {
                        $update_data = array(
                            'edited_by' => $this->session->userdata('user_id') ?? 1
                        );
                        
                        if ($icon_filename !== null) {
                            $update_data['image'] = $icon_filename;
                        }
                        
                        $this->iotsolution_model->update_content($existing['id'], $update_data);
                    } else {
                        // Create new feature title record
                        $new_title_data = array(
                            'title' => 'Feature - ' . $feature_title,
                            'content' => $feature_title,
                            'image' => $icon_filename,
                            'edited_by' => $this->session->userdata('user_id') ?? 1,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        );
                        $this->iotsolution_model->insert_content($new_title_data);
                    }
                }
    
                // Update feature content
                if ($content_id && $content !== null) {
                    $this->iotsolution_model->update_content($content_id, array(
                        'content' => $content,
                        'edited_by' => $this->session->userdata('user_id') ?? 1
                    ));
                } else if ($content !== null && trim($content) !== '') {
                    // Create new content record if it doesn't exist
                    $feature_title = $features_order[$i];
                    $existing_content = $this->iotsolution_model->get_by_title('Feature - ' . $feature_title . ' Content');
                    
                    if (!$existing_content) {
                        $new_content_data = array(
                            'title' => 'Feature - ' . $feature_title . ' Content',
                            'content' => $content,
                            'image' => null,
                            'edited_by' => $this->session->userdata('user_id') ?? 1,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        );
                        $this->iotsolution_model->insert_content($new_content_data);
                    }
                }
            }
    
            // Return JSON response for AJAX
            if ($this->input->is_ajax_request()) {
                echo json_encode(array('success' => true, 'message' => 'IoT Solution content updated successfully!'));
            } else {
                $this->session->set_flashdata('success', 'IoT Solution content updated successfully!');
                redirect('cms/iot_solution');
            }
        }
    }

    private function save_item($id_field, $content_field = null, $image_field = null, $default_title = null)
    {
        $id = $this->input->post($id_field);
        $content = $content_field ? $this->input->post($content_field) : null;
        $image = $image_field ? $this->input->post($image_field) : null;

        if (!empty($id)) {
            $data = array('edited_by' => $this->session->userdata('user_id') ?? 1);

            if ($content !== null) {
                $data['content'] = $content;
            }

            if ($image !== null) {
                $data['image'] = $image;
            }

            return $this->iotsolution_model->update_content($id, $data);
        } else if ($default_title && ($content !== null || $image !== null)) {
            // Insert new record if doesn't exist
            $insert_data = array(
                'title' => $default_title,
                'edited_by' => $this->session->userdata('user_id') ?? 1
            );

            if ($content !== null) {
                $insert_data['content'] = $content;
            }

            if ($image !== null) {
                $insert_data['image'] = $image;
            }

            return $this->iotsolution_model->insert_content($insert_data);
        }

        return false;
    }

    // 7. News and Events
    function news_and_events()
    {
        $data['page_title'] = 'Events Management';
        $data['events'] = $this->event_model->get_all_events(null, 0, null);

        $this->load->view('admin/news_and_events_simplified', $data);
    }

    public function create_event()
    {
        $data['page_title'] = 'Create New Event';

        $this->load->view('admin/create_event_simplified', $data);
    }

    public function store()
    {
        // Form validation
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('content', 'Content', 'required|trim');
        $this->form_validation->set_rules('category', 'Category', 'required|trim');
        $this->form_validation->set_rules('event_date', 'Event Date', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            $data = array(
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'meta_description' => $this->input->post('meta_description'),
                'category' => $this->input->post('category'),
                'event_date' => $this->input->post('event_date'),
                'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                'is_gated' => $this->input->post('is_gated') ? 1 : 0,
                'badge_text' => $this->input->post('badge_text'),
                'status' => $this->input->post('status'),
                'image' => $this->input->post('image'),
                'edited_by' => $this->session->userdata('admin_id'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            // Handle image upload
            if (!empty($_FILES['image_file']['name'])) {
                $upload_result = $this->upload_image();
                if ($upload_result['success']) {
                    $data['image'] = $upload_result['file_name'];
                }
            }

            $this->event_model->save_event($data);

            $this->session->set_flashdata('success', 'Event created successfully!');
            redirect('cms/news_and_events');
        }
    }

    public function edit_event($id)
    {
        $data['page_title'] = 'Edit Event';
        $data['event'] = $this->event_model->get_event_by_id($id);

        if (empty($data['event'])) {
            $this->session->set_flashdata('error', 'Event not found!');
            redirect('cms/news_and_events');
        }

        $this->load->view('admin/header');
        $this->load->view('admin/edit_event_simplified', $data);
    }

    public function update_event($id)
    {
        // Form validation
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('content', 'Content', 'required|trim');
        $this->form_validation->set_rules('category', 'Category', 'required|trim');
        $this->form_validation->set_rules('event_date', 'Event Date', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
        } else {
            $data = array(
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'meta_description' => $this->input->post('meta_description'),
                'category' => $this->input->post('category'),
                'event_date' => $this->input->post('event_date'),
                'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                'is_gated' => $this->input->post('is_gated') ? 1 : 0,
                'badge_text' => $this->input->post('badge_text'),
                'status' => $this->input->post('status'),
                'edited_by' => $this->session->userdata('admin_id'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            // Handle image upload
            if (!empty($_FILES['image_file']['name'])) {
                $upload_result = $this->upload_image();
                if ($upload_result['success']) {
                    $data['image'] = $upload_result['file_name'];

                    // Delete old image if exists
                    $old_event = $this->event_model->get_event_by_id($id);
                    if (!empty($old_event['image'])) {
                        $old_image_path = FCPATH . 'assets_system/images/' . $old_event['image'];
                        if (file_exists($old_image_path)) {
                            unlink($old_image_path);
                        }
                    }
                }
            } elseif ($this->input->post('image')) {
                $data['image'] = $this->input->post('image');
            }

            $this->event_model->update_event($id, $data);

            $this->session->set_flashdata('success', 'Event updated successfully!');
            redirect('cms/news_and_events');
        }
    }

    public function delete_event($id)
    {
        $data = array(
            'status' => 'inactive',
            'deleted_at' => date('Y-m-d H:i:s'),
            'edited_by' => $this->session->userdata('admin_id')
        );

        $this->event_model->update_event($id, $data);

        $this->session->set_flashdata('success', 'Event deleted successfully!');
        redirect('cms/news_and_events');
    }

    private function upload_image()
    {
        $config['upload_path'] = FCPATH . 'assets_system/images/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('image_file')) {
            return array(
                'success' => FALSE,
                'error' => $this->upload->display_errors()
            );
        } else {
            $upload_data = $this->upload->data();
            return array(
                'success' => TRUE,
                'file_name' => $upload_data['file_name']
            );
        }
    }
    private function category_upload_image()
    {
        $config['upload_path'] = FCPATH . 'assets_system/images/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('product_image')) {
            return array(
                'success' => FALSE,
                'error' => $this->upload->display_errors()
            );
        } else {
            $upload_data = $this->upload->data();
            return array(
                'success' => TRUE,
                'file_name' => $upload_data['file_name']
            );
        }
    }
    function toggle_status($id)
    {
        $event = $this->event_model->get_event_by_id($id);

        if ($event) {
            $new_status = $event['status'] == 'active' ? 'inactive' : 'active';

            $data = array(
                'status' => $new_status,
                'updated_at' => date('Y-m-d H:i:s'),
                'edited_by' => $this->session->userdata('admin_id')
            );

            $this->event_model->update_event($id, $data);

            $this->session->set_flashdata('success', 'Event status updated!');
        }

        redirect('cms/news_and_events');
    }


    // 8. Library
    function library()
    {
        $data = array();

        // Get statistics
        $data['total_videos'] = $this->admin_library_model->count_videos();
        $data['total_pdfs'] = $this->admin_library_model->count_pdfs();
        $data['total_items'] = $this->admin_library_model->count_all();

        // Get featured resource
        $data['featured_resource'] = $this->admin_library_model->get_featured_resource();

        // Get all resources
        $data['resources'] = $this->admin_library_model->get_all_items();
        $data['webinars'] = $this->admin_library_model->get_all_webinars();
        $this->load->view('admin/library', $data);
    }

    public function library_create()
    {
        $data = array();
    
        if ($_POST) {
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('content', 'Content', 'required');
            $this->form_validation->set_rules('resource_type', 'Resource Type', 'required');
    
            if ($this->form_validation->run() !== FALSE) {
                $resource_type = $this->input->post('resource_type'); // This will be 'Videos' or 'brochure'
                $upload_data = array();
                $image_name = '';
                $pdf_file_name = '';
                $video_url = $this->input->post('video_url') ?: '';
    
                // Handle file uploads based on resource type
                if ($resource_type == 'Videos') {
                    // Upload image for video (thumbnail)
                    if (!empty($_FILES['image_file']['name'])) {
                        $upload = $this->admin_library_model->upload_image('image_file');
                        if (isset($upload['error'])) {
                            $this->session->set_flashdata('error', 'Image upload failed: ' . $upload['error']);
                            redirect('cms/library_create');
                            return;
                        } else {
                            $image_name = $upload['success']['file_name'];
                        }
                    } else {
                        // Check if image URL is provided
                        $image_url_input = $this->input->post('image_url');
                        if (!empty($image_url_input)) {
                            $image_name = $image_url_input;
                        }
                    }
                } elseif ($resource_type == 'brochure') {
                    // Upload PDF file
                    if (!empty($_FILES['pdf_file']['name'])) {
                        $upload = $this->admin_library_model->upload_pdf('pdf_file');
                        if (isset($upload['error'])) {
                            $this->session->set_flashdata('error', 'PDF upload failed: ' . $upload['error']);
                            redirect('cms/library_create');
                            return;
                        } else {
                            $pdf_file_name = $upload['success']['file_name'];
                        }
                    } else {
                        // Check if PDF filename is provided
                        $pdf_file_url = $this->input->post('pdf_file_url');
                        if (!empty($pdf_file_url)) {
                            $pdf_file_name = $pdf_file_url;
                        }
                    }
                }
                
                // Note: video_file type is hidden in your form, so we're not handling it
    
                // Prepare data for database
                $webinar_id = $this->input->post('webinar_id');
                $data = array(
                    'title' => $this->input->post('title'),
                    'content' => $this->input->post('content'),
                    'resource_type' => $resource_type, // 'Videos' or 'brochure'
                    'webinar_id' => (!empty($webinar_id) && $webinar_id != '0') ? intval($webinar_id) : NULL,
                    'edited_by' => $this->session->userdata('admin_id'),
                    'is_gated' => $this->input->post('is_gated') ? 1 : 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
    
                // Set appropriate file fields based on resource type
                if ($resource_type == 'Videos') {
                    $data['image'] = $image_name; // Store image filename for videos
                    if (!empty($video_url)) {
                        $data['video_url'] = $video_url; // Store video URL
                    }
                } elseif ($resource_type == 'brochure') {
                    $data['pdf_file'] = $pdf_file_name; // Store PDF filename for brochures
                    // Clear image field for PDF resources
                    $data['image'] = '';
                }
    
                if ($this->admin_library_model->create_resource($data)) {
                    $this->session->set_flashdata('success', 'Resource created successfully!');
                    redirect('cms/library');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create resource.');
                }
            }
        }
    
        $data['webinars'] = $this->admin_library_model->get_all_webinars();
        $this->load->view('admin/header');
        $this->load->view('admin/library_create_views', $data);
    }

    private function library_upload_video($file_input_name)
    {
        $config['upload_path'] = './assets_system/videos/';
        $config['allowed_types'] = 'mp4|avi|mov|wmv|flv|webm';
        $config['max_size'] = 51200; // 50MB
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
                $this->upload->initialize($config);

        if (!$this->upload->do_upload($file_input_name)) {
            return array('error' => $this->upload->display_errors());
        } else {
            return array('success' => $this->upload->data());
        }
    }

   public function library_edit($id)
    {
        $data['resource'] = $this->admin_library_model->get_item($id);
    
        if (!$data['resource']) {
            show_404();
        }
    
        if ($_POST) {
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('content', 'Content', 'required');
    
            if ($this->form_validation->run() !== FALSE) {
                $image_name = $this->input->post('current_image'); // Default to current image
                $pdf_file_name = $this->input->post('current_pdf_file'); // Default to current PDF
                $video_url = $this->input->post('video_url') ?: '';
                
                // Load upload library
                $this->load->library('upload');
                
                // ==================== IMAGE HANDLING ====================
                // Handle image removal
                $remove_image = $this->input->post('remove_image');
                if ($remove_image == '1') {
                    $image_name = '';
                    // Delete old image file if exists
                    if (!empty($data['resource']['image']) && file_exists('./assets_system/images/' . $data['resource']['image'])) {
                        unlink('./assets_system/images/' . $data['resource']['image']);
                    }
                }
                
                // Handle new image upload
                if (!empty($_FILES['image_file']['name'])) {
                    $config['upload_path'] = './assets_system/images/';
                    $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                    $config['max_size'] = 2048; // 2MB
                    $config['encrypt_name'] = TRUE;
                    
                    $this->upload->initialize($config);
                    
                    if ($this->upload->do_upload('image_file')) {
                        $upload_data = $this->upload->data();
                        $image_name = $upload_data['file_name'];
                        
                        // Delete old image if exists
                        if (!empty($data['resource']['image']) && file_exists('./assets_system/images/' . $data['resource']['image'])) {
                            unlink('./assets_system/images/' . $data['resource']['image']);
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Image upload failed: ' . $this->upload->display_errors());
                        redirect('cms/library_edit/' . $id);
                    }
                } 
                // Handle image URL/name input
                elseif ($this->input->post('image_url')) {
                    $image_name = $this->input->post('image_url');
                    
                    // If user enters a new image filename and there was an old image, delete the old one
                    if ($image_name != $data['resource']['image'] && !empty($data['resource']['image']) && 
                        file_exists('./assets_system/images/' . $data['resource']['image'])) {
                        unlink('./assets_system/images/' . $data['resource']['image']);
                    }
                }
                
                // ==================== PDF FILE HANDLING ====================
                // Handle PDF file removal
                $remove_pdf_file = $this->input->post('remove_pdf_file');
                if ($remove_pdf_file == '1') {
                    $pdf_file_name = '';
                    // Delete old PDF file if exists
                    if (!empty($data['resource']['pdf_file']) && file_exists('./assets_system/images/' . $data['resource']['pdf_file'])) {
                        unlink('./assets_system/documents/' . $data['resource']['pdf_file']);
                    }
                }
                
                // Handle new PDF file upload
                if (!empty($_FILES['pdf_file']['name'])) {
                    $pdf_config['upload_path'] = './assets_system/documents/';
                    $pdf_config['allowed_types'] = 'pdf';
                    $pdf_config['max_size'] = 5120; // 5MB
                    $pdf_config['encrypt_name'] = TRUE;
                    
                    // Re-initialize upload library for PDF
                    $this->upload->initialize($pdf_config);
                    
                    if ($this->upload->do_upload('pdf_file')) {
                        $pdf_upload_data = $this->upload->data();
                        $pdf_file_name = $pdf_upload_data['file_name'];
                        
                        // Delete old PDF file if exists
                        if (!empty($data['resource']['pdf_file']) && file_exists('./assets_system/images/' . $data['resource']['pdf_file'])) {
                            unlink('./assets_system/documents/' . $data['resource']['pdf_file']);
                        }
                        
                        // If this is a PDF resource, we should clear the image field
                        if (stripos($this->input->post('content'), 'Download PDF') !== false) {
                            $image_name = '';
                            // Also delete the image file if it exists
                            if (!empty($data['resource']['image']) && file_exists('./assets_system/images/' . $data['resource']['image'])) {
                                unlink('./assets_system/images/' . $data['resource']['image']);
                            }
                        }
                    } else {
                        $this->session->set_flashdata('error', 'PDF upload failed: ' . $this->upload->display_errors());
                        redirect('cms/library_edit/' . $id);
                    }
                } 
                // Handle PDF filename input
                elseif ($this->input->post('pdf_file_url')) {
                    $pdf_file_name = $this->input->post('pdf_file_url');
                    
                    // If user enters a new PDF filename and there was an old PDF, delete the old one
                    if ($pdf_file_name != $data['resource']['pdf_file'] && !empty($data['resource']['pdf_file']) && 
                        file_exists('./assets_system/documents/' . $data['resource']['pdf_file'])) {
                        unlink('./assets_system/documents/' . $data['resource']['pdf_file']);
                    }
                    
                    // If this is a PDF resource, we should clear the image field
                    if (stripos($this->input->post('content'), 'Download PDF') !== false) {
                        $image_name = '';
                    }
                }
                
                // ==================== RESOURCE TYPE LOGIC ====================
                // Determine resource type based on content
                $content = $this->input->post('content');
                $resource_type = $this->input->post('resource_type');
                
                // If resource type is PDF but user uploaded an image, clear image
                if ($resource_type === 'pdf' && !empty($_FILES['image_file']['name'])) {
                    $image_name = '';
                }
                
                // If resource type is video but user uploaded a PDF, clear PDF
                if ($resource_type === 'video' && !empty($_FILES['pdf_file']['name'])) {
                    $pdf_file_name = '';
                }
                
                // ==================== PREPARE UPDATE DATA ====================
                $webinar_id = $this->input->post('webinar_id');
                $update_data = array(
                    'title' => $this->input->post('title'),
                    'content' => $content,
                    'image' => $image_name,
                    'pdf_file' => $pdf_file_name,
                    'webinar_id' => (!empty($webinar_id) && $webinar_id != '0') ? intval($webinar_id) : NULL,
                    'is_gated' => $this->input->post('is_gated') ? 1 : 0,
                    'video_url' => $video_url,
                    'edited_by' => $this->session->userdata('admin_id'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
    
                if ($this->admin_library_model->update_resource($id, $update_data)) {
                    $this->session->set_flashdata('success', 'Resource updated successfully!');
                    redirect('cms/library');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update resource.');
                }
            }
        }
    

        $data['webinars'] = $this->admin_library_model->get_all_webinars();
        $this->load->view('admin/library_edit_views', $data);
    }

    public function library_delete($id)
    {
        if ($this->admin_library_model->delete_resource($id)) {
            $this->session->set_flashdata('success', 'Resource deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete resource.');
        }
        redirect('cms/library');
    }

    public function library_set_featured($id)
    {
        // Update featured video (ID 2) with new content
        $resource = $this->admin_library_model->get_item($id);

        if ($resource) {
            $data = array(
                'title' => $resource['title'],
                'content' => $resource['content'],
                'image' => $resource['image'],
                'edited_by' => $this->session->userdata('admin_id')
            );

            if ($this->admin_library_model->update_resource(2, $data)) {
                $this->session->set_flashdata('success', 'Featured resource updated successfully!');
            } else {
                $this->session->set_flashdata('error', 'Failed to update featured resource.');
            }
        }

        redirect('cms/library');
    }

    public function library_search()
    {
        $keyword = $this->input->get('search');
        $type = $this->input->get('type');

        $data = array();

        if ($keyword) {
            $data['resources'] = $this->admin_library_model->search_resources($keyword);
        } elseif ($type && $type != 'all') {
            $data['resources'] = $this->admin_library_model->get_items_by_type($type);
        } else {
            $data['resources'] = $this->admin_library_model->get_all_items();
        }
        $data['type'] = $type;
        // Get statistics
        $data['total_videos'] = $this->admin_library_model->count_videos();
        $data['total_pdfs'] = $this->admin_library_model->count_pdfs();
        $data['total_items'] = $this->admin_library_model->count_all();
        $data['featured_resource'] = $this->admin_library_model->get_featured_resource();

        $this->load->view('admin/header');
        $this->load->view('admin/library', $data);
    }

    // ==================== WEBINAR MANAGEMENT ====================

    /**
     * Create a new webinar
     */
    public function webinar_create()
    {
        if ($_POST) {
            $this->form_validation->set_rules('webinar_title', 'Webinar Title', 'required');

            if ($this->form_validation->run() !== FALSE) {
                $image_name = '';

                // Handle main image upload
                if (!empty($_FILES['main_image']['name'])) {
                    $config['upload_path'] = FCPATH . 'assets_system/images/';
                    $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                    $config['max_size'] = 2048;
                    $config['encrypt_name'] = TRUE;

                    $this->load->library('upload');
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('main_image')) {
                        $upload_data = $this->upload->data();
                        $image_name = $upload_data['file_name'];
                    } else {
                        $this->session->set_flashdata('error', 'Image upload failed: ' . $this->upload->display_errors('', ''));
                        redirect('cms/webinar_create');
                        return;
                    }
                } elseif ($this->input->post('main_image_url')) {
                    $image_name = $this->input->post('main_image_url');
                }

                $data = array(
                    'webinar_title' => $this->input->post('webinar_title'),
                    'main_image' => $image_name,
                    'description_1' => $this->input->post('description_1'),
                    'description_2' => $this->input->post('description_2')
                );

                if ($this->admin_library_model->create_webinar($data)) {
                    $this->session->set_flashdata('success', 'Webinar created successfully!');
                    redirect('cms/library');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create webinar.');
                }
            }
        }

        $data = array();
        $this->load->view('admin/header');
        $this->load->view('admin/webinar_create_views', $data);
    }

    /**
     * Edit an existing webinar
     */
    public function webinar_edit($id)
    {
        $data['webinar'] = $this->admin_library_model->get_webinar($id);

        if (!$data['webinar']) {
            show_404();
        }

        if ($this->input->post() || !empty($_FILES['main_image']['name'])) {
            $this->form_validation->set_rules('webinar_title', 'Webinar Title', 'required');

            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('error', 'Validation failed: ' . validation_errors('', ''));
            } else {
                $image_name = $this->input->post('current_image');

                // Handle image removal
                if ($this->input->post('remove_image') == '1') {
                    $image_name = '';
                    if (!empty($data['webinar']['main_image']) && file_exists(FCPATH . 'assets_system/images/' . $data['webinar']['main_image'])) {
                        unlink(FCPATH . 'assets_system/images/' . $data['webinar']['main_image']);
                    }
                }

                // Handle new image upload
                $has_file = isset($_FILES['main_image']) && !empty($_FILES['main_image']['name']) && $_FILES['main_image']['error'] == 0;

                if ($has_file) {
                    $upload_config = array(
                        'upload_path'   => FCPATH . 'assets_system/images/',
                        'allowed_types' => 'jpg|jpeg|jfif|png|gif|webp',
                        'max_size'      => 5120,
                        'encrypt_name'  => TRUE
                    );

                    $this->load->library('upload');
                    $this->upload->initialize($upload_config);

                    if ($this->upload->do_upload('main_image')) {
                        $upload_data = $this->upload->data();
                        $image_name = $upload_data['file_name'];
                        // Delete old image
                        if (!empty($data['webinar']['main_image']) && file_exists(FCPATH . 'assets_system/images/' . $data['webinar']['main_image'])) {
                            unlink(FCPATH . 'assets_system/images/' . $data['webinar']['main_image']);
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Image upload failed: ' . $this->upload->display_errors('', ''));
                        redirect('cms/webinar_edit/' . $id);
                        return;
                    }
                } elseif ($this->input->post('main_image_url')) {
                    $image_name = $this->input->post('main_image_url');
                }

                $update_data = array(
                    'webinar_title' => $this->input->post('webinar_title'),
                    'main_image' => $image_name,
                    'description_1' => $this->input->post('description_1'),
                    'description_2' => $this->input->post('description_2')
                );

                if ($this->admin_library_model->update_webinar($id, $update_data)) {
                    $this->session->set_flashdata('success', 'Webinar updated successfully!');
                    redirect('cms/library');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update webinar.');
                }
            }
        }

        $this->load->view('admin/header');
        $this->load->view('admin/webinar_edit_views', $data);
    }

    /**
     * Delete a webinar
     */
    /**
     * Set a webinar as featured
     */
    public function webinar_set_featured($id)
    {
        $webinar = $this->admin_library_model->get_webinar($id);
        if ($webinar) {
            $this->admin_library_model->toggle_featured_webinar($id);
            $is_now_featured = (isset($webinar['is_featured']) && $webinar['is_featured'] == 1) ? false : true;
            if ($is_now_featured) {
                $this->session->set_flashdata('success', '"' . $webinar['webinar_title'] . '" is now featured!');
            } else {
                $this->session->set_flashdata('success', '"' . $webinar['webinar_title'] . '" has been removed from featured.');
            }
        } else {
            $this->session->set_flashdata('error', 'Webinar not found.');
        }
        redirect('cms/library');
    }

    public function webinar_delete($id)
    {
        $webinar = $this->admin_library_model->get_webinar($id);

        if ($webinar) {
            // Delete webinar image if exists
            if (!empty($webinar['main_image']) && file_exists(FCPATH . 'assets_system/images/' . $webinar['main_image'])) {
                unlink(FCPATH . 'assets_system/images/' . $webinar['main_image']);
            }

            if ($this->admin_library_model->delete_webinar($id)) {
                $this->session->set_flashdata('success', 'Webinar deleted successfully!');
            } else {
                $this->session->set_flashdata('error', 'Failed to delete webinar.');
            }
        } else {
            $this->session->set_flashdata('error', 'Webinar not found.');
        }

        redirect('cms/library');
    }

    // 9. Contact Us
    function contact_us()
    {
        // Get all content for display
        $data['content_items'] = $this->contact_us_admin_model->get_all_content();

        $this->load->view('admin/header');
        $this->load->view('admin/contact_us', $data);
    }

    /**
     * AJAX: Save all contact us content at once
     */
    public function contact_us_save_all()
    {
        $this->output->set_content_type('application/json');

        $items = $this->input->post('items');
        if (empty($items) || !is_array($items)) {
            echo json_encode(['success' => false, 'message' => 'No data received.']);
            return;
        }

        $updated = 0;
        $errors = array();

        foreach ($items as $item) {
            $id = isset($item['id']) ? (int)$item['id'] : 0;
            if ($id <= 0) continue;

            $data = array(
                'content' => isset($item['content']) ? $item['content'] : '',
                'edited_by' => $this->session->userdata('user_id')
            );

            // Handle image upload for this item
            $file_key = 'image_file_' . $id;
            if (!empty($_FILES[$file_key]['name'])) {
                $config = array(
                    'upload_path'   => FCPATH . 'assets_system/images/',
                    'allowed_types' => 'jpg|jpeg|png|gif|webp',
                    'max_size'      => 2048,
                    'encrypt_name'  => true
                );
                $this->load->library('upload');
                $this->upload->initialize($config);

                if ($this->upload->do_upload($file_key)) {
                    $upload_data = $this->upload->data();

                    // Delete old image
                    $old = $this->contact_us_admin_model->get_by_id($id);
                    if ($old && !empty($old['image'])) {
                        $old_path = FCPATH . 'assets_system/images/' . $old['image'];
                        if (file_exists($old_path)) {
                            unlink($old_path);
                        }
                    }
                    $data['image'] = $upload_data['file_name'];
                } else {
                    $errors[] = 'Image upload failed for item #' . $id . ': ' . $this->upload->display_errors('', '');
                }
            }

            if ($this->contact_us_admin_model->save($data, $id)) {
                $updated++;
            }
        }

        if (!empty($errors)) {
            echo json_encode(['success' => true, 'message' => $updated . ' items updated. Warnings: ' . implode('; ', $errors)]);
        } else {
            echo json_encode(['success' => true, 'message' => $updated . ' items updated successfully!']);
        }
    }

    public function delete_contact($id)
    {
        // Get item to check if it has an image
        $item = $this->contact_us_admin_model->get_by_id($id);

        // Delete the image file if it exists
        if ($item && !empty($item['image'])) {
            $image_path = FCPATH . 'assets_system/images/' . $item['image'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        // Delete from database
        if ($this->contact_us_admin_model->delete($id)) {
            $this->session->set_flashdata('success', 'Content deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete content.');
        }
        redirect('cms/contact_us');
    }

    /**
     * Handle image upload via AJAX
     */
    public function contact_upload_image()
    {
        $config['upload_path'] = FCPATH . 'assets_system/images/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = true; // Encrypt file name for security

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ($this->upload->do_upload('image')) {
            $upload_data = $this->upload->data();
            $response = [
                'success' => true,
                'filename' => $upload_data['file_name'],
                'message' => 'Image uploaded successfully'
            ];
        } else {
            $response = [
                'success' => false,
                'error' => $this->upload->display_errors('', ''),
                'message' => 'Failed to upload image'
            ];
        }

        echo json_encode($response);
    }

    /**
     * Handle form submission for create/update
     */
    private function handle_form_submission()
    {
        $this->form_validation->set_rules('title', 'Title', 'required|max_length[255]');
        $this->form_validation->set_rules('content', 'Content', 'required');

        if ($this->form_validation->run() === TRUE) {
            $id = $this->input->post('id');
            $data = array(
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'image' => $this->input->post('image'),
                'edited_by' => $this->session->userdata('user_id')
            );

            // Handle image upload if file is provided
            if (!empty($_FILES['image_file']['name'])) {
                $upload_result = $this->upload_image_file();
                if ($upload_result['success']) {
                    // Delete old image if exists
                    if ($id) {
                        $old_item = $this->contact_us_admin_model->get_by_id($id);
                        if ($old_item && !empty($old_item['image']) && $old_item['image'] != $upload_result['filename']) {
                            $old_image_path = FCPATH . 'assets_system/images/' . $old_item['image'];
                            if (file_exists($old_image_path)) {
                                unlink($old_image_path);
                            }
                        }
                    }
                    $data['image'] = $upload_result['filename'];
                } else {
                    $this->session->set_flashdata('error', $upload_result['error']);
                    redirect('cms/contact_us');
                    return;
                }
            }

            if ($this->contact_us_admin_model->save($data, $id)) {
                $message = $id ? 'Content updated successfully!' : 'Content created successfully!';
                $this->session->set_flashdata('success', $message);
            } else {
                $message = $id ? 'Failed to update content.' : 'Failed to create content.';
                $this->session->set_flashdata('error', $message);
            }

            redirect('cms/contact_us');
        }
    }

    /**
     * Upload image file (for form submission)
     */
    private function upload_image_file()
    {
        $config['upload_path'] = FCPATH . 'assets_system/images/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = true; // Encrypt file name for security

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ($this->upload->do_upload('image_file')) {
            $upload_data = $this->upload->data();
            return [
                'success' => true,
                'filename' => $upload_data['file_name']
            ];
        } else {
            return [
                'success' => false,
                'error' => $this->upload->display_errors('', '')
            ];
        }
    }
    
    public function product_1() {
        $data['switches'] = $this->safety_switches_model->get_all_switches();
        
        $this->load->view('admin/safety_switches', $data);
    }
    
      public function get_switch($id) {
        $switch = $this->safety_switches_model->get_switch($id);
        
        if ($switch) {
            echo json_encode(array(
                'success' => true,
                'data' => array(
                    'id' => $switch->id,
                    'title' => $switch->title,
                    'content' => $switch->content,
                    'features' => $switch->features,
                    'image' => $switch->image
                )
            ));
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'Switch not found'
            ));
        }
    }
    
    /**
     * AJAX: Save switch (create or update)
     */
    public function save_switch() {
        // Set JSON header
        header('Content-Type: application/json');
        
        // Get POST data
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $content = $this->input->post('content');
        $features = $this->input->post('features');
        $current_image = $this->input->post('current_image');
        
        // Validate required fields
        if (empty($title) || empty($content)) {
            echo json_encode(array(
                'success' => false,
                'message' => 'Title and Content are required fields.'
            ));
            return;
        }
        
        $data = array(
            'title' => $title,
            'content' => $content,
            'features' => $features,
            'edited_by' => $this->session->userdata('admin_id'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        // Handle image upload if new image is provided
        if (!empty($_FILES['image']['name'])) {
            $upload_result = $this->upload_image();
            if ($upload_result['success']) {
                $data['image'] = $upload_result['file_name'];
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Image upload failed: ' . $upload_result['error']
                ));
                return;
            }
        } else if (!empty($current_image)) {
            // Keep the current image if no new image uploaded
            $data['image'] = $current_image;
        }
        
        try {
            if (empty($id) || $id == 'undefined') {
                // Create new
                $data['created_at'] = date('Y-m-d H:i:s');
                $result = $this->safety_switches_model->create_switch($data);
                $action = 'created';
            } else {
                // Update existing
                $result = $this->safety_switches_model->update_switch($id, $data);
                $action = 'updated';
            }
            
            if ($result) {
                echo json_encode(array(
                    'success' => true,
                    'message' => 'Safety switch ' . $action . ' successfully!',
                    'id' => empty($id) ? $this->db->insert_id() : $id
                ));
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Failed to save safety switch to database.'
                ));
            }
        } catch (Exception $e) {
            echo json_encode(array(
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ));
        }
    }
    
    public function save_all_switches() {
    header('Content-Type: application/json');
    
    $switchesData = json_decode($this->input->post('switches'), true);
    
    if (empty($switchesData)) {
        echo json_encode(array(
            'success' => false,
            'message' => 'No switch data received.'
        ));
        return;
    }
    
    $savedCount = 0;
    $totalCount = count($switchesData);
    $errors = [];
    
    foreach ($switchesData as $switchId => $switchData) {
        try {
            $data = array(
                'title' => $switchData['title'],
                'content' => $switchData['content'],
                'features' => $switchData['features'],
                'edited_by' => $this->session->userdata('admin_id'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            if (!empty($switchData['current_image'])) {
                $data['image'] = $switchData['current_image'];
            }
            
            $result = $this->safety_switches_model->update_switch($switchId, $data);
            
            if ($result) {
                $savedCount++;
            } else {
                $errors[] = "Switch ID {$switchId}: Failed to save";
            }
        } catch (Exception $e) {
            $errors[] = "Switch ID {$switchId}: " . $e->getMessage();
        }
    }
    
    if ($savedCount === $totalCount) {
        echo json_encode(array(
            'success' => true,
            'message' => "All {$savedCount} switches saved successfully!"
        ));
    } else if ($savedCount > 0) {
        echo json_encode(array(
            'success' => true,
            'message' => "{$savedCount} of {$totalCount} switches saved. Errors: " . implode(', ', $errors)
        ));
    } else {
        echo json_encode(array(
            'success' => false,
            'message' => "Failed to save any switches. Errors: " . implode(', ', $errors)
        ));
    }
}
    
    /**
     * AJAX: Delete switch
     */
    public function delete_switch($id) {
        // Check if it's the main switch (ID: 1)
        if ($id == 1) {
            echo json_encode(array(
                'success' => false,
                'message' => 'Cannot delete the main safety switch.'
            ));
            return;
        }
        
        $result = $this->safety_switches_model->delete_switch($id);
        
        if ($result) {
            echo json_encode(array(
                'success' => true,
                'message' => 'Safety switch deleted successfully!'
            ));
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'Failed to delete safety switch.'
            ));
        }
    }
    
    /**
     * AJAX: Upload image only
     */
    public function upload_image_only($id = null) {
        if (!empty($_FILES['image']['name'])) {
            $upload_result = $this->switch_upload_image();
            
            if ($upload_result['success']) {
                // Update database if ID is provided
                if ($id) {
                    $this->safety_switches_model->update_switch($id, array(
                        'image' => $upload_result['file_name'],
                        'updated_at' => date('Y-m-d H:i:s')
                    ));
                }
                
                echo json_encode(array(
                    'success' => true,
                    'message' => 'Image uploaded successfully',
                    'file_name' => $upload_result['file_name'],
                    'image_url' => base_url('assets_system/images/' . $upload_result['file_name'])
                ));
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => $upload_result['error']
                ));
            }
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'No image selected'
            ));
        }
    }
    
    /**
     * Handle image upload
     */
    private function switch_upload_image() {
        $config['upload_path'] = FCPATH . 'assets_system/images/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|webp|svg';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;
        
        $this->load->library('upload', $config);
                $this->upload->initialize($config);
        
        if ($this->upload->do_upload('image')) {
            $data = $this->upload->data();
            return array(
                'success' => true,
                'file_name' => $data['file_name']
            );
        } else {
            return array(
                'success' => false,
                'error' => $this->upload->display_errors()
            );
        }
    }
    

    
    public function logout()
    {
        // Destroy the session
        $this->session->sess_destroy();

        // Redirect to login page or home
        // Change 'login' to your actual login route
        redirect('login');
    }
    
    // Image Management
    public function image_management() {
        $filter = $this->input->get('filter') ?? 'all';
        
        $data['statistics'] = $this->image_management_model->get_statistics();
        
        switch($filter) {
            case 'used':
                $all_images = $this->image_management_model->get_all_images();
                $used_images = $this->image_management_model->get_used_images();
                $data['images'] = array_filter($all_images, function($img) use ($used_images) {
                    return in_array($img['filename'], $used_images);
                });
                break;
            case 'unused':
                $data['images'] = $this->image_management_model->get_unused_images();
                break;
            default:
                $data['images'] = $this->image_management_model->get_all_images();
        }
        
        $data['filter'] = $filter;
        $data['used_images'] = $this->image_management_model->get_used_images();
        
        $this->load->view('admin/header');
        $this->load->view('admin/image_management', $data);
    }
    
    public function get_image_usage() {
        $this->output->set_content_type('application/json');
        
        $filename = $this->input->post('filename');
        
        if (empty($filename)) {
            echo json_encode([
                'success' => false,
                'message' => 'Filename is required.',
                'usage' => []
            ]);
            return;
        }
        
        try {
            $usage = $this->image_management_model->get_image_usage($filename);
            
            echo json_encode([
                'success' => true,
                'usage' => $usage
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'usage' => []
            ]);
        }
    }
    
    public function delete_image() {
        $this->output->set_content_type('application/json');
        
        $filename = $this->input->post('filename');
        
        if (empty($filename)) {
            echo json_encode([
                'success' => false,
                'message' => 'Filename is required.'
            ]);
            return;
        }
        
        try {
            // Check if image is used
            $usage = $this->image_management_model->get_image_usage($filename);
            
            if (!empty($usage)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Cannot delete. This image is currently being used in ' . count($usage) . ' location(s).'
                ]);
                return;
            }
            
            if ($this->image_management_model->delete_image($filename)) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Image deleted successfully!'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to delete image. File may not exist.'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function delete_multiple_images() {
        $this->output->set_content_type('application/json');
        
        $filenames = $this->input->post('filenames');
        
        if (empty($filenames)) {
            echo json_encode([
                'success' => false,
                'message' => 'No images selected.'
            ]);
            return;
        }
        
        // Filter out used images
        $unused = [];
        $used_count = 0;
        
        foreach ($filenames as $filename) {
            $usage = $this->image_management_model->get_image_usage($filename);
            if (empty($usage)) {
                $unused[] = $filename;
            } else {
                $used_count++;
            }
        }
        
        if (empty($unused)) {
            echo json_encode([
                'success' => false,
                'message' => 'All selected images are currently in use and cannot be deleted.'
            ]);
            return;
        }
        
        $result = $this->image_management_model->delete_multiple_images($unused);
        
        $message = $result['deleted'] . ' image(s) deleted successfully!';
        if ($used_count > 0) {
            $message .= ' ' . $used_count . ' image(s) skipped (currently in use).';
        }
        if ($result['failed'] > 0) {
            $message .= ' ' . $result['failed'] . ' image(s) failed to delete.';
        }
        
        echo json_encode([
            'success' => true,
            'message' => $message,
            'deleted' => $result['deleted'],
            'skipped' => $used_count,
            'failed' => $result['failed']
        ]);
    }
    
    // ========================================
    // PRODUCT ITEMS MANAGEMENT
    // ========================================
    
    /**
     * View products for a specific category
     */
    public function product_items($category_id)
    {
        // Get category info
        $category = $this->products_model->get_product($category_id);
        
        if (!$category) {
            show_404();
        }
        
        // Get product types for this category
        $data['types'] = $this->product_items_model->get_types_with_counts($category_id);
        
        // Get all items for this category
        $data['items'] = $this->product_items_model->get_all_items($category_id);
        
        // Category info
        $data['category'] = $category;
        $data['category_id'] = $category_id;
        
        $this->load->view('admin/header');
        $this->load->view('admin/product_items', $data);
    }

    public function edit_product($id)
    {
        $this->load->model('web/Product_page_model');
        $product = $this->Product_page_model->get_product_by_id($id);
        
        if (!$product) {
            show_404();
        }
        
        // Get product types for dropdown
        $types = $this->Product_page_model->get_product_types_by_category($product->product_category);
        
        // Parse JSON data for frontend
        if (!empty($product->models_data)) {
            $product->models_data = json_decode($product->models_data, true);
        } else {
            $product->models_data = [];
        }
        
        if (!empty($product->applications_data)) {
            $product->applications_data = json_decode($product->applications_data, true);
        } else {
            $product->applications_data = [];
        }
        
        if (!empty($product->downloads_data)) {
            $product->downloads_data = json_decode($product->downloads_data, true);
        } else {
            $product->downloads_data = [];
        }

        if (!empty($product->dynamic_tables ?? null)) {
            $decoded_dt = json_decode($product->dynamic_tables, true);
            $product->dynamic_tables = is_array($decoded_dt) ? $decoded_dt : [];
        } else {
            $product->dynamic_tables = [];
        }

        $data = [
            'product' => $product,
            'types' => $types
        ];

        $this->load->view('admin/products_edit', $data);
    }

    public function add_product_view($category_id)
    {
        $category = $this->products_model->get_product($category_id);
        if (!$category) show_404();
        
        $data['types'] = $this->product_items_model->get_all_types_by_category($category_id);
        $data['category'] = $category;
        $data['category_id'] = $category_id;
        
        $this->load->view('admin/products_add', $data);
    }
    
    /**
     * Get product item data (AJAX)
     */
    public function get_product_item($id)
    {
        $this->output->set_content_type('application/json');
        
        $item = $this->product_items_model->get_item($id);
        
        if ($item) {
            echo json_encode([
                'success' => true,
                'data' => $item
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Product item not found.'
            ]);
        }
    }
    
    public function delete_product_item($id)
    {
        $this->output->set_content_type('application/json');
        
        // Get item to delete image
        $item = $this->product_items_model->get_item($id);
        
        if ($item && !empty($item->product_image)) {
            $image_path = FCPATH . 'assets_system/images/' . $item->product_image;
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
        
        $result = $this->product_items_model->delete_item($id);
        
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Product item deleted successfully!'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to delete product item.'
            ]);
        }
    }
    
    /**
     * Add product type (AJAX)
     */
    public function add_product_type()
    {
        $this->output->set_content_type('application/json');
        
        $this->form_validation->set_rules('product_category', 'Category', 'required');
        $this->form_validation->set_rules('type_name', 'Type Name', 'required|trim');
        
        if ($this->form_validation->run() === FALSE) {
            echo json_encode([
                'success' => false,
                'message' => validation_errors()
            ]);
            return;
        }
        
        $data = [
            'product_category' => $this->input->post('product_category'),
            'type_name' => $this->input->post('type_name')
        ];
        
        $new_id = $this->product_items_model->add_type($data);
        
        if ($new_id) {
            echo json_encode([
                'success' => true,
                'message' => 'Product type added successfully!',
                'id' => $new_id
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to add product type.'
            ]);
        }
    }
    
    /**
     * Delete product type (AJAX)
     */
    public function delete_product_type($id)
    {
        $this->output->set_content_type('application/json');
        
        $result = $this->product_items_model->delete_type($id);
        
        if ($result === false) {
            echo json_encode([
                'success' => false,
                'message' => 'Cannot delete type. Products are using this type.'
            ]);
        } else if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Product type deleted successfully!'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to delete product type.'
            ]);
        }
    }
    
    /**
     * Upload product item image
     */
    private function upload_product_item_image()
    {
        $config['upload_path'] = FCPATH . 'assets_system/images/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp|svg';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;
        
        $this->load->library('upload', $config);
                $this->upload->initialize($config);
        
        if (!$this->upload->do_upload('product_image')) {
            return [
                'success' => false,
                'error' => $this->upload->display_errors('', '')
            ];
        } else {
            $upload_data = $this->upload->data();
            return [
                'success' => true,
                'file_name' => $upload_data['file_name']
            ];
        }
    }
    
    // ========================================
    // CUSTOM PAGES MANAGEMENT
    // ========================================
    
    /**
     * Privacy Policy page
     */
      public function privacy_policy()
    {
        $page = $this->custom_pages_model->get_page_by_slug('privacy_policy');
        
        $data['page'] = $page;
        $data['page_title'] = 'Privacy Policy';
        $data['page_slug'] = 'privacy_policy';
        
        if (isset($page->data)) {
            $data['page_content'] = $this->clean_html_but_keep_formatting($page->data);
        } else {
            $data['page_content'] = '';
        }
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/custom_page_editor', $data);
    }
    /**
     * Terms of Service page
     */
    public function terms_of_service()
    {
        $page = $this->custom_pages_model->get_page_by_slug('terms_of_service');
        
        $data['page'] = $page;
        $data['page_title'] = 'Terms of Service';
        $data['page_slug'] = 'terms_of_service';
        
        if (isset($page->data)) {
            $data['page_content'] = $this->clean_html_but_keep_formatting($page->data);
        } else {
            $data['page_content'] = '';
        }
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/custom_page_editor', $data);
    }
    
    
    /**
     * Cookie Policy page
     */
     public function cookie_policy()
    {
        $page = $this->custom_pages_model->get_page_by_slug('cookie_settings');
        
        $data['page'] = $page;
        $data['page_title'] = 'Cookie Settings';
        $data['page_slug'] = 'cookie_settings';
        
        if (isset($page->data)) {
            $data['page_content'] = $this->clean_html_but_keep_formatting($page->data);
        } else {
            $data['page_content'] = '';
        }
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/custom_page_editor', $data);
    }
    
    private function clean_html_but_keep_formatting($html)
    {
        // Step 1: Convert HTML line breaks to newlines
        $text = str_replace(array('<br>', '<br/>', '<br />'), "\n", $html);
        
        // Step 2: Convert paragraphs to double newlines
        $text = preg_replace('/<\/p>\s*<p>/', "\n\n", $text);
        $text = preg_replace('/<p[^>]*>/', '', $text);
        $text = str_replace('</p>', "\n\n", $text);
        
        // Step 3: Convert list items
        $text = preg_replace('/<li[^>]*>/', "• ", $text);
        $text = str_replace('</li>', "\n", $text);
        
        // Step 4: Remove other HTML tags but preserve their spacing
        $text = preg_replace('/<[^>]+>/', ' ', $text);
        
        // Step 5: Decode HTML entities
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        // Step 6: Clean up multiple spaces
        $text = preg_replace('/[ \t]+/', ' ', $text);
        
        // Step 7: Clean up multiple newlines (keep max 2)
        $text = preg_replace("/\n\s*\n\s*\n/", "\n\n", $text);
        
        // Step 8: Trim
        $text = trim($text);
        
        return $text;
    }
    
    /**
     * Cookie Settings page
     */
    public function cookie_settings()
    {
        $page = $this->custom_pages_model->get_page_by_slug('cookie_settings');
        
        // If page doesn't exist, create it
        if (!$page) {
            $this->custom_pages_model->create_page([
                'page' => 'cookie_settings',
                'data' => NULL
            ]);
            $page = $this->custom_pages_model->get_page_by_slug('cookie_settings');
        }
        
        $data['page_data'] = $page;
        
        $this->load->view('admin/header');
        $this->load->view('admin/cookie_settings', $data);
    }
    
    /**
     * Save custom page content (AJAX)
     */
    public function save_custom_page()
    {
        // Check if POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            show_404();
        }
        
        // Get POST data
        $page_slug = $this->input->post('page_slug');
        $content = $this->input->post('content');
        
        // Validate
        if (empty($page_slug)) {
            $this->session->set_flashdata('error', 'Page slug is required');
            redirect($_SERVER['HTTP_REFERER']);
        }
        
        if (empty($content)) {
            $this->session->set_flashdata('error', 'Content cannot be empty');
            redirect($_SERVER['HTTP_REFERER']);
        }
        
        // Save to database
        $result = $this->custom_pages_model->save_page($page_slug, $content);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Page saved successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to save page. Please try again.');
        }
        
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    /**
     * Upload image for custom pages (AJAX)
     */
    public function upload_custom_page_image()
    {
        $this->output->set_content_type('application/json');
        
        if (empty($_FILES['file']['name'])) {
            echo json_encode([
                'success' => false,
                'message' => 'No file selected.'
            ]);
            return;
        }
        
        $config['upload_path'] = FCPATH . 'assets_system/images/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp|svg';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;
        
        $this->load->library('upload', $config);
                $this->upload->initialize($config);
        
        if ($this->upload->do_upload('file')) {
            $upload_data = $this->upload->data();
            echo json_encode([
                'success' => true,
                'url' => base_url('assets_system/images/' . $upload_data['file_name'])
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => $this->upload->display_errors('', '')
            ]);
        }
    }
    
    // ========================================
    // DYNAMIC PRODUCT PAGES MANAGEMENT  
    // ========================================
    
    public function product_pages()
    {
        $this->load->model('admin/Product_page_model');
        $data['title'] = 'Manage Product Pages';
        $data['products'] = $this->Product_page_model->get_all_products();
        $this->load->view('admin/header', $data);
        $this->load->view('admin/product_pages_list', $data);
    }
    
    public function add_product_page()
    {
        $this->load->model('admin/Product_page_model');
        $data['title'] = 'Add Product Page';
        
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('product_name', 'Product Name', 'required');
            $this->form_validation->set_rules('title', 'Page Title', 'required');
            $this->form_validation->set_rules('slug', 'Slug', 'required|callback_product_slug_check');
            
            if ($this->form_validation->run()) {
                $product_data = array(
                    'product_name' => $this->input->post('product_name'),
                    'slug' => $this->input->post('slug'),
                    'title' => $this->input->post('title'),
                    'subtitle' => $this->input->post('subtitle'),
                    'meta_description' => $this->input->post('meta_description'),
                    'meta_keywords' => $this->input->post('meta_keywords'),
                    'description' => $this->input->post('description'),
                    'features' => $this->input->post('features'),
                    'specifications' => $this->input->post('specifications'),
                    'applications' => $this->input->post('applications'),
                    'models' => $this->input->post('models'),
                    'category' => $this->input->post('category'),
                    'tags' => $this->input->post('tags'),
                    'video_url' => $this->input->post('video_url'),
                    'youtube_embed' => $this->input->post('youtube_embed'),
                    'catalog_links' => $this->input->post('catalog_links'),
                    'anchor_sections' => $this->input->post('anchor_sections'),
                    'is_active' => $this->input->post('is_active') ? 1 : 0,
                    'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                    'display_order' => $this->input->post('display_order')
                );
                
                if (!empty($_FILES['banner_image']['name'])) {
                    $banner = $this->product_upload_image('banner_image', 'banners');
                    if ($banner) $product_data['banner_image'] = $banner;
                }
                
                if (!empty($_FILES['thumbnail_image']['name'])) {
                    $thumb = $this->product_upload_image('thumbnail_image', 'thumbnails');
                    if ($thumb) $product_data['thumbnail_image'] = $thumb;
                }
                
                if (!empty($_FILES['brochure_pdf']['name'])) {
                    $brochure = $this->product_upload_file('brochure_pdf', 'brochures');
                    if ($brochure) $product_data['brochure_pdf'] = $brochure;
                }
                
                if (!empty($_FILES['manual_pdf']['name'])) {
                    $manual = $this->product_upload_file('manual_pdf', 'manuals');
                    if ($manual) $product_data['manual_pdf'] = $manual;
                }
                
                if (!empty($_FILES['gallery_images']['name'][0])) {
                    $gallery = $this->product_upload_multiple_images('gallery_images', 'gallery');
                    if (!empty($gallery)) $product_data['gallery_images'] = json_encode($gallery);
                }
                
                if ($this->Product_page_model->insert_product($product_data)) {
                    $this->session->set_flashdata('success', 'Product page added successfully');
                    redirect('cms/product_pages');
                } else {
                    $this->session->set_flashdata('error', 'Failed to add product page');
                }
            }
        }
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/product_page_form', $data);
    }

    public function add_product_item($category_id) 
    {
        $this->load->model('admin/Product_page_model');
        
        header('Content-Type: application/json');
        ob_start();
        
        try {
            // Validation
            $this->form_validation->set_rules('product_name', 'Product Name', 'required|trim');
            $this->form_validation->set_rules('slug', 'Slug', 'required|trim|is_unique[tbl_product_items.slug]');
            $this->form_validation->set_rules('short_description', 'Short Description', 'required|trim');
            $this->form_validation->set_rules('product_type', 'Product Type', 'required|numeric');
            
            if (!$this->form_validation->run()) {
                ob_end_clean();
                echo json_encode([
                    'success' => false, 
                    'message' => 'Validation failed', 
                    'errors' => $this->form_validation->error_array()
                ]);
                return;
            }
            
            // Check if product image was uploaded
            if (!empty($_FILES['product_image_file']['name'])) {
                // Upload the product image
                $upload_config = array(
                    'upload_path' => './assets_system/images/',
                    'allowed_types' => 'jpg|jpeg|png|gif|webp',
                    'max_size' => 2048, // 2MB
                    'file_name' => $_POST['product_image'] // Use the generated filename
                );
                
                $this->load->library('upload', $upload_config);
                
                if ($this->upload->do_upload('product_image_file')) {
                    $image_data = $this->upload->data();
                    $product_image = $image_data['file_name'];
                } else {
                    // Handle upload error
                    echo json_encode(['success' => false, 'message' => 'Image upload failed: ' . $this->upload->display_errors()]);
                    return;
                }
            } else {
                $product_image = ''; // No image uploaded
            }
            
            // Prepare data
            $data = [
                'product_category' => (int)$category_id,
                'product_image' => $product_image,
                'product_type' => (int)$this->input->post('product_type'),
                'product_name' => trim($this->input->post('product_name')),
                'series_name' => trim($this->input->post('series_name')),
                'sub_title' => trim($this->input->post('sub_title')),
                'slug' => trim($this->input->post('slug')),
                'model_number' => trim($this->input->post('model_number')),
                'description' => trim($this->input->post('description')),
                'short_description' => trim($this->input->post('short_description')),
                'features' => trim($this->input->post('features')),
                'specifications' => trim($this->input->post('specifications')),
                'tags' => trim($this->input->post('tags')),
                'youtube_embed' => trim($this->input->post('youtube_embed')),
                'video_url' => trim($this->input->post('video_url')),
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'is_new' => $this->input->post('is_new') ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            
            // Handle applications JSON
            $applications_json = $this->input->post('applications_data');
            if ($applications_json) {
                $decoded = json_decode($applications_json, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $processed = $this->process_application_image_uploads($decoded, 0);
                    $data['applications_data'] = json_encode($processed);
                } else {
                    $data['applications_data'] = '[]';
                }
            } else {
                $data['applications_data'] = '[]';
            }
            
            // Handle downloads JSON
            $data['downloads_data'] = $this->input->post('downloads_data') ?: '[]';

            // Handle dynamic tables JSON
            $data['dynamic_tables'] = $this->input->post('dynamic_tables_data') ?: '[]';

            // Insert product
            $new_id = $this->Product_page_model->insert_product($data);
            
            if ($new_id) {
                ob_end_clean();
                echo json_encode([
                    'success' => true,
                    'message' => 'Product created successfully',
                    'product_id' => $new_id,
                    'redirect_url' => base_url('cms/product_items/' . $category_id)
                ]);
            } else {
                ob_end_clean();
                echo json_encode(['success' => false, 'message' => 'Failed to create product']);
            }
            
        } catch (Exception $e) {
            ob_end_clean();
            log_message('error', 'Product creation failed: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    public function edit_product_page($id)
    {
        $this->load->model('admin/Product_page_model');
        $data['title'] = 'Edit Product Page';
        $data['product'] = $this->Product_page_model->get_product_by_id($id);
        
        if (!$data['product']) show_404();
        
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('product_name', 'Product Name', 'required');
            $this->form_validation->set_rules('title', 'Page Title', 'required');
            $this->form_validation->set_rules('slug', 'Slug', 'required');
            
            if ($this->form_validation->run()) {
                $product_data = array(
                    'product_name' => $this->input->post('product_name'),
                    'slug' => $this->input->post('slug'),
                    'title' => $this->input->post('title'),
                    'subtitle' => $this->input->post('subtitle'),
                    'meta_description' => $this->input->post('meta_description'),
                    'meta_keywords' => $this->input->post('meta_keywords'),
                    'description' => $this->input->post('description'),
                    'features' => $this->input->post('features'),
                    'specifications' => $this->input->post('specifications'),
                    'applications' => $this->input->post('applications'),
                    'models' => $this->input->post('models'),
                    'category' => $this->input->post('category'),
                    'tags' => $this->input->post('tags'),
                    'video_url' => $this->input->post('video_url'),
                    'youtube_embed' => $this->input->post('youtube_embed'),
                    'catalog_links' => $this->input->post('catalog_links'),
                    'anchor_sections' => $this->input->post('anchor_sections'),
                    'is_active' => $this->input->post('is_active') ? 1 : 0,
                    'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                    'display_order' => $this->input->post('display_order')
                );
                
                if (!empty($_FILES['banner_image']['name'])) {
                    $banner = $this->product_upload_image('banner_image', 'banners');
                    if ($banner) {
                        if ($data['product']->banner_image) @unlink(FCPATH . 'assets_system/images/banners/' . $data['product']->banner_image);
                        $product_data['banner_image'] = $banner;
                    }
                }
                
                if ($this->Product_page_model->update_product($id, $product_data)) {
                    $this->session->set_flashdata('success', 'Product page updated successfully');
                    redirect('cms/product_pages');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update product page');
                }
            }
        }
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/product_page_form', $data);
    }
    
    public function delete_product_page($id)
    {
        $this->load->model('admin/Product_page_model');
        $product = $this->Product_page_model->get_product_by_id($id);
        
        if ($product) {
            if ($product->banner_image) @unlink(FCPATH . 'assets_system/images/banners/' . $product->banner_image);
            if ($product->brochure_pdf) @unlink(FCPATH . 'assets_system/images/brochures/' . $product->brochure_pdf);
            if ($product->gallery_images) {
                $gallery = json_decode($product->gallery_images);
                foreach ($gallery as $img) @unlink(FCPATH . 'assets_system/images/gallery/' . $img);
            }
            
            if ($this->Product_page_model->delete_product($id)) {
                $this->session->set_flashdata('success', 'Product page deleted successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to delete product page');
            }
        }
        
        redirect('cms/product_pages');
    }
    
    private function product_upload_image($field_name, $folder)
    {
        $config['upload_path'] = FCPATH . 'assets_system/images/' . $folder . '/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 5120;
        $config['encrypt_name'] = TRUE;
        
        if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, true);
        $this->upload->initialize($config);
        
        if ($this->upload->do_upload($field_name)) return $this->upload->data('file_name');
        return false;
    }
    
    private function product_upload_file($field_name, $folder)
    {
        $config['upload_path'] = FCPATH . 'assets_system/images/' . $folder . '/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 10240;
        $config['encrypt_name'] = TRUE;
        
        if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, true);
        $this->upload->initialize($config);
        
        if ($this->upload->do_upload($field_name)) return $this->upload->data('file_name');
        return false;
    }
    
    private function product_upload_multiple_images($field_name, $folder)
    {
        $config['upload_path'] = FCPATH . 'assets_system/images/' . $folder . '/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 5120;
        $config['encrypt_name'] = TRUE;
        
        if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, true);
        
        $uploaded_files = array();
        $files = $_FILES[$field_name];
        
        for ($i = 0; $i < count($files['name']); $i++) {
            $_FILES['upload_file']['name'] = $files['name'][$i];
            $_FILES['upload_file']['type'] = $files['type'][$i];
            $_FILES['upload_file']['tmp_name'] = $files['tmp_name'][$i];
            $_FILES['upload_file']['error'] = $files['error'][$i];
            $_FILES['upload_file']['size'] = $files['size'][$i];
            
            $this->upload->initialize($config);
            if ($this->upload->do_upload('upload_file')) $uploaded_files[] = $this->upload->data('file_name');
        }
        
        return $uploaded_files;
    }
    
    public function product_slug_check($slug)
    {
        $this->load->model('admin/Product_page_model');
        $existing = $this->Product_page_model->check_slug_exists($slug);
        if ($existing) {
            $this->form_validation->set_message('product_slug_check', 'This slug already exists');
            return FALSE;
        }
        return TRUE;
    }
    
    /**
     * Display dynamic product detail page
     * @param string $slug - Product URL slug
     */
    public function product_detail($slug)
    {
        // Load Product_page_model
        $this->load->model('admin/Product_page_model');
        
        // Get product by slug
        $product = $this->Product_page_model->get_product_by_slug($slug);
        
        // Check if product exists and is active
        if (!$product) {
            // Product not found - show 404
            show_404();
            return;
        }
        
        // Decode JSON data fields if they exist
        if (!empty($product->models_data) && is_string($product->models_data)) {
            $product->models_data = json_decode($product->models_data, true);
        }

        if (!empty($product->specifications_data) && is_string($product->specifications_data)) {
            $product->specifications_data = json_decode($product->specifications_data, true);
        }

        if (!empty($product->downloads_data) && is_string($product->downloads_data)) {
            $product->downloads_data = json_decode($product->downloads_data, true);
        }

        if (!empty($product->applications_data) && is_string($product->applications_data)) {
            $product->applications_data = json_decode($product->applications_data, true);
        }
        
        // Convert tags string to array
        if (!empty($product->tags)) {
            $product->tags_array = explode(',', $product->tags);
        } else {
            $product->tags_array = [];
        }
        
        // Convert features string to array (assuming newline-separated)
        if (!empty($product->features)) {
            $product->features_array = explode("\n", $product->features);
        } else {
            $product->features_array = [];
        }
        
        // Get related products (optional)
        $data['related_products'] = $this->Product_page_model->get_related_products($product->id, 3);
        
        // Pass product data to view
        $data['product'] = $product;
        
        // Set page title
        $data['page_title'] = $product->product_name . ' - Line Seiki Asia Pacific';
        
        // Load the dynamic product detail view
        $this->load->view('web/product_detail', $data);
    }

public function update_product_item($id) {
    $this->load->model('admin/Product_page_model');
    
    // Set JSON header
    header('Content-Type: application/json');
    
    try {
        // Basic validation
        $this->form_validation->set_rules('product_name', 'Product Name', 'required|trim');
        $this->form_validation->set_rules('slug', 'Slug', 'required|trim');
        $this->form_validation->set_rules('short_description', 'Short Description', 'required|trim');
        $this->form_validation->set_rules('product_type', 'Product Type', 'required|numeric');
        
        if (!$this->form_validation->run()) {
            $errors = $this->form_validation->error_array();
            echo json_encode([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $errors
            ]);
            return;
        }
        
        // Get existing product
        $existing_product = $this->Product_page_model->get_product_by_id($id);
        if (!$existing_product) {
            echo json_encode([
                'success' => false,
                'message' => 'Product not found'
            ]);
            return;
        }
        
        // Handle product image upload
        $product_image = $existing_product->product_image; // Keep existing by default
        
        if (!empty($_FILES['product_image_file']['name'])) {
            // Delete old image if exists
            if (!empty($existing_product->product_image) && file_exists('./assets_system/images/' . $existing_product->product_image)) {
                unlink('./assets_system/images/' . $existing_product->product_image);
            }
            
            // Upload configuration
            $config = [
                'upload_path' => './assets_system/images/',
                'allowed_types' => 'jpg|jpeg|png|gif|webp',
                'max_size' => 2048, // 2MB
                'encrypt_name' => false
            ];
            
            $this->load->library('upload', $config);
                $this->upload->initialize($config);
            
            // Use filename from post or generate one
            $new_filename = $this->input->post('product_image') ?: 'product_' . time() . '_' . rand(1000, 9999);
            
            // Clean filename
            $new_filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $new_filename);
            $new_filename = pathinfo($new_filename, PATHINFO_FILENAME);
            
            // Add extension
            $file_ext = pathinfo($_FILES['product_image_file']['name'], PATHINFO_EXTENSION);
            $config['file_name'] = $new_filename . '.' . $file_ext;
            
            // Re-initialize upload with new config
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('product_image_file')) {
                $upload_data = $this->upload->data();
                $product_image = $upload_data['file_name'];
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Product image upload failed: ' . $this->upload->display_errors()
                ]);
                return;
            }
        } elseif ($this->input->post('product_image') === '') {
            // If product_image is empty string, delete existing image
            if (!empty($existing_product->product_image) && file_exists('./assets_system/images/' . $existing_product->product_image)) {
                unlink('./assets_system/images/' . $existing_product->product_image);
            }
            $product_image = '';
        }
        
        // Prepare update data
        $data = [
            'product_type' => (int)$this->input->post('product_type'),
            'product_image' => $product_image,
            'product_name' => trim($this->input->post('product_name')),
            'series_name' => trim($this->input->post('series_name')),
            'sub_title' => trim($this->input->post('sub_title')),
            'slug' => trim($this->input->post('slug')),
            'model_number' => trim($this->input->post('model_number')),
            'description' => trim($this->input->post('description')),
            'short_description' => trim($this->input->post('short_description')),
            'features' => trim($this->input->post('features')),
            'specifications' => trim($this->input->post('specifications')),
            'tags' => trim($this->input->post('tags')),
            'youtube_embed' => trim($this->input->post('youtube_embed')),
            'video_url' => trim($this->input->post('video_url')),
            'is_active' => $this->input->post('is_active') ? 1 : 0,
            'is_new' => $this->input->post('is_new') ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        
        // Handle applications data
        $applications_json = $this->input->post('applications_data');
        if ($applications_json) {
            $applications_data = json_decode($applications_json, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($applications_data)) {
                // Process application images if any
                $processed_applications = $this->process_application_image_uploads($applications_data, $id);
                $data['applications_data'] = json_encode($processed_applications);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid applications data format'
                ]);
                return;
            }
        } else {
            $data['applications_data'] = '[]';
        }
        
        // Handle downloads data
        $downloads_json = $this->input->post('downloads_data');
        $data['downloads_data'] = $downloads_json ?: '[]';

        // Handle dynamic tables data
        $data['dynamic_tables'] = $this->input->post('dynamic_tables_data') ?: '[]';

        // Update product
        $result = $this->Product_page_model->update_product($id, $data);
        
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Product updated successfully',
                'product_id' => $id,
                'slug' => $data['slug'],
                'redirect_url' => base_url('cms/product_items/' . $existing_product->product_category)
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to update product in database'
            ]);
        }
        
    } catch (Exception $e) {
        log_message('error', 'Product update failed: ' . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => 'An error occurred: ' . $e->getMessage()
        ]);
    }
}
    
    /**
     * Upload a downloadable file (AJAX endpoint)
     */
    public function upload_download_file()
    {
        header('Content-Type: application/json');

        if (!isset($_FILES['download_file']) || $_FILES['download_file']['error'] !== 0) {
            echo json_encode(array('success' => false, 'message' => 'No file uploaded.'));
            return;
        }

        $upload_path = FCPATH . 'assets_system/documents/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $config = array(
            'upload_path'   => $upload_path,
            'allowed_types' => 'pdf|doc|docx|xls|xlsx|zip|rar|jpg|jpeg|png|gif|webp',
            'max_size'      => 10240, // 10MB
            'encrypt_name'  => TRUE
        );

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ($this->upload->do_upload('download_file')) {
            $data = $this->upload->data();
            $original_name = $_FILES['download_file']['name'];

            // Format file size
            $size = $data['file_size']; // in KB
            if ($size >= 1024) {
                $file_size = round($size / 1024, 1) . ' MB';
            } else {
                $file_size = round($size, 0) . ' KB';
            }

            echo json_encode(array(
                'success'       => true,
                'file_url'      => 'assets_system/documents/' . $data['file_name'],
                'file_name'     => $data['file_name'],
                'original_name' => $original_name,
                'file_size'     => $file_size,
                'file_type'     => $data['file_ext']
            ));
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => strip_tags($this->upload->display_errors())
            ));
        }
    }

    /**
     * Upload a specification value image via AJAX
     */
    public function upload_spec_image()
    {
        header('Content-Type: application/json');

        if (!isset($_FILES['spec_image']) || $_FILES['spec_image']['error'] !== 0) {
            echo json_encode(array('success' => false, 'message' => 'No file uploaded.'));
            return;
        }

        $upload_path = FCPATH . 'assets_system/images/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $config = array(
            'upload_path'   => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|gif|webp',
            'max_size'      => 2048,
            'encrypt_name'  => TRUE
        );

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('spec_image')) {
            $data = $this->upload->data();
            echo json_encode(array(
                'success'   => true,
                'file_name' => $data['file_name']
            ));
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => strip_tags($this->upload->display_errors())
            ));
        }
    }

    /**
     * Process application image uploads from the form
     */
    private function process_application_image_uploads($applications, $product_id) {
        if (empty($applications) || !is_array($applications)) {
            return [];
        }
        
        $upload_path = './assets_system/images/';
        
        // Ensure directory exists
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }
        
        $processed_applications = [];
        
        // Loop through each application
        foreach ($applications as $index => $app) {
            $processed_app = $app;
            
            // Check if a file was uploaded for this application
            $file_key = 'app_file_' . $index;
            
            if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] === UPLOAD_ERR_OK) {
                $temp_file = $_FILES[$file_key]['tmp_name'];
                $original_name = $_FILES[$file_key]['name'];
                $file_size = $_FILES[$file_key]['size'];
                $file_type = $_FILES[$file_key]['type'];
                
                // Validate file type
                $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($file_type, $allowed_types)) {
                    log_message('error', "Invalid file type for application {$index}: {$file_type}");
                    continue;
                }
                
                // Validate file size (max 2MB)
                if ($file_size > 2 * 1024 * 1024) {
                    log_message('error', "File too large for application {$index}: {$file_size} bytes");
                    continue;
                }
                
                // Use the filename from the app data or generate a new one
                $filename = !empty($app['image']) ? basename($app['image']) : ('app_' . time() . '_' . uniqid() . '_' . $original_name);
                
                // Move file to destination
                $destination = $upload_path . $filename;
                if (move_uploaded_file($temp_file, $destination)) {
                    $processed_app['image'] = $filename;
                    
                    // Delete old image if it's different
                    if (!empty($app['image']) && $app['image'] !== $filename) {
                        $old_file = $upload_path . basename($app['image']);
                        if (file_exists($old_file)) {
                            @unlink($old_file);
                        }
                    }
                    
                    log_message('debug', "Uploaded application image: {$filename}");
                } else {
                    log_message('error', "Failed to move uploaded file for application {$index}");
                }
            } else if (!empty($app['image'])) {
                // Keep existing image
                $processed_app['image'] = basename($app['image']);
            } else {
                // No image
                $processed_app['image'] = '';
            }
            
            $processed_applications[] = $processed_app;
        }
        
        return $processed_applications;
    }
    
    /**
     * Handle main product image upload only
     */
    private function handle_main_product_image(&$data, $existing_product) {
        $errors = [];
        $upload_path = './assets_system/images/';
        
        // Ensure directory exists
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }
        
        $this->load->library('upload');
        
        // Config for images
        $image_config = [
            'upload_path' => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|gif|webp',
            'max_size' => 2048, // 2MB
            'encrypt_name' => true,
            'overwrite' => false
        ];
        
        // Upload product image if exists
        if (!empty($_FILES['product_image']['name'])) {
            $this->upload->initialize($image_config);
            
            if ($this->upload->do_upload('product_image')) {
                $upload_data = $this->upload->data();
                $data['product_image'] = $upload_data['file_name'];
                
                // Delete old image if exists
                if (!empty($existing_product->product_image)) {
                    $old_file = $upload_path . $existing_product->product_image;
                    if (file_exists($old_file)) {
                        @unlink($old_file);
                    }
                }
            } else {
                $errors[] = 'Product image: ' . $this->upload->display_errors();
            }
        } else {
            // Keep existing image
            $data['product_image'] = $existing_product->product_image;
        }
        
        return $errors;
    }

/**
 * Handle application images upload
 */
private function handle_application_images(&$data, $existing_product, $upload_path)
{
    if (empty($data['applications_data'])) {
        return;
    }
    
    $applications = json_decode($data['applications_data'], true);
    if (empty($applications) || !is_array($applications)) {
        return;
    }
    
    $updated_applications = [];
    
    foreach ($applications as $index => $app) {
        $updated_app = $app;
        
        // Check if a new image file was uploaded for this application
        $file_key = 'application_images[' . $index . ']';
        $filename_key = 'application_image_filenames[' . $index . ']';
        
        // Check for uploaded file
        if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] === UPLOAD_ERR_OK) {
            $temp_file = $_FILES[$file_key]['tmp_name'];
            $original_name = $_FILES[$file_key]['name'];
            
            // Get or generate filename
            $filename = $this->input->post($filename_key);
            if (empty($filename)) {
                $ext = pathinfo($original_name, PATHINFO_EXTENSION);
                $filename = 'app_' . time() . '_' . $index . '_' . uniqid() . '.' . $ext;
            }
            
            // Move uploaded file
            $destination = $upload_path . $filename;
            if (move_uploaded_file($temp_file, $destination)) {
                $updated_app['image'] = 'products/' . basename(dirname($upload_path)) . '/' . $filename;
                
                // Delete old image if exists
                if (!empty($app['image']) && $app['image'] !== $updated_app['image']) {
                    $old_file = './assets_system/images/' . $app['image'];
                    if (file_exists($old_file)) {
                        @unlink($old_file);
                    }
                }
            }
        } else if (!empty($app['image'])) {
            // Keep existing image
            $updated_app['image'] = $app['image'];
        } else {
            // No image
            $updated_app['image'] = '';
        }
        
        $updated_applications[] = $updated_app;
    }
    
    // Update applications data with new image paths
    $data['applications_data'] = json_encode($updated_applications);
}

/**
 * Validate JSON string
 */
private function isValidJSON($string) {
    if (empty($string) || !is_string($string)) {
        return false;
    }
    
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
}

/**
 * Check if slug is unique (excluding current product)
 */
public function check_slug($slug, $id) {
    $this->db->where('slug', $slug);
    $this->db->where('id !=', $id);
    $query = $this->db->get('tbl_product_items');
    
    if ($query->num_rows() > 0) {
        $this->form_validation->set_message('check_slug', 'The {field} is already in use.');
        return FALSE;
    }
    
    return TRUE;
}

/**
 * Update product in database with JSON encoding
 */

/**
 * Helper function to encode JSON fields
 */
private function encode_json_fields($data) {
    $json_fields = ['applications_data', 'downloads_data', 'models_data', 'gallery_images'];
    foreach ($json_fields as $field) {
        if (isset($data[$field]) && !is_string($data[$field])) {
            $data[$field] = json_encode($data[$field]);
        }
    }
    return $data;
}

// ===================================
// QUOTE REQUESTS MANAGEMENT
// ===================================

/**
 * Display quote requests page
 */
public function quote_requests() {
    $status = $this->input->get('status') ?: 'all';
    $search = $this->input->get('search') ?: '';
    $page = $this->input->get('page') ?: 1;
    $per_page = 20;
    $offset = ($page - 1) * $per_page;
    
    $data['requests'] = $this->Quote_requests_model->get_all_requests($per_page, $offset, $status, $search);
    $data['total_requests'] = $this->Quote_requests_model->count_all_requests($status, $search);
    $data['statistics'] = $this->Quote_requests_model->get_statistics();
    $data['current_status'] = $status;
    $data['search_term'] = $search;
    $data['current_page'] = $page;
    $data['total_pages'] = ceil($data['total_requests'] / $per_page);
    
    $this->load->view('admin/header');
    $this->load->view('admin/quote_requests', $data);
}

/**
 * Update quote request status
 */
public function update_quote_status() {
    header('Content-Type: application/json');
    
    $id = $this->input->post('id');
    $status = $this->input->post('status');
    $notes = $this->input->post('notes');
    
    if (empty($id) || empty($status)) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        return;
    }
    
    if ($this->Quote_requests_model->update_status($id, $status, $notes)) {
        echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update status']);
    }
}

/**
 * Update quote request notes
 */
public function update_quote_notes() {
    header('Content-Type: application/json');
    
    $id = $this->input->post('id');
    $notes = $this->input->post('notes');
    
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'Missing request ID']);
        return;
    }
    
    if ($this->Quote_requests_model->update_notes($id, $notes)) {
        echo json_encode(['success' => true, 'message' => 'Notes updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update notes']);
    }
}

/**
 * Delete quote request
 */
public function delete_quote_request() {
    header('Content-Type: application/json');
    
    $id = $this->input->post('id');
    
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'Missing request ID']);
        return;
    }
    
    if ($this->Quote_requests_model->delete_request($id)) {
        echo json_encode(['success' => true, 'message' => 'Request deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete request']);
    }
}

/**
 * Download file attachment
 */
public function download_quote_file($id) {
    // Validate ID
    if (empty($id) || !is_numeric($id)) {
        show_404();
        return;
    }
    
    // Get request from database
    $request = $this->Quote_requests_model->get_request($id);
    
    if (!$request) {
        log_message('error', 'Quote request not found: ID ' . $id);
        show_404();
        return;
    }
    
    // Check if file path exists in database
    if (empty($request->file_path)) {
        log_message('error', 'No file path for quote request ID: ' . $id);
        $this->session->set_flashdata('error', 'No file attached to this request');
        redirect('cms/quote_requests');
        return;
    }
    
    // Construct full file path
    // Remove leading slash if exists to avoid double slashes
    $file_relative_path = ltrim($request->file_path, '/');
    $file_path = FCPATH . $file_relative_path;
    
    // Check if file exists on filesystem
    if (!file_exists($file_path)) {
        log_message('error', 'File not found on filesystem: ' . $file_path . ' for quote request ID: ' . $id);
        $this->session->set_flashdata('error', 'File not found on server. It may have been deleted.');
        redirect('cms/quote_requests');
        return;
    }
    
    // Check if file is readable
    if (!is_readable($file_path)) {
        log_message('error', 'File not readable: ' . $file_path);
        $this->session->set_flashdata('error', 'File cannot be read. Permission denied.');
        redirect('cms/quote_requests');
        return;
    }
    
    // Get file name (use original filename from database or fallback to basename)
    $file_name = !empty($request->file_name) ? $request->file_name : basename($file_path);
    
    // Security: Sanitize filename to prevent directory traversal
    $file_name = preg_replace('/[^a-zA-Z0-9._-]/', '_', $file_name);
    
    // Get mime type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file_path);
    finfo_close($finfo);
    
    // If mime type detection fails, use application/octet-stream
    if (!$mime_type) {
        $mime_type = 'application/octet-stream';
    }
    
    // Get file size
    $file_size = filesize($file_path);
    
    // Log download attempt
    log_message('info', 'Downloading quote file: ' . $file_name . ' for request ID: ' . $id);
    
    // Clear any output buffers
    if (ob_get_level()) {
        ob_end_clean();
    }
    
    // Set headers for download
    header('Content-Type: ' . $mime_type);
    header('Content-Disposition: attachment; filename="' . $file_name . '"');
    header('Content-Length: ' . $file_size);
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Expires: 0');
    
    // Read and output file in chunks to handle large files
    $chunk_size = 1024 * 1024; // 1MB chunks
    $handle = fopen($file_path, 'rb');
    
    if ($handle === false) {
        log_message('error', 'Failed to open file for reading: ' . $file_path);
        show_404();
        return;
    }
    
    while (!feof($handle)) {
        $buffer = fread($handle, $chunk_size);
        echo $buffer;
        flush();
    }
    
    fclose($handle);
    exit();
}

/**
 * Debug function to check file path (remove in production)
 * Access via: cms/debug_quote_file/[id]
 */
public function debug_quote_file($id) {
    if (empty($id) || !is_numeric($id)) {
        echo "Invalid ID";
        return;
    }
    
    $request = $this->Quote_requests_model->get_request($id);
    
    if (!$request) {
        echo "Request not found with ID: " . $id;
        return;
    }
    
    echo "<h2>Quote Request File Debug Information</h2>";
    echo "<hr>";
    echo "<strong>Request ID:</strong> " . $request->id . "<br>";
    echo "<strong>File Path (DB):</strong> " . ($request->file_path ?: 'NULL') . "<br>";
    echo "<strong>File Name (DB):</strong> " . ($request->file_name ?: 'NULL') . "<br>";
    echo "<strong>FCPATH:</strong> " . FCPATH . "<br>";
    
    if (!empty($request->file_path)) {
        $file_relative_path = ltrim($request->file_path, '/');
        $file_path = FCPATH . $file_relative_path;
        
        echo "<strong>Full File Path:</strong> " . $file_path . "<br>";
        echo "<strong>File Exists:</strong> " . (file_exists($file_path) ? 'YES' : 'NO') . "<br>";
        
        if (file_exists($file_path)) {
            echo "<strong>File Readable:</strong> " . (is_readable($file_path) ? 'YES' : 'NO') . "<br>";
            echo "<strong>File Size:</strong> " . filesize($file_path) . " bytes<br>";
            
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $file_path);
            finfo_close($finfo);
            echo "<strong>MIME Type:</strong> " . ($mime_type ?: 'Unknown') . "<br>";
        } else {
            echo "<br><strong style='color:red;'>File does not exist on filesystem!</strong><br>";
            echo "<br><strong>Checking alternative paths:</strong><br>";
            
            // Check if file exists with different path variations
            $variations = [
                FCPATH . $request->file_path,
                FCPATH . 'uploads/quote_requests/' . $request->file_name,
                FCPATH . 'assets_system/uploads/' . $request->file_name,
                './uploads/quote_requests/' . $request->file_name
            ];
            
            foreach ($variations as $path) {
                echo "Checking: " . $path . " - " . (file_exists($path) ? '<span style="color:green;">FOUND</span>' : '<span style="color:red;">Not found</span>') . "<br>";
            }
        }
    } else {
        echo "<br><strong style='color:red;'>No file path in database!</strong>";
    }
    
    echo "<hr>";
    echo "<a href='" . base_url('cms/quote_requests') . "'>Back to Quote Requests</a>";
}

/**
 * Export quote requests to CSV
 */
public function export_quote_requests() {
    $status = $this->input->get('status') ?: 'all';
    $search = $this->input->get('search') ?: '';
    
    $csv_data = $this->Quote_requests_model->export_to_csv($status, $search);
    
    // Set headers for download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="quote_requests_' . date('Y-m-d') . '.csv"');
    
    // Output CSV
    $output = fopen('php://output', 'w');
    foreach ($csv_data as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
}

/**
 * Get quote request details (for modal)
 */
public function get_quote_request_details() {
    header('Content-Type: application/json');
    
    $id = $this->input->post('id');
    
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'Missing request ID']);
        return;
    }
    
    $request = $this->Quote_requests_model->get_request($id);

    if ($request) {
        echo json_encode(['success' => true, 'request' => $request]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Request not found']);
    }
}

// ===== OTHER CAPABILITIES CRUD =====
public function add_other_capability()
{
    if (!$this->input->is_ajax_request()) {
        show_404();
    }

    $data = [
        'category'   => $this->input->post('category'),
        'item_name'  => $this->input->post('item_name'),
        'icon'       => $this->input->post('icon'),
        'is_active'  => 1
    ];

    if (empty($data['category']) || empty($data['item_name'])) {
        echo json_encode(['success' => false, 'message' => 'Category and item name are required']);
        return;
    }

    // Auto-assign sort_order to last position
    $max = $this->db->select_max('sort_order')->get('tbl_other_capabilities')->row()->sort_order;
    $data['sort_order'] = ($max ? (int)$max : 0) + 1;

    // Auto-create category setting if it doesn't exist
    $existing_cat = $this->db->get_where('tbl_other_capability_categories', ['category' => $data['category']])->row();
    if (!$existing_cat) {
        $max_cat_order = $this->db->select_max('sort_order')->get('tbl_other_capability_categories')->row()->sort_order;
        $this->db->insert('tbl_other_capability_categories', [
            'category'   => $data['category'],
            'icon'       => 'bi-folder',
            'color'      => '#0d6efd',
            'sort_order' => ($max_cat_order ? (int)$max_cat_order : 0) + 1
        ]);
    }

    $id = $this->simulation_model->add_other_capability($data);
    if ($id) {
        $item = $this->simulation_model->get_other_capability($id);
        echo json_encode(['success' => true, 'message' => 'Capability added', 'item' => $item]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add capability']);
    }
}

public function update_other_capability()
{
    if (!$this->input->is_ajax_request()) {
        show_404();
    }

    $id = $this->input->post('id');
    $data = [
        'category'   => $this->input->post('category'),
        'item_name'  => $this->input->post('item_name'),
        'icon'       => $this->input->post('icon'),
        'is_active'  => (int) $this->input->post('is_active')
    ];

    if (empty($id) || empty($data['category']) || empty($data['item_name'])) {
        echo json_encode(['success' => false, 'message' => 'ID, category and item name are required']);
        return;
    }

    if ($this->simulation_model->update_other_capability($id, $data)) {
        $item = $this->simulation_model->get_other_capability($id);
        echo json_encode(['success' => true, 'message' => 'Capability updated', 'item' => $item]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update capability']);
    }
}

public function delete_other_capability()
{
    if (!$this->input->is_ajax_request()) {
        show_404();
    }

    $id = $this->input->post('id');
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID is required']);
        return;
    }

    if ($this->simulation_model->delete_other_capability($id)) {
        echo json_encode(['success' => true, 'message' => 'Capability deleted']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete capability']);
    }
}

public function get_other_capability()
{
    if (!$this->input->is_ajax_request()) {
        show_404();
    }

    $id = $this->input->post('id');
    $item = $this->simulation_model->get_other_capability($id);
    if ($item) {
        echo json_encode(['success' => true, 'item' => $item]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Not found']);
    }
}

public function update_capability_category()
{
    if (!$this->input->is_ajax_request()) {
        show_404();
    }

    $id = $this->input->post('id');
    $data = [
        'icon'  => $this->input->post('icon'),
        'color' => $this->input->post('color')
    ];

    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID is required']);
        return;
    }

    if ($this->simulation_model->update_capability_category($id, $data)) {
        $item = $this->simulation_model->get_capability_category($id);
        echo json_encode(['success' => true, 'message' => 'Category updated', 'item' => $item]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update category']);
    }
}

public function get_capability_category()
{
    if (!$this->input->is_ajax_request()) {
        show_404();
    }

    $id = $this->input->post('id');
    $item = $this->simulation_model->get_capability_category($id);
    if ($item) {
        echo json_encode(['success' => true, 'item' => $item]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Not found']);
    }
}

public function delete_capability_category()
{
    if (!$this->input->is_ajax_request()) {
        show_404();
    }

    $id = $this->input->post('id');
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID is required']);
        return;
    }

    $cat = $this->simulation_model->get_capability_category($id);
    if (!$cat) {
        echo json_encode(['success' => false, 'message' => 'Category not found']);
        return;
    }

    // Count items that will be deleted
    $count = $this->db->where('category', $cat->category)->count_all_results('tbl_other_capabilities');

    if ($this->simulation_model->delete_capability_category($id)) {
        echo json_encode(['success' => true, 'message' => "Category \"{$cat->category}\" and {$count} item(s) deleted"]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete category']);
    }
}

}
