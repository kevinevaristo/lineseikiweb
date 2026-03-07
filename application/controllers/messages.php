<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messages extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Load necessary libraries, helpers, and models
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('session');
        $this->load->model('admin/message_model');
        
        // Authentication check (you can modify this based on your auth system)
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
    
    /**
     * Main dashboard page
     */
    public function index() {
        // Get dashboard data
        $data['title'] = 'Messages Dashboard';
        $data['statistics'] = $this->message_model->get_statistics();
        $data['recent_messages'] = $this->message_model->get_recent_messages();
        $data['all_messages'] = $this->message_model->get_all_messages();
        
        // Load views
        $this->load->view('admin/header', $data);
        $this->load->view('admin/dashboard', $data);
    }
    
    /**
     * View single message
     */
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
    
    /**
     * Update message status
     */
    public function update_status($id) {
        $status = $this->input->post('status');
        
        if($this->message_model->update_status($id, $status)) {
            $this->session->set_flashdata('success', 'Status updated successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to update status');
        }
        
        redirect('admin/view/' . $id);
    }
    
    /**
     * Add/update notes
     */
    public function update_notes($id) {
        $notes = $this->input->post('notes');
        
        if($this->message_model->update_notes($id, $notes)) {
            $this->session->set_flashdata('success', 'Notes updated successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to update notes');
        }
        
        redirect('admin/view/' . $id);
    }
    
    /**
     * Filter messages by status
     */
    public function filter($status = null) {
        $data['title'] = 'Filtered Messages';
        
        if($status) {
            $this->db->where('status', $status);
        }
        
        $this->db->select('id, name, email, subject, status, submitted_at');
        $this->db->from('tbl_send_us_message');
        $this->db->order_by('submitted_at', 'DESC');
        $query = $this->db->get();
        
        $data['messages'] = $query->result();
        $data['current_filter'] = $status;
        $data['statistics'] = $this->message_model->get_statistics();
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/filtered', $data);
    }
}