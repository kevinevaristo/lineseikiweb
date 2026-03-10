<?php $this->load->view('admin/header'); ?>

<main class="ml-64 p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Flash Messages -->
        <?php if($this->session->flashdata('success')): ?>
        <div id="successMessage" class="hidden" data-message="<?php echo htmlspecialchars($this->session->flashdata('success')); ?>"></div>
        <?php endif; ?>
        
        <?php if($this->session->flashdata('error')): ?>
        <div id="errorMessage" class="hidden" data-message="<?php echo htmlspecialchars($this->session->flashdata('error')); ?>"></div>
        <?php endif; ?>
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Edit Resource</h1>
                <p class="text-slate-500 mt-1">Update resource details and upload images or PDF files.</p>
            </div>
            <div class="flex gap-3">
                <a href="<?php echo site_url('cms/library'); ?>" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-50 transition-all flex items-center">
                    <i class="fas fa-arrow-left mr-2 text-xs"></i> Back to Resources
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <form method="POST" action="<?php echo site_url('cms/library_edit/' . $resource['id']); ?>" enctype="multipart/form-data">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Basic Information -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Resource Title *</label>
                            <input type="text" name="title" required 
                                   value="<?php echo isset($resource['title']) ? htmlspecialchars($resource['title']) : ''; ?>"
                                   class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Content Description *</label>
                            <textarea name="content" rows="4" required 
                                      class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"><?php echo isset($resource['content']) ? htmlspecialchars($resource['content']) : ''; ?></textarea>
                            <p class="text-xs text-slate-500 mt-2">
                                Include action text at the end: "- Watch Now" for videos or "- Download PDF" for documents
                            </p>
                        </div>
                        
                        <!-- Resource Type -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Resource Type</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="resource-type-option border-2 border-slate-200 rounded-xl p-4 cursor-pointer hover:border-indigo-300 transition-colors <?php echo (isset($resource['content']) && (stripos($resource['content'], 'Watch Now') !== false || stripos($resource['content'], 'Watch') !== false)) ? 'border-indigo-500 bg-indigo-50' : ''; ?>" data-type="video">
                                    <div class="flex items-center mb-2">
                                        <input type="radio" id="type_video" name="resource_type" value="video" class="mr-2" <?php echo (isset($resource['content']) && (stripos($resource['content'], 'Watch Now') !== false || stripos($resource['content'], 'Watch') !== false)) ? 'checked' : ''; ?>>
                                        <label for="type_video" class="text-sm font-bold text-slate-700">Video (with image)</label>
                                    </div>
                                    <p class="text-xs text-slate-500">End content with "- Watch Now"</p>
                                </div>
                                
                                <div class="resource-type-option border-2 border-slate-200 rounded-xl p-4 cursor-pointer hover:border-indigo-300 transition-colors <?php echo (isset($resource['content']) && stripos($resource['content'], 'Download PDF') !== false) ? 'border-indigo-500 bg-indigo-50' : ''; ?>" data-type="pdf">
                                    <div class="flex items-center mb-2">
                                        <input type="radio" id="type_pdf" name="resource_type" value="pdf" class="mr-2" <?php echo (isset($resource['content']) && stripos($resource['content'], 'Download PDF') !== false) ? 'checked' : ''; ?>>
                                        <label for="type_pdf" class="text-sm font-bold text-slate-700">PDF Document</label>
                                    </div>
                                    <p class="text-xs text-slate-500">End content with "- Download PDF"</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Gated Content Checkbox -->
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" 
                                           name="is_gated" 
                                           id="is_gated" 
                                           value="1"
                                           class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500"
                                           <?php echo (isset($resource['is_gated']) && $resource['is_gated'] == 1) ? 'checked' : ''; ?>>
                                </div>
                                <div class="ml-3">
                                    <label for="is_gated" class="text-sm font-bold text-slate-700 cursor-pointer">Gated Content</label>
                                    <p class="text-xs text-slate-500 mt-1">Require users to submit their information before accessing this resource</p>
                                </div>
                            </div>
                            
                            <!-- Gated Content Info (shown when checked) -->
                            <div id="gatedContentInfo" class="mt-4 p-4 bg-indigo-50 border border-indigo-200 rounded-lg <?php echo (isset($resource['is_gated']) && $resource['is_gated'] == 1) ? '' : 'hidden'; ?>">
                                <div class="flex items-start">
                                    <i class="fas fa-lock text-indigo-600 mt-0.5 mr-3"></i>
                                    <div>
                                        <h4 class="text-sm font-semibold text-indigo-800">Gated Resource Settings</h4>
                                        <p class="text-xs text-indigo-600 mt-1">Users will need to fill out a form with their name and email before accessing this resource. The form data will be collected and stored for follow-up.</p>
                                        <div class="mt-3 flex items-center text-xs text-indigo-700">
                                            <i class="fas fa-database mr-1"></i>
                                            <span>Lead capture data will be available in the admin panel</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Video Section -->
                        <div id="videoSection" class="upload-section space-y-6 <?php echo (isset($resource['content']) && stripos($resource['content'], 'Download PDF') !== false) ? 'hidden' : ''; ?>">
                            <!-- Video URL -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Video URL</label>
                                    <input type="url"
                                           name="video_url"
                                           class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                                           placeholder="https://youtube.com/watch?v=..."
                                           value="<?= !empty($resource['video_url']) 
                                               ? htmlspecialchars($resource['video_url'], ENT_QUOTES, 'UTF-8') 
                                               : '' ?>">
                                </div>
                            </div>
                            
                            <!-- Image Upload Section -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Thumbnail Image</label>
                                <div class="space-y-4">
                                    <!-- Current Image Preview -->
                                    <?php if(isset($resource['image']) && !empty($resource['image'])): ?>
                                    <div class="mb-4">
                                        <p class="text-sm font-medium text-slate-700 mb-2">Current Image:</p>
                                        <div class="flex items-start gap-4">
                                            <div class="w-48 h-32 bg-slate-100 rounded-lg border border-slate-200 overflow-hidden">
                                                <img id="currentImagePreview" 
                                                     src="<?php echo base_url('assets_system/images/' . $resource['image']); ?>" 
                                                     alt="<?php echo isset($resource['title']) ? htmlspecialchars($resource['title']) : 'Current Image'; ?>" 
                                                     class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex-1">
                                                <div class="mb-2">
                                                    <span class="text-sm text-slate-600">File: </span>
                                                    <span class="text-sm font-medium text-slate-800"><?php echo $resource['image']; ?></span>
                                                </div>
                                                <div class="flex gap-2">
                                                    <button type="button" onclick="removeCurrentImage()" class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-sm font-medium hover:bg-red-100 transition-colors">
                                                        <i class="fas fa-trash mr-1"></i> Remove Image
                                                    </button>
                                                    <a href="<?php echo base_url('assets_system/images/' . $resource['image']); ?>" 
                                                       target="_blank" 
                                                       class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-sm font-medium hover:bg-blue-100 transition-colors">
                                                        <i class="fas fa-external-link-alt mr-1"></i> View Full Size
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="current_image" name="current_image" value="<?php echo $resource['image']; ?>">
                                        <input type="hidden" id="remove_image" name="remove_image" value="0">
                                    </div>
                                    <?php endif; ?>
                                    
                                    <!-- Upload New Image -->
                                    <div>
                                        <p class="text-sm font-medium text-slate-700 mb-2">Upload New Image:</p>
                                        <div class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:border-indigo-400 transition-colors cursor-pointer" id="imageUploadArea">
                                            <i class="fas fa-cloud-upload-alt text-slate-400 text-3xl mb-3"></i>
                                            <p class="text-sm text-slate-600">Click to upload new image</p>
                                            <p class="text-xs text-slate-400 mt-1">JPG, PNG, GIF, WEBP (Max 2MB)</p>
                                            <input type="file" name="image_file" id="imageFile" class="hidden" accept="image/*">
                                        </div>
                                        
                                        <!-- New Image Preview -->
                                        <div id="newImagePreview" class="mt-4 hidden">
                                            <p class="text-sm font-medium text-slate-700 mb-2">New Image Preview:</p>
                                            <div class="flex items-start gap-4">
                                                <div class="w-48 h-32 bg-slate-100 rounded-lg border border-slate-200 overflow-hidden">
                                                    <img id="uploadedImagePreview" src="" alt="Preview" class="w-full h-full object-cover">
                                                </div>
                                                <div class="flex-1">
                                                    <div class="mb-2">
                                                        <span class="text-sm text-slate-600">File: </span>
                                                        <span id="uploadedFileName" class="text-sm font-medium text-slate-800"></span>
                                                    </div>
                                                    <button type="button" onclick="removeUploadedImage()" class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-sm font-medium hover:bg-red-100 transition-colors">
                                                        <i class="fas fa-times mr-1"></i> Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Or Enter Image URL -->
                                        <div class="mt-4" style="display: none">
                                            <p class="text-sm text-slate-600 mb-2">Or enter image filename:</p>
                                            <div class="flex gap-2">
                                                <input type="text" name="image_url" 
                                                       value="<?php echo isset($resource['image']) && !empty($resource['image']) ? htmlspecialchars($resource['image']) : ''; ?>"
                                                       id="imageUrlInput"
                                                       class="flex-1 px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                                       placeholder="e.g., ep1.png">
                                                <button type="button" onclick="useExistingImage()" class="px-4 py-2.5 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                                                    <i class="fas fa-check mr-1"></i> Use
                                                </button>
                                            </div>
                                            <p class="text-xs text-slate-500 mt-2">
                                                Enter filename if image already exists in assets_system/images/ folder
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- PDF Section -->
                        <div id="pdfSection" class="upload-section space-y-6 <?php echo (isset($resource['content']) && stripos($resource['content'], 'Download PDF') !== false) ? '' : 'hidden'; ?>">
                            <!-- PDF File Upload -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">PDF Document</label>
                                <div class="space-y-4">
                                    <!-- Current PDF File -->
                                    <?php if(isset($resource['pdf_file']) && !empty($resource['pdf_file'])): ?>
                                    <div class="mb-4">
                                        <p class="text-sm font-medium text-slate-700 mb-2">Current PDF File:</p>
                                        <div class="flex items-start gap-4">
                                            <div class="w-48 h-32 bg-red-50 rounded-lg border border-red-200 overflow-hidden flex items-center justify-center">
                                                <i class="fas fa-file-pdf text-red-500 text-4xl"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="mb-2">
                                                    <span class="text-sm text-slate-600">File: </span>
                                                    <span class="text-sm font-medium text-slate-800"><?php echo $resource['pdf_file']; ?></span>
                                                </div>
                                                <div class="mb-2">
                                                    <span class="text-sm text-slate-600">Size: </span>
                                                    <?php
                                                    $file_path = FCPATH . 'assets_system/images/' . $resource['pdf_file'];
                                                    if(file_exists($file_path)) {
                                                        $file_size = filesize($file_path);
                                                        echo '<span class="text-sm font-medium text-slate-800">' . round($file_size / 1024, 2) . ' KB</span>';
                                                    } else {
                                                        echo '<span class="text-sm font-medium text-red-600">File not found</span>';
                                                    }
                                                    ?>
                                                </div>
                                                <div class="flex gap-2">
                                                    <a href="<?php echo base_url('assets_system/documents/' . $resource['pdf_file']); ?>" 
                                                       target="_blank" 
                                                       class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-sm font-medium hover:bg-blue-100 transition-colors">
                                                        <i class="fas fa-eye mr-1"></i> View PDF
                                                    </a>
                                                    <button type="button" onclick="removeCurrentPDF()" class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-sm font-medium hover:bg-red-100 transition-colors">
                                                        <i class="fas fa-trash mr-1"></i> Remove PDF
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="current_pdf_file" name="current_pdf_file" value="<?php echo $resource['pdf_file']; ?>">
                                        <input type="hidden" id="remove_pdf_file" name="remove_pdf_file" value="0">
                                    </div>
                                    <?php endif; ?>
                                    
                                    <!-- Upload New PDF -->
                                    <div>
                                        <p class="text-sm font-medium text-slate-700 mb-2">Upload New PDF:</p>
                                        <div class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:border-red-400 transition-colors cursor-pointer" id="pdfUploadArea">
                                            <i class="fas fa-file-pdf text-slate-400 text-3xl mb-3"></i>
                                            <p class="text-sm text-slate-600">Click to upload PDF file</p>
                                            <p class="text-xs text-slate-400 mt-1">PDF files only (Max 5MB)</p>
                                            <input type="file" name="pdf_file" id="pdfFile" class="hidden" accept=".pdf">
                                        </div>
                                        
                                        <!-- New PDF Preview -->
                                        <div id="pdfPreview" class="mt-4 hidden">
                                            <p class="text-sm font-medium text-slate-700 mb-2">New PDF Preview:</p>
                                            <div class="flex items-start gap-4">
                                                <div class="w-48 h-32 bg-red-50 rounded-lg border border-red-200 overflow-hidden flex items-center justify-center">
                                                    <i class="fas fa-file-pdf text-red-500 text-4xl"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="mb-2">
                                                        <span class="text-sm text-slate-600">File: </span>
                                                        <span id="pdfFileName" class="text-sm font-medium text-slate-800"></span>
                                                    </div>
                                                    <div class="mb-2">
                                                        <span class="text-sm text-slate-600">Size: </span>
                                                        <span id="pdfFileSize" class="text-sm font-medium text-slate-800"></span>
                                                    </div>
                                                    <button type="button" onclick="removeUploadedPDF()" class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-sm font-medium hover:bg-red-100 transition-colors">
                                                        <i class="fas fa-times mr-1"></i> Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Or Enter PDF Filename -->
                                        <div class="mt-4" style="display:none">
                                            <p class="text-sm text-slate-600 mb-2">Or enter PDF filename:</p>
                                            <div class="flex gap-2">
                                                <input type="text" name="pdf_file_url" 
                                                       value="<?php echo isset($resource['pdf_file']) && !empty($resource['pdf_file']) ? htmlspecialchars($resource['pdf_file']) : ''; ?>"
                                                       id="pdfFileUrlInput"
                                                       class="flex-1 px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                                       placeholder="e.g., company-profile.pdf">
                                                <button type="button" onclick="useExistingPDF()" class="px-4 py-2.5 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                                                    <i class="fas fa-check mr-1"></i> Use
                                                </button>
                                            </div>
                                            <p class="text-xs text-slate-500 mt-2">
                                                Enter filename if PDF already exists in assets_system/images/ folder
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Timestamps -->
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-200">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Created</label>
                                <p class="text-sm text-slate-600">
                                    <?php echo isset($resource['created_at']) && !empty($resource['created_at']) ? date('F d, Y H:i', strtotime($resource['created_at'])) : 'Not available'; ?>
                                </p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Last Updated</label>
                                <p class="text-sm text-slate-600">
                                    <?php echo isset($resource['updated_at']) && !empty($resource['updated_at']) ? date('F d, Y H:i', strtotime($resource['updated_at'])) : 'Never'; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Sidebar -->
                    <div class="space-y-6">
                        <!-- Resource Info Card -->
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">
                            <h3 class="text-sm font-bold text-slate-700 mb-4">Resource Information</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-600">Resource ID:</span>
                                    <span class="text-sm font-bold text-slate-800">#<?php echo isset($resource['id']) ? $resource['id'] : 'N/A'; ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-600">Type:</span>
                                    <span class="text-sm font-bold text-slate-800">
                                        <?php 
                                        if(isset($resource['image']) && !empty($resource['image'])) {
                                            echo 'Video';
                                        } elseif(isset($resource['pdf_file']) && !empty($resource['pdf_file'])) {
                                            echo 'PDF Document';
                                        } elseif(isset($resource['content']) && stripos($resource['content'], 'Download PDF') !== false) {
                                            echo 'PDF Document';
                                        } elseif(isset($resource['content']) && stripos($resource['content'], 'Watch Now') !== false) {
                                            echo 'Video';
                                        } else {
                                            echo 'Text';
                                        }
                                        ?>
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-600">Gated:</span>
                                    <span class="text-sm font-bold <?php echo (isset($resource['is_gated']) && $resource['is_gated'] == 1) ? 'text-amber-600' : 'text-slate-600'; ?>">
                                        <?php echo (isset($resource['is_gated']) && $resource['is_gated'] == 1) ? 'Yes (Lead Capture)' : 'No'; ?>
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-600">Status:</span>
                                    <span class="text-sm font-bold <?php echo isset($resource['id']) && $resource['id'] <= 5 ? 'text-amber-600' : 'text-green-600'; ?>">
                                        <?php echo isset($resource['id']) && $resource['id'] <= 5 ? 'System Resource' : 'Custom Resource'; ?>
                                    </span>
                                </div>
                                
                                <!-- File Information -->
                                <?php if(isset($resource['image']) && !empty($resource['image'])): ?>
                                <div class="mt-4 pt-4 border-t border-slate-200">
                                    <p class="text-sm font-bold text-slate-700 mb-2">Image Information:</p>
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-xs text-slate-500">Filename:</span>
                                            <span class="text-xs font-medium text-slate-800"><?php echo $resource['image']; ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-xs text-slate-500">Path:</span>
                                            <span class="text-xs text-slate-600 truncate">assets_system/images/</span>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if(isset($resource['pdf_file']) && !empty($resource['pdf_file'])): ?>
                                <div class="mt-4 pt-4 border-t border-slate-200">
                                    <p class="text-sm font-bold text-slate-700 mb-2">PDF Information:</p>
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-xs text-slate-500">Filename:</span>
                                            <span class="text-xs font-medium text-slate-800"><?php echo $resource['pdf_file']; ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-xs text-slate-500">Path:</span>
                                            <span class="text-xs text-slate-600 truncate">assets_system/images/</span>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Upload Guidelines Card -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-5">
                            <h3 class="text-sm font-bold text-blue-700 mb-4">Upload Guidelines</h3>
                            <ul class="space-y-2 text-sm text-blue-600">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle mt-0.5 mr-2"></i>
                                    <span>Images: Max 2MB (JPG, PNG, GIF, WEBP)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle mt-0.5 mr-2"></i>
                                    <span>PDFs: Max 5MB</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle mt-0.5 mr-2"></i>
                                    <span>Optimal image size: 16:9 ratio</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle mt-0.5 mr-2"></i>
                                    <span>Recommended: 1280x720px for images</span>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Lead Capture Card (shows when gated) -->
                        <div id="leadCaptureCard" class="bg-amber-50 border border-amber-200 rounded-xl p-5 <?php echo (isset($resource['is_gated']) && $resource['is_gated'] == 1) ? '' : 'hidden'; ?>">
                            <h3 class="text-sm font-bold text-amber-700 mb-4">Lead Capture Information</h3>
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <i class="fas fa-envelope text-amber-600 mt-0.5 mr-2"></i>
                                    <div>
                                        <p class="text-xs text-amber-700">This resource will require user information before access</p>
                                        <p class="text-xs text-amber-600 mt-2">Fields collected:</p>
                                        <ul class="text-xs text-amber-600 mt-1 space-y-1">
                                            <li>• Full Name</li>
                                            <li>• Email Address</li>
                                            <li>• Timestamp</li>
                                        </ul>
                                    </div>
                                </div>
                                <?php if(isset($resource['id'])): ?>
                                <div class="mt-3 pt-3 border-t border-amber-200">
                                    <a href="<?php echo site_url('admin/leads/resource/' . $resource['id']); ?>" class="text-xs font-medium text-amber-700 hover:text-amber-800 flex items-center">
                                        <i class="fas fa-chart-bar mr-1"></i> View collected leads for this resource
                                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- System Notes Card -->
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-5">
                            <h3 class="text-sm font-bold text-amber-700 mb-4">System Notes</h3>
                            <ul class="space-y-2 text-sm text-amber-600">
                                <li class="flex items-start">
                                    <i class="fas fa-exclamation-circle mt-0.5 mr-2"></i>
                                    <span>ID 1 is the main header title/description</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-exclamation-circle mt-0.5 mr-2"></i>
                                    <span>ID 2 is the featured video (special)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-exclamation-circle mt-0.5 mr-2"></i>
                                    <span>IDs 3-5 are "Up Next" videos</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-exclamation-circle mt-0.5 mr-2"></i>
                                    <span>System resources (IDs 1-5) cannot be deleted</span>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="pt-4 border-t border-slate-200 space-y-3">
                            <button type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition-all flex items-center justify-center shadow-md shadow-indigo-100">
                                <i class="fas fa-save mr-2"></i> Update Resource
                            </button>
                            
                            
                            
                            
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Include SweetAlert -->
<script src="<?php echo base_url('assets_system/vendor/sweetalert2/sweetalert2.all.min.js'); ?>"></script>

<script>
// DOM Elements
const imageUploadArea = document.getElementById('imageUploadArea');
const imageFileInput = document.getElementById('imageFile');
const newImagePreview = document.getElementById('newImagePreview');
const uploadedImagePreview = document.getElementById('uploadedImagePreview');
const uploadedFileName = document.getElementById('uploadedFileName');
const imageUrlInput = document.getElementById('imageUrlInput');

const pdfUploadArea = document.getElementById('pdfUploadArea');
const pdfFileInput = document.getElementById('pdfFile');
const pdfPreview = document.getElementById('pdfPreview');
const pdfFileName = document.getElementById('pdfFileName');
const pdfFileSize = document.getElementById('pdfFileSize');
const pdfFileUrlInput = document.getElementById('pdfFileUrlInput');

const resourceTypeOptions = document.querySelectorAll('.resource-type-option');
const contentField = document.querySelector('textarea[name="content"]');
const removeImageInput = document.getElementById('remove_image');
const removePdfFileInput = document.getElementById('remove_pdf_file');

const videoSection = document.getElementById('videoSection');
const pdfSection = document.getElementById('pdfSection');

// Gated Content Elements
const isGatedCheckbox = document.getElementById('is_gated');
const gatedContentInfo = document.getElementById('gatedContentInfo');
const leadCaptureCard = document.getElementById('leadCaptureCard');

// Show flash messages using SweetAlert
document.addEventListener('DOMContentLoaded', function() {
    // Check for success message
    const successMessage = document.getElementById('successMessage');
    if (successMessage && successMessage.dataset.message) {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: successMessage.dataset.message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    }
    
    // Check for error message
    const errorMessage = document.getElementById('errorMessage');
    if (errorMessage && errorMessage.dataset.message) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: errorMessage.dataset.message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    }
    
    // Initialize resource type selection
    resourceTypeOptions.forEach(option => {
        option.addEventListener('click', function() {
            const type = this.getAttribute('data-type');
            const radio = this.querySelector('input[type="radio"]');
            
            // Uncheck all radios
            document.querySelectorAll('input[name="resource_type"]').forEach(r => r.checked = false);
            // Check clicked radio
            radio.checked = true;
            
            // Update UI
            resourceTypeOptions.forEach(opt => {
                opt.classList.remove('border-indigo-500', 'bg-indigo-50');
            });
            this.classList.add('border-indigo-500', 'bg-indigo-50');
            
            // Show/hide sections
            if (type === 'video') {
                videoSection.classList.remove('hidden');
                pdfSection.classList.add('hidden');
            } else if (type === 'pdf') {
                videoSection.classList.add('hidden');
                pdfSection.classList.remove('hidden');
            }
            
            // Auto-format content
            autoFormatContent(type);
        });
    });
    
    // Auto-select resource type based on content
    if (contentField) {
        const content = contentField.value.toLowerCase();
        if (content.includes('watch now') || content.includes('watch')) {
            document.getElementById('type_video').checked = true;
            document.querySelector('[data-type="video"]').classList.add('border-indigo-500', 'bg-indigo-50');
        } else if (content.includes('download pdf')) {
            document.getElementById('type_pdf').checked = true;
            document.querySelector('[data-type="pdf"]').classList.add('border-indigo-500', 'bg-indigo-50');
        }
    }
    
    // Set up file upload handlers
    setupFileUploadHandlers();
    
    // Set up gated content toggle
    if (isGatedCheckbox) {
        isGatedCheckbox.addEventListener('change', function() {
            toggleGatedContent(this.checked);
        });
    }
});

// Toggle gated content UI
function toggleGatedContent(isChecked) {
    if (gatedContentInfo) {
        if (isChecked) {
            gatedContentInfo.classList.remove('hidden');
            leadCaptureCard.classList.remove('hidden');
        } else {
            gatedContentInfo.classList.add('hidden');
            leadCaptureCard.classList.add('hidden');
        }
    }
}

// Setup file upload handlers
function setupFileUploadHandlers() {
    // Image Upload Handling
    if (imageUploadArea) {
        imageUploadArea.addEventListener('click', () => imageFileInput.click());
        imageFileInput.addEventListener('change', handleImageUpload);
    }
    
    // PDF Upload Handling
    if (pdfUploadArea) {
        pdfUploadArea.addEventListener('click', () => pdfFileInput.click());
        pdfFileInput.addEventListener('change', handlePDFUpload);
    }
}

// Handle Image Upload
function handleImageUpload(e) {
    const file = e.target.files[0];
    
    if (!file) return;
    
    // Validate file type
    if (!file.type.match('image.*')) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid File',
            text: 'Please select an image file (JPG, PNG, GIF, WEBP)',
            confirmButtonColor: '#4f46e5',
        });
        imageFileInput.value = '';
        return;
    }
    
    // Validate file size (2MB)
    if (file.size > 2 * 1024 * 1024) {
        Swal.fire({
            icon: 'error',
            title: 'File Too Large',
            text: 'Image file size must be less than 2MB',
            confirmButtonColor: '#4f46e5',
        });
        imageFileInput.value = '';
        return;
    }
    
    // Show preview
    const reader = new FileReader();
    reader.onload = function(e) {
        uploadedImagePreview.src = e.target.result;
        uploadedFileName.textContent = file.name;
        newImagePreview.classList.remove('hidden');
        
        // Clear URL input when uploading new file
        imageUrlInput.value = '';
    }
    reader.readAsDataURL(file);
    
    // Auto-select video type when image is uploaded
    document.getElementById('type_video').checked = true;
    resourceTypeOptions.forEach(opt => {
        opt.classList.remove('border-indigo-500', 'bg-indigo-50');
    });
    document.querySelector('[data-type="video"]').classList.add('border-indigo-500', 'bg-indigo-50');
    
    // Show video section, hide PDF section
    videoSection.classList.remove('hidden');
    pdfSection.classList.add('hidden');
    
    // Auto-format content for video
    autoFormatContent('video');
}

// Handle PDF Upload
function handlePDFUpload(e) {
    const file = e.target.files[0];
    
    if (!file) return;
    
    // Validate file type
    if (!file.name.toLowerCase().endsWith('.pdf')) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid File',
            text: 'Please select a PDF file',
            confirmButtonColor: '#4f46e5',
        });
        pdfFileInput.value = '';
        return;
    }
    
    // Validate file size (5MB)
    if (file.size > 5 * 1024 * 1024) {
        Swal.fire({
            icon: 'error',
            title: 'File Too Large',
            text: 'PDF file size must be less than 5MB',
            confirmButtonColor: '#4f46e5',
        });
        pdfFileInput.value = '';
        return;
    }
    
    // Show preview
    pdfFileName.textContent = file.name;
    pdfFileSize.textContent = formatFileSize(file.size);
    pdfPreview.classList.remove('hidden');
    
    // Clear URL input when uploading new file
    pdfFileUrlInput.value = '';
    
    // Auto-select PDF type when PDF is uploaded
    document.getElementById('type_pdf').checked = true;
    resourceTypeOptions.forEach(opt => {
        opt.classList.remove('border-indigo-500', 'bg-indigo-50');
    });
    document.querySelector('[data-type="pdf"]').classList.add('border-indigo-500', 'bg-indigo-50');
    
    // Show PDF section, hide video section
    pdfSection.classList.remove('hidden');
    videoSection.classList.add('hidden');
    
    // Auto-format content for PDF
    autoFormatContent('pdf');
}

// Format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Remove uploaded image
function removeUploadedImage() {
    imageFileInput.value = '';
    newImagePreview.classList.add('hidden');
    uploadedImagePreview.src = '';
    uploadedFileName.textContent = '';
}

// Remove uploaded PDF
function removeUploadedPDF() {
    pdfFileInput.value = '';
    pdfPreview.classList.add('hidden');
    pdfFileName.textContent = '';
    pdfFileSize.textContent = '';
}

// Remove current image
function removeCurrentImage() {
    Swal.fire({
        title: 'Remove Current Image?',
        text: 'This will remove the current image from this resource.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, remove it',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('remove_image').value = '1';
            document.getElementById('currentImagePreview').parentElement.parentElement.style.display = 'none';
            Swal.fire({
                icon: 'success',
                title: 'Image Removed',
                text: 'The image will be removed when you save changes.',
                confirmButtonColor: '#4f46e5',
            });
        }
    });
}

// Remove current PDF
function removeCurrentPDF() {
    Swal.fire({
        title: 'Remove Current PDF?',
        text: 'This will remove the current PDF file from this resource.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, remove it',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('remove_pdf_file').value = '1';
            document.querySelector('#pdfSection .mb-4').style.display = 'none';
            Swal.fire({
                icon: 'success',
                title: 'PDF Removed',
                text: 'The PDF file will be removed when you save changes.',
                confirmButtonColor: '#4f46e5',
            });
        }
    });
}

// Use existing image from URL input
function useExistingImage() {
    const imageUrl = imageUrlInput.value.trim();
    if (!imageUrl) {
        Swal.fire({
            icon: 'error',
            title: 'No Image Specified',
            text: 'Please enter an image filename',
            confirmButtonColor: '#4f46e5',
        });
        return;
    }
    
    // Clear file input
    removeUploadedImage();
    
    // Auto-select video type when image is specified
    document.getElementById('type_video').checked = true;
    resourceTypeOptions.forEach(opt => {
        opt.classList.remove('border-indigo-500', 'bg-indigo-50');
    });
    document.querySelector('[data-type="video"]').classList.add('border-indigo-500', 'bg-indigo-50');
    
    // Show video section, hide PDF section
    videoSection.classList.remove('hidden');
    pdfSection.classList.add('hidden');
    
    // Auto-format content for video
    autoFormatContent('video');
}

// Use existing PDF from URL input
function useExistingPDF() {
    const pdfUrl = pdfFileUrlInput.value.trim();
    if (!pdfUrl) {
        Swal.fire({
            icon: 'error',
            title: 'No PDF Specified',
            text: 'Please enter a PDF filename',
            confirmButtonColor: '#4f46e5',
        });
        return;
    }
    
    // Clear file input
    removeUploadedPDF();
    
    // Auto-select PDF type when PDF is specified
    document.getElementById('type_pdf').checked = true;
    resourceTypeOptions.forEach(opt => {
        opt.classList.remove('border-indigo-500', 'bg-indigo-50');
    });
    document.querySelector('[data-type="pdf"]').classList.add('border-indigo-500', 'bg-indigo-50');
    
    // Show PDF section, hide video section
    pdfSection.classList.remove('hidden');
    videoSection.classList.add('hidden');
    
    // Auto-format content for PDF
    autoFormatContent('pdf');
}

// Auto-format content based on resource type
function autoFormatContent(type) {
    if (!contentField) return;
    
    let currentContent = contentField.value.trim();
    
    // Remove existing action text
    currentContent = currentContent.replace(/\s*-\s*(Watch Now|Download PDF)\s*$/i, '').trim();
    
    // Add appropriate action text
    if (type === 'video') {
        if (currentContent && !currentContent.toLowerCase().includes('watch now')) {
            contentField.value = currentContent + ' - Watch Now';
        }
    } else if (type === 'pdf') {
        if (currentContent && !currentContent.toLowerCase().includes('download pdf')) {
            contentField.value = currentContent + ' - Download PDF';
        }
    }
}

// Set featured resource
function setFeatured(resourceId) {
    Swal.fire({
        title: 'Set as Featured?',
        text: 'This will replace the current featured video on the main page.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#4f46e5',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, set featured',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Updating...',
                text: 'Setting featured resource...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Make the request
            fetch(`<?php echo site_url('admin/resource-library/set-featured/'); ?>${resourceId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message || 'Featured resource updated successfully.',
                            confirmButtonColor: '#4f46e5',
                        }).then(() => {
                            window.location.href = '<?php echo site_url('cms/library'); ?>';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message || 'Failed to update featured resource.',
                            confirmButtonColor: '#4f46e5',
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Network error. Please try again.',
                        confirmButtonColor: '#4f46e5',
                    });
                });
        }
    });
}

// Confirm and delete resource
function confirmDelete(resourceId, resourceTitle) {
    Swal.fire({
        title: 'Delete Resource?',
        html: `Are you sure you want to delete <strong>"${resourceTitle}"</strong>?<br><span class="text-sm text-red-600">This action cannot be undone.</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait while we delete the resource.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Make the request
            fetch(`<?php echo site_url('admin/resource-library/delete/'); ?>${resourceId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: data.message || 'Resource deleted successfully.',
                            confirmButtonColor: '#4f46e5',
                        }).then(() => {
                            window.location.href = '<?php echo site_url('cms/library'); ?>';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message || 'Failed to delete resource.',
                            confirmButtonColor: '#4f46e5',
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Network error. Please try again.',
                        confirmButtonColor: '#4f46e5',
                    });
                });
        }
    });
}

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const title = document.querySelector('input[name="title"]').value.trim();
    const content = document.querySelector('textarea[name="content"]').value.trim();
    const resourceType = document.querySelector('input[name="resource_type"]:checked');
    const imageFile = imageFileInput ? imageFileInput.files[0] : null;
    const imageUrl = imageUrlInput ? imageUrlInput.value.trim() : '';
    const pdfFile = pdfFileInput ? pdfFileInput.files[0] : null;
    const pdfFileUrl = pdfFileUrlInput ? pdfFileUrlInput.value.trim() : '';
    
    const hasCurrentImage = document.getElementById('current_image') && 
                           document.getElementById('remove_image').value !== '1';
    const hasCurrentPDF = document.getElementById('current_pdf_file') && 
                         document.getElementById('remove_pdf_file').value !== '1';
    
    // Basic validation
    if (!title) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Missing Title',
            text: 'Please enter a resource title.',
            confirmButtonColor: '#4f46e5',
        });
        return;
    }
    
    if (!content) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Missing Content',
            text: 'Please enter content description.',
            confirmButtonColor: '#4f46e5',
        });
        return;
    }
    
    if (!resourceType) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Resource Type',
            text: 'Please select a resource type.',
            confirmButtonColor: '#4f46e5',
        });
        return;
    }
    
    // Check for images if resource type is video
    if (resourceType.value === 'video' && !imageFile && !imageUrl && !hasCurrentImage) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Image Required',
            text: 'Video resources require an image. Please upload an image or enter an image filename.',
            confirmButtonColor: '#4f46e5',
        });
        return;
    }
    
    // Check for PDF if resource type is PDF
    if (resourceType.value === 'pdf' && !pdfFile && !pdfFileUrl && !hasCurrentPDF) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'PDF Required',
            text: 'PDF resources require a PDF file. Please upload a PDF or enter a PDF filename.',
            confirmButtonColor: '#4f46e5',
        });
        return;
    }
    
    // Auto-format content based on resource type
    const type = resourceType.value;
    let formattedContent = content;
    
    // Remove existing action text
    formattedContent = formattedContent.replace(/\s*-\s*(Watch Now|Download PDF)\s*$/i, '').trim();
    
    // Add appropriate action text
    if (type === 'video') {
        if (!formattedContent.toLowerCase().includes('watch now')) {
            formattedContent += ' - Watch Now';
        }
    } else if (type === 'pdf') {
        if (!formattedContent.toLowerCase().includes('download pdf')) {
            formattedContent += ' - Download PDF';
        }
    }
    
    // Update the content field
    contentField.value = formattedContent;
});
</script>

<style>
/* SweetAlert custom styles */
.swal2-popup {
    border-radius: 1rem !important;
}

.swal2-title {
    font-size: 1.25rem !important;
    font-weight: 600 !important;
}

.swal2-confirm {
    border-radius: 0.75rem !important;
    padding: 0.625rem 1.5rem !important;
}

.swal2-cancel {
    border-radius: 0.75rem !important;
    padding: 0.625rem 1.5rem !important;
}

/* Resource type option styles */
.resource-type-option {
    transition: all 0.2s ease;
}

.resource-type-option:hover {
    transform: translateY(-2px);
}

/* File upload area styles */
#imageUploadArea, #pdfUploadArea {
    transition: all 0.3s ease;
}

#imageUploadArea:hover {
    background-color: #f8fafc;
    border-color: #818cf8;
}

#pdfUploadArea:hover {
    background-color: #f8fafc;
    border-color: #ef4444;
}

/* Animation for new file preview */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

#newImagePreview, #pdfPreview {
    animation: fadeIn 0.3s ease;
}

/* Gated content toggle animation */
#gatedContentInfo, #leadCaptureCard {
    animation: fadeIn 0.3s ease;
}

/* Checkbox styles */
input[type="checkbox"]:checked {
    background-color: #4f46e5;
    border-color: #4f46e5;
}

input[type="checkbox"] {
    transition: all 0.2s ease;
}
</style>