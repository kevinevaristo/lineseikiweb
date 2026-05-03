<?php
class Video_model extends CI_Model {
    
    public function get_video_submissions() {
        return $this->db->select('id, full_name, email, contact_number, position, company, video_title, submitted_at')
                       ->order_by('submitted_at', 'DESC')
                       ->get('tbl_watch_info')
                       ->result();
    }
    
    public function get_total_submissions() {
        return $this->db->count_all('tbl_watch_info');
    }
    
    public function get_today_submissions() {
        $today = date('Y-m-d');
        return $this->db->where('DATE(submitted_at)', $today)
                       ->count_all_results('tbl_watch_info');
    }
    
    public function get_count_by_type($type) {
        return $this->db->where('resource_type', $type)
                       ->count_all_results('tbl_watch_info');
    }
    
    // Optional: Get video title statistics
    public function get_video_title_stats() {
        $this->db->select('video_title, COUNT(*) as count')
                ->from('tbl_watch_info')
                ->where('video_title IS NOT NULL')
                ->where('video_title !=', '')
                ->group_by('video_title')
                ->order_by('count', 'DESC')
                ->limit(10);
        return $this->db->get()->result();
    }
}
?>