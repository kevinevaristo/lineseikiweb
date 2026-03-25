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

/* Spec Builder Styles */
.spec-row {
    display: flex;
    gap: 8px;
    align-items: flex-start;
    padding: 10px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
}
.spec-row .spec-key {
    width: 200px;
    min-width: 200px;
}
.spec-row .spec-values {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.spec-value-row {
    display: flex;
    gap: 6px;
    align-items: flex-start;
    flex-wrap: wrap;
}
.spec-value-row .spec-value-text {
    flex: 1;
    min-width: 150px;
}
.spec-value-row input[type="text"] {
    width: 100%;
}
.spec-img-area {
    display: flex;
    align-items: center;
    gap: 6px;
}
.spec-img-btn {
    padding: 4px 10px;
    background: #f0fdf4;
    color: #16a34a;
    border: 1px dashed #86efac;
    border-radius: 6px;
    cursor: pointer;
    font-size: 12px;
    white-space: nowrap;
}
.spec-img-btn:hover {
    background: #dcfce7;
}
.spec-img-preview {
    position: relative;
    display: inline-block;
}
.spec-img-preview img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
}
.spec-img-preview .spec-img-remove {
    position: absolute;
    top: -6px;
    right: -6px;
    width: 18px;
    height: 18px;
    background: #ef4444;
    color: #fff;
    border: none;
    border-radius: 50%;
    font-size: 10px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
}
.spec-value-row .remove-value-btn {
    padding: 4px 8px;
    background: #fee2e2;
    color: #dc2626;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 12px;
}
.spec-value-row .remove-value-btn:hover {
    background: #fecaca;
}
.add-value-btn {
    padding: 2px 10px;
    background: #e0f2fe;
    color: #0284c7;
    border: 1px dashed #7dd3fc;
    border-radius: 6px;
    cursor: pointer;
    font-size: 12px;
    align-self: flex-start;
}
.add-value-btn:hover {
    background: #bae6fd;
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
        <div class="flex justify-between items-center mb-8 sticky top-0 z-40 bg-gray-50 py-4 -mt-4 -mx-8 px-8 border-b border-slate-200 shadow-sm">
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
                        
                        <!-- Hidden textarea for form submission -->
                        <textarea name="specifications" id="specificationsTextarea" class="hidden"></textarea>

                        <!-- Dynamic Spec Builder -->
                        <div id="specBuilder" class="space-y-3">
                            <!-- Spec rows will be added here -->
                        </div>

                        <button type="button" onclick="addSpecRow()"
                                class="mt-3 px-4 py-2 bg-indigo-50 text-indigo-600 border border-dashed border-indigo-300 rounded-lg hover:bg-indigo-100 transition-colors text-sm">
                            <i class="fas fa-plus mr-1"></i> Add Specification
                        </button>

                        <div class="mt-3 p-3 bg-blue-50 border border-blue-100 rounded-lg">
                            <div class="flex items-start gap-2">
                                <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                                <div>
                                    <p class="text-sm text-slate-700 font-medium">Guide:</p>
                                    <ul class="text-xs text-slate-600 mt-1 space-y-1">
                                        <li>• Each specification has a key and one or more values</li>
                                        <li>• Click "+ Add Value" to add multiple values to a single key</li>
                                        <li>• Use the "Format" button to auto-organize from pasted text</li>
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

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Label *</label>
                                    <input type="text"
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none download-label"
                                        placeholder="Catalog(EN)" required>
                                </div>

                                <!-- Upload or URL toggle -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">File Source</label>
                                    <div class="flex gap-2 mb-3">
                                        <button type="button" onclick="toggleDownloadMode(this, 'upload')"
                                                class="dl-mode-btn dl-mode-upload px-3 py-1.5 text-sm rounded-lg border font-medium transition-colors bg-indigo-600 text-white border-indigo-600">
                                            <i class="fas fa-upload mr-1"></i> Upload File
                                        </button>
                                        <button type="button" onclick="toggleDownloadMode(this, 'url')"
                                                class="dl-mode-btn dl-mode-url px-3 py-1.5 text-sm rounded-lg border font-medium transition-colors bg-white text-slate-600 border-slate-300 hover:bg-slate-50">
                                            <i class="fas fa-link mr-1"></i> Enter URL
                                        </button>
                                    </div>

                                    <!-- File Upload Area -->
                                    <div class="dl-upload-area">
                                        <div class="border-2 border-dashed border-slate-300 rounded-lg p-4 text-center hover:border-indigo-400 transition-colors cursor-pointer dl-dropzone"
                                             onclick="this.querySelector('.dl-file-input').click()">
                                            <i class="fas fa-cloud-upload-alt text-slate-400 text-2xl mb-2"></i>
                                            <p class="text-sm text-slate-600">Click to upload or drag & drop</p>
                                            <p class="text-xs text-slate-400 mt-1">PDF, DOC, DOCX, XLS, XLSX, ZIP, JPG, PNG (Max 10MB)</p>
                                            <input type="file" class="hidden dl-file-input" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar,.jpg,.jpeg,.png,.gif,.webp"
                                                   onchange="handleDownloadFileSelect(this)">
                                        </div>
                                        <!-- Upload progress -->
                                        <div class="dl-upload-progress hidden mt-2">
                                            <div class="flex items-center gap-2">
                                                <div class="flex-1 bg-slate-200 rounded-full h-2">
                                                    <div class="bg-indigo-600 h-2 rounded-full transition-all dl-progress-bar" style="width: 0%"></div>
                                                </div>
                                                <span class="text-xs text-slate-500 dl-progress-text">0%</span>
                                            </div>
                                        </div>
                                        <!-- Uploaded file info -->
                                        <div class="dl-file-info hidden mt-2 p-3 bg-green-50 border border-green-200 rounded-lg">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-file-alt text-green-600"></i>
                                                    <span class="text-sm text-green-700 dl-file-name font-medium"></span>
                                                    <span class="text-xs text-green-500 dl-file-size"></span>
                                                </div>
                                                <button type="button" onclick="removeUploadedFile(this)" class="text-red-500 hover:text-red-700 text-xs">
                                                    <i class="fas fa-times mr-1"></i>Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- URL Input Area (hidden by default) -->
                                    <div class="dl-url-area hidden">
                                        <input type="url"
                                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none download-url"
                                            placeholder="https://example.com/catalog.pdf">
                                    </div>
                                </div>

                                <!-- Hidden fields -->
                                <input type="hidden" class="download-icon" value="fas fa-file-pdf">
                                <input type="hidden" class="download-url-final" value="">
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
        const urlFinal = dlItem.querySelector('.download-url-final');
        const iconInput = dlItem.querySelector('.download-icon');

        if (labelInput && dl.label) labelInput.value = dl.label;
        if (urlFinal && dl.url) urlFinal.value = dl.url;
        if (iconInput && dl.icon) iconInput.value = dl.icon;

        // If existing download has a URL, show it in URL mode with file info
        if (dl.url) {
            const fileName = dl.url.split('/').pop();
            const isLocalFile = dl.url.startsWith('assets_system/') || dl.url.includes('/assets_system/');
            if (isLocalFile) {
                // Show as uploaded file
                const fileInfo = dlItem.querySelector('.dl-file-info');
                const dropzone = dlItem.querySelector('.dl-dropzone');
                if (fileInfo) {
                    fileInfo.querySelector('.dl-file-name').textContent = fileName;
                    fileInfo.querySelector('.dl-file-size').textContent = '(uploaded)';
                    fileInfo.classList.remove('hidden');
                }
                if (dropzone) dropzone.classList.add('hidden');
            } else {
                // Show in URL mode
                toggleDownloadMode(dlItem.querySelector('.dl-mode-url'), 'url');
                const urlInput = dlItem.querySelector('.download-url');
                if (urlInput) urlInput.value = dl.url;
            }
        }
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

// Toggle between Upload and URL mode
function toggleDownloadMode(btn, mode) {
    const item = btn.closest('.download-item');
    const uploadArea = item.querySelector('.dl-upload-area');
    const urlArea = item.querySelector('.dl-url-area');
    const uploadBtn = item.querySelector('.dl-mode-upload');
    const urlBtn = item.querySelector('.dl-mode-url');

    if (mode === 'upload') {
        uploadArea.classList.remove('hidden');
        urlArea.classList.add('hidden');
        uploadBtn.className = 'dl-mode-btn dl-mode-upload px-3 py-1.5 text-sm rounded-lg border font-medium transition-colors bg-indigo-600 text-white border-indigo-600';
        urlBtn.className = 'dl-mode-btn dl-mode-url px-3 py-1.5 text-sm rounded-lg border font-medium transition-colors bg-white text-slate-600 border-slate-300 hover:bg-slate-50';
    } else {
        uploadArea.classList.add('hidden');
        urlArea.classList.remove('hidden');
        urlBtn.className = 'dl-mode-btn dl-mode-url px-3 py-1.5 text-sm rounded-lg border font-medium transition-colors bg-indigo-600 text-white border-indigo-600';
        uploadBtn.className = 'dl-mode-btn dl-mode-upload px-3 py-1.5 text-sm rounded-lg border font-medium transition-colors bg-white text-slate-600 border-slate-300 hover:bg-slate-50';
    }
}

// Handle file selection and upload
function handleDownloadFileSelect(input) {
    const file = input.files[0];
    if (!file) return;

    const item = input.closest('.download-item');
    const maxSize = 10 * 1024 * 1024; // 10MB

    if (file.size > maxSize) {
        alert('File size must be less than 10MB');
        input.value = '';
        return;
    }

    // Show progress
    const progressWrap = item.querySelector('.dl-upload-progress');
    const progressBar = item.querySelector('.dl-progress-bar');
    const progressText = item.querySelector('.dl-progress-text');
    const dropzone = item.querySelector('.dl-dropzone');
    const fileInfo = item.querySelector('.dl-file-info');

    progressWrap.classList.remove('hidden');
    dropzone.classList.add('hidden');

    // Upload via AJAX
    const formData = new FormData();
    formData.append('download_file', file);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '<?= site_url("cms/upload_download_file") ?>', true);

    xhr.upload.onprogress = function(e) {
        if (e.lengthComputable) {
            const pct = Math.round((e.loaded / e.total) * 100);
            progressBar.style.width = pct + '%';
            progressText.textContent = pct + '%';
        }
    };

    xhr.onload = function() {
        progressWrap.classList.add('hidden');
        try {
            const res = JSON.parse(xhr.responseText);
            if (res.success) {
                // Show file info
                fileInfo.querySelector('.dl-file-name').textContent = res.original_name;
                fileInfo.querySelector('.dl-file-size').textContent = '(' + res.file_size + ')';
                fileInfo.classList.remove('hidden');

                // Set the URL to the uploaded file path
                item.querySelector('.download-url-final').value = res.file_url;

                // Auto-detect icon
                const ext = res.original_name.split('.').pop().toLowerCase();
                const iconMap = {pdf:'fas fa-file-pdf', doc:'fas fa-file-word', docx:'fas fa-file-word', xls:'fas fa-file-excel', xlsx:'fas fa-file-excel', zip:'fas fa-file-archive', rar:'fas fa-file-archive'};
                item.querySelector('.download-icon').value = iconMap[ext] || 'fas fa-file-alt';

                // Auto-fill label if empty
                const labelInput = item.querySelector('.download-label');
                if (!labelInput.value.trim()) {
                    labelInput.value = res.original_name;
                }
            } else {
                alert('Upload failed: ' + (res.message || 'Unknown error'));
                dropzone.classList.remove('hidden');
            }
        } catch(e) {
            alert('Upload failed. Please try again.');
            dropzone.classList.remove('hidden');
        }
    };

    xhr.onerror = function() {
        progressWrap.classList.add('hidden');
        dropzone.classList.remove('hidden');
        alert('Upload failed. Please check your connection.');
    };

    xhr.send(formData);
}

// Remove uploaded file and reset
function removeUploadedFile(btn) {
    const item = btn.closest('.download-item');
    const dropzone = item.querySelector('.dl-dropzone');
    const fileInfo = item.querySelector('.dl-file-info');
    const fileInput = item.querySelector('.dl-file-input');

    fileInfo.classList.add('hidden');
    dropzone.classList.remove('hidden');
    fileInput.value = '';
    item.querySelector('.download-url-final').value = '';
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

// Specifications Builder — helpers
function parseSpecValue(raw) {
    // Extract image marker {{img:filename}} from value text
    const match = raw.match(/\{\{img:(.+?)\}\}/);
    if (match) {
        return { text: raw.replace(match[0], '').trim(), image: match[1] };
    }
    return { text: raw.trim(), image: '' };
}

function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

function buildValueRowHtml(text, image, showRemove) {
    const baseImgUrl = '<?= base_url("assets_system/images/") ?>';
    const imgArea = image
        ? `<div class="spec-img-preview">
               <img src="${baseImgUrl}${image}" onerror="this.style.display='none'">
               <button type="button" class="spec-img-remove" onclick="removeSpecImage(this)"><i class="fas fa-times"></i></button>
           </div>
           <input type="hidden" class="spec-img-filename" value="${escapeHtml(image)}">`
        : `<button type="button" class="spec-img-btn" onclick="triggerSpecImageUpload(this)"><i class="fas fa-image mr-1"></i>Image</button>
           <input type="hidden" class="spec-img-filename" value="">`;

    return `<div class="spec-value-row">
        <div class="spec-value-text">
            <input type="text" class="spec-value-input px-3 py-1.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-sm"
                   value="${escapeHtml(text)}" placeholder="Value" onchange="syncSpecsToTextarea()">
        </div>
        <div class="spec-img-area">${imgArea}</div>
        ${showRemove ? '<button type="button" class="remove-value-btn" onclick="removeSpecValue(this)"><i class="fas fa-times"></i></button>' : ''}
    </div>`;
}

// Core spec builder functions
function addSpecRow(key = '', valuesRaw = ['']) {
    const builder = document.getElementById('specBuilder');
    const row = document.createElement('div');
    row.className = 'spec-row';

    const parsed = valuesRaw.map(v => parseSpecValue(v));
    let valuesHtml = parsed.map((p, i) =>
        buildValueRowHtml(p.text, p.image, valuesRaw.length > 1)
    ).join('');

    row.innerHTML = `
        <div class="spec-key">
            <input type="text" class="spec-key-input w-full px-3 py-1.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-sm font-medium"
                   value="${escapeHtml(key)}" placeholder="Key (e.g. Power Supply)" onchange="syncSpecsToTextarea()">
        </div>
        <div class="spec-values">
            ${valuesHtml}
            <button type="button" class="add-value-btn" onclick="addSpecValue(this)">
                <i class="fas fa-plus mr-1"></i> Add Value
            </button>
        </div>
        <button type="button" class="px-2 py-1.5 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" onclick="removeSpecRow(this)">
            <i class="fas fa-trash"></i>
        </button>
    `;

    builder.appendChild(row);
    syncSpecsToTextarea();
}

function addSpecValue(btn) {
    const valuesContainer = btn.parentElement;
    const newRow = document.createElement('div');
    newRow.className = 'spec-value-row';
    newRow.innerHTML = `
        <div class="spec-value-text">
            <input type="text" class="spec-value-input px-3 py-1.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-sm"
                   value="" placeholder="Value" onchange="syncSpecsToTextarea()">
        </div>
        <div class="spec-img-area">
            <button type="button" class="spec-img-btn" onclick="triggerSpecImageUpload(this)"><i class="fas fa-image mr-1"></i>Image</button>
            <input type="hidden" class="spec-img-filename" value="">
        </div>
        <button type="button" class="remove-value-btn" onclick="removeSpecValue(this)"><i class="fas fa-times"></i></button>
    `;
    valuesContainer.insertBefore(newRow, btn);

    // Ensure all rows have remove button when >1
    const valueRows = valuesContainer.querySelectorAll('.spec-value-row');
    if (valueRows.length > 1) {
        valueRows.forEach(vr => {
            if (!vr.querySelector('.remove-value-btn')) {
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'remove-value-btn';
                removeBtn.onclick = function() { removeSpecValue(this); };
                removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                vr.appendChild(removeBtn);
            }
        });
    }
    syncSpecsToTextarea();
}

function removeSpecValue(btn) {
    const valueRow = btn.closest('.spec-value-row');
    const valuesContainer = valueRow.parentElement;
    valueRow.remove();
    const remaining = valuesContainer.querySelectorAll('.spec-value-row');
    if (remaining.length === 1) {
        const rmBtn = remaining[0].querySelector('.remove-value-btn');
        if (rmBtn) rmBtn.remove();
    }
    syncSpecsToTextarea();
}

function removeSpecRow(btn) {
    btn.closest('.spec-row').remove();
    syncSpecsToTextarea();
}

// Image upload for spec values
function triggerSpecImageUpload(btn) {
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = 'image/*';
    fileInput.onchange = function() {
        if (this.files && this.files[0]) {
            uploadSpecImage(this.files[0], btn);
        }
    };
    fileInput.click();
}

function uploadSpecImage(file, btn) {
    if (file.size > 2 * 1024 * 1024) {
        Swal.fire({ title: 'File too large', text: 'Max 2MB', icon: 'error', timer: 2000, showConfirmButton: false });
        return;
    }

    const formData = new FormData();
    formData.append('spec_image', file);

    const imgArea = btn.closest('.spec-img-area');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    btn.disabled = true;

    fetch('<?= site_url("cms/upload_spec_image") ?>', { method: 'POST', body: formData, credentials: 'same-origin' })
        .then(r => r.json())
        .then(data => {
            if (data.success && data.file_name) {
                const imgUrl = '<?= base_url("assets_system/images/") ?>' + data.file_name;
                imgArea.innerHTML = `
                    <div class="spec-img-preview">
                        <img src="${imgUrl}">
                        <button type="button" class="spec-img-remove" onclick="removeSpecImage(this)"><i class="fas fa-times"></i></button>
                    </div>
                    <input type="hidden" class="spec-img-filename" value="${data.file_name}">`;
                syncSpecsToTextarea();
            } else {
                Swal.fire({ title: 'Upload failed', text: data.message || 'Unknown error', icon: 'error', timer: 2000, showConfirmButton: false });
                btn.innerHTML = '<i class="fas fa-image mr-1"></i>Image';
                btn.disabled = false;
            }
        })
        .catch(err => {
            Swal.fire({ title: 'Upload error', text: err.message, icon: 'error', timer: 2000, showConfirmButton: false });
            btn.innerHTML = '<i class="fas fa-image mr-1"></i>Image';
            btn.disabled = false;
        });
}

function removeSpecImage(btn) {
    const imgArea = btn.closest('.spec-img-area');
    imgArea.innerHTML = `
        <button type="button" class="spec-img-btn" onclick="triggerSpecImageUpload(this)"><i class="fas fa-image mr-1"></i>Image</button>
        <input type="hidden" class="spec-img-filename" value="">`;
    syncSpecsToTextarea();
}

// Sync builder state to hidden textarea
function syncSpecsToTextarea() {
    const rows = document.querySelectorAll('#specBuilder .spec-row');
    const lines = [];
    rows.forEach(row => {
        const key = row.querySelector('.spec-key-input').value.trim();
        if (!key) return;
        const valueRows = row.querySelectorAll('.spec-value-row');
        const vals = [];
        valueRows.forEach(vr => {
            const text = vr.querySelector('.spec-value-input').value.trim();
            const img = vr.querySelector('.spec-img-filename')?.value || '';
            if (!text && !img) return;
            let val = text;
            if (img) val += '{{img:' + img + '}}';
            vals.push(val);
        });
        if (vals.length > 0) {
            lines.push(key + ': ' + vals.join(' | '));
        }
    });
    document.getElementById('specificationsTextarea').value = lines.join('\n');
}

// Format: parse pasted text into the spec builder
function formatSpecs() {
    const builder = document.getElementById('specBuilder');
    const textarea = document.getElementById('specificationsTextarea');
    syncSpecsToTextarea();
    const text = textarea.value.trim();

    if (!text) {
        Swal.fire({ title: 'Nothing to format', icon: 'info', timer: 1500, showConfirmButton: false });
        return;
    }

    builder.innerHTML = '';
    const lines = text.split('\n');
    lines.forEach(line => {
        const trimmed = line.trim();
        if (!trimmed) return;
        if (trimmed.includes(':')) {
            const colonIdx = trimmed.indexOf(':');
            const key = trimmed.substring(0, colonIdx).trim();
            const valPart = trimmed.substring(colonIdx + 1).trim();
            const values = valPart.split('|').map(v => v.trim()).filter(v => v);
            addSpecRow(key, values.length > 0 ? values : ['']);
        } else {
            addSpecRow(trimmed, ['']);
        }
    });

    Swal.fire({ title: 'Formatted!', text: 'Specifications have been organized.', icon: 'success', timer: 1500, showConfirmButton: false });
}

function clearSpecs() {
    Swal.fire({
        title: 'Clear Specifications?',
        text: 'This will remove all specifications.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Clear All',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#ef4444',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('specBuilder').innerHTML = '';
            document.getElementById('specificationsTextarea').value = '';
            Swal.fire({ title: 'Cleared!', icon: 'success', timer: 1500, showConfirmButton: false });
        }
    });
}

// Initialize with one empty row
document.addEventListener('DOMContentLoaded', function() {
    addSpecRow();
});

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
            // Get URL from either the uploaded file or the manual URL input
            const urlFinal = item.querySelector('.download-url-final')?.value.trim() || '';
            const urlManual = item.querySelector('.download-url')?.value.trim() || '';
            const url = urlFinal || urlManual;
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