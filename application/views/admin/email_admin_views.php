<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Subscribers - Admin</title>
    
    <!-- Tailwind CSS via CDN -->
    <script src="<?php echo base_url('assets_system/vendor/tailwindcss/tailwind.min.js'); ?>"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets_system/vendor/fontawesome-6.5.0/css/all.min.css'); ?>">
    
    <style>
        /* Custom styles */
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
        
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        
        .stat-total .stat-icon { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stat-active .stat-icon { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
        .stat-unsubscribed .stat-icon { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .stat-bounced .stat-icon { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
        .stat-today .stat-icon { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        
        .stat-number {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }
        
        .stat-label {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 500;
        }
        
        /* Status badges */
        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }
        
        .badge-active {
            background: #d1fae5;
            color: #065f46;
        }
        
        .badge-unsubscribed {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .badge-bounced {
            background: #fed7aa;
            color: #92400e;
        }
        
        /* Sort indicator */
        .sort-indicator {
            display: inline-block;
            margin-left: 4px;
            font-size: 12px;
        }
        
        /* Notification toast */
        .notification-toast {
            animation: slideIn 0.3s ease-out;
            max-width: 400px;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* Table styles */
        .table-container {
            background: white;
            border-radius: 1rem;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }
        
        .table-header {
            background: #f9fafb;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .table-row:hover {
            background: #f9fafb;
        }
        
        /* Main content with fixed header */
        .main-content {
            margin-left: 280px; /* Width of sidebar */
            transition: margin-left 0.3s ease;
        }
        
        /* Sidebar styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(135deg, #0F467B 0%, #17A2DC 100%);
            color: white;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-header h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .sidebar-header p {
            font-size: 0.875rem;
            opacity: 0.8;
        }
        
        .sidebar-nav {
            padding: 1.5rem 1rem;
        }
        
        .sidebar-nav .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 0.5rem;
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }
        
        .sidebar-nav .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }
        
        .sidebar-nav .nav-item.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        .sidebar-nav .nav-item i {
            width: 24px;
            margin-right: 12px;
        }
        
        /* Sticky header with proper spacing */
        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 900;
            background: #f8fafc;
            padding: 1rem 2rem;
            margin: -2rem -2rem 2rem -2rem;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .main-content {
                margin-left: 0;
            }
            
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .menu-toggle {
                display: block !important;
            }
        }
        
        @media (max-width: 768px) {
            .stat-number {
                font-size: 1.5rem;
            }
            
            .stat-icon {
                width: 40px;
                height: 40px;
            }
        }
    </style>
</head>
<body class="bg-slate-50">
    
    

    <!-- Mobile Menu Toggle -->
    <button class="menu-toggle fixed top-4 left-4 z-1100 bg-indigo-600 text-white p-2 rounded-lg hidden lg:hidden" onclick="toggleSidebar()">
        <i class="fas fa-bars text-xl"></i>
    </button>

    <!-- Main Content -->
    <div class="main-content p-8" id="mainContent">
        <!-- Sticky Header -->
        <div class="sticky-header">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Email Subscribers</h1>
                    <p class="text-slate-500 mt-1">Manage and monitor newsletter subscribers</p>
                </div>
                
                <div class="flex gap-3">
                    <button onclick="exportToCSV()" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                        <i class="fas fa-download mr-2"></i>Export CSV
                    </button>
                    <button onclick="refreshData()" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                        <i class="fas fa-sync-alt mr-2"></i>Refresh Data
                    </button>
                </div>
            </div>
        </div>

        <!-- Dashboard Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <!-- Total Subscribers -->
            <div class="stat-card stat-total">
                <div class="stat-icon">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <div class="stat-number"><?= $statistics['total'] ?? 0 ?></div>
                <div class="stat-label">Total Subscribers</div>
            </div>

            <!-- Active Subscribers -->
            <div class="stat-card stat-active">
                <div class="stat-icon">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
                <div class="stat-number"><?= $statistics['active'] ?? 0 ?></div>
                <div class="stat-label">Active</div>
            </div>

            <!-- Today's Subscribers -->
            <div class="stat-card stat-today">
                <div class="stat-icon">
                    <i class="fas fa-calendar-day text-white text-xl"></i>
                </div>
                <div class="stat-number"><?= $statistics['today'] ?? 0 ?></div>
                <div class="stat-label">Today's Signups</div>
            </div>
        </div>

        <!-- Status Distribution and Recent Subscribers -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            <!-- Recent Subscribers -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 flex items-center">
                        <i class="fas fa-clock mr-2 text-indigo-500"></i>Recent Subscribers
                    </h3>
                </div>
                <div class="p-0">
                    <div class="divide-y divide-slate-100">
                        <?php if (!empty($recent_subscribers)): ?>
                            <?php foreach ($recent_subscribers as $sub): ?>
                            <div class="block p-4 hover:bg-slate-50 transition-colors">
                                <div class="flex justify-between items-start mb-1">
                                    <span class="font-medium text-slate-900"><?= htmlspecialchars($sub->email) ?></span>
                                    <span class="text-xs text-slate-400"><?= date('M d, Y', strtotime($sub->subscribed_at)) ?></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-slate-600">
                                        IP: <?= $sub->ip_address ?? 'N/A' ?>
                                    </span>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full <?php
                                        $statusColors = [
                                            'active' => 'badge-active',
                                            'unsubscribed' => 'badge-unsubscribed',
                                            'bounced' => 'badge-bounced'
                                        ];
                                        echo $statusColors[$sub->status] ?? 'badge-active';
                                    ?>">
                                        <?= ucfirst($sub->status) ?>
                                    </span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="p-8 text-center text-slate-500">
                                <i class="fas fa-envelope-open-text text-5xl mb-4 text-slate-300"></i>
                                <p class="text-sm">No recent subscribers</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Table -->
        <div class="table-container">
            <div class="table-header flex flex-wrap gap-4 justify-between items-center">
                <h3 class="font-bold text-slate-800 flex items-center">
                    <i class="fas fa-list mr-2 text-indigo-500"></i>All Subscribers
                    <span class="ml-2 bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                        <?= $statistics['total'] ?? 0 ?> records
                    </span>
                </h3>
                <div class="flex flex-wrap gap-3">
                    <div class="relative">
                        <input type="text" id="searchInput" 
                               placeholder="Search emails..." 
                               class="pl-10 pr-4 py-2 border border-slate-300 rounded-lg text-sm w-64 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                               onkeyup="filterTable()">
                        <i class="fas fa-search absolute left-3 top-3 text-slate-400"></i>
                    </div>

                    <select id="dateFilter" class="px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500" onchange="filterTable()">
                        <option value="">All Time</option>
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider cursor-pointer" onclick="sortTable(0)">
                                ID <span class="sort-indicator">↕️</span>
                            </th>
                            <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider cursor-pointer" onclick="sortTable(1)">
                                Email <span class="sort-indicator">↕️</span>
                            </th>
                            <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider cursor-pointer" onclick="sortTable(2)">
                                IP Address <span class="sort-indicator">↕️</span>
                            </th>
                            <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider cursor-pointer" onclick="sortTable(3)">
                                Status <span class="sort-indicator">↕️</span>
                            </th>
                            <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider cursor-pointer" onclick="sortTable(4)">
                                Subscribed At <span class="sort-indicator">↕️</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200" id="tableBody">
                        <?php if (empty($all_subscribers)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-12 text-slate-500">
                                    <i class="fas fa-envelope-open-text text-5xl mb-4 text-slate-300"></i>
                                    <p class="text-lg font-medium">No subscribers found</p>
                                    <p class="text-sm">Subscribers will appear here when people sign up</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($all_subscribers as $sub): ?>
                            <tr class="table-row">
                                <td class="py-4 px-6 text-sm font-medium text-slate-900">
                                    #<?= $sub->id ?>
                                </td>
                                <td class="py-4 px-6 text-sm">
                                    <a href="mailto:<?= htmlspecialchars($sub->email) ?>" 
                                       class="text-indigo-600 hover:text-indigo-800 hover:underline">
                                        <?= htmlspecialchars($sub->email) ?>
                                    </a>
                                </td>
                                <td class="py-4 px-6 text-sm text-slate-600">
                                    <?= $sub->ip_address ?? 'N/A' ?>
                                </td>
                                <td class="py-4 px-6 text-sm">
                                    <span class="badge <?php
                                        $statusClasses = [
                                            'active' => 'badge-active',
                                            'unsubscribed' => 'badge-unsubscribed',
                                            'bounced' => 'badge-bounced'
                                        ];
                                        echo $statusClasses[$sub->status] ?? 'badge-active';
                                    ?>">
                                        <?= ucfirst($sub->status) ?>
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-sm text-slate-600">
                                    <div class="flex flex-col">
                                        <span><?= date('M d, Y', strtotime($sub->subscribed_at)) ?></span>
                                        <span class="text-xs text-slate-400"><?= date('h:i A', strtotime($sub->subscribed_at)) ?></span>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if (!empty($all_subscribers) && ($statistics['total'] ?? 0) > 25): ?>
            <div class="p-6 border-t border-slate-200 flex items-center justify-between">
                <div class="text-sm text-slate-600">
                    Showing <span class="font-medium">1</span> to 
                    <span class="font-medium"><?= min(25, $statistics['total']) ?></span> of 
                    <span class="font-medium"><?= $statistics['total'] ?></span> results
                </div>
                <div class="flex gap-2">
                    <button class="px-3 py-2 border border-slate-300 rounded-lg text-sm text-slate-600 hover:bg-slate-50 disabled:opacity-50" disabled>
                        Previous
                    </button>
                    <button class="px-3 py-2 border border-indigo-500 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-medium">
                        1
                    </button>
                    <button class="px-3 py-2 border border-slate-300 rounded-lg text-sm text-slate-600 hover:bg-slate-50">
                        2
                    </button>
                    <button class="px-3 py-2 border border-slate-300 rounded-lg text-sm text-slate-600 hover:bg-slate-50">
                        3
                    </button>
                    <button class="px-3 py-2 border border-slate-300 rounded-lg text-sm text-slate-600 hover:bg-slate-50">
                        Next
                    </button>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- View Modal -->
    <div id="viewModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-xl max-w-lg w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-slate-200 flex justify-between items-center">
                <h3 class="text-xl font-bold text-slate-900">Subscriber Details</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6" id="modalContent">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="p-6 border-t border-slate-200 bg-slate-50">
                <button onclick="closeModal()" class="px-4 py-2 bg-slate-200 text-slate-800 rounded-lg hover:bg-slate-300 transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        // Table filtering and sorting functionality
        let currentSortColumn = -1;
        let sortDirection = 1;

        function filterTable() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const dateFilter = document.getElementById('dateFilter').value;
            const rows = document.querySelectorAll('#tableBody tr');
            
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length < 7) return;
                
                const email = cells[1]?.textContent.toLowerCase() || '';
                const status = cells[3]?.textContent.toLowerCase().trim() || '';
                const dateText = cells[4]?.textContent || '';
                
                // Search filter
                const matchesSearch = searchTerm === '' || email.includes(searchTerm);
                
                // Status filter
                const matchesStatus = statusFilter === '' || status.includes(statusFilter);
                
                // Date filter
                let matchesDate = true;
                if (dateFilter) {
                    const rowDate = new Date(cells[4].querySelector('span:first-child')?.textContent || dateText);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    
                    switch(dateFilter) {
                        case 'today':
                            matchesDate = rowDate.toDateString() === today.toDateString();
                            break;
                        case 'week':
                            const weekAgo = new Date();
                            weekAgo.setDate(today.getDate() - 7);
                            matchesDate = rowDate >= weekAgo;
                            break;
                        case 'month':
                            const monthAgo = new Date();
                            monthAgo.setMonth(today.getMonth() - 1);
                            matchesDate = rowDate >= monthAgo;
                            break;
                    }
                }
                
                row.style.display = matchesSearch && matchesStatus && matchesDate ? '' : 'none';
            });
            
            updateVisibleCount();
        }

        function updateVisibleCount() {
            const visibleRows = document.querySelectorAll('#tableBody tr[style="display: "]');
            const countSpan = document.querySelector('.bg-indigo-100 span');
            if (countSpan) {
                countSpan.textContent = visibleRows.length + ' records';
            }
        }

        function sortTable(columnIndex) {
            const table = document.querySelector('tbody');
            const rows = Array.from(table.querySelectorAll('tr:not([style*="display: none"])'));
            
            // Toggle sort direction
            if (currentSortColumn === columnIndex) {
                sortDirection = -sortDirection;
            } else {
                currentSortColumn = columnIndex;
                sortDirection = 1;
            }
            
            // Update sort indicators
            document.querySelectorAll('.sort-indicator').forEach(indicator => {
                indicator.textContent = '↕️';
            });
            const currentIndicator = document.querySelectorAll('th')[columnIndex].querySelector('.sort-indicator');
            currentIndicator.textContent = sortDirection === 1 ? '↑' : '↓';
            
            rows.sort((a, b) => {
                let aText, bText;
                
                switch(columnIndex) {
                    case 0: // ID
                        aText = parseInt(a.cells[columnIndex].textContent.replace('#', ''));
                        bText = parseInt(b.cells[columnIndex].textContent.replace('#', ''));
                        return (aText - bText) * sortDirection;
                        
                    case 4: // Date
                    case 5: // Unsubscribed Date
                        aText = new Date(a.cells[columnIndex].querySelector('span:first-child')?.textContent || a.cells[columnIndex].textContent);
                        bText = new Date(b.cells[columnIndex].querySelector('span:first-child')?.textContent || b.cells[columnIndex].textContent);
                        return (aText - bText) * sortDirection;
                        
                    default: // Text columns
                        aText = a.cells[columnIndex].textContent.trim().toLowerCase();
                        bText = b.cells[columnIndex].textContent.trim().toLowerCase();
                        return aText.localeCompare(bText) * sortDirection;
                }
            });
            
            // Reorder rows
            rows.forEach(row => table.appendChild(row));
        }

        function exportToCSV() {
    const rows = document.querySelectorAll('#tableBody tr:not([style*="display: none"])');
    if (rows.length === 0) {
        showNotification('No data to export', 'warning');
        return;
    }
    
    const csv = [];
    
    // Add headers - removed Unsubscribed Date and Unsubscribed Time
    csv.push(['ID', 'Email', 'IP Address', 'Status', 'Subscribed Date', 'Subscribed Time'].join(','));
    
    // Add data rows
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const id = cells[0].textContent.trim().replace('#', '');
        const email = cells[1].querySelector('a')?.textContent.trim() || cells[1].textContent.trim();
        const ip = cells[2].textContent.trim();
        const status = cells[3].textContent.trim();
        const subDate = cells[4].querySelector('span:first-child')?.textContent.trim() || '';
        const subTime = cells[4].querySelector('span:last-child')?.textContent.trim() || '';
        
        // Removed unsubscribe date and time from rowData
        const rowData = [id, email, ip, status, subDate, subTime].map(text => {
            // Escape quotes and wrap in quotes if contains comma
            if (text.includes(',') || text.includes('"') || text.includes('\n')) {
                text = '"' + text.replace(/"/g, '""') + '"';
            }
            return text;
        });
        csv.push(rowData.join(','));
    });
    
    // Create and download CSV file
    const csvContent = csv.join('\n');
    const blob = new Blob(["\uFEFF" + csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `subscribers_${new Date().toISOString().split('T')[0]}.csv`;
    link.click();
    
    showNotification('CSV export completed', 'success');
}

        function refreshData() {
            showNotification('Refreshing data...', 'info');
            setTimeout(() => {
                location.reload();
            }, 500);
        }

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }

        function viewSubscriber(id) {
            const modal = document.getElementById('viewModal');
            const modalContent = document.getElementById('modalContent');
            
            modalContent.innerHTML = `
                <div class="text-center text-slate-500 py-8">
                    <i class="fas fa-spinner fa-spin text-3xl mb-4"></i>
                    <p>Loading subscriber details...</p>
                </div>
            `;
            
            modal.classList.remove('hidden');
            
            // Simulate AJAX call
            setTimeout(() => {
                modalContent.innerHTML = `
                    <div class="space-y-3">
                        <p><strong class="text-slate-700">Subscriber ID:</strong> <span class="text-slate-900">#${id}</span></p>
                        <p><strong class="text-slate-700">Email:</strong> <span class="text-indigo-600">subscriber${id}@example.com</span></p>
                        <p><strong class="text-slate-700">Status:</strong> <span class="badge badge-active">Active</span></p>
                        <p><strong class="text-slate-700">Subscribed:</strong> <span class="text-slate-900">2024-01-15 10:30 AM</span></p>
                        <p><strong class="text-slate-700">IP Address:</strong> <span class="text-slate-900">192.168.1.${id}</span></p>
                        <p><strong class="text-slate-700">User Agent:</strong> <span class="text-sm text-slate-600">Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36</span></p>
                    </div>
                `;
            }, 500);
        }

        function unsubscribeSubscriber(id, email) {
            if (confirm(`Are you sure you want to unsubscribe ${email}?`)) {
                showNotification(`Unsubscribed ${email}`, 'success');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        }

        function deleteSubscriber(id, email) {
            if (confirm(`Are you sure you want to permanently delete ${email}? This action cannot be undone.`)) {
                showNotification(`Deleted ${email}`, 'success');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        }

        function sendTestEmail(id, email) {
            if (confirm(`Send a test email to ${email}?`)) {
                showNotification(`Test email sent to ${email}`, 'success');
            }
        }

        function closeModal() {
            document.getElementById('viewModal').classList.add('hidden');
        }

        function showNotification(message, type = 'info') {
            const existingNotification = document.querySelector('.notification-toast');
            if (existingNotification) {
                existingNotification.remove();
            }
            
            const notification = document.createElement('div');
            notification.className = `notification-toast px-6 py-4 rounded-xl shadow-lg border ${
                type === 'success' ? 'bg-green-50 border-green-200 text-green-800' :
                type === 'error' ? 'bg-red-50 border-red-200 text-red-800' :
                type === 'warning' ? 'bg-yellow-50 border-yellow-200 text-yellow-800' :
                'bg-blue-50 border-blue-200 text-blue-800'
            }`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'} mr-3"></i>
                    <span>${message}</span>
                    <button class="ml-4 text-slate-400 hover:text-slate-600" onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 3000);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            filterTable();
            
            // Close modal when clicking outside
            const modal = document.getElementById('viewModal');
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
        });
    </script>
</body>
</html>