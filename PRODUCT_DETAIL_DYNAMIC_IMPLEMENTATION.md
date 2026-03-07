# Dynamic Product Detail Page Implementation Guide

## Overview
This guide explains how to implement dynamic product detail pages for all products in the Line Seiki system. Each product will have its own unique detail page generated from the database.

## Database Structure

The system uses `tbl_product_pages` table with the following key fields:
- `id` - Primary key
- `slug` - URL-friendly unique identifier (e.g., "ss2-p-1-series")
- `product_name` - Product title
- `category` - Product category
- `subtitle` - Product subtitle/description
- `tags` - Comma-separated tags (e.g., "Plastic,Stand-alone")
- `features` - Product features (JSON or text)
- `main_image` - Primary product image filename
- `youtube_url` - Embedded YouTube video URL
- `models_data` - JSON data for models table
- `specifications_data` - JSON data for specifications
- `downloads_data` - JSON data for download links
- `applications_data` - JSON data for application examples
- `is_active` - Active/Inactive status
- `display_order` - Sort order

## Implementation Steps

### 1. Routes Configuration (Already Set Up)
```php
// In application/config/routes.php
$route['product/(:any)'] = 'index/product_detail/$1';
```

### 2. Controller Method
Add this to `application/controllers/cms.php` or create a new public controller

### 3. Model
Use the existing `Product_page_model.php` which has the method:
```php
public function get_product_by_slug($slug)
```

### 4. View Template
Create `application/views/web/product_detail.php` (dynamic template)

## Features

### Dynamic Content Sections:
1. **Hero Section** - Product image, title, tags, features
2. **Navigation Tabs** - Movie, Models, Specifications, Download, Applications
3. **Movie Section** - Embedded YouTube video
4. **Models Table** - Dynamic table generation from JSON data
5. **Specifications** - Multiple specification tables
6. **Downloads** - Catalog download links (multiple languages)
7. **Applications** - Related application examples

### JSON Data Structure Examples:

#### Models Data:
```json
{
  "headers": ["Models", "Safety Output", "Auxiliary Output", "Enclosure Material"],
  "rows": [
    {
      "model": "SS2-P-110",
      "safety_output": {"type": "Relay", "contacts": "N.O. Contact x 1", "rowspan": 3},
      "auxiliary_output": "N.C. (SSR Output) x 1",
      "enclosure": {"material": "Polyamide 66 (PA66)", "rowspan": 3}
    }
  ]
}
```

#### Specifications Data:
```json
{
  "general": [
    {"label": "Power Supply Voltage", "value": "DC24V (-15%/+10%)"},
    {"label": "Operating Temperature", "value": "-25 ~ +60°C"}
  ],
  "model_specific": {
    "headers": ["Models", "SS2-P-110", "SS2-P-120", "SS2-P-130"],
    "rows": [
      {"label": "Operating Current", "values": ["60 mA", "215 mA", "60 mA"]}
    ]
  }
}
```

#### Downloads Data:
```json
{
  "catalogs": [
    {"language": "EN", "url": "https://example.com/catalog-en.pdf"},
    {"language": "North America", "url": "https://example.com/catalog-us.pdf"}
  ],
  "manual": {
    "title": "Manual · CAD (Registration required)",
    "url": "https://example.com/register"
  }
}
```

## Usage

### Creating a New Product Detail Page:

1. **Add Product in Admin Panel**
   - Go to Product Pages Management
   - Fill in all required fields
   - Upload product image
   - Set the slug (URL-friendly name)
   - Add JSON data for models, specifications, etc.
   - Save

2. **Access the Product Page**
   - URL format: `https://your-domain.com/product/{slug}`
   - Example: `https://your-domain.com/product/ss2-p-1-series`

### Admin Panel Features:

- **Product List View**: See all products with quick actions
- **Add/Edit Form**: Form with all necessary fields
- **JSON Editor**: Visual editor for complex data structures
- **Image Upload**: Upload and manage product images
- **Preview**: Preview product page before publishing
- **Status Toggle**: Enable/disable products
- **Order Management**: Drag-and-drop to reorder products

## File Structure

```
application/
├── controllers/
│   └── index.php (add product_detail method)
├── models/
│   └── admin/
│       └── Product_page_model.php (already exists)
└── views/
    └── web/
        └── product_detail.php (new dynamic template)

assets_system/
└── images/
    └── products/ (product images directory)
```

## Benefits of This Implementation:

1. **No Code Changes Needed**: Add new products entirely through admin panel
2. **Consistent Design**: All product pages use the same template
3. **SEO-Friendly**: Clean URLs with product slugs
4. **Easy Maintenance**: Update product info without touching code
5. **Scalable**: Add unlimited products
6. **Flexible**: JSON data allows complex structures

## Security Considerations:

- Validate slug parameter to prevent SQL injection
- Sanitize all output to prevent XSS
- Check `is_active` status before displaying
- Implement proper image upload validation
- Use prepared statements in database queries

## Future Enhancements:

1. Product search functionality
2. Related products section
3. Product comparison feature
4. User reviews and ratings
5. Multi-language support
6. Product variations (colors, sizes, etc.)
7. Stock availability
8. Price management
