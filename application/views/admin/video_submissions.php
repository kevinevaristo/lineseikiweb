<?php $this->load->view('admin/header'); ?>

<main class="ml-64 p-8">
    <!-- Sticky Header -->
    <div class="sticky top-0 z-40 bg-slate-50 -mx-8 px-8 py-4 mb-8">
    <div class="max-w-7xl mx-auto">
        <!-- Simple Back Button Row -->
        <div class="flex items-center mb-4">
            <a href="<?= base_url('cms/library') ?>" 
               class="inline-flex items-center text-indigo-600 hover:text-indigo-800 group">
                <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="font-medium">Back to Library Management</span>
            </a>
        </div>
        
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Video Submissions</h1>
                <p class="text-slate-500 mt-1">Manage and monitor video resource submissions</p>
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
            <!-- Total Submissions -->
            <div class="stat-card stat-total">
                <div class="stat-icon">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="stat-number"><?= $stats['total_submissions'] ?></div>
                <div class="stat-label">Total Submissions</div>
            </div>

            <!-- Today's Submissions -->
            <div class="stat-card stat-today">
                <div class="stat-icon">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="stat-number"><?= $stats['today_submissions'] ?></div>
                <div class="stat-label">Today's Submissions</div>
            </div>

            <!-- Video Resources -->
            <div class="stat-card stat-video">
                <div class="stat-icon">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="stat-number"><?= $stats['video_count'] ?></div>
                <div class="stat-label">Video Resources</div>
            </div>

            <!-- Other Resources -->
            <div class="stat-card stat-other">
                <div class="stat-icon">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </div>
                <div class="stat-number"><?= $stats['other_count'] ?></div>
                <div class="stat-label">Other Resources</div>
            </div>
        </div>

        <!-- Video Title Statistics -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 flex items-center">
                    <span class="mr-2">📊</span> Video Title Popularity
                </h3>
            </div>
            <div class="p-6">
                <?php
                $videoStats = $this->Video_model->get_video_title_stats();
                if (!empty($videoStats)): ?>
                    <div class="space-y-4">
                        <?php foreach ($videoStats as $stat): ?>
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="text-sm font-medium text-slate-900 truncate" title="<?= htmlspecialchars($stat->video_title) ?>">
                                    <?= htmlspecialchars($stat->video_title) ?>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="text-sm font-semibold text-indigo-600">
                                    <?= $stat->count ?> submission<?= $stat->count > 1 ? 's' : '' ?>
                                </div>
                                <div class="w-32">
                                    <div class="h-2 bg-slate-200 rounded-full overflow-hidden">
                                        <?php
                                        $maxCount = max(array_column($videoStats, 'count'));
                                        $width = ($stat->count / $maxCount) * 100;
                                        ?>
                                        <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full" 
                                             style="width: <?= $width ?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8 text-slate-500">
                        <svg class="w-12 h-12 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p>No video title data available yet</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Main Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 flex items-center">
                    <span class="mr-2">📋</span> All Video Submissions
                    <span class="ml-2 bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                        <?= count($videos) ?> records
                    </span>
                </h3>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <input type="text" id="searchInput" 
                               placeholder="Search submissions..." 
                               class="pl-10 pr-4 py-2 border border-slate-300 rounded-lg text-sm w-64 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                               onkeyup="filterTable()">
                        <svg class="absolute left-3 top-2.5 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
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
                                ID <span class="sort-indicator">↕</span>
                            </th>
                            <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider cursor-pointer" onclick="sortTable(1)">
                                Full Name <span class="sort-indicator">↕</span>
                            </th>
                            <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider cursor-pointer" onclick="sortTable(2)">
                                Email <span class="sort-indicator">↕</span>
                            </th>
                            <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider cursor-pointer" onclick="sortTable(3)">
                                Position <span class="sort-indicator">↕</span>
                            </th>
                            <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider cursor-pointer" onclick="sortTable(4)">
                                Company <span class="sort-indicator">↕</span>
                            </th>
                            <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider cursor-pointer" onclick="sortTable(5)">
                                Video Title <span class="sort-indicator">↕</span>
                            </th>
                            <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider cursor-pointer" onclick="sortTable(6)">
                                Submitted At <span class="sort-indicator">↕</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200" id="tableBody">
                        <?php if (empty($videos)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-12 text-slate-500">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                    </svg>
                                    <p class="text-lg font-medium">No video submissions found</p>
                                    <p class="text-sm">Video submissions will appear here when users submit</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($videos as $video): ?>
                            <tr class="request-row hover:bg-slate-50 transition-colors">
                                <td class="py-4 px-6 text-sm font-medium text-slate-900">
                                    #<?= $video->id ?>
                                </td>
                                <td class="py-4 px-6 text-sm font-medium text-slate-900">
                                    <?= htmlspecialchars($video->full_name) ?>
                                </td>
                                <td class="py-4 px-6 text-sm text-slate-600">
                                    <a href="mailto:<?= htmlspecialchars($video->email) ?>" 
                                       class="text-indigo-600 hover:text-indigo-800 hover:underline">
                                        <?= htmlspecialchars($video->email) ?>
                                    </a>
                                </td>
                                <td class="py-4 px-6 text-sm text-slate-700">
                                    <?= htmlspecialchars($video->position) ?>
                                </td>
                                <td class="py-4 px-6 text-sm text-slate-700">
                                    <?= htmlspecialchars($video->company) ?>
                                </td>
                                <td class="py-4 px-6 text-sm">
                                    <div class="max-w-xs truncate" title="<?= htmlspecialchars($video->video_title ?: 'No title provided') ?>">
                                        <?= htmlspecialchars($video->video_title ?: 'No title provided') ?>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-sm text-slate-600">
                                    <div class="flex flex-col">
                                        <span><?= date('M d, Y', strtotime($video->submitted_at)) ?></span>
                                        <span class="text-xs text-slate-400"><?= date('h:i A', strtotime($video->submitted_at)) ?></span>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination (if you have many records) -->
            <?php if (!empty($videos)): ?>
            <div class="p-6 border-t border-slate-200 flex items-center justify-between">
                <div class="text-sm text-slate-600">
                    Showing <span class="font-medium"><?= min(1, count($videos)) ?></span> to 
                    <span class="font-medium"><?= count($videos) ?></span> of 
                    <span class="font-medium"><?= $stats['total_submissions'] ?></span> results
                </div>
                <div class="flex gap-2">
                    <button class="px-3 py-2 border border-slate-300 rounded-lg text-sm text-slate-600 hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        Previous
                    </button>
                    <button class="px-3 py-2 border border-slate-300 rounded-lg text-sm text-slate-600 hover:bg-slate-50">
                        1
                    </button>
                    <button class="px-3 py-2 border border-indigo-500 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-medium">
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
    const dateFilter = document.getElementById('dateFilter').value;
    const rows = document.querySelectorAll('#tableBody tr:not([style*="display: none"])');
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const rowText = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');
        const dateCell = cells[6]?.textContent;
        
        let showRow = rowText.includes(searchTerm);
        
        // Apply date filter
        if (dateFilter && showRow) {
            const rowDate = new Date(cells[6].querySelector('span:first-child')?.textContent);
            const today = new Date();
            
            switch(dateFilter) {
                case 'today':
                    showRow = rowDate.toDateString() === today.toDateString();
                    break;
                case 'week':
                    const weekAgo = new Date();
                    weekAgo.setDate(today.getDate() - 7);
                    showRow = rowDate >= weekAgo;
                    break;
                case 'month':
                    const monthAgo = new Date();
                    monthAgo.setMonth(today.getMonth() - 1);
                    showRow = rowDate >= monthAgo;
                    break;
            }
        }
        
        row.style.display = showRow ? '' : 'none';
    });
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
        indicator.textContent = '↕';
    });
    const currentIndicator = document.querySelectorAll('th')[columnIndex].querySelector('.sort-indicator');
    currentIndicator.textContent = sortDirection === 1 ? '↑' : '↓';
    
    rows.sort((a, b) => {
        const aText = a.cells[columnIndex].textContent.trim().toLowerCase();
        const bText = b.cells[columnIndex].textContent.trim().toLowerCase();
        
        // Special handling for dates (column 6)
        if (columnIndex === 6) {
            const aDate = new Date(a.cells[6].querySelector('span:first-child')?.textContent);
            const bDate = new Date(b.cells[6].querySelector('span:first-child')?.textContent);
            return (aDate - bDate) * sortDirection;
        }
        
        // Special handling for IDs (column 0)
        if (columnIndex === 0) {
            const aNum = parseInt(aText.replace('#', ''));
            const bNum = parseInt(bText.replace('#', ''));
            return (aNum - bNum) * sortDirection;
        }
        
        return aText.localeCompare(bText) * sortDirection;
    });
    
    // Reorder rows
    rows.forEach(row => table.appendChild(row));
}

function exportToCSV() {
    const rows = document.querySelectorAll('#tableBody tr:not([style*="display: none"])');
    const csv = [];
    
    // Add headers
    csv.push(['ID', 'Full Name', 'Email', 'Position', 'Company', 'Video Title', 'Submitted At'].join(','));
    
    // Add data rows
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const rowData = Array.from(cells).map(cell => {
            // Clean and escape CSV values
            let text = cell.textContent.trim();
            
            // Handle email cell
            if (cell.querySelector('a[href^="mailto:"]')) {
                text = cell.querySelector('a').textContent.trim();
            }
            
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
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `video_submissions_${new Date().toISOString().split('T')[0]}.csv`;
    link.click();
    
    showNotification('CSV export started', 'success');
}

function refreshData() {
    showNotification('Refreshing data...', 'info');
    setTimeout(() => {
        location.reload();
    }, 500);
}

function showNotification(message, type = 'info') {
    // Your existing notification function
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

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Add any initialization code here
});
</script>

<style>
/* Additional styles for this view */
.request-row {
    transition: all 0.2s;
}

.request-row:hover {
    background: #f9fafb;
}

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
.stat-today .stat-icon { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
.stat-video .stat-icon { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
.stat-pdf .stat-icon { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
.stat-other .stat-icon { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }

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

.sort-indicator {
    display: inline-block;
    margin-left: 4px;
    font-size: 12px;
}

.notification-toast {
    animation: slideIn 0.3s ease-out;
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
</style>