<?php
/**
 * ==============================================
 * SIMPLIFIED NEWS & EVENTS CONTROLLER METHODS
 * ==============================================
 * 
 * Replace the corresponding methods in your cms.php controller
 * with these simplified versions
 */

// ========================================
// 1. LIST EVENTS
// ========================================

public function news_and_events() {
    // Load model
    $this->load->model('admin/event_model_simplified');
    
    // Get all events
    $data['events'] = $this->event_model_simplified->get_all();
    
    // Load view
    $this->load->view('admin/news_and_events_simplified', $data);
}

// ========================================
// 2. CREATE EVENT - SHOW FORM
// ========================================

public function create_event() {
    $this->load->view('admin/create_event_simplified');
}

// ========================================
// 3. STORE NEW EVENT
// ========================================

public function store() {
    // Load model
    $this->load->model('admin/event_model_simplified');
    
    // Validation rules
    $this->form_validation->set_rules('title', 'Title', 'required|trim');
    $this->form_validation->set_rules('content', 'Content', 'required');
    $this->form_validation->set_rules('category', 'Category', 'required');
    $this->form_validation->set_rules('event_date', 'Event Date', 'required');
    
    if ($this->form_validation->run() === FALSE) {
        $this->create_event();
        return;
    }
    
    // Prepare data
    $data = [
        'title' => $this->input->post('title'),
        'content' => $this->input->post('content'),
        'meta_description' => $this->input->post('meta_description'),
        'category' => $this->input->post('category'),
        'event_date' => $this->input->post('event_date'),
        'badge_text' => $this->input->post('badge_text'),
        'status' => $this->input->post('status') ?: 'active',
        'is_featured' => $this->input->post('is_featured') ? 1 : 0,
        'edited_by' => $this->session->userdata('admin_id') ?: 1
    ];
    
    // Handle image upload
    if (!empty($_FILES['image_file']['name'])) {
        $upload = $this->upload_event_image();
        if ($upload['success']) {
            $data['image'] = $upload['file_name'];
        }
    }
    
    // Create event
    if ($this->event_model_simplified->create($data)) {
        $this->session->set_flashdata('success', 'Event created successfully!');
        redirect('cms/news_and_events');
    } else {
        $this->session->set_flashdata('error', 'Failed to create event.');
        $this->create_event();
    }
}

// ========================================
// 4. EDIT EVENT - SHOW FORM
// ========================================

public function edit_event($id) {
    // Load model
    $this->load->model('admin/event_model_simplified');
    
    // Get event
    $data['event'] = $this->event_model_simplified->get_by_id($id);
    
    if (!$data['event']) {
        $this->session->set_flashdata('error', 'Event not found!');
        redirect('cms/news_and_events');
    }
    
    // Load view
    $this->load->view('admin/edit_event_simplified', $data);
}

// ========================================
// 5. UPDATE EVENT
// ========================================

public function update_event($id) {
    // Load model
    $this->load->model('admin/event_model_simplified');
    
    // Validation
    $this->form_validation->set_rules('title', 'Title', 'required|trim');
    $this->form_validation->set_rules('content', 'Content', 'required');
    $this->form_validation->set_rules('category', 'Category', 'required');
    $this->form_validation->set_rules('event_date', 'Event Date', 'required');
    
    if ($this->form_validation->run() === FALSE) {
        $this->edit_event($id);
        return;
    }
    
    // Prepare data
    $data = [
        'title' => $this->input->post('title'),
        'content' => $this->input->post('content'),
        'meta_description' => $this->input->post('meta_description'),
        'category' => $this->input->post('category'),
        'event_date' => $this->input->post('event_date'),
        'badge_text' => $this->input->post('badge_text'),
        'status' => $this->input->post('status') ?: 'active',
        'is_featured' => $this->input->post('is_featured') ? 1 : 0,
        'edited_by' => $this->session->userdata('admin_id') ?: 1
    ];
    
    // Handle image upload
    if (!empty($_FILES['image_file']['name'])) {
        $upload = $this->upload_event_image();
        if ($upload['success']) {
            // Delete old image
            $old_event = $this->event_model_simplified->get_by_id($id);
            if (!empty($old_event['image'])) {
                $this->delete_event_image($old_event['image']);
            }
            
            $data['image'] = $upload['file_name'];
        }
    }
    
    // Update event
    if ($this->event_model_simplified->update($id, $data)) {
        $this->session->set_flashdata('success', 'Event updated successfully!');
        redirect('cms/news_and_events');
    } else {
        $this->session->set_flashdata('error', 'Failed to update event.');
        $this->edit_event($id);
    }
}

// ========================================
// 6. DELETE EVENT
// ========================================

public function delete_event($id) {
    // Load model
    $this->load->model('admin/event_model_simplified');
    
    // Soft delete
    if ($this->event_model_simplified->delete($id)) {
        $this->session->set_flashdata('success', 'Event deleted successfully!');
    } else {
        $this->session->set_flashdata('error', 'Failed to delete event.');
    }
    
    redirect('cms/news_and_events');
}

// ========================================
// 7. TOGGLE STATUS
// ========================================

public function toggle_status($id) {
    // Load model
    $this->load->model('admin/event_model_simplified');
    
    if ($this->event_model_simplified->toggle_status($id)) {
        $this->session->set_flashdata('success', 'Status updated!');
    } else {
        $this->session->set_flashdata('error', 'Failed to update status.');
    }
    
    redirect('cms/news_and_events');
}

// ========================================
// HELPER: UPLOAD EVENT IMAGE
// ========================================

private function upload_event_image() {
    $config = [
        'upload_path' => FCPATH . 'assets_system/images/',
        'allowed_types' => 'jpg|jpeg|png|gif|webp',
        'max_size' => 2048, // 2MB
        'encrypt_name' => TRUE,
        'remove_spaces' => TRUE
    ];
    
    $this->load->library('upload', $config);
    
    if (!$this->upload->do_upload('image_file')) {
        return [
            'success' => FALSE,
            'error' => $this->upload->display_errors()
        ];
    }
    
    $data = $this->upload->data();
    return [
        'success' => TRUE,
        'file_name' => $data['file_name']
    ];
}

// ========================================
// HELPER: DELETE EVENT IMAGE
// ========================================

private function delete_event_image($filename) {
    $path = FCPATH . 'assets_system/images/' . $filename;
    if (file_exists($path)) {
        return @unlink($path);
    }
    return false;
}
