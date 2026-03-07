

<style>
.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pending { background: #fef3c7; color: #92400e; }
.status-reviewed { background: #dbeafe; color: #1e40af; }
.status-contacted { background: #d1fae5; color: #065f46; }
.status-completed { background: #e5e7eb; color: #374151; }

.stat-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    border: 1px solid #e5e7eb;
    transition: transform 0.2s, box-shadow 0.2s;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
}

.request-row {
    transition: all 0.2s;
}

.request-row:hover {
    background: #f9fafb;
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.modal.active {
    display: flex;
}

.modal-content {
    background: white;
    border-radius: 1rem;
    max-width: 600px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
}

.file-preview {
    max-width: 100%;
    max-height: 400px;
    object-fit: contain;
}
</style>

<main class="ml-64 p-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900 mb-2">Quote Requests</h1>
        <p class="text-slate-600">Manage SMUC service quote requests from customers</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500 uppercase font-semibold">Total</p>
                    <p class="text-3xl font-bold text-slate-900 mt-1"><?= $statistics['total'] ?></p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-yellow-700 uppercase font-semibold">Pending</p>
                    <p class="text-3xl font-bold text-yellow-900 mt-1"><?= $statistics['pending'] ?></p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-700 uppercase font-semibold">Reviewed</p>
                    <p class="text-3xl font-bold text-blue-900 mt-1"><?= $statistics['reviewed'] ?></p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-700 uppercase font-semibold">Contacted</p>
                    <p class="text-3xl font-bold text-green-900 mt-1"><?= $statistics['contacted'] ?></p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500 uppercase font-semibold">Completed</p>
                    <p class="text-3xl font-bold text-slate-900 mt-1"><?= $statistics['completed'] ?></p>
                </div>
                <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Actions -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Filter by Status -->
            <div class="flex items-center gap-4">
                <div>
                    <label class="text-sm font-medium text-slate-700 mb-2 block">Filter by Status:</label>
                    <select id="statusFilter" class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" onchange="filterByStatus(this.value)">
                        <option value="all" <?= $current_status == 'all' ? 'selected' : '' ?>>All Requests</option>
                        <option value="pending" <?= $current_status == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="reviewed" <?= $current_status == 'reviewed' ? 'selected' : '' ?>>Reviewed</option>
                        <option value="contacted" <?= $current_status == 'contacted' ? 'selected' : '' ?>>Contacted</option>
                        <option value="completed" <?= $current_status == 'completed' ? 'selected' : '' ?>>Completed</option>
                    </select>
                </div>

                <!-- Search -->
                <div>
                    <label class="text-sm font-medium text-slate-700 mb-2 block">Search:</label>
                    <input type="text" id="searchInput" placeholder="Name, email, company..." class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-64" value="<?= htmlspecialchars($search_term) ?>" onkeyup="handleSearch(event)">
                </div>
            </div>

            <!-- Export Button -->
            <div class="flex items-end">
                <a href="<?= base_url('cms/export_quote_requests?status=' . $current_status . '&search=' . urlencode($search_term)) ?>" class="px-4 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export to CSV
                </a>
            </div>
        </div>
    </div>

    <!-- Requests Table -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider">ID</th>
                        <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider">Name</th>
                        <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider">Email</th>
                        <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider">Company</th>
                        <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider">Contact</th>
                        <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider">File</th>
                        <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider">Status</th>
                        <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider">Date</th>
                        <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php if (empty($requests)): ?>
                    <tr>
                        <td colspan="9" class="text-center py-12 text-slate-500">
                            <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-lg font-medium">No quote requests found</p>
                            <p class="text-sm">Try adjusting your filters or search terms</p>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($requests as $request): ?>
                        <tr class="request-row" id="request-<?= $request->id ?>">
                            <td class="py-4 px-6 text-sm font-medium text-slate-900">#<?= $request->id ?></td>
                            <td class="py-4 px-6 text-sm text-slate-900"><?= htmlspecialchars($request->name) ?></td>
                            <td class="py-4 px-6 text-sm text-slate-600">
                                <a href="mailto:<?= htmlspecialchars($request->email) ?>" class="text-indigo-600 hover:text-indigo-800">
                                    <?= htmlspecialchars($request->email) ?>
                                </a>
                            </td>
                            <td class="py-4 px-6 text-sm text-slate-900"><?= htmlspecialchars($request->company_name) ?></td>
                            <td class="py-4 px-6 text-sm text-slate-600">
                                <a href="tel:<?= htmlspecialchars($request->contact_number) ?>" class="hover:text-indigo-600">
                                    <?= htmlspecialchars($request->contact_number) ?>
                                </a>
                            </td>
                            <td class="py-4 px-6 text-sm">
                                <?php if (!empty($request->file_name)): ?>
                                    <a href="<?= base_url('cms/download_quote_file/' . $request->id) ?>" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Download
                                    </a>
                                <?php else: ?>
                                    <span class="text-slate-400">No file</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-6 text-sm">
                                <span class="status-badge status-<?= $request->status ?>">
                                    <?= ucfirst($request->status) ?>
                                </span>
                            </td>
                            <td class="py-4 px-6 text-sm text-slate-600">
                                <?= date('M d, Y', strtotime($request->created_at)) ?>
                                <br>
                                <span class="text-xs text-slate-400"><?= date('h:i A', strtotime($request->created_at)) ?></span>
                            </td>
                            <td class="py-4 px-6 text-sm">
                                <button onclick="viewRequest(<?= $request->id ?>)" class="text-indigo-600 hover:text-indigo-900 font-medium mr-3">
                                    View
                                </button>
                                <button onclick="deleteRequest(<?= $request->id ?>)" class="text-red-600 hover:text-red-900 font-medium">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex items-center justify-between">
            <div class="text-sm text-slate-600">
                Showing page <?= $current_page ?> of <?= $total_pages ?> (<?= $total_requests ?> total requests)
            </div>
            <div class="flex gap-2">
                <?php if ($current_page > 1): ?>
                    <a href="<?= base_url('cms/quote_requests?page=' . ($current_page - 1) . '&status=' . $current_status . '&search=' . urlencode($search_term)) ?>" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50">
                        Previous
                    </a>
                <?php endif; ?>
                
                <?php for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
                    <a href="<?= base_url('cms/quote_requests?page=' . $i . '&status=' . $current_status . '&search=' . urlencode($search_term)) ?>" class="px-4 py-2 <?= $i == $current_page ? 'bg-indigo-600 text-white' : 'bg-white border border-slate-300 text-slate-700 hover:bg-slate-50' ?> rounded-lg text-sm font-medium">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
                
                <?php if ($current_page < $total_pages): ?>
                    <a href="<?= base_url('cms/quote_requests?page=' . ($current_page + 1) . '&status=' . $current_status . '&search=' . urlencode($search_term)) ?>" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50">
                        Next
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>

<!-- View Request Modal -->
<div id="viewModal" class="modal">
    <div class="modal-content">
        <div class="p-6 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-slate-900">Quote Request Details</h2>
                <button onclick="closeModal('viewModal')" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        <div id="modalContent" class="p-6">
            <!-- Content will be loaded dynamically -->
        </div>
    </div>
</div>

<script>
function filterByStatus(status) {
    const searchTerm = document.getElementById('searchInput').value;
    window.location.href = '<?= base_url("cms/quote_requests") ?>?status=' + status + '&search=' + encodeURIComponent(searchTerm);
}

function handleSearch(event) {
    if (event.key === 'Enter') {
        const status = document.getElementById('statusFilter').value;
        const searchTerm = event.target.value;
        window.location.href = '<?= base_url("cms/quote_requests") ?>?status=' + status + '&search=' + encodeURIComponent(searchTerm);
    }
}

function viewRequest(id) {
    // Fetch request details
    fetch('<?= base_url() ?>cms/get_quote_request_details', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + id
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const request = data.request;
            const content = `
                <div class="space-y-6">
                    <!-- Customer Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Customer Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-slate-500">Name</label>
                                <p class="text-slate-900">${request.name}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-500">Email</label>
                                <p class="text-slate-900"><a href="mailto:${request.email}" class="text-indigo-600 hover:text-indigo-800">${request.email}</a></p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-500">Company</label>
                                <p class="text-slate-900">${request.company_name}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-500">Contact Number</label>
                                <p class="text-slate-900"><a href="tel:${request.contact_number}" class="hover:text-indigo-600">${request.contact_number}</a></p>
                            </div>
                        </div>
                    </div>

                    <!-- File Attachment -->
                    ${request.file_name ? `
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Attached File</h3>
                        <a href="<?= base_url('cms/download_quote_file/') ?>${request.id}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Download ${request.file_name}
                        </a>
                    </div>
                    ` : '<p class="text-slate-500">No file attached</p>'}

                    <!-- Status Management -->
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Status Management</h3>
                        <select id="requestStatus" class="w-full px-4 py-2 border border-slate-300 rounded-lg" onchange="updateStatus(${request.id}, this.value)">
                            <option value="pending" ${request.status == 'pending' ? 'selected' : ''}>Pending</option>
                            <option value="reviewed" ${request.status == 'reviewed' ? 'selected' : ''}>Reviewed</option>
                            <option value="contacted" ${request.status == 'contacted' ? 'selected' : ''}>Contacted</option>
                            <option value="completed" ${request.status == 'completed' ? 'selected' : ''}>Completed</option>
                        </select>
                    </div>

                    <!-- Notes -->
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Internal Notes</h3>
                        <textarea id="requestNotes" rows="4" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Add internal notes about this request...">${request.notes || ''}</textarea>
                        <button onclick="saveNotes(${request.id})" class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            Save Notes
                        </button>
                    </div>

                    <!-- Request Date -->
                    <div>
                        <label class="text-sm font-medium text-slate-500">Submitted On</label>
                        <p class="text-slate-900">${new Date(request.created_at).toLocaleString()}</p>
                    </div>
                </div>
            `;
            
            document.getElementById('modalContent').innerHTML = content;
            document.getElementById('viewModal').classList.add('active');
        } else {
            alert('Failed to load request details');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while loading request details');
    });
}

function updateStatus(id, status) {
    fetch('<?= base_url() ?>cms/update_quote_status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + id + '&status=' + status
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Status updated successfully', 'success');
            // Update the status badge in the table
            const row = document.getElementById('request-' + id);
            if (row) {
                const badge = row.querySelector('.status-badge');
                if (badge) {
                    badge.className = 'status-badge status-' + status;
                    badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                }
            }
        } else {
            showNotification('Failed to update status', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('active');
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-lg border transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-50 border-green-200 text-green-800' :
        'bg-red-50 border-red-200 text-red-800'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <span class="mr-3">${type === 'success' ? '✓' : '✗'}</span>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('active');
    }
});
</script>
<script>
function saveNotes(id) {
    const notes = document.getElementById('requestNotes').value;
    
    fetch('<?= base_url() ?>cms/update_quote_notes', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + id + '&notes=' + encodeURIComponent(notes)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Notes saved successfully', 'success');
        } else {
            showNotification('Failed to save notes', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function deleteRequest(id) {
    if (!confirm('Are you sure you want to delete this quote request? This action cannot be undone.')) {
        return;
    }
    
    fetch('<?= base_url() ?>cms/delete_quote_request', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + id
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Request deleted successfully', 'success');
            // Remove the row from the table
            const row = document.getElementById('request-' + id);
            if (row) {
                row.remove();
            }
            // Reload page if table is now empty
            setTimeout(() => {
                const tbody = document.querySelector('tbody');
                if (tbody && tbody.querySelectorAll('tr').length === 0) {
                    location.reload();
                }
            }, 1000);
        } else {
            showNotification('Failed to delete request', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('active');
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-lg border transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-50 border-green-200 text-green-800' :
        'bg-red-50 border-red-200 text-red-800'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <span class="mr-3">${type === 'success' ? '✓' : '✗'}</span>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('active');
    }
});
</script>

