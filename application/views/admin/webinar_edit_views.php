<main class="ml-64 p-8">
    <div class="max-w-4xl mx-auto">
        <?php if($this->session->flashdata('success')): ?>
        <div id="successMessage" class="hidden" data-message="<?php echo htmlspecialchars($this->session->flashdata('success')); ?>"></div>
        <?php endif; ?>
        <?php if($this->session->flashdata('error')): ?>
        <div id="errorMessage" class="hidden" data-message="<?php echo htmlspecialchars($this->session->flashdata('error')); ?>"></div>
        <?php endif; ?>

        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Edit Webinar</h1>
                <p class="text-slate-500 mt-1">Update webinar series details and cover image.</p>
            </div>
            <div class="flex gap-3">
                <a href="<?php echo site_url('cms/library'); ?>" class="px-5 py-2.5 border border-slate-300 text-slate-700 rounded-xl font-semibold hover:bg-slate-50 transition-all flex items-center">
                    <i class="fas fa-arrow-left mr-2 text-xs"></i> Back to Library
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <form method="POST" action="<?php echo site_url('cms/webinar_edit/' . $webinar['id']); ?>" enctype="multipart/form-data">
                <input type="hidden" name="current_image" value="<?= isset($webinar['main_image']) ? htmlspecialchars($webinar['main_image']) : '' ?>">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Webinar Title -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Webinar Title *</label>
                            <input type="text" name="webinar_title" required
                                   value="<?= isset($webinar['webinar_title']) ? htmlspecialchars($webinar['webinar_title']) : '' ?>"
                                   class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <!-- Description 1 -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Description</label>
                            <textarea name="description_1" rows="4"
                                      class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"><?= isset($webinar['description_1']) ? htmlspecialchars($webinar['description_1']) : '' ?></textarea>
                        </div>

                        <!-- Description 2 -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Additional Description <span class="text-slate-400 font-normal">(optional)</span></label>
                            <textarea name="description_2" rows="3"
                                      class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"><?= isset($webinar['description_2']) ? htmlspecialchars($webinar['description_2']) : '' ?></textarea>
                        </div>

                        <!-- Main Image -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Cover Image</label>

                            <?php if(!empty($webinar['main_image'])): ?>
                            <div class="mb-4 p-4 bg-slate-50 rounded-lg border border-slate-200">
                                <p class="text-xs text-slate-500 mb-2 font-medium">Current Image:</p>
                                <div class="flex items-center gap-4">
                                    <img src="<?= base_url('assets_system/images/' . $webinar['main_image']) ?>"
                                         alt="Current cover" class="w-32 h-20 object-cover rounded-lg border">
                                    <div>
                                        <p class="text-xs text-slate-600"><?= htmlspecialchars($webinar['main_image']) ?></p>
                                        <label class="flex items-center mt-2 cursor-pointer">
                                            <input type="checkbox" name="remove_image" value="1" class="w-4 h-4 text-red-600 border-slate-300 rounded mr-2">
                                            <span class="text-xs text-red-600">Remove this image</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="space-y-4">
                                <div class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center hover:border-indigo-400 transition-colors cursor-pointer" id="imageUploadArea">
                                    <i class="fas fa-image text-slate-400 text-3xl mb-3"></i>
                                    <p class="text-sm text-slate-600">Click to upload new cover image</p>
                                    <p class="text-xs text-slate-400 mt-1">JPG, PNG, GIF, WEBP (Max 2MB)</p>
                                    <input type="file" name="main_image" id="imageFile" class="hidden" accept="image/*">
                                </div>
                                <div id="imagePreview" class="mt-2 hidden">
                                    <div class="flex items-center space-x-3">
                                        <img src="" alt="Preview" class="w-24 h-16 object-cover rounded-lg border">
                                        <button type="button" onclick="removeNewImage()" class="text-xs text-red-600 hover:text-red-800">
                                            <i class="fas fa-times mr-1"></i> Remove
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <p class="text-sm text-slate-600 mb-2">Or enter existing image filename:</p>
                                    <input type="text" name="main_image_url" id="imageUrl"
                                           class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                           placeholder="e.g., webinar-cover.png">
                                    <p class="text-xs text-slate-500 mt-1">If image already exists in assets_system/images/</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Sidebar -->
                    <div class="space-y-6">
                        <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-5">
                            <h3 class="text-sm font-bold text-indigo-700 mb-4"><i class="fas fa-info-circle mr-2"></i>Webinar Info</h3>
                            <ul class="space-y-3 text-sm text-slate-600">
                                <li class="flex items-start">
                                    <i class="fas fa-hashtag text-indigo-500 mt-0.5 mr-2"></i>
                                    <span>ID: <strong><?= $webinar['id'] ?></strong></span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-link text-indigo-500 mt-0.5 mr-2"></i>
                                    <span>Resources linked to this webinar will be grouped in the library</span>
                                </li>
                            </ul>
                        </div>

                        <div class="bg-red-50 border border-red-200 rounded-xl p-5">
                            <h3 class="text-sm font-bold text-red-700 mb-3"><i class="fas fa-exclamation-triangle mr-2"></i>Danger Zone</h3>
                            <p class="text-xs text-red-600 mb-3">Deleting this webinar will unlink all associated resources.</p>
                            <a href="<?= site_url('cms/webinar_delete/' . $webinar['id']) ?>"
                               onclick="return confirm('Are you sure you want to delete this webinar? All resources linked to it will be unlinked.')"
                               class="w-full px-4 py-2.5 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-colors flex items-center justify-center text-sm">
                                <i class="fas fa-trash mr-2"></i> Delete Webinar
                            </a>
                        </div>

                        <div class="pt-4 border-t border-slate-200">
                            <button type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition-all flex items-center justify-center">
                                <i class="fas fa-save mr-2"></i> Update Webinar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    const imageUploadArea = document.getElementById('imageUploadArea');
    const imageFileInput = document.getElementById('imageFile');
    const imagePreview = document.getElementById('imagePreview');

    imageUploadArea.addEventListener('click', () => imageFileInput.click());

    imageFileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            if (!file.type.match('image.*')) {
                alert('Please select an image file');
                this.value = '';
                return;
            }
            if (file.size > 2 * 1024 * 1024) {
                alert('Image must be less than 2MB');
                this.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.querySelector('img').src = e.target.result;
                imagePreview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
            document.getElementById('imageUrl').value = '';
        }
    });

    function removeNewImage() {
        imageFileInput.value = '';
        imagePreview.classList.add('hidden');
        imagePreview.querySelector('img').src = '';
    }
</script>
