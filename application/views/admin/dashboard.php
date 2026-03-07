

<main class="ml-64 p-8">
    <!-- Sticky Header -->
    <div class="sticky top-0 z-40 bg-slate-50 -mx-8 px-8 py-4 mb-8">
        <div class="max-w-7xl mx-auto">
            <!-- Simple Back Button Row -->
            <!--<div class="flex items-center mb-4">-->
            <!--    <a href="<?= base_url('cms/dashboard') ?>" -->
            <!--       class="inline-flex items-center text-indigo-600 hover:text-indigo-800 group">-->
            <!--        <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
            <!--            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>-->
            <!--        </svg>-->
            <!--        <span class="font-medium">Back to Dashboard</span>-->
            <!--    </a>-->
            <!--</div>-->
            
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Messages Dashboard</h1>
                    <p class="text-slate-500 mt-1">Manage and monitor customer messages</p>
                </div>
                
                <div class="flex gap-3">
                    <button onclick="exportToCSV()" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                        Export CSV
                    </button>
                    <button onclick="refreshData()" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                        Refresh Data
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto">
        <!-- Dashboard Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <!-- Total Messages -->
            <div class="stat-card stat-total">
                <div class="stat-icon">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="stat-number"><?= $statistics['total'] ?></div>
                <div class="stat-label">Total Messages</div>
            </div>

            <!-- New Messages -->
            <div class="stat-card stat-new">
                <div class="stat-icon">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="stat-number"><?= $statistics['new'] ?></div>
                <div class="stat-label">New Messages</div>
            </div>

            <!-- Read Messages -->
            <div class="stat-card stat-read">
                <div class="stat-icon">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <div class="stat-number"><?= $statistics['read'] ?></div>
                <div class="stat-label">Read Messages</div>
            </div>

            <!-- Replied Messages -->
            <div class="stat-card stat-replied">
                <div class="stat-icon">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                    </svg>
                </div>
                <div class="stat-number"><?= $statistics['replied'] ?></div>
                <div class="stat-label">Replied</div>
            </div>

            <!-- Today's Messages -->
            <div class="stat-card stat-today">
                <div class="stat-icon">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="stat-number"><?= $statistics['today'] ?></div>
                <div class="stat-label">Today's Messages</div>
            </div>
        </div>

        <!-- Message Status Distribution -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Status Distribution Chart -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 flex items-center">
                        <span class="mr-2">📊</span> Message Status Distribution
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <?php
                        $total = $statistics['total'] ?: 1;
                        $statuses = [
                            'new' => ['label' => 'New', 'color' => 'red', 'count' => $statistics['new']],
                            'read' => ['label' => 'Read', 'color' => 'yellow', 'count' => $statistics['read']],
                            'replied' => ['label' => 'Replied', 'color' => 'green', 'count' => $statistics['replied']],
                            'archived' => ['label' => 'Archived', 'color' => 'slate', 'count' => $statistics['archived']]
                        ];
                        ?>
                        <?php foreach ($statuses as $key => $status): ?>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="w-3 h-3 rounded-full bg-<?= $status['color'] ?>-500 mr-3"></span>
                                <span class="text-sm font-medium text-slate-700"><?= $status['label'] ?></span>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="text-sm font-semibold text-<?= $status['color'] ?>-600">
                                    <?= $status['count'] ?> (<?= round(($status['count']/$total)*100, 1) ?>%)
                                </div>
                                <div class="w-32">
                                    <div class="h-2 bg-slate-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-<?= $status['color'] ?>-500 rounded-full" 
                                             style="width: <?= ($status['count']/$total)*100 ?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Recent Messages -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 flex items-center">
                        <span class="mr-2">⏱️</span> Recent Messages
                    </h3>
                </div>
                <div class="p-0">
                    <div class="divide-y divide-slate-100">
                        <?php if (!empty($recent_messages)): ?>
                            <?php foreach ($recent_messages as $msg): ?>
                            <a href="<?= base_url('cms/view/'.$msg->id) ?>" class="block p-4 hover:bg-slate-50 transition-colors">
                                <div class="flex justify-between items-start mb-1">
                                    <span class="font-medium text-slate-900"><?= htmlspecialchars(substr($msg->subject, 0, 40)) ?><?= strlen($msg->subject) > 40 ? '...' : '' ?></span>
                                    <span class="text-xs text-slate-400"><?= date('M d, Y', strtotime($msg->submitted_at)) ?></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-slate-600">From: <?= htmlspecialchars($msg->name) ?></span>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full <?php
                                        $statusColors = [
                                            'new' => 'bg-red-100 text-red-800',
                                            'read' => 'bg-yellow-100 text-yellow-800',
                                            'replied' => 'bg-green-100 text-green-800',
                                            'archived' => 'bg-slate-100 text-slate-800'
                                        ];
                                        echo $statusColors[$msg->status] ?? 'bg-slate-100 text-slate-800';
                                    ?>">
                                        <?= ucfirst($msg->status) ?>
                                    </span>
                                </div>
                            </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="p-8 text-center text-slate-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="text-sm">No recent messages</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-wrap gap-4 justify-between items-center">
                <h3 class="font-bold text-slate-800 flex items-center">
                    <span class="mr-2">📋</span> All Messages
                    <span class="ml-2 bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                        <?= $statistics['total'] ?> records
                    </span>
                </h3>
                <div class="flex flex-wrap gap-3">
                    <div class="relative">
                        <input type="text" id="searchInput" 
                               placeholder="Search messages..." 
                               class="pl-10 pr-4 py-2 border border-slate-300 rounded-lg text-sm w-64 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                               onkeyup="filterTable()">
                        <svg class="absolute left-3 top-2.5 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    
                    <select id="statusFilter" class="px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500" onchange="filterTable()">
                        <option value="">All Statuses</option>
                        <option value="new">New</option>
                        <option value="read">Read</option>
                        <option value="replied">Replied</option>
                        <option value="archived">Archived</option>
                    </select>

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
                                Name <span class="sort-indicator">↕️</span>
                            </th>
                            <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider cursor-pointer" onclick="sortTable(2)">
                                Email <span class="sort-indicator">↕️</span>
                            </th>
                            <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider cursor-pointer" onclick="sortTable(3)">
                                Subject <span class="sort-indicator">↕️</span>
                            </th>
                            <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider cursor-pointer" onclick="sortTable(4)">
                                Status <span class="sort-indicator">↕️</span>
                            </th>
                            <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider cursor-pointer" onclick="sortTable(5)">
                                Submitted At <span class="sort-indicator">↕️</span>
                            </th>
                            <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200" id="tableBody">
                        <?php if (empty($all_messages)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-12 text-slate-500">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-lg font-medium">No messages found</p>
                                    <p class="text-sm">Messages will appear here when customers contact you</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($all_messages as $msg): ?>
                            <tr class="message-row hover:bg-slate-50 transition-colors">
                                <td class="py-4 px-6 text-sm font-medium text-slate-900">
                                    #<?= $msg->id ?>
                                </td>
                                <td class="py-4 px-6 text-sm font-medium text-slate-900">
                                    <?= htmlspecialchars($msg->name) ?>
                                </td>
                                <td class="py-4 px-6 text-sm text-slate-600">
                                    <a href="mailto:<?= htmlspecialchars($msg->email) ?>" 
                                       class="text-indigo-600 hover:text-indigo-800 hover:underline">
                                        <?= htmlspecialchars($msg->email) ?>
                                    </a>
                                </td>
                                <td class="py-4 px-6 text-sm">
                                    <div class="max-w-xs truncate" title="<?= htmlspecialchars($msg->subject) ?>">
                                        <?= htmlspecialchars($msg->subject) ?>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-sm">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full <?php
                                        $statusColors = [
                                            'new' => 'bg-red-100 text-red-800',
                                            'read' => 'bg-yellow-100 text-yellow-800',
                                            'replied' => 'bg-green-100 text-green-800',
                                            'archived' => 'bg-slate-100 text-slate-800'
                                        ];
                                        echo $statusColors[$msg->status] ?? 'bg-slate-100 text-slate-800';
                                    ?>">
                                        <?= ucfirst($msg->status) ?>
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-sm text-slate-600">
                                    <div class="flex flex-col">
                                        <span><?= date('M d, Y', strtotime($msg->submitted_at)) ?></span>
                                        <span class="text-xs text-slate-400"><?= date('h:i A', strtotime($msg->submitted_at)) ?></span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-sm">
                                    <a href="<?= base_url('cms/view/'.$msg->id) ?>" 
                                       class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition-colors">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        View
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if (!empty($all_messages) && $statistics['total'] > 25): ?>
            <div class="p-6 border-t border-slate-200 flex items-center justify-between">
                <div class="text-sm text-slate-600">
                    Showing <span class="font-medium">1</span> to 
                    <span class="font-medium"><?= min(25, $statistics['total']) ?></span> of 
                    <span class="font-medium"><?= $statistics['total'] ?></span> results
                </div>
                <div class="flex gap-2">
                    <button class="px-3 py-2 border border-slate-300 rounded-lg text-sm text-slate-600 hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed">
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
</main>

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
        if (cells.length < 6) return;
        
        const name = cells[1]?.textContent.toLowerCase() || '';
        const email = cells[2]?.textContent.toLowerCase() || '';
        const subject = cells[3]?.textContent.toLowerCase() || '';
        const status = cells[4]?.textContent.toLowerCase().trim() || '';
        const dateText = cells[5]?.textContent || '';
        
        // Search filter
        const matchesSearch = searchTerm === '' || 
            name.includes(searchTerm) || 
            email.includes(searchTerm) || 
            subject.includes(searchTerm);
        
        // Status filter
        const matchesStatus = statusFilter === '' || status.includes(statusFilter);
        
        // Date filter
        let matchesDate = true;
        if (dateFilter) {
            const rowDate = new Date(cells[5].querySelector('span:first-child')?.textContent || dateText);
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
    
    // Update count
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
        
        // Handle different column types
        switch(columnIndex) {
            case 0: // ID
                aText = parseInt(a.cells[columnIndex].textContent.replace('#', ''));
                bText = parseInt(b.cells[columnIndex].textContent.replace('#', ''));
                return (aText - bText) * sortDirection;
                
            case 5: // Date
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
    
    // Add headers
    csv.push(['ID', 'Name', 'Email', 'Subject', 'Status', 'Submitted Date', 'Submitted Time'].join(','));
    
    // Add data rows
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const id = cells[0].textContent.trim();
        const name = cells[1].textContent.trim();
        const email = cells[2].querySelector('a')?.textContent.trim() || cells[2].textContent.trim();
        const subject = cells[3].textContent.trim();
        const status = cells[4].textContent.trim();
        const date = cells[5].querySelector('span:first-child')?.textContent.trim() || '';
        const time = cells[5].querySelector('span:last-child')?.textContent.trim() || '';
        
        const rowData = [id, name, email, subject, status, date, time].map(text => {
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
    const blob = new Blob(["\uFEFF" + csvContent], { type: 'text/csv;charset=utf-8;' }); // UTF-8 BOM for Excel
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `messages_${new Date().toISOString().split('T')[0]}.csv`;
    link.click();
    
    showNotification('CSV export completed', 'success');
}

function refreshData() {
    showNotification('Refreshing data...', 'info');
    setTimeout(() => {
        location.reload();
    }, 500);
}

function showNotification(message, type = 'info') {
    const existingNotification = document.querySelector('.notification-toast');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    const notification = document.createElement('div');
    notification.className = `notification-toast fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-lg border transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-50 border-green-200 text-green-800' :
        type === 'error' ? 'bg-red-50 border-red-200 text-red-800' :
        type === 'warning' ? 'bg-yellow-50 border-yellow-200 text-yellow-800' :
        'bg-blue-50 border-blue-200 text-blue-800'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <span class="mr-3">${type === 'success' ? '✓' : type === 'error' ? '✗' : type === 'warning' ? '⚠' : 'ℹ'}</span>
            <span>${message}</span>
            <button class="ml-4 text-slate-400 hover:text-slate-600" onclick="this.parentElement.parentElement.remove()">
                ×
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
    filterTable(); // Apply initial filters
});
</script>

<style>
/* Stat Cards */
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
.stat-new .stat-icon { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
.stat-read .stat-icon { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
.stat-replied .stat-icon { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
.stat-today .stat-icon { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }

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

/* Sort indicator */
.sort-indicator {
    display: inline-block;
    margin-left: 4px;
    font-size: 12px;
}

/* Message row hover */
.message-row {
    transition: all 0.2s;
}

.message-row:hover {
    background: #f9fafb;
}

/* Notification toast */
.notification-toast {
    animation: slideIn 0.3s ease-out;
    max-width: 400px;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .stat-number {
        font-size: 1.5rem;
    }
    
    .stat-icon {
        width: 40px;
        height: 40px;
    }
    
    .stat-icon svg {
        width: 20px;
        height: 20px;
    }
}
</style>