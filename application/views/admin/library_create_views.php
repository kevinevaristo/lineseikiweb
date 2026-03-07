<main class="ml-64 p-8">
    <div class="max-w-7xl mx-auto">
        <?php if($this->session->flashdata('error')): ?>
        <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded-xl">
            <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php endif; ?>
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Add New Resource</h1>
                <p class="text-slate-500 mt-1">Create a new video, case study, or brochure with file uploads.</p>
            </div>
            <div class="flex gap-3">
                <a href="<?php echo site_url('cms/library'); ?>" class="px-5 py-2.5 border border-slate-300 text-slate-700 rounded-xl font-semibold hover:bg-slate-50 transition-all flex items-center">
                    <i class="fas fa-arrow-left mr-2 text-xs"></i> Back to Resources
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <form method="POST" action="<?php echo site_url('cms/library_create'); ?>" enctype="multipart/form-data">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Basic Information -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Resource Title *</label>
                            <input type="text" name="title" required 
                                   class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                                   placeholder="e.g., Episode 1: Unifying CAD, CAE, & CAM">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Content Description *</label>
                            <textarea name="content" rows="4" required 
                                      class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                                      placeholder="e.g., Unifying CAD, CAE, & CAM. - Watch Now"></textarea>
                            <p class="text-xs text-slate-500 mt-2">
                                Include action text at the end: "- Watch Now" for videos or "- Download PDF" for documents
                            </p>
                        </div>
                        
                        <!-- Resource Type Selection -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Resource Type *</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="resource-type-option border-2 border-slate-200 rounded-xl p-4 cursor-pointer hover:border-sky-300 transition-colors" data-type="video">
                                    <div class="flex items-center mb-2">
                                        <input type="radio" id="type_video" name="resource_type" value="Videos" class="mr-2" required>
                                        <label for="type_video" class="text-sm font-bold text-slate-700">Video (External)</label>
                                    </div>
                                    <p class="text-xs text-slate-500">YouTube/Stream links with thumbnail</p>
                                </div>
                                
                                <div class="resource-type-option border-2 border-slate-200 rounded-xl p-4 cursor-pointer hover:border-sky-300 transition-colors" data-type="video_file" style="display: none;">
                                    <div class="flex items-center mb-2">
                                        <input type="radio" id="type_video_file" name="resource_type" value="Videos" class="mr-2" required>
                                        <label for="type_video_file" class="text-sm font-bold text-slate-700">Video Upload</label>
                                    </div>
                                    <p class="text-xs text-slate-500">Upload MP4/AVI/MOV files</p>
                                </div>
                                
                                <div class="resource-type-option border-2 border-slate-200 rounded-xl p-4 cursor-pointer hover:border-sky-300 transition-colors" data-type="pdf">
                                    <div class="flex items-center mb-2">
                                        <input type="radio" id="type_pdf" name="resource_type" value="brochure" class="mr-2" required>
                                        <label for="type_pdf" class="text-sm font-bold text-slate-700">PDF Document</label>
                                    </div>
                                    <p class="text-xs text-slate-500">Upload PDF files</p>
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
                                           class="w-4 h-4 text-sky-600 border-slate-300 rounded focus:ring-sky-500">
                                </div>
                                <div class="ml-3">
                                    <label for="is_gated" class="text-sm font-bold text-slate-700 cursor-pointer">Gated Content</label>
                                    <p class="text-xs text-slate-500 mt-1">Require users to submit their information before accessing this resource</p>
                                </div>
                            </div>
                            
                            <!-- Gated Content Info (shown when checked) -->
                            <div id="gatedContentInfo" class="mt-4 p-4 bg-sky-50 border border-sky-200 rounded-lg hidden">
                                <div class="flex items-start">
                                    <i class="fas fa-lock text-sky-600 mt-0.5 mr-3"></i>
                                    <div>
                                        <h4 class="text-sm font-semibold text-sky-800">Gated Resource Settings</h4>
                                        <p class="text-xs text-sky-600 mt-1">Users will need to fill out a form with their name and email before accessing this resource. The form data will be collected and stored for follow-up.</p>
                                        <div class="mt-3 flex items-center text-xs text-sky-700">
                                            <i class="fas fa-database mr-1"></i>
                                            <span>Lead capture data will be available in the admin panel</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Dynamic File Upload Sections -->
                        <div id="uploadSections">
                            <!-- Video External Section (Default) -->
                            <div id="videoSection" class="upload-section space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Video URL</label>
                                        <input type="url" name="video_url" 
                                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                                               placeholder="https://youtube.com/watch?v=...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Thumbnail Image</label>
                                        <div class="space-y-4">
                                            <div class="border-2 border-dashed border-slate-300 rounded-lg p-4 text-center hover:border-sky-400 transition-colors cursor-pointer" id="imageUploadArea">
                                                <i class="fas fa-image text-slate-400 text-2xl mb-2"></i>
                                                <p class="text-sm text-slate-600">Click to upload thumbnail</p>
                                                <p class="text-xs text-slate-400 mt-1">JPG, PNG, GIF, WEBP (Max 2MB)</p>
                                                <input type="file" name="image_file" id="imageFile" class="hidden" accept="image/*">
                                            </div>
                                            <div id="imagePreview" class="mt-2 hidden">
                                                <div class="flex items-center space-x-2">
                                                    <img src="" alt="Preview" class="w-20 h-12 object-cover rounded">
                                                    <button type="button" onclick="removeImage()" class="text-xs text-red-600 ml-2">Remove</button>
                                                </div>
                                            </div>
                                            
                                            <!-- Image filename input field -->
                                            <div class="mt-4" style="display: none">
                                                <p class="text-sm text-slate-600 mb-2">Or enter image filename:</p>
                                                <div class="flex gap-2">
                                                    <input type="text" name="image_url" 
                                                           id="imageUrl"
                                                           class="flex-1 px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                                                           placeholder="e.g., ep1.png">
                                                    <button type="button" onclick="useExistingImage()" class="px-4 py-2.5 bg-sky-600 text-white rounded-lg font-medium hover:bg-sky-700 transition-colors">
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
                            
                            <!-- Video Upload Section (Hidden by default) -->
                            <div id="videoFileSection" class="upload-section space-y-4 hidden">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Upload Video File</label>
                                    <div class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center hover:border-sky-400 transition-colors cursor-pointer" id="videoUploadArea">
                                        <i class="fas fa-video text-slate-400 text-3xl mb-3"></i>
                                        <p class="text-sm text-slate-600">Click to upload video file</p>
                                        <p class="text-xs text-slate-400 mt-1">MP4, AVI, MOV, WMV, FLV, WEBM (Max 50MB)</p>
                                        <input type="file" name="video_file" id="videoFile" class="hidden" accept="video/*">
                                    </div>
                                    <div id="videoPreview" class="mt-2 hidden">
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-file-video text-sky-600"></i>
                                            <span id="videoFileName" class="text-sm"></span>
                                            <button type="button" onclick="removeVideo()" class="text-xs text-red-600 ml-2">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- PDF Upload Section (Hidden by default) -->
                            <div id="pdfSection" class="upload-section space-y-4 hidden">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Upload PDF Document</label>
                                    <div class="space-y-4">
                                        <div class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center hover:border-sky-400 transition-colors cursor-pointer" id="pdfUploadArea">
                                            <i class="fas fa-file-pdf text-slate-400 text-3xl mb-3"></i>
                                            <p class="text-sm text-slate-600">Click to upload PDF file</p>
                                            <p class="text-xs text-slate-400 mt-1">PDF files only (Max 5MB)</p>
                                            <input type="file" name="pdf_file" id="pdfFile" class="hidden" accept=".pdf">
                                        </div>
                                        <div id="pdfPreview" class="mt-2 hidden">
                                            <div class="flex items-center space-x-2">
                                                <i class="fas fa-file-pdf text-red-600"></i>
                                                <span id="pdfFileName" class="text-sm"></span>
                                                <button type="button" onclick="removePDF()" class="text-xs text-red-600 ml-2">Remove</button>
                                            </div>
                                        </div>
                                        
                                        <!-- PDF filename input field -->
                                        <div class="mt-4" style="display: none">
                                            <p class="text-sm text-slate-600 mb-2">Or enter PDF filename:</p>
                                            <div class="flex gap-2">
                                                <input type="text" name="pdf_file_url" 
                                                       id="pdfFileUrl"
                                                       class="flex-1 px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                                                       placeholder="e.g., company-profile.pdf">
                                                <button type="button" onclick="useExistingPDF()" class="px-4 py-2.5 bg-sky-600 text-white rounded-lg font-medium hover:bg-sky-700 transition-colors">
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
                    </div>
                    
                    <!-- Right Sidebar -->
                    <div class="space-y-6">
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">
                            <h3 class="text-sm font-bold text-slate-700 mb-4">Quick Tips</h3>
                            <ul class="space-y-3 text-sm text-slate-600">
                                <li class="flex items-start">
                                    <i class="fas fa-info-circle text-sky-500 mt-0.5 mr-2"></i>
                                    <span>For videos, end content with "- Watch Now"</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-info-circle text-sky-500 mt-0.5 mr-2"></i>
                                    <span>For PDFs, end content with "- Download PDF"</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-info-circle text-sky-500 mt-0.5 mr-2"></i>
                                    <span>Max file sizes: Images 2MB, Videos 50MB, PDFs 5MB</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-info-circle text-sky-500 mt-0.5 mr-2"></i>
                                    <span>Create folder permissions: assets_system/images/, assets_system/videos/, assets_system/documents/</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="bg-sky-50 border border-sky-200 rounded-xl p-5">
                            <h3 class="text-sm font-bold text-sky-700 mb-4">Supported Formats</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-xs font-bold text-sky-600">Video Thumbnails:</p>
                                    <p class="text-xs text-slate-600">JPG, PNG, GIF, WEBP</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-sky-600">Video Files:</p>
                                    <p class="text-xs text-slate-600">MP4, AVI, MOV, WMV, FLV, WEBM</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-sky-600">Documents:</p>
                                    <p class="text-xs text-slate-600">PDF only</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Lead Capture Card (appears when gated is checked) -->
                        <div id="leadCaptureCard" class="bg-amber-50 border border-amber-200 rounded-xl p-5 hidden">
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
                            </div>
                        </div>
                        
                        <div class="pt-4 border-t border-slate-200">
                            <button type="submit" class="w-full px-4 py-3 bg-sky-600 text-white rounded-xl font-semibold hover:bg-sky-700 transition-all flex items-center justify-center">
                                <i class="fas fa-save mr-2"></i> Create Resource
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    // DOM Elements
    const resourceTypeOptions = document.querySelectorAll('.resource-type-option');
    const uploadSections = document.querySelectorAll('.upload-section');
    const contentField = document.querySelector('textarea[name="content"]');
    
    // File upload areas
    const imageUploadArea = document.getElementById('imageUploadArea');
    const videoUploadArea = document.getElementById('videoUploadArea');
    const pdfUploadArea = document.getElementById('pdfUploadArea');
    
    // File inputs
    const imageFileInput = document.getElementById('imageFile');
    const videoFileInput = document.getElementById('videoFile');
    const pdfFileInput = document.getElementById('pdfFile');
    
    // Input fields
    const imageUrlInput = document.getElementById('imageUrl');
    const pdfFileUrlInput = document.getElementById('pdfFileUrl');
    
    // Preview elements
    const imagePreview = document.getElementById('imagePreview');
    const videoPreview = document.getElementById('videoPreview');
    const pdfPreview = document.getElementById('pdfPreview');
    
    // Gated Content Elements
    const isGatedCheckbox = document.getElementById('is_gated');
    const gatedContentInfo = document.getElementById('gatedContentInfo');
    const leadCaptureCard = document.getElementById('leadCaptureCard');
    
    // Gated content toggle
    if (isGatedCheckbox) {
        isGatedCheckbox.addEventListener('change', function() {
            if (this.checked) {
                gatedContentInfo.classList.remove('hidden');
                leadCaptureCard.classList.remove('hidden');
            } else {
                gatedContentInfo.classList.add('hidden');
                leadCaptureCard.classList.add('hidden');
            }
        });
    }
    
    // Resource type selection
    resourceTypeOptions.forEach(option => {
        option.addEventListener('click', function() {
            const type = this.getAttribute('data-type');
            const radio = this.querySelector('input[type="radio"]');
            
            // Uncheck all radios
            document.querySelectorAll('input[name="resource_type"]').forEach(r => r.checked = false);
            // Check clicked radio
            radio.checked = true;
            
            // Update UI
            resourceTypeOptions.forEach(opt => opt.classList.remove('border-sky-500', 'bg-sky-50'));
            this.classList.add('border-sky-500', 'bg-sky-50');
            
            // Show appropriate upload section
            uploadSections.forEach(section => section.classList.add('hidden'));
            document.getElementById(`${type}Section`).classList.remove('hidden');
            
            // Auto-format content
            autoFormatContent(type);
        });
    });
    
    // Auto-format content based on resource type
    function autoFormatContent(type) {
        let currentContent = contentField.value.trim();
        
        // Remove existing action text
        currentContent = currentContent.replace(/\s*-\s*(Watch Now|Download PDF)\s*$/i, '');
        
        // Add appropriate action text
        if (type === 'video' || type === 'video_file') {
            if (currentContent && !currentContent.includes('Watch Now')) {
                contentField.value = currentContent + (currentContent.endsWith('.') ? ' ' : ' - ') + 'Watch Now';
            }
        } else if (type === 'pdf') {
            if (currentContent && !currentContent.includes('Download PDF')) {
                contentField.value = currentContent + (currentContent.endsWith('.') ? ' ' : ' - ') + 'Download PDF';
            }
        }
    }
    
    // Image upload handling
    imageUploadArea.addEventListener('click', () => imageFileInput.click());
    imageFileInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            
            // Validate file type
            if (!file.type.match('image.*')) {
                alert('Please select an image file (JPG, PNG, GIF, WEBP)');
                this.value = '';
                return;
            }
            
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Image file size must be less than 2MB');
                this.value = '';
                return;
            }
            
            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.querySelector('img').src = e.target.result;
                imagePreview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
            
            // Clear image URL input
            imageUrlInput.value = '';
            
            // Auto-select video type
            document.getElementById('type_video').checked = true;
            resourceTypeOptions.forEach(opt => opt.classList.remove('border-sky-500', 'bg-sky-50'));
            document.querySelector('[data-type="video"]').classList.add('border-sky-500', 'bg-sky-50');
            uploadSections.forEach(section => section.classList.add('hidden'));
            document.getElementById('videoSection').classList.remove('hidden');
        }
    });
    
    // Video upload handling
    videoUploadArea.addEventListener('click', () => videoFileInput.click());
    videoFileInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            
            // Validate file type
            const validTypes = ['video/mp4', 'video/avi', 'video/quicktime', 'video/x-ms-wmv', 'video/x-flv', 'video/webm'];
            if (!validTypes.includes(file.type)) {
                alert('Please select a video file (MP4, AVI, MOV, WMV, FLV, WEBM)');
                this.value = '';
                return;
            }
            
            // Validate file size (50MB)
            if (file.size > 50 * 1024 * 1024) {
                alert('Video file size must be less than 50MB');
                this.value = '';
                return;
            }
            
            // Show preview
            document.getElementById('videoFileName').textContent = file.name;
            videoPreview.classList.remove('hidden');
        }
    });
    
    // PDF upload handling
    pdfUploadArea.addEventListener('click', () => pdfFileInput.click());
    pdfFileInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            
            // Validate file type
            if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
                alert('Please select a PDF file');
                this.value = '';
                return;
            }
            
            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('PDF file size must be less than 5MB');
                this.value = '';
                return;
            }
            
            // Show preview
            document.getElementById('pdfFileName').textContent = file.name;
            pdfPreview.classList.remove('hidden');
            
            // Clear PDF URL input
            pdfFileUrlInput.value = '';
            
            // Auto-select PDF type
            document.getElementById('type_pdf').checked = true;
            resourceTypeOptions.forEach(opt => opt.classList.remove('border-sky-500', 'bg-sky-50'));
            document.querySelector('[data-type="pdf"]').classList.add('border-sky-500', 'bg-sky-50');
            uploadSections.forEach(section => section.classList.add('hidden'));
            document.getElementById('pdfSection').classList.remove('hidden');
        }
    });
    
    // Use existing image filename
    function useExistingImage() {
        const imageUrl = imageUrlInput.value.trim();
        
        if (!imageUrl) {
            alert('Please enter an image filename');
            return;
        }
        
        // Clear file input
        imageFileInput.value = '';
        imagePreview.classList.add('hidden');
        imagePreview.querySelector('img').src = '';
        
        // Auto-select video type
        document.getElementById('type_video').checked = true;
        resourceTypeOptions.forEach(opt => opt.classList.remove('border-sky-500', 'bg-sky-50'));
        document.querySelector('[data-type="video"]').classList.add('border-sky-500', 'bg-sky-50');
        uploadSections.forEach(section => section.classList.add('hidden'));
        document.getElementById('videoSection').classList.remove('hidden');
        
        // Auto-format content
        autoFormatContent('video');
    }
    
    // Use existing PDF filename
    function useExistingPDF() {
        const pdfUrl = pdfFileUrlInput.value.trim();
        
        if (!pdfUrl) {
            alert('Please enter a PDF filename');
            return;
        }
        
        // Clear file input
        pdfFileInput.value = '';
        pdfPreview.classList.add('hidden');
        document.getElementById('pdfFileName').textContent = '';
        
        // Auto-select PDF type
        document.getElementById('type_pdf').checked = true;
        resourceTypeOptions.forEach(opt => opt.classList.remove('border-sky-500', 'bg-sky-50'));
        document.querySelector('[data-type="pdf"]').classList.add('border-sky-500', 'bg-sky-50');
        uploadSections.forEach(section => section.classList.add('hidden'));
        document.getElementById('pdfSection').classList.remove('hidden');
        
        // Auto-format content
        autoFormatContent('pdf');
    }
    
    // Remove file functions
    function removeImage() {
        imageFileInput.value = '';
        imagePreview.classList.add('hidden');
        imagePreview.querySelector('img').src = '';
    }
    
    function removeVideo() {
        videoFileInput.value = '';
        videoPreview.classList.add('hidden');
        document.getElementById('videoFileName').textContent = '';
    }
    
    function removePDF() {
        pdfFileInput.value = '';
        pdfPreview.classList.add('hidden');
        document.getElementById('pdfFileName').textContent = '';
    }
    
    // Form validation before submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const resourceType = document.querySelector('input[name="resource_type"]:checked');
        
        if (!resourceType) {
            e.preventDefault();
            alert('Please select a resource type');
            return;
        }
        
        const typeValue = resourceType.value; // 'Videos' or 'brochure'
        const typeElement = resourceType.closest('.resource-type-option');
        const type = typeElement ? typeElement.getAttribute('data-type') : '';
        
        if (type === 'pdf') {
            // For PDF, check if either file is uploaded OR filename is provided
            const hasPdfFile = pdfFileInput.files[0];
            const hasPdfUrl = pdfFileUrlInput.value.trim();
            
            if (!hasPdfFile && !hasPdfUrl) {
                e.preventDefault();
                alert('Please upload a PDF file or enter a PDF filename');
                return;
            }
        }
        
        if (type === 'video') {
            // For video, check if either image is uploaded OR image filename is provided OR video URL is provided
            const hasImageFile = imageFileInput.files[0];
            const hasImageUrl = imageUrlInput.value.trim();
            const hasVideoUrl = document.querySelector('input[name="video_url"]').value.trim();
            
            if (!hasImageFile && !hasImageUrl && !hasVideoUrl) {
                e.preventDefault();
                alert('Please provide either: upload thumbnail, enter image filename, or provide video URL');
                return;
            }
        }
        
        // Auto-format content one last time before submit
        if (type === 'video' || type === 'video_file') {
            autoFormatContent('video');
        } else if (type === 'pdf') {
            autoFormatContent('pdf');
        }
    });
    
    // Initialize first option as selected
    document.querySelector('[data-type="video"]').click();
</script>

<style>
/* Animation for gated content info */
#gatedContentInfo, #leadCaptureCard {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Checkbox styles */
input[type="checkbox"]:checked {
    background-color: #0284c7;
    border-color: #0284c7;
}

input[type="checkbox"] {
    transition: all 0.2s ease;
}
</style>