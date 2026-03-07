<!-- File: application/views/admin/simulation_add.php -->
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

/* Metric Table Styles */
.metrics-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    gap: 15px;
    align-items: center;
    background: #f9fafb;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}

.metrics-header {
    font-weight: 600;
    color: #0b2e46;
    text-align: center;
}

.metrics-row {
    display: contents;
}

.metrics-row .metric-label {
    font-weight: 500;
    color: #374151;
}

.metrics-row input {
    width: 100%;
    padding: 8px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    text-align: center;
}

.metrics-row input:focus {
    outline: none;
    border-color: #4f46e5;
    ring: 2px solid #4f46e5;
}

/* Color coding for metric headers */
.metrics-header.with-simulation {
    color: #ffeb3b;
    background-color: #0b2e46;
    padding: 8px;
    border-radius: 4px;
}

.metrics-header.without-simulation {
    color: #ffeb3b;
    background-color: #0b2e46;
    padding: 8px;
    border-radius: 4px;
}

/* Template for metric rows */
.metric-template {
    display: none;
}
</style>

<main class="ml-64 p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <button type="button" onclick="history.back();" class="text-slate-500 hover:text-indigo-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <h1 class="text-3xl font-bold text-slate-900">
                        Add New Case Study
                    </h1>
                </div>
                <p class="text-slate-500 ml-9">Create a new engineering simulation case study with all details</p>
            </div>
            <div class="flex gap-3">
                <a href="javascript:void(0)" 
                   onclick="history.back()" 
                   class="px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-xl font-medium hover:bg-slate-50 transition-all">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="button" onclick="saveSimulation()" 
                        class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition-all">
                    <i class="fas fa-save mr-2"></i>Create Case Study
                </button>
            </div>
        </div>

        <!-- Main Form -->
        <form id="simulationForm" enctype="multipart/form-data" class="space-y-6">
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
                        <!-- Title -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Title *</label>
                            <input type="text" name="title" required
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                   placeholder="E.g., Structural Analysis of Automotive Chassis">
                        </div>

                        <!-- Client -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Client *</label>
                            <input type="text" name="client" required
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                   placeholder="E.g., Toyota Motors">
                        </div>

                        <!-- Analysis Type - Changed from select to input -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Analysis Type *</label>
                            <input type="text" name="analysis_type" required
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                   placeholder="E.g., Structural Analysis, Thermal Analysis, CFD, etc.">
                        </div>

                        <!-- Main Image Upload -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Main Image *</label>
                            <div class="image-upload-container">
                                <input type="file" 
                                       id="mainImageUpload" 
                                       class="hidden" 
                                       accept="image/*"
                                       onchange="handleMainImageUpload(this.files[0])">
                                
                                <div class="image-upload-area" onclick="document.getElementById('mainImageUpload').click()">
                                    <div class="image-preview" id="mainImagePreview">
                                        <!-- Preview will be shown here -->
                                    </div>
                                    <div class="text-slate-500">
                                        <i class="fas fa-upload text-lg mb-1"></i>
                                        <p class="text-sm font-medium">Click to upload main case study image</p>
                                        <p class="text-xs">JPG, PNG, GIF, WebP (max 2MB)</p>
                                    </div>
                                </div>
                                
                                <input type="hidden" id="mainImageFilename" name="main_image_filename" value="">
                            </div>
                            <p class="text-xs text-slate-500 mt-1">Main featured image for the case study (appears in listings and header)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Abstract Section -->
            <div class="section-card bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-file-alt text-indigo-600 section-icon"></i>
                            <h3 class="text-lg font-bold text-slate-800">Abstract</h3>
                        </div>
                        <span class="text-sm text-slate-500">Click to expand/collapse</span>
                    </div>
                </div>
                <div class="section-content">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Abstract *</label>
                        <textarea name="abstract" rows="4" required
                                  class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                  placeholder="Brief summary of the case study..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Case Study Details Section -->
            <div class="section-card bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-microscope text-indigo-600 section-icon"></i>
                            <h3 class="text-lg font-bold text-slate-800">Case Study Details</h3>
                        </div>
                        <span class="text-sm text-slate-500">Click to expand/collapse</span>
                    </div>
                </div>
                <div class="section-content">
                    <div class="space-y-4">
                        <!-- Problem -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Problem *</label>
                            <textarea name="problem" rows="3" required
                                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                      placeholder="Describe the engineering problem..."></textarea>
                        </div>

                        <!-- Study -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Study *</label>
                            <textarea name="study" rows="3" required
                                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                      placeholder="Describe the study conducted..."></textarea>
                        </div>

                        <!-- Root Cause -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Root Cause *</label>
                            <textarea name="root_cause" rows="2" required
                                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                      placeholder="Identified root cause..."></textarea>
                        </div>

                        <!-- Solution -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Solution *</label>
                            <textarea name="solution" rows="3" required
                                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                      placeholder="Proposed solution..."></textarea>
                        </div>

                        <!-- Qualitative Benefits -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Qualitative Benefits</label>
                            <textarea name="qualitative_benefits" rows="3"
                                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                      placeholder="Describe non-numerical benefits..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metrics Section (Prototype, Testing, Development) -->
            <div class="section-card bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-chart-bar text-indigo-600 section-icon"></i>
                            <h3 class="text-lg font-bold text-slate-800">Performance Metrics</h3>
                        </div>
                        <span class="text-sm text-slate-500">Click to expand/collapse</span>
                    </div>
                </div>
                <div class="section-content">
                    <div class="mb-4 p-3 bg-blue-50 border border-blue-100 rounded-lg">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                            <div>
                                <p class="text-sm text-slate-700">Enter the values for each metric. Reductions will be auto-calculated.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Metrics Header -->
                    <div class="metrics-grid mb-2">
                        <div class="metrics-header">Metric</div>
                        <div class="metrics-header without-simulation">WITHOUT Simulation</div>
                        <div class="metrics-header with-simulation">WITH Simulation</div>
                        <div class="metrics-header">Reduction</div>
                    </div>

                    <!-- Prototype Row -->
                    <div class="metrics-grid mb-2">
                        <div class="metric-label">Prototype</div>
                        <div><input type="text" name="prototype_without" id="prototype_without" value="" placeholder="e.g., 6 units" oninput="calculateReduction('prototype')"></div>
                        <div><input type="text" name="prototype_with" id="prototype_with" value="" placeholder="e.g., 2 units" oninput="calculateReduction('prototype')"></div>
                        <div><input type="text" name="prototype_reduction" id="prototype_reduction" value="" readonly class="bg-slate-100" placeholder="Auto-calculated"></div>
                    </div>

                    <!-- Testing Row -->
                    <div class="metrics-grid mb-2">
                        <div class="metric-label">Testing</div>
                        <div><input type="text" name="testing_without" id="testing_without" value="" placeholder="e.g., 120 hours" oninput="calculateReduction('testing')"></div>
                        <div><input type="text" name="testing_with" id="testing_with" value="" placeholder="e.g., 40 hours" oninput="calculateReduction('testing')"></div>
                        <div><input type="text" name="testing_reduction" id="testing_reduction" value="" readonly class="bg-slate-100" placeholder="Auto-calculated"></div>
                    </div>

                    <!-- Development Row -->
                    <div class="metrics-grid">
                        <div class="metric-label">Development</div>
                        <div><input type="text" name="development_without" id="development_without" value="" placeholder="e.g., 8 months" oninput="calculateReduction('development')"></div>
                        <div><input type="text" name="development_with" id="development_with" value="" placeholder="e.g., 3 months" oninput="calculateReduction('development')"></div>
                        <div><input type="text" name="development_reduction" id="development_reduction" value="" readonly class="bg-slate-100" placeholder="Auto-calculated"></div>
                    </div>

                    <div class="mt-4 text-sm text-slate-500">
                        <i class="fas fa-lightbulb text-yellow-500 mr-1"></i>
                        Tip: Enter numerical values with units (e.g., "6 units", "120 hours", "8 months")
                    </div>
                </div>
            </div>

            <!-- Images Section -->
            <div class="section-card bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-images text-indigo-600 section-icon"></i>
                            <h3 class="text-lg font-bold text-slate-800">Additional Images</h3>
                        </div>
                        <span class="text-sm text-slate-500">Click to expand/collapse</span>
                    </div>
                </div>
                <div class="section-content">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Actual Component Image -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Actual Component Image</label>
                            <div class="image-upload-container">
                                <input type="file" 
                                       id="actualImageUpload" 
                                       class="hidden" 
                                       accept="image/*"
                                       onchange="handleActualImageUpload(this.files[0])">
                                
                                <div class="image-upload-area" onclick="document.getElementById('actualImageUpload').click()">
                                    <div class="image-preview" id="actualImagePreview">
                                        <!-- Preview will be shown here -->
                                    </div>
                                    <div class="text-slate-500">
                                        <i class="fas fa-upload text-lg mb-1"></i>
                                        <p class="text-sm font-medium">Click to upload actual component image</p>
                                        <p class="text-xs">JPG, PNG, GIF, WebP (max 2MB)</p>
                                    </div>
                                </div>
                                
                                <input type="hidden" id="actualImageFilename" name="actual_image_filename" value="">
                            </div>
                            <p class="text-xs text-slate-500 mt-1 text-center">Image of the actual component/part</p>
                        </div>

                        <!-- Simulation Result Image -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Simulation Result Image</label>
                            <div class="image-upload-container">
                                <input type="file" 
                                       id="simulationImageUpload" 
                                       class="hidden" 
                                       accept="image/*"
                                       onchange="handleSimulationImageUpload(this.files[0])">
                                
                                <div class="image-upload-area" onclick="document.getElementById('simulationImageUpload').click()">
                                    <div class="image-preview" id="simulationImagePreview">
                                        <!-- Preview will be shown here -->
                                    </div>
                                    <div class="text-slate-500">
                                        <i class="fas fa-upload text-lg mb-1"></i>
                                        <p class="text-sm font-medium">Click to upload simulation result image</p>
                                        <p class="text-xs">JPG, PNG, GIF, WebP (max 2MB)</p>
                                    </div>
                                </div>
                                
                                <input type="hidden" id="simulationImageFilename" name="simulation_image_filename" value="">
                            </div>
                            <p class="text-xs text-slate-500 mt-1 text-center">Image showing simulation results</p>
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-blue-50 border border-blue-100 rounded-lg">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                            <div>
                                <p class="text-sm text-slate-700 font-medium">Image Guidelines:</p>
                                <ul class="text-xs text-slate-600 mt-1 space-y-1">
                                    <li>• Recommended size: 800x600 pixels or larger</li>
                                    <li>• Supported formats: JPG, PNG, GIF, WebP</li>
                                    <li>• Maximum file size: 2MB per image</li>
                                    <li>• Use clear, high-quality images for best presentation</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Section -->
            <div class="section-card bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-toggle-on text-indigo-600 section-icon"></i>
                            <h3 class="text-lg font-bold text-slate-800">Status & Visibility</h3>
                        </div>
                        <span class="text-sm text-slate-500">Click to expand/collapse</span>
                    </div>
                </div>
                <div class="section-content">
                    <div class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" value="1" checked
                               class="mr-2 h-4 w-4">
                        <label for="is_active" class="text-sm text-slate-700">Active (Visible on website)</label>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">If unchecked, the case study will be saved as draft and not shown publicly</p>
                </div>
            </div>
        </form>
    </div>
</main>

<!-- Include SweetAlert -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>

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

// Calculate reduction for metrics
function calculateReduction(metric) {
    const withoutVal = document.getElementById(`${metric}_without`).value;
    const withVal = document.getElementById(`${metric}_with`).value;
    const reductionField = document.getElementById(`${metric}_reduction`);
    
    if (withoutVal && withVal) {
        // Try to extract numerical values
        const withoutNum = parseFloat(withoutVal.replace(/[^0-9.-]/g, ''));
        const withNum = parseFloat(withVal.replace(/[^0-9.-]/g, ''));
        
        if (!isNaN(withoutNum) && !isNaN(withNum) && withoutNum > 0) {
            const reduction = ((withoutNum - withNum) / withoutNum * 100).toFixed(0);
            
            // Get the unit from the without value
            const unit = withoutVal.replace(/[0-9.-]/g, '').trim();
            
            reductionField.value = `${reduction}% ${unit}`;
        } else {
            reductionField.value = 'Unable to calculate';
        }
    } else {
        reductionField.value = '';
    }
}

// Main Image Upload Functions
function handleMainImageUpload(file) {
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
        const previewArea = document.getElementById('mainImagePreview');
        const filenameInput = document.getElementById('mainImageFilename');
        const uploadArea = document.querySelector('#mainImageUpload').closest('.image-upload-area');
        
        // Generate a unique filename
        const timestamp = Date.now();
        const random = Math.random().toString(36).substring(2, 8);
        const originalName = file.name.replace(/\.[^/.]+$/, "");
        const extension = file.name.split('.').pop();
        const newFilename = `main_${timestamp}_${random}_${originalName}.${extension}`;
        
        // Set the filename in hidden input
        if (filenameInput) {
            filenameInput.value = newFilename;
        }
        
        // Show preview
        if (previewArea) {
            previewArea.innerHTML = `
                <div style="position: relative;">
                    <img src="${e.target.result}" alt="Preview" class="max-h-32 object-contain rounded">
                    <button type="button" onclick="removeMainImage()" class="remove-image-btn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
        }
        
        // Update the upload area text
        const textArea = uploadArea.querySelector('.text-slate-500');
        if (textArea) {
            textArea.innerHTML = `
                <p class="text-sm font-medium text-green-600">Image uploaded</p>
                <p class="text-xs text-slate-500">Click to change</p>
            `;
        }
    };
    reader.readAsDataURL(file);
}

function removeMainImage() {
    const previewArea = document.getElementById('mainImagePreview');
    const filenameInput = document.getElementById('mainImageFilename');
    const fileInput = document.getElementById('mainImageUpload');
    const uploadArea = document.querySelector('#mainImageUpload').closest('.image-upload-area');
    
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
    const textArea = uploadArea.querySelector('.text-slate-500');
    if (textArea) {
        textArea.innerHTML = `
            <i class="fas fa-upload text-lg mb-1"></i>
            <p class="text-sm font-medium">Click to upload main case study image</p>
            <p class="text-xs">JPG, PNG, GIF, WebP (max 2MB)</p>
        `;
    }
}

// Actual Image Upload Functions
function handleActualImageUpload(file) {
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
        const previewArea = document.getElementById('actualImagePreview');
        const filenameInput = document.getElementById('actualImageFilename');
        const uploadArea = document.querySelector('#actualImageUpload').closest('.image-upload-area');
        
        // Generate a unique filename
        const timestamp = Date.now();
        const random = Math.random().toString(36).substring(2, 8);
        const originalName = file.name.replace(/\.[^/.]+$/, "");
        const extension = file.name.split('.').pop();
        const newFilename = `actual_${timestamp}_${random}_${originalName}.${extension}`;
        
        // Set the filename in hidden input
        if (filenameInput) {
            filenameInput.value = newFilename;
        }
        
        // Show preview
        if (previewArea) {
            previewArea.innerHTML = `
                <div style="position: relative;">
                    <img src="${e.target.result}" alt="Preview" class="max-h-32 object-contain rounded">
                    <button type="button" onclick="removeActualImage()" class="remove-image-btn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
        }
        
        // Update the upload area text
        const textArea = uploadArea.querySelector('.text-slate-500');
        if (textArea) {
            textArea.innerHTML = `
                <p class="text-sm font-medium text-green-600">Image uploaded</p>
                <p class="text-xs text-slate-500">Click to change</p>
            `;
        }
    };
    reader.readAsDataURL(file);
}

function removeActualImage() {
    const previewArea = document.getElementById('actualImagePreview');
    const filenameInput = document.getElementById('actualImageFilename');
    const fileInput = document.getElementById('actualImageUpload');
    const uploadArea = document.querySelector('#actualImageUpload').closest('.image-upload-area');
    
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
    const textArea = uploadArea.querySelector('.text-slate-500');
    if (textArea) {
        textArea.innerHTML = `
            <i class="fas fa-upload text-lg mb-1"></i>
            <p class="text-sm font-medium">Click to upload actual component image</p>
            <p class="text-xs">JPG, PNG, GIF, WebP (max 2MB)</p>
        `;
    }
}

// Simulation Image Upload Functions
function handleSimulationImageUpload(file) {
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
        const previewArea = document.getElementById('simulationImagePreview');
        const filenameInput = document.getElementById('simulationImageFilename');
        const uploadArea = document.querySelector('#simulationImageUpload').closest('.image-upload-area');
        
        // Generate a unique filename
        const timestamp = Date.now();
        const random = Math.random().toString(36).substring(2, 8);
        const originalName = file.name.replace(/\.[^/.]+$/, "");
        const extension = file.name.split('.').pop();
        const newFilename = `simulation_${timestamp}_${random}_${originalName}.${extension}`;
        
        // Set the filename in hidden input
        if (filenameInput) {
            filenameInput.value = newFilename;
        }
        
        // Show preview
        if (previewArea) {
            previewArea.innerHTML = `
                <div style="position: relative;">
                    <img src="${e.target.result}" alt="Preview" class="max-h-32 object-contain rounded">
                    <button type="button" onclick="removeSimulationImage()" class="remove-image-btn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
        }
        
        // Update the upload area text
        const textArea = uploadArea.querySelector('.text-slate-500');
        if (textArea) {
            textArea.innerHTML = `
                <p class="text-sm font-medium text-green-600">Image uploaded</p>
                <p class="text-xs text-slate-500">Click to change</p>
            `;
        }
    };
    reader.readAsDataURL(file);
}

function removeSimulationImage() {
    const previewArea = document.getElementById('simulationImagePreview');
    const filenameInput = document.getElementById('simulationImageFilename');
    const fileInput = document.getElementById('simulationImageUpload');
    const uploadArea = document.querySelector('#simulationImageUpload').closest('.image-upload-area');
    
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
    const textArea = uploadArea.querySelector('.text-slate-500');
    if (textArea) {
        textArea.innerHTML = `
            <i class="fas fa-upload text-lg mb-1"></i>
            <p class="text-sm font-medium">Click to upload simulation result image</p>
            <p class="text-xs">JPG, PNG, GIF, WebP (max 2MB)</p>
        `;
    }
}

// Save Simulation Function with Better Error Handling
async function saveSimulation() {
    const saveBtn = document.querySelector('button[onclick="saveSimulation()"]');
    const originalText = saveBtn.innerHTML;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating...';
    saveBtn.disabled = true;
    
    // Show loading overlay if exists
    const loadingOverlay = document.getElementById('loadingOverlay');
    if (loadingOverlay) loadingOverlay.style.display = 'flex';
    
    try {
        // Get form element
        const form = document.getElementById('simulationForm');
        if (!form) throw new Error('Form not found');
        
        // Validate required fields
        const requiredFields = ['title', 'client', 'analysis_type', 'abstract', 'problem', 'study', 'root_cause', 'solution'];
        for (let field of requiredFields) {
            const input = form.querySelector(`[name="${field}"]`);
            if (!input || !input.value.trim()) {
                throw new Error(`Please fill in the ${field.replace('_', ' ')} field`);
            }
        }
        
        // Validate main image (if required)
        const mainImageInput = document.getElementById('mainImageUpload');
        const mainImageFilename = document.getElementById('mainImageFilename').value;
        if ((!mainImageInput || !mainImageInput.files || !mainImageInput.files[0]) && !mainImageFilename) {
            throw new Error('Please upload a main image');
        }
        
        // Create FormData
        const formData = new FormData(form);
        
        // Add checkbox value
        formData.append('is_active', document.getElementById('is_active').checked ? '1' : '0');
        
        // Add image files to FormData
        const mainFileInput = document.getElementById('mainImageUpload');
        if (mainFileInput && mainFileInput.files && mainFileInput.files[0]) {
            formData.append('main_image_file', mainFileInput.files[0]);
        }
        
        const actualFileInput = document.getElementById('actualImageUpload');
        if (actualFileInput && actualFileInput.files && actualFileInput.files[0]) {
            formData.append('actual_image_file', actualFileInput.files[0]);
        }
        
        const simulationFileInput = document.getElementById('simulationImageUpload');
        if (simulationFileInput && simulationFileInput.files && simulationFileInput.files[0]) {
            formData.append('simulation_image_file', simulationFileInput.files[0]);
        }
        
        // Get the URL
        const url = '<?php echo base_url("cms/add_simulation"); ?>';
        console.log('Sending request to:', url);
        
        // Send to server
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });
        
        // Check if response is OK
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        // Get response text
        const text = await response.text();
        console.log('Raw server response:', text);
        
        // Check if response is empty
        if (!text || text.trim() === '') {
            throw new Error('Server returned empty response');
        }
        
        // Try to parse as JSON
        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            console.error('JSON Parse Error:', e);
            console.error('Response that caused error:', text);
            
            // Show the actual response in an alert for debugging
            Swal.fire({
                title: 'Error - Invalid Response',
                html: `<div class="text-left">
                    <p class="mb-2 font-bold">The server returned invalid JSON:</p>
                    <div class="bg-red-50 p-3 rounded text-sm overflow-auto max-h-60">
                        <pre>${escapeHtml(text.substring(0, 500))}</pre>
                    </div>
                    <p class="mt-2 text-sm">URL: ${url}</p>
                </div>`,
                icon: 'error',
                confirmButtonColor: '#4f46e5',
                width: '600px'
            });
            return;
        }
        
        // Handle response
        if (data.success) {
            Swal.fire({
                title: 'Success!',
                text: data.message || 'Case study created successfully',
                icon: 'success',
                confirmButtonColor: '#4f46e5'
            });
            
            // Redirect after success
            if (data.redirect_url) {
                setTimeout(() => {
                    window.location.href = data.redirect_url;
                }, 1500);
            } else {
                setTimeout(() => {
                    window.location.href = '<?php echo base_url("cms/simulation_analysis"); ?>';
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
            text: error.message || 'Failed to create case study',
            icon: 'error',
            confirmButtonColor: '#4f46e5'
        });
        
    } finally {
        // Restore button
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
        
        // Hide loading overlay
        if (loadingOverlay) loadingOverlay.style.display = 'none';
    }
}

// Helper function to escape HTML for display
function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // You can add any initialization code here
    console.log('Add Simulation form loaded');
});
</script>