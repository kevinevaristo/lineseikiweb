<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get total visitor count from tbl_website_visits
     */
    public function get_total_visitors()
    {
        return $this->db->count_all('tbl_website_visits');
    }
    
    /**
     * Get unique visitors count
     */
    public function get_unique_visitors()
    {
        $this->db->select('COUNT(DISTINCT ip_address) as unique_count');
        $result = $this->db->get('tbl_website_visits')->row();
        return $result ? $result->unique_count : 0;
    }
    
    /**
     * Get today's visitor count from tbl_website_visits
     */
    public function get_today_visitors()
    {
        $today = date('Y-m-d');
        $this->db->where('DATE(visit_date)', $today);
        return $this->db->count_all_results('tbl_website_visits');
    }
    
    /**
     * Get visitor data for last N days from tbl_website_visits
     */
    public function get_visitor_trend($days = 30)
    {
        $sql = "SELECT DATE(visit_date) as date, 
                       COUNT(*) as count,
                       COUNT(DISTINCT ip_address) as unique_visitors
                FROM tbl_website_visits
                WHERE visit_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
                GROUP BY DATE(visit_date)
                ORDER BY date ASC";
        
        $query = $this->db->query($sql, array($days));
        return $query->result_array();
    }
    
    /**
     * Get device type statistics
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
     */
public function get_browser_statistics($limit = 5)
{
    // Kunin muna lahat ng data
    $this->db->select('browser');
    $this->db->from('tbl_website_visits');
    $this->db->where('browser IS NOT NULL');
    $this->db->where('browser !=', '');
    $query = $this->db->get();
    $results = $query->result_array();
    
    // Process manually sa PHP
    $browser_counts = [];
    
    foreach ($results as $row) {
        $browser = $row['browser'];
        
        // Simplify browser name
        if (strpos($browser, 'Chrome') !== false) {
            $browser_name = 'Chrome';
        } elseif (strpos($browser, 'Firefox') !== false) {
            $browser_name = 'Firefox';
        } elseif (strpos($browser, 'Safari') !== false && strpos($browser, 'Chrome') === false) {
            $browser_name = 'Safari';
        } elseif (strpos($browser, 'Edg') !== false) {
            $browser_name = 'Edge';
        } elseif (strpos($browser, 'Opera') !== false || strpos($browser, 'OPR') !== false) {
            $browser_name = 'Opera';
        } elseif (strpos($browser, 'MSIE') !== false || strpos($browser, 'Trident') !== false) {
            $browser_name = 'Internet Explorer';
        } else {
            // Kunin lang ang unang salita
            $browser_name = explode(' ', trim($browser))[0];
        }
        
        // Count
        if (!isset($browser_counts[$browser_name])) {
            $browser_counts[$browser_name] = 0;
        }
        $browser_counts[$browser_name]++;
    }
    
    // Sort at limit
    arsort($browser_counts);
    $browser_counts = array_slice($browser_counts, 0, $limit, true);
    
    // Format para sa result_array
    $result = [];
    foreach ($browser_counts as $browser => $count) {
        $result[] = [
            'browser' => $browser,
            'count' => (string)$count
        ];
    }
    
    return $result;
}
    
    /**
     * Get top pages visited
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
     * Get referrer statistics
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
    
    /**
     * Get top countries by visit count
     */
    public function get_location_statistics($limit = 10)
    {
        $this->db->select('country, COUNT(*) as count');
        $this->db->from('tbl_website_visits');
        $this->db->where('country IS NOT NULL');
        $this->db->where('country !=', '');
        $this->db->where('country !=', 'Unknown');
        $this->db->group_by('country');
        $this->db->order_by('count', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result_array();
    }
    
    /**
     * Get top cities by visit count
     */
    public function get_city_statistics($limit = 10)
    {
        $this->db->select('city, country, COUNT(*) as count');
        $this->db->from('tbl_website_visits');
        $this->db->where('city IS NOT NULL');
        $this->db->where('city !=', '');
        $this->db->where('city !=', 'Unknown');
        $this->db->group_by('city');
        $this->db->order_by('count', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result_array();
    }
    
    /**
     * Get total number of unique countries
     */
    public function get_total_countries()
    {
        $this->db->select('COUNT(DISTINCT country) as total');
        $this->db->from('tbl_website_visits');
        $this->db->where('country IS NOT NULL');
        $this->db->where('country !=', '');
        $this->db->where('country !=', 'Unknown');
        $result = $this->db->get()->row();
        return $result ? (int) $result->total : 0;
    }
    
    /**
     * Get last content update timestamp
     */
    public function get_last_update()
    {
        // Check multiple tables for the most recent update
        $tables = [
            'tbl_home_page',
            'tbl_about_us',
            'tbl_products',
            'tbl_event'
        ];
        
        $latest = null;
        
        foreach ($tables as $table) {
            if ($this->db->table_exists($table)) {
                $this->db->select_max('updated_at');
                $query = $this->db->get($table);
                $result = $query->row();
                
                if ($result && $result->updated_at) {
                    if (!$latest || strtotime($result->updated_at) > strtotime($latest)) {
                        $latest = $result->updated_at;
                    }
                }
            }
        }
        
        return $latest;
    }
    
    /**
     * Get time ago format
     */
    public function time_ago($datetime)
    {
        if (!$datetime) return 'Never';
        
        $time = strtotime($datetime);
        $diff = time() - $time;
        
        if ($diff < 60) {
            return 'Just now';
        } elseif ($diff < 3600) {
            $mins = floor($diff / 60);
            return $mins . ' minute' . ($mins > 1 ? 's' : '') . ' ago';
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
        } elseif ($diff < 604800) {
            $days = floor($diff / 86400);
            return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
        } else {
            return date('M d, Y', $time);
        }
    }
    
    /**
     * Get statistics summary
     */
    public function get_statistics_summary()
    {
        return [
            'total_visitors'  => $this->get_total_visitors(),
            'unique_visitors' => $this->get_unique_visitors(),
            'today_visitors'  => $this->get_today_visitors(),
            'last_update'     => $this->time_ago($this->get_last_update()),
            'visitor_trend'   => $this->get_visitor_trend(30),
            'device_stats'    => $this->get_device_statistics(),
            'browser_stats'   => $this->get_browser_statistics(),
            'top_pages'       => $this->get_top_pages(),
            'referrer_stats'  => $this->get_referrer_statistics(),
            'location_stats'  => $this->get_location_statistics(10),
            'city_stats'      => $this->get_city_statistics(10),
            'total_countries' => $this->get_total_countries(),
        ];
    }
}
