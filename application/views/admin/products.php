<?php $this->load->view('admin/header'); ?>
<style>
/* Main container adjustment */
main {
    padding-top: 1rem; /* Reduce top padding since header is sticky */
}

/* Sticky header animation */
.sticky-header {
    transition: all 0.3s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

/* Scroll indicator */
.scroll-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 2px;
    background: linear-gradient(90deg, #4f46e5, #7c3aed);
    transition: width 0.3s ease;
}

/* Shadow on scroll */
.sticky-header.scrolled {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

/* Save button animation */
#saveAllChanges:active {
    transform: scale(0.98);
}

/* Loading animation for save button */
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

#saveAllChanges.saving {
    animation: pulse 1.5s ease-in-out infinite;
}

/* Ensure modal displays properly */
#categoryModal {
    transition: opacity 0.3s ease;
}

#categoryModal:not(.hidden) {
    display: flex !important;
    opacity: 1 !important;
    visibility: visible !important;
}

/* Override any conflicting styles */
.fixed.inset-0 {
    position: fixed !important;
    top: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    left: 0 !important;
}

.z-50 {
    z-index: 9999 !important;
}
</style>
<main class="ml-64 p-8">
    <!-- STICKY HEADER SECTION -->
    <div class="sticky top-0 z-40 bg-slate-50 -mx-8 px-8 py-4 sticky-header mb-8">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Product Categories Editor</h1>
                    <p class="text-slate-500 mt-1">Manage the grid of product categories shown on the main products page.</p>
                </div>
                <div class="flex gap-3">
                    <a href="<?php echo base_url('products'); ?>" target="_blank" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-50 transition-all flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Preview Page
                    </a>
                    <button id="saveAllChanges" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition-all flex items-center">
                        <svg id="saveIcon" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Save All Changes
                    </button>
                </div>
            </div>
        </div>
        <!-- Scroll Progress Bar -->
        <div class="scroll-progress"></div>
    </div>

    <div class="max-w-6xl mx-auto">
        <!-- ADD onsubmit="return false;" to prevent form submission -->
        <form id="productCategoriesForm" enctype="multipart/form-data" onsubmit="return false;">
            <!-- Page Header Settings -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-8">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Page Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Main Page Title</label>
                        <input type="text" id="page_title" class="w-full p-3 bg-white border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" 
                               value="Our Product Categories" placeholder="Enter page title">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Background Image</label>
                        <div class="flex items-center gap-4">
                            <div class="w-24 h-16 bg-slate-100 border border-slate-300 rounded overflow-hidden">
                                <img id="bgPreview" src="<?php echo base_url('assets_system/images/' . ($content['bg_image']['image'] ?? 'stockroom.jpg')); ?>" alt="Background" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <div class="text-xs text-slate-500 mb-1 truncate"><?php echo $content['bg_image']['image'] ?? 'stockroom.jpg'; ?></div>
                                <input type="file" id="bgUpload" class="hidden" accept="image/*">
                                <input type="hidden" id="bg_image" value="<?php echo $content['bg_image']['image'] ?? ''; ?>">
                                <button type="button" onclick="document.getElementById('bgUpload').click()" class="text-sm text-indigo-600 font-medium hover:text-indigo-800 hover:underline">
                                    Change Background
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categories Grid -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-slate-800">Product Categories (<span id="categoriesCount"><?php echo count($products); ?></span>)</h3>
                    <button type="button" onclick="showAddCategoryModal()" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-medium hover:bg-indigo-100 transition-colors flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2h-5V4a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span>Add New Category</span>
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="categoriesContainer">
                    <?php 
                    // Load categories from database
                    $this->load->model('admin/products_model');
                    $categories = $this->products_model->get_all_products();
                    
                    if (!empty($categories)): 
                        $counter = 0;
                        foreach($categories as $category): 
                            $counter++;
                            $delay_class = 'delay-' . (($counter % 4) + 1);
                    ?>
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 hover:border-indigo-200 animate__animated animate__fadeInUp <?php echo $delay_class; ?>" 
                         id="category_<?php echo $category->id; ?>">
                        <div class="h-40 bg-slate-50 relative overflow-hidden group">
                            <?php if (!empty($category->product_image)): ?>
                                <img id="preview_<?php echo $category->id; ?>" 
                                     src="<?php echo base_url('assets_system/images/' . $category->product_image); ?>" 
                                     class="w-full h-full object-contain p-4 transition-transform duration-300 group-hover:scale-110" 
                                     alt="<?php echo htmlspecialchars($category->category_name); ?>">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            <?php endif; ?>
                            
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-2">
                                <button type="button" onclick="editCategory(<?php echo $category->id; ?>)" 
                                        class="bg-indigo-600 text-white text-xs font-bold px-3 py-2 rounded-lg shadow-xl hover:bg-indigo-700 transition-colors flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                    Edit
                                </button>
                            </div>
                            <input type="file" id="upload_<?php echo $category->id; ?>" class="hidden" accept="image/*" onchange="uploadCategoryImage(<?php echo $category->id; ?>, this)">
                            <input type="hidden" id="input_<?php echo $category->id; ?>" value="<?php echo $category->product_image; ?>">
                        </div>
                        
                        <div class="p-5 space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Category Name</label>
                                <div class="flex items-center gap-2">
                                    <h4 class="text-lg font-bold text-slate-800 truncate" id="categoryName_<?php echo $category->id; ?>">
                                        <?php echo htmlspecialchars($category->category_name); ?>
                                    </h4>
                                </div>
                            </div>
                            
                            <!-- View Products Button -->
                            <div>
                                <button type="button" onclick="viewProducts(<?php echo $category->id; ?>, '<?php echo htmlspecialchars($category->category_name); ?>')" 
                                        class="w-full px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span>View Products</span>
                                </button>
                            </div>
                            
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                                <span>Updated: <?php echo date('M d, Y', strtotime($category->updated_at)); ?></span>
                            </div>
                        </div>

                        <div class="px-5 py-3 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-slate-400">Category #<?php echo $category->id; ?></span>
                            </div>
                            <button type="button" onclick="deleteCategory(<?php echo $category->id; ?>, '<?php echo htmlspecialchars(addslashes($category->category_name)); ?>')" 
                                    class="text-xs text-red-500 font-medium hover:text-red-700 transition-colors flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Delete
                            </button>
                        </div>
                    </div>
                    <?php 
                        endforeach;
                    else: 
                    ?>
                    <div class="col-span-3">
                        <div class="text-center py-12 border-2 border-dashed border-slate-300 rounded-2xl bg-slate-50/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <h4 class="text-lg font-medium text-slate-600 mb-2">No Categories Yet</h4>
                            <p class="text-slate-500 mb-4">Add your first product category to get started</p>
                            <button type="button" onclick="showAddCategoryModal()" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors inline-flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2h-5V4a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Add First Category
                            </button>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Category Modal -->
            <div class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" id="categoryModal">
                <div class="bg-white rounded-2xl w-full max-w-md max-h-[90vh] overflow-y-auto">
                    <div class="p-6 border-b border-slate-200">
                        <h3 class="text-xl font-bold text-slate-800" id="modalTitle">Add New Category</h3>
                    </div>
                    
                    <!-- Changed from form to div to prevent submission -->
                    <div id="categoryFormContent" class="p-6 space-y-4">
                        <input type="hidden" id="categoryId" name="category_id" value="">
                        
                        <!-- Category Name -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="categoryName" name="category_name" 
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                                   placeholder="Enter category name" required>
                            <div class="text-xs text-red-500 mt-1 hidden" id="nameError"></div>
                        </div>
                        
                        <!-- Image Upload -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Category Image <span class="text-slate-500 text-xs">(Optional)</span>
                            </label>
                            <div class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:border-indigo-400 transition-colors cursor-pointer"
                                 onclick="document.getElementById('categoryImage').click()">
                                <div class="mb-4" id="imagePreviewContainer">
                                    <img id="categoryImagePreview" src="" alt="Preview" 
                                         class="mx-auto max-h-40 object-contain hidden">
                                </div>
                                <div id="uploadPlaceholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-slate-600 font-medium mb-1">Click to upload image</p>
                                    <p class="text-slate-500 text-sm">JPG, PNG, GIF, SVG or WebP (Max. 2MB)</p>
                                </div>
                                <input type="file" id="categoryImage" name="category_image" 
                                       class="hidden" accept="image/*">
                            </div>
                            <div class="text-xs text-red-500 mt-1 hidden" id="imageError"></div>
                        </div>
                        
                        <div class="pt-4 flex justify-end gap-3">
                            <button type="button" onclick="closeCategoryModal()" 
                                    class="px-4 py-2 text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                                Cancel
                            </button>
                            <button type="button" id="submitCategoryButton" 
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors flex items-center gap-2">
                                <span id="submitText">Add Category</span>
                                <span id="submitSpinner" class="spinner-border spinner-border-sm hidden"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section Editor -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <span>📋</span>
                    <span>Bottom Inquiry Section</span>
                </h3>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">CTA Headline</label>
                        <input type="text" id="cta_headline" class="w-full p-3 bg-white border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" 
                               value="Looking for the Right Measuring Solution?" placeholder="Enter headline text">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Description Text</label>
                        <textarea id="cta_description" class="w-full p-3 bg-white border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" 
                                  rows="2" placeholder="Enter description text">Contact us today to discuss your requirements and find the perfect product for your needs.</textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Button Text</label>
                            <input type="text" id="cta_button_text" class="w-full p-3 bg-white border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" 
                                   value="INQUIRE" placeholder="Button text">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Button Link</label>
                            <input type="text" id="cta_button_link" class="w-full p-3 bg-white border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" 
                                   value="index/contact_us" placeholder="Button link URL">
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
<link rel="stylesheet" href="<?php echo base_url('assets_system/vendor/animate.css/animate.min.css'); ?>">

<script>
// Prevent main form from submitting
document.addEventListener('DOMContentLoaded', function() {
    // Prevent main form submission
    const mainForm = document.getElementById('productCategoriesForm');
    if (mainForm) {
        mainForm.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            return false;
        });
    }
    
    // Initialize button event listeners
    initEventListeners();
});

function initEventListeners() {
    // Add category button event listener
    const submitButton = document.getElementById('submitCategoryButton');
    if (submitButton) {
        submitButton.addEventListener('click', handleCategorySubmit);
    }
    
    // Image preview for category image
    const categoryImage = document.getElementById('categoryImage');
    if (categoryImage) {
        categoryImage.addEventListener('change', handleImagePreview);
    }
    
    // Background image upload
    const bgUpload = document.getElementById('bgUpload');
    if (bgUpload) {
        bgUpload.addEventListener('change', handleBackgroundImage);
    }
    
    // Save all changes button
    const saveAllBtn = document.getElementById('saveAllChanges');
    if (saveAllBtn) {
        saveAllBtn.addEventListener('click', saveAllChanges);
    }
    
    // Close modal when clicking outside
    const modal = document.getElementById('categoryModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeCategoryModal();
            }
        });
    }
}

// Category Modal Functions
function showAddCategoryModal() {
    console.log('Opening add category modal...');
    
    // Reset modal
    document.getElementById('modalTitle').textContent = 'Add New Category';
    document.getElementById('submitText').textContent = 'Add Category';
    document.getElementById('categoryId').value = '';
    document.getElementById('categoryName').value = '';
    
    // Reset image preview
    document.getElementById('categoryImagePreview').classList.add('hidden');
    document.getElementById('categoryImagePreview').src = '';
    document.getElementById('uploadPlaceholder').classList.remove('hidden');
    document.getElementById('categoryImage').value = '';
    
    // Show modal
    const modal = document.getElementById('categoryModal');
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        console.log('Modal shown successfully');
    } else {
        console.error('Modal element not found!');
        alert('Error: Modal element not found. Please check your HTML.');
    }
}

function closeCategoryModal() {
    const modal = document.getElementById('categoryModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}

// Edit Category
function editCategory(categoryId) {
    // Show loading
    Swal.fire({
        title: 'Loading...',
        text: 'Fetching category data',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Fetch category data
    fetch(`<?php echo base_url('cms/get_category/'); ?>/${categoryId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        Swal.close();
        
        if (data.success) {
            // Fill modal with data
            document.getElementById('modalTitle').textContent = 'Edit Category';
            document.getElementById('submitText').textContent = 'Update Category';
            document.getElementById('categoryId').value = data.data.id;
            document.getElementById('categoryName').value = data.data.category_name;
            
            // Show image preview if exists
            const preview = document.getElementById('categoryImagePreview');
            const placeholder = document.getElementById('uploadPlaceholder');
            if (data.data.product_image) {
                preview.src = data.data.product_image;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            } else {
                preview.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
            
            // Show modal
            const modal = document.getElementById('categoryModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        } else {
            Swal.fire({
                title: 'Error!',
                text: data.message || 'Failed to load category data',
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
        }
    })
    .catch(error => {
        Swal.close();
        Swal.fire({
            title: 'Network Error!',
            text: 'Failed to load category data',
            icon: 'error',
            confirmButtonColor: '#dc3545'
        });
    });
}

// Delete Category
function deleteCategory(categoryId, categoryName) {
    Swal.fire({
        title: 'Delete Category?',
        html: `<div class="text-left">
                  <p>Are you sure you want to delete:</p>
                  <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-3">
                      <p class="font-bold text-red-700">${categoryName}</p>
                      <p class="text-sm text-red-600">ID: ${categoryId}</p>
                  </div>
                  <p class="text-sm text-slate-600">This action cannot be undone!</p>
               </div>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Delete It!',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        showClass: {
            popup: 'animate__animated animate__shakeX'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Show deleting animation
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Send delete request
            fetch(`<?php echo base_url('cms/delete_category/'); ?>/${categoryId}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Remove category from DOM with animation
                    const categoryElement = document.getElementById(`category_${categoryId}`);
                    if (categoryElement) {
                        categoryElement.classList.add('animate__animated', 'animate__fadeOutUp');
                        setTimeout(() => {
                            categoryElement.remove();
                            
                            // Update count
                            const remainingCategories = document.querySelectorAll('[id^="category_"]').length;
                            document.getElementById('categoriesCount').textContent = remainingCategories;
                            
                            // Show empty state if no categories
                            if (remainingCategories === 0) {
                                document.getElementById('categoriesContainer').innerHTML = `
                                    <div class="col-span-3">
                                        <div class="text-center py-12 border-2 border-dashed border-slate-300 rounded-2xl bg-slate-50/50">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                            <h4 class="text-lg font-medium text-slate-600 mb-2">No Categories Yet</h4>
                                            <p class="text-slate-500 mb-4">Add your first product category to get started</p>
                                            <button onclick="showAddCategoryModal()" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors inline-flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2h-5V4a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                Add First Category
                                            </button>
                                        </div>
                                    </div>
                                `;
                            }
                        }, 300);
                    }
                    
                    Swal.fire({
                        title: 'Deleted!',
                        text: data.message || 'Category deleted successfully',
                        icon: 'success',
                        confirmButtonColor: '#059669',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'Failed to delete category',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Network Error!',
                    text: 'Failed to delete category',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            });
        }
    });
}

// Handle Category Submit
function handleCategorySubmit(e) {
    e.preventDefault();
    e.stopPropagation();
    
    const categoryName = document.getElementById('categoryName').value.trim();
    if (!categoryName) {
        Swal.fire({
            title: 'Validation Error!',
            text: 'Please enter a category name',
            icon: 'warning',
            confirmButtonColor: '#f59e0b'
        });
        return;
    }
    
    const isEdit = document.getElementById('categoryId').value !== '';
    const actionText = isEdit ? 'update' : 'add';
    closeCategoryModal();
    // Show confirmation
    Swal.fire({
        title: `Confirm ${actionText}`,
        html: `<div class="text-left">
                  <p>You are about to ${actionText} the category:</p>
                  <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-3">
                      <p class="font-bold text-indigo-700">${categoryName}</p>
                  </div>
                  <p>Are you sure you want to proceed?</p>
               </div>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#4f46e5',
        cancelButtonColor: '#6b7280',
        confirmButtonText: `Yes, ${actionText} it!`,
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: `${isEdit ? 'Updating' : 'Adding'} Category...`,
                text: 'Please wait',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Prepare form data
            const formData = new FormData();
            formData.append('category_name', categoryName);
            
            // Add category ID only if editing
            const categoryId = document.getElementById('categoryId').value;
            if (categoryId) {
                formData.append('category_id', categoryId);
            }
            
            // Add image file if selected (optional)
            const imageInput = document.getElementById('categoryImage');
            if (imageInput.files[0]) {
                formData.append('category_image', imageInput.files[0]);
            }
         
            // Determine URL
            const url = isEdit 
                ? `<?php echo base_url('cms/update_category/'); ?>/${categoryId}`
                : `<?php echo base_url('cms/add_category'); ?>`;
            
            // Send request
            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                Swal.close();
                
                if (data.success) {
                    // Close modal
                    closeCategoryModal();
                    
                    // Show success and reload
                    Swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#059669',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || `Failed to ${actionText} category`,
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                Swal.close();
                Swal.fire({
                    title: 'Network Error!',
                    text: 'Failed to save category: ' + error.message,
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            });
        }
    });
}

// Image Preview Handler
function handleImagePreview(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('categoryImagePreview');
    const placeholder = document.getElementById('uploadPlaceholder');
    
    if (file) {
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({
                title: 'File Too Large!',
                text: 'Maximum file size is 2MB',
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
            e.target.value = '';
            return;
        }
        
        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
        if (!validTypes.includes(file.type)) {
            Swal.fire({
                title: 'Invalid File Type!',
                text: 'Please upload JPG, PNG, GIF, WebP or SVG image files only',
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
            e.target.value = '';
            return;
        }
        
        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
}

// Upload Category Image (for existing categories)
function uploadCategoryImage(categoryId, input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({
                title: 'File Too Large!',
                text: 'Maximum file size is 2MB',
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
            input.value = '';
            return;
        }
        
        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
        if (!validTypes.includes(file.type)) {
            Swal.fire({
                title: 'Invalid File Type!',
                text: 'Please upload JPG, PNG, GIF, WebP or SVG image files only',
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
            input.value = '';
            return;
        }
        
        // Show loading
        Swal.fire({
            title: 'Uploading Image...',
            text: 'Please wait',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Prepare form data
        const formData = new FormData();
        formData.append('product_image', file);
        
        // Send request
        fetch(`<?php echo base_url('cms/upload_category_image/'); ?>${categoryId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            Swal.close();
            
            if (data.success) {
                // Update preview image
                const previewImg = document.getElementById(`preview_${categoryId}`);
                if (previewImg) {
                    previewImg.src = data.image_url;
                }
                
                // Update image name display
                const imageNameDisplay = document.getElementById(`imageName_${categoryId}`);
                if (imageNameDisplay) {
                    imageNameDisplay.textContent = file.name;
                }
                
                Swal.fire({
                    title: 'Success!',
                    text: 'Image uploaded successfully',
                    icon: 'success',
                    confirmButtonColor: '#059669',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message || 'Failed to upload image',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            }
        })
        .catch(error => {
            Swal.close();
            Swal.fire({
                title: 'Network Error!',
                text: 'Failed to upload image',
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
        });
    }
}

// Background Image Handler
function handleBackgroundImage(e) {
    const file = e.target.files[0];
    if (file) {
        // Validate file
        if (!file.type.match('image.*')) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid file',
                text: 'Please select an image file'
            });
            return;
        }
        
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'File too large',
                text: 'Please select an image smaller than 2MB'
            });
            return;
        }
        
        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('bgPreview').src = e.target.result;
        };
        reader.readAsDataURL(file);
        
        // Update hidden input
        document.getElementById('bg_image').value = file.name;
        
        Swal.fire({
            icon: 'success',
            title: 'Background image selected!',
            text: 'Click "Save All Changes" to upload it',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    }
}

// Save All Changes
function saveAllChanges() {
    const saveBtn = document.getElementById('saveAllChanges');
    
    // Confirm before saving
    Swal.fire({
        title: 'Save All Changes?',
        html: `<div class="text-left">
                  <p>This will save:</p>
                  <ul class="list-disc pl-5 mt-2 text-sm text-slate-600">
                      <li>Page settings and background image</li>
                      <li>All category images and updates</li>
                      <li>Bottom inquiry section content</li>
                  </ul>
                  <p class="mt-3">Are you sure you want to proceed?</p>
               </div>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#4f46e5',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Save All!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            const originalHTML = saveBtn.innerHTML;
            saveBtn.innerHTML = `
                <svg class="animate-spin h-5 w-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Saving...
            `;
            saveBtn.disabled = true;
            saveBtn.classList.add('saving');
            
            // Show loading Swal
            Swal.fire({
                title: 'Saving Changes...',
                text: 'Please wait while we save your updates',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Collect all data
            const formData = new FormData();
            
            // Page settings
            formData.append('page_title', document.getElementById('page_title')?.value || '');
            formData.append('bg_image', document.getElementById('bg_image')?.value || '');
            
            // CTA section
            formData.append('cta_headline', document.getElementById('cta_headline')?.value || '');
            formData.append('cta_description', document.getElementById('cta_description')?.value || '');
            formData.append('cta_button_text', document.getElementById('cta_button_text')?.value || '');
            formData.append('cta_button_link', document.getElementById('cta_button_link')?.value || '');
            
            // Handle background image file upload if changed
            const bgFileInput = document.getElementById('bgUpload');
            if (bgFileInput.files[0]) {
                formData.append('bg_image_file', bgFileInput.files[0]);
            }
            
            // Send to server
            fetch('<?php echo base_url("cms/save_products"); ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Restore button state
                saveBtn.innerHTML = originalHTML;
                saveBtn.disabled = false;
                saveBtn.classList.remove('saving');
                
                Swal.close();
                
                if (data.success) {
                    Swal.fire({
                        title: 'Saved Successfully!',
                        html: `<div class="text-left">
                                  <p class="mb-2">${data.message}</p>
                                  ${data.updated_count ? `<p class="text-sm text-slate-600">Updated ${data.updated_count} items</p>` : ''}
                                  ${data.warnings && data.warnings.length > 0 ? 
                                      `<div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                          <p class="text-sm font-medium text-yellow-800 mb-1">Warnings:</p>
                                          <ul class="list-disc pl-5 text-sm text-yellow-700">
                                              ${data.warnings.map(w => `<li>${w}</li>`).join('')}
                                          </ul>
                                      </div>` : ''
                                  }
                               </div>`,
                        icon: 'success',
                        confirmButtonColor: '#059669',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        title: 'Save Failed',
                        text: data.message || 'There was an error saving your changes.',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Restore button state
                saveBtn.innerHTML = originalHTML;
                saveBtn.disabled = false;
                saveBtn.classList.remove('saving');
                
                Swal.close();
                
                Swal.fire({
                    title: 'Network Error',
                    text: 'Failed to save changes. Please check your connection and try again.',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            });
        }
    });
}

// View Products
function viewProducts(categoryId, categoryName) {
    window.location.href = '<?php echo base_url(); ?>cms/product_items/' + categoryId;
}
</script>

<style>
/* Additional custom styles */
.swal2-popup {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    border-radius: 1rem !important;
}

.swal2-input {
    border-radius: 0.75rem !important;
    border: 1px solid #e2e8f0 !important;
    padding: 0.75rem 1rem !important;
    margin: 0.5rem 0 !important;
}

.swal2-input:focus {
    border-color: #6366f1 !important;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1) !important;
}

#categoriesContainer > div {
    animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>