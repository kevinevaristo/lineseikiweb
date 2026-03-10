<?php $this->load->view('admin/header'); ?>

<style>
/* Custom styles for testimonial admin */
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

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.status-active {
    background-color: #dcfce7;
    color: #166534;
}

.status-inactive {
    background-color: #fee2e2;
    color: #991b1b;
}

.testimonial-card {
    transition: all 0.3s ease;
}

.testimonial-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
}

/* Sortable styles */
.sortable-ghost {
    opacity: 0.4;
    background-color: #e0e7ff;
    border: 2px dashed #4f46e5;
}

.sortable-drag {
    opacity: 0.8;
    transform: rotate(2deg);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
}

.drag-handle {
    cursor: move;
    color: #9ca3af;
    transition: color 0.2s;
}

.drag-handle:hover {
    color: #4f46e5;
}

.image-preview {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e5e7eb;
    transition: all 0.3s;
}

.image-preview:hover {
    border-color: #4f46e5;
    transform: scale(1.1);
}

/* Modal styles */
.modal-content {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.modal-header {
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: white;
    border-radius: 1rem 1rem 0 0;
}

.modal-header .btn-close {
    filter: brightness(0) invert(1);
}
</style>

<main class="ml-64 p-8">
    <!-- STICKY HEADER SECTION -->
    <div class="sticky top-0 z-40 bg-slate-50 -mx-8 px-8 py-4 sticky-header mb-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Testimonial Manager</h1>
                    <p class="text-slate-500 mt-1">Manage client testimonials and reviews</p>
                </div>
                <div class="flex gap-3">
                    <a href="<?php echo base_url(); ?>" target="_blank" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-50 transition-all flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        View Site
                    </a>
                    <a href="<?php echo site_url('cms/add_testimonial'); ?>" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition-all flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add New Testimonial
                    </a>
                </div>
            </div>
        </div>
        <!-- Scroll Progress Bar -->
        <div class="scroll-progress"></div>
    </div>

    <div class="max-w-7xl mx-auto">
        <!-- Success/Error Messages -->
        <?php if ($this->session->flashdata('success')): ?>
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <?php echo $this->session->flashdata('success'); ?>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <?php echo $this->session->flashdata('error'); ?>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
        <?php endif; ?>

        <!-- Bulk Actions Bar -->
        <div class="mb-6 bg-white rounded-xl border border-slate-200 p-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="flex items-center">
                    <input type="checkbox" id="selectAll" class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                    <label for="selectAll" class="ml-2 text-sm text-slate-600">Select All</label>
                </div>
                <select id="bulkAction" class="px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Bulk Actions</option>
                    <option value="activate">Activate Selected</option>
                    <option value="deactivate">Deactivate Selected</option>
                    <option value="delete">Delete Selected</option>
                </select>
                <button onclick="executeBulkAction()" class="px-4 py-2 bg-slate-800 text-white rounded-lg text-sm hover:bg-slate-900 transition-colors">
                    Apply
                </button>
            </div>
            <div class="text-sm text-slate-500">
                Total: <span class="font-semibold text-slate-700"><?php echo count($testimonials); ?></span> testimonials
            </div>
        </div>

        <!-- Testimonials Grid -->
        <div id="testimonialsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (!empty($testimonials)): ?>
                <?php foreach ($testimonials as $index => $testimonial): ?>
                <div class="testimonial-card bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm" data-id="<?php echo $testimonial->id; ?>">
                    <!-- Card Header with Drag Handle -->
                    <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="drag-handle">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                                </svg>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" class="item-checkbox w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500" value="<?php echo $testimonial->id; ?>">
                            </div>
                            <span class="text-xs font-medium text-slate-400">#<?php echo $testimonial->id; ?></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <?php if ($testimonial->is_active): ?>
                                <span class="status-badge status-active">Active</span>
                            <?php else: ?>
                                <span class="status-badge status-inactive">Inactive</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Card Body -->
                    <div class="p-5">
                        <div class="flex items-start gap-4 mb-4">
                            <!-- Avatar/Image -->
                            <div class="flex-shrink-0">
                                <?php if (!empty($testimonial->image) && file_exists(FCPATH . 'assets_system/images/' . $testimonial->image)): ?>
                                    <img src="<?php echo base_url('assets_system/images/' . $testimonial->image . '?t=' . time()); ?>" 
                                         alt="<?php echo htmlspecialchars($testimonial->name); ?>" 
                                         class="image-preview"
                                         onerror="this.src='<?php echo base_url('assets_system/images/default-avatar.png'); ?>'">
                                <?php else: ?>
                                    <div class="w-[60px] h-[60px] rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-xl">
                                        <?php echo strtoupper(substr($testimonial->name, 0, 1)); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Name and Position -->
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-slate-900 truncate"><?php echo htmlspecialchars($testimonial->name); ?></h3>
                                <p class="text-sm text-slate-500 truncate"><?php echo htmlspecialchars($testimonial->position); ?></p>
                            </div>
                        </div>
                        
                        <!-- Testimonial Content -->
                        <div class="mb-4">
                            <p class="text-sm text-slate-600 line-clamp-3 italic">
                                "<?php echo htmlspecialchars($testimonial->content); ?>"
                            </p>
                        </div>
                        
                        <!-- Meta Info -->
                        <div class="flex items-center justify-between text-xs text-slate-400 border-t border-slate-100 pt-3">
                            <span>Order: <?php echo $testimonial->sort_order; ?></span>
                            <span>Added: <?php echo date('M d, Y', strtotime($testimonial->created_at)); ?></span>
                        </div>
                    </div>
                    
                    <!-- Card Footer -->
                    <div class="px-5 py-3 bg-slate-50/50 border-t border-slate-100 flex justify-end gap-2">
                        <a href="<?php echo site_url('cms/toggle_status_testi/' . $testimonial->id); ?>" 
                           class="p-2 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                           title="<?php echo $testimonial->is_active ? 'Deactivate' : 'Activate'; ?>">
                            <?php if ($testimonial->is_active): ?>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            <?php else: ?>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            <?php endif; ?>
                        </a>
                        <a href="<?php echo site_url('cms/edit_testimonial/' . $testimonial->id); ?>" 
                           class="p-2 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                           title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <button onclick="confirmDelete(<?php echo $testimonial->id; ?>, '<?php echo htmlspecialchars(addslashes($testimonial->name)); ?>')" 
                                class="p-2 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                title="Delete">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Empty State -->
                <div class="col-span-3 text-center py-16 border-2 border-dashed border-slate-300 rounded-xl bg-slate-50/50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <h3 class="text-xl font-medium text-slate-700 mb-2">No Testimonials Yet</h3>
                    <p class="text-slate-500 mb-6">Add your first testimonial to showcase client feedback</p>
                    <a href="<?php echo site_url('cms/add_testimonial'); ?>" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Your First Testimonial
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<!-- Delete Confirmation Forms -->
<?php foreach ($testimonials as $testimonial): ?>
<form id="delete-form-<?php echo $testimonial->id; ?>" action="<?php echo site_url('cms/delete_testimonial/' . $testimonial->id); ?>" method="POST" class="hidden">
    <input type="hidden" name="csrf_token" value="<?php echo $this->security->get_csrf_hash(); ?>">
</form>
<?php endforeach; ?>

<!-- Bulk Action Form -->
<form id="bulk-action-form" action="<?php echo site_url('cms/bulk_action'); ?>" method="POST" class="hidden">
    <input type="hidden" name="ids" id="bulk-ids">
    <input type="hidden" name="action" id="bulk-action">
    <!--<input type="hidden" name="csrf_token" value="<?php echo $this->security->get_csrf_hash(); ?>">-->
</form>

<link rel="stylesheet" href="<?php echo base_url('assets_system/vendor/sweetalert2/sweetalert2.min.css'); ?>">
<script src="<?php echo base_url('assets_system/vendor/sweetalert2/sweetalert2.all.min.js'); ?>"></script>
<script src="<?php echo base_url('assets_system/vendor/sortablejs/Sortable.min.js'); ?>"></script>

<script>
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

// Initialize Sortable for drag & drop reordering
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('testimonialsContainer');
    
    if (container) {
        new Sortable(container, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            dragClass: 'sortable-drag',
            onEnd: function(evt) {
                saveOrder();
            }
        });
    }
});

// Save new order via AJAX
function saveOrder() {
    const items = document.querySelectorAll('[data-id]');
    const orders = {};
    
    items.forEach((item, index) => {
        const id = item.getAttribute('data-id');
        orders[id] = index;
    });
    
    fetch('<?php echo site_url("cms/reorder"); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'orders=' + JSON.stringify(orders) + '&csrf_token=<?php echo $this->security->get_csrf_hash(); ?>'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Order updated successfully!', 'success');
        }
    });
}

// Delete confirmation
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Delete Testimonial?',
        html: `<div class="text-left">
                  <p class="mb-3">Are you sure you want to delete:</p>
                  <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
                      <p class="font-bold text-red-700">${name}</p>
                  </div>
                  <p class="text-sm text-slate-600">This action cannot be undone.</p>
               </div>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Delete It!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Deleting...',
                text: 'Removing testimonial',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                    setTimeout(() => {
                        document.getElementById('delete-form-' + id).submit();
                    }, 500);
                }
            });
        }
    });
}

// Bulk actions
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});

function executeBulkAction() {
    const action = document.getElementById('bulkAction').value;
    const selectedIds = Array.from(document.querySelectorAll('.item-checkbox:checked')).map(cb => cb.value);
    
    if (!action) {
        Swal.fire({
            title: 'No Action Selected',
            text: 'Please select an action to perform',
            icon: 'warning',
            confirmButtonColor: '#4f46e5'
        });
        return;
    }
    
    if (selectedIds.length === 0) {
        Swal.fire({
            title: 'No Items Selected',
            text: 'Please select at least one testimonial',
            icon: 'warning',
            confirmButtonColor: '#4f46e5'
        });
        return;
    }
    
    let actionText = '';
    let confirmColor = '';
    
    switch(action) {
        case 'activate':
            actionText = 'activate';
            confirmColor = '#10b981';
            break;
        case 'deactivate':
            actionText = 'deactivate';
            confirmColor = '#f59e0b';
            break;
        case 'delete':
            actionText = 'delete';
            confirmColor = '#dc2626';
            break;
    }
    
    Swal.fire({
        title: `Confirm Bulk Action`,
        html: `<div class="text-left">
                  <p class="mb-3">Are you sure you want to <strong class="text-${confirmColor}">${actionText}</strong> these testimonials?</p>
                  <div class="bg-slate-100 border border-slate-200 rounded-lg p-3">
                      <p class="font-medium text-slate-700">${selectedIds.length} item(s) selected</p>
                  </div>
               </div>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: confirmColor,
        cancelButtonColor: '#6b7280',
        confirmButtonText: `Yes, ${actionText} them`,
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Create a dynamic form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?php echo site_url("cms/bulk_action"); ?>';
            
            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = 'csrf_token';
            csrfInput.value = '<?php echo $this->security->get_csrf_hash(); ?>';
            form.appendChild(csrfInput);
            
            // Add IDs as individual fields with the same name
            selectedIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';  // Note the [] to make it an array
                input.value = id;
                form.appendChild(input);
            });
            
            // Add action
            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = action;
            form.appendChild(actionInput);
            
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Notification function
function showNotification(message, type = 'info') {
    Swal.fire({
        icon: type,
        title: type === 'success' ? 'Success!' : 'Notice',
        text: message,
        timer: 1500,
        showConfirmButton: false,
        toast: true,
        position: 'top-end'
    });
}

// Auto-hide success messages
setTimeout(() => {
    document.querySelectorAll('.bg-green-50, .bg-red-50').forEach(el => {
        el.style.transition = 'opacity 0.5s';
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 500);
    });
}, 5000);
</script>