# Dynamic Product Detail Page Implementation Guide

This guide explains how to make the product detail pages fully dynamic using data from `tbl_product_items`.

## 📋 Overview

Based on the Line Seiki reference page (SS2-P-1 series), we're implementing a comprehensive dynamic product detail page with:

- Product hero section with image and details
- YouTube video embedding
- Dynamic models table
- Dynamic specifications table
- Download section with multiple catalog links
- Related applications/cases section
- Related products carousel
- Fully responsive design

## 🗄️ Database Changes

### Step 1: Run the Database Update

Execute the SQL file provided in the artifact `db_product_items_update.sql`.

This adds the following columns to `tbl_product_items`:

- `youtube_video_id` - YouTube video ID for product demo
- `models_data` - JSON array for models table
- `specifications_data` - JSON array for specifications
- `downloads_data` - JSON array for download links  
- `applications_data` - JSON array for application cases
- `related_products` - Comma-separated product IDs

## 📁 Files to Update

### 1. Model: `application/models/web/Product_page_model.php`

If this file doesn't exist, create it:

```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_page_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get product by slug with category information
     */
    public function get_product_by_slug($slug)
    {
        $this->db->select('
            pi.*,
            pc.category_name,
            pc.slug as category_slug,
            pt.type_name,
            pt.slug as type_slug
        ');
        $this->db->from('tbl_product_items pi');
        $this->db->join('tbl_product_category pc', 'pi.product_category = pc.id', 'left');
        $this->db->join('tbl_product_types pt', 'pi.product_type = pt.id', 'left');
        $this->db->where('pi.slug', $slug);
        $this->db->where('pi.is_active', 1);
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $product = $query->row();
            
            // Decode JSON fields
            if (!empty($product->models_data)) {
                $product->models = json_decode($product->models_data, true);
            }
            
            if (!empty($product->specifications_data)) {
                $product->specifications_table = json_decode($product->specifications_data, true);
            }
            
            if (!empty($product->downloads_data)) {
                $product->downloads = json_decode($product->downloads_data, true);
            }
            
            if (!empty($product->applications_data)) {
                $product->applications_list = json_decode($product->applications_data, true);
            }
            
            // Convert tags to array
            if (!empty($product->tags)) {
                $product->tags_array = array_map('trim', explode(',', $product->tags));
            } else {
                $product->tags_array = [];
            }
            
            // Convert features to array (newline-separated)
            if (!empty($product->features)) {
                $product->features_array = array_filter(array_map('trim', explode("\n", $product->features)));
            } else {
                $product->features_array = [];
            }
            
            return $product;
        }
        
        return null;
    }
    
    /**
     * Get related products (same category, different ID)
     */
    public function get_related_products($product_id, $category_id, $limit = 3)
    {
        $this->db->select('id, product_name, slug, product_image, short_description, description');
        $this->db->from('tbl_product_items');
        $this->db->where('product_category', $category_id);
        $this->db->where('id !=', $product_id);
        $this->db->where('is_active', 1);
        $this->db->order_by('RAND()');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }
    
    /**
     * Get product by ID
     */
    public function get_product_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->where('is_active', 1);
        return $this->db->get('tbl_product_items')->row();
    }
}
```

### 2. Controller: Update `application/controllers/index.php`

Add this method to handle the product detail route:

```php
/**
 * Product Detail Page
 * URL: /product/{slug}
 */
public function product($slug)
{
    // Load model
    $this->load->model('web/Product_page_model');
    
    // Get product by slug
    $product = $this->Product_page_model->get_product_by_slug($slug);
    
    // Check if product exists
    if (!$product) {
        show_404();
        return;
    }
    
    // Get related products
    $data['related_products'] = $this->Product_page_model->get_related_products(
        $product->id,
        $product->product_category,
        3
    );
    
    // Pass product to view
    $data['product'] = $product;
    $data['page_title'] = $product->meta_title ?: ($product->product_name . ' - Line Seiki Asia Pacific');
    
    // Load view
    $this->load->view('web/product_detail', $data);
}
```

### 3. Routes: Update `application/config/routes.php`

Add this route:

```php
// Product detail route
$route['product/(:any)'] = 'index/product/$1';
```

## 🎨 View Files

The main view file has already been created. You'll need to create the new dynamic version.

### Update: `application/views/web/product_detail.php`

I'll create the complete dynamic product detail view in the next artifact.

## 📊 Data Structure Examples

### Models Data (JSON)
```json
[
  {
    "model": "SS2-P-110",
    "safety_output": "Relay N.O. Contact x 1",
    "auxiliary_output": "N.C.(SSR Output) x 1",
    "material": "Polyamide 66 (PA66)"
  }
]
```

### Specifications Data (JSON)
```json
[
  {
    "label": "Power Supply Voltage",
    "value": "DC24V (-15%/+10%)"
  },
  {
    "label": "Operating Temperature",
    "value": "-25 – +60°C"
  }
]
```

### Downloads Data (JSON)
```json
[
  {
    "title": "Catalog(EN)",
    "url": "SafetyDigestE.pdf"
  },
  {
    "title": "Manual・CAD",
    "url": "/contact-safety/",
    "is_external": true
  }
]
```

### Applications Data (JSON)
```json
[
  {
    "image": "36.jpg",
    "title": "Door of Food Processing Machinery",
    "category": "Safety"
  }
]
```

## 🔄 How to Use

### Adding a New Product

1. Go to Admin Panel → Products → Product Items
2. Click "Add New Product"
3. Fill in basic information:
   - Product Name
   - Slug (auto-generated or custom)
   - Category & Type
   - Description
   - Features (one per line)

4. Fill in dynamic data fields:
   - **Models Data**: JSON array of model configurations
   - **Specifications Data**: JSON array of technical specs
   - **Downloads Data**: JSON array of downloadable files
   - **Applications Data**: JSON array of use cases
   - **YouTube Video ID**: Just the ID part from YouTube URL

5. Upload images:
   - Main product image
   - Gallery images (if any)

6. Save and view at: `https://your-site.com/product/your-product-slug`

## 🎥 YouTube Video Integration

To add a YouTube video:
1. Get the YouTube video URL: `https://www.youtube.com/watch?v=nNI2By9m0hI`
2. Extract the video ID: `nNI2By9m0hI`
3. Enter just the ID in the `youtube_video_id` field

The page will automatically embed it as:
```html
<iframe src="https://www.youtube.com/embed/nNI2By9m0hI"></iframe>
```

## 🧪 Testing

1. Run the database migration
2. Insert sample product (included in SQL)
3. Visit: `http://localhost/lineseiki.systems-test.com/product/ss2-p-1-series`
4. Verify all sections display correctly:
   - ✅ Product hero with image
   - ✅ YouTube video
   - ✅ Models table
   - ✅ Specifications table
   - ✅ Downloads section
   - ✅ Applications/Cases
   - ✅ Related products

## 🐛 Troubleshooting

**Problem**: 404 error when accessing product page
- **Solution**: Make sure routes.php is updated and `.htaccess` is configured

**Problem**: JSON data not showing
- **Solution**: Verify JSON format is valid using jsonlint.com

**Problem**: Images not loading
- **Solution**: Check that images exist in `assets_system/images/` folder

**Problem**: YouTube video not embedding
- **Solution**: Verify the `youtube_video_id` field contains only the ID, not the full URL

## 📱 Responsive Design

The template is fully responsive and includes:
- Desktop: Full layout with sidebar
- Tablet: Stacked layout
- Mobile: Single column with collapsible sections

## 🎨 Customization

To customize the design:
1. Edit the CSS in the `<style>` section of `product_detail.php`
2. Modify colors using CSS variables:
   - `--primary-blue`: Main brand color
   - `--newblue`: Secondary accent
   - `--newblue2`: Dark accent

## 📝 Admin Panel Integration

To manage products easily:
1. Use the existing Product Items admin interface
2. Add JSON editors for dynamic fields (consider using a JSON editor library)
3. Add image upload handlers for applications

## 🚀 Next Steps

1. ✅ Run database migration
2. ✅ Update model file
3. ✅ Update controller
4. ✅ Update routes
5. ✅ Test with sample product
6. ✅ Add more products using admin panel
7. ✅ Customize design as needed

## 📞 Support

For issues or questions:
- Check this guide first
- Review the sample SQL data
- Test with the provided sample product
- Verify all files are in the correct locations

---

**Last Updated**: January 2026
**Version**: 1.0
