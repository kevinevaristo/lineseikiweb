<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visit_tracker_model extends CI_Model
{
    /**
     * Track a website visit
     * 
     * @return int|bool Insert ID on success, false on failure
     */
    public function track_visit()
    {
        $visit_data = $this->prepare_visit_data();
        
        if ($this->db->insert('tbl_website_visits', $visit_data)) {
            return $this->db->insert_id();
        }
        
        return false;
    }
    
    /**
     * Prepare visit data from current request
     * 
     * @return array Visit data array
     */
    private function prepare_visit_data()
    {
        $ip = $this->get_ip_address();
        
        $data = array(
            'ip_address' => $ip,
            'user_agent' => $this->input->user_agent(),
            'page_url' => current_url(),
            'referrer' => $this->input->server('HTTP_REFERER') ?: null,
            'visit_date' => date('Y-m-d H:i:s'),
            'session_id' => $this->session->userdata('session_id') ?: session_id()
        );
        
        // Parse user agent for device info
        $this->load->library('user_agent');
        $data['device_type'] = $this->get_device_type();
        $data['browser'] = $this->agent->browser() . ' ' . $this->agent->version();
        $data['os'] = $this->agent->platform();
        
        // Get location from IP address
        $location = $this->get_location_from_ip($ip);
        $data['country'] = $location['country'];
        $data['city'] = $location['city'];
        
        return $data;
    }
    
    /**
     * Resolve visitor's country and city from IP address
     * Uses ip-api.com (free, no API key required)
     *
     * @param string $ip IP address
     * @return array ['country' => ..., 'city' => ...]
     */
    private function get_location_from_ip($ip)
    {
        // Skip lookup for localhost / private ranges
        if (
            empty($ip) ||
            $ip === 'UNKNOWN' ||
            $ip === '127.0.0.1' ||
            $ip === '::1' ||
            preg_match('/^(10\.|172\.(1[6-9]|2[0-9]|3[01])\.|192\.168\.)/', $ip)
        ) {
            return ['country' => 'Local', 'city' => 'Local'];
        }
        
        // Attempt lookup via ip-api.com (free tier, 1 000 req/min)
        $url = 'http://ip-api.com/json/' . urlencode($ip) . '?fields=status,country,city';
        
        $context = stream_context_create([
            'http' => [
                'timeout' => 3,
                'ignore_errors' => true
            ]
        ]);
        
        $response = @file_get_contents($url, false, $context);
        
        if ($response !== false) {
            $geo = json_decode($response, true);
            if (is_array($geo) && isset($geo['status']) && $geo['status'] === 'success') {
                return [
                    'country' => !empty($geo['country']) ? $geo['country'] : 'Unknown',
                    'city'    => !empty($geo['city'])    ? $geo['city']    : 'Unknown'
                ];
            }
        }
        
        return ['country' => 'Unknown', 'city' => 'Unknown'];
    }
    
    /**
     * Get visitor's IP address
     * 
     * @return string IP address
     */
    private function get_ip_address()
    {
        // Check for IP behind proxy
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // Handle multiple IPs (take the first one)
            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($ips[0]);
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED'])) {
            return $_SERVER['HTTP_X_FORWARDED'];
        } elseif (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['HTTP_FORWARDED'])) {
            return $_SERVER['HTTP_FORWARDED'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        }
        
        return 'UNKNOWN';
    }
    
    /**
     * Determine device type from user agent
     * 
     * @return string Device type (Mobile, Tablet, Desktop)
     */
    private function get_device_type()
    {
        if ($this->agent->is_mobile()) {
            return 'Mobile';
        } elseif ($this->agent->is_robot()) {
            return 'Bot';
        }
        
        // Check for tablet indicators
        $user_agent = $this->input->user_agent();
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', $user_agent)) {
            return 'Tablet';
        }
        
        return 'Desktop';
    }
    
    /**
     * Get total visits count
     * 
     * @param string $from_date Optional start date (Y-m-d)
     * @param string $to_date Optional end date (Y-m-d)
     * @return int Total visits
     */
    public function get_total_visits($from_date = null, $to_date = null)
    {
        if ($from_date) {
            $this->db->where('visit_date >=', $from_date . ' 00:00:00');
        }
        if ($to_date) {
            $this->db->where('visit_date <=', $to_date . ' 23:59:59');
        }
        
        return $this->db->count_all_results('tbl_website_visits');
    }
    
    /**
     * Get unique visitors count
     * 
     * @param string $from_date Optional start date (Y-m-d)
     * @param string $to_date Optional end date (Y-m-d)
     * @return int Unique visitors
     */
    public function get_unique_visitors($from_date = null, $to_date = null)
    {
        $this->db->select('COUNT(DISTINCT ip_address) as unique_visitors');
        
        if ($from_date) {
            $this->db->where('visit_date >=', $from_date . ' 00:00:00');
        }
        if ($to_date) {
            $this->db->where('visit_date <=', $to_date . ' 23:59:59');
        }
        
        $result = $this->db->get('tbl_website_visits')->row();
        return $result ? $result->unique_visitors : 0;
    }
    
    /**
     * Get visits by date range (for charts)
     * 
     * @param int $days Number of days to look back
     * @return array Array of dates with visit counts
     */
    public function get_visits_by_date($days = 30)
    {
        $sql = "SELECT DATE(visit_date) as visit_day, 
                       COUNT(*) as total_visits,
                       COUNT(DISTINCT ip_address) as unique_visitors
                FROM tbl_website_visits
                WHERE visit_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
                GROUP BY DATE(visit_date)
                ORDER BY visit_day ASC";
        
        $query = $this->db->query($sql, array($days));
        return $query->result_array();
    }
    
    /**
     * Get top pages visited
     * 
     * @param int $limit Number of results to return
     * @return array Top pages with visit counts
     */
    public function get_top_pages($limit = 10)
    {
        $this->db->select('page_url, COUNT(*) as visit_count');
        $this->db->from('tbl_website_visits');
        $this->db->group_by('page_url');
        $this->db->order_by('visit_count', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result_array();
    }
    
    /**
     * Get device type statistics
     * 
     * @return array Device types with counts
     */
    public function get_device_statistics()
    {
        $this->db->select('device_type, COUNT(*) as count');
        $this->db->from('tbl_website_visits');
        $this->db->where('device_type IS NOT NULL');
        $this->db->group_by('device_type');
        $this->db->order_by('count', 'DESC');
        
        return $this->db->get()->result_array();
    }
    
    /**
     * Get browser statistics
     * 
     * @param int $limit Number of results
     * @return array Browsers with counts
     */
    public function get_browser_statistics($limit = 10)
    {
        $this->db->select('browser, COUNT(*) as count');
        $this->db->from('tbl_website_visits');
        $this->db->where('browser IS NOT NULL');
        $this->db->where('browser !=', '');
        $this->db->group_by('browser');
        $this->db->order_by('count', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result_array();
    }
    
    /**
     * Get referrer statistics
     * 
     * @param int $limit Number of results
     * @return array Referrers with counts
     */
    public function get_referrer_statistics($limit = 10)
    {
        $this->db->select('referrer, COUNT(*) as count');
        $this->db->from('tbl_website_visits');
        $this->db->where('referrer IS NOT NULL');
        $this->db->where('referrer !=', '');
        $this->db->group_by('referrer');
        $this->db->order_by('count', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result_array();
    }
}
