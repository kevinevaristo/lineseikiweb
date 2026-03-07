<?php $this->load->view('admin/header'); ?>

<main class="ml-64 p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">News & Events</h1>
                    <p class="text-slate-500 mt-1">Manage company updates and events</p>
                </div>
                <div class="flex gap-3">
                    <a href="<?php echo base_url('index/news_event'); ?>" target="_blank" 
                       class="px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50">
                        Preview
                    </a>
                    <a href="<?php echo base_url('cms/create_event'); ?>" 
                       class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        + Add New
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg border border-slate-200">
                <div class="text-sm text-slate-500">Total</div>
                <div class="text-2xl font-bold text-slate-900">
                    <?php echo $this->event_model->get_admin_total_events('all'); ?>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg border border-slate-200">
                <div class="text-sm text-slate-500">Active</div>
                <div class="text-2xl font-bold text-green-600">
                    <?php 
                    $this->db->where('status', 'active');
                    $this->db->where('deleted_at IS NULL', null, false);
                    echo $this->db->count_all_results('tbl_events');
                    ?>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg border border-slate-200">
                <div class="text-sm text-slate-500">Featured</div>
                <div class="text-2xl font-bold text-yellow-600">
                    <?php 
                    $this->db->where('is_featured', 1);
                    $this->db->where('deleted_at IS NULL', null, false);
                    echo $this->db->count_all_results('tbl_events');
                    ?>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg border border-slate-200">
                <div class="text-sm text-slate-500">Upcoming</div>
                <div class="text-2xl font-bold text-blue-600">
                    <?php 
                    $this->db->where('event_date >=', date('Y-m-d'));
                    $this->db->where('deleted_at IS NULL', null, false);
                    echo $this->db->count_all_results('tbl_events');
                    ?>
                </div>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="bg-white rounded-lg border border-slate-200 p-4 mb-6">
            <div class="flex gap-4">
                <input type="text" id="searchInput" placeholder="Search..." 
                       class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <select id="categoryFilter" class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Categories</option>
                    <option value="news">News</option>
                    <option value="events">Events</option>
                    <option value="product">Product</option>
                    <option value="webinars">Webinars</option>
                </select>
            </div>
        </div>

        <!-- Events Table -->
        <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left py-3 px-4 font-semibold text-slate-700">Title</th>
                        <th class="text-left py-3 px-4 font-semibold text-slate-700">Category</th>
                        <th class="text-left py-3 px-4 font-semibold text-slate-700">Date</th>
                        <th class="text-left py-3 px-4 font-semibold text-slate-700">Status</th>
                        <th class="text-left py-3 px-4 font-semibold text-slate-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (!empty($events)): ?>
                        <?php foreach ($events as $event): ?>
                        <tr class="hover:bg-slate-50">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <?php if ($event['image']): ?>
                                    <img src="<?php echo base_url('assets_system/images/' . $event['image']); ?>" 
                                         class="w-12 h-12 rounded object-cover">
                                    <?php else: ?>
                                    <div class="w-12 h-12 bg-slate-200 rounded flex items-center justify-center text-slate-400">
                                        📷
                                    </div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="font-medium text-slate-900">
                                            <?php echo htmlspecialchars($event['title']); ?>
                                        </div>
                                        <?php if ($event['is_featured']): ?>
                                        <span class="text-xs text-yellow-600">⭐ Featured</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded text-xs font-medium
                                    <?php 
                                    echo $event['category'] == 'events' ? 'bg-blue-100 text-blue-700' : 
                                        ($event['category'] == 'news' ? 'bg-green-100 text-green-700' : 
                                        ($event['category'] == 'product' ? 'bg-purple-100 text-purple-700' : 
                                        'bg-yellow-100 text-yellow-700'));
                                    ?>">
                                    <?php echo ucfirst($event['category']); ?>
                                </span>
                            </td>
                            <td class="py-3 px-4 text-sm text-slate-600">
                                <?php 
                                if (!empty($event['event_date']) && $event['event_date'] != '0000-00-00') {
                                    echo date('M j, Y', strtotime($event['event_date']));
                                } else {
                                    echo '—';
                                }
                                ?>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded text-xs font-medium
                                    <?php echo $event['status'] == 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                                    <?php echo ucfirst($event['status']); ?>
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex gap-2">
                                    <a href="<?php echo base_url('cms/edit_event/' . $event['id']); ?>" 
                                       class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                        ✏️
                                    </a>
                                    <form action="<?php echo base_url('cms/delete_event/' . $event['id']); ?>" 
                                          method="POST" class="inline" 
                                          onsubmit="return confirm('Delete this event?');">
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" 
                                               value="<?php echo $this->security->get_csrf_hash(); ?>">
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-500">
                            <div class="text-4xl mb-3">📭</div>
                            <p class="font-medium">No events found</p>
                            <a href="<?php echo base_url('cms/create_event'); ?>" 
                               class="mt-3 inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                Create First Event
                            </a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const search = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(search) ? '' : 'none';
    });
});

// Category filter
document.getElementById('categoryFilter').addEventListener('change', function() {
    const category = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        if (!category) {
            row.style.display = '';
            return;
        }
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(category) ? '' : 'none';
    });
});

// Flash messages
<?php if ($this->session->flashdata('success')): ?>
    alert('<?php echo $this->session->flashdata("success"); ?>');
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    alert('<?php echo $this->session->flashdata("error"); ?>');
<?php endif; ?>
</script>
