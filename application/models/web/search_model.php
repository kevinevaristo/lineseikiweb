<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Search_model extends CI_Model
{
    private $per_page = 10;

    /**
     * Search across all website content tables.
     * Returns paginated results with page name, snippet, and URL.
     */
    public function search($keyword, $page = 1)
    {
        $keyword = trim($keyword);
        if (empty($keyword)) {
            return array('results' => array(), 'total' => 0, 'per_page' => $this->per_page, 'current_page' => 1, 'total_pages' => 0);
        }

        $escaped = $this->db->escape_like_str($keyword);
        $all_results = array();

        // 1. Products (tbl_product_items)
        $this->db->select('product_name, short_description, description, slug');
        $this->db->from('tbl_product_items');
        $this->db->where("(product_name LIKE '%{$escaped}%' OR series_name LIKE '%{$escaped}%' OR description LIKE '%{$escaped}%' OR short_description LIKE '%{$escaped}%' OR tags LIKE '%{$escaped}%' OR model_number LIKE '%{$escaped}%')");
        $products = $this->db->get()->result_array();

        foreach ($products as $row) {
            $all_results[] = array(
                'page_name' => 'Product: ' . $row['product_name'],
                'snippet'   => $this->generate_snippet($row['short_description'] ? $row['short_description'] : $row['description'], $keyword),
                'url'       => 'index/product/' . $row['slug']
            );
        }

        // 2. Product Categories (tbl_products)
        $this->db->select('title, content');
        $this->db->from('tbl_products');
        $this->db->where("(title LIKE '%{$escaped}%' OR content LIKE '%{$escaped}%')");
        $categories = $this->db->get()->result_array();

        foreach ($categories as $row) {
            $all_results[] = array(
                'page_name' => 'Products: ' . $row['title'],
                'snippet'   => $this->generate_snippet($row['content'], $keyword),
                'url'       => 'index/ps_prod'
            );
        }

        // 3. Events (tbl_events)
        $this->db->select('id, title, content, meta_description, category');
        $this->db->from('tbl_events');
        $this->db->where('status', 'active');
        $this->db->where("(title LIKE '%{$escaped}%' OR content LIKE '%{$escaped}%' OR meta_description LIKE '%{$escaped}%')");
        $events = $this->db->get()->result_array();

        foreach ($events as $row) {
            $all_results[] = array(
                'page_name' => 'News & Events: ' . $row['title'],
                'snippet'   => $this->generate_snippet($row['meta_description'] ? $row['meta_description'] : $row['content'], $keyword),
                'url'       => 'index/news_events_extension/' . $row['id']
            );
        }

        // 4. Library (tbl_library)
        $this->db->select('title, content, resource_type');
        $this->db->from('tbl_library');
        $this->db->where("(title LIKE '%{$escaped}%' OR content LIKE '%{$escaped}%')");
        $library = $this->db->get()->result_array();

        foreach ($library as $row) {
            $all_results[] = array(
                'page_name' => 'Library: ' . $row['title'],
                'snippet'   => $this->generate_snippet($row['content'], $keyword),
                'url'       => 'index/library'
            );
        }

        // 5. About Us (tbl_about_us)
        $this->db->select('title, content');
        $this->db->from('tbl_about_us');
        $this->db->where("(title LIKE '%{$escaped}%' OR content LIKE '%{$escaped}%')");
        $about = $this->db->get()->result_array();

        foreach ($about as $row) {
            $all_results[] = array(
                'page_name' => 'About Us',
                'snippet'   => $this->generate_snippet($row['content'], $keyword),
                'url'       => 'index/about_us'
            );
        }

        // 6. IoT Solution (tbl_iotsolution)
        $this->db->select('title, content');
        $this->db->from('tbl_iotsolution');
        $this->db->where("(title LIKE '%{$escaped}%' OR content LIKE '%{$escaped}%')");
        $iot = $this->db->get()->result_array();

        foreach ($iot as $row) {
            $all_results[] = array(
                'page_name' => 'IoT Solution',
                'snippet'   => $this->generate_snippet($row['content'], $keyword),
                'url'       => 'index/ps_iotsolution'
            );
        }

        // 7. Simulation (tbl_simulation)
        $this->db->select('title, content');
        $this->db->from('tbl_simulation');
        $this->db->where("(title LIKE '%{$escaped}%' OR content LIKE '%{$escaped}%')");
        $sim = $this->db->get()->result_array();

        foreach ($sim as $row) {
            $all_results[] = array(
                'page_name' => 'Simulation Analysis',
                'snippet'   => $this->generate_snippet($row['content'], $keyword),
                'url'       => 'index/ps_serv_simulation'
            );
        }

        // 8. Silicone / SMUC (tbl_smuc)
        $this->db->select('title, content');
        $this->db->from('tbl_smuc');
        $this->db->where("(title LIKE '%{$escaped}%' OR content LIKE '%{$escaped}%')");
        $smuc = $this->db->get()->result_array();

        foreach ($smuc as $row) {
            $all_results[] = array(
                'page_name' => 'Silicone Molding & Urethane Casting',
                'snippet'   => $this->generate_snippet($row['content'], $keyword),
                'url'       => 'index/ps_serv_silicone'
            );
        }

        // 9. Contact Us (tbl_contact_us)
        $this->db->select('title, content');
        $this->db->from('tbl_contact_us');
        $this->db->where("(title LIKE '%{$escaped}%' OR content LIKE '%{$escaped}%')");
        $contact = $this->db->get()->result_array();

        foreach ($contact as $row) {
            $all_results[] = array(
                'page_name' => 'Contact Us',
                'snippet'   => $this->generate_snippet($row['content'], $keyword),
                'url'       => 'index/contact_us'
            );
        }

        // Paginate
        $total = count($all_results);
        $total_pages = ($total > 0) ? ceil($total / $this->per_page) : 0;
        $offset = ($page - 1) * $this->per_page;
        $paged_results = array_slice($all_results, $offset, $this->per_page);

        return array(
            'results'      => $paged_results,
            'total'        => $total,
            'per_page'     => $this->per_page,
            'current_page' => $page,
            'total_pages'  => $total_pages
        );
    }

    /**
     * Generate a text snippet around the keyword match, with highlighted keyword.
     */
    private function generate_snippet($text, $keyword, $radius = 80)
    {
        if (empty($text)) {
            return '';
        }

        // Strip HTML tags
        $text = strip_tags($text);
        // Decode HTML entities
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        // Normalize whitespace
        $text = preg_replace('/\s+/', ' ', trim($text));

        $pos = mb_stripos($text, $keyword);

        if ($pos === false) {
            // Keyword not found in this field, return start of text
            $snippet = mb_substr($text, 0, $radius * 2);
            return (mb_strlen($text) > $radius * 2) ? $snippet . '...' : $snippet;
        }

        $start = max(0, $pos - $radius);
        $length = mb_strlen($keyword) + ($radius * 2);
        $snippet = mb_substr($text, $start, $length);

        // Add ellipsis
        if ($start > 0) {
            $snippet = '...' . $snippet;
        }
        if ($start + $length < mb_strlen($text)) {
            $snippet .= '...';
        }

        // Highlight keyword (case-insensitive)
        $snippet = preg_replace('/(' . preg_quote($keyword, '/') . ')/i', '<mark>$1</mark>', $snippet);

        return $snippet;
    }
}
