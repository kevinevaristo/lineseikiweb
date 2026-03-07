<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class home_page_model extends CI_Model

{

    protected $table = 'tbl_home_page';
    protected $table1 = 'tbl_home_carousel';

    

    public function __construct()

    {

        parent::__construct();

        $this->load->database();

    }

    

    /**

     * Get all home page content as key-value pairs

     */
    public function get_all_slides() {
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get($this->table1);
        
        return $query->result_array();
    }
    
   
    public function get_homepage_slides() {
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get($this->table1);
        
        return $query->result_array();
    }

    public function get_new_product()
    {
        return $this->db
            ->where('is_new', 1)
            ->limit(1)
            ->get('tbl_product_items')
            ->row(); // single row
    }

    public function get_home_content()

    {

        $query = $this->db->get($this->table);

        $result = $query->result_array();

        

        // Convert the flat result into a key-value pair array

        $content = array();

        foreach ($result as $row) {

            $content[$row['title']] = array(

                'id'      => $row['id'],

                'content' => $row['content'],

                'image'   => $row['image']

            );

        }

        return $content;

    }

    

    /**

     * Get content by specific title/key

     */

    public function get_by_title($title)

    {

        $this->db->where('title', $title);

        $query = $this->db->get($this->table);

        return $query->row_array();

    }

    

    /**

     * Get multiple content items by partial title match

     */

    public function get_by_title_like($like_pattern)

    {

        $this->db->like('title', $like_pattern, 'both');

        $this->db->order_by('id', 'ASC');

        $query = $this->db->get($this->table);

        return $query->result_array();

    }

    

    /**

     * Get structured hero section data

     */

    public function get_hero_data()

    {

        $content = $this->get_home_content();

        $hero_data = array();

        

        // Text content

        $hero_data['text'] = isset($content['hero_text']['content']) ? $content['hero_text']['content'] : 'Precision You Can Trust';

        $hero_data['sub_text'] = isset($content['hero_sub_text']['content']) ? $content['hero_sub_text']['content'] : 'Default subtext';

        

        // Carousel slides

        $hero_data['slides'] = array();

        for ($i = 1; $i <= 4; $i++) {

            $slide = array(

                'image' => '',

                'bg_image' => ''

            );

            

            // Get foreground image

            if (isset($content["hero_image_$i"]['image'])) {

                $slide['image'] = $content["hero_image_$i"]['image'];

            }

            

            // Get background image

            if (isset($content["hero_bg_img_$i"]['image'])) {

                $slide['bg_image'] = $content["hero_bg_img_$i"]['image'];

            }

            

            $hero_data['slides'][] = $slide;

        }

        

        return $hero_data;

    }

    

    /**

     * Get structured legacy products data

     */

    public function get_legacy_products_data()

    {

        $content = $this->get_home_content();

        $legacy_data = array();

        

        // Main legacy content

        $legacy_data['trusted_badge'] = isset($content['trusted_badge']['content']) ? $content['trusted_badge']['content'] : 'Trusted Since 1953';

        $legacy_data['legacy_header'] = isset($content['legacy_header']['content']) ? $content['legacy_header']['content'] : 'Our Proven Line of Counting and Measuring Instruments';

        $legacy_data['legacy_text'] = isset($content['legacy_text']['content']) ? $content['legacy_text']['content'] : 'For over 70 years...';

        $legacy_data['timeline_years'] = isset($content['timeline_years']['content']) ? $content['timeline_years']['content'] : '70+';

        $legacy_data['timeline_label'] = isset($content['timeline_label']['content']) ? $content['timeline_label']['content'] : 'Years of Excellence';

        

        // Categories

        $legacy_data['categories'] = array();

        for ($i = 1; $i <= 4; $i++) {

            if (isset($content["category_title_$i"]) && isset($content["category_text_$i"])) {

                $legacy_data['categories'][] = array(

                    'title' => $content["category_title_$i"]['content'],

                    'text' => $content["category_text_$i"]['content']

                );

            }

        }

        

        // Statistics

        $legacy_data['stats'] = array();

        for ($i = 1; $i <= 4; $i++) {

            if (isset($content["stat_number_$i"]) && isset($content["stat_label_$i"])) {

                $legacy_data['stats'][] = array(

                    'number' => $content["stat_number_$i"]['content'],

                    'label' => $content["stat_label_$i"]['content']

                );

            }

        }

        

        return $legacy_data;

    }
    
    public function get_categories() {
        $this->db->order_by('id', 'ASC');
        return $this->db->get('tbl_card_categories')->result_array();
    }
    
    public function get_stats() {
        $this->db->order_by('id', 'ASC');
        return $this->db->get('tbl_key_stats')->result_array();
    }

    

    /**

     * Get structured services data

     */

    public function get_services_data()

    {

        $content = $this->get_home_content();

        $services_data = array();

        

        // Services header

        $services_data['tagline'] = isset($content['serv_tagline']['content']) ? $content['serv_tagline']['content'] : 'Beyond Measurement — We Engineer Possibilities';

        

        // Services

        $services_data['services'] = array();

        for ($i = 1; $i <= 3; $i++) {

            $service = array();

            

            // Basic fields

            $fields = array(

                'featured_badge' => "feat_badge_$i",

                'badge' => "serv_badge_$i",

                'title' => "serv_title_$i",

                'description' => "serv_desc_$i",

                'link_label' => "serv_link_label_$i",

                'image' => "serv_image_$i"

            );

            

            foreach ($fields as $key => $field) {

                if (isset($content[$field])) {

                    $service[$key] = !empty($content[$field]['content']) ? $content[$field]['content'] : $content[$field]['image'];

                }

            }

            

            // Features

            $service['features'] = array();

            if ($i == 1) {

                for ($j = 1; $j <= 4; $j++) {

                    if (isset($content["serv_feat_$j"]['content'])) {

                        $service['features'][] = $content["serv_feat_$j"]['content'];

                    }

                }

            } else {

                for ($j = 1; $j <= 4; $j++) {

                    $field = "serv_feat_{$i}_$j";

                    if (isset($content[$field]['content'])) {

                        $service['features'][] = $content[$field]['content'];

                    }

                }

            }

            

            $services_data['services'][] = $service;

        }

        

        // Background image

        $services_data['bg_image'] = isset($content['serv_bg_img']['image']) ? $content['serv_bg_img']['image'] : 'simulation2.jpg';

        

        return $services_data;

    }

    

    /**

     * Get structured new products data

     */

    public function get_new_products_data()

    {

        $content = $this->get_home_content();

        $new_products_data = array();

        

        // Main fields

        $main_fields = array(

            'badge' => 'new_badge',

            'header' => 'new_product_header',

            'text' => 'new_product_text',

            'button' => 'new_product_button',

            'image' => 'new_product_image'

        );

        

        foreach ($main_fields as $key => $field) {

            if (isset($content[$field])) {

                $new_products_data[$key] = !empty($content[$field]['content']) ? $content[$field]['content'] : $content[$field]['image'];

            }

        }

        

        // Features

        $new_products_data['features'] = array();

        for ($i = 1; $i <= 4; $i++) {

            if (isset($content["new_prod_feat_$i"]['content'])) {

                $feature = array(

                    'title' => $content["new_prod_feat_$i"]['content'],

                    'image' => isset($content["feat_image_$i"]['image']) ? $content["feat_image_$i"]['image'] : ''

                );

                $new_products_data['features'][] = $feature;

            }

        }

        

        return $new_products_data;

    }

    

    /**

     * Update content by title/key

     */

    public function update_content($title, $data, $user_id = null)

    {

        $existing = $this->get_by_title($title);

        

        if ($existing) {

            // Update existing

            $update_data = array(

                'content' => $data['content'] ?? '',

                'edited_by' => $user_id,

                'updated_at' => date('Y-m-d H:i:s')

            );

            

            if (isset($data['image'])) {

                $update_data['image'] = $data['image'];

            }

            

            $this->db->where('id', $existing['id']);

            return $this->db->update($this->table, $update_data);

        } else {

            // Create new

            $insert_data = array(

                'title' => $title,

                'content' => $data['content'] ?? '',

                'edited_by' => $user_id,

                'created_at' => date('Y-m-d H:i:s'),

                'updated_at' => date('Y-m-d H:i:s')

            );

            

            if (isset($data['image'])) {

                $insert_data['image'] = $data['image'];

            }

            

            return $this->db->insert($this->table, $insert_data);

        }

    }

    

    /**

     * Update content by ID

     */

    public function update_by_id($id, $data)

    {

        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);

        return $this->db->update($this->table, $data);

    }

    

    /**

     * Get all content for CMS table view

     */

    public function get_content_for_cms($search = null, $limit = null, $offset = 0)

    {

        if ($search) {

            $this->db->group_start();

            $this->db->like('title', $search);

            $this->db->or_like('content', $search);

            $this->db->group_end();

        }

        

        $this->db->order_by('title', 'ASC');

        

        if ($limit) {

            $this->db->limit($limit, $offset);

        }

        

        $query = $this->db->get($this->table);

        return $query->result_array();

    }

    

    /**

     * Count total content items

     */

    public function count_content($search = null)

    {

        if ($search) {

            $this->db->group_start();

            $this->db->like('title', $search);

            $this->db->or_like('content', $search);

            $this->db->group_end();

        }

        

        return $this->db->count_all_results($this->table);

    }

    

    /**

     * Get content by ID

     */

    public function get_by_id($id)

    {

        $this->db->where('id', $id);

        $query = $this->db->get($this->table);

        return $query->row_array();

    }

    

    /**

     * Delete content by ID

     */

    public function delete_by_id($id)

    {

        $this->db->where('id', $id);

        return $this->db->delete($this->table);

    }

    

    /**

     * Create new content

     */

    public function create_content($data)

    {

        $data['created_at'] = date('Y-m-d H:i:s');

        $data['updated_at'] = date('Y-m-d H:i:s');

        return $this->db->insert($this->table, $data);

    }

}