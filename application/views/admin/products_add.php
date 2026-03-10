<!-- File: application/views/admin/products_add.php -->
<?php $this->load->view('admin/header'); ?>
<style>
.section-card {
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
}

.section-header {
    cursor: pointer;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    background-color: #f9fafb;
    user-select: none;
}

.section-header:hover {
    background-color: #f3f4f6;
}

.section-content {
    padding: 1.5rem;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.section-collapsed .section-content {
    max-height: 0;
    padding-top: 0;
    padding-bottom: 0;
}

.section-icon {
    transition: transform 0.3s ease;
    transform: rotate(0deg);
}

.section-collapsed .section-icon {
    transform: rotate(-90deg);
}

.section-content > *:last-child {
    margin-bottom: 0;
}

/* Image Upload Styles */
.image-upload-container {
    position: relative;
}

.image-upload-area {
    border: 2px dashed #d1d5db;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f9fafb;
}

.image-upload-area:hover {
    border-color: #4f46e5;
    background-color: #f8fafc;
}

.image-preview {
    margin-bottom: 10px;
    min-height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-preview img {
    max-width: 100%;
    max-height: 100px;
    object-fit: contain;
    border-radius: 6px;
    border: 1px solid #e5e7eb;
}

.remove-image-btn {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #ef4444;
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 12px;
    z-index: 10;
}

.remove-image-btn:hover {
    background: #dc2626;
}

/* Specifications View Styles */
.specifications-view {
    background: #f9fafb;
    border-radius: 8px;
    padding: 20px;
    border: 1px solid #e5e7eb;
    font-family: 'Courier New', monospace;
    white-space: pre-wrap;
    max-height: 400px;
    overflow-y: auto;
    font-size: 14px;
    line-height: 1.6;
}

.specifications-view p {
    margin: 0 0 10px 0;
    padding: 0;
}

.specifications-empty {
    color: #9ca3af;
    font-style: italic;
    text-align: center;
    padding: 40px;
}

.no-data {
    padding: 40px;
    text-align: center;
    color: #6b7280;
    background: #f9fafb;
}
</style>
<main class="ml-64 p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <a href="<?php echo base_url('cms/product_items/' . $category_id); ?>" class="text-slate-500 hover:text-indigo-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h1 class="text-3xl font-bold text-slate-900">
                        Add New Product
                    </h1>
                </div>
                <p class="text-slate-500 ml-9">Create a new product with all details and content sections</p>
            </div>
            <div class="flex gap-3">
                <a href="<?php echo base_url('cms/product_items/' . $category_id); ?>" 
                   class="px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-xl font-medium hover:bg-slate-50 transition-all">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="button" onclick="saveProduct()" 
                        class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition-all">
                    <i class="fas fa-save mr-2"></i>Create Product
                </button>
            </div>
        </div>

        <!-- Main Form -->
        <form id="productForm" enctype="multipart/form-data" class="space-y-6">
            <input type="hidden" id="categoryId" name="product_category" value="<?php echo $category_id; ?>">
            
            <!-- Basic Information Section -->
            <div class="section-card bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-info-circle text-indigo-600 section-icon"></i>
                            <h3 class="text-lg font-bold text-slate-800">Basic Information</h3>
                        </div>
                        <span class="text-sm text-slate-500">Click to expand/collapse</span>
                    </div>
                </div>
                <div class="section-content">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Product Type -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Product Type/Group *</label>
                            <select name="product_type" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                                <option value="">Select Type</option>
                                <?php foreach ($types as $type): ?>
                                <option value="<?php echo $type->id; ?>">
                                    <?php echo htmlspecialchars($type->type_name); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- Product Name -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Product Name *</label>
                            <input type="text" name="product_name" required
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                        </div>
                        
                        <!-- Series Name -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Series Name</label>
                            <input type="text" name="series_name"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                   placeholder="E.g., SS2-P-1 series">
                        </div>
                        
                        <!-- Sub Title -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Sub Title / Tagline</label>
                            <input type="text" name="sub_title"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                   placeholder="Short descriptive tagline">
                        </div>
                        
                        <!-- Model Number -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Model Number</label>
                            <input type="text" name="model_number"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                   placeholder="E.g., SS2-P-1XX">
                        </div>
                        
                        <!-- Slug -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">URL Slug *</label>
                            <input type="text" name="slug" id="slugInput" required readonly
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                   placeholder="product-url-slug">
                            <p class="text-sm text-slate-500 mt-1">Used in URLs: <?php echo base_url('index/product/'); ?><span id="slugPreview">product-url-slug</span></p>
                        </div>
                        
                        <!-- Product Image Upload Field -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Product Image</label>
                            <div class="image-upload-container">
                                <!-- Hidden file input -->
                                <input type="file" 
                                       id="productImageUpload" 
                                       class="hidden" 
                                       accept="image/*">
                                
                                <!-- Image preview and upload button -->
                                <div class="image-upload-area" onclick="triggerProductImageUpload()">
                                    <div class="image-preview mb-2">
                                        <!-- Preview will be shown here -->
                                    </div>
                                    <div class="text-slate-500">
                                        <i class="fas fa-upload text-lg mb-1"></i>
                                        <p class="text-sm font-medium">Click to upload image</p>
                                        <p class="text-xs">JPG, PNG, GIF, WebP (max 2MB)</p>
                                    </div>
                                </div>
                                
                                <!-- Hidden input for existing image filename -->
                                <input type="hidden" id="productImageFilename" name="product_image" value="">
                            </div>
                        </div>
                        
                        <!-- Tags -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tags</label>
                            <input type="text" name="tags"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                   placeholder="Plastic,Stand-alone,Safety">
                            <p class="text-sm text-slate-500 mt-1">Comma-separated tags for filtering</p>
                        </div>
                    </div>
                    
                    <!-- Short Description -->
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Short Description *</label>
                        <textarea name="short_description" rows="3" required
                                  class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                  placeholder="Brief product summary (max 500 chars)"></textarea>
                    </div>
                    
                    <!-- Full Description -->
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Full Description</label>
                        <textarea name="description" rows="6"
                                  class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                  placeholder="Detailed product description"></textarea>
                    </div>
                    
                    <!-- Status & Order -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
                        <div class="flex items-center">
                            <input type="checkbox" id="isActive" name="is_active" value="1" checked
                                   class="mr-2 h-4 w-4">
                            <label for="isActive" class="text-sm text-slate-700">Active Product</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="isNew" name="is_new" value="1" checked
                                   class="mr-2 h-4 w-4">
                            <label for="isNew" class="text-sm text-slate-700">New Product</label>
                        </div>
                    </div>
                    
                    <!-- Features -->
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Features List</label>
                        <textarea name="features" rows="6"
                                  class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                  placeholder="Enter each feature on a new line"></textarea>
                        <p class="text-sm text-slate-500 mt-1">Each line will become a separate bullet point</p>
                    </div>
                </div>
            </div>
        
            <!-- Movie Section -->
            <div class="section-card bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-video text-indigo-600 section-icon"></i>
                            <h3 class="text-lg font-bold text-slate-800">Movie</h3>
                        </div>
                        <span class="text-sm text-slate-500">Click to expand/collapse</span>
                    </div>
                </div>
                <div class="section-content">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">YouTube Video ID</label>
                            <input type="text" name="youtube_embed"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                   placeholder="nNI2By9m0hI">
                            <p class="text-sm text-slate-500 mt-1">Only the video ID (from YouTube URL)</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Video URL</label>
                            <input type="url" name="video_url"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                   placeholder="https://example.com/video.mp4">
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Specifications Section -->
            <div class="section-card bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-list-alt text-indigo-600 section-icon"></i>
                            <h3 class="text-lg font-bold text-slate-800">Technical Specifications</h3>
                        </div>
                        <span class="text-sm text-slate-500">Click to expand/collapse</span>
                    </div>
                </div>
                <div class="section-content">
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-3">
                            <label class="block text-sm font-medium text-slate-700">Specifications</label>
                            <div class="flex gap-2">
                                <button type="button" onclick="formatSpecs()" 
                                        class="px-3 py-1 bg-slate-100 text-slate-700 text-sm rounded-lg hover:bg-slate-200 transition-colors">
                                    <i class="fas fa-magic mr-1"></i> Format
                                </button>
                                <button type="button" onclick="clearSpecs()" 
                                        class="px-3 py-1 bg-red-50 text-red-600 text-sm rounded-lg hover:bg-red-100 transition-colors">
                                    <i class="fas fa-trash mr-1"></i> Clear
                                </button>
                            </div>
                        </div>
                        
                        <textarea name="specifications" rows="10"
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none font-mono text-sm"
                                placeholder="Enter specifications in format:
Key 1: Value 1
Key 2: Value 2
Key 3: Value 3

Each specification should be on a new line with a colon separating key and value."></textarea>
                        
                        <div class="mt-3 p-3 bg-blue-50 border border-blue-100 rounded-lg">
                            <div class="flex items-start gap-2">
                                <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                                <div>
                                    <p class="text-sm text-slate-700 font-medium">Format Guide:</p>
                                    <ul class="text-xs text-slate-600 mt-1 space-y-1">
                                        <li>• Each line should have a key and value separated by a colon (e.g., <code>Power Supply Voltage: DC24V (-15%/+10%)</code>)</li>
                                        <li>• Empty lines will be ignored</li>
                                        <li>• Use the "Format" button to auto-format your specifications</li>
                                        <li>• The "Clear" button will empty the textarea</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Downloads Section -->
            <div class="section-card bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-download text-indigo-600 section-icon"></i>
                            <h3 class="text-lg font-bold text-slate-800">Downloadable Files</h3>
                        </div>
                        <span class="text-sm text-slate-500">Click to expand/collapse</span>
                    </div>
                </div>
                <div class="section-content">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="font-medium text-slate-700">Manage downloadable files</h4>
                        <button type="button" onclick="addDownload(null, true)" 
                                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Add Download
                        </button>
                    </div>
                    
                    <!-- Downloads Manager -->
                    <div id="downloadsContainer" class="space-y-4">
                        <!-- Downloads will be populated by JavaScript -->
                    </div>
                    
                    <!-- Download Template (Hidden) -->
                    <template id="downloadTemplate">
                        <div class="download-item border border-slate-300 rounded-lg p-4 bg-slate-50">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="font-medium text-slate-800">Download <span class="dl-number">1</span></h4>
                                <button type="button" onclick="removeDownload(this)" 
                                        class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Label *</label>
                                    <input type="text" 
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none download-label"
                                        placeholder="Catalog(EN)" required>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">URL *</label>
                                    <input type="url" 
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none download-url"
                                        placeholder="https://example.com/catalog.pdf" required>
                                </div>
                                
                                <!-- Hidden icon input -->
                                <input type="hidden" class="download-icon" value="fas fa-file-pdf">
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        
            <!-- Applications Section -->
            <div class="section-card bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-tasks text-indigo-600 section-icon"></i>
                            <h3 class="text-lg font-bold text-slate-800">Application Examples</h3>
                        </div>
                        <span class="text-sm text-slate-500">Click to expand/collapse</span>
                    </div>
                </div>
                <div class="section-content">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="font-medium text-slate-700">Manage application examples</h4>
                        <button type="button" onclick="addApplication(null, true)" 
                                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Add Application
                        </button>
                    </div>
                    
                    <!-- Applications Manager -->
                    <div id="applicationsContainer" class="space-y-4">
                        <!-- Applications will be populated by JavaScript -->
                    </div>
                    
                    <!-- Application Template (Hidden) -->
                    <template id="applicationTemplate">
                        <div class="application-item border border-slate-300 rounded-lg p-4 bg-slate-50">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="font-medium text-slate-800">Application <span class="app-number">1</span></h4>
                                <button type="button" onclick="removeApplication(this)" 
                                        class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Title *</label>
                                    <input type="text" 
                                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none app-title"
                                           placeholder="Door of Food Processing Machinery" required>
                                </div>
                                
                                <!-- Image Upload Field -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Application Image</label>
                                    <div class="image-upload-container">
                                        <!-- Hidden file input -->
                                        <input type="file" 
                                               class="application-image-upload hidden" 
                                               accept="image/*">
                                        
                                        <!-- Image preview and upload button -->
                                        <div class="image-upload-area" onclick="triggerApplicationImageUpload(this)">
                                            <div class="image-preview mb-2">
                                                <!-- Preview will be shown here -->
                                            </div>
                                            <div class="text-slate-500">
                                                <i class="fas fa-upload text-lg mb-1"></i>
                                                <p class="text-sm font-medium">Click to upload image</p>
                                                <p class="text-xs">JPG, PNG, GIF, WebP (max 2MB)</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Hidden input for existing image filename -->
                                        <input type="hidden" class="application-image-filename" value="">
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Badge/Label</label>
                                    <input type="text" 
                                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none app-badge"
                                           placeholder="Safety">
                                </div>
                                
                                <div style="display: none;">
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Link</label>
                                    <input type="text" 
                                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none app-link"
                                           placeholder="https://example.com">
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </form>
    </div>
</main>

<!-- Include SweetAlert -->
<link rel="stylesheet" href="<?php echo base_url('assets_system/vendor/sweetalert2/sweetalert2.min.css'); ?>">
<script src="<?php echo base_url('assets_system/vendor/sweetalert2/sweetalert2.all.min.js'); ?>"></script>
<script src="<?php echo base_url('assets_system/vendor/fontawesome-6.5.0/js/all.min.js'); ?>"></script>

<script>
// Product Image Upload Functions
function triggerProductImageUpload() {
    const fileInput = document.getElementById('productImageUpload');
    if (fileInput) {
        fileInput.click();
    }
}

// Setup product image upload on page load
document.addEventListener('DOMContentLoaded', function() {
    const productFileInput = document.getElementById('productImageUpload');
    if (productFileInput) {
        productFileInput.addEventListener('change', function(e) {
            handleProductImageUpload(e.target.files[0]);
        });
    }
});

function handleProductImageUpload(file) {
    if (!file) return;
    
    // Validate file size (max 2MB)
    if (file.size > 2 * 1024 * 1024) {
        Swal.fire({
            title: 'File Too Large',
            text: 'Image must be less than 2MB',
            icon: 'error',
            confirmButtonColor: '#4f46e5'
        });
        return;
    }
    
    // Validate file type
    const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!validTypes.includes(file.type)) {
        Swal.fire({
            title: 'Invalid File Type',
            text: 'Please upload a JPG, PNG, GIF, or WebP image',
            icon: 'error',
            confirmButtonColor: '#4f46e5'
        });
        return;
    }
    
    // Create preview
    const reader = new FileReader();
    reader.onload = function(e) {
        const previewArea = document.querySelector('#productImageUpload').closest('.image-upload-container').querySelector('.image-preview');
        const filenameInput = document.getElementById('productImageFilename');
        const uploadArea = document.querySelector('#productImageUpload').closest('.image-upload-area');
        
        // Generate a unique filename
        const timestamp = Date.now();
        const random = Math.random().toString(36).substring(2, 8);
        const originalName = file.name.replace(/\.[^/.]+$/, ""); // Remove extension
        const extension = file.name.split('.').pop();
        const newFilename = `product_${timestamp}_${random}_${originalName}.${extension}`;
        
        // Set the filename in hidden input
        if (filenameInput) {
            filenameInput.value = newFilename;
        }
        
        // Show preview
        if (previewArea) {
            previewArea.innerHTML = `
                <div style="position: relative;">
                    <img src="${e.target.result}" alt="Preview" class="max-h-32 object-contain rounded">
                    <button type="button" onclick="removeProductImage()" class="remove-image-btn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
        }
        
        // Update the upload area text
        if (uploadArea) {
            const textArea = uploadArea.querySelector('.text-slate-500');
            if (textArea) {
                textArea.innerHTML = `
                    <p class="text-sm font-medium text-green-600">Image uploaded</p>
                    <p class="text-xs text-slate-500">Click to change</p>
                `;
            }
        }
    };
    reader.readAsDataURL(file);
}

function removeProductImage() {
    const container = document.getElementById('productImageUpload').closest('.image-upload-container');
    const previewArea = container.querySelector('.image-preview');
    const filenameInput = document.getElementById('productImageFilename');
    const fileInput = document.getElementById('productImageUpload');
    const uploadArea = container.querySelector('.image-upload-area');
    
    // Clear preview
    if (previewArea) {
        previewArea.innerHTML = '';
    }
    
    // Clear filename
    if (filenameInput) {
        filenameInput.value = '';
    }
    
    // Clear file input
    if (fileInput) {
        fileInput.value = '';
    }
    
    // Reset upload area text
    if (uploadArea) {
        const textArea = uploadArea.querySelector('.text-slate-500');
        if (textArea) {
            textArea.innerHTML = `
                <i class="fas fa-upload text-lg mb-1"></i>
                <p class="text-sm font-medium">Click to upload image</p>
                <p class="text-xs">JPG, PNG, GIF, WebP (max 2MB)</p>
            `;
        }
    }
}
</script>

<script>
// Section toggle functionality
function toggleSection(header) {
    const section = header.closest('.section-card');
    section.classList.toggle('section-collapsed');
    
    const content = section.querySelector('.section-content');
    if (section.classList.contains('section-collapsed')) {
        content.style.maxHeight = '0';
    } else {
        content.style.maxHeight = content.scrollHeight + 'px';
    }
}

// Auto-generate slug from product name
document.addEventListener('DOMContentLoaded', function() {
    const productNameInput = document.querySelector('input[name="product_name"]');
    const slugInput = document.getElementById('slugInput');
    const slugPreview = document.getElementById('slugPreview');
    
    if (productNameInput && slugInput) {
        productNameInput.addEventListener('input', function() {
            if (!slugInput.dataset.manuallyEdited) {
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                slugInput.value = slug;
                slugPreview.textContent = slug || 'product-url-slug';
            }
        });
        
        slugInput.addEventListener('input', function() {
            slugInput.dataset.manuallyEdited = 'true';
            slugPreview.textContent = this.value || 'product-url-slug';
        });
    }
});

// Applications Management
let appCount = 0;

function addApplication(app = null, isManualAdd = false) {
    const template = document.getElementById('applicationTemplate');
    const container = document.getElementById('applicationsContainer');
    
    if (!template || !container) {
        console.error('Application template or container not found');
        return;
    }
    
    const clone = template.content.cloneNode(true);
    appCount++;
    const appItem = clone.querySelector('.application-item');
    appItem.querySelector('.app-number').textContent = appCount;
    
    // Set values if provided
    if (app) {
        const titleInput = appItem.querySelector('.app-title');
        const imageInput = appItem.querySelector('.application-image-filename');
        const badgeInput = appItem.querySelector('.app-badge');
        const linkInput = appItem.querySelector('.app-link');
        
        if (titleInput && app.title) titleInput.value = app.title;
        if (imageInput && app.image) {
            imageInput.value = app.image;
            showApplicationImagePreview(appItem, app.image);
        }
        if (badgeInput && app.badge) badgeInput.value = app.badge;
        if (linkInput && app.link) linkInput.value = app.link;
    }
    
    container.appendChild(appItem);
    
    // Setup image upload for this item
    const fileInput = appItem.querySelector('.application-image-upload');
    if (fileInput) {
        setupApplicationImageUpload(fileInput, appItem);
    }
    
    return appItem;
}

function removeApplication(button) {
    const item = button.closest('.application-item');
    if (!item) return;
    
    item.remove();
    appCount--;
    
    // Re-number applications
    const items = document.querySelectorAll('#applicationsContainer .application-item');
    items.forEach((item, index) => {
        item.querySelector('.app-number').textContent = index + 1;
    });
}

// Downloads Management
let dlCount = 0;

function addDownload(dl = null, isManualAdd = false) {
    const template = document.getElementById('downloadTemplate');
    const container = document.getElementById('downloadsContainer');
    
    if (!template || !container) {
        console.error('Download template or container not found');
        return;
    }
    
    const clone = template.content.cloneNode(true);
    dlCount++;
    const dlItem = clone.querySelector('.download-item');
    dlItem.querySelector('.dl-number').textContent = dlCount;
    
    // Set values if provided
    if (dl) {
        const labelInput = dlItem.querySelector('.download-label');
        const urlInput = dlItem.querySelector('.download-url');
        const iconInput = dlItem.querySelector('.download-icon');
        
        if (labelInput && dl.label) labelInput.value = dl.label;
        if (urlInput && dl.url) urlInput.value = dl.url;
        if (iconInput && dl.icon) iconInput.value = dl.icon;
    }
    
    container.appendChild(dlItem);
    return dlItem;
}

function removeDownload(button) {
    const item = button.closest('.download-item');
    if (!item) return;
    
    item.remove();
    dlCount--;
    
    // Re-number downloads
    const items = document.querySelectorAll('#downloadsContainer .download-item');
    items.forEach((item, index) => {
        item.querySelector('.dl-number').textContent = index + 1;
    });
}

// Image Upload Functions
function triggerApplicationImageUpload(uploadArea) {
    const container = uploadArea.closest('.image-upload-container');
    const fileInput = container.querySelector('.application-image-upload');
    if (fileInput) {
        fileInput.click();
    }
}

function setupApplicationImageUpload(fileInput, appItem) {
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        
        // Validate file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({
                title: 'File Too Large',
                text: 'Image must be less than 2MB',
                icon: 'error',
                confirmButtonColor: '#4f46e5'
            });
            return;
        }
        
        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            Swal.fire({
                title: 'Invalid File Type',
                text: 'Please upload a JPG, PNG, GIF, or WebP image',
                icon: 'error',
                confirmButtonColor: '#4f46e5'
            });
            return;
        }
        
        // Create preview
        const reader = new FileReader();
        reader.onload = function(e) {
            const container = fileInput.closest('.image-upload-container');
            const previewArea = container.querySelector('.image-preview');
            const filenameInput = container.querySelector('.application-image-filename');
            
            // Generate a unique filename
            const timestamp = Date.now();
            const random = Math.random().toString(36).substring(2, 8);
            const originalName = file.name.replace(/\.[^/.]+$/, ""); // Remove extension
            const extension = file.name.split('.').pop();
            const newFilename = `application_${timestamp}_${random}_${originalName}.${extension}`;
            
            // Set the filename in hidden input
            if (filenameInput) {
                filenameInput.value = newFilename;
            }
            
            // Show preview
            previewArea.innerHTML = `
                <div style="position: relative;">
                    <img src="${e.target.result}" alt="Preview" class="max-h-32 object-contain rounded">
                    <button type="button" onclick="removeApplicationImage(this)" class="remove-image-btn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            // Update the upload area text
            const uploadArea = container.querySelector('.image-upload-area');
            const textArea = uploadArea.querySelector('.text-slate-500');
            if (textArea) {
                textArea.innerHTML = `
                    <p class="text-sm font-medium text-green-600">Image uploaded</p>
                    <p class="text-xs text-slate-500">Click to change</p>
                `;
            }
        };
        reader.readAsDataURL(file);
    });
}

function showApplicationImagePreview(appItem, imageFilename) {
    const container = appItem.querySelector('.image-upload-container');
    if (!container || !imageFilename) return;
    
    const previewArea = container.querySelector('.image-preview');
    const uploadArea = container.querySelector('.image-upload-area');
    const textArea = uploadArea.querySelector('.text-slate-500');
    
    if (previewArea) {
        previewArea.innerHTML = `
            <div style="position: relative;">
                <img src="<?php echo base_url('assets_system/images/'); ?>/${imageFilename}" alt="Preview" class="max-h-32 object-contain rounded">
                <button type="button" onclick="removeApplicationImage(this)" class="remove-image-btn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
    }
    
    if (textArea) {
        textArea.innerHTML = `
            <p class="text-sm font-medium text-green-600">Image uploaded</p>
            <p class="text-xs text-slate-500">Click to change</p>
        `;
    }
}

function removeApplicationImage(button) {
    const container = button.closest('.image-upload-container');
    const previewArea = container.querySelector('.image-preview');
    const filenameInput = container.querySelector('.application-image-filename');
    const fileInput = container.querySelector('.application-image-upload');
    const uploadArea = container.querySelector('.image-upload-area');
    
    // Clear preview
    previewArea.innerHTML = '';
    
    // Clear filename
    if (filenameInput) {
        filenameInput.value = '';
    }
    
    // Clear file input
    if (fileInput) {
        fileInput.value = '';
    }
    
    // Reset upload area text
    const textArea = uploadArea.querySelector('.text-slate-500');
    if (textArea) {
        textArea.innerHTML = `
            <i class="fas fa-upload text-lg mb-1"></i>
            <p class="text-sm font-medium">Click to upload image</p>
            <p class="text-xs">JPG, PNG, GIF, WebP (max 2MB)</p>
        `;
    }
}

// Specifications formatting
function formatSpecs() {
    const textarea = document.querySelector('textarea[name="specifications"]');
    if (!textarea) return;
    
    const lines = textarea.value.split('\n');
    const formattedLines = [];
    
    lines.forEach(line => {
        const trimmedLine = line.trim();
        if (!trimmedLine) return;
        
        if (trimmedLine.includes(':')) {
            const parts = trimmedLine.split(':').map(part => part.trim());
            if (parts.length >= 2) {
                formattedLines.push(`${parts[0]}: ${parts.slice(1).join(': ')}`);
            } else {
                formattedLines.push(trimmedLine);
            }
        } else {
            formattedLines.push(trimmedLine);
        }
    });
    
    textarea.value = formattedLines.join('\n');
    
    Swal.fire({
        title: 'Formatted!',
        text: 'Specifications have been formatted successfully.',
        icon: 'success',
        timer: 1500,
        showConfirmButton: false
    });
}

function clearSpecs() {
    Swal.fire({
        title: 'Clear Specifications?',
        text: 'This will remove all specifications from the textarea.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Clear All',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#ef4444',
    }).then((result) => {
        if (result.isConfirmed) {
            const textarea = document.querySelector('textarea[name="specifications"]');
            if (textarea) {
                textarea.value = '';
                textarea.focus();
                
                Swal.fire({
                    title: 'Cleared!',
                    text: 'Specifications have been cleared.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        }
    });
}

// Save Product Function
async function saveProduct() {
    const saveBtn = document.querySelector('button[onclick="saveProduct()"]');
    const originalText = saveBtn.innerHTML;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating...';
    saveBtn.disabled = true;
    
    try {
        // 1. Get form element
        const form = document.getElementById('productForm');
        if (!form) throw new Error('Form not found');
        
        // 2. Create FormData
        const formData = new FormData(form);
        
        // 3. Add checkbox values
        formData.append('is_active', document.getElementById('isActive').checked ? '1' : '0');
        formData.append('is_new', document.getElementById('isNew').checked ? '1' : '0');
        
        const productFileInput = document.getElementById('productImageUpload');
        if (productFileInput && productFileInput.files && productFileInput.files[0]) {
            formData.append('product_image_file', productFileInput.files[0]);
        }
        
        // 4. Collect applications data as JSON
        const applications = [];
        document.querySelectorAll('#applicationsContainer .application-item').forEach((item, index) => {
            const title = item.querySelector('.app-title')?.value.trim() || '';
            const image = item.querySelector('.application-image-filename')?.value || '';
            const badge = item.querySelector('.app-badge')?.value.trim() || '';
            const link = item.querySelector('.app-link')?.value.trim() || '';
            
            if (title) {
                const app = {
                    title: title,
                    badge: badge,
                    link: link
                };
                
                // Add image if exists
                if (image) {
                    app.image = image;
                }
                
                // Get file if uploaded
                const fileInput = item.querySelector('.application-image-upload');
                if (fileInput && fileInput.files && fileInput.files[0]) {
                    // Add file to FormData with unique name
                    formData.append(`app_file_${index}`, fileInput.files[0]);
                }
                
                applications.push(app);
            }
        });
        
        // Add applications JSON to FormData
        formData.append('applications_data', JSON.stringify(applications));
        
        // 5. Collect downloads data as JSON
        const downloads = [];
        document.querySelectorAll('#downloadsContainer .download-item').forEach((item, index) => {
            const label = item.querySelector('.download-label')?.value.trim() || '';
            const url = item.querySelector('.download-url')?.value.trim() || '';
            const icon = item.querySelector('.download-icon')?.value || 'fas fa-file-pdf';
            
            if (label && url) {
                downloads.push({
                    label: label,
                    url: url,
                    icon: icon
                });
            }
        });
        
        // Add downloads JSON to FormData
        formData.append('downloads_data', JSON.stringify(downloads));
        
        // 6. Send to server
        const categoryId = document.getElementById('categoryId').value;
        const response = await fetch('<?php echo base_url("cms/add_product_item/"); ?>' + "/" + categoryId, {
            method: 'POST',
            body: formData
        });
        
        // 7. Get and parse response
        const text = await response.text();
        console.log('Server response:', text);
        
        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            console.error('JSON Parse Error:', e);
            throw new Error('Invalid response from server');
        }
        
        // 8. Handle response
        if (data.success) {
            Swal.fire({
                title: 'Success!',
                text: data.message || 'Product created successfully',
                icon: 'success',
                confirmButtonColor: '#4f46e5'
            });
            
            // Redirect after success
            if (data.redirect_url) {
                setTimeout(() => {
                    window.location.href = data.redirect_url;
                }, 1500);
            } else {
                // Default redirect to products list
                setTimeout(() => {
                    window.location.href = '<?php echo base_url("cms/product_items/"); ?>' + categoryId;
                }, 1500);
            }
        } else {
            Swal.fire({
                title: 'Error',
                text: data.message || 'Save failed',
                icon: 'error',
                confirmButtonColor: '#4f46e5'
            });
        }
        
    } catch (error) {
        console.error('Save error:', error);
        
        Swal.fire({
            title: 'Error',
            text: error.message || 'Failed to create product',
            icon: 'error',
            confirmButtonColor: '#4f46e5'
        });
        
    } finally {
        // Restore button
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
    }
}
</script>