<main class="ml-64 p-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Contact Us Content Management</h1>
                <p class="text-slate-500 mt-1">Manage all content for the Contact Us page in one place.</p>
            </div>
            <div class="flex gap-3">
                <a href="<?= base_url('admin/contact_us/preview'); ?>" target="_blank" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-50 transition-all">Preview Page</a>
            </div>
        </div>

        <!-- Success/Error Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('error')): ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Form (Create/Edit) -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden sticky top-8">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h2 class="font-bold text-slate-800">
                            <?= $edit_item ? 'Edit Content' : 'Edit Content'; ?>
                        </h2>
                    </div>
                    
                    <form method="post" action="<?= base_url('cms/contact_us'); ?>" enctype="multipart/form-data" class="p-6 space-y-6">
                        <input type="hidden" name="id" value="<?= $edit_item ? $edit_item['id'] : ''; ?>">
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Title *</label>
                            <input type="text" name="title" value="<?= $edit_item ? htmlspecialchars($edit_item['title']) : ''; ?>" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" required placeholder="e.g., Contact Hero Title">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Content *</label>
                            <textarea name="content" rows="5" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" required placeholder="Enter the content text..."><?= $edit_item ? htmlspecialchars($edit_item['content']) : ''; ?></textarea>
                        </div>
                        
                        <!-- Image Upload Section -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Image</label>
                            
                            <!-- Current Image Preview -->
                            <?php if ($edit_item && !empty($edit_item['image'])): ?>
                                <div class="mb-4 p-3 border border-slate-200 rounded-xl bg-slate-50">
                                    <p class="text-sm text-slate-600 mb-2">Current Image:</p>
                                    <div class="flex items-center gap-3">
                                        <div class="w-16 h-16 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0">
                                            <img src="<?= base_url('assets_system/images/' . $edit_item['image']); ?>" alt="Current" class="w-full h-full object-cover" onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center text-slate-400\'><i class=\'fas fa-image text-2xl\'></i></div>';">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-slate-800 truncate"><?= $edit_item['image']; ?></p>
                                            <p class="text-xs text-slate-500">Click "Upload New Image" to replace</p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Image Upload Input -->
                            <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 text-center hover:border-indigo-300 transition-colors cursor-pointer" onclick="document.getElementById('image_file').click()">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <div class="w-12 h-12 bg-indigo-50 rounded-full flex items-center justify-center">
                                        <i class="fas fa-cloud-upload-alt text-indigo-500 text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-700">Click to upload image</p>
                                        <p class="text-xs text-slate-500 mt-1">JPG, PNG, GIF, WebP (Max 2MB)</p>
                                    </div>
                                </div>
                                <input type="file" id="image_file" name="image_file" class="hidden" accept=".jpg,.jpeg,.png,.gif,.webp" onchange="previewImage(this)">
                            </div>
                            
                            <!-- Image Preview -->
                            <div id="image_preview" class="mt-3 hidden">
                                <div class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl bg-slate-50">
                                    <div class="w-16 h-16 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0">
                                        <img id="uploaded_image_preview" src="" alt="Preview" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p id="image_filename" class="text-sm font-medium text-slate-800 truncate"></p>
                                        <p class="text-xs text-slate-500">New image selected</p>
                                    </div>
                                    <button type="button" onclick="removeImage()" class="p-1 text-slate-400 hover:text-red-500 transition-colors">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Hidden input for existing image filename -->
                            <input type="hidden" name="image" id="image_filename_input" value="<?= $edit_item ? htmlspecialchars($edit_item['image']) : ''; ?>">
                        </div>
                        
                        <div class="flex gap-3 pt-4 border-t border-slate-100">
                            <?php if ($edit_item): ?>
                                <a href="<?= base_url('cms/contact_us'); ?>" class="px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition-colors">Cancel Edit</a>
                            <?php endif; ?>
                            <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition-all flex-1">
                                <?= $edit_item ? 'Update Content' : 'Update Content'; ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column: Content List -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h2 class="font-bold text-slate-800">All Content Items</h2>
                        <p class="text-sm text-slate-500 mt-1"><?= count($content_items); ?> items total</p>
                    </div>
                    
                    <div class="divide-y divide-slate-100">
                        <?php if (empty($content_items)): ?>
                            <div class="p-8 text-center text-slate-500">
                                No content found. Create your first content item using the form on the left.
                            </div>
                        <?php else: ?>
                            <?php foreach ($content_items as $item): ?>
                                <div class="p-6 hover:bg-slate-50 transition-colors <?= $edit_item && $edit_item['id'] == $item['id'] ? 'bg-indigo-50' : ''; ?>">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <span class="px-2 py-1 bg-slate-100 text-slate-600 text-xs font-mono rounded">#<?= $item['id']; ?></span>
                                                <h3 class="font-semibold text-slate-800"><?= htmlspecialchars($item['title']); ?></h3>
                                            </div>
                                            
                                            <p class="text-slate-600 mb-3">
                                                <?= strlen($item['content']) > 150 ? htmlspecialchars(substr($item['content'], 0, 150)) . '...' : htmlspecialchars($item['content']); ?>
                                            </p>
                                            
                                            <div class="flex items-center gap-4 text-sm text-slate-500">
                                                <?php if ($item['image']): ?>
                                                    <div class="flex items-center gap-2">
                                                        <div class="w-6 h-6 bg-slate-100 rounded overflow-hidden">
                                                            <img src="<?= base_url('assets_system/images/' . $item['image']); ?>" alt="" class="w-full h-full object-cover" onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'w-6 h-6 flex items-center justify-center text-slate-400\'><i class=\'fas fa-image\'></i></div>';">
                                                        </div>
                                                        <span><?= $item['image']; ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <span class="text-xs">
                                                    Updated: <?= date('M d, Y', strtotime($item['updated_at'] ?: $item['created_at'])); ?>
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center gap-2 ml-4">
                                            <a href="?edit=<?= $item['id']; ?>" class="px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-medium hover:bg-indigo-100 transition-colors">Edit</a>
                                            <a href="<?= base_url('cms/delete_contact/' . $item['id']); ?>" class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-sm font-medium hover:bg-red-100 transition-colors" onclick="return confirm('Are you sure you want to delete this?')">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
// Image preview functionality
function previewImage(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('uploaded_image_preview').src = e.target.result;
            document.getElementById('image_filename').textContent = file.name;
            document.getElementById('image_preview').classList.remove('hidden');
            
            // Clear the hidden filename input since we're uploading a new image
            document.getElementById('image_filename_input').value = '';
        }
        
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    document.getElementById('image_file').value = '';
    document.getElementById('image_preview').classList.add('hidden');
    document.getElementById('image_filename_input').value = '';
}

// Scroll to form when editing
document.addEventListener('DOMContentLoaded', function() {
    <?php if ($edit_item): ?>
        // Scroll to form when editing
        document.querySelector('.lg\\:col-span-1').scrollIntoView({ behavior: 'smooth' });
        
        // Highlight the form
        const formDiv = document.querySelector('.bg-white.rounded-2xl');
        formDiv.classList.add('ring-2', 'ring-indigo-500');
        
        // Remove highlight after 3 seconds
        setTimeout(() => {
            formDiv.classList.remove('ring-2', 'ring-indigo-500');
        }, 3000);
    <?php endif; ?>
    
    // Auto-focus title field when creating new
    <?php if (!$edit_item): ?>
        document.querySelector('input[name="title"]').focus();
    <?php endif; ?>
    
    // Validate file size before upload
    document.getElementById('image_file').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const maxSize = 2 * 1024 * 1024; // 2MB in bytes
            if (file.size > maxSize) {
                alert('File size exceeds 2MB limit. Please choose a smaller file.');
                this.value = '';
                removeImage();
            }
        }
    });
});

// Show notification
function showNotification(message, type = 'success') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-lg border transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-50 border-green-200 text-green-800' :
        type === 'error' ? 'bg-red-50 border-red-200 text-red-800' :
        'bg-blue-50 border-blue-200 text-blue-800'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <span class="mr-3">${type === 'success' ? '✓' : '✗'}</span>
            <span>${message}</span>
            <button class="ml-4 text-slate-400 hover:text-slate-600" onclick="this.parentElement.parentElement.remove()">
                ×
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}
</script>