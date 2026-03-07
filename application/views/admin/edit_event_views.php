<?php $this->load->view('admin/header'); ?>

<main class="ml-64 p-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Edit Event</h1>
                <p class="text-slate-500 mt-1">Update event details and content</p>
            </div>
            <div class="flex gap-3">
                <a href="<?php echo base_url('cms/news_and_events'); ?>" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-50 transition-all">Cancel</a>
                <button id="saveEvent" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition-all">Save Changes</button>
            </div>
        </div>

        <form action="<?php echo base_url('cms/update_event/' . $event['id']); ?>" method="POST" enctype="multipart/form-data" id="eventForm">
            <!-- FIXED: CodeIgniter 3 CSRF Protection -->
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            
            <div class="space-y-8">
                <!-- Basic Information -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 flex items-center"><span class="mr-2">📝</span> Basic Information</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="text-sm font-medium text-slate-700 mb-2 block">Event Title *</label>
                            <input type="text" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" required>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-slate-700 mb-2 block">Content *</label>
                            <textarea name="content" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition min-h-[200px]" required><?php echo htmlspecialchars($event['content']); ?></textarea>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-slate-700 mb-2 block">Meta Description</label>
                            <textarea name="meta_description" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" rows="3"><?php echo htmlspecialchars($event['meta_description']); ?></textarea>
                            <p class="text-xs text-slate-500 mt-1">Keep it under 160 characters for best SEO results</p>
                        </div>
                    </div>
                </section>

                <!-- Category & Details -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 flex items-center"><span class="mr-2">🏷️</span> Category & Details</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-sm font-medium text-slate-700 mb-2 block">Category *</label>
                                <select name="category" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" required>
                                    <option value="">Select Category</option>
                                    <option value="news" <?php echo $event['category'] == 'news' ? 'selected' : ''; ?>>Company News</option>
                                    <option value="events" <?php echo $event['category'] == 'events' ? 'selected' : ''; ?>>Events & Exhibitions</option>
                                    <option value="product" <?php echo $event['category'] == 'product' ? 'selected' : ''; ?>>Product Updates</option>
                                    
                                </select>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-slate-700 mb-2 block">Event Date *</label>
                                <input type="date" name="event_date" value="<?php echo $event['event_date']; ?>" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" required>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-sm font-medium text-slate-700 mb-2 block">Badge Text</label>
                                <input type="text" name="badge_text" value="<?php echo htmlspecialchars($event['badge_text']); ?>" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-slate-700 mb-2 block">Status</label>
                                <select name="status" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                                    <option value="active" <?php echo $event['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?php echo $event['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_featured" id="is_featured" value="1" <?php echo $event['is_featured'] ? 'checked' : ''; ?> class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                                <label for="is_featured" class="ml-2 text-sm font-medium text-slate-700">Mark as Featured Event</label>
                            </div>
                            <span class="text-xs text-slate-500">Featured events appear prominently on the homepage</span>
                        </div>
                    </div>
                </section>

                <!-- Featured Image -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 flex items-center"><span class="mr-2">🖼️</span> Featured Image</h3>
                    </div>
                    <div class="p-6">
                        <div class="mb-4">
                            <label class="text-sm font-medium text-slate-700 mb-2 block">Current Image</label>
                            
                            <?php if (!empty($event['image'])): ?>
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-48 h-32 bg-slate-100 rounded-xl border border-slate-200 overflow-hidden">
                                    <img id="currentImage" src="<?php echo base_url('assets_system/images/' . $event['image']); ?>" alt="Current Image" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <div class="mb-2">
                                        <span class="text-sm font-medium text-slate-700">Filename: </span>
                                        <span class="text-sm text-slate-500"><?php echo $event['image']; ?></span>
                                    </div>
                                    <div class="text-sm text-slate-500">
                                        Upload new image to replace current one
                                    </div>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="mb-6 p-4 bg-slate-50 rounded-lg">
                                <p class="text-sm text-slate-600">No image currently set.</p>
                            </div>
                            <?php endif; ?>
                            
                            <label class="text-sm font-medium text-slate-700 mb-2 block">Upload New Image</label>
                            <p class="text-sm text-slate-500 mb-4">Recommended size: 1200×600px. Max file size: 2MB</p>
                            
                            <div class="border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center hover:border-indigo-300 transition-colors cursor-pointer" onclick="document.getElementById('image_file').click()">
                                <div class="mx-auto w-16 h-16 mb-4 bg-indigo-50 rounded-full flex items-center justify-center">
                                    <span class="text-2xl text-indigo-500">📷</span>
                                </div>
                                <p class="text-slate-700 font-medium mb-2">Click to upload new image</p>
                                <p class="text-sm text-slate-500">or drag and drop</p>
                                <input type="file" name="image_file" id="image_file" class="hidden" accept="image/*">
                                <input type="hidden" name="image" id="image" value="<?php echo !empty($event['image']) ? $event['image'] : ''; ?>">
                            </div>
                        </div>
                        
                        <div id="imagePreview" class="hidden">
                            <div class="mt-4">
                                <label class="text-sm font-medium text-slate-700 mb-2 block">New Image Preview</label>
                                <div class="relative max-w-md">
                                    <img id="previewImage" class="w-full h-auto rounded-xl border border-slate-200" src="" alt="Preview">
                                    <button type="button" onclick="removeImage()" class="absolute top-2 right-2 p-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors">
                                        ✕
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </form>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image upload preview
    const imageInput = document.getElementById('image_file');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    const imageHidden = document.getElementById('image');
    
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                imagePreview.classList.remove('hidden');
                // Update hidden field with new filename
                imageHidden.value = file.name;
            }
            reader.readAsDataURL(file);
        }
    });
    
    // Form submission with validation
    document.getElementById('saveEvent').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent default to validate first
        
        const form = document.getElementById('eventForm');
        const saveBtn = this;
        const originalText = saveBtn.textContent;
        
        // Basic validation
        const title = form.querySelector('[name="title"]').value.trim();
        const content = form.querySelector('[name="content"]').value.trim();
        const category = form.querySelector('[name="category"]').value;
        const eventDate = form.querySelector('[name="event_date"]').value;
        
        if (!title || !content || !category || !eventDate) {
            alert('Please fill in all required fields (Title, Content, Category, and Event Date)');
            return;
        }
        
        // Show loading state
        saveBtn.innerHTML = '<span class="inline-flex items-center"><svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...</span>';
        saveBtn.disabled = true;
        
        // Submit form
        form.submit();
    });
});

function removeImage() {
    document.getElementById('image_file').value = '';
    document.getElementById('imagePreview').classList.add('hidden');
    // Reset hidden field to original image if exists, otherwise empty
    const originalImage = "<?php echo !empty($event['image']) ? $event['image'] : ''; ?>";
    document.getElementById('image').value = originalImage;
}
</script>