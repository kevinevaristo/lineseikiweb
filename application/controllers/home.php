<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class home extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->load->model('admin/admin_model');
    $this->load->model('admin/dashboard_model');

    if ($this->session->userdata('SESS_USER_ID') == '') {
      redirect('panel_72c81/session_expired');
    }
  }

  function index()
  {
    $user_id = $this->session->userdata('SESS_USER_ID');

    // Get dashboard statistics
    $data['statistics'] = $this->dashboard_model->get_statistics_summary();
    $this->load->view('admin/header');
    $this->load->view('admin/home_views', $data);

  }
  
  /**
   * API endpoint to get visitor statistics
   */
  public function get_visitor_stats()
  {
    $this->output->set_content_type('application/json');
    
    $stats = $this->dashboard_model->get_statistics_summary();
    
    echo json_encode([
      'success' => true,
      'data' => $stats
    ]);
  }
  
  /**
   * API endpoint to get visitor trend data
   */
  public function get_visitor_trend()
  {
    $this->output->set_content_type('application/json');
    
    $days = $this->input->get('days') ?? 30;
    $trend = $this->dashboard_model->get_visitor_trend($days);
    
    echo json_encode([
      'success' => true,
      'data' => $trend
    ]);
  }
}

