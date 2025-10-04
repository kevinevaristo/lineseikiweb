<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

class index extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    // $this->load->model('reimbursement_model');
    $this->load->helper(array('form', 'url'));
    $this->load->library('upload');
  }

  function index()
  {
    $this->load->view('home');
  }

  function about_us()
  {
    $this->load->view('aboutus');
  }

  function contact_us()
  {
    $this->load->view('contactus');
  }

  function library()
  {
    $this->load->view('library');
  }

  function news_event()
  {
    $this->load->view('newsevent');
  }

  function ps_iotsolution()
  {
    $this->load->view('ps_iotsolution');
  }

  function ps_prod()
  {
    $this->load->view('ps_prod');
  }

  function ps_serv_silicone()
  {
    $this->load->view('ps_serv_silicone');
  }

  function ps_serv_simulation()
  {
   $this->load->view('ps_serv_simulation');
  }

   function products_details()
  {
   $this->load->view('products_details');
  }
}
