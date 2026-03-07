<?php $this->load->view('admin/header'); ?>

<style>
.sticky-header {
    transition: all 0.3s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.sticky-header.scrolled {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.scroll-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 2px;
    background: linear-gradient(90deg, #4f46e5, #7c3aed);
    transition: width 0.3s ease;
}

.image-preview-container {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid #e5e7eb;
    margin: 0 auto;
    transition: all 0.3s;
}

.image-preview-container:hover {
    border-color: #4f46e5;
    transform: scale(1.05);
}

.image-preview {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>

<main class="ml-64 p-8">
    <!-- STICKY HEADER SECTION -->
    <div class="sticky top-0 z-40 bg-slate-50 -mx-8 px-8 py-4 sticky-header mb-8">
        <div class="max-w-3xl mx-auto">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Add New Testimonial</h1>
                    <p class="text-slate-500 mt-1">Create a new client testimonial</p>
                </div>
                <div class="flex gap-3">
                    <a href="<?php echo site_url('cms/testimonial'); ?>" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-50 transition-all flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>
        <!-- Scroll Progress Bar -->
        <div class="scroll-progress"></div>
    </div>

    <div class="max-w-3xl mx-auto">
        <!-- Form -->
        <form action="<?php echo site_url('cms/add_testimonial'); ?>" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <input type="hidden" name="csrf_token" value="<?php echo $this->security->get_csrf_hash(); ?>">
            
            <!-- Form Header -->
            <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-indigo-50 to-purple-50">
                <h3 class="font-bold text-slate-800 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Testimonial Details
                </h3>
            </div>
            
            <!-- Form Body -->
            <div class="p-6 space-y-6">
                <!-- Image Upload Section -->
                <div class="text-center mb-8">
                    <div class="image-preview-container mb-4">
                        <img id="imagePreview" src="<?php echo base_url('assets_system/images/default-avatar.png'); ?>" alt="Preview" class="image-preview">
                    </div>
                    <div>
                        <label for="image" class="cursor-pointer inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Choose Image
                        </label>
                        <input type="file" id="image" name="image" class="hidden" accept="image/*" onchange="previewImage(this)">
                        <p class="text-xs text-slate-500 mt-2">Recommended: Square image (500x500px) - Max 2MB</p>
                    </div>
                </div>

                <!-- Name Field -->
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">
                        Client Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="<?php echo set_value('name'); ?>" required
                           class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                           placeholder="e.g., John Smith">
                    <?php echo form_error('name', '<p class="text-xs text-red-500 mt-1">', '</p>'); ?>
                </div>

                <!-- Position Field -->
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">
                        Position / Company
                    </label>
                    <input type="text" name="position" value="<?php echo set_value('position'); ?>"
                           class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                           placeholder="e.g., CEO, TechCorp Inc.">
                </div>

                <!-- Content Field -->
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">
                        Testimonial Content <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content" rows="5" required
                              class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition resize-none"
                              placeholder="Write the testimonial here..."><?php echo set_value('content'); ?></textarea>
                    <?php echo form_error('content', '<p class="text-xs text-red-500 mt-1">', '</p>'); ?>
                </div>

                <!-- Sort Order Field -->
                <div style="display: none">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">
                        Display Order
                    </label>
                    <input type="number" name="sort_order" value="<?php echo set_value('sort_order', 0); ?>" min="0"
                           class="w-32 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                           placeholder="0">
                    <p class="text-xs text-slate-500 mt-1">Lower numbers appear first</p>
                </div>

                <!-- Status Field -->
                <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    </label>
                    <span class="text-sm font-medium text-slate-700">Active (visible on website)</span>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="p-6 border-t border-slate-100 bg-slate-50/50 flex justify-end gap-3">
                <a href="<?php echo site_url('cms/testimonial'); ?>" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-semibold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition-all flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Save Testimonial
                </button>
            </div>
        </form>
    </div>
</main>

<script>
// Image preview
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Scroll Progress Bar
window.addEventListener('scroll', function() {
    const winScroll = document.documentElement.scrollTop;
    const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrolled = (winScroll / height) * 100;
    document.querySelector('.scroll-progress').style.width = scrolled + '%';
    
    // Sticky header shadow
    const header = document.querySelector('.sticky-header');
    if (winScroll > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});
</script>