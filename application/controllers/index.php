<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', 1);

class index extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    // $this->load->model('reimbursement_model');
    $this->load->helper(array('form', 'url'));
     $this->load->library('form_validation');
    $this->load->library('upload');
    $this->load->model('web/home_page_model');
    $this->load->model('web/about_us_model');
    $this->load->model('web/smuc_model');
    $this->load->model('web/iotsolution_model');
    $this->load->model('web/event_model');
    $this->load->model('web/library_model');
    $this->load->model('web/contact_us_model');
    $this->load->model('web/safety_switches_model');
    $this->load->model('web/privacy_model');
    $this->load->model('web/visit_tracker_model');
    $this->load->model('web/visit_tracker_model');
    $this->load->model('web/email_model');
    $this->load->model('web/testimonial_model');
    $this->load->model('web/search_model');
  }

  function index()
  {
    // Track website visit
    $this->visit_tracker_model->track_visit();
    
    $data = array(
            'hero' => $this->home_page_model->get_hero_data(),
            'legacy' => $this->home_page_model->get_legacy_products_data(),
            'services' => $this->home_page_model->get_services_data(),
            'new_products' => $this->home_page_model->get_new_products_data()
        );
      
  $data['hero']['slides'] = $this->home_page_model->get_homepage_slides();
  $data['dynamic_categories'] = $this->home_page_model->get_categories();
   $data['dynamic_stats'] = $this->home_page_model->get_stats();
   $data['new_item'] = $this->home_page_model->get_new_product();
   $data['cms_data'] = $this->home_page_model->get_home_content();
   $this->db->where('is_active', 1);
        $this->db->order_by('sort_order', 'ASC');
        $this->db->order_by('year', 'DESC');
        $query = $this->db->get('tbl_achievements');
        $data['achievements'] = $query->result_array();
    $this->load->view('web/home', $data);
  }
  
    public function subscribe_newsletter() {
        // Initialize response array
        $response = [
            'status' => 'error',
            'message' => 'An unknown error occurred'
        ];

        try {
            // Validate email
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|strtolower');

            if ($this->form_validation->run() == FALSE) {
                // Validation failed
                $response = [
                    'status' => 'error',
                    'message' => strip_tags(validation_errors(' ', ' '))
                ];
                
                $this->send_json_response($response);
                return;
            }

            $email = $this->input->post('email', true);
            
            // Get additional data
            $ip_address = $this->input->ip_address();
            $user_agent = $this->input->user_agent();

            // Check if email already exists
            $existing = $this->email_model->get_by_email($email);
            
            if ($existing) {
                if ($existing->status == 'unsubscribed') {
                    // Reactivate unsubscribed email
                    $update_data = [
                        'status' => 'active',
                        'unsubscribed_at' => null
                    ];
                    
                    if ($this->email_model->update($existing->id, $update_data)) {
                        $response = [
                            'status' => 'success',
                            'message' => 'Welcome back! Your subscription has been reactivated.'
                        ];
                    } else {
                        $response = [
                            'status' => 'error',
                            'message' => 'Failed to reactivate subscription. Please try again.'
                        ];
                    }
                } else {
                    // Email already active
                    $response = [
                        'status' => 'info',
                        'message' => 'This email is already subscribed to our newsletter.'
                    ];
                }
            } else {
                // New subscription
                $data = [
                    'email' => $email,
                    'ip_address' => $ip_address,
                    'user_agent' => $user_agent,
                    'status' => 'active',
                    'subscribed_at' => date('Y-m-d H:i:s')
                ];
                
                $insert_id = $this->email_model->insert($data);
                
                if ($insert_id) {
                    // Try to send welcome email (but don't fail if it doesn't work)
                    
                    
                    $response = [
                        'status' => 'success',
                        'message' => 'Thank you for subscribing to our newsletter!'
                    ];
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'Failed to subscribe. Please try again later.'
                    ];
                }
            }
        } catch (Exception $e) {
            // Log the error
            log_message('error', 'Newsletter subscription error: ' . $e->getMessage());
            
            $response = [
                'status' => 'error',
                'message' => 'An error occurred. Please try again.'
            ];
        }

        // Send JSON response
        $this->send_json_response($response);
    }

    /**
     * Send JSON response and exit
     */
    private function send_json_response($response) {
        // Clear any output buffers
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        
        // Set proper JSON header
        header('Content-Type: application/json');
        header('X-Content-Type-Options: nosniff');
        
        echo json_encode($response);
        exit;
    }

  function about_us()
  {
    $data = $this->about_us_model->get_about_data();
    $data['partners'] = $this->about_us_model->get_all_partners();
    $data['stats'] = $this->about_us_model->get_stats();
    $this->load->view('web/aboutus', $data);
  }

  function contact_us()
  {
     $data['contact_content'] = $this->contact_us_model->get_all_content();
        
        // Get specific content for easier access in view
        $data['contact_hero_title'] = $this->get_content('Contact Hero Title');
        $data['contact_hero_desc'] = $this->get_content('Contact Hero Description');

        // Get hero image from Contact Hero Title row
        $hero_row = $this->contact_us_model->get_by_title('Contact Hero Title');
        $data['contact_hero_image'] = ($hero_row && !empty($hero_row['image'])) ? $hero_row['image'] : '';
        $data['contact_info_title'] = $this->get_content('Contact Information Section Title');
        $data['contact_form_title'] = $this->get_content('Contact Form Section Title');
        $data['map_section_title'] = $this->get_content('Map Section Title');
        $data['map_section_desc'] = $this->get_content('Map Section Description');
        $data['map_embed_url'] = $this->get_content('Map Embed URL');
        $data['cta_title'] = $this->get_content('CTA Section Title');
        $data['cta_desc'] = $this->get_content('CTA Section Description');
        
        // Get contact info cards using the simpler method
        $contact_cards = $this->contact_us_model->get_contact_info_cards_simple();
        $data['contact_info_cards'] = $this->organize_contact_cards($contact_cards);
        
        // Get form labels and placeholders
        $data['form_labels'] = array(
            'name' => $this->get_content('Name Field Label'),
            'email' => $this->get_content('Email Field Label'),
            'subject' => $this->get_content('Subject Field Label'),
            'message' => $this->get_content('Message Field Label')
        );
        
        $data['form_placeholders'] = array(
            'name' => $this->get_content('Name Field Placeholder'),
            'email' => $this->get_content('Email Field Placeholder'),
            'subject' => $this->get_content('Subject Field Placeholder'),
            'message' => $this->get_content('Message Field Placeholder')
        );
        
        $data['submit_button'] = $this->get_content('Submit Button Text');
        $data['cta_buttons'] = array(
            'schedule' => $this->get_content('Schedule Consultation Button'),
            'demo' => $this->get_content('Request Demo Button')
        );
    $this->load->view('web/contactus', $data);
  }
  
  private function get_content($title) {
        $content = $this->contact_us_model->get_by_title($title);
        return $content ? $content['content'] : '';
    }
    
    /**
     * Organize contact cards into title-content pairs
     */
    private function organize_contact_cards($cards) {
        $organized = array();
        
        foreach ($cards as $card) {
            if (strpos($card['title'], 'Title') !== false) {
                // This is a title card, find its corresponding content
                $title_key = str_replace(' Title', '', $card['title']);
                $organized[$title_key] = array(
                    'title' => $card['content'],
                    'content' => '',
                    'image' => $card['image']
                );
            } elseif (strpos($card['title'], 'Content') !== false) {
                // This is a content card, find its corresponding title
                $title_key = str_replace(' Content', '', $card['title']);
                if (isset($organized[$title_key])) {
                    $organized[$title_key]['content'] = $card['content'];
                }
            }
        }
        
        return $organized;
    }

  function library()
  {
     $data = array();
        
        // Get main header (ID 1)
        $data['main_header'] = $this->library_model->get_item(1);
        
        // Get featured video (ID 2)
        $data['featured_video'] = $this->library_model->get_item(2);
        
        // Get up next videos (IDs 3, 4, 5)
        $data['up_next_videos'] = $this->library_model->get_items_by_ids(array(3, 4, 5));
        
        // Get video items with images (Episodes 1-8 and video tutorials)
        $data['video_items'] = $this->library_model->get_items_with_images();
        
        // Get PDF items without images (brochures, etc.)
        $data['pdf_items'] = $this->library_model->get_items_without_images();

        // Get case studies from simulation content
        $data['case_study_items'] = $this->library_model->get_case_studies();

        // Get all webinars
    $data['webinars'] = $this->db->order_by('id', 'ASC')->get('tbl_webinar')->result_array();
    
    // Check if a specific webinar is selected from URL
    $data['selected_webinar'] = $this->input->get('webinar') ? intval($this->input->get('webinar')) : 0;
    
    $this->load->view('web/library', $data);
    
  }
  
  // application/controllers/Index.php
public function save_download_info() {
    $response = array('success' => false, 'message' => '');
    
    try {
        $data = array(
            'full_name' => $this->input->post('full_name', true),
            'email' => $this->input->post('email', true),
            'contact_number' => $this->input->post('contact_number', true),
            'company' => $this->input->post('company', true),
            'position' => $this->input->post('position', true),
            'file_name' => $this->input->post('file_name', true),
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent(),
            'downloaded_at' => date('Y-m-d H:i:s')
        );
        
        $this->db->insert('tbl_download_info', $data);
        
        if($this->db->affected_rows() > 0) {
            $response['success'] = true;
            $response['message'] = 'Download recorded successfully';
        } else {
            $response['message'] = 'Failed to save download info';
        }
        
    } catch(Exception $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
    }
    
    echo json_encode($response);
}

  /**
   * Download a PDF file from the documents folder
   */
  public function download_file($filename = '') {
      if (empty($filename)) {
          show_404();
          return;
      }

      $filename = basename($filename); // prevent directory traversal
      $filepath = FCPATH . 'assets_system/documents/' . $filename;

      if (!file_exists($filepath)) {
          $this->session->set_flashdata('error', 'The requested file was not found.');
          redirect('index/library');
          return;
      }

      $this->load->helper('download');
      $data = file_get_contents($filepath);
      force_download($filename, $data);
  }

  /**
   * Save video watch information
   */
  function save_watch_info()
  {
    // Set JSON header
    header('Content-Type: application/json');
    
    // Validate required fields
    $full_name = trim($this->input->post('full_name'));
    $email = trim($this->input->post('email'));
    $contact_number = trim($this->input->post('contact_number'));
    $company = trim($this->input->post('company'));
    $position = trim($this->input->post('position'));
    $video_title = trim($this->input->post('video_title'));
    $video_url = trim($this->input->post('video_url'));
    
    if (empty($full_name) || empty($email) || empty($company) || empty($position)) {
      echo json_encode([
        'success' => false,
        'message' => 'Please fill in all required fields.'
      ]);
      exit;
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid email address.'
      ]);
      exit;
    }
    
    // Prepare data
    $data = array(
      'full_name' => $full_name,
      'email' => $email,
      'contact_number' => $contact_number,
      'company' => $company,
      'position' => $position,
      'video_title' => $video_title,
      'submitted_at' => date('Y-m-d H:i:s'),
      'video_url' => $video_url,
      'resource_type' => 'video',
      'ip_address' => $this->input->ip_address(),
      'user_agent' => $this->input->user_agent()
    );
    
    try {
      $result = $this->library_model->save_watch_info($data);
      
      if ($result) {
        log_message('info', 'Watch info saved for: ' . $email . ' - Video: ' . $video_title);
        echo json_encode([
          'success' => true,
          'message' => 'Information saved successfully!',
          'video_url' => $video_url
        ]);
      } else {
        echo json_encode([
          'success' => false,
          'message' => 'Failed to save information. Please try again.'
        ]);
      }
    } catch (Exception $e) {
      log_message('error', 'Watch info save error: ' . $e->getMessage());
      echo json_encode([
        'success' => false,
        'message' => 'An error occurred. Please try again.'
      ]);
    }
    exit;
  }
  
  /**
   * Save download information
   */
  

  function news_event()
  {
     $data = array();
        
        // Get filter from GET parameter (if any)
        $category = $this->input->get('filter') ?: 'all';
        
        // Get all events for the selected category
        $data['events'] = $this->event_model->get_all_events(6, 0, $category);
        
        // Get featured events
        $data['featured_events'] = $this->event_model->get_featured_events(1);
        
        // Get total counts for each category (for filter buttons)
        $data['category_counts'] = array(
            'all' => $this->event_model->get_total_events('all'),
            'news' => $this->event_model->get_total_events('news'),
            'events' => $this->event_model->get_total_events('events'),
            'product' => $this->event_model->get_total_events('product'),
            'webinars' => $this->event_model->get_total_events('webinars')
        );
        
        // Current active filter
        $data['active_filter'] = $category;
    $this->load->view('web/newsevent', $data);
  }

  function ps_iotsolution()
  {
    $grouped_data = $this->iotsolution_model->get_grouped_content();
        
        // Pass data to view
        $data['hero'] = isset($grouped_data['hero']) ? $grouped_data['hero'] : array();
        $data['solution'] = isset($grouped_data['solution']) ? $grouped_data['solution'] : array();
        $data['products'] = isset($grouped_data['products']) ? $grouped_data['products'] : array();
        $data['system_setup'] = isset($grouped_data['system_setup']) ? $grouped_data['system_setup'] : array();
        $data['setup_diagram'] = $this->iotsolution_model->get_by_title('System Setup Diagram') ?: array('image' => 'system-setupnobg.png', 'id' => '');
        $data['production_data'] = isset($grouped_data['production_data']) ? $grouped_data['production_data'] : array();
        $data['features'] = isset($grouped_data['features']) ? $grouped_data['features'] : array();
        $data['section_background'] = $this->iotsolution_model->get_by_title('Section Background') ?: array('image' => 'decisionsbg.jpg', 'id' => '');
        // Get ordered features
        $data['features_ordered'] = $this->iotsolution_model->get_features_ordered();
        
        // Get production data in correct order
        $data['production_data_ordered'] = $this->iotsolution_model->get_production_data_ordered();
         $data['testimonials'] = $this->testimonial_model->get_all_testimonials();
        
    $this->load->view('web/ps_iotsolution', $data);
  }

  function ps_prod()
  {
    $this->load->model('web/products_model');
    $data = $this->products_model->get_products_data();
    
    $this->load->view('web/ps_prod', $data);
  }
  
  /**
   * Display products for a specific category
   * @param int $category_id The category ID
   */
  function category_products($category_id)
  {
    $this->load->database();
    $this->load->model('web/products_model');
    
    // Get category details
    $category_query = $this->db->where('id', $category_id)->get('tbl_product_category');
    $data['category'] = $category_query->row();
    
    if (!$data['category']) {
      show_404();
      return;
    }
    
    // Get all product types for this category with item counts
    $types_query = $this->db
      ->select('tbl_product_types.*, COUNT(tbl_product_items.id) as item_count')
      ->from('tbl_product_types')
      ->join('tbl_product_items', 'tbl_product_types.id = tbl_product_items.product_type', 'left')
      ->where('tbl_product_types.product_category', $category_id)
      ->where('tbl_product_items.is_active !=', 0)
      ->group_by('tbl_product_types.id')
      ->order_by('tbl_product_types.id', 'ASC')
      ->get();
    $data['types'] = $types_query->result();
    
    // Get all products for this category organized by type
    $items_query = $this->db
      ->select('tbl_product_items.*, tbl_product_types.type_name, tbl_product_items.slug')
      ->from('tbl_product_items')
      ->join('tbl_product_types', 'tbl_product_items.product_type = tbl_product_types.id', 'left')
      ->where('tbl_product_items.product_category', $category_id)
      ->where('tbl_product_items.is_active !=', 0)
      ->order_by('tbl_product_types.id', 'ASC')
      ->order_by('tbl_product_items.id', 'ASC')
      ->get();
    
    $all_items = $items_query->result();
    
    // Organize items by type
    $data['items_by_type'] = array();
    foreach ($all_items as $item) {
      if (!isset($data['items_by_type'][$item->product_type])) {
        $data['items_by_type'][$item->product_type] = array();
      }
      $data['items_by_type'][$item->product_type][] = $item;
    }
    
    $this->load->view('web/category_products', $data);
  }

  public function product($slug)
  {
    $this->load->database();
    $this->load->model('web/Product_page_model');
    
    // Get product details by slug
    $data['product'] = $this->Product_page_model->get_product_by_slug($slug);
    
    if (!$data['product']) {
        show_404();
        return;
    }
    
    // Get related products (same category, different product)
    $data['related_products'] = $this->Product_page_model->get_related_products(
        $data['product']->id,
        $data['product']->product_category,
        3 // Limit to 3 related products
    );
    
    $this->load->view('web/product_detail_dynamic', $data);
  }


  function ps_serv_silicone()
  {
    $data['content'] = $this->smuc_model->get_all_content();
    $data['gallery_urethane'] = $this->smuc_model->get_all('urethane_parts');
     $data['testimonials'] = $this->testimonial_model->get_all_testimonials();
    $data['gallery_overmolding'] = $this->smuc_model->get_all('overmolding');
    $this->load->view('web/ps_serv_silicone', $data);
  }

  private function send_quote_email($quote_data)
{
    // Detect local or live server
    $is_local = (
        strpos($_SERVER['HTTP_HOST'], 'localhost') !== false ||
        strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false
    );

    if ($is_local) {
        // LOCAL XAMPP - Gmail SMTP
        $config = array(
            'protocol'    => 'smtp',
            'smtp_host'   => 'smtp.gmail.com',
            'smtp_port'   => 587,
            'smtp_user'   => 'traballojeffrey3@gmail.com',
            'smtp_pass'   => 'YOUR_GMAIL_APP_PASSWORD', // ⚠️ move to env/config
            'smtp_crypto' => 'tls',
            'mailtype'    => 'html',
            'charset'     => 'utf-8',
            'newline'     => "\r\n",
            'wordwrap'    => TRUE,
            'smtp_timeout'=> 10
        );

        log_message('debug', 'Using Gmail SMTP for local development');

    } else {
        // LIVE SERVER - cPanel SMTP
        $config = array(
        'protocol'    => 'smtp',
        'smtp_host'   => 'lineseikiasiapacific.com',
        'smtp_user'   => 'noreply@lineseikiasiapacific.com',
        'smtp_pass'   => '?P@55w0rd123?',
        'smtp_port'   => 465,
        'smtp_crypto' => 'ssl',
        'mailtype'    => 'html',
        'charset'     => 'utf-8',
        'newline'     => "\r\n",
        'crlf'        => "\r\n",
        'smtp_timeout'=> 15,
        'wordwrap'    => TRUE
    );

        log_message('debug', 'Using cPanel SMTP for live server');
    }

    // Load Email Library
    $this->load->library('email');
    $this->email->initialize($config);

    // From
    $from_email = 'traballojeffrey3@gmail.com';

    $from_name = 'Line Seiki Asia Pacific - SMUC';

    $this->email->from('noreply@lineseikiasiapacific.com', $from_name);

    // Send TO ADMIN (not customer)
    $this->email->to('traballojeffrey3@gmail.com');

    // Reply-To Customer
    $this->email->reply_to($quote_data['email'], $quote_data['name']);

    $this->email->subject('New SMUC Quote Request from ' . $quote_data['company_name']);

    // Attachment
    if (!empty($quote_data['file_path'])) {
        $full_path = FCPATH . $quote_data['file_path'];
        if (file_exists($full_path)) {
            $this->email->attach($full_path);
            log_message('debug', 'File attached: ' . $quote_data['file_name']);
        } else {
            log_message('warning', 'Attachment file not found: ' . $full_path);
        }
    }

    // Email Body
    $this->email->message($this->get_email_template($quote_data));

    // Send Email
    if ($this->email->send()) {
        log_message('info', 'Quote email sent successfully');
        return true;
    } else {
        log_message('error', 'Email failed: ' . $this->email->print_debugger());
        return false;
    }
}


  private function send_contact_notification($contact_data)
  {
    // Detect local or live server
    $is_local = (
        strpos($_SERVER['HTTP_HOST'], 'localhost') !== false ||
        strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false
    );

    if ($is_local) {
        // LOCAL XAMPP - Gmail SMTP
        $config = array(
            'protocol'    => 'smtp',
            'smtp_host'   => 'smtp.gmail.com',
            'smtp_port'   => 587,
            'smtp_user'   => 'traballojeffrey3@gmail.com',
            'smtp_pass'   => 'YOUR_GMAIL_APP_PASSWORD', // ⚠️ move to env/config
            'smtp_crypto' => 'tls',
            'mailtype'    => 'html',
            'charset'     => 'utf-8',
            'newline'     => "\r\n",
            'wordwrap'    => TRUE,
            'smtp_timeout'=> 10
        );
    } else {
        // LIVE SERVER - cPanel SMTP
        $config = array(
            'protocol'    => 'smtp',
            'smtp_host'   => 'lineseikiasiapacific.com',
            'smtp_user'   => 'noreply@lineseikiasiapacific.com',
            'smtp_pass'   => '?P@55w0rd123?',
            'smtp_port'   => 465,
            'smtp_crypto' => 'ssl',
            'mailtype'    => 'html',
            'charset'     => 'utf-8',
            'newline'     => "\r\n",
            'crlf'        => "\r\n",
            'smtp_timeout'=> 15,
            'wordwrap'    => TRUE
        );
    }

    $this->load->library('email');
    $this->email->initialize($config);

    $from_name = 'Line Seiki Asia Pacific - Contact';

    $this->email->from('noreply@lineseikiasiapacific.com', $from_name);
    $this->email->to('traballojeffrey3@gmail.com');
    $this->email->reply_to($contact_data['email'], $contact_data['name']);
    $this->email->subject('New Contact Message: ' . $contact_data['subject']);
    $this->email->message($this->get_contact_email_template($contact_data));

    if ($this->email->send()) {
        log_message('info', 'Contact notification email sent successfully');
        return true;
    } else {
        log_message('error', 'Contact email failed: ' . $this->email->print_debugger());
        return false;
    }
  }


  private function get_contact_email_template($data)
  {
    $html = '
    <!DOCTYPE html>
    <html>
    <head>
      <meta charset="UTF-8">
      <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #0F467B, #17A2DC); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { background: #f8f9fa; padding: 30px; }
        .info-row { margin-bottom: 20px; padding: 15px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .label { font-weight: bold; color: #0F467B; margin-bottom: 5px; }
        .value { color: #333; white-space: pre-wrap; }
        .footer { background: #0F467B; color: white; padding: 20px; text-align: center; border-radius: 0 0 10px 10px; }
        .badge { background: #28a745; color: white; padding: 5px 10px; border-radius: 4px; font-size: 12px; }
      </style>
    </head>
    <body>
      <div class="container">
        <div class="header">
          <h1>📩 New Contact Message</h1>
          <p style="margin: 10px 0 0 0;">Line Seiki Asia Pacific Website</p>
        </div>

        <div class="content">
          <p style="text-align: center; margin-bottom: 30px;">
            <span class="badge">NEW MESSAGE</span>
          </p>

          <div class="info-row">
            <div class="label">👤 Name:</div>
            <div class="value">' . htmlspecialchars($data['name']) . '</div>
          </div>

          <div class="info-row">
            <div class="label">📧 Email Address:</div>
            <div class="value">' . htmlspecialchars($data['email']) . '</div>
          </div>

          <div class="info-row">
            <div class="label">📝 Subject:</div>
            <div class="value">' . htmlspecialchars($data['subject']) . '</div>
          </div>

          <div class="info-row">
            <div class="label">💬 Message:</div>
            <div class="value">' . htmlspecialchars($data['message']) . '</div>
          </div>

          <div class="info-row">
            <div class="label">📅 Received:</div>
            <div class="value">' . date('F j, Y g:i A') . '</div>
          </div>
        </div>

        <div class="footer">
          <p style="margin: 0;">Line Seiki Asia Pacific</p>
          <p style="margin: 5px 0 0 0; font-size: 14px; opacity: 0.8;">Automated Contact Form Notification</p>
        </div>
      </div>
    </body>
    </html>
    ';

    return $html;
  }


  private function get_email_template($data)
  {
    $html = '
    <!DOCTYPE html>
    <html>
    <head>
      <meta charset="UTF-8">
      <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #0F467B, #17A2DC); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { background: #f8f9fa; padding: 30px; }
        .info-row { margin-bottom: 20px; padding: 15px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .label { font-weight: bold; color: #0F467B; margin-bottom: 5px; }
        .value { color: #333; }
        .footer { background: #0F467B; color: white; padding: 20px; text-align: center; border-radius: 0 0 10px 10px; }
        .badge { background: #28a745; color: white; padding: 5px 10px; border-radius: 4px; font-size: 12px; }
      </style>
    </head>
    <body>
      <div class="container">
        <div class="header">
          <h1>🔔 New SMUC Quote Request</h1>
          <p style="margin: 10px 0 0 0;">Silicone Molding & Urethane Casting</p>
        </div>
        
        <div class="content">
          <p style="text-align: center; margin-bottom: 30px;">
            <span class="badge">NEW REQUEST</span>
          </p>
          
          <div class="info-row">
            <div class="label">👤 Customer Name:</div>
            <div class="value">' . htmlspecialchars($data['name']) . '</div>
          </div>
          
          <div class="info-row">
            <div class="label">📧 Email Address:</div>
            <div class="value">' . htmlspecialchars($data['email']) . '</div>
          </div>
          
          <div class="info-row">
            <div class="label">📞 Contact Number:</div>
            <div class="value">' . htmlspecialchars($data['contact_number']) . '</div>
          </div>
          
          <div class="info-row">
            <div class="label">🏢 Company Name:</div>
            <div class="value">' . htmlspecialchars($data['company_name']) . '</div>
          </div>
          
          <div class="info-row">
            <div class="label">📎 Attached File:</div>
            <div class="value">' . (!empty($data['file_name']) ? htmlspecialchars($data['file_name']) : 'No file attached') . '</div>
          </div>
          
          <div class="info-row">
            <div class="label">📅 Request Date:</div>
            <div class="value">' . date('F j, Y g:i A') . '</div>
          </div>
        </div>
        
        <div class="footer">
          <p style="margin: 0;">Line Seiki Asia Pacific</p>
          <p style="margin: 5px 0 0 0; font-size: 14px; opacity: 0.8;">Automated Quote Request Notification</p>
        </div>
      </div>
    </body>
    </html>
    ';
    
    return $html;
}

  private function get_email_plain_text($data)
  {
    $text = "NEW SMUC QUOTE REQUEST\n";
    $text .= "=====================================\n\n";
    $text .= "Customer Name: " . $data['name'] . "\n";
    $text .= "Email: " . $data['email'] . "\n";
    $text .= "Contact Number: " . $data['contact_number'] . "\n";
    $text .= "Company: " . $data['company_name'] . "\n";
    $text .= "Attached File: " . (!empty($data['file_name']) ? $data['file_name'] : 'None') . "\n";
    $text .= "Request Date: " . date('F j, Y g:i A') . "\n\n";
    $text .= "-------------------------------------\n";
    $text .= "Line Seiki Asia Pacific\n";
    $text .= "Automated Quote Request Notification";
    
    return $text;
}

  function submit_quote_request()
  {
    // Load database if not already loaded
    if (!$this->db->conn_id) {
      $this->load->database();
    }
    
    // Set JSON header
    header('Content-Type: application/json');
    
    // Enable error logging for debugging
    log_message('debug', 'Quote request started');
    
    // Validate required fields
    $name = trim($this->input->post('name'));
    $email = trim($this->input->post('email'));
    $contact_number = trim($this->input->post('contact_number'));
    $company_name = trim($this->input->post('company_name'));
    
    if (empty($name) || empty($email) || empty($contact_number) || empty($company_name)) {
      echo json_encode([
        'success' => false,
        'message' => 'Please fill in all required fields.'
      ]);
      exit;
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid email address.'
      ]);
      exit;
    }
    
    // File is required
    if (empty($_FILES['project_file']['name'])) {
      echo json_encode([
        'success' => false,
        'message' => 'Please attach a file before submitting your request.'
      ]);
      exit;
    }

    // Handle file upload
    $file_name = null;
    $file_path = null;

    if (!empty($_FILES['project_file']['name'])) {
      $upload_path = FCPATH . 'uploads/quote_requests/';
      
      // Create directory if it doesn't exist
      if (!is_dir($upload_path)) {
        if (!mkdir($upload_path, 0755, true)) {
          echo json_encode([
            'success' => false,
            'message' => 'Failed to create upload directory. Please contact administrator.'
          ]);
          exit;
        }
      }
      
      if (!is_writable($upload_path)) {
        echo json_encode([
          'success' => false,
          'message' => 'Upload directory is not writable. Please contact administrator.'
        ]);
        exit;
      }
      
      $config['upload_path'] = $upload_path;
      $config['allowed_types'] = 'pdf|doc|docx|dwg|dxf|step|stp|iges|igs|stl|zip|rar|jpg|jpeg|png';
      $config['max_size'] = 10240; // 10MB
      $config['encrypt_name'] = TRUE;
      
      $this->upload->initialize($config);
      
      if ($this->upload->do_upload('project_file')) {
        $upload_data = $this->upload->data();
        $file_name = $upload_data['file_name'];
        $file_path = 'uploads/quote_requests/' . $file_name;
        log_message('debug', 'File uploaded successfully: ' . $file_name);
      } else {
        $error = $this->upload->display_errors('', '');
        log_message('error', 'File upload failed: ' . $error);
        echo json_encode([
          'success' => false,
          'message' => 'File upload failed: ' . $error
        ]);
        exit;
      }
    }
    
    // Insert into database
    $data = [
      'name' => $name,
      'email' => $email,
      'contact_number' => $contact_number,
      'company_name' => $company_name,
      'file_name' => $file_name,
      'file_path' => $file_path,
      'status' => 'new',
      'created_at' => date('Y-m-d H:i:s')
    ];
    
    try {
      $this->db->insert('tbl_request_quote', $data);
      
      if ($this->db->affected_rows() > 0) {
        log_message('info', 'Quote request submitted for: ' . $email);
        
        // Send email notification
        $email_sent = $this->send_quote_email($data);
        
        if ($email_sent) {
          echo json_encode([
            'success' => true,
            'message' => 'Thank you! Your quote request has been submitted successfully. We will contact you soon.'
          ]);
        } else {
          echo json_encode([
            'success' => true,
            'message' => 'Your quote request has been submitted, but email notification failed. We will still process your request.'
          ]);
        }
      } else {
        echo json_encode([
          'success' => false,
          'message' => 'Failed to submit request. Please try again.'
        ]);
      }
    } catch (Exception $e) {
      log_message('error', 'Database error: ' . $e->getMessage());
      echo json_encode([
        'success' => false,
        'message' => 'Database error occurred. Please contact administrator.'
      ]);
    }
    exit;
  }
  
  public function submit_contact_message()
  {
    // Load the Contact_message_model
    $this->load->model('web/Contact_message_model');
    
    // Set JSON header
    header('Content-Type: application/json');
    
    // Enable error logging
    log_message('debug', 'Contact form submission started');
    
    // Validate required fields
    $name = trim($this->input->post('name'));
    $email = trim($this->input->post('email'));
    $subject = trim($this->input->post('subject'));
    $message = trim($this->input->post('message'));
    
    // Check if all required fields are filled
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
      echo json_encode([
        'success' => false,
        'message' => 'Please fill in all required fields.'
      ]);
      exit;
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid email address.'
      ]);
      exit;
    }
    
    // Validate message length
    if (strlen($message) < 10) {
      echo json_encode([
        'success' => false,
        'message' => 'Message must be at least 10 characters long.'
      ]);
      exit;
    }
    
    // Prepare data for insertion
    $data = [
      'name' => $name,
      'email' => $email,
      'subject' => $subject,
      'message' => $message,
      'ip_address' => $this->input->ip_address(),
      'user_agent' => $this->input->user_agent()
    ];
    
    try {
      // Insert into database using the model
      $insert_id = $this->Contact_message_model->insert_message($data);
      
      if ($insert_id) {
        log_message('info', 'Contact message submitted: ID ' . $insert_id . ' from ' . $email);
        
        // Send email notification to admin
        $this->send_contact_notification($data);

        echo json_encode([
          'success' => true,
          'message' => 'Thank you for your message! We will get back to you soon.'
        ]);
      } else {
        log_message('error', 'Failed to insert contact message to database');
        echo json_encode([
          'success' => false,
          'message' => 'Failed to submit your message. Please try again.'
        ]);
      }
    } catch (Exception $e) {
      log_message('error', 'Contact form error: ' . $e->getMessage());
      echo json_encode([
        'success' => false,
        'message' => 'An error occurred. Please try again later.'
      ]);
    }
    exit;
  }
  
  public function get_ip_location($ip = null)
    {
        // Kung walang ipinasa na IP, gamitin ang visitor IP
        if (!$ip) {
            $ip = $this->input->ip_address();
        }

        // URL ng free API
        $url = "http://ip-api.com/json/{$ip}";

        // Call API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result, true);

        if ($data['status'] === 'success') {
            // Example output
            echo "<pre>";
            echo "IP: " . $ip . "\n";
            echo "Country: " . $data['country'] . "\n";
            echo "Region: " . $data['regionName'] . "\n";
            echo "City: " . $data['city'] . "\n";
            echo "ISP: " . $data['isp'] . "\n";
            echo "Lat/Lon: " . $data['lat'] . " / " . $data['lon'] . "\n";
            echo "</pre>";
        } else {
            echo "Location not found for IP: {$ip}";
        }
    }

  function ps_serv_simulation()
  {
    $this->load->model('web/simulation_model');
    $content = $this->simulation_model->get_simulation_content();
    
    $data = array(
        'content' => $content
    );
    $data['testimonials'] = $this->testimonial_model->get_all_testimonials();
    $data['capabilities'] = $this->simulation_model->get_all_capabilities();
    $data['benefits'] = $this->simulation_model->get_all_benefits();
    // Get featured webinars for CTA links
    $this->load->model('admin/admin_library_model');
    $data['featured_webinars'] = $this->admin_library_model->get_featured_webinars();
    $data['other_capabilities'] = $this->simulation_model->get_other_capabilities();
    $data['category_settings'] = $this->simulation_model->get_capability_category_settings();
    $this->load->view('web/ps_serv_simulation', $data);
  }

   function safetyswitches()
  {
    $data['safety_switches'] = $this->safety_switches_model->get_all_safety_switches();
    $this->load->view('web/products_details', $data);
  }
  function terms_of_service()
  {
    $this->load->model('admin/custom_pages_model');
    $page = $this->custom_pages_model->get_page_by_slug('terms_of_service');
    
    $data['page_title'] = 'Terms of Service';
    $data['page_content'] = $page ? $page->data : '';
    
    $this->load->view('web/custom_page_template', $data);
  }
  
  function cookie_settings()
  {
    $this->load->model('admin/custom_pages_model');
    $page = $this->custom_pages_model->get_page_by_slug('cookie_settings');
    
    $data['page_title'] = 'Cookie Settings';
    $data['page_content'] = $page ? $page->data : '';
    
    $this->load->view('web/custom_page_template', $data);
  }
  
  function cookies_setting()
  {
    // Redirect to cookie_settings for consistency
    redirect('index/cookie_settings');
  }
  
  function privacy_policy()
  {
    $this->load->model('admin/custom_pages_model');
    $page = $this->custom_pages_model->get_page_by_slug('privacy_policy');
    
    $data['page_title'] = 'Privacy Policy';
    $data['page_content'] = $page ? $page->data : '';
    
    $this->load->view('web/custom_page_template', $data);
  }
  function news_events_extension($id = null)
  {
    // If no ID provided, redirect to news_event page
    if (!$id) {
      redirect('index/news_event');
      return;
    }
    
    // Get specific event by ID
    $data['event'] = $this->event_model->get_event_by_id($id);
    
    // If event not found, show 404
    if (!$data['event']) {
      show_404();
      return;
    }
    
    $this->load->view('web/news_events_extension', $data);
  }
  function electroniccounters()
  {
   $this->load->view('web/electronic_counter_details');
  }
  function technical_specs()
  {
   $this->load->view('web/technical_specs');
  }
  function ps_contents($id)
  {
   $this->load->model('web/simulation_model');
   $data['simulation'] = $this->simulation_model->get_content_by_id($id);
   $data['title'] = $data['simulation']->title;
   $this->load->view('web/ps_contents', $data);
  }
  function ps_content_2()
  {
   $this->load->view('web/ps_content_2');
  }
  function ps_content_3()
  {
   $this->load->view('web/ps_content_3');
  }
  function ps_serv()
  {
   $this->load->view('web/ps_serv');
  }
  function timers()
  {
   $this->load->view('web/timer_details');
  }
  function mechanicalcounters()
  {
   $this->load->view('web/mechanical_counter_details');
  }
  function slidelimitcounters()
  {
   $this->load->view('web/slide_limit_counter_details');
  }
  function limitswitches()
  {
   $this->load->view('web/limit_switches_details');
  }
  function lengthcounters()
  {
   $this->load->view('web/length_counter_sensor_details');
  }
  function rotaryencoders()
  {
   $this->load->view('web/rotary_encoders_details');
  }
  function tachometers()
  {
   $this->load->view('web/tachometers_details');
  }
  function thermometers()
  {
   $this->load->view('web/thermometers_details');
  }
  function measuringinstruments()
  {
   $this->load->view('web/measuring_instruments_details');
  }
  function tallycounters()
  {
   $this->load->view('web/tally_counters_details');
  }
  function ss_2()
  {
   $this->load->view('web/ss2_p1_series');
  }
  
  /**
   * Display product item detail page
   */
  public function product_detail($category_id, $item_id)
  {
    $this->load->database();
    $this->load->model('web/Product_page_model');

    $data['product'] = $this->Product_page_model->get_product_by_id($item_id);

    if (!$data['product']) {
        show_404();
        return;
    }

    $data['related_products'] = $this->Product_page_model->get_related_products(
        $data['product']->id,
        $data['product']->product_category,
        3
    );

    $this->load->view('web/product_detail_dynamic', $data);
  }
  
  /**
   * Display category products listing
   */
  
  
  public function update_category($id) {
        // Validate form
        $this->form_validation->set_rules('product_name', 'Product Name', 'required|trim');
        
        if ($this->form_validation->run() === FALSE) {
            $response = [
                'success' => false,
                'message' => validation_errors()
            ];
        } else {
            $data = [
                'product_name' => $this->input->post('product_name'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            // Handle image upload
            if (!empty($_FILES['product_image']['name'])) {
                $upload_result = $this->category_upload_image();
                if ($upload_result['success']) {
                    $data['product_image'] = $upload_result['file_name'];
                    
                    // Delete old image if exists
                    $old_product = $this->products_model->get_product($id);
                    if ($old_product && $old_product->product_image) {
                        $old_image_path = FCPATH . 'assets_system/images/' . $old_product->product_image;
                        if (file_exists($old_image_path)) {
                            unlink($old_image_path);
                        }
                    }
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
    
    private function category_upload_image()
    {
        $config['upload_path'] = FCPATH . 'assets_system/images/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;

        $this->load->library('upload', $config);

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
    
    public function upload_image()
{
    // Verify API key
    $api_key = $this->input->post('api_key');
    if ($api_key != 'YOUR_SECURE_API_KEY') {
        die(json_encode(['status' => 'error', 'message' => 'Invalid API key']));
    }
    
    $filename = $this->input->post('filename');
    $file_data = base64_decode($this->input->post('file'));
    
    // Save to website's assets folder
    $path = FCPATH . 'assets_system/images/' . $filename;
    file_put_contents($path, $file_data);
    
    echo json_encode(['status' => 'success', 'filename' => $filename]);
}

  function search()
  {
    $keyword = $this->input->get('q', TRUE);
    $page = max(1, (int) $this->input->get('page'));

    $data = $this->search_model->search($keyword, $page);
    $data['keyword'] = $keyword;

    $this->load->view('web/search_results', $data);
  }

}
