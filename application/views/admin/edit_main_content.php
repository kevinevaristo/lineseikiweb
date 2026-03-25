<!-- File: application/views/admin/simulation_edit.php -->
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

/* Current Image Display */
.current-image {
    margin-top: 10px;
    padding: 10px;
    background: #f8fafc;
    border-radius: 6px;
    border: 1px solid #e5e7eb;
}

.current-image p {
    font-size: 0.85rem;
    color: #4b5563;
    margin-bottom: 5px;
}

.current-image img {
    max-width: 100%;
    max-height: 80px;
    object-fit: contain;
    border-radius: 4px;
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

/* Status badge */
.status-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
}

.status-active {
    background-color: #d1fae5;
    color: #065f46;
}

.status-inactive {
    background-color: #fee2e2;
    color: #991b1b;
}

/* Loading overlay */
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255,255,255,0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    display: none;
}

.loading-spinner {
    width: 50px;
    height: 50px;
    border: 5px solid #f3f3f3;
    border-top: 5px solid #4f46e5;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<main class="ml-64 p-8">
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8 sticky top-0 z-40 bg-gray-50 py-4 -mt-4 -mx-8 px-8 border-b border-slate-200 shadow-sm">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <button type="button" onclick="history.back();" class="text-slate-500 hover:text-indigo-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <h1 class="text-3xl font-bold text-slate-900">
                        Edit Case Study
                    </h1>
                </div>
                <p class="text-slate-500 ml-9">Update the engineering simulation case study details</p>
            </div>
            <div class="flex gap-3">
                <a href="javascript:void(0)" 
                   onclick="history.back()" 
                   class="px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-xl font-medium hover:bg-slate-50 transition-all">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="button" onclick="updateSimulation(<?php echo $simulation->id; ?>)" 
                        class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition-all">
                    <i class="fas fa-save mr-2"></i>Update Case Study
                </button>
            </div>
        </div>

        <!-- Main Form -->
        <form id="simulationForm" enctype="multipart/form-data" class="space-y-6">
            <input type="hidden" name="id" value="<?php echo $simulation->id; ?>">
            
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
                                   value="<?php echo htmlspecialchars($simulation->title); ?>"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                   placeholder="E.g., Structural Analysis of Automotive Chassis">
                        </div>

                        <!-- Client -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Client *</label>
                            <input type="text" name="client" required
                                   value="<?php echo htmlspecialchars($simulation->client); ?>"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                   placeholder="E.g., Toyota Motors">
                        </div>

                        <!-- Analysis Type -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Analysis Type *</label>
                            <input type="text" name="analysis_type" required
                                   value="<?php echo htmlspecialchars($simulation->analysis_type); ?>"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                   placeholder="E.g., Structural Analysis, Thermal Analysis, CFD, etc.">
                        </div>

                        <!-- Main Image Upload -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Main Image</label>
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
                                        <p class="text-sm font-medium">Click to upload new main image</p>
                                        <p class="text-xs">JPG, PNG, GIF, WebP (max 2MB)</p>
                                    </div>
                                </div>
                                
                                <input type="hidden" id="mainImageFilename" name="main_image_filename" value="<?php echo $simulation->main_image; ?>">
                            </div>
                            
                            <!-- Current Image Display -->
                            <?php if (!empty($simulation->main_image)): ?>
                            <div class="current-image">
                                <p class="text-sm font-medium text-slate-700">Current Image:</p>
                                <img src="<?php echo base_url('assets_system/images/' . $simulation->main_image); ?>" 
                                     alt="Current Main Image"
                                     onerror="this.src='<?php echo base_url('assets_system/images/no-image.png'); ?>'">
                                <p class="text-xs text-slate-500 mt-1"><?php echo $simulation->main_image; ?></p>
                            </div>
                            <?php endif; ?>
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
                                  placeholder="Brief summary of the case study..."><?php echo htmlspecialchars($simulation->abstract); ?></textarea>
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
                                      placeholder="Describe the engineering problem..."><?php echo htmlspecialchars($simulation->problem); ?></textarea>
                        </div>

                        <!-- Study -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Study *</label>
                            <textarea name="study" rows="3" required
                                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                      placeholder="Describe the study conducted..."><?php echo htmlspecialchars($simulation->study); ?></textarea>
                        </div>

                        <!-- Root Cause -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Root Cause *</label>
                            <textarea name="root_cause" rows="2" required
                                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                      placeholder="Identified root cause..."><?php echo htmlspecialchars($simulation->root_cause); ?></textarea>
                        </div>

                        <!-- Solution -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Solution *</label>
                            <textarea name="solution" rows="3" required
                                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                      placeholder="Proposed solution..."><?php echo htmlspecialchars($simulation->solution); ?></textarea>
                        </div>

                        <!-- Qualitative Benefits -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Qualitative Benefits</label>
                            <textarea name="qualitative_benefits" rows="3"
                                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                      placeholder="Describe non-numerical benefits..."><?php echo htmlspecialchars($simulation->qualitative_benefits); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metrics Section -->
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
                        <div><input type="text" name="prototype_without" id="prototype_without" 
                                   value="<?php echo htmlspecialchars($simulation->prototype_without); ?>" 
                                   placeholder="e.g., 6 units" oninput="calculateReduction('prototype')"></div>
                        <div><input type="text" name="prototype_with" id="prototype_with" 
                                   value="<?php echo htmlspecialchars($simulation->prototype_with); ?>" 
                                   placeholder="e.g., 2 units" oninput="calculateReduction('prototype')"></div>
                        <div><input type="text" name="prototype_reduction" id="prototype_reduction" 
                                   value="<?php echo htmlspecialchars($simulation->prototype_reduction); ?>" 
                                   readonly class="bg-slate-100" placeholder="Auto-calculated"></div>
                    </div>

                    <!-- Testing Row -->
                    <div class="metrics-grid mb-2">
                        <div class="metric-label">Testing</div>
                        <div><input type="text" name="testing_without" id="testing_without" 
                                   value="<?php echo htmlspecialchars($simulation->testing_without); ?>" 
                                   placeholder="e.g., 120 hours" oninput="calculateReduction('testing')"></div>
                        <div><input type="text" name="testing_with" id="testing_with" 
                                   value="<?php echo htmlspecialchars($simulation->testing_with); ?>" 
                                   placeholder="e.g., 40 hours" oninput="calculateReduction('testing')"></div>
                        <div><input type="text" name="testing_reduction" id="testing_reduction" 
                                   value="<?php echo htmlspecialchars($simulation->testing_reduction); ?>" 
                                   readonly class="bg-slate-100" placeholder="Auto-calculated"></div>
                    </div>

                    <!-- Development Row -->
                    <div class="metrics-grid">
                        <div class="metric-label">Development</div>
                        <div><input type="text" name="development_without" id="development_without" 
                                   value="<?php echo htmlspecialchars($simulation->development_without); ?>" 
                                   placeholder="e.g., 8 months" oninput="calculateReduction('development')"></div>
                        <div><input type="text" name="development_with" id="development_with" 
                                   value="<?php echo htmlspecialchars($simulation->development_with); ?>" 
                                   placeholder="e.g., 3 months" oninput="calculateReduction('development')"></div>
                        <div><input type="text" name="development_reduction" id="development_reduction" 
                                   value="<?php echo htmlspecialchars($simulation->development_reduction); ?>" 
                                   readonly class="bg-slate-100" placeholder="Auto-calculated"></div>
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
                                        <p class="text-sm font-medium">Click to upload new actual component image</p>
                                        <p class="text-xs">JPG, PNG, GIF, WebP (max 2MB)</p>
                                    </div>
                                </div>
                                
                                <input type="hidden" id="actualImageFilename" name="actual_image_filename" 
                                       value="<?php echo $simulation->actual_image_filename; ?>">
                            </div>
                            
                            <!-- Current Image Display -->
                            <?php if (!empty($simulation->actual_image_filename)): ?>
                            <div class="current-image">
                                <p class="text-sm font-medium text-slate-700">Current Image:</p>
                                <img src="<?php echo base_url('assets_system/images/' . $simulation->actual_image_filename); ?>" 
                                     alt="Current Actual Image"
                                     onerror="this.src='<?php echo base_url('assets_system/images/no-image.png'); ?>'">
                                <p class="text-xs text-slate-500 mt-1"><?php echo $simulation->actual_image_filename; ?></p>
                            </div>
                            <?php endif; ?>
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
                                        <p class="text-sm font-medium">Click to upload new simulation result image</p>
                                        <p class="text-xs">JPG, PNG, GIF, WebP (max 2MB)</p>
                                    </div>
                                </div>
                                
                                <input type="hidden" id="simulationImageFilename" name="simulation_image_filename" 
                                       value="<?php echo $simulation->simulation_image_filename; ?>">
                            </div>
                            
                            <!-- Current Image Display -->
                            <?php if (!empty($simulation->simulation_image_filename)): ?>
                            <div class="current-image">
                                <p class="text-sm font-medium text-slate-700">Current Image:</p>
                                <img src="<?php echo base_url('assets_system/images/' . $simulation->simulation_image_filename); ?>" 
                                     alt="Current Simulation Image"
                                     onerror="this.src='<?php echo base_url('assets_system/images/no-image.png'); ?>'">
                                <p class="text-xs text-slate-500 mt-1"><?php echo $simulation->simulation_image_filename; ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-blue-50 border border-blue-100 rounded-lg">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                            <div>
                                <p class="text-sm text-slate-700 font-medium">Image Guidelines:</p>
                                <ul class="text-xs text-slate-600 mt-1 space-y-1">
                                    <li>• Leave empty to keep current images</li>
                                    <li>• Upload new image only if you want to replace the current one</li>
                                    <li>• Recommended size: 800x600 pixels or larger</li>
                                    <li>• Supported formats: JPG, PNG, GIF, WebP</li>
                                    <li>• Maximum file size: 2MB per image</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metadata Section (Read-only) -->
            <div class="section-card bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-clock text-indigo-600 section-icon"></i>
                            <h3 class="text-lg font-bold text-slate-800">Metadata</h3>
                        </div>
                        <span class="text-sm text-slate-500">Click to expand/collapse</span>
                    </div>
                </div>
                <div class="section-content">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Created At</label>
                            <input type="text" value="<?php echo date('F j, Y g:i A', strtotime($simulation->created_at)); ?>" 
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-slate-600" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Last Updated</label>
                            <input type="text" value="<?php echo date('F j, Y g:i A', strtotime($simulation->updated_at)); ?>" 
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-slate-600" readonly>
                        </div>
                    </div>
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
                <p class="text-sm font-medium text-green-600">New image selected</p>
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
    
    // Clear filename (set to empty string to keep current image)
    if (filenameInput) {
        filenameInput.value = '<?php echo $simulation->main_image; ?>';
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
            <p class="text-sm font-medium">Click to upload new main image</p>
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
                <p class="text-sm font-medium text-green-600">New image selected</p>
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
    
    // Clear filename (set to empty string to keep current image)
    if (filenameInput) {
        filenameInput.value = '<?php echo $simulation->actual_image_filename; ?>';
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
            <p class="text-sm font-medium">Click to upload new actual component image</p>
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
                <p class="text-sm font-medium text-green-600">New image selected</p>
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
    
    // Clear filename (set to empty string to keep current image)
    if (filenameInput) {
        filenameInput.value = '<?php echo $simulation->simulation_image_filename; ?>';
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
            <p class="text-sm font-medium">Click to upload new simulation result image</p>
            <p class="text-xs">JPG, PNG, GIF, WebP (max 2MB)</p>
        `;
    }
}

// Update Simulation Function - with better error handling
async function updateSimulation(id) {
    const saveBtn = document.querySelector('button[onclick="updateSimulation(' + id + ')"]');
    const originalText = saveBtn.innerHTML;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
    saveBtn.disabled = true;
    
    // Show loading overlay
    document.getElementById('loadingOverlay').style.display = 'flex';
    
    try {
        // Get form element
        const form = document.getElementById('simulationForm');
        if (!form) throw new Error('Form not found');
        
        // Create FormData
        const formData = new FormData(form);
        
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
        
        // Log the URL being called
        const url = '<?php echo base_url("cms/update/"); ?>' + '/' + id;
        console.log('Calling URL:', url);
        
        // Send to server
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });
        
        // Get the response text first
        const text = await response.text();
        console.log('Raw server response:', text.substring(0, 500)); // Log first 500 chars
        
        // Try to parse as JSON
        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            console.error('JSON Parse Error:', e);
            console.error('Response that caused error:', text);
            
            // Show the actual HTML response in SweetAlert for debugging
            Swal.fire({
                title: 'Error - Invalid Response',
                html: `<div class="text-left">
                    <p class="mb-2">The server returned HTML instead of JSON. This could be:</p>
                    <ul class="list-disc pl-5 mb-3">
                        <li>Wrong URL (404 page)</li>
                        <li>PHP error in the controller</li>
                        <li>Authentication redirect</li>
                    </ul>
                    <p class="font-bold mt-2">URL called: ${url}</p>
                    <p class="mt-2 text-sm bg-red-50 p-2 rounded">First 200 chars of response: ${text.substring(0, 200)}</p>
                </div>`,
                icon: 'error',
                confirmButtonColor: '#4f46e5'
            });
            return;
        }
        
        // Handle response
        if (data.success) {
            Swal.fire({
                title: 'Success!',
                text: data.message || 'Case study updated successfully',
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
                text: data.message || 'Update failed',
                icon: 'error',
                confirmButtonColor: '#4f46e5'
            });
        }
        
    } catch (error) {
        console.error('Update error:', error);
        
        Swal.fire({
            title: 'Error',
            text: error.message || 'Failed to update case study',
            icon: 'error',
            confirmButtonColor: '#4f46e5'
        });
        
    } finally {
        // Restore button
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
        
        // Hide loading overlay
        document.getElementById('loadingOverlay').style.display = 'none';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Edit Simulation form loaded');
    
    // Initialize all sections as expanded
    document.querySelectorAll('.section-card').forEach(section => {
        section.classList.remove('section-collapsed');
        const content = section.querySelector('.section-content');
        if (content) {
            content.style.maxHeight = content.scrollHeight + 'px';
        }
    });
});
</script>