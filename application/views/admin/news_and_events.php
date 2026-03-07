<?php $this->load->view('admin/header'); ?>

<main class="ml-64 p-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Events & News Management</h1>
                <p class="text-slate-500 mt-1">Manage your company news, events, exhibitions, and updates.</p>
            </div>
            <div class="flex gap-3">
                <a href="<?php echo base_url('index/news_event'); ?>" target="_blank" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-50 transition-all">Preview Page</a>
                <a href="<?php echo base_url('cms/create_event'); ?>" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition-all flex items-center">
                    <span class="mr-2">+</span> Add New Event
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Events</p>
                        <p class="text-3xl font-bold text-slate-900 mt-2"><?php echo $this->event_model->get_admin_total_events('all'); ?></p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-xl">
                        <span class="text-blue-600 text-xl">📅</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Featured Events</p>
                        <p class="text-3xl font-bold text-slate-900 mt-2">
                            <?php 
                            $this->db->where('is_featured', 1);
                            $this->db->where('deleted_at IS NULL', null, false);
                            echo $this->db->count_all_results('tbl_events');
                            ?>
                        </p>
                    </div>
                    <div class="p-3 bg-yellow-50 rounded-xl">
                        <span class="text-yellow-600 text-xl">⭐</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Active Events</p>
                        <p class="text-3xl font-bold text-slate-900 mt-2">
                            <?php 
                            $this->db->where('status', 'active');
                            $this->db->where('deleted_at IS NULL', null, false);
                            echo $this->db->count_all_results('tbl_events');
                            ?>
                        </p>
                    </div>
                    <div class="p-3 bg-green-50 rounded-xl">
                        <span class="text-green-600 text-xl">✅</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Upcoming Events</p>
                        <p class="text-3xl font-bold text-slate-900 mt-2">
                            <?php 
                            $this->db->where('event_date >=', date('Y-m-d'));
                            $this->db->where('deleted_at IS NULL', null, false);
                            echo $this->db->count_all_results('tbl_events');
                            ?>
                        </p>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-xl">
                        <span class="text-purple-600 text-xl">🚀</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm mb-6">
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="relative flex-1">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400">🔍</span>
                            <input type="text" id="searchInput" placeholder="Search events..." class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <div class="flex gap-2">
                            <button class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg font-medium hover:bg-slate-200 transition-colors">All</button>
                            <button class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-lg font-medium hover:bg-slate-50 transition-colors">News</button>
                            <button class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-lg font-medium hover:bg-slate-50 transition-colors">Events</button>
                            <button class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-lg font-medium hover:bg-slate-50 transition-colors">Product</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Events Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800">All Events & News</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50">
                            <th class="text-left py-4 px-6 font-semibold text-slate-700">Event</th>
                            <th class="text-left py-4 px-6 font-semibold text-slate-700">Category</th>
                            <th class="text-left py-4 px-6 font-semibold text-slate-700">Date</th>
                            <th class="text-left py-4 px-6 font-semibold text-slate-700">Status</th>
                            <th class="text-left py-4 px-6 font-semibold text-slate-700">Featured</th>
                            <th class="text-left py-4 px-6 font-semibold text-slate-700">Actions</th>
                        </tr>
                    </thead>
                   
                    <tbody class="divide-y divide-slate-100">
    <?php foreach ($events as $event): ?>
    <tr class="hover:bg-slate-50/50 transition-colors">
        <td class="py-4 px-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-slate-100 rounded-lg border border-slate-200 overflow-hidden flex-shrink-0">
                    <?php if ($event['image']): ?>
                    <img src="<?php echo base_url('assets_system/images/' . $event['image']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center text-slate-400">📷</div>
                    <?php endif; ?>
                </div>
                <div>
                    <h4 class="font-medium text-slate-800"><?php echo htmlspecialchars($event['title']); ?></h4>
                    <p class="text-sm text-slate-500 mt-1 truncate max-w-xs">
                        <?php 
                        // Use substr instead of character_limiter to avoid function errors
                        $content = strip_tags($event['content']);
                        echo strlen($content) > 60 ? substr($content, 0, 60) . '...' : $content;
                        ?>
                    </p>
                </div>
            </div>
        </td>
        <td class="py-4 px-6">
            <span class="px-3 py-1 rounded-full text-xs font-medium 
                <?php 
                // FIXED: Proper ternary operator
                echo $event['category'] == 'events' ? 'bg-blue-100 text-blue-700' : 
                       ($event['category'] == 'news' ? 'bg-green-100 text-green-700' : 
                       ($event['category'] == 'product' ? 'bg-purple-100 text-purple-700' : 
                       'bg-yellow-100 text-yellow-700'));
                ?>">
                <?php echo ucfirst($event['category']); ?>
            </span>
        </td>
        <td class="py-4 px-6">
            <span class="text-sm text-slate-600">
                <?php 
                if (!empty($event['event_date']) && $event['event_date'] != '0000-00-00') {
                    echo date('M j, Y', strtotime($event['event_date']));
                } else {
                    echo 'No date';
                }
                ?>
            </span>
        </td>
        <td class="py-4 px-6">
            <form action="<?php echo base_url('cms/toggle_status/' . $event['id']); ?>" method="POST" class="inline">
                <!-- FIXED: Correct CSRF for CodeIgniter 3 -->
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <button type="submit" class="relative inline-block w-10 align-middle select-none transition duration-200 ease-in">
                    <input type="checkbox" <?php echo $event['status'] == 'active' ? 'checked' : ''; ?> class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" />
                    <label class="toggle-label block overflow-hidden h-6 rounded-full bg-slate-300 cursor-pointer"></label>
                </button>
            </form>
            <span class="ml-2 text-sm <?php echo $event['status'] == 'active' ? 'text-green-600' : 'text-red-600'; ?>">
                <?php echo ucfirst($event['status']); ?>
            </span>
        </td>
        <td class="py-4 px-6">
            <?php if ($event['is_featured']): ?>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                <span class="mr-1">⭐</span> Featured
            </span>
            <?php else: ?>
            <span class="text-sm text-slate-500">—</span>
            <?php endif; ?>
        </td>
        <td class="py-4 px-6">
            <div class="flex items-center gap-2">
                <a href="<?php echo base_url('cms/edit_event/' . $event['id']); ?>" class="p-2 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit">
                    ✏️
                </a>
                <form action="<?php echo base_url('cms/delete_event/' . $event['id']); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this event?');">
                    <!-- FIXED: Correct CSRF for CodeIgniter 3 -->
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <button type="submit" class="p-2 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                        🗑️
                    </button>
                </form>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    
    <?php if (empty($events)): ?>
    <tr>
        <td colspan="6" class="py-12 px-6 text-center">
            <div class="text-slate-400">
                <span class="text-4xl block mb-3">📭</span>
                <p class="text-lg font-medium text-slate-500">No events found</p>
                <p class="text-slate-400 mt-1">Get started by creating your first event</p>
                <a href="<?php echo base_url('admin/events/create'); ?>" class="mt-4 inline-block px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition-all">
                    Create New Event
                </a>
            </div>
        </td>
    </tr>
    <?php endif; ?>
</tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if (!empty($events)): ?>
            <div class="p-6 border-t border-slate-100">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-slate-600">
                        Showing <span class="font-medium">1</span> to <span class="font-medium"><?php echo count($events); ?></span> of <span class="font-medium"><?php echo $this->event_model->get_admin_total_events('all'); ?></span> results
                    </div>
                    <div class="flex gap-2">
                        <button class="px-3 py-2 bg-white border border-slate-200 text-slate-600 rounded-lg font-medium hover:bg-slate-50 transition-colors">
                            ← Previous
                        </button>
                        <button class="px-3 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                            1
                        </button>
                        <button class="px-3 py-2 bg-white border border-slate-200 text-slate-600 rounded-lg font-medium hover:bg-slate-50 transition-colors">
                            2
                        </button>
                        <button class="px-3 py-2 bg-white border border-slate-200 text-slate-600 rounded-lg font-medium hover:bg-slate-50 transition-colors">
                            Next →
                        </button>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<style>
.toggle-checkbox:checked {
    right: 0;
    border-color: #10b981;
}
.toggle-checkbox:checked + .toggle-label {
    background-color: #10b981;
}
.toggle-checkbox {
    right: 0;
    left: auto;
    transition: all 0.3s;
}
.toggle-label {
    transition: background-color 0.3s;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('tbody tr');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    
    // Toggle switch functionality
    document.querySelectorAll('.toggle-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            this.parentElement.parentElement.submit();
        });
    });
    
    // Success/Error messages
    <?php if ($this->session->flashdata('success')): ?>
        showNotification('<?php echo $this->session->flashdata("success"); ?>', 'success');
    <?php endif; ?>
    
    <?php if ($this->session->flashdata('error')): ?>
        showNotification('<?php echo $this->session->flashdata("error"); ?>', 'error');
    <?php endif; ?>
});

function showNotification(message, type = 'info') {
    // Remove existing notification
    const existingNotification = document.querySelector('.notification-toast');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    // Create new notification
    const notification = document.createElement('div');
    notification.className = `notification-toast fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-lg border transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-50 border-green-200 text-green-800' :
        type === 'error' ? 'bg-red-50 border-red-200 text-red-800' :
        'bg-blue-50 border-blue-200 text-blue-800'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <span class="mr-3">${type === 'success' ? '✓' : type === 'error' ? '✗' : 'ℹ'}</span>
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