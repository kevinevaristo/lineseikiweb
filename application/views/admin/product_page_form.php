<!-- application/views/admin/product_page_form.php -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3><?php echo isset($product) ? 'Edit Product Page' : 'Add Product Page'; ?></h3>
                </div>
                <div class="card-body">
                    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                    
                    <?php echo form_open_multipart(isset($product) ? 'cms/edit_product_page/' . $product->id : 'cms/add_product_page'); ?>
                    
                    <ul class="nav nav-tabs" id="productTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#basic" role="tab">Basic Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="content-tab" data-toggle="tab" href="#content" role="tab">Content</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="media-tab" data-toggle="tab" href="#media" role="tab">Media</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="advanced-tab" data-toggle="tab" href="#advanced" role="tab">Advanced</a>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="productTabsContent">
                        <!-- Basic Info Tab -->
                        <div class="tab-pane fade show active" id="basic" role="tabpanel">
                            <div class="form-row mt-3">
                                <div class="form-group col-md-6">
                                    <label for="product_name">Product Name *</label>
                                    <input type="text" class="form-control" id="product_name" name="product_name" 
                                           value="<?php echo isset($product) ? $product->product_name : set_value('product_name'); ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="slug">Slug (URL) *</label>
                                    <input type="text" class="form-control" id="slug" name="slug" 
                                           value="<?php echo isset($product) ? $product->slug : set_value('slug'); ?>" required>
                                    <small class="form-text text-muted">URL-friendly version (e.g., ss2-p-1-series)</small>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="title">Page Title *</label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="<?php echo isset($product) ? $product->title : set_value('title'); ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="subtitle">Subtitle</label>
                                    <input type="text" class="form-control" id="subtitle" name="subtitle" 
                                           value="<?php echo isset($product) ? $product->subtitle : set_value('subtitle'); ?>">
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="category">Category</label>
                                    <select class="form-control" id="category" name="category">
                                        <option value="">Select Category</option>
                                        <option value="safety" <?php echo (isset($product) && $product->category == 'safety') ? 'selected' : ''; ?>>Safety Switches</option>
                                        <option value="electronic" <?php echo (isset($product) && $product->category == 'electronic') ? 'selected' : ''; ?>>Electronic Counters</option>
                                        <option value="time" <?php echo (isset($product) && $product->category == 'time') ? 'selected' : ''; ?>>Timers</option>
                                        <option value="electromagnetic" <?php echo (isset($product) && $product->category == 'electromagnetic') ? 'selected' : ''; ?>>Electromagnetic Counters</option>
                                        <option value="mechanical" <?php echo (isset($product) && $product->category == 'mechanical') ? 'selected' : ''; ?>>Mechanical Counters</option>
                                        <option value="slide" <?php echo (isset($product) && $product->category == 'slide') ? 'selected' : ''; ?>>Slide Limit Counters</option>
                                        <option value="limit" <?php echo (isset($product) && $product->category == 'limit') ? 'selected' : ''; ?>>Limit Switches</option>
                                        <option value="length" <?php echo (isset($product) && $product->category == 'length') ? 'selected' : ''; ?>>Length Counters & Sensors</option>
                                        <option value="encoder" <?php echo (isset($product) && $product->category == 'encoder') ? 'selected' : ''; ?>>Rotary Encoders</option>
                                        <option value="tachometers" <?php echo (isset($product) && $product->category == 'tachometers') ? 'selected' : ''; ?>>Tachometers</option>
                                        <option value="thermo" <?php echo (isset($product) && $product->category == 'thermo') ? 'selected' : ''; ?>>Thermometers</option>
                                        <option value="measure" <?php echo (isset($product) && $product->category == 'measure') ? 'selected' : ''; ?>>Measuring Instruments</option>
                                        <option value="tally" <?php echo (isset($product) && $product->category == 'tally') ? 'selected' : ''; ?>>Tally Counters</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="tags">Tags (comma-separated)</label>
                                    <input type="text" class="form-control" id="tags" name="tags" 
                                           value="<?php echo isset($product) ? $product->tags : set_value('tags'); ?>"
                                           placeholder="e.g., Plastic,Stand-alone,High Performance">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="meta_description">Meta Description</label>
                                <textarea class="form-control" id="meta_description" name="meta_description" rows="2"><?php echo isset($product) ? $product->meta_description : set_value('meta_description'); ?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="meta_keywords">Meta Keywords</label>
                                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" 
                                       value="<?php echo isset($product) ? $product->meta_keywords : set_value('meta_keywords'); ?>">
                            </div>
                        </div>
                        
                        <!-- Content Tab -->
                        <div class="tab-pane fade" id="content" role="tabpanel">
                            <div class="mt-3">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4"><?php echo isset($product) ? $product->description : set_value('description'); ?></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="features">Features (one per line)</label>
                                    <textarea class="form-control" id="features" name="features" rows="6"><?php echo isset($product) ? $product->features : set_value('features'); ?></textarea>
                                    <small class="form-text text-muted">Enter each feature on a new line</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="specifications">Specifications (Format: Label: Value)</label>
                                    <textarea class="form-control" id="specifications" name="specifications" rows="8"><?php echo isset($product) ? $product->specifications : set_value('specifications'); ?></textarea>
                                    <small class="form-text text-muted">Example: Power Supply Voltage: DC24V (-15%/+10%)</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="models">Models (JSON Format)</label>
                                    <textarea class="form-control" id="models" name="models" rows="6"><?php echo isset($product) ? $product->models : set_value('models'); ?></textarea>
                                    <small class="form-text text-muted">JSON array of model objects: [{"model":"SS2-P-110","safety_output":"..."}]</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="applications">Applications (one per line)</label>
                                    <textarea class="form-control" id="applications" name="applications" rows="5"><?php echo isset($product) ? $product->applications : set_value('applications'); ?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Media Tab -->
                        <div class="tab-pane fade" id="media" role="tabpanel">
                            <div class="mt-3">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="banner_image">Banner Image</label>
                                        <input type="file" class="form-control-file" id="banner_image" name="banner_image" accept="image/*">
                                        <?php if (isset($product) && $product->banner_image): ?>
                                        <div class="mt-2">
                                            <img src="<?php echo base_url('assets_system/images/banners/' . $product->banner_image); ?>" 
                                                 alt="Current Banner" style="max-width: 300px;">
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        <label for="thumbnail_image">Thumbnail Image</label>
                                        <input type="file" class="form-control-file" id="thumbnail_image" name="thumbnail_image" accept="image/*">
                                        <?php if (isset($product) && $product->thumbnail_image): ?>
                                        <div class="mt-2">
                                            <img src="<?php echo base_url('assets_system/images/thumbnails/' . $product->thumbnail_image); ?>" 
                                                 alt="Current Thumbnail" style="max-width: 200px;">
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="gallery_images">Gallery Images (multiple)</label>
                                    <input type="file" class="form-control-file" id="gallery_images" name="gallery_images[]" accept="image/*" multiple>
                                    <?php if (isset($product) && $product->gallery_images): ?>
                                    <div class="gallery-preview mt-2">
                                        <?php 
                                        $gallery = json_decode($product->gallery_images);
                                        if ($gallery):
                                            foreach ($gallery as $img):
                                        ?>
                                        <img src="<?php echo base_url('assets_system/images/gallery/' . $img); ?>" 
                                             alt="Gallery Image" style="max-width: 150px; margin: 5px;">
                                        <?php 
                                            endforeach;
                                        endif;
                                        ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="video_url">Video URL</label>
                                        <input type="text" class="form-control" id="video_url" name="video_url" 
                                               value="<?php echo isset($product) ? $product->video_url : set_value('video_url'); ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="youtube_embed">YouTube Video ID</label>
                                        <input type="text" class="form-control" id="youtube_embed" name="youtube_embed" 
                                               value="<?php echo isset($product) ? $product->youtube_embed : set_value('youtube_embed'); ?>"
                                               placeholder="e.g., nNI2By9m0hI">
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="brochure_pdf">Brochure PDF</label>
                                        <input type="file" class="form-control-file" id="brochure_pdf" name="brochure_pdf" accept=".pdf">
                                        <?php if (isset($product) && $product->brochure_pdf): ?>
                                        <small class="form-text text-muted">Current: <?php echo $product->brochure_pdf; ?></small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="manual_pdf">Manual PDF</label>
                                        <input type="file" class="form-control-file" id="manual_pdf" name="manual_pdf" accept=".pdf">
                                        <?php if (isset($product) && $product->manual_pdf): ?>
                                        <small class="form-text text-muted">Current: <?php echo $product->manual_pdf; ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Advanced Tab -->
                        <div class="tab-pane fade" id="advanced" role="tabpanel">
                            <div class="mt-3">
                                <div class="form-group">
                                    <label for="catalog_links">Catalog Links (JSON Format)</label>
                                    <textarea class="form-control" id="catalog_links" name="catalog_links" rows="5"><?php echo isset($product) ? $product->catalog_links : set_value('catalog_links'); ?></textarea>
                                    <small class="form-text text-muted">Example: [{"label":"Catalog(EN)","url":"https://example.com/catalog.pdf"}]</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="anchor_sections">Anchor Navigation Sections (JSON Format)</label>
                                    <textarea class="form-control" id="anchor_sections" name="anchor_sections" rows="4"><?php echo isset($product) ? $product->anchor_sections : set_value('anchor_sections'); ?></textarea>
                                    <small class="form-text text-muted">Example: [{"id":"block01","label":"Movie"},{"id":"block02","label":"Models"}]</small>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="display_order">Display Order</label>
                                        <input type="number" class="form-control" id="display_order" name="display_order" 
                                               value="<?php echo isset($product) ? $product->display_order : '0'; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>&nbsp;</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                                   <?php echo (isset($product) && $product->is_active) || !isset($product) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="is_active">Active</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>&nbsp;</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                                                   <?php echo (isset($product) && $product->is_featured) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="is_featured">Featured</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fa fa-save"></i> <?php echo isset($product) ? 'Update Product' : 'Add Product'; ?>
                        </button>
                        <a href="<?php echo base_url('cms/product_pages'); ?>" class="btn btn-secondary btn-lg">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                    </div>
                    
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-generate slug from product name
document.getElementById('product_name').addEventListener('blur', function() {
    var slug = document.getElementById('slug');
    if (!slug.value) {
        slug.value = this.value.toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }
});
</script>
