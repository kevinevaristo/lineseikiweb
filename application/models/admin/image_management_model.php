<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image_management_model extends CI_Model {
    
    private $image_path;
    
    public function __construct() {
        parent::__construct();
        $this->image_path = FCPATH . 'assets_system/images/';
    }
    
    /**
     * Get all images from the images folder
     */
    public function get_all_images() {
        $images = [];
        
        if (is_dir($this->image_path)) {
            $files = scandir($this->image_path);
            
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    $file_path = $this->image_path . $file;
                    
                    // Check if it's a file (not directory) and is an image
                    if (is_file($file_path) && $this->is_image_file($file)) {
                        $images[] = [
                            'filename' => $file,
                            'size' => filesize($file_path),
                            'size_formatted' => $this->format_bytes(filesize($file_path)),
                            'modified' => filemtime($file_path),
                            'modified_formatted' => date('Y-m-d H:i:s', filemtime($file_path)),
                            'url' => base_url('assets_system/images/' . $file),
                            'path' => $file_path,
                            'extension' => strtolower(pathinfo($file, PATHINFO_EXTENSION))
                        ];
                    }
                }
            }
        }
        
        // Sort by modified date (newest first)
        usort($images, function($a, $b) {
            return $b['modified'] - $a['modified'];
        });
        
        return $images;
    }
    
    /**
     * Get images used in database
     */
    public function get_used_images() {
        $used_images = [];
        
        // Tables to check based on lineseiki_db.sql structure
        $tables_to_check = [
            'tbl_home_page' => ['image'],
            'tbl_home_carousel' => ['hero_image', 'hero_bg_img'],
            'tbl_about_us' => ['image'],
            'tbl_products' => ['image'],
            'tbl_product_list' => ['product_image'],
            'tbl_simulation' => ['image'],
            'tbl_smuc' => ['image'],
            'tbl_iotsolution' => ['image'],
            'tbl_events' => ['image'],
            'tbl_library' => ['image', 'pdf_file'],
            'tbl_contact_us' => ['image'],
            'tbl_safety_switches' => ['image'],
            'tbl_footer' => ['image'],
            'tbl_partners' => ['partner_logo'],
            'tbl_privacy_policy' => ['image'],
            'tbl_employee_infos' => ['col_imag_path']
        ];
        
        foreach ($tables_to_check as $table => $columns) {
            // Check if table exists
            if (!$this->db->table_exists($table)) {
                continue;
            }
            
            foreach ($columns as $column) {
                // Check if column exists in table
                if (!$this->db->field_exists($column, $table)) {
                    continue;
                }
                
                $this->db->select($column);
                $this->db->from($table);
                $this->db->where("$column IS NOT NULL");
                $this->db->where("$column !=", '');
                
                try {
                    $query = $this->db->get();
                    
                    if ($query && $query->num_rows() > 0) {
                        foreach ($query->result_array() as $row) {
                            if (!empty($row[$column])) {
                                // Extract just the filename from path or URL
                                $image_name = basename($row[$column]);
                                if (!in_array($image_name, $used_images)) {
                                    $used_images[] = $image_name;
                                }
                            }
                        }
                    }
                } catch (Exception $e) {
                    // Skip if there's an error with this table/column
                    continue;
                }
            }
        }
        
        return array_unique($used_images);
    }
    
    /**
     * Get unused images
     */
    public function get_unused_images() {
        $all_images = $this->get_all_images();
        $used_images = $this->get_used_images();
        
        $unused = [];
        foreach ($all_images as $image) {
            if (!in_array($image['filename'], $used_images)) {
                $unused[] = $image;
            }
        }
        
        return $unused;
    }
    
    /**
     * Get image usage details
     */
    public function get_image_usage($filename) {
        $usage = [];
        
        // Tables and their reference columns
        $tables_to_check = [
            'tbl_home_page' => [
                'image_columns' => ['image'],
                'reference_column' => 'title'
            ],
            'tbl_home_carousel' => [
                'image_columns' => ['hero_image', 'hero_bg_img'],
                'reference_column' => 'hero_text'
            ],
            'tbl_about_us' => [
                'image_columns' => ['image'],
                'reference_column' => 'title'
            ],
            'tbl_products' => [
                'image_columns' => ['image'],
                'reference_column' => 'title'
            ],
            'tbl_product_list' => [
                'image_columns' => ['product_image'],
                'reference_column' => 'product_name'
            ],
            'tbl_simulation' => [
                'image_columns' => ['image'],
                'reference_column' => 'title'
            ],
            'tbl_smuc' => [
                'image_columns' => ['image'],
                'reference_column' => 'title'
            ],
            'tbl_iotsolution' => [
                'image_columns' => ['image'],
                'reference_column' => 'title'
            ],
            'tbl_events' => [
                'image_columns' => ['image'],
                'reference_column' => 'title'
            ],
            'tbl_library' => [
                'image_columns' => ['image', 'pdf_file'],
                'reference_column' => 'title'
            ],
            'tbl_contact_us' => [
                'image_columns' => ['image'],
                'reference_column' => 'title'
            ],
            'tbl_safety_switches' => [
                'image_columns' => ['image'],
                'reference_column' => 'title'
            ],
            'tbl_footer' => [
                'image_columns' => ['image'],
                'reference_column' => 'title'
            ],
            'tbl_partners' => [
                'image_columns' => ['partner_logo'],
                'reference_column' => 'partner_name'
            ],
            'tbl_privacy_policy' => [
                'image_columns' => ['image'],
                'reference_column' => 'title'
            ],
            'tbl_employee_infos' => [
                'image_columns' => ['col_imag_path'],
                'reference_column' => 'col_user_name'
            ]
        ];
        
        foreach ($tables_to_check as $table => $config) {
            // Check if table exists
            if (!$this->db->table_exists($table)) {
                continue;
            }
            
            $reference_column = $config['reference_column'];
            
            // Check if reference column exists
            if (!$this->db->field_exists($reference_column, $table)) {
                $reference_column = 'id'; // Fallback to id
            }
            
            foreach ($config['image_columns'] as $image_column) {
                // Check if column exists
                if (!$this->db->field_exists($image_column, $table)) {
                    continue;
                }
                
                try {
                    $this->db->select("id, $reference_column as reference, '$image_column' as image_field");
                    $this->db->from($table);
                    $this->db->like($image_column, $filename);
                    $query = $this->db->get();
                    
                    if ($query && $query->num_rows() > 0) {
                        foreach ($query->result_array() as $row) {
                            $usage[] = [
                                'table' => $table,
                                'id' => $row['id'],
                                'reference' => $row['reference'] ?? 'ID: ' . $row['id'],
                                'field' => $image_column
                            ];
                        }
                    }
                } catch (Exception $e) {
                    // Skip if there's an error
                    continue;
                }
            }
        }
        
        return $usage;
    }
    
    /**
     * Delete image file
     */
    public function delete_image($filename) {
        $file_path = $this->image_path . $filename;
        
        if (file_exists($file_path) && is_file($file_path)) {
            return unlink($file_path);
        }
        
        return false;
    }
    
    /**
     * Delete multiple images
     */
    public function delete_multiple_images($filenames) {
        $deleted = 0;
        $failed = 0;
        
        foreach ($filenames as $filename) {
            if ($this->delete_image($filename)) {
                $deleted++;
            } else {
                $failed++;
            }
        }
        
        return [
            'deleted' => $deleted,
            'failed' => $failed
        ];
    }
    
    /**
     * Get statistics
     */
    public function get_statistics() {
        $all_images = $this->get_all_images();
        $used_images = $this->get_used_images();
        $unused_images = $this->get_unused_images();
        
        $total_size = 0;
        foreach ($all_images as $image) {
            $total_size += $image['size'];
        }
        
        $unused_size = 0;
        foreach ($unused_images as $image) {
            $unused_size += $image['size'];
        }
        
        return [
            'total_images' => count($all_images),
            'used_images' => count($used_images),
            'unused_images' => count($unused_images),
            'total_size' => $total_size,
            'total_size_formatted' => $this->format_bytes($total_size),
            'unused_size' => $unused_size,
            'unused_size_formatted' => $this->format_bytes($unused_size),
            'usage_percentage' => count($all_images) > 0 ? round((count($used_images) / count($all_images)) * 100, 1) : 0
        ];
    }
    
    /**
     * Check if file is an image
     */
    private function is_image_file($filename) {
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'ico'];
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return in_array($extension, $allowed_extensions);
    }
    
    /**
     * Format bytes to human readable format
     */
    private function format_bytes($bytes, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
