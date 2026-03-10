<main class="ml-64 p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <a href="<?php echo base_url('cms/products'); ?>" class="text-slate-500 hover:text-indigo-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h1 class="text-3xl font-bold text-slate-900">
                        <?php echo htmlspecialchars($category->category_name); ?> - Products
                    </h1>
                </div>
                <p class="text-slate-500 ml-9">Manage products and types for this category</p>
            </div>
            <div class="flex gap-3">
                <button onclick="showAddTypeModal()" class="px-4 py-2 bg-white border border-indigo-200 text-indigo-600 rounded-xl font-semibold hover:bg-indigo-50 transition-all">
                    + Add Type
                </button>
                <button onclick="showAddProductModal()" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition-all">
                    + Add Product
                </button>
            </div>
        </div>

        <!-- Product Types Section -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-8">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Product Types / Groups</h3>
            
            <?php if (!empty($types)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($types as $type): ?>
                <div class="border border-slate-200 rounded-lg p-4 hover:border-indigo-300 hover:bg-indigo-50 transition-all">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h4 class="font-semibold text-slate-800"><?php echo htmlspecialchars($type->type_name); ?></h4>
                            <p class="text-sm text-slate-500 mt-1">
                                <?php echo $type->item_count; ?> product<?php echo $type->item_count != 1 ? 's' : ''; ?>
                            </p>
                        </div>
                        <button onclick="deleteType(<?php echo $type->id; ?>, '<?php echo htmlspecialchars(addslashes($type->type_name)); ?>', <?php echo $type->item_count; ?>)" 
                                class="text-red-500 hover:text-red-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="text-center py-8 border-2 border-dashed border-slate-300 rounded-lg bg-slate-50">
                <p class="text-slate-500">No product types yet. Add one to organize your products.</p>
                <button onclick="showAddTypeModal()" class="mt-3 text-indigo-600 font-medium hover:underline">+ Add First Type</button>
            </div>
            <?php endif; ?>
        </div>

        <!-- Products Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800">Products (<span id="productCount"><?php echo count($items); ?></span>)</h3>
                    <div class="flex gap-3">
                        <input type="text" id="searchInput" placeholder="Search products..." 
                               class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                        <select id="filterType" class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                            <option value="">All Types</option>
                            <?php foreach ($types as $type): ?>
                            <option value="<?php echo $type->id; ?>"><?php echo htmlspecialchars($type->type_name); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select id="filterStatus" class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                            <option value="">All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                            <option value="new">New</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Image</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Product Name</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Series/Model</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Type/Group</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200" id="productsTableBody">
                        <?php if (!empty($items)): ?>
                            <?php foreach ($items as $item): ?>
                            <tr class="hover:bg-slate-50 transition-colors" data-type="<?php echo $item->product_type; ?>" 
                                data-active="<?php echo $item->is_active; ?>"
                                data-featured="<?php echo $item->is_featured; ?>"
                                data-new="<?php echo $item->is_new; ?>">
                                <td class="px-6 py-4">
                                    <?php if (!empty($item->product_image)): ?>
                                    <img src="<?php echo base_url('assets_system/images/' . $item->product_image); ?>" 
                                         alt="<?php echo htmlspecialchars($item->product_name); ?>"
                                         class="w-16 h-16 object-contain border border-slate-200 rounded-lg">
                                    <?php else: ?>
                                    <div class="w-16 h-16 bg-slate-100 border border-slate-200 rounded-lg flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800"><?php echo htmlspecialchars($item->product_name); ?></div>
                                    <?php if (!empty($item->sub_title)): ?>
                                    <div class="text-sm text-slate-500"><?php echo htmlspecialchars($item->sub_title); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-800">
                                        <?php if (!empty($item->series_name)): ?>
                                        <div><strong>Series:</strong> <?php echo htmlspecialchars($item->series_name); ?></div>
                                        <?php endif; ?>
                                        <?php if (!empty($item->model_number)): ?>
                                        <div><strong>Model:</strong> <?php echo htmlspecialchars($item->model_number); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-sm rounded-full">
                                        <?php echo htmlspecialchars($item->type_name); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        <?php if ($item->is_active): ?>
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
                                        <?php else: ?>
                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Inactive</span>
                                        <?php endif; ?>
                                        
                                        
                                        
                                        <?php if ($item->is_new): ?>
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">New</span>
                                        <?php endif; ?>
                                        
                                        
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="<?php echo base_url('cms/edit_product/' . $item->id); ?>" 
                                           class="text-indigo-600 hover:text-indigo-800 transition-colors"
                                           title="Edit Full Details">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                        <button onclick="deleteProduct(<?php echo $item->id; ?>, '<?php echo htmlspecialchars(addslashes($item->product_name)); ?>')" 
                                                class="text-red-600 hover:text-red-800 transition-colors"
                                                title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                    No products yet. Add your first product to get started.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Add/Edit Product Modal -->
<div id="productModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-xl font-bold text-slate-800" id="productModalTitle">Add Product</h3>
        </div>
        
        <form id="productForm" enctype="multipart/form-data" class="p-6 space-y-4">
            <input type="hidden" id="productId" name="product_id">
            <input type="hidden" name="product_category" value="<?php echo $category_id; ?>">
            
            <!-- Product Type -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Product Type/Group *</label>
                <select id="productType" name="product_type" required
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                    <option value="">Select Type</option>
                    <?php foreach ($types as $type): ?>
                    <option value="<?php echo $type->id; ?>"><?php echo htmlspecialchars($type->type_name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Product Name -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Product Name *</label>
                <input type="text" id="productName" name="product_name" required
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                       placeholder="Enter product display name">
            </div>
            
            <!-- Series Name -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Series Name</label>
                <input type="text" id="seriesName" name="series_name"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                       placeholder="E.g., SS2-P-1 series">
            </div>
            
            <!-- Sub Title -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Sub Title / Tagline</label>
                <input type="text" id="subTitle" name="sub_title"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                       placeholder="Short descriptive tagline">
            </div>
            
            <!-- Model Number -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Model Number</label>
                <input type="text" id="modelNumber" name="model_number"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                       placeholder="E.g., SS2-P-1XX">
            </div>
            
            <!-- Short Description -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Short Description</label>
                <textarea id="shortDescription" name="short_description" rows="2"
                          class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                          placeholder="Brief product summary (max 500 chars)"></textarea>
            </div>
            
            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Full Description</label>
                <textarea id="productDescription" name="description" rows="3"
                          class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                          placeholder="Detailed product description"></textarea>
            </div>
            
            <!-- Status Flags -->
            <div class="grid grid-cols-2 gap-4">
                <div class="flex items-center">
                    <input type="checkbox" id="isActive" name="is_active" value="1" class="mr-2 h-4 w-4" checked>
                    <label for="isActive" class="text-sm text-slate-700">Active Product</label>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" id="isNew" name="is_new" value="1" class="mr-2 h-4 w-4">
                    <label for="isNew" class="text-sm text-slate-700">New Product</label>
                </div>
                
            </div>
            
            <!-- Image Upload -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Product Image</label>
                <div class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:border-indigo-400 transition-colors cursor-pointer"
                     onclick="document.getElementById('productImage').click()">
                    <div class="mb-4" id="imagePreviewContainer">
                        <img id="productImagePreview" src="" alt="Preview" 
                             class="mx-auto max-h-40 object-contain hidden">
                    </div>
                    <div id="uploadPlaceholder">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-slate-600 font-medium mb-1">Click to upload image</p>
                        <p class="text-slate-500 text-sm">JPG, PNG, GIF, SVG or WebP (Max. 2MB)</p>
                    </div>
                    <input type="file" id="productImage" name="product_image" class="hidden" accept="image/*">
                </div>
            </div>
            
            <div class="pt-4 flex justify-end gap-3">
                <button type="button" onclick="closeProductModal()" 
                        class="px-4 py-2 text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                    Cancel
                </button>
                <button type="submit" id="productSubmitBtn"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <span id="productSubmitText">Add Product</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Add Type Modal -->
<div id="typeModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-md">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-xl font-bold text-slate-800">Add Product Type</h3>
        </div>
        
        <form id="typeForm" class="p-6 space-y-4">
            <input type="hidden" name="product_category" value="<?php echo $category_id; ?>">
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Type Name *</label>
                <input type="text" id="typeName" name="type_name" required
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                       placeholder="E.g., Non-contact Safety Switch">
            </div>
            
            <div class="pt-4 flex justify-end gap-3">
                <button type="button" onclick="closeTypeModal()" 
                        class="px-4 py-2 text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                    Cancel
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    Add Type
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Include SweetAlert -->
<link rel="stylesheet" href="<?php echo base_url('assets_system/vendor/sweetalert2/sweetalert2.min.css'); ?>">
<script src="<?php echo base_url('assets_system/vendor/sweetalert2/sweetalert2.all.min.js'); ?>"></script>

<script>
// Modal Functions
function showAddProductModal() {
    window.location.href = "<?php echo base_url('cms/add_product_view/'); ?>" + "/" +"<?php echo $category_id; ?>";
}

function closeProductModal() {
    document.getElementById('productModal').classList.add('hidden');
    document.getElementById('productModal').classList.remove('flex');
}

function showAddTypeModal() {
    document.getElementById('typeForm').reset();
    document.getElementById('typeModal').classList.remove('hidden');
    document.getElementById('typeModal').classList.add('flex');
}

function closeTypeModal() {
    document.getElementById('typeModal').classList.add('hidden');
    document.getElementById('typeModal').classList.remove('flex');
}

// Image Preview
document.getElementById('productImage').addEventListener('change', function(e) {
    const file = this.files[0];
    const preview = document.getElementById('productImagePreview');
    const placeholder = document.getElementById('uploadPlaceholder');
    
    if (file) {
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({
                title: 'File Too Large!',
                text: 'Maximum file size is 2MB',
                icon: 'error'
            });
            this.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
});

// Quick Edit Product
function quickEditProduct(id) {
    Swal.fire({
        title: 'Loading...',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => { Swal.showLoading(); }
    });
    
    fetch(`<?php echo base_url('cms/get_product_item/'); ?>${id}`)
        .then(response => response.json())
        .then(data => {
            Swal.close();
            
            if (data.success) {
                const product = data.data;
                document.getElementById('productModalTitle').textContent = 'Edit Product';
                document.getElementById('productSubmitText').textContent = 'Update Product';
                document.getElementById('productId').value = product.id;
                document.getElementById('productType').value = product.product_type;
                document.getElementById('productName').value = product.product_name;
                document.getElementById('seriesName').value = product.series_name || '';
                document.getElementById('subTitle').value = product.sub_title || '';
                document.getElementById('modelNumber').value = product.model_number || '';
                document.getElementById('shortDescription').value = product.short_description || '';
                document.getElementById('productDescription').value = product.description || '';
                document.getElementById('displayOrder').value = product.display_order || 0;
                document.getElementById('isActive').checked = product.is_active == 1;
                document.getElementById('isFeatured').checked = product.is_featured == 1;
                document.getElementById('isNew').checked = product.is_new == 1;
                
                if (product.product_image) {
                    const preview = document.getElementById('productImagePreview');
                    preview.src = `<?php echo base_url('assets_system/images/'); ?>${product.product_image}`;
                    preview.classList.remove('hidden');
                    document.getElementById('uploadPlaceholder').classList.add('hidden');
                } else {
                    document.getElementById('productImagePreview').classList.add('hidden');
                    document.getElementById('uploadPlaceholder').classList.remove('hidden');
                }
                
                document.getElementById('productModal').classList.remove('hidden');
                document.getElementById('productModal').classList.add('flex');
            } else {
                Swal.fire('Error!', data.message, 'error');
            }
        })
        .catch(() => {
            Swal.close();
            Swal.fire('Error!', 'Failed to load product data', 'error');
        });
}

// Product Form Submit
document.getElementById('productForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const productId = document.getElementById('productId').value;
    const isEdit = productId !== '';
    const url = isEdit 
        ? `<?php echo base_url('cms/update_product_item/'); ?>${productId}`
        : `<?php echo base_url('cms/add_product_item'); ?>`;
    
    Swal.fire({
        title: isEdit ? 'Updating...' : 'Adding...',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => { Swal.showLoading(); }
    });
    
    const formData = new FormData(this);
    
    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        Swal.close();
        
        if (data.success) {
            Swal.fire({
                title: 'Success!',
                text: data.message,
                icon: 'success',
                confirmButtonColor: '#4f46e5'
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire('Error!', data.message, 'error');
        }
    })
    .catch(() => {
        Swal.close();
        Swal.fire('Error!', 'Failed to save product', 'error');
    });
});

// Delete Product
function deleteProduct(id, name) {
    Swal.fire({
        title: 'Delete Product?',
        html: `<p>Are you sure you want to delete:</p><p class="font-bold text-red-600">${name}</p><p class="text-sm text-slate-500 mt-2">This will also delete all related data (images, files, etc.)</p>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Deleting...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => { Swal.showLoading(); }
            });
            
            fetch(`<?php echo base_url('cms/delete_product_item/'); ?>/${id}`, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Deleted!', data.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            })
            .catch(() => {
                Swal.fire('Error!', 'Failed to delete product', 'error');
            });
        }
    });
}

// Toggle Product Status
function toggleProductStatus(id, newStatus, name) {
    const action = newStatus == 1 ? 'activate' : 'deactivate';
    Swal.fire({
        title: `${action.charAt(0).toUpperCase() + action.slice(1)} Product?`,
        html: `<p>Are you sure you want to ${action}:</p><p class="font-bold">${name}</p>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: newStatus == 1 ? '#10b981' : '#f59e0b',
        cancelButtonColor: '#6b7280',
        confirmButtonText: `Yes, ${action}`,
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: `${action.charAt(0).toUpperCase() + action.slice(1)}ing...`,
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => { Swal.showLoading(); }
            });
            
            fetch(`<?php echo base_url('cms/toggle_product_status/'); ?>${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ is_active: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success!', data.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            })
            .catch(() => {
                Swal.fire('Error!', 'Failed to update status', 'error');
            });
        }
    });
}

// Type Form Submit
document.getElementById('typeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: 'Adding Type...',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => { Swal.showLoading(); }
    });
    
    const formData = new FormData(this);
    
    fetch(`<?php echo base_url('cms/add_product_type'); ?>`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        Swal.close();
        
        if (data.success) {
            Swal.fire({
                title: 'Success!',
                text: data.message,
                icon: 'success'
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire('Error!', data.message, 'error');
        }
    })
    .catch(() => {
        Swal.close();
        Swal.fire('Error!', 'Failed to add type', 'error');
    });
});

// Delete Type
function deleteType(id, name, itemCount) {
    if (itemCount > 0) {
        Swal.fire({
            title: 'Cannot Delete!',
            html: `<p>This type has <strong>${itemCount}</strong> product(s).</p><p>Please delete or reassign the products first.</p>`,
            icon: 'warning'
        });
        return;
    }
    
    Swal.fire({
        title: 'Delete Type?',
        html: `<p>Are you sure you want to delete:</p><p class="font-bold text-red-600">${name}</p>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`<?php echo base_url('cms/delete_product_type/'); ?>/${id}`, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Deleted!', data.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            })
            .catch(() => {
                Swal.fire('Error!', 'Failed to delete type', 'error');
            });
        }
    });
}

// Filter and Search
document.getElementById('filterType').addEventListener('change', function() {
    filterProducts();
});

document.getElementById('filterStatus').addEventListener('change', function() {
    filterProducts();
});

document.getElementById('searchInput').addEventListener('input', function() {
    filterProducts();
});

function filterProducts() {
    const typeFilter = document.getElementById('filterType').value;
    const statusFilter = document.getElementById('filterStatus').value;
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#productsTableBody tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const type = row.getAttribute('data-type');
        const isActive = row.getAttribute('data-active');
        const isFeatured = row.getAttribute('data-featured');
        const isNew = row.getAttribute('data-new');
        const name = row.textContent.toLowerCase();
        
        // Type filter
        const typeMatch = !typeFilter || type === typeFilter;
        
        // Status filter
        let statusMatch = true;
        if (statusFilter) {
            if (statusFilter === '1') {
                statusMatch = isActive === '1';
            } else if (statusFilter === '0') {
                statusMatch = isActive === '0';
            } else if (statusFilter === 'featured') {
                statusMatch = isFeatured === '1';
            } else if (statusFilter === 'new') {
                statusMatch = isNew === '1';
            }
        }
        
        // Search filter
        const searchMatch = !searchTerm || name.includes(searchTerm);
        
        if (typeMatch && statusMatch && searchMatch) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    document.getElementById('productCount').textContent = visibleCount;
}

// Close modals when clicking outside
document.getElementById('productModal').addEventListener('click', function(e) {
    if (e.target === this) closeProductModal();
});

document.getElementById('typeModal').addEventListener('click', function(e) {
    if (e.target === this) closeTypeModal();
});
</script>