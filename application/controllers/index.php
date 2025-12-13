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
  function termsof_service()
  {
   $this->load->view('termsof_service');
  }
  function cookies_setting()
  {
   $this->load->view('cookies_setting');
  }
   function privacy_policy()
  {
   $this->load->view('privacy_policy');
  }
  function news_events_extension()
  {
   $this->load->view('news_events_extension');
  }
  function electronic_counter_details()
  {
   $this->load->view('electronic_counter_details');
  }
  function technical_specs()
  {
   $this->load->view('technical_specs');
  }
  function ps_contents()
  {
   $this->load->view('ps_contents');
  }
  function ps_serv()
  {
   $this->load->view('ps_serv');
  }
  function timer_details()
  {
   $this->load->view('timer_details');
  }
  function mechanical_counter_details()
  {
   $this->load->view('mechanical_counter_details');
  }
  function slide_limit_counter_details()
  {
   $this->load->view('slide_limit_counter_details');
  }
  function limit_switches_details()
  {
   $this->load->view('limit_switches_details');
  }
  function length_counter_sensor_details()
  {
   $this->load->view('length_counter_sensor_details');
  }
  function rotary_encoders_details()
  {
   $this->load->view('rotary_encoders_details');
  }
  function tachometers_details()
  {
   $this->load->view('tachometers_details');
  }
  function thermometers_details()
  {
   $this->load->view('thermometers_details');
  }
  function measuring_instruments_details()
  {
   $this->load->view('measuring_instruments_details');
  }
  function tally_counters_details()
  {
   $this->load->view('tally_counters_details');
  }
  function ss2_p3_series()
  {
   $this->load->view('ss2_p3_series');
  }

}
