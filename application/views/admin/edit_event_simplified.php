

<main class="ml-64 p-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Edit Event</h1>
                    <p class="text-slate-500 mt-1">Update event details</p>
                </div>
                <a href="<?php echo base_url('cms/news_and_events'); ?>" 
                   class="px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50">
                    ← Back
                </a>
            </div>
        </div>

        <!-- Form -->
        <form action="<?php echo base_url('cms/update_event/' . $event['id']); ?>" method="POST" enctype="multipart/form-data" id="eventForm">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" 
                   value="<?php echo $this->security->get_csrf_hash(); ?>">
            
            <div class="space-y-6">
                <!-- Basic Info -->
                <div class="bg-white rounded-lg border border-slate-200 p-6">
                    <h3 class="font-semibold text-slate-900 mb-4">Basic Information</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Title *</label>
                            <input type="text" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Content *</label>
                            <textarea name="content" rows="6" required
                                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500"><?php echo htmlspecialchars($event['content']); ?></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Meta Description</label>
                            <textarea name="meta_description" rows="2"
                                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500"><?php echo htmlspecialchars($event['meta_description']); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Details -->
                <div class="bg-white rounded-lg border border-slate-200 p-6">
                    <h3 class="font-semibold text-slate-900 mb-4">Details</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Category *</label>
                            <select name="category" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option value="">Select</option>
                                <option value="news" <?php echo $event['category'] == 'news' ? 'selected' : ''; ?>>News</option>
                                <option value="events" <?php echo $event['category'] == 'events' ? 'selected' : ''; ?>>Events</option>
                                <option value="product" <?php echo $event['category'] == 'product' ? 'selected' : ''; ?>>Product</option>
                                <option value="webinars" <?php echo $event['category'] == 'webinars' ? 'selected' : ''; ?>>Webinars</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Date *</label>
                            <input type="date" name="event_date" value="<?php echo $event['event_date']; ?>" required
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Badge Text</label>
                            <input type="text" name="badge_text" value="<?php echo htmlspecialchars($event['badge_text']); ?>"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                            <select name="status"
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option value="active" <?php echo $event['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                <option value="inactive" <?php echo $event['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-4 flex items-center gap-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_featured" value="1" <?php echo $event['is_featured'] ? 'checked' : ''; ?>
                                   class="w-4 h-4 text-indigo-600 border-slate-300 rounded">
                            <span class="ml-2 text-sm text-slate-700">Featured Event</span>
                        </label>
                        
                        <!-- Gated Checkbox -->
                        <label class="flex items-center">
                            <input type="checkbox" name="is_gated" value="1" <?php echo isset($event['is_gated']) && $event['is_gated'] ? 'checked' : ''; ?>
                                   class="w-4 h-4 text-indigo-600 border-slate-300 rounded">
                            <span class="ml-2 text-sm text-slate-700">Gated Content</span>
                            
                        </label>
                    </div>
                </div>

                <!-- Image -->
                <div class="bg-white rounded-lg border border-slate-200 p-6">
                    <h3 class="font-semibold text-slate-900 mb-4">Image</h3>
                    
                    <?php if (!empty($event['image'])): ?>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Current Image</label>
                        <div class="flex items-center gap-4">
                            <img src="<?php echo base_url('assets_system/images/' . $event['image']); ?>" 
                                 class="w-32 h-20 object-cover rounded">
                            <span class="text-sm text-slate-500"><?php echo $event['image']; ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="border-2 border-dashed border-slate-300 rounded-lg p-8 text-center">
                        <input type="file" name="image_file" id="imageInput" accept="image/*" class="hidden">
                        <div id="uploadPrompt" onclick="document.getElementById('imageInput').click()" 
                             class="cursor-pointer">
                            <div class="text-4xl mb-2">📷</div>
                            <p class="text-slate-600">Click to upload new image</p>
                            <p class="text-sm text-slate-500 mt-1">Recommended: 1200×600px, Max 2MB</p>
                        </div>
                        <div id="imagePreview" class="hidden">
                            <img id="previewImg" class="max-w-full h-auto rounded-lg mx-auto">
                            <button type="button" onclick="removeImage()" 
                                    class="mt-3 px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                Remove
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex justify-end gap-3">
                    <a href="<?php echo base_url('cms/news_and_events'); ?>" 
                       class="px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</main>

<script>
const imageInput = document.getElementById('imageInput');
const uploadPrompt = document.getElementById('uploadPrompt');
const imagePreview = document.getElementById('imagePreview');
const previewImg = document.getElementById('previewImg');

imageInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            uploadPrompt.classList.add('hidden');
            imagePreview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
});

function removeImage() {
    imageInput.value = '';
    uploadPrompt.classList.remove('hidden');
    imagePreview.classList.add('hidden');
}
</script>