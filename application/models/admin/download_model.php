<?php
class Download_model extends CI_Model {
    
    public function get_download_submissions() {
        return $this->db->select('id, full_name, email, position, company, file_name, downloaded_at')
                       ->order_by('downloaded_at', 'DESC')
                       ->get('tbl_download_info')
                       ->result();
    }
    
    public function get_total_downloads() {
        return $this->db->count_all('tbl_download_info');
    }
    
    public function get_today_downloads() {
        $today = date('Y-m-d');
        return $this->db->where('DATE(downloaded_at)', $today)
                       ->count_all_results('tbl_download_info');
    }
    
    public function get_unique_files_count() {
        return $this->db->distinct()
                       ->select('file_name')
                       ->where('file_name IS NOT NULL')
                       ->where('file_name !=', '')
                       ->count_all_results('tbl_download_info');
    }
    
    public function get_top_downloaded_files($limit = 5) {
        $this->db->select('file_name, COUNT(*) as download_count')
                ->from('tbl_download_info')
                ->where('file_name IS NOT NULL')
                ->where('file_name !=', '')
                ->group_by('file_name')
                ->order_by('download_count', 'DESC')
                ->limit($limit);
        return $this->db->get()->result();
    }
    
    public function get_downloads_by_hour() {
        $this->db->select("HOUR(downloaded_at) as hour, COUNT(*) as count")
                ->from('tbl_download_info')
                ->group_by("HOUR(downloaded_at)")
                ->order_by("hour");
        return $this->db->get()->result();
    }
}
?>