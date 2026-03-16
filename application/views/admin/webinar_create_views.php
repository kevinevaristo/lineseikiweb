<main class="ml-64 p-8">
    <div class="max-w-4xl mx-auto">
        <?php if($this->session->flashdata('error')): ?>
        <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded-xl">
            <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php endif; ?>

        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Create New Webinar</h1>
                <p class="text-slate-500 mt-1">Add a new webinar series that resources can be linked to.</p>
            </div>
            <div class="flex gap-3">
                <a href="<?php echo site_url('cms/library'); ?>" class="px-5 py-2.5 border border-slate-300 text-slate-700 rounded-xl font-semibold hover:bg-slate-50 transition-all flex items-center">
                    <i class="fas fa-arrow-left mr-2 text-xs"></i> Back to Library
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <form method="POST" action="<?php echo site_url('cms/webinar_create'); ?>" enctype="multipart/form-data">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Webinar Title -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Webinar Title *</label>
                            <input type="text" name="webinar_title" required
                                   class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                                   placeholder="e.g., Advanced Injection Molding Techniques">
                        </div>

                        <!-- Description 1 -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Description</label>
                            <textarea name="description_1" rows="4"
                                      class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                                      placeholder="Main description of this webinar series..."></textarea>
                        </div>

                        <!-- Description 2 -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Additional Description <span class="text-slate-400 font-normal">(optional)</span></label>
                            <textarea name="description_2" rows="3"
                                      class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                                      placeholder="Additional details or notes..."></textarea>
                        </div>

                        <!-- Main Image Upload -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Cover Image</label>
                            <div class="space-y-4">
                                <div class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center hover:border-sky-400 transition-colors cursor-pointer" id="imageUploadArea">
                                    <i class="fas fa-image text-slate-400 text-3xl mb-3"></i>
                                    <p class="text-sm text-slate-600">Click to upload cover image</p>
                                    <p class="text-xs text-slate-400 mt-1">JPG, PNG, GIF, WEBP (Max 2MB)</p>
                                    <input type="file" name="main_image" id="imageFile" class="hidden" accept="image/*">
                                </div>
                                <div id="imagePreview" class="mt-2 hidden">
                                    <div class="flex items-center space-x-3">
                                        <img src="" alt="Preview" class="w-24 h-16 object-cover rounded-lg border">
                                        <button type="button" onclick="removeImage()" class="text-xs text-red-600 hover:text-red-800">
                                            <i class="fas fa-times mr-1"></i> Remove
                                        </button>
                                    </div>
                                </div>

                                <!-- Existing image filename -->
                                <div>
                                    <p class="text-sm text-slate-600 mb-2">Or enter existing image filename:</p>
                                    <input type="text" name="main_image_url" id="imageUrl"
                                           class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                                           placeholder="e.g., webinar-cover.png">
                                    <p class="text-xs text-slate-500 mt-1">If image already exists in assets_system/images/</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Sidebar -->
                    <div class="space-y-6">
                        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-5">
                            <h3 class="text-sm font-bold text-emerald-700 mb-4"><i class="fas fa-info-circle mr-2"></i>About Webinars</h3>
                            <ul class="space-y-3 text-sm text-slate-600">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-emerald-500 mt-0.5 mr-2"></i>
                                    <span>Webinars group related resources together</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-emerald-500 mt-0.5 mr-2"></i>
                                    <span>Users can filter the library by webinar series</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-emerald-500 mt-0.5 mr-2"></i>
                                    <span>Assign videos and PDFs to a webinar when creating resources</span>
                                </li>
                            </ul>
                        </div>

                        <div class="pt-4 border-t border-slate-200">
                            <button type="submit" class="w-full px-4 py-3 bg-emerald-600 text-white rounded-xl font-semibold hover:bg-emerald-700 transition-all flex items-center justify-center">
                                <i class="fas fa-save mr-2"></i> Create Webinar
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

    function removeImage() {
        imageFileInput.value = '';
        imagePreview.classList.add('hidden');
        imagePreview.querySelector('img').src = '';
    }
</script>
