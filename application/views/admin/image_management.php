<div class="ml-64 p-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900 mb-2">Image Management</h1>
        <p class="text-slate-600">Manage all images in your system. View, filter, and delete unused images.</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Images</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1"><?= $statistics['total_images']; ?></p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <span class="text-2xl">🖼️</span>
                </div>
            </div>
            <p class="text-xs text-slate-500 mt-2"><?= $statistics['total_size_formatted']; ?> total</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Used Images</p>
                    <p class="text-2xl font-bold text-green-600 mt-1"><?= $statistics['used_images']; ?></p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <span class="text-2xl">✅</span>
                </div>
            </div>
            <p class="text-xs text-slate-500 mt-2"><?= $statistics['usage_percentage']; ?>% usage rate</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Unused Images</p>
                    <p class="text-2xl font-bold text-orange-600 mt-1"><?= $statistics['unused_images']; ?></p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <span class="text-2xl">⚠️</span>
                </div>
            </div>
            <p class="text-xs text-slate-500 mt-2"><?= $statistics['unused_size_formatted']; ?> wasted</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Storage Used</p>
                    <p class="text-2xl font-bold text-indigo-600 mt-1"><?= $statistics['total_size_formatted']; ?></p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <span class="text-2xl">💾</span>
                </div>
            </div>
            <p class="text-xs text-slate-500 mt-2">in assets folder</p>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <!-- Filter Buttons -->
            <div class="flex items-center gap-2">
                <a href="<?= base_url('cms/image_management?filter=all'); ?>" 
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-all <?= $filter == 'all' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'; ?>">
                    All Images (<?= $statistics['total_images']; ?>)
                </a>
                <a href="<?= base_url('cms/image_management?filter=used'); ?>" 
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-all <?= $filter == 'used' ? 'bg-green-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'; ?>">
                    Used (<?= $statistics['used_images']; ?>)
                </a>
                <a href="<?= base_url('cms/image_management?filter=unused'); ?>" 
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-all <?= $filter == 'unused' ? 'bg-orange-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'; ?>">
                    Unused (<?= $statistics['unused_images']; ?>)
                </a>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2">
                <button id="selectAllBtn" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-200 transition-all">
                    Select All
                </button>
                <button id="deleteSelectedBtn" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    Delete Selected
                </button>
            </div>
        </div>
    </div>

    <!-- Images Grid -->
    <?php if (empty($images)): ?>
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
            <div class="text-6xl mb-4">📁</div>
            <h3 class="text-xl font-semibold text-slate-900 mb-2">No Images Found</h3>
            <p class="text-slate-600">No images match the current filter.</p>
        </div>
    <?php else: ?>
        <div id="imagesGrid" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <?php foreach ($images as $image): ?>
                <?php $is_used = in_array($image['filename'], $used_images); ?>
                <div class="image-card bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden group hover:shadow-lg transition-all relative" 
                     data-filename="<?= htmlspecialchars($image['filename']); ?>"
                     data-used="<?= $is_used ? '1' : '0'; ?>">
                    
                    <!-- Selection Checkbox -->
                    <div class="absolute top-2 left-2 z-10">
                        <input type="checkbox" class="image-checkbox w-5 h-5 rounded border-2 border-white shadow-lg cursor-pointer <?= $is_used ? 'opacity-50 cursor-not-allowed' : ''; ?>" 
                               data-filename="<?= htmlspecialchars($image['filename']); ?>"
                               <?= $is_used ? 'disabled' : ''; ?>>
                    </div>

                    <!-- Status Badge -->
                    <?php if ($is_used): ?>
                        <div class="absolute top-2 right-2 bg-green-600 text-white text-xs font-bold px-2 py-1 rounded-lg z-10">
                            USED
                        </div>
                    <?php else: ?>
                        <div class="absolute top-2 right-2 bg-orange-600 text-white text-xs font-bold px-2 py-1 rounded-lg z-10">
                            UNUSED
                        </div>
                    <?php endif; ?>
                    
                    <!-- Image Preview -->
                    <div class="aspect-square bg-slate-100 flex items-center justify-center p-2">
                        <img src="<?= $image['url']; ?>" 
                             alt="<?= htmlspecialchars($image['filename']); ?>" 
                             class="max-w-full max-h-full object-contain"
                             loading="lazy">
                    </div>
                    
                    <!-- Image Info -->
                    <div class="p-3">
                        <p class="text-xs font-medium text-slate-900 truncate" title="<?= htmlspecialchars($image['filename']); ?>">
                            <?= htmlspecialchars($image['filename']); ?>
                        </p>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-xs text-slate-500"><?= $image['size_formatted']; ?></span>
                            <span class="text-xs text-slate-500 uppercase"><?= $image['extension']; ?></span>
                        </div>
                        <p class="text-xs text-slate-400 mt-1"><?= date('M d, Y', $image['modified']); ?></p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition-all flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100">
                        <button class="view-btn bg-white text-slate-700 px-3 py-2 rounded-lg text-xs font-medium hover:bg-slate-100 transition-all"
                                data-url="<?= $image['url']; ?>"
                                data-filename="<?= htmlspecialchars($image['filename']); ?>">
                            👁️ View
                        </button>
                        <button class="usage-btn bg-blue-600 text-white px-3 py-2 rounded-lg text-xs font-medium hover:bg-blue-700 transition-all"
                                data-filename="<?= htmlspecialchars($image['filename']); ?>">
                            📊 Usage
                        </button>
                        <?php if (!$is_used): ?>
                            <button class="delete-btn bg-red-600 text-white px-3 py-2 rounded-lg text-xs font-medium hover:bg-red-700 transition-all"
                                    data-filename="<?= htmlspecialchars($image['filename']); ?>">
                                🗑️ Delete
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Image Preview Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-4xl w-full max-h-[90vh] overflow-auto">
        <div class="sticky top-0 bg-white border-b border-slate-200 p-4 flex items-center justify-between">
            <h3 id="modalTitle" class="text-lg font-semibold text-slate-900"></h3>
            <button id="closeModal" class="text-slate-400 hover:text-slate-600 text-2xl">&times;</button>
        </div>
        <div class="p-6">
            <img id="modalImage" src="" alt="" class="w-full h-auto">
        </div>
    </div>
</div>

<!-- Usage Modal -->
<div id="usageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-2xl w-full max-h-[90vh] overflow-auto">
        <div class="sticky top-0 bg-white border-b border-slate-200 p-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900">Image Usage</h3>
            <button id="closeUsageModal" class="text-slate-400 hover:text-slate-600 text-2xl">&times;</button>
        </div>
        <div class="p-6">
            <p class="text-sm font-medium text-slate-700 mb-4">Image: <span id="usageFilename" class="text-indigo-600"></span></p>
            <div id="usageContent"></div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let selectedImages = [];

    // Select All / Deselect All
    $('#selectAllBtn').click(function() {
        const allChecked = $('.image-checkbox:not(:disabled)').length === $('.image-checkbox:checked:not(:disabled)').length;
        $('.image-checkbox:not(:disabled)').prop('checked', !allChecked);
        updateSelectedImages();
        $(this).text(allChecked ? 'Select All' : 'Deselect All');
    });

    // Update selected images array
    function updateSelectedImages() {
        selectedImages = [];
        $('.image-checkbox:checked').each(function() {
            selectedImages.push($(this).data('filename'));
        });
        $('#deleteSelectedBtn').prop('disabled', selectedImages.length === 0);
    }

    // Checkbox change
    $('.image-checkbox').change(function() {
        updateSelectedImages();
    });

    // View Image
    $(document).on('click', '.view-btn', function() {
        const url = $(this).data('url');
        const filename = $(this).data('filename');
        $('#modalImage').attr('src', url);
        $('#modalTitle').text(filename);
        $('#imageModal').removeClass('hidden');
    });

    $('#closeModal').click(function() {
        $('#imageModal').addClass('hidden');
    });

    // View Usage
    $(document).on('click', '.usage-btn', function() {
        const filename = $(this).data('filename');
        $('#usageFilename').text(filename);
        $('#usageContent').html('<div class="text-center py-4"><div class="animate-spin text-4xl">⏳</div></div>');
        $('#usageModal').removeClass('hidden');

        $.ajax({
            url: '<?= base_url('cms/get_image_usage'); ?>',
            method: 'POST',
            data: { filename: filename },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    if (response.usage.length === 0) {
                        $('#usageContent').html('<div class="text-center py-8"><div class="text-4xl mb-2">✅</div><p class="text-slate-600">This image is not used anywhere.</p></div>');
                    } else {
                        let html = '<div class="space-y-2">';
                        response.usage.forEach(function(item) {
                            html += '<div class="bg-slate-50 rounded-lg p-3 border border-slate-200">';
                            html += '<p class="text-sm font-medium text-slate-900">Table: ' + item.table + '</p>';
                            html += '<p class="text-xs text-slate-600 mt-1">Reference: ' + (item.reference || 'N/A') + '</p>';
                            html += '<p class="text-xs text-slate-500">Field: ' + item.field + '</p>';
                            html += '</div>';
                        });
                        html += '</div>';
                        $('#usageContent').html(html);
                    }
                }
            },
            error: function() {
                $('#usageContent').html('<div class="text-center py-8 text-red-600">Error loading usage data.</div>');
            }
        });
    });

    $('#closeUsageModal').click(function() {
        $('#usageModal').addClass('hidden');
    });

    // Delete Single Image
    $(document).on('click', '.delete-btn', function() {
        const filename = $(this).data('filename');
        
        Swal.fire({
            title: 'Delete Image?',
            text: 'Are you sure you want to delete "' + filename + '"? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('cms/delete_image'); ?>',
                    method: 'POST',
                    data: { filename: filename },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Deleted!', response.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Failed to delete image.', 'error');
                    }
                });
            }
        });
    });

    // Delete Multiple Images
    $('#deleteSelectedBtn').click(function() {
        if (selectedImages.length === 0) return;

        Swal.fire({
            title: 'Delete Selected Images?',
            text: 'You are about to delete ' + selectedImages.length + ' image(s). This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete them!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('cms/delete_multiple_images'); ?>',
                    method: 'POST',
                    data: { filenames: selectedImages },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Success!', response.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Failed to delete images.', 'error');
                    }
                });
            }
        });
    });

    // Close modals on background click
    $('#imageModal, #usageModal').click(function(e) {
        if (e.target === this) {
            $(this).addClass('hidden');
        }
    });
});
</script>
